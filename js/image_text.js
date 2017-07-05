
(function ($) {

    $.widget("ui.image_text", {

        options: {
			animate:true,
		},
		
		_create: function () {
			
			var that = this;
			
			that.contenu = $('<ul id="image_text-ul-' + that.options.key + '"></ul>').appendTo(that.element);
			
			for(var i in that.options.data.image) 
				$('<li></li>').css({'background-image':'url(img/modules/image_text/' + that.options.key + '/' + that.options.data.image[i] + ')','width':that.options.data.image_width}).appendTo(that.contenu);
			
			setInterval(function () { 
				if(that.options.animate) that._animate();
			}, that.options.data.time);
			
			$(that.element).hover(
				function () {
					that.options.animate = false;
				},
				function () {
					that.options.animate = true;
				}
			);
		},
		
		_animate: function() {
			
			var that = this;
			
			that.courant = true;
			
			$('#image_text-ul-' + that.options.key + ' li:last').prependTo(that.contenu);
			$(that.contenu).css('left', '-'+ that.options.data.image_width + 'px');
			
			$(that.contenu).animate({
				left: '+=' + that.options.data.image_width
			}, 500, function() {
				$(that.contenu).css('left', '0');
				that.courant = false;
			});
		}
    });

})(jQuery);