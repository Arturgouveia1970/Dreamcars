<?php get_header(); ?>

<div class="container">

    <button class="theme-toggle" onclick="toggleDarkMode()" id="themeToggle">
    🌙
    </button>

    <!-- FILTERS -->
    
    <?php
    $args = [
        'post_type' => 'car',
        'posts_per_page' => -1
    ];
    
    $cars = new WP_Query($args);

    if (!empty($_GET['max_price'])) {
        $args['meta_query'][] = [
            'key' => 'price_per_day',
            'value' => $_GET['max_price'],
            'type' => 'NUMERIC',
            'compare' => '<='
        ];
    }

    if (!empty($_GET['fuel'])) {
        $args['meta_query'][] = [
            'key' => 'fuel_type',
            'value' => $_GET['fuel'],
            'compare' => '='
        ];
    }

    if (!empty($_GET['transmission'])) {
        $args['meta_query'][] = [
            'key' => 'transmission',
            'value' => $_GET['transmission'],
            'compare' => '='
        ];
    }

    $cars = new WP_Query($args);
    ?>

    <div class="car-grid">

        <?php if ($cars->have_posts()) : ?>
            <?php while($cars->have_posts()) : $cars->the_post(); ?>

                <a href="<?php the_permalink(); ?>" class="car-card">

                    <img src="<?php the_post_thumbnail_url(); ?>" />

                    <div class="car-info">

    <h3><?php the_title(); ?></h3>

    <div class="car-specs">
        <span>⛽ <?php the_field('fuel_type'); ?></span>
        <span>⚙️ <?php the_field('transmission'); ?></span>
        <span>🪑 <?php the_field('seats'); ?></span>
    </div>

    <p class="price">
        £<?php the_field('price_per_day'); ?> / day
    </p>

</div>

                </a>

            <?php endwhile; ?>
        <?php else: ?>

            <p style="text-align:center;">No cars found.</p>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</div>

<?php get_footer(); ?>