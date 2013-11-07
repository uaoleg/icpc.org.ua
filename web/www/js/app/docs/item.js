function appDocsItem() {

    /**
     * Bind delete buttons
     */
    $('.document .document-delete').on('confirmed', function() {
        var $this = $(this),
            $document = $this.closest('.document');
        $this.prop('disabled', true);
        $document.css('opacity', OPACITY_DISABLED);
        $.ajax({
            url: app.baseUrl + '/staff/docs/delete',
            data: {
                id: $document.data('id')
            },
            success: function() {
                $document.remove();
            }
        });
    });

}