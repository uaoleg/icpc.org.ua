function appStaffDocsEdit() {

    var self = this,
        $form = $('.form-horizontal');
    self.$form = $form;

    // Init uploader
    self.initUploader();

    // On change
    $('input, textarea, select', $form).on('keydown change', function() {
        if ((self.uploader.files.length > 0) || ($('[name=id]', $form).val().length > 0)) {
            self.onchange();
        }
    });

    // Save news
    $('.btn.save-document', $form).on('click', function(e) {
        $(this).prop('disabled', true);
        $('#pickfiles').prop('disabled', true);
        if ($('[name=id]', $form).val()) {
            $.ajax({
                url: app.baseUrl + '/staff/docs/edit',
                data: {
                    id:    $('[name=id]', $form).val(),
                    title: $('[name=title]', $form).val(),
                    desc:  $('[name=desc]', $form).val(),
                    type:  $('[name=type]', $form).val()
                },
                success: function(response) {
                    appShowErrors(response.errors, $form);
                    if (response.errors) {
                        return;
                    } else {
                        location.href = app.baseUrl + '/docs/' + $('[name=type]', $form).val();
                    }
                }
            });
        } else {
            self.uploader.start();
        }
    });

}

/**
 * On change event
 */
appStaffDocsEdit.prototype.onchange = function() {
    $('.btn.save-document').prop('disabled', false);
}

/**
 * Init uploader
 */
appStaffDocsEdit.prototype.initUploader = function () {

    var self = this;

    self.uploader = new plupload.Uploader({
        runtimes:         'html5,flash,silverlight,browserplus',
        browse_button:    'pickfiles',
        container:        'container',
        max_file_size:    '10mb',
        multi_selection:  false,
        url:              app.baseUrl + '/upload/document',
        multipart_params: {},
        resize: {width: 320, height: 240, quality: 90}
    });

    self.uploader.init();

    self.uploader.bind('FilesAdded', function(up, files) {
        $('#pickfiles').closest('.form-group')
            .removeClass('has-error')
            .find('.help-block').text('');
        $.each(files, function(i, file) {
            $('.document-origin-filename').text(file.name);
        });
        self.onchange();

        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('BeforeUpload', function (up, file) {
        var fileExt = file.name.split('.').pop();
        up.settings.multipart_params.uniqueName = $.fn.uniqueId() + '.' + fileExt;
        up.settings.multipart_params.title      = $('[name=title]', self.$form).val();
        up.settings.multipart_params.desc       = $('[name=desc]', self.$form).val();
        up.settings.multipart_params.type       = $('[name=type]', self.$form).val();
    });

    self.uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    self.uploader.bind('Error', function(up, err) {
        $('#pickfiles').closest('.form-group')
            .addClass('has-error')
            .find('.help-block').text(err.message);

        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('FileUploaded', function(up, file) {
        location.href = app.baseUrl + '/docs/' + $('[name=type]', self.$form).val();
    });
}