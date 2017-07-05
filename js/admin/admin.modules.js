
(function ($) {

    $.widget("ui.admin_modules", {
		
		_create: function () {
			
			var that = this;
		},
		
		_init: function () {
			
			var that = this;
			
			that.div = $('<div></div>').appendTo(that.element);
			
			$('<button class="edit">Ajouter un module</button>').appendTo(that.div)
			.click(function() {
				that._ajouter_modules();
			});
			
			$('<button class="edit">Déplacer les modules</button>').appendTo(that.div)
			.click(function() {
				that._gerer_modules();
			});
		},
		
		_ajouter_modules:function() {
			var that = this;
			
			$('#dial').css('display', 'block');
				
			var fenetre = $('<div class="fenetre"></div>').appendTo(dial);
			
			$('<button class="close"></button>').appendTo(fenetre)
			.click(function () {
				$('#dial').css('display', 'none');
				$('.fenetre').remove();
			});
			
			$('<h3>Ajouter un module</h3>').appendTo(fenetre);
			
			var form = $('<form id="form-modules" action="' + document.URL + '" method="post"></form>').appendTo(fenetre);
			
			var div = $('<div class="form"></div>').appendTo(form);
			$('<label>Module</label>').appendTo(div);
			var select = $('<select name="module"></select>').appendTo(div)
			.change(function() {
				
				$(that.div_options).empty().html();
				
				var i = this.value,
					options = $.modules[i].options;
				
				if(options) {
					that.custom = {};
					for(var i in options)
						that._options_modules(options, i);
				}
			});
			
			for(var i in $.modules)
				$('<option value="' + i + '">' + $.modules[i].name + '</option>').appendTo(select);
				
			that.div_options = $('<div></div>').appendTo(form);
			
			var div = $('<div class="form"></div>').appendTo(form);
			$('<button type="submit" name="ajouter-module">Ajouter</button>').appendTo(div);
		},
		
		_options_modules: function(options,i) {
			var that = this;
			
			var div = $('<div class="form"></div>').appendTo(that.div_options);
			$('<label>' + options[i].name + '</label>').appendTo(div);
			
			if(options[i].options) {
				var select = $('<select name="' + i + '"></select>').appendTo(div)
				.change(function() {
					if(this.value == 'custom')
						$(options[i].custom).appendTo(that.custom[i]);
					else 
						$(that.custom[i]).empty().html();
				});
				for(var _i in options[i].options)
					$('<option value="' + _i + '">' + options[i].options[_i] + '</option>').appendTo(select);
					
				that.custom[i] = $('<span></span>').appendTo(div);
			}
		},
		
		_gerer_modules:function() {
			var that = this;
			
			$('.redactor_editor').redactor('destroy').css('margin', '');
			that._draggable('.module section');
			that._droppable('.module');
			
			$(that.div).empty().html();
			
			$('.edit').css('display', 'none');
			
			$('<button class="edit">Annuler</button>').appendTo(that.div)
			.click(function() {
				top.location = document.URL;
			});
			$('<button class="edit">Sauvegarder</button>').appendTo(that.div)
			.click(function() {
				$.post('ajax/admin/modules/change', {file:that.options.file, data:that.options.data}, function(data) {
					top.location = document.URL.replace('#', '');
				});
			});
		},
		
		_draggable: function(section) {
			
			var that = this;
			
			var module = $(section).attr('id').split('-');
			
			$(section).draggable({
				helper: 'clone',
				zIndex: '99999999',
				key: module[1]
			});
		},
		
		_droppable: function(section) {
			
			var that = this;
			
			$(section).droppable({
				hoverClass: "draggable-hover",
				drop: function (event, ui) {
					
					var drop = $(this).attr('id').split('-'),
						drop = drop[1] ? drop[1] : false,
						drag = ui.draggable.parent().attr('id').split('-'),
						drag = drag[1] ? drag[1] : false;
					
					if(!that.options.data[drop] || !that.options.data[drag])
						return;
						
					var _drop = that.options.data[drop],
						_drag = that.options.data[drag];
						
					that.options.data[drop] = _drag;
					that.options.data[drag] = _drop;
					
					$(this).children().appendTo(ui.draggable.parent());
					$(ui.draggable).appendTo(this);
				}
			});
		}
		
	 });

})(jQuery);