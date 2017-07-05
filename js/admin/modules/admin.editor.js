
(function ($) {

    $.widget("ui.admin_editor", {

		options: {},
		
		_create: function () {
			
			var that = this;
			
			that.editable = '#editor-' + that.options.key + ' .content';
		},
		
		_init:function() {
			
			var that = this;
			
			that.div = $('<div></div>').prependTo(that.element);
			
			$('<button class="edit">Editer</button>').appendTo(that.div)
			.click(function() {
				
				that.options.save = $(that.editable).html();
				
				$(that.div).empty().html();
				
				$(that.editable).redactor({
					lang: 'fr',
					imageGetJson: 'redactor/php/images.json.php',
					imageUpload: 'redactor/php/images.upload.php',
					plugins: ['youtube'],
				});
				
				$('<button class="edit">Annuler</button>').appendTo(that.div)
				.click(function() {
					that._annuler();
				});
				
				$('<button class="edit">Sauvegarder</button>').appendTo(that.div)
				.click(function() {
					
					var data = $(that.editable).redactor('get');
					
					$.post('ajax/admin/modules/editor/save', {key:that.options.key, data:data});
					$(that.editable).redactor('destroy');
					$(that.div).remove();
					that._init();
				});
			});
			
			$('<button class="edit">Supprimer</button>').appendTo(that.div)
			.click(function() {
				
				$('#dial').css('display', 'block');
				
				var fenetre = $('<div class="fenetre"></div>').appendTo(dial);
				
				$('<button class="close"></button>').appendTo(fenetre)
				.click(function () {
					$('#dial').css('display', 'none');
					$('.fenetre').remove();
				});
				
				$('<h3>Supprimer ce module ?</h3>').appendTo(fenetre);
				
				var form = $('<form id="form-modules" action="' + document.URL + '" method="post"></form>').appendTo(fenetre);
				
				$('<input type="hidden" name="module" value="editor">').appendTo(form);
				$('<input type="hidden" name="key" value="' + that.options.key + '">').appendTo(form);
				
				var div = $('<div class="form"></div>').appendTo(form);
				$('<button type="submit" name="supprimer-module">Supprimer</button>').appendTo(div);
			});
		},
		
		_annuler:function() {
			var that = this;
			$(that.editable).redactor('destroy').empty().html(that.options.save);
			$(that.div).remove();
			that._init();
		},
	});

})(jQuery);