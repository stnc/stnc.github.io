
/*  STNC jquery thumbnail scroller plugin 
 * Version: 2.0.0,
 * https://github.com/stnc/jquery-thumbnail-scroller
 * selmantunc@gmail.com
 *  License: MIT License (MIT) */
(function($) {
  $.fn.StncThumbnailScroller = function(options) {
    // Establish our default settings
    var settings = $.extend({
      scrollSpeed: 100,
      fadeSpeed: 400,
      imagePictureAttr: '#showPicture'
    }, options);
    return this.each(function() {
      var element = $(this);
      var picture = jQuery('li img:first', element).data('src');
      jQuery(settings.imagePictureAttr ).attr('src', picture);
      //picture show click
      jQuery("li img", element).click(function() {
        var picture = jQuery(this).data('src');
        jQuery(settings.imagePictureAttr).hide();
        jQuery(settings.imagePictureAttr).fadeIn(settings.fadeSpeed);
        jQuery(settings.imagePictureAttr).attr('src', picture);

      });
      //direction button 
      jQuery(".directionBtn").click(function() {
        where = jQuery(this).data('direction');
        var item_width = jQuery(' li', element).outerWidth() + 10;
        if (where == 'next') {
          var left_indent = parseInt(jQuery(element).css('left')) + item_width;
        } else {
          var left_indent = parseInt(jQuery('', element).css('left')) - item_width;
        }
        //make the sliding effect using jQuery's animate function... '
        jQuery(':not(:animated)', element).animate({
          'left': left_indent
        }, settings.scrollSpeed, function() {
          if (where == 'next') {
            jQuery(' li:first', element).before(jQuery(' li:last', element));
          } else {
            jQuery(' li:last', element).after(jQuery(' li:first', element));
          }
          jQuery('ul',element).css({
            'left': '-100px'
          });

        });
      });
    });
  }
  
}(jQuery));
