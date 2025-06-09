<footer class="site-footer" style="background: url('<?php echo get_template_directory_uri(); ?>/assets/images/about-tdm.png') no-repeat bottom/cover;">
  <div class="footer-widgets container">
    
    <div class="footer-logo-social-column">
      <div class="footer-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <img 
            src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" 
            alt="<?php bloginfo( 'name' ); ?> Logo"
          />
        </a>
      </div>

      <div class="footer-social-icons">
        <a href="https://facebook.com/YourPage" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="currentColor" aria-hidden="true"><path d="M279.14 288l14.22-92.66H196.83V123.34c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S259.3 0 225.36 0c-73.22 0-121.02 44.38-121.02 124.72v70.62H22.89V288h81.45v224h100.17V288z"/></svg>
        </a>
        <a href="https://twitter.com/YourHandle" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" aria-hidden="true"><path d="M459.4 151.7c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c14.182 7.797 30.355 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.919-2.599-24.04 0-57.502 46.782-104.284 104.284-104.284 30.004 0 57.153 12.67 76.167 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.797 24.366-24.366 44.833-46.132 57.502 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
        </a>
        <a href="https://instagram.com/YourProfile" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true"><path d="M224.1 141c-63.6 0-115 51.4-115 115 0 63.6 51.4 115 115 115s115-51.4 115-115c0-63.6-51.4-115-115-115zm0 190c-41.4 0-75-33.6-75-75s33.6-75 75-75 75 33.6 75 75-33.6 75-75 75zm146.4-194.3c0 14.9-12.1 27-27 27h-27c-14.9 0-27-12.1-27-27v-27c0-14.9 12.1-27 27-27h27c14.9 0 27 12.1 27 27v27zm76.1 27.2c-1.7-35.7-9.9-67.2-36.2-93.4-26.2-26.2-57.7-34.5-93.4-36.2-37-2.1-147.9-2.1-184.9 0-35.7 1.7-67.2 9.9-93.4 36.2-26.2 26.2-34.5 57.7-36.2 93.4-2.1 37-2.1 147.9 0 184.9 1.7 35.7 9.9 67.2 36.2 93.4 26.2 26.2 57.7 34.5 93.4 36.2 37 2.1 147.9 2.1 184.9 0 35.7-1.7 67.2-9.9 93.4-36.2 26.2-26.2 34.5-57.7 36.2-93.4 2.1-37 2.1-147.9 0-184.9zm-48.1 224.5c-7.8 19.6-22.9 34.7-42.5 42.5-29.5 11.7-99.5 9-132.4 9s-102.9 2.6-132.4-9c-19.6-7.8-34.7-22.9-42.5-42.5-11.7-29.5-9-99.5-9-132.4s-2.6-102.9 9-132.4c7.8-19.6 22.9-34.7 42.5-42.5 29.5-11.7 99.5-9 132.4-9s102.9-2.6 132.4 9c19.6 7.8 34.7 22.9 42.5 42.5 11.7 29.5 9 99.5 9 132.4s2.7 102.9-9 132.4z"/></svg>
        </a>
      </div>
    </div>

    <div class="footer-menu-column">
      <h4 class="footer-menu-title">Our Products</h4>
      <?php if ( has_nav_menu( 'footer_menu_1' ) ) : ?>
        <?php
          wp_nav_menu( array(
            'theme_location' => 'footer_menu_1',
            'menu_class'     => 'footer-menu footer-menu-1',
            'container'      => false,
            'depth'          => 1,
            'fallback_cb'    => false,
          ) );
        ?>
      <?php endif; ?>
    </div>

    <div class="footer-menu-column">
      <h4 class="footer-menu-title">Consultation</h4>
      <?php if ( has_nav_menu( 'footer_menu_2' ) ) : ?>
        <?php
          wp_nav_menu( array(
            'theme_location' => 'footer_menu_2',
            'menu_class'     => 'footer-menu footer-menu-2',
            'container'      => false,
            'depth'          => 1,
            'fallback_cb'    => false,
          ) );
        ?>
      <?php endif; ?>
    </div>

    <div class="footer-menu-column">
      <h4 class="footer-menu-title">Our Brands</h4>
      <?php if ( has_nav_menu( 'footer_menu_3' ) ) : ?>
        <?php
          wp_nav_menu( array(
            'theme_location' => 'footer_menu_3',
            'menu_class'     => 'footer-menu footer-menu-3',
            'container'      => false,
            'depth'          => 1,
            'fallback_cb'    => false,
          ) );
        ?>
      <?php endif; ?>
    </div>

    <div class="footer-contact-column">
      <h4 class="footer-contact-title">Get in Touch</h4>
      <p class="footer-email">
        <a href="mailto:info@yourdomain.com">info@tdmbusiness.com</a>
      </p>
    </div>

  </div>

  <div class="site-info container">
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
  </div>

</footer>
