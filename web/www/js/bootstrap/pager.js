$(document).ready(function() {

    // Disable click on disabled and active pages
    $('.pager .disabled a, .pagination .active a').on('click', function(e) {
        e.preventDefault();
        return false;
    });

});