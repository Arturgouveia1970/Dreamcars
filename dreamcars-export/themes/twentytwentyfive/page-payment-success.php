<?php get_header(); ?>

<div style="max-width:700px;margin:100px auto;text-align:center;">

    <h1>🎉 Payment Successful</h1>
    <p>Your booking is confirmed.</p>

    <p id="redirect-text">Redirecting you back...</p>

</div>

<script>
    setTimeout(() => {
        const carId = new URLSearchParams(window.location.search).get('car_id');
        if (carId) {
            window.location.href = "/?p=" + carId;
        } else {
            window.location.href = "<?php echo home_url('/'); ?>";
        }
    }, 3000);
</script>

<?php get_footer(); ?>