<section class="hero">

<?php get_template_part("partials/hero-background") ?>

  <div class="hero-slider-stack">
  <h1><?php the_field('hero_heading'); ?></h1>

<h2><?php the_field('hero_subheading'); ?></h2> 

<p class="hero-content"><?php echo esc_html(get_field('hero_paragraph')); ?></p>
    <?php if( have_rows('slide_titles') ): ?>
      <div class="slide-titles-row">
        <?php
        $total = count(get_field('slide_titles'));
        $i = 0;
        while( have_rows('slide_titles') ): the_row();
          $i++;
          $title = get_sub_field('text_id');
        ?>
          <span class="slide-title<?php if ($i === 1) echo ' active'; ?>">
            <?php echo esc_html($title); ?>
          </span>
          <?php if ($i < $total): ?>
            <hr class="slide-title-sep" />
          <?php endif; ?>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

    <?php
    $slides = get_field('hero_slides');
    if ( empty( $slides ) || count( $slides ) < 1 ) {
      return;
    }
    ?>
    <div class="hero-slider">
      <button class="slider-button prev" aria-label="Previous slide">‹</button>
      <div class="slider-viewport">
        <div class="slider-track">
          <?php
          $extended = array_merge(
            array_slice( $slides, -3 ), 
            $slides,
            array_slice( $slides, 0, 3 )
          );
          foreach ( $extended as $slide ) :
            $img = $slide['slide_image'];
            $cap = esc_html( $slide['slide_caption'] );
          ?>
            <div class="slide">
              <?php if ( $img ) : ?>
                <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>">
              <?php endif; ?>
              <?php if ( $cap ) : ?>
                <div class="caption"><?php echo $cap; ?></div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <button class="slider-button next" aria-label="Next slide">›</button>
    </div>
  </div>
</section>
