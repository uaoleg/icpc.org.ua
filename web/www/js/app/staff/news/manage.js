function appStaffNewsManage() {}

/**
 * Init manage page
 */
appStaffNewsManage.prototype.init = function() {

    var self = this;
    self.$form = $('.form-horizontal');

    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.keyCode === 83) {
            self.save();
            e.preventDefault();
        }
    });

    // On language changed
    $('select', self.$form).on('change', function() {
        self.onchange();
    });

    // On title changed
    $('input', self.$form).on('keydown', function() {
        self.onchange();
    });

    // Init ckeditor
    self.editor = CKEDITOR.replace($('textarea.content', self.$form)[0], {
        extraPlugins: 'onchange',
        height: '400px'
    });
    self.editor.on('change', function(e) {
        self.onchange();
    });

    self.editor.addCommand("saveNews", {
        exec: function () {
            self.save();
        },
        modes: {
            wysiwyg: 1,
            source: 1
        },
        readOnly: 1,
        canUndo: !1
    });

    self.editor.setKeystroke(CKEDITOR.CTRL + 83, "saveNews");

};

/**
 * On change event
 */
appStaffNewsManage.prototype.onchange = function() {
    $('.btn.save-news').prop('disabled', false);
};

appStaffNewsManage.prototype.save = function() {
    $('.btn.save-news').click();
}