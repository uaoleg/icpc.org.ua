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
    var $inputTagList = $('input[name=tagList]');
    $inputTagList.select2({
        minimumInputLength: 1,
        maximumSelectionSize: 10,
        multiple: true,
        width: '500',
        initSelection: function(element, callback) {
            var data = [];
            $(element.val().split(',')).each(function () {
                data.push({id: this, text: this});
            });
            callback(data);
        },
        ajax: {
            url: app.baseUrl + '/qa/tagList',
            dataType: 'json',
            data: function (term, page) {
                return {
                    q: term,
                    page_limit: 10
                };
            },
            results: function (data, page) {
                return {results: data.tags};
            }
        },
        escapeMarkup: function (m) { return m; },
        formatSelection: function(item) {
            return item.text;
        },
        formatResult: function(item) {
            return item.text;
        },
        dropdownCssClass: 'bigdrop'
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
                tagList:    $('input[name=tagList]').val()
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

    /**
     * Tags list: tag click
     */
    $('.tags-list span').on('click', function() {
        $inputTagList.select2(
            "val",
            $inputTagList
                .select2('val')
                .concat([$(this).text()])
        );
    });

}