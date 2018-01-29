/**
 * Esto es para las magias del middle-menu
 */
(function ($) {
    $('div#middle-group ul li a[data-toggle="collapse"]').click(function () {
        $('.collapse-style.collapse.show').collapse('hide');
        $(this).parent().removeClass('menu-middle-inactive');
        $(this).parent().addClass('menu-middle-active');

    });
    $('.menu-middle-link').not('collapsed').click(function () {
        $(this).parent().siblings().removeClass('menu-middle-inactive');
        $(this).parent().siblings().addClass('menu-middle-active');

    });
    $('div#middle-group').on('shown.bs.collapse', function () {
        $('.menu-middle-link.collapsed').parent().addClass('menu-middle-inactive');
        $('.menu-middle-link.collapsed').parent().removeClass('menu-middle-active');
    })


    $('#carousel_secundario_noticias').carousel()



})(jQuery);