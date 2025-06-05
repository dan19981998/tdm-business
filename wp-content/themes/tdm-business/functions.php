<?php
function tdm_enqueue_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // --- CSS (variables + all other .min.css) ---
    $css_dir = "{$theme_dir}/assets/css";
    $css_uri = "{$theme_uri}/assets/css";

    $vars_file = "{$css_dir}/variables.min.css";
    if ( file_exists( $vars_file ) ) {
        wp_enqueue_style(
            'tdm-variables',
            "{$css_uri}/variables.min.css",
            [],
            filemtime( $vars_file )
        );
    }

    foreach ( glob( "{$css_dir}/*.min.css" ) as $file ) {
        $name = basename( $file );
        if ( $name === 'variables.min.css' ) {
            continue;
        }
        $base   = str_replace( '.min', '', pathinfo( $name, PATHINFO_FILENAME ) );
        $handle = 'tdm-' . sanitize_title_with_dashes( $base );

        wp_enqueue_style(
            $handle,
            "{$css_uri}/{$name}",
            file_exists( $vars_file ) ? [ 'tdm-variables' ] : [],
            filemtime( $file )
        );
    }

    // --- “Home” layout styles: only on the front page ---
    if ( is_front_page() || is_home() ) {
        $home_dir = "{$css_dir}/layout/home";
        $home_uri = "{$css_uri}/layout/home";

        foreach ( glob( "{$home_dir}/*.min.css" ) as $file ) {
            $name   = basename( $file );
            $base   = str_replace( '.min', '', pathinfo( $name, PATHINFO_FILENAME ) );
            $handle = 'tdm-home-' . sanitize_title_with_dashes( $base );

            wp_enqueue_style(
                $handle,
                "{$home_uri}/{$name}",
                file_exists( $vars_file ) ? [ 'tdm-variables' ] : [],
                filemtime( $file )
            );
        }
    }

    // --- JS (minified files in assets/js/min) ---
    $js_dir = "{$theme_dir}/assets/js/min";
    $js_uri = "{$theme_uri}/assets/js/min";

    $scripts = [
        'header' => 'header.min.js',
        'hero'   => 'hero.min.js',
        'home'   => 'home.min.js', // now enqueued on every page
        // add more here as needed…
    ];

    foreach ( $scripts as $key => $file_name ) {
        $js_file = "{$js_dir}/{$file_name}";
        if ( file_exists( $js_file ) ) {
            // only load “hero.min.js” on the front page
            if ( $key === 'hero' && ! ( is_front_page() || is_home() ) ) {
                continue;
            }
            wp_enqueue_script(
                "tdm-{$key}",
                "{$js_uri}/{$file_name}",
                [],
                filemtime( $js_file ),
                true
            );
        }
    }
}

function mytheme_register_footer_menus() {
    register_nav_menus( array(
      'footer_menu_1' => __( 'Footer Menu 1', 'mytheme' ),
      'footer_menu_2' => __( 'Footer Menu 2', 'mytheme' ),
      'footer_menu_3' => __( 'Footer Menu 3', 'mytheme' ),
    ) );
  }
  add_action( 'after_setup_theme', 'mytheme_register_footer_menus' );
  
add_action( 'wp_enqueue_scripts', 'tdm_enqueue_assets' );

function tdm_add_module_type( $tag, $handle ) {
    if ( in_array( $handle, [ 'tdm-header', 'tdm-hero', 'tdm-home' ], true ) ) {
        return str_replace( '<script ', '<script type="module" ', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'tdm_add_module_type', 10, 2 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
