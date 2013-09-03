$(window).on('scroll', function(e) {
    var $navbar = $('#main > .container > .navbar');
    if ($(window).scrollTop() > $('.header-title').outerHeight() * 2) {
        $navbar.removeClass('navbar-static-top').addClass('navbar-fixed-top');
    } else {
        $navbar.removeClass('navbar-fixed-top').addClass('navbar-static-top');
    }
});