function appStaffNewsManage() {}

/**
 * Init manage page
 */
appStaffNewsManage.prototype.init = function() {

    var self = this;
    self.$form = $('.form-horizontal');

    // On changed
    $('input, select', self.$form).on('keydown change', function() {
        self.onchange();
    });

    // Init ckeditor
    self.editor = CKEDITOR.replace($('textarea[name=content]', self.$form)[0], {
        extraPlugins: 'onchange',
        height: '400px',
        toolbar: [
            {
                name: 'styles',
                items: ['Format']
            },
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Strike']
            },
            {
                name: 'links',
                items: ['Link', 'Unlink', 'Anchor']
            },
            {
                name: 'list',
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            },
            {
                name: 'cleanup',
                items: ['RemoveFormat']
            }
        ]
    });
    self.editor.on('change', function(e) {
        self.onchange();
    });

    // On Ctrl + S
    $(document).onCtrlS(function(){
        self.save();
    }, self.editor);

};

/**
 * On change event
 */
appStaffNewsManage.prototype.onchange = function() {
    $('.news-status-switcher .btn').prop('disabled', true);
    $('.btn.save-news').prop('disabled', false);
};

appStaffNewsManage.prototype.save = function() {
    $('.btn.save-news').click();
}