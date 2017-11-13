function appStaffNewsEdit() {

    var self = this;
    self.init();

    // Init uploader
    self.initUploader();

    /**
     * On window unload
     */
    window.onbeforeunload = function() {
        if ($('.btn.save-news', self.$form).is(':disabled')) {
            return;
        } else {
            return _t('appjs', 'You have unsaved changes.');
        }
    };

    /**
     * Save news
     */
    $('.btn.save-news', self.$form).on('click', function() {
        var $selfElement = $(this);
        $selfElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/staff/news/edit?' + $.param({
                id:      $('[name=id]', self.$form).val(),
                lang:    $('[name=lang]', self.$form).val()
            }),
            data: {
                title:   $('[name=title]', self.$form).val(),
                content: self.editor.getData(),
                geo:     $('[name=filter-geo]:checked', self.$form).val()
            },
            success: function(response) {
                appShowErrors(response.errors, self.$form);
                if (response.errors) {
                    $selfElement.prop('disabled', false);
                    return;
                } else {
                    if (response.isNew) {
                        location.href = response.url;
                    } else {
                        $('.news-status-switcher .btn').prop('disabled', false);
                    }
                }
            }
        });
    });

    /**
     * Upload images for news
     */
    $('#uploadNewsImages').on('click', function() {
        self.uploader.start();
    });

    /**
     * Delete image
     */
    $('.news-edit__image-item > button').on('confirmed', function(event){
        event.preventDefault();
        var imageId = $(this).closest('div').data('image-id');
        $.ajax({
            url: app.baseUrl + '/staff/news/delete-image',
            data: {
                imageId: imageId
            },
            success: function(response) {
                $('#uploadImagesContainer').find('button').removeClass('hide');
                $('[data-image-id=' + imageId + ']').remove();
            }
        });
    });

}

appStaffNewsEdit.prototype = appStaffNewsManage.prototype;

/**
 * Init uploader
 */
appStaffNewsEdit.prototype.initUploader = function () {

    var self = this;

    self.uploader = new plupload.Uploader(pluploadHelpersSettings({
        browse_button:    'uploadNewsImages',
        container:        'uploadImagesContainer',
        url:              app.baseUrl + '/upload/images',
        multipart_params : {
            '_csrf': app.csrfToken
        },
        filters: {
            mime_types: [
                { title : "Image files", extensions : "jpg,jpeg,png" }
            ]
        }

    }));

    self.uploader.init();

    self.uploader.bind('FilesAdded', function(up, files) {
        $('#uploadNewsImages').closest('.form-group')
            .removeClass('has-error')
            .find('.help-block').text('');
        self.uploader.start();
        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('BeforeUpload', function (up, file) {
        var fileExt = file.name.split('.').pop();
        up.settings.multipart_params.uniqueName = $.fn.uniqueId() + '.' + fileExt;
        up.settings.multipart_params.newsId     = $('[name=id]').val();
    });

    self.uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    self.uploader.bind('Error', function(up, err) {
        $('#uploadNewsImages').closest('.form-group')
            .addClass('has-error')
            .find('.help-block').text(err.message);

        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('FileUploaded', function(up, file, res) {
        var response = JSON.parse(res.response);
        if (!response.errors) {
            $('.news-edit__image-item.hide')
                .first()
                .clone(true)
                .removeClass('hide')
                .attr('data-image-id', response.id)
                .appendTo('.images-block')
                .find('img').attr('src', '/news/image?id=' + response.id);

            if ($('.news-edit__image-item[data-image-id]').length >= $('#uploadImagesContainer').data('images-limit')) {
                $('.btn-upload').addClass('hide');
            }
        } else {
            $('#uploadNewsImages').closest('.form-group')
                .addClass('has-error')
                .find('.help-block').text(response.message);
        }
    });
};