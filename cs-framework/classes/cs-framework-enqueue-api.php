<?php
/**
 *
 * CSFramework Enqueue API
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Enqueue_API extends CSFramework_Abstract {

  public function __construct() {
    $this->addAction( 'admin_enqueue_scripts', 'admin_enqueue_scripts' );
    $this->addAction( 'customize_controls_enqueue_scripts', 'admin_enqueue_scripts', 20 );
  }

  /**
   *
   * Admin Enqueue
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function admin_enqueue_scripts() {

    wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

    wp_enqueue_style( 'chosen', FRAMEWORK_ASSETS.'/css/chosen.css', array(), '3.0.3', 'all' );
    wp_enqueue_style( 'cs-alert', FRAMEWORK_ASSETS.'/css/cs-alert.css', array(), '1.0.0', 'all' );
    wp_enqueue_style( 'cs-framework', FRAMEWORK_ASSETS.'/css/cs-framework.css', array(), '1.0.0', 'all' );

    if ( is_rtl() ) {
      wp_enqueue_style( 'cs-framework-rtl', FRAMEWORK_ASSETS.'/css/cs-framework-rtl.css', array(), '1.0.0', 'all' );
    }

    wp_enqueue_style( 'wp-jquery-ui-dialog' );

    wp_enqueue_style( 'cs-font-awesome',  THEME_URI . '/css/vendor/font-awesome.css' );

    if( cs_get_option( 'icomoon' ) ) {
      wp_enqueue_style( 'icomoon', THEME_URI . '/css/vendor/icomoon.css' );
    }

    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-slider' );
    wp_enqueue_script( 'jquery-ui-dialog' );
    wp_enqueue_script( 'jquery-ui-spinner' );
    wp_enqueue_script( 'jquery-ui-accordion' );

    wp_enqueue_script( 'jquery.store', FRAMEWORK_ASSETS.'/js/jquery.store.js', array('jquery'), '1.4.0', true );
    wp_enqueue_script( 'jquery-interdependencies', FRAMEWORK_ASSETS.'/js/jquery.interdependencies.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'chosen', FRAMEWORK_ASSETS.'/js/chosen.jquery.min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'cs-framework', FRAMEWORK_ASSETS.'/js/cs-framework.js', array('jquery', 'jquery.store', 'chosen', 'jquery-interdependencies'), '1.0.0', true );
    wp_localize_script(
      'cs-framework',
      'articlamag_params',
      array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
      )
    );

    if( isset( $_GET['page'] ) && $_GET['page'] == 'articlemag' ) {

      $webfonts = array();
      $fonts = json_decode( @file_get_contents( FRAMEWORK_DIR.'/fields/typography/fonts.json' ) );

      foreach ( $fonts->items as $key => $font ) {
        $webfonts[$font->family] = $font->variants;
      }

      wp_localize_script('cs-framework', 'cs_google_fonts', $webfonts);

    }

  }

}
new CSFramework_Enqueue_API();