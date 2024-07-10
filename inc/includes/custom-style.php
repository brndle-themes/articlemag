<?php
/**
 *
 * Style Parser
 *
 * @since 1.0.0
 * @version 1.0.0
 */
function cs_get_custom_style() {

	$cs_get_typography   = cs_get_typography();
	$font_family         = cs_get_option( 'font_family' );
	$non_responsive      = cs_get_option( 'non_responsive' );
	$header_height       = cs_get_option( 'header_height' );
	$menu_max_width      = cs_get_option( 'menu_max_width' );
	$height_sticky       = cs_get_option( 'header_height_sticky' );
	$logo_top            = cs_get_option( 'logo_top' );
	$logo_bottom         = cs_get_option( 'logo_bottom' );
	$visible_top_bar     = cs_get_option( 'visible_top_bar' );
	$mobile_animations   = cs_get_option( 'mobile_animations' );
	$extra_header_height = ( ! empty( $header_height ) || $header_height === 0 ) ? $header_height + 40 : 140;
	$container_width     = cs_get_option( 'container_width' );

	ob_start();

	if ( ! empty( $font_family ) ) {

		foreach ( $font_family as $font ) {
			echo '@font-face{';

			echo 'font-family: "' . $font['name'] . '";';

			if ( empty( $font['css'] ) ) {
				echo 'font-style: normal;';
				echo 'font-weight: normal;';
			} else {
				echo $font['css']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
			}

			echo ( ! empty( $font['ttf'] ) ) ? 'src: url(' . $font['ttf'] . ');' : '';
			echo ( ! empty( $font['eot'] ) ) ? 'src: url(' . $font['eot'] . ');' : '';
			echo ( ! empty( $font['svg'] ) ) ? 'src: url(' . $font['svg'] . ');' : '';
			echo ( ! empty( $font['woff'] ) ) ? 'src: url(' . $font['woff'] . ');' : '';
			echo ( ! empty( $font['otf'] ) ) ? 'src: url(' . $font['otf'] . ');' : '';

			echo '}';
		}
	}

	// stop mobile animations.
	if ( ! empty( $mobile_animations ) && wp_is_mobile() ) {
		echo '.cs-animation{ visibility: inherit; }';
	}

	// typography.
	echo $cs_get_typography; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output

	// header height.
	if ( $header_height ) {
		echo <<<CSS
  .cs-sticky-item{
    line-height: {$header_height}px !important;
    height: {$header_height}px !important;
  }

  .cs-header-transparent #page-header .md-padding{
    padding-top: {$extra_header_height}px;
  }

  .cs-header-transparent #navigation-mobile{
    padding-top: {$header_height}px;
  }
CSS;
	}

	// container width
	// -----------------------------------------------------------
	if ( $container_width ) {
			echo <<<CSS
                @media (min-width: 1200px) {
              .container {
                  width: 100%;
                  max-width: {$container_width}px;
              }
        }
CSS;
	}

	// header sticky height
	// -----------------------------------------------------------
	if ( $height_sticky ) {
		echo <<<CSS
  .is-compact .cs-sticky-item{
    line-height: {$height_sticky}px !important;
    height: {$height_sticky}px !important;
  }
CSS;
	}

	// logo top
	// -----------------------------------------------------------
	if ( cs_not_empty( $logo_top ) || cs_not_empty( $logo_bottom ) ) {
		$logo_top    = ( cs_not_empty( $logo_top ) ) ? 'padding-top:' . $logo_top . 'px;' : '';
		$logo_bottom = ( cs_not_empty( $logo_bottom ) ) ? 'padding-bottom:' . $logo_bottom . 'px;' : '';
		echo '#site-logo h1, #site-logo img{' . $logo_top . $logo_bottom . '}';
	}

	// non responsive check
	// -----------------------------------------------------------
	if ( ! $non_responsive ) {

		echo <<<CSS
@media (max-width: {$menu_max_width}px) {

  #site-logo-right,
  #site-nav{
    display: none !important;
  }

  .cs-header-left #site-logo{
    display: block !important;
    float: left;
    line-height: 70px;
  }

  #cs-mobile-icon,
  .cs-mobile-toggle-track{
    display: block;

  }

  #main{
    padding-top: 0 !important;
  }

  .cs-header-fancy #site-logo{
    text-align: left;
    max-width: 85%;
  }

  .cs-header-fancy .cs-fancy-row{
    margin-left: 0;
  }

    .cs-header-fancy .cs-fancy-logo {
        padding-left: 0;
        padding-right: 0;
    }

    .cs-header-fancy #masthead .cs-inner {
        display: flex;
    }

    #cs-mobile-userbar {
        display: block;
        height: 100%;
        line-height: 65px;
        cursor: pointer;
    }

    .cs-header-fancy #cs-mobile-userbar {
        height: 100%;
        line-height: 100px;
    }

    #cs-mobile-userbar .cs-user-link img {
        margin-left: 0; 
    }

    .cs-header-left #cs-mobile-userbar {
        line-height: 70px;
    }

    .cs-header-center #cs-mobile-userbar {
        line-height: 50px;
    }

    .cs-header-center .cs-user-link img {
        width: 40px;
        height: 40px;
    }

    .cs-header-center #cs-mobile-userbar ul#bp-userbar {
        right: 0px;
    }

    ul#bp-notify {
        display: none;
    }

    .cs-mobile-icons-wrapper {
        display: flex;
        justify-content: flex-end;
    }

    .cs-mobile-icons-wrapper {
        margin-right: 50px;
    }

    .cs-header-left .cs-sticky-item,
    .cs-header-left .cs-mobile-icons-wrapper > div {
        height: 70px;
        line-height: 70px;
    }

    .cs-header-center .cs-sticky-item,
    .cs-header-center .cs-mobile-icons-wrapper > div {
        height: 50px;
        line-height: 50px;
    }

    .cs-header-center #cs-mobile-icon {
        left: 15px;
        right: auto;
    }

    .cs-header-center .cs-mobile-icons-wrapper {
        margin-right: 0;
    }
    
    .cs-header-center #site-logo{
      padding:0 15px;
    }

    .cs-header-center #masthead{
      padding:0 15px;
    }

    .cs-header-center .cs-mobile-toggle-track {
      right: 0;
      position: absolute;
      left: 35px;
      width: 40px;
    }


    
    [dir='rtl'] .cs-mobile-icons-wrapper {
        margin-left: 30px;
        margin-right: auto;
    }

    [dir='rtl'] .cs-mobile-icons-wrapper > div:first-child,
    [dir='rtl'] .cs-mobile-icons-wrapper > div:last-child {
        padding-left: 8px;
        padding-right: 0;
    }

    [dir='rtl'] .cs-header-left #site-logo {
        float: right;
    }
    
    [dir='rtl'] .cs-header-center .cs-mobile-icons-wrapper {
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        margin-right: 15px;
    }

    [dir='rtl'] .cs-header-fancy .cs-fancy-row {
        margin-left: auto;
        margin-right: 0;
    }

}
CSS;

		if ( ! $visible_top_bar && ! $non_responsive ) {

			echo <<<CSS
@media (max-width: {$menu_max_width}px) {

  .is-transparent #top-bar,
  #top-bar{
    display: none !important;
  }

  .is-transparent.is-transparent-top-bar #masthead{
    margin-top:0 !important;
  }

  .is-transparent-top-bar #page-header .md-padding{
    padding-top:140px;
  }

}
CSS;
		}
	}

	$output = ob_get_clean();

	return $output;
}

