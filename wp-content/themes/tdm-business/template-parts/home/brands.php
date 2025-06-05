<section class="brands">
    <h2>Our Brands</h2>
    <p>Whatever you need, TDM have you covered.</p>
    <?php
    $images = get_field('carousel_images');
    if ($images): ?>
    <div class="acf-carousel">
        <div class="carousel-track">
        <?php foreach ($images as $img): ?>
            <div class="carousel-slide">
            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
            </div>
        <?php endforeach; ?>
        <?php foreach ($images as $img): ?>
            <div class="carousel-slide">
            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
            </div>
        <?php endforeach; ?>
        <?php foreach ($images as $img): ?>
            <div class="carousel-slide">
            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</section>