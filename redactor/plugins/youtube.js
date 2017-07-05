if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};

RedactorPlugins.youtube = {

	options: {
		element: '<div id="redactor_youtube"></div>',
		size: {
			1: {
				width:420,
				height:315
			},
			2: {
				width:480,
				height:360
			},
			3: {
				width:640,
				height:480
			},
			4: {
				width:900,
				height:700
			}
		},
		position: {
			1: {
				name:'Gauche',
				style:'left',
			},
			2: {
				name:'Droite',
				style:'right',
			},
			3: {
				name:'Centre',
				style:'center',
			}
		}
	},
	init: function() {
		
		var that = this;
		
		var callback = $.proxy(function() {
				
			that.construct();
			that.setVideo();
			that.selectionSave();
			
		}, this);
		
		this.buttonAddAfter('image', 'youtube', 'Vidéo Youtube', function() {
			
			this.modalInit('Vidéo Youtube', this.options.element, 500, callback);
		
		});
	},
	construct : function() {
		var that = this;
		
		var section = $('<section></section>').appendTo('#redactor_youtube');
		
		$('<label>Lien</label>').appendTo(section);
		$('<input type="text" name="redactor_youtube_lien" class="redactor_input">').appendTo(section)
		.focus(function() {
			$(error).empty().text();
		});
		
		var error = $('<p id="error"></p>').appendTo(section);
		
		var size = $('<div id="redactor_youtube_size"></div>').appendTo(section);
		
		$('<label>Taille</label>').appendTo(size);
		
		var select = $('<select name="redactor_youtube_size"></select>').appendTo(size)
		.change(function() {
			if(this.value == 'custon')
				that.input_custom_size = $('<input type="text" name="redactor_youtube_size_width" class="redactor_input"/> x <input type="text" name="redactor_youtube_size_height" class="redactor_input"/>').appendTo(size);
			else
				if(that.input_custom_size)
					$(that.input_custom_size).remove();
		});
		
		for(var i in that.options.size)
			$('<option value="' + i + '">' + that.options.size[i].width + ' x ' + that.options.size[i].height + '</option>').appendTo(select);
		$('<option value="custon">Personalisé</option>').appendTo(select);
		
		
		$('<label>Position</label>').appendTo(section);
		
		var select = $('<select name="redactor_youtube_position"></select>').appendTo(section);
		
		$('<option value="">Normal</option>').appendTo(select);
		for(var i in that.options.position)
			$('<option value="' + i + '">' + that.options.position[i].name + '</option>').appendTo(select);
		
		var footer = $('<footer></footer>').appendTo('#redactor_youtube');
		
		$('<a href="#" class="redactor_modal_btn">Annuler</a>').appendTo(footer)
		.click(function() {
			that.modalClose();
		});
		
		$('<input type="button" name="redactor_youtube_submit" class="redactor_modal_btn" value="Insérer">').appendTo(footer);
	},
	setVideo: function() {
		var that = this;
		
		$('input[name=redactor_youtube_submit]').click(function() {
			var regex = new RegExp('^(http(s)?:)?\/\/(www\.)?(youtu\.be|youtube\.com)\/watch\\?(.*)v=([a-zA-Z0-9\-\_]{11})'),
				value = $('input[name=redactor_youtube_lien]').val(),
				youtube = value.match(regex);
			
			if(youtube && youtube[6]) {
				
				that.selectionRestore();
				
				var size = $('select[name=redactor_youtube_size]').val();
				
				if(that.options.size[size])
					var width = that.options.size[size].width,
						height = that.options.size[size].height;
				else 
					var width = parseInt($('input[name=redactor_youtube_size_width]').val()) < that.options.size[4].width ? $('input[name=redactor_youtube_size_width]').val() : that.options.size[1].width,
						height = parseInt($('input[name=redactor_youtube_size_height]').val()) < that.options.size[4].height ? $('input[name=redactor_youtube_size_height]').val() : that.options.size[1].height;
						
				var position = $('select[name=redactor_youtube_position]').val(),
					style = "";
					
				if(that.options.position[position])
					var style = that.options.position[position].style;
				
				that.insertHtml('<p class="' + style + '"><iframe width="' + width + '" height="' + height + '" src="http://www.youtube.com/embed/' + youtube[6] + '" frameborder="0" allowfullscreen></iframe></p><p>&#8203;​</p>');
				
				that.modalClose();
			}
			else {
				$('#error').empty().text('Lien non valide');
			}
		});
	}

}