// custom skin.
function cs_get_custom_skin() {

	$skin              = cs_get_option( 'skin' );
	$accent            = ( cs_get_option( 'accent_color' ) ) ? cs_get_option( 'accent_color' ) : '#e9425d';
	$accent_brightness = cs_brightness( $accent, 0.7901 );
	$accent_darkness   = cs_brightness( $accent, -0.7901 );
	$accent_rgba_06    = cs_hex2rgba( $accent_brightness, 0.6 );

	// accent elements colors.
	if ( $skin == 'accent' ) {

		return <<<CSS
  .cs-tab .cs-tab-nav ul li a:hover,
  .cs-tab .cs-tab-nav ul li.active a,
  .cs-toggle-title .cs-in,
  .cs-progress-icon .active,
  .cs-icon-accent.cs-icon-outlined,
  .cs-icon-default,
  .cs-faq-filter a.active,
  .cs-faq-filter a:hover,
  .cs-counter,
  .ajax-close:hover,
  .isotope-filter a:hover, .isotope-filter a.active,
  .cs-accordion-title .cs-in,
  #sidebar .widget_nav_menu ul li.current-menu-item > a,
  #sidebar .widget_nav_menu ul li a:hover,
  .articlemag_widget .widget-title h4,
  .articlemag_widget ul li a:hover,
  .portfolio-item-description .item-title a:hover,
  .cs-lang-top-modal ul li a:hover,
  .comment-reply-link,
  .related-posts ul li a:hover,
  .entry-title a:hover,
  .entry-meta a:hover,
  .post-navigation a:hover,
  .page-pagination a:hover,
  #site-nav ul li ul li .cs-link:hover,
  #site-nav > ul > li > .cs-link:hover,
  #site-nav .cs-notification .sub-menu li a:hover,
  ul#bp-userbar li a:hover,
  #site-nav a.cs-user-link:hover,
  .bp-msg .bp-icon-wrap:hover,
  .user-notifications .bp-icon-wrap:hover,
  .cs-mobile-icons-wrapper .cs-menu-cart > a:hover,
  #site-nav .current-menu-ancestor > .cs-link,
  #site-nav .current-menu-item > .cs-link,
  #site-logo h1 a:hover,
  .cs-lang-top-modal ul li a:hover,
  .cs-top-module > a:hover,
  .cs-top-module .cs-open-modal:hover,
  a,
  .cs-accent-color,
  .cs-cart-widget-side .cs-module-woominicart .total .amount,
        
  .buddypress-wrap .bp-navs li.current a, .buddypress-wrap .bp-navs li.selected a, .buddypress.widget .item-options a.selected, .buddypress.widget .item-options a:hover,
  .buddypress-wrap .bp-navs li:not(.current) a:focus, .buddypress-wrap .bp-navs li:not(.current) a:hover, .buddypress-wrap .bp-navs li:not(.selected) a:focus, .buddypress-wrap .bp-navs li:not(.selected) a:hover,
  nav#object-nav.vertical .selected > a, nav#object-nav.vertical a:hover, .bp-single-vert-nav .item-body:not(#group-create-body) #subnav:not(.tabbed-links) li.current a,
  .buddypress-wrap .main-navs:not(.dir-navs) li.selected a, .buddypress-wrap .main-navs:not(.dir-navs) li.current a, .buddypress-wrap .tabbed-links ol li.current a, .buddypress-wrap .tabbed-links ul li.current a,
  .buddypress-wrap .bp-navs li.current a, .buddypress-wrap .bp-navs li.current a:focus, .buddypress-wrap .bp-navs li.current a:hover, .buddypress-wrap .bp-navs li.selected a, .buddypress-wrap .bp-navs li.selected a:focus, .buddypress-wrap .bp-navs li.selected a:hover {
    color: {$accent};
  }

  .dark-mode .cs-top-module > a:hover,
  .dark-mode .cs-top-module .cs-open-modal:hover,
  .dark-mode #site-logo h1 a:hover,
  .dark-mode .entry-title a:hover,
  .dark-mode #site-nav > ul > li > .cs-link:hover,
  .dark-mode #site-nav a.cs-user-link:hover,
  .dark-mode .bp-msg .bp-icon-wrap:hover,
  .dark-mode .user-notifications .bp-icon-wrap:hover,
  .dark-mode .cs-mobile-icons-wrapper .cs-menu-cart > a:hover,
  .dark-mode #site-nav .current-menu-ancestor > .cs-link,
  .dark-mode #site-nav .current-menu-item > .cs-link,
  .dark-mode #site-nav ul li ul li .cs-link:hover,
  .dark-mode #site-nav .cs-notification .sub-menu li a:hover,
  .dark-mode ul#bp-userbar li a:hover,
  .dark-mode .comment-meta a:hover,
  .dark-mode .entry-tags a:hover,
  .dark-mode .entry-meta a:hover,
  .dark-mode .articlemag_widget ul li a:hover,
  .dark-mode .post-navigation a:hover,
  .dark-mode .page-pagination a:hover,
  .dark-mode #copyright a:hover {
	color: {$accent};
  }

  #cs-footer-block-before,
  #cs-footer-block-after,
  .bbp-pagination-links span.current,
  #bbp_user_edit_submit,
  .bbp-submit-wrapper .button,
  .cs-cart-count,
  .cs-notification-count,
  .cs-tab .cs-tab-nav ul li.active a:after,
  .cs-progress-bar,
  .cs-pricing-column-accent .cs-pricing-price,
  .cs-icon-accent.cs-icon-bordered,
  .cs-icon-accent.cs-icon-bgcolor,
  .cs-highlight,
  .cs-fancybox-accent.cs-fancybox-bgcolor,
  .cs-cta-bgcolor,
  .cs-btn-outlined-accent:hover,
  .cs-btn-flat-accent,
  .page-pagination .current,
  .widget_calendar tbody a,
  #sidebar .widget_nav_menu ul li.current-menu-item > a:after,
  .ajax-pagination .cs-loader:after,
  #page-header,
  .cs-menu-effect-7 .cs-depth-0:hover .cs-link-depth-0,
  .cs-menu-effect .cs-link-depth-0:before,
  .cs-module-social a:hover,
  .cs-accent-background,
  .articlemag_widget .widget-title h4:after,
        
  #buddypress .comment-reply-link, #buddypress .generic-button a, #buddypress .standard-form button, #buddypress a.button, #buddypress input[type="button"], #buddypress input[type="reset"]:not(.text-button), #buddypress input[type="submit"], #buddypress ul.button-nav li a, a.bp-title-button, #buddypress.buddypress-wrap .activity-list .load-more a, #buddypress.buddypress-wrap .activity-list .load-newest a, .buddypress .buddypress-wrap .bp-list.grid .action a, .buddypress .buddypress-wrap .bp-list.grid .action button, .buddypress .buddypress-wrap .action button, form#bp-data-export button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a, .buddypress .buddypress-wrap button.button, .buddypress .buddypress-wrap button.button.edit, .buddypress .buddypress-wrap .btn-default, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button,
  .buddypress-wrap .bp-navs li.current a .count, .buddypress-wrap .bp-navs li.dynamic.current a .count, .buddypress-wrap .bp-navs li.selected a .count, .buddypress_object_nav .bp-navs li.current a .count, .buddypress_object_nav .bp-navs li.selected a .count {
    background-color: {$accent};
  }
    
.bbp-pagination-links span.current,
  .cs-icon-accent.cs-icon-outlined,
  .cs-icon-accent.cs-icon-outer,
  .cs-faq-filter a.active,
  .cs-fancybox-outlined,
  .cs-cta-outlined,
  blockquote,
  .ajax-close:hover,
  .isotope-filter a:hover, .isotope-filter a.active,
  .page-pagination .current,
  .cs-menu-effect-6 .cs-link-depth-0:before,
  #site-nav > ul > li > ul,
  #site-nav .cs-notification .sub-menu,
  .cs-modal-content,
  .cs-accent-border,

  #buddypress .comment-reply-link, #buddypress .generic-button a, #buddypress .standard-form button, #buddypress a.button, #buddypress input[type="button"], #buddypress input[type="reset"]:not(.text-button), #buddypress input[type="submit"], #buddypress ul.button-nav li a, a.bp-title-button, #buddypress.buddypress-wrap .activity-list .load-more a, #buddypress.buddypress-wrap .activity-list .load-newest a, .buddypress .buddypress-wrap .bp-list.grid .action a, .buddypress .buddypress-wrap .bp-list.grid .action button, .buddypress .buddypress-wrap .action button, form#bp-data-export button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a, .buddypress .buddypress-wrap button.button, .buddypress .buddypress-wrap button.button.edit, .buddypress .buddypress-wrap .btn-default, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button,
  .buddypress-wrap .bp-navs li.current a, .buddypress-wrap .bp-navs li.selected a,
  ul#bp-userbar {
    border-color: {$accent};
  }
    
  .activity-list .activity-item .activity-content > .activity-meta.action .button:hover,
  .activity-list .activity-item .activity-content > .bp-generic-meta.action .button:hover {
    border-color: {$accent} !important;
  }

  .cs-menu-effect-4 .cs-link-depth-0:before{
    color: {$accent};
    text-shadow: 0 0 {$accent};
  }

  .cs-menu-effect-4 .cs-link-depth-0:hover::before{
    text-shadow: 8px 0 {$accent}, -8px 0 {$accent};
  }

 #bbp_user_edit_submit:hover,
  .bbp-submit-wrapper .button:hover,
  .cs-btn-flat-accent:hover,

  #buddypress .comment-reply-link:hover, #buddypress .generic-button a:hover, #buddypress .standard-form button:hover, #buddypress a.button:hover, #buddypress input[type="button"]:hover, #buddypress input[type="reset"]:not(.text-button):hover, #buddypress input[type="submit"]:hover, #buddypress ul.button-nav li a:hover, a.bp-title-button:hover, #buddypress.buddypress-wrap .activity-list .load-more a:hover, #buddypress.buddypress-wrap .activity-list .load-newest a:hover, .buddypress .buddypress-wrap .bp-list.grid .action a:focus, .buddypress .buddypress-wrap .bp-list.grid .action a:hover, .buddypress .buddypress-wrap .bp-list.grid .action button:focus, .buddypress .buddypress-wrap .bp-list.grid .action button:hover, .buddypress .buddypress-wrap .action button:hover, form#bp-data-export button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a:hover, .buddypress .buddypress-wrap button.button:hover, .buddypress .buddypress-wrap button.button.edit:hover, .buddypress .buddypress-wrap .btn-default:hover, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button:hover {
    background-color: {$accent_brightness};
  }

  #buddypress .comment-reply-link:hover, #buddypress .generic-button a:hover, #buddypress .standard-form button:hover, #buddypress a.button:hover, #buddypress input[type="button"]:hover, #buddypress input[type="reset"]:not(.text-button):hover, #buddypress input[type="submit"]:hover, #buddypress ul.button-nav li a:hover, a.bp-title-button:hover, #buddypress.buddypress-wrap .activity-list .load-more a:hover, #buddypress.buddypress-wrap .activity-list .load-newest a:hover, .buddypress .buddypress-wrap .bp-list.grid .action a:focus, .buddypress .buddypress-wrap .bp-list.grid .action a:hover, .buddypress .buddypress-wrap .bp-list.grid .action button:focus, .buddypress .buddypress-wrap .bp-list.grid .action button:hover, .buddypress .buddypress-wrap .action button:hover, form#bp-data-export button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a:hover, .buddypress .buddypress-wrap button.button:hover, .buddypress .buddypress-wrap button.button.edit:hover, .buddypress .buddypress-wrap .btn-default:hover, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button:hover {
	border-color: {$accent_brightness};
  }

  .cs-btn-outlined-accent {
    color: {$accent} !important;
    border-color: {$accent};
  }

  .cs-btn-3d-accent {
    background-color: {$accent};
    -webkit-box-shadow: 0 0.3em 0 {$accent_darkness};
    box-shadow: 0 0.3em 0 {$accent_darkness};
  }

  .cs-pricing-column-accent .cs-pricing-title{
    background-color: {$accent_darkness};
  }

  select:focus,
  textarea:focus,
  input[type="text"]:focus,
  input[type="password"]:focus,
  input[type="email"]:focus,
  input[type="url"]:focus,
  input[type="search"]:focus {
    border-color: {$accent};
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px {$accent_rgba_06};
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px {$accent_rgba_06};
  }

  ::selection{
    background-color: {$accent};
  }

  ::-moz-selection{
    background-color: {$accent};
  }
