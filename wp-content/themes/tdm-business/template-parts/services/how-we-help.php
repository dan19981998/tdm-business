<section class="how-we-help">
  <div class="wrapper">
    <h2><?php the_field('title'); ?></h2>
    <p><?php the_field('subheading'); ?></p>
    <div class="flex-wrapper">

      <?php if( have_rows('how_we_help_blocks') ): ?>
        <div class="blocks-wrapper">
        <div class="blocks">
          <?php while( have_rows('how_we_help_blocks') ): the_row(); 
            $image = get_sub_field('block_image');
            $title = get_sub_field('block_title');
            $text  = get_sub_field('block_text');
          ?>
            <div class="content-block">
              <?php if( $image ): ?>
                <div class="content-for-block">
                    <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                    <h3><?php echo esc_html($title); ?></h3>
                </div>
              <?php endif; ?>
                <p><?php echo wp_kses_post($text); ?></p>
            </div>
          <?php endwhile; ?>
              </div>
              <div class="scroll-track-wrapper"> 
            <div class="scroll-indicator"></div>
          </div>
          <div class="lottie-swipe"></div>   
        </div>
      <?php endif; ?>

      <?php
$hero_image_array = get_field('apply_image');
            if ( ! empty( $hero_image_array ) && isset( $hero_image_array['url'] ) ) :
                $hero_src = $hero_image_array['url']; 
                
                $background_style = 'background-image: url(' . esc_url($hero_src) . ');';
                $background_style .= ' background-size: cover;';
                $background_style .= ' background-position: center;';
                $background_style .= ' background-repeat: no-repeat;';
            ?>
                <div class="content-hero" style="<?php echo $background_style; ?>">
                    <h3><?php echo esc_html( get_field('apply_title') ); ?></h3>
                    <div class="animate-border">
                        <a href="/apply" class="cta">Apply Now</a>
                    </div>
                </div>
            <?php endif; ?>
    </div>
  </div>
</section>
