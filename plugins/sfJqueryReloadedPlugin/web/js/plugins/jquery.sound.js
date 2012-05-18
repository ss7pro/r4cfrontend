/**
 * jQuery simple sound plugin 
 */

/**
 * API Documentation
 * 
 * // increase the timeout to four seconds before removing the sound object from the dom for longer sounds
 * $.sound.play({
 *   src: url,
 *   timeout: 4000
 * });
 * 
 * // stop a sound by removing the element returned by play
 * var sound = $.sound.play({
 *   src: url, 
 *   type: "audio/mpeg"
 * });
 * sound.remove();
 */

(function($) {
	
$.sound = {
	play: function(options){
		
		options = $.extend({
			timeout: 2000,
			mime: 'audio/basic'
		}, options);
		
		var element = null;
    try {
      
      element = $('<embed/>').attr({
        src: options.src,
        type: options.mime,
        height: 0
      });
      $('body').append(element);
      setTimeout(function() { element.remove(); }, options.timeout);
      
    } catch(e) { /* ignore */ }
		
		return element;
	}
};

})(jQuery);