CSS;
	} elseif ( $skin == 'custom' ) {

		// top-bar.
		$top_bar_image        = cs_get_option( 'top_bar_image' );
		$top_bar_image_url    = isset( $top_bar_image['background-image']['url'] ) ? $top_bar_image['background-image']['url'] : '';
		$top_bar_repeat       = cs_get_option( 'top_bar_repeat' );
		$top_bar_position     = cs_get_option( 'top_bar_position' );
		$top_bar_attachment   = cs_get_option( 'top_bar_attachment' );
		$top_bar_size         = cs_get_option( 'top_bar_size' );
		$top_bar_bg           = cs_get_option( 'top_bar_bg' );
		$top_bar_border       = cs_get_option( 'top_bar_border' );
		$top_bar_text         = cs_get_option( 'top_bar_text' );
		$top_bar_link         = cs_get_option( 'top_bar_link' );
		$top_bar_link_hover   = cs_get_option( 'top_bar_link_hover' );
		$top_bar_icon_color   = cs_get_option( 'top_bar_icon_color' );
		$top_bar_social_color = cs_get_option( 'top_bar_social_color' );
		$top_bar_social_hover = cs_get_option( 'top_bar_social_hover' );

		if ( ! empty( $top_bar_image ) ) {
			$top_bar_css  = 'background-image: url(' . $top_bar_image_url . ');';
			$top_bar_css .= ( ! empty( $top_bar_repeat ) ) ? 'background-repeat: ' . $top_bar_repeat . ';' : '';
			$top_bar_css .= ( ! empty( $top_bar_position ) ) ? 'background-position: ' . $top_bar_position . ';' : '';
			$top_bar_css .= ( ! empty( $top_bar_attachment ) ) ? 'background-attachment: ' . $top_bar_attachment . ';' : '';
			$top_bar_css .= ( ! empty( $top_bar_size ) ) ? 'background-size: ' . $top_bar_size . ';' : '';
			$top_bar_css .= ( ! empty( $top_bar_bg ) ) ? 'background-color: ' . $top_bar_bg . ';' : '';
		} else {
			$top_bar_css = 'background-color:' . $top_bar_bg . ';';
		}

		// header.
		$header_image         = cs_get_option( 'header_image' );
		$header_image_url     = isset( $header_image['background-image']['url'] ) ? $header_image['background-image']['url'] : '';
		$header_repeat        = cs_get_option( 'header_repeat' );
		$header_position      = cs_get_option( 'header_position' );
		$header_attachment    = cs_get_option( 'header_attachment' );
		$header_size          = cs_get_option( 'header_size' );
		$header_bg            = cs_get_option( 'header_bg' );
		$header_bg_opacity    = cs_hex2rgba( $header_bg, 0.95 );
		$header_border        = cs_get_option( 'header_border' );
		$header_link          = cs_get_option( 'header_link' );
		$header_link_hover    = cs_get_option( 'header_link_hover' );
		$header_link_hover_bg = cs_get_option( 'header_link_hover_bg' );

		if ( ! empty( $header_image ) ) {
			$header_css  = 'background-image: url(' . $header_image_url . ');';
			$header_css .= ( ! empty( $header_repeat ) ) ? 'background-repeat: ' . $header_repeat . ';' : '';
			$header_css .= ( ! empty( $header_position ) ) ? 'background-position: ' . $header_position . ';' : '';
			$header_css .= ( ! empty( $header_attachment ) ) ? 'background-attachment: ' . $header_attachment . ';' : '';
			$header_css .= ( ! empty( $header_size ) ) ? 'background-size: ' . $header_size . ';' : '';
			$header_css .= ( ! empty( $header_bg ) ) ? 'background-color: ' . $header_bg . ';' : '';
		} else {
			$header_css = 'background-color:' . $header_bg . ';';
		}

		$header_link_hover_bg_css = ( ! empty( $header_link_hover_bg ) ) ? 'background-color: ' . $header_link_hover_bg . ';' : '';

		// sub-menu.
		$submenu_bg                 = cs_get_option( 'submenu_bg' );
		$submenu_bg_hover           = cs_get_option( 'submenu_bg_hover' );
		$submenu_border             = cs_get_option( 'submenu_border' );
		$submenu_link               = cs_get_option( 'submenu_link' );
		$submenu_link_hover         = cs_get_option( 'submenu_link_hover' );
		$submenu_mega_title_color   = cs_get_option( 'submenu_mega_title_color' );
		$submenu_mega_title_bgcolor = cs_get_option( 'submenu_mega_title_bgcolor' );
		$submenu_mega_title_border  = cs_get_option( 'submenu_mega_title_border' );

		// page-header.
		$page_header_image      = cs_get_option( 'page_header_image' );
		$page_header_image_url  = isset( $page_header_image['background-image']['url'] ) ? $page_header_image['background-image']['url'] : '';
		$page_header_repeat     = cs_get_option( 'page_header_repeat' );
		$page_header_position   = cs_get_option( 'page_header_position' );
		$page_header_attachment = cs_get_option( 'page_header_attachment' );
		$page_header_size       = cs_get_option( 'page_header_size' );
		$page_header_bg         = cs_get_option( 'page_header_bg' );
		$page_header_color      = cs_get_option( 'page_header_color' );
		$breadcrumb_bgcolor     = cs_hex2rgba( cs_get_option( 'breadcrumb_bgcolor' ), 0.5 );
		$breadcrumb_color       = cs_hex2rgba( cs_get_option( 'breadcrumb_color' ), 0.7 );
		$breadcrumb_link_color  = cs_get_option( 'breadcrumb_link_color' );

		if ( ! empty( $page_header_image ) ) {
			$page_header_css  = 'background-image: url(' . $page_header_image_url . ');';
			$page_header_css .= ( ! empty( $page_header_repeat ) ) ? 'background-repeat: ' . $page_header_repeat . ';' : '';
			$page_header_css .= ( ! empty( $page_header_position ) ) ? 'background-position: ' . $page_header_position . ';' : '';
			$page_header_css .= ( ! empty( $page_header_attachment ) ) ? 'background-attachment: ' . $page_header_attachment . ';' : '';
			$page_header_css .= ( ! empty( $page_header_size ) ) ? 'background-size: ' . $page_header_size . ';' : '';
			$page_header_css .= ( ! empty( $page_header_bg ) ) ? 'background-color: ' . $page_header_bg . ';' : '';
		} else {
			$page_header_css = 'background-color:' . $page_header_bg . ';';
		}

		// footer.
		$footer_image        = cs_get_option( 'footer_image' );
		$footer_image_url    = isset( $footer_image['background-image']['url'] ) ? $footer_image['background-image']['url'] : '';
		$footer_repeat       = cs_get_option( 'footer_repeat' );
		$footer_position     = cs_get_option( 'footer_position' );
		$footer_attachment   = cs_get_option( 'footer_attachment' );
		$footer_size         = cs_get_option( 'footer_size' );
		$footer_bg           = cs_get_option( 'footer_bg' );
		$footer_color        = cs_get_option( 'footer_color' );
		$footer_link_color   = cs_get_option( 'footer_link_color' );
		$footer_link_hover   = cs_get_option( 'footer_link_hover' );
		$footer_title_color  = cs_get_option( 'footer_title_color' );
		$footer_border_color = cs_get_option( 'footer_border_color' );

		if ( ! empty( $footer_image ) ) {
			$footer_css  = 'background-image: url(' . $footer_image_url . ');';
			$footer_css .= ( ! empty( $footer_repeat ) ) ? 'background-repeat: ' . $footer_repeat . ';' : '';
			$footer_css .= ( ! empty( $footer_position ) ) ? 'background-position: ' . $footer_position . ';' : '';
			$footer_css .= ( ! empty( $footer_attachment ) ) ? 'background-attachment: ' . $footer_attachment . ';' : '';
			$footer_css .= ( ! empty( $footer_size ) ) ? 'background-size: ' . $footer_size . ';' : '';
			$footer_css .= ( ! empty( $footer_bg ) ) ? 'background-color: ' . $footer_bg . ';' : '';
		} else {
			$footer_css = 'background-color:' . $footer_bg . ';';
		}

		// footer before and after.
		$footer_ba_image        = cs_get_option( 'footer_ba_image' );
		$footer_ba_url          = isset( $footer_ba_image['background-image']['url'] ) ? $footer_ba_image['background-image']['url'] : '';
		$footer_ba_repeat       = cs_get_option( 'footer_ba_repeat' );
		$footer_ba_position     = cs_get_option( 'footer_ba_position' );
		$footer_ba_attachment   = cs_get_option( 'footer_ba_attachment' );
		$footer_ba_size         = cs_get_option( 'footer_ba_size' );
		$footer_ba_bg           = cs_get_option( 'footer_ba_bg' );
		$footer_ba_color        = cs_get_option( 'footer_ba_color' );
		$footer_ba_link_color   = cs_get_option( 'footer_ba_link_color' );
		$footer_ba_link_hover   = cs_get_option( 'footer_ba_link_hover' );
		$footer_ba_title_color  = cs_get_option( 'footer_ba_title_color' );
		$footer_ba_border_color = cs_get_option( 'footer_ba_border_color' );

		if ( ! empty( $footer_ba_image ) ) {
			$footer_ba_css  = 'background-image: url(' . $footer_ba_url . ');';
			$footer_ba_css .= ( ! empty( $footer_ba_repeat ) ) ? 'background-repeat: ' . $footer_ba_repeat . ';' : '';
			$footer_ba_css .= ( ! empty( $footer_ba_position ) ) ? 'background-position: ' . $footer_ba_position . ';' : '';
			$footer_ba_css .= ( ! empty( $footer_ba_attachment ) ) ? 'background-attachment: ' . $footer_ba_attachment . ';' : '';
			$footer_ba_css .= ( ! empty( $footer_ba_size ) ) ? 'background-size: ' . $footer_ba_size . ';' : '';
			$footer_ba_css .= ( ! empty( $footer_ba_bg ) ) ? 'background-color: ' . $footer_ba_bg . ';' : '';
		} else {
			$footer_ba_css = 'background-color:' . $footer_ba_bg . ';';
		}

		// copyright.
		$copyright_image      = cs_get_option( 'copyright_image' );
		$copyright_url        = isset( $copyright_image['background-image']['url'] ) ? $copyright_image['background-image']['url'] : '';
		$copyright_repeat     = cs_get_option( 'copyright_repeat' );
		$copyright_position   = cs_get_option( 'copyright_position' );
		$copyright_attachment = cs_get_option( 'copyright_attachment' );
		$copyright_size       = cs_get_option( 'copyright_size' );
		$copyright_bg         = cs_get_option( 'copyright_bg' );
		$copyright_color      = cs_get_option( 'copyright_color' );
		$copyright_link_color = cs_get_option( 'copyright_link_color' );
		$copyright_link_hover = cs_get_option( 'copyright_link_hover' );

		if ( ! empty( $copyright_image ) ) {
			$copyright_css  = 'background-image: url(' . $copyright_url . ');';
			$copyright_css .= ( ! empty( $copyright_repeat ) ) ? 'background-repeat: ' . $copyright_repeat . ';' : '';
			$copyright_css .= ( ! empty( $copyright_position ) ) ? 'background-position: ' . $copyright_position . ';' : '';
			$copyright_css .= ( ! empty( $copyright_attachment ) ) ? 'background-attachment: ' . $copyright_attachment . ';' : '';
			$copyright_css .= ( ! empty( $copyright_size ) ) ? 'background-size: ' . $copyright_size . ';' : '';
			$copyright_css .= ( ! empty( $copyright_bg ) ) ? 'background-color: ' . $copyright_bg . ';' : '';
		} else {
			$copyright_css = 'background-color:' . $copyright_bg . ';';
		}

		// logo bar.
		$logo_bar_image      = cs_get_option( 'logo_bar_image' );
		$logo_bar_url        = isset( $logo_bar_image['background-image']['url'] ) ? $logo_bar_image['background-image']['url'] : '';
		$logo_bar_repeat     = cs_get_option( 'logo_bar_repeat' );
		$logo_bar_position   = cs_get_option( 'logo_bar_position' );
		$logo_bar_attachment = cs_get_option( 'logo_bar_attachment' );
		$logo_bar_size       = cs_get_option( 'logo_bar_size' );
		$logo_bar_bg         = cs_get_option( 'logo_bar_bg' );
		$logo_bar_color      = cs_get_option( 'logo_bar_color' );
		$logo_bar_css        = '';

		if ( ! empty( $logo_bar_image ) ) {
			$logo_bar_css .= '#header-logo{';
			$logo_bar_css .= 'color:' . $logo_bar_color . ';';
			$logo_bar_css .= 'background-image: url(' . $logo_bar_url . ');';
			$logo_bar_css .= ( ! empty( $logo_bar_repeat ) ) ? 'background-repeat: ' . $logo_bar_repeat . ';' : '';
			$logo_bar_css .= ( ! empty( $logo_bar_position ) ) ? 'background-position: ' . $logo_bar_position . ';' : '';
			$logo_bar_css .= ( ! empty( $logo_bar_attachment ) ) ? 'background-attachment: ' . $logo_bar_attachment . ';' : '';
			$logo_bar_css .= ( ! empty( $logo_bar_size ) ) ? 'background-size: ' . $logo_bar_size . ';' : '';
			$logo_bar_css .= ( ! empty( $logo_bar_bg ) ) ? 'background-color: ' . $logo_bar_bg . ';' : '';
			$logo_bar_css .= '}';
		} else {
			$logo_bar_css .= '#header-logo{';
			$logo_bar_css .= 'color:' . $logo_bar_color . ';';
			$logo_bar_css .= 'background-color:' . $logo_bar_bg . ';';
			$logo_bar_css .= '}';
		}

		return <<<CSS
{$logo_bar_css}

#top-bar{
  color: {$top_bar_text};
  border-color: {$top_bar_border};
  {$top_bar_css}
}

