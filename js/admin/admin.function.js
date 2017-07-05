
(function($){
	
	$.extend({
		modules: {
			editor: {
				name: 'Page vierge',
				options: false
			},
			image_text: {
				name: 'Images & Texte',
				options: {
					title:{
						name:"Titre",
						options: {
							Titre: 'Oui',
							false: 'Non',
						},
					},
					position:{
						name:"Position des images",
						options: {
							left: 'Gauche',
							right: 'Droite',
						},
					},
					image_size: {
						name:"Taille des images",
						options: {
							200: '200 x 200',
							300: '300 x 300',
							400: '400 x 400',
							500: '500 x 500',
							custom: 'Personalisé',
						},
						custom: '<input class="custom" type="text" name="image_width" value="300" /><span class="text-custom">x</span><input class="custom" type="text" name="image_height" value="300" />',
					},
					time: {
						name:"Défilement des images",
						options: {
							4: '4 secondes',
							8: '8 secondes',
							12: '12 secondes',
							15: '16 secondes',
							custom: 'Personalisé',
						},
						custom: '<input class="custom" type="text" name="time" value="8" /><span class="text-custom">secondes</span>',
					},
				}
			},
			sliders: {
				name: 'Slider',
				options: {
					direction:{
						name:'Direction',
						options: {
							left: 'Gauche',
							right: 'Droite',
						},
					},
					time: {
						name:"Défilement",
						options: {
							3: '3 secondes',
							5: '5 secondes',
							7: '7 secondes',
							10: '10 secondes',
							custom: 'Personalisé',
						},
						custom: '<input class="custom" type="text" name="time" value="5" /><span class="text-custom">secondes</span>',
					},
					height: {
						name:'Hauteur',
						options: {
							300: '300px',
							350: '350px',
							400: '400px',
							450: '450px',
							500: '500px',
							custom: 'Personalisé',
						},
						custom: '<input class="custom" type="text" name="height" value="350" /><span class="text-custom">px</span>',
					},
				},
			},
			albums: {
				name: 'Album photos',
				options: false
			},
		},
		
		_upload:function(current_file, min_max, width, height,_function) {
		
			var reader = new FileReader();
			if (current_file.type.indexOf('image') == 0) {
				reader.onload = function (event) {
					var image = new Image();
					image.src = event.target.result;
					image.onload = function() {
						var imageWidth = image.width,
						imageHeight = image.height,
						scaleWidth = width / imageWidth,
						scaleHeight = height / imageHeight;
						
						if(min_max == 'min')
							var scale = scaleWidth > scaleHeight ? scaleWidth : scaleHeight;
						else
							var scale = scaleWidth < scaleHeight ? scaleWidth : scaleHeight;
						
						if(scale < 1) {
							imageWidth = imageWidth * scale;
							imageHeight = imageHeight * scale;
						}

						var canvas = document.createElement('canvas');
						canvas.width = imageWidth;
						canvas.height = imageHeight;
						image.width = imageWidth;
						image.height = imageHeight;
						var ctx = canvas.getContext("2d");
						ctx.drawImage(this, 0, 0, imageWidth, imageHeight);
						
						_function(canvas.toDataURL(current_file.type));
					}
				}
				reader.readAsDataURL(current_file);
			}
		},
		
	});
})(jQuery);