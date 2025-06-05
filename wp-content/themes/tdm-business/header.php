<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TDM Business</title>
  <meta name="description" content="Grow your account with the world renowned OnlyFans management agency. From niche marketing to chatting, we drive growth and engagement.">
  <?php wp_head(); ?>
  <script src="https://cdn.jsdelivr.net/npm/smooth-scrollbar@8.7.4/dist/smooth-scrollbar.js"></script>
</head>
<body <?php body_class(); ?>>

  <header class="site-header">
    <div class="site-header__inner">
      <div style="display:flex; align-items:center; justify-content:space-between; height:5rem; width: 100%;">
        
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="TDM Business Logo" loading="lazy">
        </a>

        <nav class="primary-nav" aria-label="Primary Navigation">
          <?php
            wp_nav_menu([
              'menu'       => 'Main',
              'container'  => false,
              'menu_id'    => 'menu-main',
              'menu_class' => '',  // container ul gets no extra classes
              'fallback_cb'=> false,
            ]);
          ?>
          <div class="animate-border">
            <a href="<?php echo esc_url(home_url('/apply/')); ?>" class="btn-outline">
              Contact Us
            </a>
          </div>
        </nav>

        <button id="mobile-menu-button" class="mobile-menu-button" aria-label="Toggle menu" aria-controls="mobile-menu" aria-expanded="false">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
            <path
              id="menu-icon-path"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          </button>
      </div>

      <div id="mobile-menu" class="mobile-menu">
        <?php
          wp_nav_menu([
            'menu'       => 'Main',
            'container'  => false,
            'menu_id'    => 'menu-main-mobile',
            'menu_class' => '',
            'fallback_cb'=> false,
          ]);
        ?>
        <div class="animate-border">
          <a href="<?php echo esc_url(home_url('/apply/')); ?>" class="btn-outline" style="text-align:center;">
            Contact Us
          </a>
        </div>
      </div>
    </div>
  </header>

  <?php wp_footer(); ?>
</body>
</html>
