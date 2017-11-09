function appDocsItem() {

    /**
     * Bind delete buttons
     */
    $('.document .document-delete').on('confirmed', function() {
        var $this = $(this);
        var $document = $this.closest('.document');
        var redirectUrl = $document.data('after-delete-redirect');
        $this.prop('disabled', true);
        $document.css('opacity', OPACITY_DISABLED);
        $.ajax({
            url: app.baseUrl + '/staff/docs/delete?id=' + $document.data('id'),
            success: function() {
                if (redirectUrl) {
                    location.href = redirectUrl;
                } else {
                    $document.remove();
                }
            }
        });
    });

}