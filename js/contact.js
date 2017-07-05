
(function ($) {

    $.widget("ui.contact", {

        options: {
			error: {
				color: '3px solid #930',
				element: 'border',
			}
		},
		
		_create: function () {
			
			var that = this;
			
			that._submit();
		},
		
		_submit:function() {
			
			var that = this;
			
			$('#form-contact input[type=text]').focus(function() {
				$(this).css(that.options.error.element, '');
			});
			
			$('#form-contact textarea').focus(function() {
				$(this).css(that.options.error.element, '');
			});
			
			$('#form-contact').submit(function() {
			
				if(!$('#form-contact input[name="nom"]').val()) {
					$('#form-contact input[name="nom"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
				
				if(!$('#form-contact input[name="email"]').val()) {
					$('#form-contact input[name="email"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
				
				if(!$('#form-contact input[name="objet"]').val()) {
					$('#form-contact input[name="objet"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
				
				if(!$('#form-contact textarea[name="message"]').val()) {
					$('#form-contact textarea[name="message"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
			});
		}
		
    });

})(jQuery);