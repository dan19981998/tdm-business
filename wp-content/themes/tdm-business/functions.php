<?php
function tdm_enqueue_assets() {
  $theme_dir = get_template_directory();
  $theme_uri = get_template_directory_uri();

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

  if ( is_page_template( 'creator.php' ) || is_page_template( 'agency.php' ) ) {
      $services_dir = "{$css_dir}/layout/services";
      $services_uri = "{$theme_uri}/assets/css/layout/services";
      
      foreach ( glob( "{$services_dir}/*.min.css" ) as $file ) {
          $name   = basename( $file );
          $base   = str_replace( '.min', '', pathinfo( $name, PATHINFO_FILENAME ) );
          $handle = 'tdm-' . sanitize_title_with_dashes( $base );

          wp_enqueue_style(
              $handle,
              "{$services_uri}/{$name}",
              file_exists( $vars_file ) ? [ 'tdm-variables' ] : [],
              filemtime( $file )
          );
      }
  }

  $js_dir = "{$theme_dir}/assets/js/min";
  $js_uri = "{$theme_uri}/assets/js/min";

  wp_enqueue_script(
    'tdm-lottie',
    'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js',
    [],
    '5.9.4',
    true
  );

  $other_scripts = [
    'header'       => 'header.min.js',
    'hero'         => 'hero.min.js',
    'home'         => 'home.min.js',
    'custom-scroll'=> 'customScroll.min.js',
    'calculator' => 'calculator.min.js',
    'card-overlap' => 'card-overlap.min.js',
  ];

  foreach ( $other_scripts as $key => $file_name ) {
    $path = "{$js_dir}/{$file_name}";
    if ( file_exists( $path ) ) {
      $deps = ( $key === 'hero' ) ? [ 'tdm-lottie' ] : [];
      
      wp_enqueue_script(
        "tdm-{$key}",
        "{$js_uri}/{$file_name}",
        $deps,
        filemtime( $path ),
        true
      );
    }
  }

  if ( wp_script_is( 'tdm-calculator', 'enqueued' ) ) {
    wp_localize_script(
      'tdm-calculator',
      'ajax_object',
      [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ]
    );
  }

  // 2) ALSO localize the Lottie path for loading.json
  if ( wp_script_is( 'tdm-calculator', 'enqueued' ) ) {
    wp_localize_script(
      'tdm-calculator',
      'tdm_paths',
      [ 'lottiePath' => "{$theme_uri}/assets/images/" ]
    );
  }
  
  if ( wp_script_is( 'tdm-lottie', 'enqueued' ) && wp_script_is( 'tdm-hero', 'enqueued' ) ) {
    wp_localize_script(
      'tdm-hero',
      'tdm_paths',
      [ 'lottiePath' => "{$theme_uri}/assets/images/" ]
    );
    wp_add_inline_script(
      'tdm-hero',
      "
      document.addEventListener('DOMContentLoaded', function() {
        var scrollLottieContainer = document.querySelector('.lottie-scroll');
        var swipeLottieContainer  = document.querySelector('.lottie-swipe');
        var tickContainers        = document.querySelectorAll('.lottie-tick');
        var animLib               = window.lottie || window.bodymovin;
        var tickAnims             = [];
  
        if (!animLib) return;
  
        // load the always-playing ones
        if (scrollLottieContainer) animLib.loadAnimation({ container: scrollLottieContainer, renderer: 'svg', loop: true, autoplay: true, path: tdm_paths.lottiePath + 'scroll.json' });
        if (swipeLottieContainer)  animLib.loadAnimation({ container: swipeLottieContainer,  renderer: 'svg', loop: true, autoplay: true, path: tdm_paths.lottiePath + 'swipe.json'  });
  
        // prepare tick animations (but don't autoplay)
        tickContainers.forEach(function(container) {
          var a = animLib.loadAnimation({
            container: container,
            renderer: 'svg',
            loop: false,
            autoplay: false,
            path: tdm_paths.lottiePath + 'tick.json'
          });
          tickAnims.push({ el: container, anim: a });
        });
  
        // observe each tick container so it plays exactly when it scrolls into view
        var obsOptions = { root: null, rootMargin: '0px', threshold: 0.5 };
        var observer = new IntersectionObserver(function(entries) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              // find the matching anim and play it
              tickAnims.forEach(function(t) {
                if (t.el === entry.target && typeof t.anim.play === 'function') {
                  t.anim.play();
                }
              });
              observer.unobserve(entry.target);
            }
          });
        }, obsOptions);
  
        tickContainers.forEach(function(container) {
          observer.observe(container);
        });
  
        // slider-fade logic stays the same...
        var blocks = document.querySelector('.how-we-help .blocks');
        var hasInteracted = false;
        if (blocks) {
          blocks.addEventListener('scroll', function() {
            if (blocks.scrollLeft > 0 && !hasInteracted) {
              hasInteracted = true;
              if (swipeLottieContainer) swipeLottieContainer.classList.add('fade-out-lottie');
            }
          }, { passive: true });
        }
      });
      "
    );
  }  
}
add_action( 'wp_enqueue_scripts', 'tdm_enqueue_assets' );

function mytheme_register_footer_menus() {
    register_nav_menus( array(
      'footer_menu_1' => __( 'Footer Menu 1', 'mytheme' ),
      'footer_menu_2' => __( 'Footer Menu 2', 'mytheme' ),
      'footer_menu_3' => __( 'Footer Menu 3', 'mytheme' ),
    ) );
}
add_action( 'after_setup_theme', 'mytheme_register_footer_menus' );

