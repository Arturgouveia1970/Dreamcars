<?php get_header(); ?>

<div class="home">

    <!-- HERO -->
    <section class="hero">
        <h1>Dreancars</h1>
        <p>Luxury & everyday cars available instantly. Book in seconds.</p>

        <a href="<?php echo get_post_type_archive_link('car'); ?>" class="cta">
            Browse Cars
        </a>
    </section>

    <!-- FEATURED CARS -->
    <section class="featured">

        <h2>Featured Dream Cars</h2>

        <div class="car-grid">

            <?php
            $featured = new WP_Query([
                'post_type' => 'car',
                'posts_per_page' => 4
            ]);

            while ($featured->have_posts()) : $featured->the_post(); ?>

                <a href="<?php the_permalink(); ?>" class="car-card">

                    <img src="<?php the_post_thumbnail_url(); ?>" />

                    <div class="car-info">
                        <h3><?php the_title(); ?></h3>
                        <p class="price">£<?php the_field('price_per_day'); ?> / day</p>
                    </div>

                </a>

            <?php endwhile; wp_reset_postdata(); ?>

        </div>

    </section>

</div>

<?php get_footer(); ?>