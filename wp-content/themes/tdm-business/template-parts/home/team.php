<?php
$section_title = get_field('section_title');
$subtitle      = get_field('subtitle');
?>

<?php if ( have_rows('team_members') ) : ?>
<section class="team-section">
  <div class="team-section__header">
    <h2 class="team-section__title"><?php echo esc_html( $section_title ); ?></h2>
    <p class="team-section__subtitle"><?php echo esc_html( $subtitle ); ?></p>
  </div>

  <div class="team-section__content">
    <div class="team-accordion">
      <ul class="team-accordion__list">
        <?php
        $index = 0;
        while ( have_rows('team_members') ) : the_row();
          $title           = get_sub_field('accordion_title');
          $content         = get_sub_field('accordion_content');
          $is_active_class = ( $index === 0 ) ? ' team-accordion__item--active' : '';
          $caret_html      = ( $index === 0 ) ? '&#9650;' : '&#9660;';
        ?>
          <li class="team-accordion__item<?php echo $is_active_class; ?>" data-index="<?php echo esc_attr( $index ); ?>">
            <button class="team-accordion__button">
              <img src="<?php echo esc_url( get_template_directory_uri() . "/assets/images/small-fav.png" ); ?>" class="team-accordion__icon" alt="" />
              <span class="team-accordion__label"><?php echo esc_html( $title ); ?></span>
              <span class="team-accordion__caret"><?php echo $caret_html; ?></span>
            </button>
            <div class="team-accordion__panel">
              <?php echo wp_kses_post( $content ); ?>
            </div>
          </li>
        <?php $index++; endwhile; ?>
      </ul>
    </div>

    <?php
    reset_rows();

    $index = 0;
    while ( have_rows('team_members') ) : the_row();
      if ( have_rows('accordion_images') ) :
        $style = ( $index === 0 ) ? '' : 'style="display:none;"';
    ?>
      <div class="team-cards" data-group="<?php echo esc_attr( $index ); ?>" <?php echo $style; ?>>
      <?php
        while ( have_rows('accordion_images') ) : the_row();
        $img = get_sub_field('member_image');
        $quote = get_sub_field('hover_quote'); 
        if ( is_array( $img ) ) : ?>
            <div class="team-card">
            <div class="team-card__image-wrapper">
                <img 
                src="<?php echo esc_url( $img['url'] ); ?>" 
                class="team-card__image" 
                alt="<?php echo esc_attr( $img['alt'] ?? '' ); ?>" 
                />
                <?php if ( $quote ) : ?>
                <div class="team-card__quote">
                    <?php echo wp_kses_post( $quote ); ?>
                </div>
                <?php endif; ?>
            </div>
            </div>
        <?php endif;
        endwhile;
        ?>
      </div>
    <?php endif; $index++; endwhile; ?>
  </div>
</section>
<?php endif; ?>