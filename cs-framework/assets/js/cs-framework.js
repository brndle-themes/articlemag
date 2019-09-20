// the semi-colon before the function invocation is a safety
// net against concatenated scripts and/or other plugins
// that are not closed properly.
// set root Object
;(function ( $, window, document, undefined ) {
  'use strict';

  // ======================================================
  if ( !$.ARTICLEMAGWP ) {
    $.ARTICLEMAGWP = {};
  }
  // ======================================================


  // ======================================================
  // ARTICLEMAGWP MEGA MENU
  // ======================================================
  $.ARTICLEMAGWP.megamenu = function( el ){
    var base  = this;

    // Access to jQuery and DOM versions of element
    base.$el  = $(el);
    base.el   = el;

    // Add a reverse reference to the DOM object
    base.$el.data( "ARTICLEMAGWP.megamenu" , base );

    base.init = function () {

      var _timeout  = 0,
          _menu     = base.$el;

      _menu.on('click', '.is-mega', function(){
        base.flush( $(this) );
        base.depends( _menu );
      });

      _menu.on( 'mouseup', '.menu-item-bar', function(){
        clearTimeout( _timeout );
        _timeout = setTimeout( function(){ base.depends(); }, 50 );
      });

      _menu.on('change', '.is-width', function(){
        var _this       = $(this),
            _container  = _this.closest('.cs-mega-menu');

        if( _this.val() == 'custom' || _this.val() == 'natural' ) {
          _container.find('.mega-depend-position').removeClass('hidden');
        } else {
          _container.find('.mega-depend-position').addClass('hidden');
        }

        if( _this.val() == 'custom' ) {
          _container.find('.mega-depend-width').removeClass('hidden');
        } else {
          _container.find('.mega-depend-width').addClass('hidden');
        }
      });

      $('.is-width').trigger('change');

      base.depends();
    };

    base.depends = function(){

      var _menu = base.$el;

      _menu.find('.is-mega').each(function (){
        base.flush( $(this) );
      });

      // clear all mega columns
      $('li', _menu).removeClass('active-mega-column').removeClass('active-sub-mega-column');

      // add columns for mega menu
      var nextDepth = $('.active-mega-menu', _menu).nextUntil('.menu-item-depth-0', 'li');
      nextDepth.closest('li.menu-item-depth-1').addClass('active-mega-column');
      nextDepth.closest('li:not(.menu-item-depth-1)').addClass('active-sub-mega-column');
    };

    base.flush = function( _el ){
      if( _el.is(':checked') ){
        _el.closest('li').addClass('active-mega-menu');
        _el.closest('li').find('.field-mega-width').removeClass('hidden');
      }else{
        _el.closest('li').find('.field-mega-width').addClass('hidden');
        _el.closest('li').removeClass('active-mega-menu');
      }
    };

    // Run initializer
    base.init();
  };
  $.fn.ARTICLEMAGWP_megamenu = function () {
    return this.each(function () {
      new $.ARTICLEMAGWP.megamenu( this );
    });
  };
  // ======================================================


  // ======================================================
  // ARTICLEMAGWP DEPENDENCY
  // ======================================================
  $.ARTICLEMAGWP.dependency = function( el, param ){
    var base  = this;

    // Access to jQuery and DOM versions of element
    base.$el  = $(el);
    base.el   = el;

    // Add a reverse reference to the DOM object
    base.$el.data( "ARTICLEMAGWP.dependency" , base );

    base.init = function () {
      base.ruleset = $.deps.createRuleset();

      // required for shortcode attrs
      var cfg = {
        show: function( el ){
          el.removeClass('hidden');
        },
        hide: function( el ){
          el.addClass('hidden');
        },
        log : false,
        checkTargets: false
      };

      if( param !== undefined ){
        base.depSub();
      }else{
        base.depRoot();
      }

      $.deps.enable( base.$el, base.ruleset, cfg );
    };

    base.depRoot = function(){

      base.$el.each( function(){
        var _elem = $(this);
        _elem.find('[data-controller]').each( function(){
          var _this         = $(this),
              _dependElem   = _this.data('controller'),
              _dependRule   = _this.data('condition'),
              _dependValue  = _this.data('value'),
              _dependTarget = _elem.find('[data-depend-id="' + _dependElem + '"]');
          base.ruleset.createRule( _dependTarget , _dependRule, _dependValue).include( _this );
        });
      });

    };

    base.depSub = function(){

      base.$el.each( function(){
        var _elem = $(this);
        _elem.find('[data-sub-controller]').each( function(){
          var _this     = $(this),
            _dependElem   = _this.data('sub-controller'),
            _dependRule   = _this.data('sub-condition'),
            _dependValue  = _this.data('sub-value'),
            _dependTarget = _elem.find('[data-depend-id="' + _dependElem + '"]');
          base.ruleset.createRule( _dependTarget , _dependRule, _dependValue).include( _this );
        });
      });

    };

    // Run initializer
    base.init();
  };

  $.fn.ARTICLEMAGWP_dependency = function ( param ) {
    return this.each(function () {
      new $.ARTICLEMAGWP.dependency( this, param );
    });
  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP SHORTCODE MANAGER
  // ======================================================
  $.ARTICLEMAGWP.shortcodeManager = function( el ){
    var base  = this;

    // Access to jQuery and DOM versions of element
    base.$el  = $(el);
    base.el   = el;
    base.win  = $(window);

    // Add a reverse reference to the DOM object
    base.$el.data( "ARTICLEMAGWP.shortcodeManager" , base );

    base.init = function () {

      var shortcodeOverlay  = $('#shortcode-overlay'),
        shortcodeDialog     = $('#shortcode-dialog'),
        shortcodeInsert     = shortcodeDialog.find('#shortcode-insert'),
        shortcodeLoad       = shortcodeDialog.find('#shortcode-load'),
        shortcodeSelector   = shortcodeDialog.find('#shortcode-select'),
        dialog_height       = ( $(window).height() <= 700 ) ? 500 : 700,
        shortcode_name,
        shortcode_view,
        shortcode_clone,
        shortcode_textarea,
        shortcode_target,
        shortcode_gutenberg;

      $(document.body).on('click', '.shortcode-button, .gutenberg-shortcode-button', function( e ) {
        e.preventDefault();

        var _this = $(this),
          _target = _this.data('target');

        shortcode_target = _target;
        shortcode_textarea = _this;

        if( _this.hasClass('gutenberg-shortcode-button') ) {
          shortcode_gutenberg = true;
        }

        // init jquery ui-dialog
        shortcodeDialog.dialog({
          dialogClass: 'wp-dialog cs-shortcode-dialog',
          width: 850,
          height: dialog_height,
          closeOnEscape: true,
          create: function(){
            $('.ui-dialog-titlebar-close').addClass('ui-button');
          },
          open: function() {
            shortcodeLoad.height( parseInt(dialog_height - 195) );
            shortcodeOverlay.show();
          },
          close: function() {
            shortcode_target = undefined;
            shortcode_gutenberg = false;
            shortcodeOverlay.hide();
          },
          resize: function( event, ui ) {
            shortcodeLoad.height( parseInt(ui.size.height - 195) );
          }
        });

      });

      shortcodeOverlay.click( function( e ) {
        e.preventDefault();
        shortcodeOverlay.hide();
        shortcodeDialog.dialog( 'close' );
      });

      shortcodeSelector.on( 'change', function() {

        var elem_this   = $(this);
        shortcode_name  = elem_this.val();
        shortcode_view  = elem_this.find(':selected').data('view');

        // check val
        if( shortcode_name.length ){

          $.ajax({
            type  : 'POST',
            url   : ajaxurl,
            data  : { action: 'get-shortcode', shortcode: shortcode_name },
            success : function( content ) {
              shortcodeLoad.html( content );
              shortcodeInsert.parent().removeClass('hidden');

              shortcode_clone = $('.shortcode-clone', shortcodeDialog).clone();

              // reloadPlugins
              shortcodeLoad.ARTICLEMAGWP_dependency();
              shortcodeLoad.ARTICLEMAGWP_dependency('sub');
              $.reloadPlugins();
            }
          });

        }else{
          shortcodeInsert.parent().addClass('hidden');
          shortcodeLoad.html('');
        }

      });

      shortcodeInsert.click( function(e){

        e.preventDefault();

        // set variables
        var send_to_shortcode = '', ruleAttr = 'data-atts', cloneAttr = 'data-clone-atts', cloneID = 'data-clone-id';

        switch ( shortcode_view ){

          case 'normal':
          case 'single':

            send_to_shortcode += '[' + shortcode_name;

            $('[' + ruleAttr + ']', '#shortcode-load .cs-element-wrap:not(.hidden)').each( function(){

              var _this = $(this), _atts = _this.data('atts');

              // is not attr content, add shortcode attribute else write content and close shortcode tag
              if( _atts != 'content' ){
                send_to_shortcode += base.validate_atts( _atts, _this ); // validate empty atts
              }else if ( _atts == 'content' ){
                send_to_shortcode += ']';
                send_to_shortcode += _this.val();
                send_to_shortcode += '[/'+shortcode_name+'';
              }

            });

            send_to_shortcode += ']';

          break;

          case 'contents':

            $('[' + ruleAttr + ']', '#shortcode-load').each( function(){
              var _this = $(this), _atts = _this.data('atts');
              send_to_shortcode += '['+_atts+']';
              send_to_shortcode += _this.val();
              send_to_shortcode += '[/'+_atts+']';
            });

          break;

          case 'flexible':

            // main-shortcode begin
            send_to_shortcode += '[' + shortcode_name;

            // main-shortcode attributes begin
            $('[' + ruleAttr + ']', '#shortcode-load .cs-element-wrap:not(.hidden)').each( function(){
              var _this_main = $(this), _this_main_atts = _this_main.data('atts');
              send_to_shortcode += base.validate_atts( _this_main_atts, _this_main );  // validate empty atts
            });

            send_to_shortcode += ']';
            // main-shortcode attributes end

            // multiple-shortcode each begin
            $('[' + cloneID + ']', '#shortcode-load').each( function(){

                // multiple-shortcode begin
                var _this_clone = $(this), _clone_id = _this_clone.data('clone-id');

                send_to_shortcode += '[' + _clone_id;

                // multiple-shortcode attributes begin
                $('[' + cloneAttr + ']', _this_clone.find('.cs-element-wrap').not('.hidden') ).each( function(){

                  var _this_multiple = $(this), _atts_multiple = _this_multiple.data('clone-atts');

                  // is not attr content, add shortcode attribute else write content and close shortcode tag
                  if( _atts_multiple != 'content' ){
                    send_to_shortcode += base.validate_atts( _atts_multiple, _this_multiple ); // validate empty atts
                  }else if ( _atts_multiple == 'content' ){
                    send_to_shortcode += ']';
                    send_to_shortcode += _this_multiple.val();
                    send_to_shortcode += '[/'+_clone_id+'';
                  }
                });
                // multiple-shortcode attributes end

                send_to_shortcode += ']';
                // multiple-shortcode end

            });
            // multiple-shortcode each end

            send_to_shortcode += '[/' + shortcode_name + ']';
            // main-shortcode end

          break;

        }

        if( shortcode_gutenberg ) {

          var originalText = window.articlemagShortcodeBlock.attributes.hasOwnProperty('shortcode') ? window.articlemagShortcodeBlock.attributes.shortcode : '';
          window.articlemagShortcodeBlock.setAttributes({shortcode: originalText + send_to_shortcode});
          shortcode_gutenberg = false;

        } else {

          if( shortcode_target !== undefined ) {

            var _parent = shortcode_textarea.parent().parent();
            var textarea_target = $('#' + shortcode_target);

            if( _parent.hasClass('cs_field_textarea') ) {
              textarea_target = _parent.find('textarea');
            }

            textarea_target.val( base.insertAtChars( textarea_target, send_to_shortcode ) );

          }else{
            window.send_to_editor( send_to_shortcode );
          }

        }

        shortcodeDialog.dialog( 'close' );

      });


      // cloner button
      var i = 0;
      shortcodeDialog.on('click', '#shortcode-clone', function( e ){

        e.preventDefault();
        // clone from cache
        var cloned_el = shortcode_clone.clone().hide();
          cloned_el.find('input:radio').attr('name', '_nonce_' + i);

        $('.shortcode-clone:last').after( cloned_el );

        // add - remove effects
        cloned_el.slideDown(100);
        cloned_el.find('.remove-clone').show().click( function( e ){
          cloned_el.slideUp(100, function(){ cloned_el.remove(); });
          e.preventDefault();
        });

        // reloadPlugins
        cloned_el.ARTICLEMAGWP_dependency('sub');
        $.reloadPlugins();
        i++;

      });

    };

    base.validate_atts = function(  _atts, _this ) {

      var el_value;

      if ( _this.closest('.pseudo-field').hasClass('hidden') === true ){ return ''; }
      if ( _this.hasClass('pseudo') === true ){ return ''; }

      if( _this.is(':checkbox') || _this.is(':radio') ){
        el_value = _this.is(':checked') ? _this.val() : '';
      }else{
        el_value = _this.val();
      }

      // return if valid
      if( el_value !== null && el_value !== undefined && el_value !== '' ){
        return ' ' + _atts + '="' + el_value + '"';
      }
      return '';

    };

    base.insertAtChars = function( _this, currentValue ){

      var obj = ( typeof _this[0].name !='undefined' ) ? _this[0] : _this;

      if ( $.browser.mozilla || $.browser.webkit ) {
        obj.focus();
        return obj.value.substring( 0, obj.selectionStart ) + currentValue + obj.value.substring( obj.selectionEnd, obj.value.length );
      } else {
        obj.focus();
        return currentValue;
      }

    };

    // Run initializer
    base.init();
  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP JQUERY UI SLIDER
  // ======================================================
  $.fn.ARTICLEMAGWP_slider = function () {
    return this.each(function () {

      var sliders   = $(this),
          slider_ui = sliders.find('.ui-slider-block');

      slider_ui.slider({
        range  : 'min',
        min    : slider_ui.data('min'),
        max    : slider_ui.data('max'),
        step   : slider_ui.data('step'),
        slide  : function (event, ui) {
          sliders.find('input').val( ui.value );
        },
        create : function(event, ui){
          slider_ui.slider('value', sliders.find('input').val() );
        }
      });

      sliders.find('input').on('keyup', function(){
        slider_ui.slider('value', sliders.find('input').val() );
      });

    });
  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP JQUERY UI SPINNER
  // ======================================================
  $.fn.ARTICLEMAGWP_spinner = function() {
    return this.each(function( options ) {

      var spinner = $(this);

      spinner.spinner({
        range : 'min',
        min   : spinner.data('min'),
        max   : spinner.data('max'),
        step  : spinner.data('step'),
        icons : {
          up  : "dashicons dashicons-arrow-up",
          down: "dashicons dashicons-arrow-down"
        },
        stop  : function( event, ui ) {
          spinner.trigger("keyup");
        }
      });

    });

  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP IMAGE SELECTOR
  // ======================================================
  $.fn.ARTICLEMAGWP_imageSelector = function() {
    return this.each(function() {

      // extending default settings
      var labels = $(this);

      $('label', labels).each( function (){

        var label = $(this);

        if ( label.find("input").is(":checked") ){ label.addClass('selected'); }

        label.bind('click', function(){

          var element = $(this);

          if ( element.find("input").is(":checked") ){
            element.addClass('selected').siblings().removeClass("selected");
          }else{
            element.removeClass('selected');
            element.parent().find("input").each(function(){ $(this).attr("checked", false); });
          }

        });

      });

    });
  };
  // ======================================================

  // ======================================================
  // ARTICLEMAGWP MEDIA UPLOADER / UPLOAD
  // ======================================================
  $.fn.ARTICLEMAGWP_upload = function() {
    return this.each(function() {

      // extending default settings
      var el          = $(this),
        media_upload  = el.find('.cs-add-media'),
        media_remove  = el.find('.cs-button-remove'),
        media_preview = el.find('.cs-upload-preview'),
        send_val      = el.find('input.media-attachment'),
        send_detail   = el.find('input.media-details'),
        media_thumbnail,
        frame;

      media_upload.click( function( event ) {

        event.preventDefault();

        // Check if the `wp.media.gallery` API exists.
        if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.gallery ){
          return;
        }

        // If the media frame already exists, reopen it.
        if ( frame ) {
          frame.open();
          return;
        }

        // Create the media frame.
        frame = wp.media.frames.customUpload = wp.media({

          // Set the title of the modal.
          title: media_upload.data('frame-title'),

          // Tell the modal to show only images.
          library: {
            type: media_upload.data('upload-type')
          },

          // Customize the submit button.
          button: {
            // Set the text of the button.
            text: media_upload.data('insert-title'),
          }

        });

        // When an image is selected, run a callback.
        frame.on( 'select', function() {

          // Grab the selected attachment.
          var attachment = frame.state().get('selection').first(), return_method = media_upload.data('return');

          send_val.val( attachment.attributes[return_method] ).trigger('keyup');

          if ( send_detail.length ) {
            send_detail.val( attachment.attributes.id + ',' + attachment.attributes.width + ',' + attachment.attributes.height );
          }

          if ( media_preview.length ) {
            media_thumbnail = ( attachment.attributes.sizes !== undefined && attachment.attributes.sizes.thumbnail !== undefined ) ? attachment.attributes.sizes.thumbnail.url : attachment.attributes.url;
            media_preview.html( '<a href="'+ attachment.attributes.url +'" target="_blank"><img src="'+ media_thumbnail +'" alt=""/></a>' );
            media_remove.removeClass('hidden');
          }

        });

        // Finally, open the modal.
        frame.open();

      });

      media_remove.click( function( event ) {

        event.preventDefault();

        send_val.val('');

        if ( media_preview.length ) {
          media_preview.html('');
          media_remove.addClass('hidden');
        }

        if ( send_detail.length ) {
          send_detail.val('');
        }

      });

    });

  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP TYPOGRAPHY
  // ======================================================
  $.fn.ARTICLEMAGWP_typography = function() {
    return this.each(function() {

      // extending default settings
      var typography          = $(this),
          typography_select   = typography.find('.typography-select'),
          variants_select     = typography.find('.typography-variant-select'),
          googlefonts_link    = typography.find('.typography-googlefonts-link'),
          typography_variants = null;

      typography_select.unbind('change').bind('change',function(){

        var _this          = $(this),
            _type          = _this.find(':selected').data('type'),
            _current       = _this.find(':selected').val(),
            _variants_opts = typography.find('.typography-variant-select option');

        switch( _type ){

          case 'customfonts':

            typography_variants = {
              '400': 'regular',
            };

            _variants_opts.remove();

            $.each( typography_variants, function( key, text ) {
              variants_select.append('<option value="'+ key +'">'+ text +'</option>');
            });

          break;

          case 'safefonts':

            typography_variants = {
              '400': 'regular',
              '400italic': 'italic',
              '700': '700',
              '700italic': '700italic',
              'inherit': 'inherit'
            };

            _variants_opts.remove();

            $.each( typography_variants, function( key, text ) {
              variants_select.append('<option value="'+ key +'">'+ text +'</option>');
            });

          break;

          case 'googlefonts':

            typography_variants = cs_google_fonts[_current];

            _variants_opts.remove();

            $.each( typography_variants, function( key, value ) {
              variants_select.append('<option value="'+ value +'">'+ value +'</option>');
            });

            variants_select.find('option[value="regular"]').attr('selected', 'selected');

          break;
        }

        variants_select.trigger("chosen:updated");

      });

    });
  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP GROUP
  // ======================================================
  $.fn.ARTICLEMAGWP_group = function() {
    return this.each(function() {

      // set variables
      var _this         = $(this),
        field_groups    = _this.find('.cs-field-groups'),
        accordion_group = _this.find('.cs-accordion'),
        clone_group     = _this.find('.cs-field-group:first').clone();

      if ( accordion_group.length ) {
        accordion_group.accordion({
          header    : "> div > h3",
          collapsible : true,
          active    : false,
          animate   : 200,
          heightStyle : "content",
          icons   : {
            "header"    : "dashicons dashicons-arrow-right",
            "activeHeader"  : "dashicons dashicons-arrow-down"
          },
          beforeActivate: function( event, ui ) {
            $(ui.newPanel).ARTICLEMAGWP_dependency( 'sub' );
          }
        });
      }

      field_groups.sortable({
        axis        : "y",
        handle      : "h3",
        helper      : "clone",
        cursor      : 'move',
        placeholder : 'widget-placeholder',
        start       : function( event, ui ) {
          var inside = ui.item.children('.ui-accordion-content');
          if ( inside.css('display') === 'block' ) {
            inside.hide();
            field_groups.sortable('refreshPositions');
          }
        },
        stop         : function( event, ui ) {
          ui.item.children( "h3" ).triggerHandler( "focusout" );
          accordion_group.accordion({ active:false });
        }
      });

      var i = 0;
      $('.cs-add-field', _this).click( function( e ){

        e.preventDefault();

        clone_group.find('input, select, textarea').each( function (){
          this.name = this.name.replace(/\[(\d+)\]/,function(string, id){ return '[' + (parseInt(id,10)+1) + ']'; });
        });

        var cloned = clone_group.clone().removeClass('hidden');
        field_groups.append( cloned );

        if ( accordion_group.length ) {
          field_groups.accordion('refresh');
          field_groups.accordion({ active: cloned.index() });
        }

        field_groups.find('input, select, textarea').each( function (){
          this.name = this.name.replace('[_nonce]', '');
        });

        // run all field plugins
        cloned.ARTICLEMAGWP_dependency( 'sub' );
        $.reloadPlugins();

        i++;

      });

      field_groups.on('click', '.remove-cs-field', function(e){
        e.preventDefault();
        $(this).closest('.cs-field-group').remove();
      });

    });
  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP ICON SELECTOR
  // ======================================================
  $.fn.ARTICLEMAGWP_icon = function() {

    var _iconDialog   = $('#icon-dialog'),
        _iconOverlay  = $('#icon-overlay'),
        _iconInsert   = _iconDialog.find('#icon-insert'),
        _iconLoad     = _iconDialog.find('#icon-load'),
        _iconSearch   = _iconDialog.find('#icon-search'),
        _iconSelected = false,
        _iconsLoaded  = false,
        _iconRemove,
        _iconParent,
        _iconValue,
        _iconDialogHeight,
        _iconPreview;

    $(document.body).on('click', '.icon-add', function( e ){

      e.preventDefault();

      // set vars
      _iconDialogHeight = ( $(window).height() <= 700 ) ? 500 : 700;
      _iconParent       = $(this).parent();
      _iconPreview      = _iconParent.find('.icon-preview');
      _iconRemove       = _iconParent.find('.icon-remove');
      _iconValue        = _iconParent.find('.icon-value');

      _iconDialog.dialog({
        dialogClass: 'wp-dialog cs-icon-dialog',
        width: 1000,
        height: _iconDialogHeight,
        closeOnEscape: true,
        create: function(){
          $('.ui-dialog-titlebar-close').addClass('ui-button');
        },
        open: function() {
          _iconLoad.height( parseInt( _iconDialogHeight - 210 ) );
          _iconOverlay.show();
        },
        close: function() {
          _iconOverlay.hide();
        },
        resize: function( event, ui ) {
          _iconLoad.height( parseInt( ui.size.height - 210 ) );
        }
      });

      if( _iconsLoaded === false ){

        $.ajax({
          type  : 'POST',
          url   : ajaxurl,
          data  : { action: 'cs-icons' },
          success : function( data ) {

            _iconLoad.html( data );
            _iconLoad.find('a').each( function(){
              var _this = $(this),
                  _data = _this.data('ro-icon');

              _this.click( function( e ){
                e.preventDefault();
                if( _this.is('.active-icon') ){
                  _this.removeClass('active-icon');
                  _iconSelected = false;
                }else{
                  _this.addClass('active-icon').siblings().removeClass('active-icon');
                  _iconSelected = _data;
                }

              });
            });
            _iconsLoaded = true;

          }
        });

      }


      _iconSearch.keyup( function(){
        var input = $(this),
            val   = input.val(),
            list  = _iconLoad.find('a');

        list.each(function() {
          var _this = $(this);

          if ( _this.data('ro-icon').search( new RegExp(val, "i") ) < 0 ) {
            _this.hide();
          } else {
            _this.show();
          }

        });
      });


      _iconInsert.click( function( e ) {
        e.preventDefault();
        if ( _iconSelected !== false ){

          // preview
          _iconPreview.removeClass('hidden');
          _iconPreview.find('span').removeAttr('class').addClass( _iconSelected.substr( 0,2 ) + ' ' + _iconSelected );

          // value
          _iconValue.val( _iconSelected ).trigger('keyup');

          // remove icon class
          _iconRemove.removeClass('hidden');

          // close dialog
          _iconDialog.dialog( 'close' );
        }
      });



    });

    // clear
    $(document.body).on('click', '.icon-remove', function(e){
      e.preventDefault();
      var _remove = $(this),
        _parent = _remove.parent();

      _parent.find('.icon-preview').addClass('hidden');
      _parent.find('.icon-value').val('');
      _remove.addClass('hidden');
    });

    _iconOverlay.click( function( e ) {
      e.preventDefault();
      _iconOverlay.hide();
      _iconDialog.dialog( 'close' );
    });

  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP STICKY HEADER
  // ======================================================
  $.fn.ARTICLEMAGWP_stickyHeader = function() {
    return this.each( function(){

      var _this     = $(this),
        _cs_framework = $('.cs-framework'),
        _top      = _cs_framework.offset().top,
        _bar_height   = $('#wpadminbar').height();

      $(window).resize( function() {
        _this.css('width', ( $(window).width() - 60 ) - _this.offset().left );
      }).trigger('resize');

      $(window).scroll( function(){

        var scrollTop = $(window).scrollTop();

        if ( scrollTop >= parseInt( _top - _bar_height ) ) {
          _cs_framework.addClass('sticky-header');
        } else {
          _cs_framework.removeClass('sticky-header');
        }

      }).trigger("scroll");

    });
  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP RESET OPTIONS
  // ======================================================
  $.fn.ARTICLEMAGWP_areYouSure = function() {
    return this.each( function(){
      $(this).click( function( e ){
        if ( !confirm('Are you sure?') ) {
          e.preventDefault();
        }
      });
    });
  };
  // ======================================================



  // ======================================================
  // ARTICLEMAGWP SAVE OPTIONS
  // ======================================================
  $.fn.ARTICLEMAGWP_saveAjax = function() {
    return this.each( function(){

      var _this = $(this);

      _this.click( function ( e ){
        e.preventDefault();

        // disable save button for force save
        _this.prop('disabled', true).attr('value', 'Saving...');

        // show ajax notify
        $('#save-ajax').html('saving...').hide().fadeIn('fast');

        // get form serialize
        var serializedOptions = $('#csframework_form').serialize();

        // send ajax
        $.post( 'options.php', serializedOptions ).error( function() {
          alert('Error, Please try again.');
        }).success( function() {

          // if success enable save button
          _this.prop('disabled', false).attr('value', 'Save');

          // hiding ajax notify
          $('#save-ajax').html('done...').fadeOut();
        });


        $('.cs-reset').click( function ( e ){
          if ( !confirm('Are you sure?') ) {
            e.preventDefault();
          }else{
            this.value = 'Reseting...';
          }
        });
      });

    });
  };
  // ======================================================


  // ======================================================
  // ARTICLEMAGWP FRAMEWORK NAV
  // ======================================================
  $.fn.ARTICLEMAGWP_frameworkNav = function() {
    return this.each(function() {

      // set vars
      var el          = $(this),
        hash        = window.location.hash,
        cookie_unique   = el.data('cookie'),
        accordion_nav   = el.find('ul.cs-accordion-nav'),
        sections_nav    = el.find('ul.cs-sections'),
        accordion_index   = ( $.cookie('accordion-' + cookie_unique) ) ? $.cookie('accordion-' + cookie_unique) : 0,
        section_index   = ( $.cookie('section-'   + cookie_unique) ) ? $.cookie('section-' + cookie_unique) : 0,
        content_index   = $.cookie('content-'   + cookie_unique),
        current_section   = $.cookie('current-'   + cookie_unique),
        sub_section;

      // set navigation for directlink
      if( hash.length ){
        var params    = (window.location.hash.substr(1)).split("&");
        section_index = parseInt( params[0] );
        content_index = '#cs-tab-' + params[1];
        current_section = params[1];
      }

      if( current_section !== undefined ){
        el.find('#cs-reset-section').val( current_section );
      }else{
        el.find('#cs-reset-section').val( sections_nav.find('a:first').data("section") );
      }

      // if accordion_nav
      if( accordion_index !== undefined ){
        accordion_nav.find('> li').eq(accordion_index).addClass("cs-active").find('ul').show();
      }

      accordion_nav.on('click', 'a.cs-nav-tab', function( e ){

        var _this = $(this);
        _this.parent().addClass("cs-active").siblings().removeClass("cs-active");
        _this.next().slideDown('fast').parent().siblings().find('ul').slideUp('fast');

        // cookie for tab-index
        $.cookie('accordion-' + cookie_unique, parseInt( _this.parent().index() ), { path: '/' });

        e.preventDefault();

      });

      // if section_index set from cookie, active last choose
      if( section_index !== undefined ){
        if( accordion_nav.length ){
          sub_section = accordion_nav.find('> li').eq(accordion_index).find('ul li').eq(section_index);
        }else{
          sub_section = sections_nav.find('li').eq(section_index);
        }
        sub_section.addClass("section-active");
      }

      if( content_index !== undefined ){
        el.find(content_index).show();
      }else{
        el.find('.cs-content ul:first li:first').show();
      }

      // section click
      sections_nav.on('click', 'a', function( e ){

        e.preventDefault();
        var _this = $(this), _target = '#' + _this.data("target"), _section = _this.data("section");

        _this.closest('.cs-accordion-nav').find('li').removeClass("section-active");
        _this.parent().addClass("section-active").siblings().removeClass("section-active");

        $(_target).fadeIn('fast').siblings().hide();


        // cookie for tab-index
        $.cookie('section-' + cookie_unique, parseInt( _this.parent().index() ), { path: '/' });
        $.cookie('content-' + cookie_unique, _target, { path: '/' });
        $.cookie('current-' + cookie_unique, _section, { path: '/' });

        el.find('#cs-reset-section').val(_section);

      });

    });
  };
  // ======================================================


  // ======================================================
  // ARTICLEMAGWP COLOUR SCHEME
  // ======================================================
  $.fn.ARTICLEMAGWP_resetCustomize = function() {
    return this.each( function(){

      var _this     = $(this),
          _reset    = _this.find('.cs-reset-color'),
          _spinner  = _this.find('.spinner-scheme');

      _reset.click( function ( e ){
        e.preventDefault();

        _spinner.removeClass('hidden');
        _reset.html('Reseting...');
        $.ajax({
          type  : 'POST',
          url   : ajaxurl,
          data  : { action: 'cs-reset-customize' },
          success : function() {
            _spinner.addClass('hidden');
            _reset.html('Success!').attr('disabled', 'disabled');
            window.location.reload(true);
          }
        });

      });

    });
  };
  // ======================================================

  // ======================================================
  // ARTICLEMAGWP ONE-CLICK INSTALL
  // ======================================================
  $.fn.ARTICLEMAGWP_oneClickInstall = function() {
    return this.each( function(){

      var _this           = $(this),
          _install        = _this.find('#cs-install'),
          _visit          = _this.find('#cs-visit-site'),
          _attachment     = _this.find('#cs-install-attachment'),
          _few_minutes    = _this.find('#cs-few-minutes'),
          _spinner        = _this.find('.cs-spinner'),
          _installed      = false,
          _is_attachment  = null;

      _install.click( function ( e ){
        e.preventDefault();

        if ( !_installed && window.confirm( 'Are you sure?' ) ) {

          if( _attachment.is(':checked') ) {
            _is_attachment = true;
          }

          _spinner.show();
          _spinner.addClass('is-active');
          _attachment.closest('p').hide();
          _few_minutes.removeClass('hidden');
          _install.html('Importing...').attr('disabled', 'disabled');
          _installed = true;

          $.ajax({
            type  : 'POST',
            url   : ajaxurl,
            data  : { action: 'cs-import-dump', attachment: _is_attachment },
            success : function( data ) {
              _spinner.hide();
              _spinner.removeClass('is-active');
              _visit.removeClass('hidden');
              _few_minutes.addClass('hidden');
              _install.html('Successful!');
              _this.prepend( data );
            }
          });

        }

      });

    });
  };
  // ======================================================

  // ======================================================
  // VISUAL COMPOSER IMAGE SELECT
  // ======================================================
  $.fn.JSCOMPOSER_image_select = function() {
    return this.each(function() {

      var _el       = $(this),
          _elems    = _el.find('li');

      _elems.each( function (){
        var _this = $(this),
            _data = _this.data('value');

        _this.click( function(){
          if( _this.is('.selected') ){
            _this.removeClass('selected');
            _el.next().val('').trigger('keyup');
          }else{
            _this.addClass('selected').siblings().removeClass('selected');
            _el.next().val( _data ).trigger('keyup');
          }
        });

      });
    });
  };
  // ======================================================



  // ======================================================
  // VISUAL COMPOSER SWITCH
  // ======================================================
  $.fn.JSCOMPOSER_switch = function() {
    return this.each(function() {

      var _this   = $(this),
          _input  = _this.find('input');

      _this.click( function(){
        _this.toggleClass('switch-active');
        _input.val( ( _input.val() == 1 ) ? '' : 1 ).trigger('keyup');
      });

    });
  };
  // ======================================================

  // ======================================================
  // CSFRAMEWORK COLORPICKER
  // ------------------------------------------------------
  if( typeof Color.prototype.toString !== undefined ) {

    // adding alpha support for Automattic Color.js toString function.
    Color.prototype.toString = function () {

      // check for alpha
      if ( this._alpha < 1 ) {
        return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
      }

      var hex = parseInt( this._color, 10 ).toString( 16 );

      if ( this.error ) { return ''; }

      // maybe left pad it
      if ( hex.length < 6 ) {
        for (var i = 6 - hex.length - 1; i >= 0; i--) {
          hex = '0' + hex;
        }
      }

      return '#' + hex;

    };

  }

  $.ARTICLEMAGWP.PARSE_COLOR_VALUE = function( val ) {

    var value = val.replace(/\s+/g, ''),
        alpha = ( value.indexOf('rgba') !== -1 ) ? parseFloat( value.replace(/^.*,(.+)\)/, '$1') * 100 ) : 100,
        rgba  = ( alpha < 100 ) ? true : false;

    return { value: value, alpha: alpha, rgba: rgba };

  };

  $.fn.ARTICLEMAGWP_COLORPICKER = function() {

    return this.each(function() {

      var $this = $(this);

      // check for rgba enabled/disable
      if( $this.data('rgba') !== false ) {

        // parse value
        var picker = $.ARTICLEMAGWP.PARSE_COLOR_VALUE( $this.val() );

        // wpColorPicker core
        $this.wpColorPicker({

          // wpColorPicker: clear
          clear: function() {
            $this.trigger('keyup');
          },

          // wpColorPicker: change
          change: function( event, ui ) {

            var ui_color_value = ui.color.toString();
            $this.closest('.wp-picker-container').find('.cs-alpha-slider-offset').css('background-color', ui_color_value);
            $this.val(ui_color_value).trigger('change');

          },

          // wpColorPicker: create
          create: function( event, ui ) {

            // set variables for alpha slider
            var a8cIris       = $this.data('a8cIris'),
                $container    = $this.closest('.wp-picker-container'),

                // appending alpha wrapper
                $alpha_wrap   = $('<div class="cs-alpha-wrap">' +
                                  '<div class="cs-alpha-slider"></div>' +
                                  '<div class="cs-alpha-slider-offset"></div>' +
                                  '<div class="cs-alpha-text"></div>' +
                                  '</div>').appendTo( $container.find('.wp-picker-holder') ),

                $alpha_slider = $alpha_wrap.find('.cs-alpha-slider'),
                $alpha_text   = $alpha_wrap.find('.cs-alpha-text'),
                $alpha_offset = $alpha_wrap.find('.cs-alpha-slider-offset');

            // alpha slider
            $alpha_slider.slider({

              // slider: slide
              slide: function( event, ui ) {

                var slide_value = parseFloat( ui.value / 100 );

                // update iris data alpha && wpColorPicker color option && alpha text
                a8cIris._color._alpha = slide_value;
                $this.wpColorPicker( 'color', a8cIris._color.toString() );
                $alpha_text.text( ( slide_value < 1 ? slide_value : '' ) );

              },

              // slider: create
              create: function() {

                var slide_value = parseFloat( picker.alpha / 100 ),
                    alpha_text_value = slide_value < 1 ? slide_value : '';

                // update alpha text && checkerboard background color
                $alpha_text.text(alpha_text_value);
                $alpha_offset.css('background-color', picker.value);

                // wpColorPicker clear for update iris data alpha && alpha text && slider color option
                $container.on('click', '.wp-picker-clear', function() {

                  a8cIris._color._alpha = 1;
                  $alpha_text.text('');
                  $alpha_slider.slider('option', 'value', 100).trigger('slide');

                });

                // wpColorPicker default button for update iris data alpha && alpha text && slider color option
                $container.on('click', '.wp-picker-default', function() {

                  var default_picker = $.ARTICLEMAGWP.PARSE_COLOR_VALUE( $this.data('default-color') ),
                      default_value  = parseFloat( default_picker.alpha / 100 ),
                      default_text   = default_value < 1 ? default_value : '';

                  a8cIris._color._alpha = default_value;
                  $alpha_text.text(default_text);
                  $alpha_slider.slider('option', 'value', default_picker.alpha).trigger('slide');

                });

                // show alpha wrapper on click color picker button
                $container.on('click', '.wp-color-result', function() {
                  $alpha_wrap.toggle();
                });

                // hide alpha wrapper on click body
                $('body').on( 'click.wpcolorpicker', function() {
                  $alpha_wrap.hide();
                });

              },

              // slider: options
              value: picker.alpha,
              step: 1,
              min: 1,
              max: 100

            });
          },
          palettes: ["#000000", "#ffffff",  "#6e6e6e", "#293951", "#5cb85c", "#d9534f", "#f0ad4e"]
        });

      } else {

        // wpColorPicker default picker
        $this.wpColorPicker({
          clear: function() {
            $this.trigger('keyup');
          },
          change: function( event, ui ) {
            $this.val(ui.color.toString()).trigger('change');
          },
          palettes: ["#000000", "#ffffff",  "#6e6e6e", "#293951", "#5cb85c", "#d9534f", "#f0ad4e"]
        });

      }

    });

  };
  // ======================================================

  // ======================================================
  // RELOAD JSCOMPOSER PLUGINS
  // ======================================================
  $.reloadJSPlugins = function() {
    $('.vc_switch').JSCOMPOSER_switch();
    $('.vc_image_select').JSCOMPOSER_image_select();
    $('.cs-color-picker').ARTICLEMAGWP_COLORPICKER();
    $('.cs-uploader').ARTICLEMAGWP_upload();
    $('.chosen').chosen({allow_single_deselect: true, disable_search_threshold: 15});
  };
  // ======================================================

  // ======================================================
  // ON WIDGET-ADDED RELOAD FRAMEWORK PLUGINS
  // ------------------------------------------------------
  $.ARTICLEMAGWP_frameworkWidgetTrigger = function() {
    $(document).on('widget-added widget-updated', function( event, $widget ) {
      $('.cs-uploader', $widget).ARTICLEMAGWP_upload();
    });
  };

  // ======================================================
  // RELOAD FRAMEWORK PLUGINS
  // ======================================================
  $.reloadPlugins = function() {
    $('.chosen').chosen({allow_single_deselect: true, disable_search_threshold: 15});
    $('.cs-ui-slider').ARTICLEMAGWP_slider();
    $('.cs-ui-spinner').ARTICLEMAGWP_spinner();
    $('.image_select').ARTICLEMAGWP_imageSelector();
    $('.cs-uploader').ARTICLEMAGWP_upload();
    $('.cs-typography').ARTICLEMAGWP_typography();
    $('.cs-icon-select').ARTICLEMAGWP_icon();
    $('.cs-color-picker').ARTICLEMAGWP_COLORPICKER();
  };

  $(document).ready( function(){

    $('#menu-to-edit').ARTICLEMAGWP_megamenu();
    $('.cs-framework-nav').ARTICLEMAGWP_frameworkNav();
    $('.cs-ajax').ARTICLEMAGWP_saveAjax();
    $('.cs-reset-all, .cs-reset, .cs-import-backup').ARTICLEMAGWP_areYouSure();
    $('.cs-sticky').ARTICLEMAGWP_stickyHeader();
    $('.cs-field-container').ARTICLEMAGWP_group();
    $('.cs-content').ARTICLEMAGWP_dependency();
    $('#cs-reset-customize').ARTICLEMAGWP_resetCustomize();
    $('#cs-one-click').ARTICLEMAGWP_oneClickInstall();
    $.reloadPlugins();
    $.ARTICLEMAGWP.shortcodeManager();
    $.ARTICLEMAGWP_frameworkWidgetTrigger();

  });

})( jQuery, window, document );