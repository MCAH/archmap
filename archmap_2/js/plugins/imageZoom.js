/*
* jQuery.fn.imageZoom( options );
*
* Turns a simple image to a super sweet zoomable image
*
* $('.element').imageZoom({
*     small: 'the small image to show',
*     original: 'The image we show when over',
*     viewpoint: {
*         width: 'width of viewpoint',
*         height: 'height of viewpoint'
*     }
* });
*
* Version 0.2.2
* www.labs.skengdon.com/imageZoom
* www.labs.skengdon.com/imageZoom/js/imageZoom.min.js
*/
;(function($){
	$.fn.imageZoom = function( options ) {
		var settings = {
			viewpoint: {
				width: 150,
				height: 100
			}
		};
		$.extend(true, settings, options);
		return this.each(function() {
			var $loader = document.createElement('div');
			$(this).append($loader);
			
			var $image = document.createElement('img');
			$(this).append($image);
			
			var $viewpoint = document.createElement('div');
			$(this).append($viewpoint);
			
			var $loader = $($loader);
			var $image = $($image);
			var $viewpoint = $($viewpoint);
			var $viewpointImage = new Image;
			
			var pos = ( $(this).css('position') == 'static' ) ? 'relative' : $(this).css('position');
			$(this).css({
				position: pos,
				overflow: 'hidden'
			});
			
			$loader.addClass('imageZoom_loading');
			$loader.text('Loading...');
			$loader.css({
				'margin': '100px',
				'padding': '30px 70px',
				'text-align': 'center',
				'background': '#222',
				
				'border-radius': '10px',
				'-o-border-radius': '10px',
				'-moz-border-radius': '10px',
				'-webkit-border-radius': '10px'
			});
			
			$image.attr('src', settings.small);
			$image.css({
				width: $(this).width() 
			});
			
			$viewpointImage.src = settings.original;
			$viewpoint.addClass('imageZoom_viewpoint');
			$viewpoint.css({
				width: settings.viewpoint.width,
				height: settings.viewpoint.height,
				display: 'none',
				position: 'absolute',
				background: 'url(' + $viewpointImage.src + ') 0 0 no-repeat',
				'border': '1px solid #222',
				'box-shadow': '0 0 20px #000',
				'-o-box-shadow': '0 0 20px #000',
				'-moz-box-shadow': '0 0 20px #000',
				'-webkit-box-shadow': '0 0 20px #000'
			});
			
			var $this = $(this);
			
			var interval = setInterval(function(){
				
				$image.hide();
				$loader.show();
				
				if ( $viewpointImage.complete ) {
					clearInterval(interval);
					$loader.hide();
					$image.show();
					$this.mousemove(function( event ){
						$viewpoint.hide();
						
						var vars = {};
						vars.width2height = $(this).width() / $(this).height();
						vars.image2viewpoint = $image.width() / $viewpointImage.width;
						vars.mouse = {};
						vars.mouse.top = event.pageY - $(this).offset().top;
						vars.mouse.left = event.pageX - $(this).offset().left;
						
						vars.viewpoint = {};
						vars.viewpoint.position = {};
						vars.viewpoint.position.top = vars.mouse.top - $viewpoint.height() / 2;
						vars.viewpoint.position.left = vars.mouse.left - $viewpoint.width() / 2;
						vars.viewpoint.image = {};
						vars.viewpoint.image.top = - vars.mouse.top / vars.image2viewpoint + $viewpoint.height() / 2;
						vars.viewpoint.image.left = - vars.mouse.left / vars.image2viewpoint + $viewpoint.width() / 2;
						
						$viewpoint.css({
							top: vars.viewpoint.position.top,
							left: vars.viewpoint.position.left
						});
						$viewpoint.css({
							'background-position': vars.viewpoint.image.left + 'px ' + vars.viewpoint.image.top + 'px'
						});
						
						$viewpoint.show();
					});
					$this.mouseout(function(){
						$viewpoint.hide();
					});
				}
			},50);
		});
	};
})(jQuery);