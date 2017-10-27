$(window).on('scroll', function(e) {
    var $navbar = $('#main > .container > .navbar'),
        height = $('.header-title').outerHeight() + $('.slogan').outerHeight();
    if ($(window).scrollTop() > height) {
        if ($navbar.hasClass('navbar-static-top')) {
            $('body').css('padding-top', height - 65 + 'px');
            $navbar.removeClass('navbar-static-top').addClass('navbar-fixed-top');
        }
    } else {
        $('body').css('padding-top', 0);
        $navbar.removeClass('navbar-fixed-top').addClass('navbar-static-top');
    }
});