#top-bar .cs-top-module{
  border-color: {$top_bar_border};
}

#top-bar .cs-top-module > a,
#top-bar .cs-top-module .cs-open-modal{
  color: {$top_bar_link};
}

#top-bar .cs-top-module > a:hover,
#top-bar .cs-top-module .cs-open-modal:hover {
  color: {$top_bar_link_hover};
}

#top-bar .cs-in {
  color: {$top_bar_icon_color};
}

#top-bar .cs-module-social a {
  color: {$top_bar_social_color};
}

#top-bar .cs-module-social a:hover {
  background-color: {$top_bar_social_hover};
}

#top-bar .cs-modal-content-hover,
#top-bar .cs-modal-content{
  border-color: {$top_bar_border};
}

#masthead{
 {$header_css}
}

#masthead.is-compact{
  background-color: {$header_bg_opacity};
}

#cs-mobile-icon,
#site-nav > ul > li > .cs-link,
.bp-msg .bp-icon-wrap,
.user-notifications .bp-icon-wrap,
.cs-mobile-icons-wrapper .cs-menu-cart > a,
#site-nav > ul > li > .cs-link,
#site-nav a.cs-user-link {
  color: {$header_link};
}

#cs-mobile-icon i{
  background-color: {$header_link};
}

#site-nav .current-menu-ancestor > .cs-link,
#site-nav .current-menu-item > .cs-link,
#site-nav > ul > li > .cs-link:hover,
#site-nav a.cs-user-link:hover,
.bp-msg .bp-icon-wrap:hover,
.user-notifications .bp-icon-wrap:hover,
.cs-mobile-icons-wrapper .cs-menu-cart > a:hover {
  color: {$header_link_hover};
  {$header_link_hover_bg_css}
}

