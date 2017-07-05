
(function ($) {

    $.widget("ui.devis", {

        options: {
			error: {
				color: '3px solid #930',
				element: 'border',
			}
		},
		
		_create: function () {
			
			var that = this;
			
			that._departement();
			that._submit();
			
		},
		
		_departement: function () {
			$('select[name=departement]').change(function(){
				$.post('ajax/devis/devis.ville', { id: $(this).val() }, function(data) {
					if(data) $('#ville').empty().html(data);
				});
			});
		},
		
		_submit:function() {
			
			var that = this;
			
			$('#form-devis input[type=text]').focus(function() {
				$(this).css(that.options.error.element, '');
			});
			
			$('#form-devis').submit(function() {
			
				if(!$('#form-devis input[name="nom"]').val()) {
					$('#form-devis input[name="nom"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
				
				if(!$('#form-devis input[name="adresse"]').val()) {
					$('#form-devis input[name="adresse"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
				
				if(!$('#form-devis input[name="code_postal"]').val()) {
					$('#form-devis input[name="code_postal"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
				
				if(!$('#form-devis input[name="commune"]').val()) {
					$('#form-devis input[name="commune"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
				
				if(!$('#form-devis input[name="email"]').val()) {
					$('#form-devis input[name="email"]').css(that.options.error.element, that.options.error.color);
					return false;
				}
			});
		}
		
    });

})(jQuery);