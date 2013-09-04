$(window).on('scroll', function(e) {
    var $navbar = $('#main > .container > .navbar');
    if ($(window).scrollTop() > $('.header-title').outerHeight()) {
        if ($navbar.hasClass('navbar-static-top')) {
            $('body').css('padding-top', $('.header-title').outerHeight() + 'px');
            $navbar.removeClass('navbar-static-top').addClass('navbar-fixed-top');
        }
    } else {
        $('body').css('padding-top', 0);
        $navbar.removeClass('navbar-fixed-top').addClass('navbar-static-top');
    }
});