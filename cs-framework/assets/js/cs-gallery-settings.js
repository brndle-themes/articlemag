// the semi-colon before the function invocation is a safety
// net against concatenated scripts and/or other plugins
// that are not closed properly.
// set root Object
;(function ( $, window, document, undefined ) {
  'use strict';

  $(document).ready( function(){

    var media = wp.media;

    // merge default gallery settings template
    media.view.Settings.Gallery = media.view.Settings.Gallery.extend({

      render: function() {
        var $el = this.$el;

        media.view.Settings.prototype.render.apply( this, arguments );

        // append cs gallery settings
        $el.append( media.template( 'cs-gallery-settings' ) );

        // set default attributes
        media.gallery.defaults.cstype = '';
        media.gallery.defaults.scale  = '';

        // apply update
        this.update.apply( this, ['cstype'] );
        this.update.apply( this, ['scale'] );

        // bind type
        $el.find( '#cs-gallery-type' ).on( 'change', function () {

          var hidden_settings = $el.find( '#cs-gallery-scale' );
          if ( 'slideshow' == $( this ).val() || 'gallery_thumb' == $( this ).val() || 'gallery_nearby' == $( this ).val() ){
            hidden_settings.removeClass('hidden');
          }else{
            hidden_settings.addClass('hidden');
          }

        } ).change();

        return this;
      }

    });

  });

})( jQuery, window, document );