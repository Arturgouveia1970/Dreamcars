<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Dark Mode Script -->
    <script>
    function toggleDarkMode() {
        document.body.classList.toggle("dark");

        const isDark = document.body.classList.contains("dark");
        localStorage.setItem("dark", isDark);

        const btn = document.getElementById("themeToggle");
        if (btn) btn.textContent = isDark ? "☀️" : "🌙";
    }

    document.addEventListener("DOMContentLoaded", () => {
        const isDark = localStorage.getItem("dark") === "true";

        if (isDark) {
            document.body.classList.add("dark");
        }

        const btn = document.getElementById("themeToggle");
        if (btn) btn.textContent = isDark ? "☀️" : "🌙";
    });
    </script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="site-header">
    <div class="header-inner">

        <a href="<?php echo home_url(); ?>" class="logo">
            
            <!-- LIGHT MODE LOGO -->
            <img class="logo-light"
                 src="<?php echo get_template_directory_uri(); ?>/assets/icons/dreamcars_black_icon_512x512.png"
                 alt="Dreamcars">

            <!-- DARK MODE LOGO -->
            <img class="logo-dark"
                 src="<?php echo get_template_directory_uri(); ?>/assets/icons/dreamcars_white_icon_512x512.png"
                 alt="Dreamcars">

        </a>

    </div>
</header>
   