
(function ($) {

    $.widget("ui.sliders", {

        options: {
			animate:true,
			width:980,
		},
		
		_create: function () {
			
			var that = this;
			
			var fleche1 = $('<button class="fleche fleche-left">').appendTo(that.element)
			.click(function() {
				if(!that.courant) that._animate_left();
			});
			
			var fleche2 = $('<button class="fleche fleche-right">').appendTo(that.element)
			.click(function() {
				if(!that.courant) that._animate_right();
			});
			
			that.contenu = $('<ul id="sliders-ul-' + that.options.key + '"></ul>').appendTo(that.element);
			
			for(var i in that.options.data.image) 
				$('<li></li>').css('background-image', 'url(img/modules/sliders/' + that.options.key + '/' + that.options.data.image[i] + ')').appendTo(that.contenu);
			
			setInterval(function () { 
				if(!that.options.animate)
					return;
				if(that.options.data.direction == 'left')
					that._animate_right();
				else 
					that._animate_left();
			}, that.options.data.time);
			
			$(that.element).hover(
				function () {
					if(that.element.hasClass('ui-draggable'))
						return;
					that.options.animate = false;
					$(fleche1).css('display', 'block');
					$(fleche2).css('display', 'block');
				},
				function () {
					
					that.options.animate = true;
					$(fleche1).css('display', 'none');
					$(fleche2).css('display', 'none');
				}
			);
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