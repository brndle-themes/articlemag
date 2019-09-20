<?php
/**
 *
 * CSFramework Actions API
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Actions_API extends CSFramework_Abstract {

  public function __construct() {
    $this->addAction( 'admin_footer', 'icon_dialog', 99 );
    $this->addAction( 'wp_ajax_cs-icons', 'icon_generator', 99 );

    if ( !isset( get_current_screen()->id ) || get_current_screen()->base != 'post' ) {
      $this->addAction( 'print_media_templates', 'print_media_templates' );
      $this->addAction( 'wp_enqueue_media', 'wp_enqueue_media' );
    }
  }

  /**
   *
   * WP_Gallery Extra Settings
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_enqueue_media() {
    wp_enqueue_script( 'cs-gallery-settings', FRAMEWORK_ASSETS.'/js/cs-gallery-settings.js', array('media-views'), '1.0.0', true );
  }

  /**
   *
   * WP_Gallery Extra Settings
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function print_media_templates() {
  ?>
  <script type="text/html" id="tmpl-cs-gallery-settings">
    <label class="setting cs-settings">
      <small class="cs-label cs-label-primary">ARTICLEMAG</small>
      <span>Slideshow or </span>
      <select id="cs-gallery-type" data-setting="cstype">
        <option value="">default</option>
        <option value="slideshow">Slideshow</option>
        <option value="gallery_thumb">Gallery with Thumbnails</option>
        <option value="gallery_nearby">Gallery visibleNearby</option>
        <option value="gallery_lightbox">Gallery with Lightbox</option>
      </select>
    </label>
    <div id="cs-gallery-scale" class="hidden">
      <label class="setting">
        <span>Image Scale</span>
        <select name="" data-setting="scale">
          <option value="">default</option>
          <option value="fill">fill</option>
          <option value="fit">fit</option>
          <option value="fit-if-smaller">fit-if-smaller</option>
          <option value="none">none</option>
        </select>
      </label>
    </div>
  </script>
  <?php
  }

  /**
   *
   * Icon Generator
   * @since 1.0.0
   * @version 1.1.0
   *
   */
  public function icon_generator() {

    do_action( 'cs_custom_icon' );

    if( cs_get_option( 'icomoon' ) ) {
      echo '<div class="icon-set-title icon-set-im">ICOMOON ICONS</div>';
      $icomoon_icons = json_decode( @file_get_contents( FRAMEWORK_DIR.'/fields/icon/im-icons.json' ) );
      foreach ( $icomoon_icons->icons as $icomoon_icon ) {
        echo '<a href="#" data-ro-icon="im-'. $icomoon_icon .'"><span class="im im-'. $icomoon_icon .'"></a>';
      }
      echo '<div class="icon-set-title icon-set-fa">FONT-AWESOME ICONS</div>';
    }

    $icons = json_decode( @file_get_contents( FRAMEWORK_DIR.'/fields/icon/fa-icons.json' ) );
    foreach ( $icons->icons as $icon ) {
      echo '<a href="#" data-ro-icon="fa-'. $icon .'"><span class="fa fa-'. $icon .'"></a>';
    }

    die();
  }

  /**
   *
   * Icon Generator
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function icon_dialog() {
    ?>
    <div id="icon-dialog" title="Icon Manager">
      <div id="dialog-header-wrap">
        <input type="text" name="" id="icon-search" placeholder="Search a icon..." value="" />
      </div>
      <div id="dialog-shadow-up"></div>
      <div id="icon-load"></div>
      <div id="dialog-insert-button">
        <div id="dialog-shadow-down"></div>
        <a href="#" id="icon-insert" class="button button-primary button-large">Use this icon</a>
      </div>
    </div>
    <div id="shortcode-overlay"></div>
    <?php
  }
}
new CSFramework_Actions_API();