function appResultsLatest() {
    
    var self = this;

    // Init uploader
    self.initUploader();

    // Upload results
    $('#uploadResults').on('click', function(){
        if ($('[name=filter-geo]:checked').length !== 1) {
            $('[name=filter-geo]').closest('.form-group').addClass('has-error');
        } else {
            $(this).add('#uploadPickfiles').prop('disabled', true);
            $('[data-toggle=buttons] > label').addClass('disabled');
            self.uploader.start();
        }
    });
}

/**
 * Init uploader
 */
appResultsLatest.prototype.initUploader = function () {

    var self = this;

    self.uploader = new plupload.Uploader(pluploadHelpersSettings({
        browse_button:    'uploadPickfiles',
        container:        'uploadContainer',
        url:              app.baseUrl + '/upload/results'
    }));

    self.uploader.init();

    self.uploader.bind('FilesAdded', function(up, files) {
        $('#uploadPickfiles').closest('.form-group')
            .removeClass('has-error')
            .find('.help-block').text('');
        $.each(files, function(i, file) {
            if (file.name.split('.')[1] !== 'html') {
                self.uploader.trigger('Error', {message: 'not-html'});
            } else {
                self.onchange();
            }
            $('.document-origin-filename').text(file.name);
        });

        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('BeforeUpload', function (up, file) {
        var fileExt = file.name.split('.').pop();
        up.settings.multipart_params.uniqueName = $.fn.uniqueId() + '.' + fileExt;
        up.settings.multipart_params.geo        = $('[name=filter-geo]:checked').val();
    });

    self.uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    self.uploader.bind('Error', function(up, err) {
        var $helpBlock = $('#uploadPickfiles').closest('.form-group')
                        .addClass('has-error')
                        .find('.help-block');
        if ($helpBlock.data(err.message) != undefined) {
            $helpBlock.text($helpBlock.data(err.message));
        } else {
            $helpBlock.text(err.message);
        }
        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('FileUploaded', function(up, file) {
        location.href = app.baseUrl + '/results';
    });
}

appResultsLatest.prototype.onchange = function() {
    $('#uploadResults').prop('disabled', false);
}