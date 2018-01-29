/**
 * Theme functions file
 */
(function ($) {
    var $document = $(document);
    var $window = $(window);


    /**
    * Document ready (jQuery)
    */
    $(function () {


        /**
         * Activate superfish menu.
         */
        $('.sf-menu').superfish({
            'speed': 'fast',
            'delay' : 0,
            'animation': {
                'height': 'show'
            }
        });

        /**
         * Activate jQuery.mmenu.
         */

        $("#menu-top-slide").mmenu({
            slidingSubmenus: false
        });

        $("#menu-main-slide").mmenu({
            slidingSubmenus: false
        })


        /**
         * Activate FitVids.
         */
        $(".entry-content, .video-cover, .post-video").fitVids();



        /**
         * Activate main slider.
         */
        $('#slider').sllider();

        /**
         *
         */
        $.fn.responsiveSliderImages();


    });



    $.fn.sllider = function() {
        return this.each(function () {
            var $this = $(this);

            $this.flexslider({
                controlNav: true,
                directionNav: true,
                animationLoop: true,
                useCSS: true,
                smoothHeight: false,
                touch: true,
                pauseOnAction: true,
                slideshow: zoomOptions.slideshow_auto,
                animation: zoomOptions.slideshow_effect.toLowerCase(),
                slideshowSpeed: parseInt(zoomOptions.slideshow_speed, 10)
            });

        });
    };



    $.fn.responsiveSliderImages = function () {
        $(window).on('resize orientationchange', update);

        function update() {
            var windowWidth = $(window).width();

            if (windowWidth < 680) {
                $('#slider .slides li').each(function () {
                    var bgurl = $(this).css('background-image').match(/^url\(['"]?(.+)["']?\)$/)[1],
                        smallimg = $(this).data('smallimg');

                    if ( !bgurl || typeof smallimg === 'undefined' || bgurl == smallimg ) return;

                    $(this).css('background-image', 'url("' + smallimg + '")');
                });
            }

            if (windowWidth > 680) {
                $('#slider .slides li').each(function () {
                    var bgurl = $(this).css('background-image').match(/^url\(['"]?(.+)["']?\)$/)[1],
                        bigimg = $(this).data('bigimg');

                    if ( !bgurl || typeof bigimg === 'undefined' || bgurl == bigimg ) return;

                    if ( !$(this).data('smallimg') ) $(this).data('smallimg', bgurl);

                    $(this).css('background-image', 'url("' + bigimg + '")');
                });
            }
        }

        update();
    };

})(jQuery);