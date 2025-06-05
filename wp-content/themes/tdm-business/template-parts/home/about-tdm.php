<section class="about" style="background: url('<?php echo get_template_directory_uri(); ?>/assets/images/about-tdm.png') no-repeat bottom/cover;">
    <div class="about-wrapper">
    <div class="intro">
        <h2> <?php the_field("about_title") ?> </h2>
        <h3> <?php the_field("about_sub") ?> </h3>
        <p> <?php the_field("about_p") ?> </p>
    </div>
    <div class="definition">
         <?php the_field("definition") ?>
    </div>
    </div>
</section>