#site-nav > ul > li > ul,
#site-nav .cs-modal-content{
  border-color: {$header_link_hover};
}

.cs-header-center #masthead,
.cs-header-center .cs-depth-0,
.cs-header-fancy #masthead,
.cs-header-fancy .cs-depth-0,
.cs-header-left #masthead,
.cs-header-left .cs-depth-0{
  border-color: {$header_border};
}

#site-nav ul li ul .current-menu-ancestor > .cs-link,
#site-nav ul li ul .current-menu-item > .cs-link{
  color: {$submenu_link_hover};
  background-color: {$submenu_bg_hover};
}

#site-nav ul li ul{
  background-color: {$submenu_bg};
}

#site-nav ul li ul li .cs-link{
  color: {$submenu_link};
  background-color: {$submenu_bg};
  border-top-color: {$submenu_border};
}

#site-nav ul li ul li .cs-link:hover{
  color: {$submenu_link_hover};
  background-color: {$submenu_bg_hover};
}

#site-nav .cs-mega-menu > ul > li .cs-link {
  border-right-color: {$submenu_border};
}

#site-nav .cs-mega-menu > ul > li .cs-title:hover,
#site-nav .cs-mega-menu > ul > li .cs-title{
  color: {$submenu_mega_title_color} !important;
  background-color: {$submenu_mega_title_bgcolor} !important;
  border-right-color: {$submenu_mega_title_border} !important;
}

