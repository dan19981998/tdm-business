<?php
$tabs = get_field('service_tabs');
if ( $tabs ):
?>
<section class="tabs-container">
  <div class="tabs-wrapper">
  <ul class="tab-nav">
    <?php foreach ( $tabs as $index => $tab ): ?>
      <li class="tab-nav-item <?php echo ( $index === 0 ) ? 'active' : ''; ?>" data-tab="tab-<?php echo $index; ?>">
        <img src="<?php echo esc_url( $tab['tab_icon']['url'] ); ?>"  alt="<?php echo esc_attr( $tab['tab_icon']['alt'] ); ?>" class="tab-icon">
        <p><?php echo esc_html( $tab['tab_nav_title'] ); ?></p>
      </li>
    <?php endforeach; ?>
  </ul>

  <div class="tab-content-container">
    <?php foreach ( $tabs as $index => $tab ): ?>
      <div class="tab-content <?php echo ( $index === 0 ) ? 'active' : ''; ?>" id="tab-<?php echo $index; ?>">
          <div class="tab-text" style="flex: 1;">
            <h3><?php echo esc_html( $tab['tab_title'] ); ?></h3>
            <p><?php echo esc_html( $tab['tab_content'] ); ?></p>
            <div class="animate-border">
              <button class="cta">Learn More</button>
            </div>
          </div>
          <div class="tab-image">
            <img src="<?php echo esc_url( $tab['tab_image']['url'] ); ?>" alt="<?php echo esc_attr( $tab['tab_image']['alt'] ); ?>">
          </div>
      </div>
    <?php endforeach; ?>
  </div>
    </div>
</section>
<?php endif; ?>
