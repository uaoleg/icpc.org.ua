/**
 * Default settings for jqGrid
 */
(function($) {
    if ($.jgrid) {
        var defaults = {
            cellEdit:       true,
            cellsubmit:     'remote',
            datatype:       'json',
            height:         400,
            pager:          '#message-pager',
            rowNum:         20,
            scroll:         1,
            shrinkToFit:    true,
            viewrecords:    true,
            width:          1140
        };
        $.extend($.jgrid.defaults, defaults);
    }
}(jQuery));