.cs-menu-effect .cs-link-depth-0:before{
  background-color: {$header_link_hover};
}

.cs-menu-effect-4 .cs-link-depth-0:before{
  color: {$header_link_hover};
  text-shadow: 0 0 {$header_link_hover};
}

.cs-menu-effect-4 .cs-link-depth-0:hover::before{
  text-shadow: 8px 0 {$header_link_hover}, -8px 0 {$header_link_hover};
}

.cs-menu-effect-6 .cs-link-depth-0:before{
  border: 2px solid {$header_link_hover};
}

.cs-menu-effect-7 .cs-depth-0:hover .cs-link-depth-0{
  color: {$header_link_hover};
  {$header_link_hover_bg_css}
}

#page-header{
  color: {$page_header_color};
  {$page_header_css}
}

#page-header .page-title{
  color: {$page_header_color};
}

.cs-breadcrumb .cs-inner{
  color: {$breadcrumb_color};
  background-color: {$breadcrumb_bgcolor};
}

.cs-breadcrumb a {
  color: {$breadcrumb_link_color};
}

#colophon{
  color: {$footer_color};
  {$footer_css}
}

#colophon a{
  color: {$footer_link_color};
}

#colophon a:hover{
  color: {$footer_link_hover};
}

#colophon .articlemag_widget .widget-title h4{
  color: {$footer_title_color};
}

