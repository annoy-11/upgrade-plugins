(function ( $ ) {

    $.fn.imageProjection = function( $image, options ) {

        // The image that will be projected
        var originImage = new Image();
        originImage.src = $image.attr("src");

        // The projection of original image
        // Ideally the size is proportional to the original
        var projectedImage = new Image();

        var pWidth = originImage.width
        var pHeight = originImage.height

        // The ratio of original image to projected image, defaulted to one
        var widthRatio = 1;
        var heightRatio = 1;

        var $window = $(window);

        // The surface where viewfinder will be attached
        var $surface = this;
        var surfaceOffset = this.offset();

        // Making sure that everything works
        $surface.parent().css({
            position: "relative"
        });

        // Create the viewfinder and projected image container
        var $viewfinder = $( "<div id='ip-viewfinder'></div>" );
        var $projection = $("<div id='ip-projection' class='sesproduct_zoom_cnt'></div>");

        projectedImage.onload = function(){
            // Recalculate the ratio
            widthRatio = projectedImage.width / originImage.width;
            heightRatio = projectedImage.height / originImage.height;

            // Set the viewfinder size based on original image size
            $viewfinder.width( 100 );
            $viewfinder.height( 100 );

            // Set viewfinder position and hide it for the time being
            $viewfinder.css({
                position: "absolute",
                "z-index": 3,
                display: "none"
            });

            // Set projection size
            $projection.width( pWidth );
            $projection.height( pHeight );

            // Set projection position and place the image as background
            $projection.css({
                background: ("url('" + projectedImage.src + "') no-repeat 0 0"),
                display: "none",
                position: "absolute",
                left: $surface.width() + 30,
                top: 0,
                "z-index": 3
            });

            // Making sure that there are only one viewfinder and one projection
            $surface.find("#viewfinder").remove();
            $surface.parent().find("#projection").remove();

            // Put viewfinder and projection on their respective places
            $surface.append($viewfinder);
            $surface.parent().append($projection);

        };

        // Set up the projection image
        if(sesJqueryObject('#sessmoothbox_container').length == 0) {
            projectedImage.src = $image.data("pimg") == "" ? $image.attr("src") : $image.data("pimg");
        }else {
            projectedImage.src = sesJqueryObject('#sesproduct_preview_image').attr('src');
        }
        // Toggle the viewfinder and projection whenever the mouse cursor is inside the surface
        this.hover(
            function( event ){
                $viewfinder.fadeIn(500);
                $projection.fadeIn(500);
            },
            function( event ){
                $viewfinder.fadeOut(250);
                $projection.fadeOut(250);
            }
        );

        this.mousemove(function(event){

            // Whenever the mouse cursor is hovering the surface, update viewfinder position

            var windowScrollTop = 0;
            var windowScrollLeft = 0;

            var left = event.clientX;
            var top = event.clientY;
            var surfaceOffsetLeft = surfaceOffset.left;
            var surfaceOffsetTop = surfaceOffset.top;
            if(sesJqueryObject('.sessmoothbox_container').length){
                left = left - sesJqueryObject('.sessmoothbox_container').css('left').replace('px','');
                top = top - sesJqueryObject('.sessmoothbox_container').css('top').replace('px','');
                surfaceOffsetTop = sesJqueryObject('.sessmoothbox_container').css('top').replace('px','') - sesJqueryObject('.sessmoothbox_container').css('top').replace('px','');
                var leftMinus = 0;
                if(sesJqueryObject('.sesproduct_left_pnl').length){
                    leftMinus = sesJqueryObject('.sesproduct_left_pnl').css('width').replace('px','');
                }
                surfaceOffsetLeft =  sesJqueryObject('.sessmoothbox_container').css('left').replace('px','') - 15 - leftMinus;
            }
            setViewfinderPosition(Math.floor(left - surfaceOffsetLeft + windowScrollLeft), Math.floor(top - surfaceOffsetTop + windowScrollTop));

        });

        function setViewfinderPosition( mouseLeft, mouseTop ){
            // Keep the mouse pointer at the center of viewfinder.
            var viewfinderLeft = (mouseLeft - ($viewfinder.width() / 2));
            var viewfinderTop = (mouseTop - ($viewfinder.height() / 2));

            // Keep the viewfinder inside the surface.

            // Protect the top-left bounds.
            viewfinderLeft = Math.max( viewfinderLeft, 0 );
            viewfinderTop = Math.max( viewfinderTop, 0 );

            // Protect the bottom-right bounds. Because the
            // bottom and right need to take the dimensions
            // of the viewfinder into account, be sure to use
            // the outer width to include the border.
            viewfinderLeft = Math.min(
                viewfinderLeft,
                ($surface.width() - $viewfinder.outerWidth())
            );
            viewfinderTop = Math.min(
                viewfinderTop,
                ($surface.height() - $viewfinder.outerHeight())
            );

            // Position the viewfinder inside the surface.
            $viewfinder.css({
                left: (viewfinderLeft + "px"),
                top: (viewfinderTop + "px")
            });

            // Adjust the projected image as we move around the viewfinder.
            $projection.css("background-position", ((viewfinderLeft) * -1 * widthRatio) + "px" + " " + ((viewfinderTop) * -1 * heightRatio) + "px")
        };


        return this;

    };

}( sesJqueryObject ));