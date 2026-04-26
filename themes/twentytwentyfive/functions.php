<?php

// =====================
// CAR POST TYPE
// =====================
function create_car_post_type() {
    register_post_type('car', [
        'labels' => [
            'name' => 'Cars',
            'singular_name' => 'Car'
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-car',
        'supports' => ['title', 'editor', 'thumbnail']
    ]);
}
add_action('init', 'create_car_post_type');


// =====================
// BOOKING POST TYPE
// =====================
function register_booking_post_type() {
    register_post_type('booking', [
        'labels' => [
            'name' => 'Bookings',
            'singular_name' => 'Booking'
        ],
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => ['title']
    ]);
}
add_action('init', 'register_booking_post_type');


// =====================
// STRIPE (SAFE VERSION)
// =====================


add_action('wp_ajax_create_checkout', 'create_checkout');
add_action('wp_ajax_nopriv_create_checkout', 'create_checkout');

function create_checkout() {

    header('Content-Type: application/json');

    require_once get_template_directory() . '/vendor/autoload.php';

    if (!defined('STRIPE_SECRET_KEY') || empty(STRIPE_SECRET_KEY)) {
        wp_send_json([
            "success" => false,
            "error" => "Stripe key not configured"
        ]);
    }

    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

    $car_id = intval($_POST['car_id'] ?? 0);
    $start  = sanitize_text_field($_POST['start_date'] ?? '');
    $end    = sanitize_text_field($_POST['end_date'] ?? '');

    if (!$car_id || !$start || !$end) {
        wp_send_json(["success" => false, "error" => "Missing data"]);
    }

    $start_ts = strtotime($start);
    $end_ts   = strtotime($end);

    if (!$start_ts || !$end_ts || $end_ts <= $start_ts) {
        wp_send_json(["success" => false, "error" => "Invalid dates"]);
    }

    // =====================
    // CHECK ONLY PAID BOOKINGS
    // =====================
    $bookings = get_posts([
        'post_type' => 'booking',
        'numberposts' => -1,
        'meta_query' => [
            ['key' => 'car_id', 'value' => $car_id]
        ]
    ]);

    foreach ($bookings as $b) {

        $status = get_post_meta($b->ID, 'status', true);
        if ($status !== 'paid') continue;

        $s = strtotime(get_post_meta($b->ID, 'start_date', true));
        $e = strtotime(get_post_meta($b->ID, 'end_date', true));

        if (!$s || !$e) continue;

        if ($start_ts <= $e && $end_ts >= $s) {
            wp_send_json([
                "success" => false,
                "error" => "Car already booked"
            ]);
        }
    }

    // =====================
    // PRICE
    // =====================
    $price = function_exists('get_field')
        ? (float) get_field('price_per_day', $car_id)
        : 100;

    if ($price <= 0) $price = 100;

    $days = max(1, ($end_ts - $start_ts) / 86400);
    $total = $price * $days;

    // =====================
    // STRIPE SESSION
    // =====================
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'mode' => 'payment',

        'metadata' => [
            'car_id' => $car_id,
            'start'  => $start,
            'end'    => $end
        ],

        'line_items' => [[
            'price_data' => [
                'currency' => 'gbp',
                'product_data' => [
                    'name' => get_the_title($car_id),
                ],
                'unit_amount' => intval($total * 100),
            ],
            'quantity' => 1,
        ]],

        'success_url' => home_url('/payment-success?booking_id={CHECKOUT_SESSION_ID}'),
        'cancel_url'  => home_url('/payment-cancel'),
    ]);

    wp_send_json([
        "success" => true,
        "url" => $session->url
    ]);
}


// =====================
// SUCCESS PAGE
// =====================
add_action('template_redirect', function () {

    if (strpos($_SERVER['REQUEST_URI'], 'payment-success') === false) return;

    echo "<h1>✅ Payment Successful</h1>";
    echo "<p>Your booking is confirmed.</p>";

    exit;
});

add_action('template_redirect', function () {

    if (is_front_page() || is_home()) {
        wp_redirect(home_url('/car/'));
        exit;
    }

});

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'theme-main',
        get_stylesheet_uri()
    );

    wp_enqueue_style(
        'theme-app',
        get_template_directory_uri() . '/styles/app.css',
        [],
        time()
    );

});