#colophon .articlemag_widget ul li,
#colophon .articlemag_widget ul ul{
  border-color: {$footer_border_color};
}

#cs-footer-block-after,
#cs-footer-block-before{
  color: {$footer_ba_color};
  {$footer_ba_css}
}

#cs-footer-block-after a,
#cs-footer-block-before a{
  color: {$footer_ba_link_color};
}

#cs-footer-block-after a:hover,
#cs-footer-block-before a:hover{
  color: {$footer_ba_link_hover};
}

#cs-footer-block-after .articlemag_widget .widget-title h4,
#cs-footer-block-before .articlemag_widget .widget-title h4{
  color: {$footer_ba_title_color};
}

#cs-footer-block-before .articlemag_widget ul li,
#cs-footer-block-after .articlemag_widget ul li,
#cs-footer-block-before .articlemag_widget ul ul,
#cs-footer-block-after .articlemag_widget ul ul{
  border-color: {$footer_ba_border_color};
}

#copyright{
  color: {$copyright_color};
  {$copyright_css}
}

#copyright a{
  color: {$copyright_link_color};
}

#copyright a:hover{
  color: {$copyright_link_hover};
}

.cs-tab .cs-tab-nav ul li a:hover,
.cs-tab .cs-tab-nav ul li.active a,
.cs-toggle-title .cs-in,
.cs-progress-icon .active,
.cs-icon-accent.cs-icon-outlined,
.cs-icon-default,
.cs-faq-filter a.active,
.cs-faq-filter a:hover,
.cs-counter,
.ajax-close:hover,
.isotope-filter a:hover, .isotope-filter a.active,
.cs-accordion-title .cs-in,
#sidebar .widget_nav_menu ul li.current-menu-item > a,
#sidebar .widget_nav_menu ul li a:hover,
.articlemag_widget .widget-title h4,
.articlemag_widget ul li a:hover,
.portfolio-item-description .item-title a:hover,
.cs-lang-top-modal ul li a:hover,
.comment-reply-link,
.related-posts ul li a:hover,
.entry-title a:hover,
.entry-meta a:hover,
.post-navigation a:hover,
.page-pagination a:hover,
a,
.cs-accent-color,
.cs-cart-widget-side .cs-module-woominicart .total .amount,

.buddypress-wrap .bp-navs li.current a, .buddypress-wrap .bp-navs li.selected a, .buddypress.widget .item-options a.selected, .buddypress.widget .item-options a:hover,
.buddypress-wrap .bp-navs li:not(.current) a:focus, .buddypress-wrap .bp-navs li:not(.current) a:hover, .buddypress-wrap .bp-navs li:not(.selected) a:focus, .buddypress-wrap .bp-navs li:not(.selected) a:hover,
nav#object-nav.vertical .selected > a, nav#object-nav.vertical a:hover, .bp-single-vert-nav .item-body:not(#group-create-body) #subnav:not(.tabbed-links) li.current a,
.buddypress-wrap .main-navs:not(.dir-navs) li.selected a, .buddypress-wrap .main-navs:not(.dir-navs) li.current a,.buddypress-wrap .tabbed-links ol li.current a, .buddypress-wrap .tabbed-links ul li.current a,
.buddypress-wrap .bp-navs li.current a, .buddypress-wrap .bp-navs li.current a:focus, .buddypress-wrap .bp-navs li.current a:hover, .buddypress-wrap .bp-navs li.selected a, .buddypress-wrap .bp-navs li.selected a:focus, .buddypress-wrap .bp-navs li.selected a:hover {
  color: {$accent};
}

.dark-mode .cs-top-module > a:hover,
.dark-mode .cs-top-module .cs-open-modal:hover,
.dark-mode #site-logo h1 a:hover,
.dark-mode .entry-title a:hover,
.dark-mode #site-nav > ul > li > .cs-link:hover,
.dark-mode #site-nav a.cs-user-link:hover,
.dark-mode .bp-msg .bp-icon-wrap:hover,
.dark-mode .user-notifications .bp-icon-wrap:hover,
.dark-mode .cs-mobile-icons-wrapper .cs-menu-cart > a:hover,
.dark-mode #site-nav .current-menu-ancestor > .cs-link,
.dark-mode #site-nav .current-menu-item > .cs-link,
.dark-mode #site-nav ul li ul li .cs-link:hover,
.dark-mode #site-nav .cs-notification .sub-menu li a:hover,
.dark-mode ul#bp-userbar li a:hover,
.dark-mode .comment-meta a:hover,
.dark-mode .entry-tags a:hover,
.dark-mode .entry-meta a:hover,
.dark-mode .articlemag_widget ul li a:hover,
.dark-mode .post-navigation a:hover,
.dark-mode .page-pagination a:hover,
.dark-mode #copyright a:hover {
  color: {$accent};
}

.bbp-pagination-links span.current,
#bbp_user_edit_submit,
.bbp-submit-wrapper .button,
.cs-cart-count,
.cs-notification-count,
.cs-tab .cs-tab-nav ul li.active a:after,
.cs-progress-bar,
.cs-pricing-column-accent .cs-pricing-price,
.cs-icon-accent.cs-icon-bordered,
.cs-icon-accent.cs-icon-bgcolor,
.cs-highlight,
.cs-fancybox-accent.cs-fancybox-bgcolor,
.cs-cta-bgcolor,
.cs-btn-outlined-accent:hover,
.cs-btn-flat-accent,
.page-pagination .current,
.widget_calendar tbody a,
#sidebar .widget_nav_menu ul li.current-menu-item > a:after,
.ajax-pagination .cs-loader:after,
.cs-accent-background,
.widget_price_filter .ui-slider .ui-slider-handle,
.articlemag_widget .widget-title h4:after,

#buddypress .comment-reply-link, #buddypress .generic-button a, #buddypress .standard-form button, #buddypress a.button, #buddypress input[type="button"], #buddypress input[type="reset"]:not(.text-button), #buddypress input[type="submit"], #buddypress ul.button-nav li a, a.bp-title-button, #buddypress.buddypress-wrap .activity-list .load-more a, #buddypress.buddypress-wrap .activity-list .load-newest a, .buddypress .buddypress-wrap .bp-list.grid .action a, .buddypress .buddypress-wrap .bp-list.grid .action button, .buddypress .buddypress-wrap .action button, form#bp-data-export button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a, .buddypress .buddypress-wrap button.button, .buddypress .buddypress-wrap button.button.edit, .buddypress .buddypress-wrap .btn-default, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button,
.buddypress-wrap .bp-navs li.current a .count, .buddypress-wrap .bp-navs li.dynamic.current a .count, .buddypress-wrap .bp-navs li.selected a .count, .buddypress_object_nav .bp-navs li.current a .count, .buddypress_object_nav .bp-navs li.selected a .count {
  background-color: {$accent};
}

