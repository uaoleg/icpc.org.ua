function appStaffQatagsManage() {

    /**
     * Init CKEditor
     */
    var editor = CKEDITOR.replace('tag-desc', {
        extraPlugins: 'onchange',
        height: '200px'
    });

    /**
     * Save tag
     */
    $('.save-tag').on('click', function(){
        $.ajax({
            url: app.baseUrl + '/staff/qatags/manage',
            data: {
                id:   $('input[name=id]').val(),
                name: $('input[name=name]').val(),
                desc: editor.getData()
            },
            success: function(response) {
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    location = app.baseUrl + '/staff/qatags';
                }
            }
        });
    });

}