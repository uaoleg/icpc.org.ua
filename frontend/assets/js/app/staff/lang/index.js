/**
 * Langauges translations
 */
function appStaffLangIndex() {

    // Parse files
    $(document).on('click', '.btn.parse', function() {

        var $selfElement = $(this);

        // Send request
        $selfElement.prop('disabled', true);
        $('.alert').hide();
        $.ajax({
            url: app.baseUrl + '/staff/lang/parse',
            success: function() {
                $('.alert-success.parse-alert').show();
                $('table#message')[0].triggerToolbar();
            },
            complete: function() {
                $selfElement.prop('disabled', false);
            }
        });

    });

}