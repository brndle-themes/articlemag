<?php
/**
 *
 * CSFramework Mega Menu API
 * @since 1.0.0
 * @version 1.0.0
 *
 */
locate_template( 'cs-framework/includes/walker_nav_menu.php', true );

class CSFramework_Mega_Menu_API extends CSFramework_Abstract {

  public $extra_fields = array( 'highlight', 'highlight_type', 'icon', 'mega', 'mega_width', 'mega_position', 'mega_custom_width', 'column_title', 'column_title_link', 'column_width', 'content' );
  public $walker = null;

  public function __construct() {

    $this->addFilter( 'wp_nav_menu_args', 'wp_nav_menu_args', 99 );
    $this->addFilter( 'wp_edit_nav_menu_walker', 'wp_edit_nav_menu_walker', 10, 2 );
    $this->addFilter( 'wp_setup_nav_menu_item', 'wp_setup_nav_menu_item', 10, 1 );

    $this->addAction( 'wp_update_nav_menu_item', 'wp_update_nav_menu_item', 10, 3 );
    $this->addAction( 'cs_mega_menu_fields', 'cs_mega_menu_fields', 10, 2 );
    $this->addAction( 'cs_mega_menu_labels', 'cs_mega_menu_labels' );

  }

  /**
   *
   * Menu Menu Fields
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function cs_mega_menu_fields( $item_id, $item ) {
  ?>
  <p class="field-highlight description description-thin">
    <label for="edit-menu-item-highlight-<?php echo $item_id; ?>">
      Highlight<br />
      <input type="text" id="edit-menu-item-highlight-<?php echo $item_id; ?>" class="widefat code edit-menu-item-highlight" name="menu-item-highlight[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->highlight ); ?>" />
    </label>
  </p>

  <p class="field-highlight-type description description-thin">
    <label for="edit-menu-item-highlight-type-<?php echo $item_id; ?>">
      Highlight Type<br />
      <select id="edit-menu-item-highlight-type-<?php echo $item_id; ?>" name="menu-item-highlight_type[<?php echo $item_id; ?>]">
        <option value="">default</option>
        <?php
          foreach ( array( 'info', 'success', 'warning', 'danger' ) as $highlight ) {
            echo '<option value="'. $highlight .'"'. selected( $highlight, $item->highlight_type ) .'>'. $highlight .'</option>';
          }
        ?>
      </select>
    </label>
  </p>

  <div class="field-icon description description-wide">
    <?php
      $hidden = ( empty( $item->icon ) ) ? ' hidden' : '';
      $icon   = ( !empty( $item->icon ) ) ? ' class="'. cs_icon_class( $item->icon ) . '"' : '';
    ?>
    <div class="cs_field cs_field_icon">
      <div class="cs-icon-select">
        <span class="icon-preview<?php echo $hidden; ?>"><span<?php echo $icon; ?>></span></span>
        <button class="button button-primary icon-add">Add Icon</button>
        <button class="button cs-button-remove icon-remove<?php echo $hidden; ?>">Remove Icon</button>
        <input type="hidden" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo $item->icon; ?>" class="widefat code edit-menu-item-icon icon-value"/>
      </div>
    </div>
  </div>

  <div class="cs-mega-menu">

    <div class="field-mega">
      <label for="edit-menu-item-mega-<?php echo $item_id; ?>">
        <input type="checkbox" class="is-mega" id="edit-menu-item-mega-<?php echo $item_id; ?>" value="mega" name="menu-item-mega[<?php echo $item_id; ?>]"<?php checked( $item->mega, 'mega' ); ?> />
        Mega Menu
      </label>
    </div>

    <div class="field-mega-width">
      <select id="edit-menu-item-mega_width-<?php echo $item_id; ?>" name="menu-item-mega_width[<?php echo $item_id; ?>]" class="is-width">
        <option value="">Full Width</option>
        <?php
          $mega_width = array( 'natural' => 'Natural Width', 'custom'  => 'Custom Width' );
          foreach ( $mega_width as $key => $value ) {
            echo '<option value="'. $key .'"'. selected( $key, $item->mega_width) .'>'. $value .'</option>';
          }
        ?>
      </select>
    </div>

    <div class="mega-depend-width hidden">
      <p class="description">
        <label for="edit-menu-item-mega_custom_width<?php echo $item_id; ?>">
          Custom Mega Menu Width (without px)<br />
          <input type="text" id="edit-menu-item-mega_custom_width<?php echo $item_id; ?>" class="widefat code edit-menu-item-mega_custom_width" name="menu-item-mega_custom_width[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->mega_custom_width ); ?>" />
        </label>
      </p>
    </div>

    <div class="mega-depend-position hidden">
      <p class="description">
        <label for="edit-menu-item-mega_position<?php echo $item_id; ?>">
          <input type="checkbox" id="edit-menu-item-mega_position<?php echo $item_id; ?>" value="1" name="menu-item-mega_position[<?php echo $item_id; ?>]"<?php checked( $item->mega_position, 1 ); ?> />
          Mega Right Position (optional)
        </label>
      </p>
    </div>

    <div class="clear"></div>
  </div>

  <div class="cs-mega-column">

    <p class="field-column description description-thin">
      <label for="edit-menu-item-column-title-<?php echo $item_id; ?>">
        <input type="checkbox" id="edit-menu-item-column-title-<?php echo $item_id; ?>" value="1" name="menu-item-column_title[<?php echo $item_id; ?>]"<?php checked( $item->column_title, 1 ); ?> /> Disable Title
      </label>
    </p>

    <p class="field-column description description-thin cs-last">
      <label for="edit-menu-item-column-title-link-<?php echo $item_id; ?>">
        <input type="checkbox" id="edit-menu-item-column-title-link-<?php echo $item_id; ?>" value="1" name="menu-item-column_title_link[<?php echo $item_id; ?>]"<?php checked( $item->column_title_link, 1 ); ?> /> Disable Title Link
      </label>
    </p>

    <p class="field-column description">
      <select id="edit-menu-item-column_width-<?php echo $item_id; ?>" name="menu-item-column_width[<?php echo $item_id; ?>]">
        <option value="">Custom column width (optional)</option>
        <?php
          $column_width = array(
            'col-md-1'    => '1 Col',
            'col-md-2'    => '2 Col',
            'col-md-3'    => '3 Col',
            'col-md-4'    => '4 Col',
            'col-md-5'    => '5 Col',
            'col-md-6'    => '6 Col (half)',
            'col-md-7'    => '7 Col',
            'col-md-8'    => '8 Col',
            'col-md-9'    => '9 Col',
            'col-md-10'   => '10 Col',
            'col-md-11'   => '11 Col',
            'col-md-12'   => '12 Col (full-width)'
          );
          foreach ($column_width as $key => $value) {
            echo '<option value="'. $key .'"'. selected($key, $item->column_width) .'>'. $value .'</option>';
          }
        ?>
      </select>
    </p>

    <div class="clear"></div>
  </div>

  <p class="field-content description description-wide">
    <label for="edit-menu-item-content-<?php echo $item_id; ?>">
      Description ( and can be used any shortcode )<br />
      <textarea id="edit-menu-item-content-<?php echo $item_id; ?>" class="widefat edit-menu-item-content" rows="3" cols="20" name="menu-item-content[<?php echo $item_id; ?>]"><?php echo $item->content; ?></textarea>
    </label>
  </p>

  <div class="clear"></div>
  <?php
  }
  public function cs_mega_menu_labels() {

    $out   = '<span class="item-mega"><span class="cs-label cs-label-primary">Mega Menu</span></span>';
    $out  .= '<span class="item-mega-column"><span class="cs-label cs-label-success">Column</span></span>';
    echo $out;

  }

  /**
   *
   * Custom Menu Args
   * @since 1.0.0
   * @version 1.1.0
   *
   */
  public function wp_nav_menu_args( $args ) {

    $location = $args['theme_location'];

    if( ( $location == 'primary' || $location == 'right' ) && ! isset( $args['mobile'] ) ) {

      $header = cs_get_option( 'header_style' );

      $walker = new Walker_Nav_Menu_Custom();
      $args['container'] = false;
      $args['menu_class'] = 'main-navigation sf-menu';
      $args['walker'] = $walker;

      if( ( $location == 'primary' && $header != 'fancy' ) || ( $location == 'right' && $header == 'fancy' ) ) {
        $args['items_wrap'] = $walker->custom_wrap();
      }

    } else if ( isset( $args['mobile'] ) || $location == 'mobile' ) {
      $args['after'] = '<div class="cs-dropdown-plus"><i class="fa fa-plus"></i></div>';
    }

    return $args;
  }

  /**
   *
   * Custom Nav Menu Edit
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_edit_nav_menu_walker( $walker, $menu_id ) {
    return 'Walker_Nav_Menu_Edit_Custom';
  }

  /**
   *
   * Save Custom Fields
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_setup_nav_menu_item( $item ) {

    foreach ( $this->extra_fields as $key ) {
      $item->$key = get_post_meta( $item->ID, '_menu_item_'. $key, true );
    }

    return $item;
  }

  /**
   *
   * Update Custom Fields
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_update_nav_menu_item( $menu_id, $menu_item_db_id, $args ) {

    foreach ( $this->extra_fields as $key ) {
      $value = ( isset( $_REQUEST['menu-item-'.$key][$menu_item_db_id] ) ) ? $_REQUEST['menu-item-'.$key][$menu_item_db_id] : '';
      update_post_meta( $menu_item_db_id, '_menu_item_'. $key, $value );
    }

  }
}
new CSFramework_Mega_Menu_API();