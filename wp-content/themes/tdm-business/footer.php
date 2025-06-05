<footer class="site-footer">
  <div class="footer-widgets container">
    <div class="footer-menu-column">
      <?php
      if ( has_nav_menu( 'footer_menu_1' ) ) {
        wp_nav_menu( array(
          'theme_location' => 'footer_menu_1',
          'menu_class'     => 'footer-menu footer-menu-1',
          'container'      => false,
          'depth'          => 1,
          'fallback_cb'    => false,
        ) );
      }
      ?>
    </div>

    <div class="footer-menu-column">
      <?php
      if ( has_nav_menu( 'footer_menu_2' ) ) {
        wp_nav_menu( array(
          'theme_location' => 'footer_menu_2',
          'menu_class'     => 'footer-menu footer-menu-2',
          'container'      => false,
          'depth'          => 1,
          'fallback_cb'    => false,
        ) );
      }
      ?>
    </div>

    <div class="footer-menu-column">
      <?php
      if ( has_nav_menu( 'footer_menu_3' ) ) {
        wp_nav_menu( array(
          'theme_location' => 'footer_menu_3',
          'menu_class'     => 'footer-menu footer-menu-3',
          'container'      => false,
          'depth'          => 1,
          'fallback_cb'    => false,
        ) );
      }
      ?>
    </div>
  </div>

  <div class="site-info container">
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
  </div>
</footer>
