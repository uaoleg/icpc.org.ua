function appStaffTeamSchoolComplete() {

    /**
     * Save school info
     */
    $('.btn-save').on('click', function(){
        var $this = $(this),
            $form = $this.closest('.form');
        $this.prop('disabled', true);

        $.ajax({
            url: app.baseUrl + '/staff/team/school-complete',
            data: {
                shortNameUk:    $('[name=shortNameUk]').val(),
                fullNameEn:     $('[name=fullNameEn]').val(),
                shortNameEn:    $('[name=shortNameEn]').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = response.url;
                }
            }
        });
    });

}