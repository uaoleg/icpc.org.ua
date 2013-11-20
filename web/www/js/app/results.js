function appResults() {
    var self = this;

    // Init uploader
    self.initUploader();

    $('#uploadResults').on('click', function(){
        if ($('[name=phase]:checked').length !== 1) {
            $('[name=phase]').closest('.form-group').addClass('has-error');
        } else {
            $(this).add('#pickfiles, [name=phase]').prop('disabled', true);
            self.uploader.start();
        }
    });
}

/**
 * Init uploader
 */
appResults.prototype.initUploader = function () {

    var self = this;

    self.uploader = new plupload.Uploader(pluploadHelpersSettings({
        browse_button:    'pickfiles',
        container:        'upload_container',
        url:              app.baseUrl + '/upload/results'
    }));

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
        up.settings.multipart_params.phase      = $('[name=phase]:checked').val();
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
        location.href = app.baseUrl + '/results';
    });
}

appResults.prototype.onchange = function() {
    $('#uploadResults').prop('disabled', false);
}