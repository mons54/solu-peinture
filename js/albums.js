
(function ($) {

    $.widget("ui.albums", {

        options: {
			animate:true,
			width:980,
		},
		
		_create: function () {
			
			var that = this;
			
			var img = $._get_first_object(that.options.data.image);
			
			that.photo = $('<img class="photo" src="img/modules/albums/' + that.options.key + '/' + img + '">').appendTo(that.element);
			
			var mini = $('<div class="mini-photo"></div>').appendTo(that.element);
			that.mini = $('<div class="ct-mini-photo"></div>').appendTo(mini);
			
			for(var i in that.options.data.image)
				that._mini_photo(i);
				
			var width = mini.width(),
				last = that.mini.find('a:last-child');
			
			mini.scrollLeft(0).unbind('mousemove').bind('mousemove',function(e){
				
				var _width = last[0].offsetLeft + last.outerWidth() - 20;

				var left = (e.pageX - mini.offset().left) * (_width-width) / width;
				mini.scrollLeft(left);
			});
		},
		
		_mini_photo:function(i) {
			var that = this;
			
			var img = that.options.data.image[i];
			
			$('<a href="#" class="mini"></a>').css('background-image', 'url(img/modules/albums/' + that.options.key + '/' + img + ')').appendTo(that.mini)
			.hover(
				function () {
					$(this).css('opacity', '1');
				},
				function () {
					$('.mini-photo .mini').css('opacity', '0.5');
				}
			)
			.click(function() {
				$(that.photo).attr('src', 'img/modules/albums/' + that.options.key + '/' + img);
				return false;
			});
		},
		
		_animate_right: function() {
			
			var that = this;
			
			that.courant = true;
			
			$(that.contenu).animate({
				left: '-=' + that.options.width
			}, 500, function() {
				$('#sliders-ul-' + that.options.key + ' li:first').appendTo(that.contenu);
				$(that.contenu).css('left', '0');
				that.courant = false;
			});
		},
		
		_animate_left: function() {
			
			var that = this;
			
			that.courant = true;
			
			$('#sliders-ul-' + that.options.key + ' li:last').prependTo(that.contenu);
			$(that.contenu).css('left', '-'+ that.options.width + 'px');
			
			$(that.contenu).animate({
				left: '+=' + that.options.width
			}, 500, function() {
				$(that.contenu).css('left', '0');
				that.courant = false;
			});
		}
    });

})(jQuery);