function tdm_add_module_type( $tag, $handle ) {
    if ( in_array( $handle, [ 'tdm-header', 'tdm-hero', 'tdm-home' ], true ) ) {
        return str_replace( '<script ', '<script type="module" ', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'tdm_add_module_type', 10, 2 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );





add_action( 'wp_ajax_calculate_earnings',     'calculate_earnings_callback' );
add_action( 'wp_ajax_nopriv_calculate_earnings','calculate_earnings_callback' );
function calculate_earnings_callback() {
    ob_start();
    $age           = intval( $_POST['age'] ?? 0 );
    $branding      = sanitize_text_field( $_POST['branding'] ?? '' );
    $username      = sanitize_text_field( $_POST['following'] ?? '' );
    $traffic       = sanitize_text_field( $_POST['traffic'] ?? '' );
    $looks         = intval( $_POST['looks'] ?? 0 );
    $location      = sanitize_text_field( $_POST['location'] ?? '' );
    $management    = sanitize_text_field( $_POST['management'] ?? '' );
    $speaksEnglish = sanitize_text_field( $_POST['speaksEnglish'] ?? '' );
    $explicit      = sanitize_text_field( $_POST['explicit'] ?? '' );
    $custom        = sanitize_text_field( $_POST['custom'] ?? '' );
    $workEthic     = intval( $_POST['workEthic'] ?? 0 );

    if ( ! $username ) {
        wp_send_json_error( ['error' => 'Instagram username is required'] );
        wp_die();
    }

    // Fetch Instagram data via RapidAPI
    $api_key  = '593135a089mshb2607da9319fbc1p1bd7d5jsn08fa38076e39';
    $api_host = 'instagram230.p.rapidapi.com';
    $url      = "https://{$api_host}/user/details?username=" . urlencode( $username );

    $ch = curl_init();
    curl_setopt_array( $ch, [
      CURLOPT_URL            => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER     => [
        "x-rapidapi-host: {$api_host}",
        "x-rapidapi-key:  {$api_key}"
      ],
    ]);
    $raw = curl_exec( $ch );
    curl_close( $ch );

    $ig = json_decode( $raw, true );
    if ( ! isset( $ig['data']['user'] ) ) {
      wp_send_json_error( ['error' => 'Failed to fetch Instagram data. Please check the username.'] );
      wp_die();
    }
    $user = $ig['data']['user'];

    // Extract follower count & name
    $follower_count = intval( $user['edge_followed_by']['count'] ?? 0 );
    $full_name      = $user['full_name'] ?? 'N/A';

    // Base earnings calculator
    function calc_base( $fc ) {
      if ( $fc < 200000 ) {
        $adj  = 2 + log10( $fc +1 ) * 1.8;
        $fac  = 1 + pow( $fc, .85 ) / 150;
        $mult = 10;
      } elseif ( $fc < 1000000 ) {
        $adj  = 2 + log10( $fc +1 ) * 1.5;
        $fac  = 1 + pow( $fc, .92 ) / 175;
        $mult = 3;
      } else {
        $adj  = 2 + log10( $fc +1 ) * 1.2;
        $fac  = 1 + pow( $fc, .95 ) / 250;
        $mult = 2;
      }
      return $adj * $fac * $mult;
    }
    $baseE = calc_base( $follower_count );

    // Factors
    $ageFactor       = $age < 25 ? 1.2 : ( $age < 35 ? 1.0 : 0.8 );
    $brandingMap     = [
      'occupational-niche'=>1,'gym-girl'=>1.75,'gamer'=>1.5,'e-girl'=>1.75,
      'goth'=>2, 'trans'=>2, 'femboy'=>1.75, 'sports'=>1.2, 'girl-next-door'=>1,
      'femdom'=>2, 'worship'=>1.5, 'bbw'=>1.2, 'milf'=>1, 'teen'=>1, 'pregnant'=>1.25
    ];
    $brandingFactor  = $brandingMap[ $branding ] ?? 1;
    $trafficFactor   = $traffic==='tier1'?1.6:($traffic==='tier2'?1.25:0.9);
    $locMap          = ['NA'=>1.5,'WE'=>1.4,'EE'=>1.5,'SA'=>1.1,'AS'=>1.2,'AFR'=>0.5,'AUST'=>1.5];
    $locationFactor  = $locMap[$location] ?? 1;
    $managementFactor= 1; // all options at 1
    $englishFactor   = $speaksEnglish==='yes'?1.2:0.7;
    $explicitFactor  = $explicit==='yes'?1.2:0.7;
    $customFactor    = $custom==='yes'?1.2:1;
    $looksFactor     = $looks>=5?0.6+pow($looks/10,1.1):max(0.1,1-pow((5-$looks)/5,3.5));
    $workEthicFactor = $workEthic>=5?0.65+log($workEthic+1)*0.15:max(0.1,1-pow((5-$workEthic)/4.5,3.8));

    // Final earnings
    $est = max(0, $baseE
      * $ageFactor * $brandingFactor
      * $trafficFactor * $looksFactor
      * $locationFactor * $managementFactor
      * $englishFactor * $explicitFactor
      * $customFactor * $workEthicFactor
    );

    // JSON response
    $resp = [
      'estimatedEarnings'   => number_format( $est, 2 ),
      'followerCount'       => number_format( $follower_count ),
      'fullName'            => $full_name,
      'instagramData'       => $user
    ];

    ob_end_clean();
    wp_send_json_success( $resp );
    wp_die();
}
