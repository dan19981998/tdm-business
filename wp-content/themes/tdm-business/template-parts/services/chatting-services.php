<section class="chatting-services-container">
  <div class="wrapper">
    <div class="content">
      <h2><?php the_field('chatting_title'); ?></h2>
      <p><?php the_field('chatting_subtitle'); ?></p>

      <?php if ( have_rows('service_features') ) : ?>
        <ul class="service-features-list">
          <?php while ( have_rows('service_features') ) : the_row(); 
            $feature = get_sub_field('feature_text');
            if ( $feature ) : ?>
              <li class="service-feature-item">
                <div class="lottie-tick"></div>
                <span class="feature-text"><?php echo esc_html( $feature ); ?></span>
              </li>
            <?php endif;
          endwhile; ?>
        </ul>
      <?php endif; ?>
        <div class="animate-border">
      <button class="cta">I Need Chatting</button>
        </div>
    </div>

    <?php 
    $image = get_field('chatting_image');
    if ( $image ) : ?>
      <div class="content-image">
        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
      </div>
    <?php endif; ?>
  </div>
</section>
