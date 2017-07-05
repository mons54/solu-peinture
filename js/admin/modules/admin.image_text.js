
(function ($) {

    $.widget("ui.admin_image_text", {

		options: {
			css:{}
		},
		
		_create: function () {
			
			var that = this;
			
			if(!that.options.key)
				return;
				
			that.editable_title = '#image_text-' + that.options.key + ' h1.title';
			that.editable_text = '#image_text-' + that.options.key + ' .text';
			
			if(that.options.data.position == 'left')
				that.options.css = {
					margin: '-50px 0 0 10px',
					align: 'left'
				};
			else 
				that.options.css = {
					margin: '-50px 10px 0 0',
					align: 'right'
				};
		},
		
		_init:function() {
			
			var that = this;
			that.div = $('<div></div>').prependTo(that.element).css('text-align', that.options.css.align);
			
			$('<button class="edit">Paramétres</button>').appendTo(that.div)
			.click(function() {
				
				$('#dial').css('display', 'block');
				
				var fenetre = $('<div class="fenetre"></div>').appendTo(dial);
				
				$('<button class="close"></button>').appendTo(fenetre)
				.click(function () {
					$('#dial').css('display', 'none');
					$('.fenetre').remove();
				});
				
				$('<h3>Paramétres</h3>').appendTo(fenetre);
				
				that.form = $('<form id="form-modules" action="' + document.URL + '" method="post"></form>').appendTo(fenetre);
				
				that.custom = {};
				
				var options = $.modules.image_text.options;
				
				for(var i in options) 
					that._options_modules(options, i);
				
				$('<input type="hidden" name="module" value="image_text">').appendTo(that.form);
				$('<input type="hidden" name="key" value="' + that.options.key + '">').appendTo(that.form);
				
				var div = $('<div class="form"></div>').appendTo(that.form);
				$('<button type="submit" name="modifier-module">Modifier</button>').appendTo(div);
			});
			
			$('<button class="edit">Editer</button>').appendTo(that.div)
			.click(function() {
				
				that.options.save = {};
				
				if($(that.editable_title).html())
					that.options.save.title = $(that.editable_title).html();
				
				that.options.save.text = $(that.editable_text).html();
				
				$(that.div).empty().html();
				
				if($(that.editable_title).html())
					$(that.editable_title).redactor({
						lang: 'fr',
						toolbar:false,
						linebreaks: true
					});
				
				$(that.editable_text).redactor({
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
					
					$('#remove').remove();
					$(that.editable_text).redactor('sync');
					
					var data = {};
					
					if($(that.editable_title).html())
						data.title = $(that.editable_title).redactor('get');
						
					data.text = $(that.editable_text).redactor('get');
					
					$.post('ajax/admin/modules/image_text/save.text', {key:that.options.key, data:data});
					
					$('#image_text-image-' + that.options.key).css('display', 'block');
					
					if($(that.editable_title).html())
						$(that.editable_title).redactor('destroy');
				
					$(that.editable_text).redactor('destroy').css('margin', '');
					$(that.div).remove();
					that._init();
				});
				
				var style = $('#image_text-image-' + that.options.key).attr('style'),
					_class = $('#image_text-image-' + that.options.key).attr('class');
				
				$('#image_text-image-' + that.options.key).css('display', 'none');
				$('<img id="remove" class="' + _class + '" style="' + style + '" src=""/>').prependTo('#image_text-' + that.options.key + ' .redactor_box .text');
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
				
				$('<input type="hidden" name="module" value="image_text">').appendTo(form);
				$('<input type="hidden" name="key" value="' + that.options.key + '">').appendTo(form);
				
				var div = $('<div class="form"></div>').appendTo(form);
				$('<button type="submit" name="supprimer-module">Supprimer</button>').appendTo(div);
			});
			
			$('<button class="edit modifier-image">Images</button>').appendTo('#image_text-' + that.options.key + ' .image')
			.click(function() {
				that._modifier_images();
			});
		},
		
		_options_modules: function(options,i) {
			var that = this;
			
			var div = $('<div class="form"></div>').appendTo(that.form);
			$('<label>' + options[i].name + '</label>').appendTo(div);
			
			if(options[i].options) {
				var select = $('<select name="' + i + '"></select>').appendTo(div)
				.change(function() {
					if(this.value == 'custom')
						$(options[i].custom).appendTo(that.custom[i]);
					else 
						$(that.custom[i]).empty().html();
				});
				
				var _selected = false;
				
				if(i == 'image_size')
					var val = that.options.data['image_size'];
				else if(i == 'time')
					var val = that.options.data['time'] / 1000;
				else
					var val = that.options.data[i];
				
				for(var _i in options[i].options) {
					
					var selected = '';
					
					if(val == _i || (_i == 'custom' && !_selected)) {
						selected = 'selected';
						if(i == 'image_size' && val == 'custom')
							_selected = false;
						else if(val == _i)
							_selected = true;
					}
					
					$('<option ' + selected + ' value="' + _i + '">' + options[i].options[_i] + '</option>').appendTo(select);
				}
					
				that.custom[i] = $('<span></span>').appendTo(div);
				
				if(!_selected) {
					$(options[i].custom).appendTo(that.custom[i]);
					if(i == 'image_size') {
						$('input[name=image_width]').val(that.options.data['image_width']);
						$('input[name=image_height]').val(that.options.data['image_height']);
					}
					else {
						$('input[name=' + i + ']').val(val);
					}
				}
			}
		},
		
		_annuler:function() {
			var that = this;
			$('#image_text-image-' + that.options.key).css('display', 'block');
			
			if($(that.editable_title).html())
				$(that.editable_title).redactor('destroy').empty().html(that.options.save.title);
			
			$(that.editable_text).redactor('destroy').empty().html(that.options.save.text).css('margin', '');
			$(that.div).remove();
			that._init();
		},
		
		_modifier_images: function() {
			
			var that = this;
			
			$('#dial').css('display', 'block');
				
			var fenetre = $('<div class="fenetre"></div>').appendTo(dial);
			
			$('<button class="close"></button>').appendTo(fenetre)
			.click(function () {
				$('#dial').css('display', 'none');
				$('.fenetre').remove();
			});
			
			$('<h3>Modifier les images</h3>').appendTo(fenetre);
			
			var form = $('<form id="form-photos" method="post"></form>').appendTo(fenetre);
		
			var div = $('<div class="form"></div>').appendTo(form);
			$('<input class="perso-multi-files" name="file[]" type="file" multiple="multiple" />').appendTo(div)
			.change(function() {
			
				for (var i = 0; i < this.files.length; i++) {
					var current_file = this.files[i];
					$._upload(current_file,'min',500,500,that._uploadFile);
				}
				
				$(this).empty().val('');
			});
			
			that.upload = $('<div class="upload" id="upload"></div>').appendTo(form);
			
			for(var i in that.options.data.image) {
				var div = $('<div class="photo-upload"></div>').appendTo(that.upload),
					img = that.options.data.image[i];
					
				that._sup_photo(img, div);
					
				$('<div class="mini-upload"></div>').css('background-image','url(img/modules/image_text/' + that.options.key + '/' + img + ')').appendTo(div);
				$('<input type="hidden" name="photos-' + i + '" value="' + img + '">').appendTo(div);
			}
			
			var div = $('<div class="form"></div>').appendTo(form);
			that.submit = $('<button type="submit">Modifier</button>').appendTo(div);
			
			$('#form-photos').submit(function () {    
				
				$('#form-photos button[type=submit]').attr('disabled','true');
				
				var form = $(this).serializeArray(),
					data = {
						photos:{},
						upload:[],
					};
				
				for(i in form) {
					if(form[i].value) {
						var name = form[i].name.split('-');
						if(name[0] && data[name[0]])
							if(name[1])
								data[name[0]][name[1]] = form[i].value;
							else
								data[name[0]].push(form[i].value);
					}
				}
				
				$.post('ajax/admin/modules/image_text/save.image', {key:that.options.key, data:data}, function(data) {
					
					that.options.data.image = data.image ? data.image : {};
					
					if(data.image[0])
						$('#image_text-image-' + that.options.key).css('background-image', 'url(img/modules/image_text/' + that.options.key + '/' + data.image[0] + ')');
						
					$('#image_text-image-' + that.options.key).image_text({key:that.options.key, data:data});
					
					$('#dial').css('display', 'none');
					$('.fenetre').remove();
				
				}, 'json');
				
				return false;
			});
		},
		
		_uploadFile:function(img) {
			var that = this,
				div = $('<div class="photo-upload"></div>').appendTo('#upload');
			
			$('<button class="sup-upload"></button>').appendTo(div)
			.click(function() {
				$(this).parent().remove();
			});
			$('<div class="mini-upload"></div>').css('background-image','url(' + img + ')').appendTo(div);
			$('<input type="hidden" name="upload-" value="' + img + '">').appendTo(div);
		},
		
		_sup_photo: function(img, div) {
			
			$('<button class="sup-upload"></button>').appendTo(div)
			.click(function() {
				$(div).remove();
				return false;
			});
		},
		
	 });

})(jQuery);