.bbp-pagination-links span.current,
.cs-icon-accent.cs-icon-outlined,
.cs-icon-accent.cs-icon-outer,
.cs-faq-filter a.active,
.cs-fancybox-outlined,
.cs-cta-outlined,
blockquote,
.ajax-close:hover,
.isotope-filter a:hover, .isotope-filter a.active,
.page-pagination .current,
.cs-accent-border,
.widget_price_filter .ui-slider .ui-slider-handle,
  
#copyright .cs-powered-by,
#buddypress .comment-reply-link, #buddypress .generic-button a, #buddypress .standard-form button, #buddypress a.button, #buddypress input[type="button"], #buddypress input[type="reset"]:not(.text-button), #buddypress input[type="submit"], #buddypress ul.button-nav li a, a.bp-title-button, #buddypress.buddypress-wrap .activity-list .load-more a, #buddypress.buddypress-wrap .activity-list .load-newest a, .buddypress .buddypress-wrap .bp-list.grid .action a, .buddypress .buddypress-wrap .bp-list.grid .action button, .buddypress .buddypress-wrap .action button, form#bp-data-export button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a, .buddypress .buddypress-wrap button.button, .buddypress .buddypress-wrap button.button.edit, .buddypress .buddypress-wrap .btn-default, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button,
.buddypress-wrap .bp-navs li.current a, .buddypress-wrap .bp-navs li.selected a,
ul#bp-userbar {
  border-color: {$accent};
}
  
.activity-list .activity-item .activity-content > .activity-meta.action .button:hover,
.activity-list .activity-item .activity-content > .bp-generic-meta.action .button:hover {
  border-color: {$accent} !important;
}

#bbp_user_edit_submit:hover,
.bbp-submit-wrapper .button:hover,
.cs-btn-flat-accent:hover,

#buddypress .comment-reply-link:hover, #buddypress .generic-button a:hover, #buddypress .standard-form button:hover, #buddypress a.button:hover, #buddypress input[type="button"]:hover, #buddypress input[type="reset"]:not(.text-button):hover, #buddypress input[type="submit"]:hover, #buddypress ul.button-nav li a:hover, a.bp-title-button:hover, #buddypress.buddypress-wrap .activity-list .load-more a:hover, #buddypress.buddypress-wrap .activity-list .load-newest a:hover, .buddypress .buddypress-wrap .bp-list.grid .action a:focus, .buddypress .buddypress-wrap .bp-list.grid .action a:hover, .buddypress .buddypress-wrap .bp-list.grid .action button:focus, .buddypress .buddypress-wrap .bp-list.grid .action button:hover, .buddypress .buddypress-wrap .action button:hover, form#bp-data-export button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a:hover, .buddypress .buddypress-wrap button.button:hover, .buddypress .buddypress-wrap button.button.edit:hover, .buddypress .buddypress-wrap .btn-default:hover, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button:hover {
  background-color: {$accent_brightness};
}

#buddypress .comment-reply-link:hover, #buddypress .generic-button a:hover, #buddypress .standard-form button:hover, #buddypress a.button:hover, #buddypress input[type="button"]:hover, #buddypress input[type="reset"]:not(.text-button):hover, #buddypress input[type="submit"]:hover, #buddypress ul.button-nav li a:hover, a.bp-title-button:hover, #buddypress.buddypress-wrap .activity-list .load-more a:hover, #buddypress.buddypress-wrap .activity-list .load-newest a:hover, .buddypress .buddypress-wrap .bp-list.grid .action a:focus, .buddypress .buddypress-wrap .bp-list.grid .action a:hover, .buddypress .buddypress-wrap .bp-list.grid .action button:focus, .buddypress .buddypress-wrap .bp-list.grid .action button:hover, .buddypress .buddypress-wrap .action button:hover, form#bp-data-export button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content button:hover, body.bp-nouveau.media #buddypress div#item-header div#item-header-content a:hover, .buddypress .buddypress-wrap button.button:hover, .buddypress .buddypress-wrap button.button.edit:hover, .buddypress .buddypress-wrap .btn-default:hover, .buddypress .buddypress-wrap button.gamipress-achievement-unlock-with-points-button:hover {
  border-color: {$accent_brightness};
}

.cs-btn-outlined-accent {
  color: {$accent} !important;
  border-color: {$accent};
}

.cs-btn-3d-accent {
  background-color: {$accent};
  -webkit-box-shadow: 0 0.3em 0 {$accent_darkness};
  box-shadow: 0 0.3em 0 {$accent_darkness};
}

.cs-pricing-column-accent .cs-pricing-title{
  background-color: {$accent_darkness};
}

select:focus,
textarea:focus,
input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="search"]:focus {
  border-color: {$accent};
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px {$accent_rgba_06};
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px {$accent_rgba_06};
}

::selection{
  background-color: {$accent};
}

::-moz-selection{
  background-color: {$accent};
}
CSS;
	} else {
		return;
	}
}

function cs_get_woocoomerce_style() {

	if ( is_woocommerce_activated() ) {

		$accent            = ( cs_get_option( 'accent_color' ) ) ? cs_get_option( 'accent_color' ) : '#e9425d';
		$accent_brightness = cs_brightness( $accent, 0.7901 );

		return <<<CSS

  .woocommerce .button,
  .woocommerce-page .button,
  .woocommerce-Reviews .form-submit input[type=submit]{
    background-color: {$accent};
  }

  .woocommerce .button:hover,
  .woocommerce-page .button:hover,
  .woocommerce-Reviews .form-submit input[type=submit]:hover{
    background-color: {$accent_brightness};
  }

  .woocommerce .cs-btn-outlined.button,
  .woocommerce-page .cs-btn-outlined.button{
    color: {$accent};
    border-color: {$accent};
    background-color: transparent;
  }

  .woocommerce .cs-btn-outlined.button:hover,
  .woocommerce-page .cs-btn-outlined.button:hover{
    background-color: {$accent};
  }

CSS;
	} else {
		return;
	}
}
