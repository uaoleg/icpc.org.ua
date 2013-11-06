/**
 * Returns settings for plupload with default
 *
 * @param {Object} settings
 * @return {Object}
 */
function pluploadHelpersSettings(settings) {
    var defaults = {
        runtimes:            pluploadHelpersRuntimes(),
        max_file_size:       '10mb',
        multi_selection:     false,
        multipart_params:    {},
        flash_swf_url:       app.baseUrl + '/lib/plupload-2.0.0-beta/js/Moxie.swf',
        silverlight_xap_url: app.baseUrl + '/lib/plupload-2.0.0-beta/js/Moxie.xap'
    };
    return $.extend({}, defaults, settings);
}

/**
 * Define plupload runtimes relying on browser
 *
 * @return {String}
 */
function pluploadHelpersRuntimes() {
    var runtimes;
    if ($.browser.msie) {
        runtimes = 'html5,silverlight,gears,browserplus';
    } else {
        runtimes = 'html5,silverlight,flash,gears,browserplus';
    }
    return runtimes;
}