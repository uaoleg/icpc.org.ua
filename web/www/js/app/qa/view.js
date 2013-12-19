function appQaView() {

    /**
     * Init editor for answer
     */
    var editor = CKEDITOR.replace('answer-content', {
        toolbar: [
            [ 'Bold', 'Italic', 'Underline', 'Strike' ],
            [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ],
            [ 'Undo', 'Redo' ],
        ],
        extraPlugins: 'onchange',
        height: '200px'
    });

    /**
     * Give answer
     */
    $('.answer-create').on('click', function(){
        var $this = $(this);
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/qa/answer',
            data: {
                questionId: $('input[name=questionId]').val(),
                content:    editor.getData()
            },
            success: function(response) {
                $this.prop('disabled', false);
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    editor.setData('');
                    $('.qa-answer-list').append(response.answerHtml);
                    $('.qa-answer-count').text(response.answerCount).removeClass('hide');
                }
            }
        });
    });

}