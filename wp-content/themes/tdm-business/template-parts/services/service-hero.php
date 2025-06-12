<section class="service-hero">
<?php get_template_part("partials/hero-background") ?>
    <div class="hero-slider-stack">
        <h1><?php the_field('hero_heading'); ?></h1>
        <p class="hero-content"><?php echo esc_html(get_field('hero_paragraph')); ?></p>
        <div class="supported-creators">
            <?php echo wp_get_attachment_image( get_field('creators_hero_image')['ID'], 'full' ); ?>
            <?php echo (get_field('creators_hero_text')); ?>
        </div>
        <?php if( have_rows('services_items') ): ?>
          <div class="services-slider">
                <?php
                $i = 0;
                while( have_rows('services_items') ): the_row();
                    $i++;
                    $img   = get_sub_field('service_image'); 
                    $label = get_sub_field('service_label');
                    $classes = $i === 2 ? 'service-item center' : 'service-item side';
                ?>
                <div class="<?php echo esc_attr($classes); ?>">
                    <?php 
                    echo wp_get_attachment_image( 
                        $img['ID'], 
                        'large', 
                        false, 
                        [ 'class' => 'service-img' ] 
                    ); 
                    ?>
                    <h3 class="service-label"><?php echo esc_html($label); ?></h3>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            <div class="lottie-scroll"></div>   
    </div>
     
</section>