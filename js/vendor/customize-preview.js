/**
 *
 * Live-update changed settings in real time in the Customizer preview.
 *
 */
;(function ( $, wp, window, document, undefined ) {

  if ( wp && wp.customize ) {

    api = wp.customize;

    //
    // Top Bar
    // ------------------------------------
    var $top_bar = $('#top-bar');

    api( 'customize_option[top_bar_image]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'background-image': 'url('+ to +')' });
      });
    });

    api( 'customize_option[top_bar_repeat]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'background-repeat': to });
      });
    });

    api( 'customize_option[top_bar_position]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'background-position': to });
      });
    });

    api( 'customize_option[top_bar_attachment]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'background-attachment': to });
      });
    });

    api( 'customize_option[top_bar_size]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'background-size': to });
      });
    });

    api( 'customize_option[top_bar_bg]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'background-color': to });
      });
    });

    api( 'customize_option[top_bar_border]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'border-color': to });
        $top_bar.find('.cs-top-module').css({ 'border-color': to });
      });
    });

    api( 'customize_option[top_bar_text]', function( value ) {
      value.bind( function( to ) {
        $top_bar.css({ 'color': to });
      });
    });


    //
    // Header
    // ------------------------------------
    var $header = $('#masthead');

    api( 'customize_option[header_image]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'background-image': 'url('+ to +')' });
      });
    });

    api( 'customize_option[header_repeat]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'background-repeat': to });
      });
    });

    api( 'customize_option[header_position]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'background-position': to });
      });
    });

    api( 'customize_option[header_attachment]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'background-attachment': to });
      });
    });

    api( 'customize_option[header_size]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'background-size': to });
      });
    });

    api( 'customize_option[header_bg]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'background-color': to });
      });
    });

    api( 'customize_option[header_color]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'color': to });
      });
    });

    api( 'customize_option[header_border]', function( value ) {
      value.bind( function( to ) {
        $header.css({ 'border-color': to });
        $('.cs-header-left .cs-depth-0, .cs-header-fancy .cs-depth-0').css({ 'border-color': to });
      });
    });

    //
    // Footer
    // ------------------------------------
    var $page_header = $('#page-header');

    api( 'customize_option[page_header_image]', function( value ) {
      value.bind( function( to ) {
        $page_header.css({ 'background-image': 'url('+ to +')' });
      });
    });

    api( 'customize_option[page_header_repeat]', function( value ) {
      value.bind( function( to ) {
        $page_header.css({ 'background-repeat': to });
      });
    });

    api( 'customize_option[page_header_position]', function( value ) {
      value.bind( function( to ) {
        $page_header.css({ 'background-position': to });
      });
    });

    api( 'customize_option[page_header_attachment]', function( value ) {
      value.bind( function( to ) {
        $page_header.css({ 'background-attachment': to });
      });
    });

    api( 'customize_option[page_header_size]', function( value ) {
      value.bind( function( to ) {
        $page_header.css({ 'background-size': to });
      });
    });

    api( 'customize_option[page_header_bg]', function( value ) {
      value.bind( function( to ) {
        $page_header.css({ 'background-color': to });
      });
    });

    api( 'customize_option[page_header_color]', function( value ) {
      value.bind( function( to ) {
        $page_header.find('.page-title').css({ 'color': to });
      });
    });

    //
    // Breadcrumb
    // ------------------------------------
    var $breadcrumb = $('.cs-breadcrumb .cs-inner')

    api( 'customize_option[breadcrumb_bgcolor]', function( value ) {
      value.bind( function( to ) {
        $breadcrumb.css({ 'background-color': to });
      });
    });

    api( 'customize_option[breadcrumb_color]', function( value ) {
      value.bind( function( to ) {
        $breadcrumb.css({ 'color': to });
      });
    });

    //
    // Footer
    // ------------------------------------
    var $colophon = $('#colophon');

    api( 'customize_option[footer_image]', function( value ) {
      value.bind( function( to ) {
        $colophon.css({ 'background-image': 'url('+ to +')' });
      });
    });

    api( 'customize_option[footer_repeat]', function( value ) {
      value.bind( function( to ) {
        $colophon.css({ 'background-repeat': to });
      });
    });

    api( 'customize_option[footer_position]', function( value ) {
      value.bind( function( to ) {
        $colophon.css({ 'background-position': to });
      });
    });

    api( 'customize_option[footer_attachment]', function( value ) {
      value.bind( function( to ) {
        $colophon.css({ 'background-attachment': to });
      });
    });

    api( 'customize_option[footer_size]', function( value ) {
      value.bind( function( to ) {
        $colophon.css({ 'background-size': to });
      });
    });

    api( 'customize_option[footer_bg]', function( value ) {
      value.bind( function( to ) {
        $colophon.css({ 'background-color': to });
      });
    });

    api( 'customize_option[footer_color]', function( value ) {
      value.bind( function( to ) {
        $colophon.css({ 'color': to });
      });
    });

    api( 'customize_option[footer_title_color]', function( value ) {
      value.bind( function( to ) {
        $colophon.find('.widget-title h4').css({ 'color': to });
      });
    });

    api( 'customize_option[footer_border_color]', function( value ) {
      value.bind( function( to ) {
        $colophon.find('.articlemag_widget ul li').css({ 'border-color': to });
      });
    });

    //
    // Footer Before and After
    // ------------------------------------
    var $footer_ba = $('#cs-footer-block-before, #cs-footer-block-after');

    api( 'customize_option[footer_ba_image]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.css({ 'background-image': 'url('+ to +')' });
      });
    });

    api( 'customize_option[footer_ba_repeat]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.css({ 'background-repeat': to });
      });
    });

    api( 'customize_option[footer_ba_position]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.css({ 'background-position': to });
      });
    });

    api( 'customize_option[footer_ba_attachment]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.css({ 'background-attachment': to });
      });
    });

    api( 'customize_option[footer_ba_size]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.css({ 'background-size': to });
      });
    });

    api( 'customize_option[footer_ba_bg]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.css({ 'background-color': to });
      });
    });

    api( 'customize_option[footer_ba_color]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.css({ 'color': to });
      });
    });

    api( 'customize_option[footer_ba_title_color]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.find('.widget-title h4').css({ 'color': to });
      });
    });

    api( 'customize_option[footer_ba_border_color]', function( value ) {
      value.bind( function( to ) {
        $footer_ba.find('.articlemag_widget ul li').css({ 'border-color': to });
      });
    });

    //
    // Copyright
    // ------------------------------------
    var $copyright = $('#copyright');

    api( 'customize_option[copyright_image]', function( value ) {
      value.bind( function( to ) {
        $copyright.css({ 'background-image': 'url('+ to +')' });
      });
    });

    api( 'customize_option[copyright_repeat]', function( value ) {
      value.bind( function( to ) {
        $copyright.css({ 'background-repeat': to });
      });
    });

    api( 'customize_option[copyright_position]', function( value ) {
      value.bind( function( to ) {
        $copyright.css({ 'background-position': to });
      });
    });

    api( 'customize_option[copyright_attachment]', function( value ) {
      value.bind( function( to ) {
        $copyright.css({ 'background-attachment': to });
      });
    });

    api( 'customize_option[copyright_size]', function( value ) {
      value.bind( function( to ) {
        $copyright.css({ 'background-size': to });
      });
    });

    api( 'customize_option[copyright_bg]', function( value ) {
      value.bind( function( to ) {
        $copyright.css({ 'background-color': to });
      });
    });

    api( 'customize_option[copyright_color]', function( value ) {
      value.bind( function( to ) {
        $copyright.css({ 'color': to });
      });
    });


    //
    // Logo Bar
    // ------------------------------------
    var $logo_bar = $('#header-logo');

    api( 'customize_option[logo_bar_image]', function( value ) {
      value.bind( function( to ) {
        $logo_bar.css({ 'background-image': 'url('+ to +')' });
      });
    });

    api( 'customize_option[logo_bar_repeat]', function( value ) {
      value.bind( function( to ) {
        $logo_bar.css({ 'background-repeat': to });
      });
    });

    api( 'customize_option[logo_bar_position]', function( value ) {
      value.bind( function( to ) {
        $logo_bar.css({ 'background-position': to });
      });
    });

    api( 'customize_option[logo_bar_attachment]', function( value ) {
      value.bind( function( to ) {
        $logo_bar.css({ 'background-attachment': to });
      });
    });

    api( 'customize_option[logo_bar_size]', function( value ) {
      value.bind( function( to ) {
        $logo_bar.css({ 'background-size': to });
      });
    });

    api( 'customize_option[logo_bar_bg]', function( value ) {
      value.bind( function( to ) {
        $logo_bar.css({ 'background-color': to });
      });
    });

    api( 'customize_option[logo_bar_color]', function( value ) {
      value.bind( function( to ) {
        $logo_bar.css({ 'color': to });
      });
    });

  }

})( jQuery, wp, window, document );
