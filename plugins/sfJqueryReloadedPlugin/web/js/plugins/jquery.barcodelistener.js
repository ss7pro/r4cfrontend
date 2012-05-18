(function($) {
  
  var settings = {
    maxLength: 13,
    validator: function(barcode){ return true; },
    success: function(barcode){;},
    error: function(barcode){;},
    withAlpha: false,
    debug: false
  };
   
  function _keyToChar(key) {
    if(key >= 48 && key <= 57) return String.fromCharCode(key);
    if(settings.withAplha && key >= 65 && key <= 90) return String.fromCharCode(key);
    else if(key >= 96 && key <= 105) return String.fromCharCode(key - 48); // numpad 0 - 9
    else return '';
  };
  
  function _charQueue(str, character, length) {
    if(str.length > length) str = str.substr(1, str.length);
    //return str + character;
    return str;
  };

  function _process(e) {
    var barcode = $(e.target).val();
    if(settings.debug) { console.log(['process', barcode]); }
    if(barcode.length < settings.maxLength) return;
    if(settings.validator(barcode)) {
      if(settings.debug) { console.log(['success', barcode]); }
      settings.success(barcode);
    } else { 
      if(settings.debug) { console.log(['error', barcode]); }
      settings.error(barcode);
    }
    $(e.target).val('');
  }
  
  function _keypress(e) {
    if(settings.debug) { console.log([e.type, e.keyCode]); }
    var key = e.keyCode;
    if(key == 9 || key == 13 || key == 10) { //TAB || CR || LF
      e.preventDefault();
      _process(e);
      return false;
    }
  }
  
  function _keyup(e) {
    if(settings.debug) { console.log([e.type, e.keyCode]); }
    var key = e.keyCode;
    if(key == 9 || key == 13 || key == 10) { //TAB || CR || LF
      return;
    }

    var barcode = $(e.target).val();
    var ch = _keyToChar(key);
    barcode = _charQueue(barcode, ch, settings.maxLength);  
    $(e.target).val(barcode);
  };

  var methods = {
      
    init: function(options) {

      if(options) $.extend(settings, options);

      return this.each(function(){
        $(this)
          .keydown(function(e){ _keypress(e); })
          .keyup(function(e){ _keyup(e); });
      }).first().focus();
    }
  };
  
  $.fn.barcodelistener = function(method) {      
    if ( methods[method] ) {
      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
    }  
  };

})(jQuery);
