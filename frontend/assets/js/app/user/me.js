function appUserMe() {

    var self = this;

    // Init uploader
    self.initUploader();

    /**
     * Init Select2
     */
    $('.form-group .form-control[name=schoolId]').select2({
        'width': 'resolve'
    });

    /**
     * Type and Coordinator checkboxes
     */
    $(':checkbox[name=type], :checkbox[name=coordinator]').on('change', function() {
        var $group = $(this).closest('.btn-group');
        if ($(this).is(':checked')) {
            if ($(this).val() === 'student') {
                $('.btn:nth-child(2), .btn:nth-child(3)', $group).removeClass('active');
                $('.btn:nth-child(2) :checkbox, .btn:nth-child(3) :checkbox', $group).prop('checked', false).change();
            } else if (($(this).val() === 'coach') || ($(this).prop('name') === 'coordinator')) {
                $('.btn:nth-child(1)', $group).removeClass('active');
            }
        }
    });

    $(':checkbox[name=coordinator]').on('change', function() {

        var $this = $(this),
            $btn = $this.closest('.btn'),
            $group = $this.closest('.btn-group'),
            $dropdown = $group.next('.btn-group').find('.dropdown-menu:first');

        // Toggle dropdown menu
        if ($this.is(':checked')) {
            $dropdown.show();
        } else {
            $dropdown.hide();
        }

        // Select value
        $('li a', $dropdown).on('click', function() {
            $this.val($(this).data('val'));
            $('.caption', $btn).html($(this).html());
            $dropdown.hide();
            return false;
        });

        // Bind hide on document click
        if (!$this.data('hide-on-document-click')) {
            $this.data('hide-on-document-click', true);
            $(document).on('click', function(e) {
                var $target = $(e.target)
                if (!$target.hasClass('btn')) {
                    $target = $target.closest('.btn')
                }
                $target = $target.filter(function() {
                    return ($(':checkbox[name=coordinator]', this).length > 0);
                });
                if (!$target.length) {
                    $dropdown.hide();
                    if (!$this.val()) {
                        $btn.removeClass('active');
                        $(':checkbox', $btn).prop('checked', false).change();
                    }
                }
            });
        }

    });

    /**
     * Save button info handler
     */
    $('.js-save').on('click', function() {
        var $this = $(this),
            $form = $this.closest('.form-horizontal');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/me',
            data: {
                firstNameUk:           $('[name=firstNameUk]').val(),
                middleNameUk:          $('[name=middleNameUk]').val(),
                lastNameUk:            $('[name=lastNameUk]').val(),
                firstNameEn:           $('[name=firstNameEn]').val(),
                middleNameEn:          $('[name=middleNameEn]').val(),
                lastNameEn:            $('[name=lastNameEn]').val(),
                schoolId:              $('[name=schoolId]').val(),
                type:                  $('.form-group .btn.active [name=type]').val(),
                coordinator:           $('.form-group .btn.active [name=coordinator]').val(),
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/me';
                }
            }
        });
    });

    /**
     * Save button password handler
     */
    $('.btn-save-password').on('click', function() {
        var $this = $(this),
            $form = $this.closest('.form-horizontal');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/password-change',
            data: {
                currentPassword: $('[name=currentPassword]').val(),
                password:        $('[name=password]').val(),
                passwordRepeat:  $('[name=passwordRepeat]').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/me';
                }
            }
        });
    });
}

/**
 * Init uploader
 */
appUserMe.prototype.initUploader = function () {

    var self = this;

    self.uploader = new plupload.Uploader(pluploadHelpersSettings({
        browse_button:    'uploadPickfiles',
        container:        'uploadContainer',
        url:              app.baseUrl + '/upload/photo',
        filters: {
            mime_types: [
                { title : "Image files", extensions : "jpg,jpeg,png" }
            ]
        }
    }));

    self.uploader.init();

    self.uploader.bind('FilesAdded', function(up, files) {
        $('#uploadPickfiles')
            .prop('disabled', true)
            .closest('.form-group')
            .removeClass('has-error')
            .find('.help-block').text('');
        $.each(files, function(i, file) {
            $('.document-origin-filename').text(file.name);
        });
//        self.onchange();
        self.uploader.start();

        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('BeforeUpload', function (up, file) {
        var fileExt = file.name.split('.').pop();
        up.settings.multipart_params.uniqueName = $.fn.uniqueId() + '.' + fileExt;
    });

    self.uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    self.uploader.bind('Error', function(up, err) {
        $('#uploadPickfiles')
            .prop('disabled', false)
            .closest('.form-group')
            .addClass('has-error')
            .find('.help-block').text(err.message);
        up.refresh(); // Reposition Flash/Silverlight
    });

    self.uploader.bind('FileUploaded', function(up, file, res) {
        var response = JSON.parse(res.response);
        if (response.errors) {
            $('.help-block')
                .text(response.message)
                .closest('.form-group')
                .addClass('has-error');
        } else {
            $('#uploadPickfiles').prop('disabled', false);

            $('.js-user-photo').prop('src', app.baseUrl + '/user/photo?id=' + response.photoId + '.jpg');
        }

    });
};