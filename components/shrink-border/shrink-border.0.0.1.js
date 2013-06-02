// shrink-border.0.0.1.js
// Author Kenji Wong
// Lastest Modification 25/4/2013

(function($) {
    $.fn.shrinkBorder = function(options) {
        var defaultOptions = {
	    	border : "10px solid #0071BA",
	    	time   : 300,
	    	easing : "swing",
	    	zindex : "10"
		}
		var options = $.extend(defaultOptions, options);
		
	// iterate each matched DOM element
		return this.each(function() {
			var borderDiv = $("<div></div>");
			borderDiv.css("position", "absolute");
			borderDiv.css("width", $(this).children(".image").width());
			borderDiv.css("height", $(this).children(".image").height());
			borderDiv.css("border", options.border);
			borderDiv.css("z-index", options.zindex);

			var borderWidth = borderDiv.css("border-width");
			borderDiv.css("left", "-"+borderWidth);
			borderDiv.css("top", "-"+borderWidth);

			$(this).children(".image").append(borderDiv);
			$(this).on("mouseover", function(){
				var _w = $(this).children(".image").width() - parseInt(borderWidth,10)*2;
				var _h = $(this).children(".image").height() - parseInt(borderWidth,10)*2;
				borderDiv.stop().animate({ 
					left:0, 
					top:0,
					width:_w,
					height:_h,
				}, options.time, options.easing);
			});
			$(this).on("mouseout", function(){
				borderDiv.stop().animate({ 
					left 	: "-"+borderWidth, 
					top 	: "-"+borderWidth,
					width 	: $(this).children(".image").width(),
					height 	: $(this).children(".image").height()
				}, options.time, options.easing);
			});
		});
    }
})(jQuery)