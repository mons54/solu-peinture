
(function($){
	
	$.extend({
		
		_get_first_object: function(array) {
			for(var i in array)
				return array[i];
			
			return false;
		}
	});
})(jQuery);