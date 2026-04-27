<?php get_header(); ?>

<div class="container">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- IMAGE -->
<div class="image">
    <img src="<?php the_post_thumbnail_url(); ?>" />
</div>

<div class="grid">

    <!-- LEFT CONTENT -->
    <div>

        <h1><?php the_title(); ?></h1>

        <!-- SUCCESS MESSAGE -->
        <?php if (isset($_GET['payment']) && $_GET['payment'] === 'success') : ?>
            <div class="success">
                ✅ Payment successful — your booking is confirmed!
            </div>

            <script>
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('payment');
                    window.history.replaceState({}, document.title, url.pathname);
                }
            </script>
        <?php endif; ?>

        <div class="content">
            <?php the_content(); ?>
        </div>

        <div class="card">
            <p>⛽ Fuel: <b><?php the_field('fuel_type'); ?></b></p>
            <p>⚙️ Transmission: <b><?php the_field('transmission'); ?></b></p>
            <p>🪑 Seats: <b><?php the_field('seats'); ?></b></p>
        </div>

    </div>

    <!-- RIGHT SIDEBAR -->
    <div class="booking-box">

        <h2>
            £<?php the_field('price_per_day'); ?>
            <span>/ day</span>
        </h2>

        <p class="muted">Instant booking available</p>

        <!-- DATES -->
        <label>Start date</label>
        <input type="date" id="start_date">

        <label>End date</label>
        <input type="date" id="end_date">

        <!-- PRICE -->
        <div id="pricePreview" class="price-breakdown">
            Select dates to calculate total
        </div>

        <!-- BUTTON -->
        <button id="bookBtn" type="button" onclick="payNow()" disabled>
            Select dates
        </button>

    </div>

</div>

</div>

<?php endwhile; endif; ?>

</div>

<script>

const ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
const carId = <?php echo get_the_ID(); ?>;
const pricePerDay = <?php echo (float) get_field('price_per_day'); ?>;

// =====================
// PRICE CALCULATION
// =====================
function updatePrice() {

    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;
    const btn = document.getElementById("bookBtn");

    if (!start || !end) {
        document.getElementById("pricePreview").innerText = "Select dates to calculate total";
        btn.disabled = true;
        btn.textContent = "Select dates";
        return;
    }

    if (new Date(end) <= new Date(start)) {
        document.getElementById("pricePreview").innerText = "Invalid date range";
        btn.disabled = true;
        btn.textContent = "Select valid dates";
        return;
    }

    const MS_PER_DAY = 1000 * 60 * 60 * 24;
    const days = Math.ceil((new Date(end) - new Date(start)) / MS_PER_DAY);
    const total = days * pricePerDay;

    document.getElementById("pricePreview").innerHTML =
        `£${pricePerDay} × ${days} days = <strong>£${total}</strong>`;

    btn.disabled = false;
    btn.textContent = "Pay & Book";
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('start_date').addEventListener('change', updatePrice);
    document.getElementById('end_date').addEventListener('change', updatePrice);
});

// =====================
// PAYMENT
// =====================
function payNow() {

    const btn = document.getElementById("bookBtn");
    btn.disabled = true;
    btn.textContent = "Processing...";

    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;

    if (!start || !end) {
        alert("Select start and end dates");
        btn.disabled = false;
        btn.textContent = "Pay & Book";
        return;
    }

    fetch(ajaxUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            action: "create_checkout",
            car_id: carId,
            start_date: start,
            end_date: end
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.url) {
            window.location.href = data.url;
        } else {
            alert(data.error || "Payment failed");
            btn.disabled = false;
            btn.textContent = "Pay & Book";
        }
    })
    .catch(() => {
        alert("Error");
        btn.disabled = false;
        btn.textContent = "Pay & Book";
    });
}

</script>

<?php get_footer(); ?>