<section class="faq-container">
  <div class="faq-wrapper">
    <div class="faq-content">
      <h2><?php the_field('faq_title'); ?></h2>
      <p><?php the_field('faq_subtitle'); ?></p>
      <div class="cta-wrapper">
        <img src="<?php echo esc_url( get_template_directory_uri() . "/assets/images/smallicons.png" ); ?>" class="smallicons" alt="" />
        <div class="animate-border">
            <button class="cta">Schedule A Call</button>
        </div>
      </div>
    </div>
    <div class="faq-questions">
      <?php if ( have_rows('faqs') ) : ?>
        <div class="faq-accordion">
          <?php while ( have_rows('faqs') ) : the_row();
            $question = get_sub_field('question');
            $answer   = get_sub_field('answer');
          ?>
            <div class="faq-item">
              <button class="faq-question"><?php echo esc_html( $question ); ?></button>
              <div class="faq-answer"><?php echo wp_kses_post( $answer ); ?></div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>