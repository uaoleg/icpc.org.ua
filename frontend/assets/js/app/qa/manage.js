function appQaManage() {

    /**
     * Init ckeditor for question contetn
     */
    var editor = CKEDITOR.replace('question-content', {
        toolbar: [
            [ 'Bold', 'Italic', 'Underline', 'Strike' ],
            [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ],
            [ 'Undo', 'Redo' ],
        ],
        extraPlugins: 'onchange',
        height: '300px'
    });

    /**
     * Init select2 for tags
     */
    $('[name=tagList]').select2({
        width: '500'
    });

    /**
     * Save question
     */
    $('.question-save').on('click', function(){
        $.ajax({
            url: app.baseUrl + '/qa/save',
            data: {
                id:         $('input[name=id]').val(),
                title:      $('input[name=title]').val(),
                content:    editor.getData(),
                tagList:    $('[name=tagList]').val()
            },
            success: function(response) {
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    location = response.url;
                }
            }
        });
    });
}