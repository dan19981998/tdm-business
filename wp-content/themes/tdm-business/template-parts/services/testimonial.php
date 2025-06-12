<section class="testimonial-container">
  <div class="testimonial-wrapper">
    <h2>What Our <span class="blue-text">Creators</span><br>Say About Us</h2>
    <div class="testimonial-column">
      <div class="testimonial-content-wrapper">
        <div class="testimonial-content">
          <h3><?= the_field("creator_names_for_testimonial") ?></h3>
          <p class="profile"><?= the_field("case_study_text") ?></p>
          <div class="iconAndName">
            <img src="<?= get_template_directory_uri(); ?>/assets/images/taraIcon.webp" alt="tara-favicon">
            <p class="name">Tara, 12 Jan 2025</p>
          </div>
          <div class="animate-border">
            <button class="cta">Apply Now</button>
          </div>
        </div>
        <div class="testimonial-video">
          <div class="video-container">
            <video id="myVideo" loop muted controls poster="<?= get_template_directory_uri(); ?>/assets/images/taraposter.jpg" alt="poster-image">
              <source src="<?= get_template_directory_uri(); ?>/assets/images/tara.mp4" type="video/mp4">
            </video>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>