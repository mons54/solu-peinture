
(function ($) {

    $.widget("ui.admin_albums", {

        options: {
		},
		
		_create: function () {
			
			var that = this;
			
			that.div = $('<div class="update"></div>').appendTo(that.element);
					
			$('<button class="edit">Images</button>').appendTo(that.div)
			.click(function() {
				that._update_photo();
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
				
				$('<input type="hidden" name="module" value="albums">').appendTo(form);
				$('<input type="hidden" name="key" value="' + that.options.key + '">').appendTo(form);
				
				var div = $('<div class="form"></div>').appendTo(form);
				$('<button type="submit" name="supprimer-module">Supprimer</button>').appendTo(div);
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
				
				if(i == 'time')
					var val = that.options.data['time'] / 1000;
				else
					var val = that.options.data[i];
				
				for(var _i in options[i].options) {
					
					var selected = '';
					
					if(val == _i || (_i == 'custom' && !_selected)) {
						selected = 'selected';
						if(val == _i)
							_selected = true;
					}
					
					$('<option ' + selected + ' value="' + _i + '">' + options[i].options[_i] + '</option>').appendTo(select);
				}
					
				that.custom[i] = $('<span></span>').appendTo(div);
				
				if(!_selected) {
					$(options[i].custom).appendTo(that.custom[i]);
					$('input[name=' + i + ']').val(val);
				}
			}
		},
		
		_update_photo: function() {
			
			var that = this;
			
			$('#dial').css('display', 'block');
				
			var fenetre = $('<div class="fenetre"></div>').appendTo(dial);
			
			$('<button class="close"></button>').appendTo(fenetre)
			.click(function () {
				$('#dial').css('display', 'none');
				$('.fenetre').remove();
			});
			
			$('<h3>Modifier les photos</h3>').appendTo(fenetre);
			
			var form = $('<form action="" method="post"></form>').appendTo(fenetre);
		
			var div = $('<div class="form"></div>').appendTo(form);
			$('<input class="perso-multi-files" name="file[]" type="file" multiple="multiple" />').appendTo(div)
			.change(function() {
				
				var data = new FormData();
				
				for (var i = 0; i < this.files.length; i++) {
					var current_file = this.files[i];
					$._upload(current_file,'min',960,450,that._uploadFile);
				}
				
				$(this).empty().val('');
			});
			
			that.upload = $('<div class="upload" id="upload"></div>').appendTo(form);
			
			for(var i in that.options.data.image) {
				var div = $('<div class="photo-upload"></div>').appendTo(that.upload),
					img = that.options.data.image[i];
					
				that._sup_photo(img, div);
					
				$('<div class="mini-upload"></div>').css('background-image', 'url(img/modules/albums/' + that.options.key + '/' + img + ')').appendTo(div);
				$('<input type="hidden" name="photo[' + i + ']" value="' + img + '">').appendTo(div);
			}
			
			$('<input type="hidden" name="key" value="' +  that.options.key + '">').appendTo(form);
			
			var div = $('<div class="form"></div>').appendTo(form);
			that.submit = $('<button name="submit-photos-albums" type="submit">Modifier</button>').appendTo(div);
		},
		
		_uploadFile:function(img) {
			var that = this,
				div = $('<div class="photo-upload"></div>').appendTo('#upload');
			
			$('<button class="sup-upload"></button>').appendTo(div)
			.click(function() {
				$(this).parent().remove();
			});
			$('<div class="mini-upload"></div>').css('background-image', 'url(' + img + ')').appendTo(div);
			$('<input type="hidden" name="upload[]" value="' + img + '">').appendTo(div);
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