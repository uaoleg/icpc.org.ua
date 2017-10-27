function appBootstrap(appConf) {

    // Constants
    DATE_FORMAT_DATEPICKER = 'dd.mm.yy';
    DATE_FORMAT_INPUT_MASK = {
        alias: 'dd.mm.yyyy',
        placeholder: 'дд.мм.гггг'
    };
    DATE_FORMAT_DATETIMEPICKER = 'yy-mm-dd';
    DATETIME_FORMAT_MOMENT = 'YYYY-MM-DD HH:mm:ss';
    OPACITY_DISABLED = 0.5;
    VALIDATION_TIMEOUT = 1000;
    KEY_ENTER       = 13;
    KEY_ESC         = 27;
    KEY_LEFT        = 37;
    KEY_UP          = 38;
    KEY_RIGHT       = 39;
    KEY_DOWN        = 40;
    KEY_HOME        = 36;
    KEY_END         = 35;
    KEY_PAGE_UP     = 33;
    KEY_PAGE_DOWN   = 34;

    // Making viewport units (vh|vw|vmin|vmax) work properly in Mobile Safari
    if (window.viewportUnitsBuggyfill !== undefined) {
        window.viewportUnitsBuggyfill.init();
    }

    // Application settings
    app = appConf;

    // Document ajax load
    (function() {
        $(document)
            .on('ajax-load', function(e) {
                var $target = getTarget(e);
                var $spinner = $target.data('ajax-load-spinner');
                var left;
                if (!$target.children('.ajax-spinner').length) {
                    if ($('.forms-container', $target).length) {
                        left =
                            $('.forms-container', $target).offset().left +
                            $('.forms-container', $target).width() / 2
                        ;
                        $spinner.css({
                            left: left
                        });
                    }
                    $target
                        .css('opacity', OPACITY_DISABLED)
                        .append($spinner)
                    ;
                }
            })
            .on('ajax-loaded', function(e) {
                var $target = getTarget(e);
                $target.css('opacity', 1);
                $target.children('.ajax-spinner').remove();
            });
        function getTarget(e) {
            var $target,
                $spinner = $('<div class="ajax-spinner" style="-webkit-transform:scale(0.6)"><div></div></div>');
            if (e.target === document) {
                $target = $('body');
                $spinner.css('position', 'fixed');
            } else {
                $target = $(e.target);
                $spinner.css('position', 'absolute');
            }
            $target.data('ajax-load-spinner', $spinner);
            return $target;
        }
    })();

    // Ajax setup
    $.ajaxSetup({
        type: 'POST',
        data: {
            _csrf: app.csrfToken
        }
    });

    // Bootstrap alert
    $('.close').click(function () {
        $(this).parent().addClass('hide');
    });

    // Bootstrap buton: remove focus after click
    $(document).on('focus', '.btn', function () {
        var $btn = $(this);
        setTimeout(function() {
            $btn.blur().removeClass('focus');
        }, 100);
    });

    // Bootstrap modal: show
    $(document).on('click', '[data-toggle-modal]', function() {
        $($(this).data('target')).modal('show');
    });

    // Bootstrap modal: hide confirmation
    $(document)
        .on('hide.bs.modal', '.modal', function() {
            var $modal = $(this),
                $form = $('.modal-content:visible', $modal);
            if ($form.data('hide-confirm') && !confirm($form.data('hide-confirm'))) {
                return false;
            }
        }).on('show.bs.modal', '.modal', function() {
            $('[data-toggle="tooltip"], [data-toggle-tooltip]').tooltip('hide');
        }).on('shown.bs.modal', '.modal', function() {
            var $modal = $(this);
            if ($modal.hasClass('fade')) {
                setTimeout(function() {
                    // Hide animation of prev modal could affect current modal's scroll
                    $('body').addClass('modal-open');
                }, 10);
            }

            // Autofocus
            $(this).find('[autofocus]').focus();
        })
    ;

    // Enjoyhint
    $(document).on('click', '.js-enjoyhint-btn', function() {
        var $btn = $(this),
            steps = $btn.data('enjoyhint-steps'),
            enjoyhintInstance = new EnjoyHint()
        ;

        // Init
        enjoyhintInstance.set(steps);
        enjoyhintInstance.run();
        $('.modal').on('show.bs.modal', function() {
            enjoyhintInstance.set([]);
            enjoyhintInstance.run();
        });

        return false;
    });

    // Yii GridView filtering
    $(document).on('afterFilter', function() {
        $(document).trigger('ajax-load');
    });

    // IE fix: http://stackoverflow.com/questions/27886618/problems-with-new-google-recaptcha-in-ie-when-inside-modal-or-dialog
    if (/MSIE|Trident|Edge/.test(window.navigator.userAgent)) {
        $.fn.modal.Constructor.prototype.enforceFocus = function () { };
    }

    // Body padding fix: https://github.com/twbs/bootstrap/issues/14040#issuecomment-89720484
    $(document).ready(function() {
        $(window).load(function() {
            var oldSSB = $.fn.modal.Constructor.prototype.setScrollbar;
            $.fn.modal.Constructor.prototype.setScrollbar = function() {
                oldSSB.apply(this);
                if (this.bodyIsOverflowing && this.scrollbarWidth) {
                    var navPad = parseInt(($('.navbar-fixed-top, .navbar-fixed-bottom').css('padding-right') || 0), 10);
                    $('.navbar-fixed-top, .navbar-fixed-bottom').css('padding-right', navPad + this.scrollbarWidth);
                }
            };
            var oldRSB = $.fn.modal.Constructor.prototype.resetScrollbar;
            $.fn.modal.Constructor.prototype.resetScrollbar = function() {
                oldRSB.apply(this);
                $('.navbar-fixed-top, .navbar-fixed-bottom').css('padding-right', '');
                $('body').css('padding-right', '');
            };
        });
    });

    // Init controls
    $(document).on('init-controls pjax:complete', function(e) {

        // Bootstrap toggle
        if ($.fn.bootstrapToggle) {
            $('.js-bs-toggle').filter(function() {
                return $(this).closest('.modal').length === 0;
            }).bootstrapToggle();
            $('.toggle .toggle-off').removeClass('active');
            $('.modal').on('shown.bs.modal', function() {
                $('.js-bs-toggle', this).bootstrapToggle();
                $('.toggle .toggle-off').removeClass('active');
            });
        }

        // Bootstrap tooltip
        $(this).initBootstrapTooltip();

        // Bootstrap popover
        $(this).initBootstrapPopover();

        // Form submit animation
        $('form[data-submit-animation]').on('submit', function() {
            $(document).trigger('ajax-load');
        });

        // Textarea auth height
        $('textarea').textareaAutoHeight();
    });
    $(function () {

        // Bootstrap tooltip: custom CSS class
        $(document).on('inserted.bs.tooltip', function(e) {
            var tooltip = $(e.target).data('bs.tooltip');
            tooltip.$tip.addClass($(e.target).data('tooltip-custom-class'));
        });

        // Init controls
        $(document).trigger('init-controls');
    });

}

// Translate
function _t(message) {
    return message;
}

$.ajaxSetup({
    type: 'post'
});
(function($){

    var functionList = {

        /**
         * Ctrl+S events
         *
         * @return {object} [for jQuery chaining]
         */
        onCtrlS: function(callback, editor) {
            $(this).on('keydown', function(e) {
                if ((e.ctrlKey) && (e.keyCode === KEY_S)) {
                    callback();
                    e.preventDefault();
                }
            }
            );

            if (editor != undefined) {
                editor.addCommand("saveNews", {
                    exec: function () {
                    callback();
                },
                modes: {
                    wysiwyg: 1,
                    source: 1
                },
                readOnly: 1,
                canUndo: !1
                });
                editor.setKeystroke(CKEDITOR.CTRL + 83, "saveNews");
            }

            return $(this);
        },

        /**
         * Returns bootstrap progress bar component
         *
         * @return {String}
         */
        progressBar: function() {
            var progressBar = $('<div>')
                .addClass('progress progress-striped active')
                .css('margin', '20px 10px')
                .html(
                    $('<div>')
                        .addClass('bar')
                        .css('width', '100%')
                );
            return progressBar;
        },

        /**
         * Sort list
         */
        sortList: function(order) {

            if (order !== -1) {
                order = 1;
            }

            var self = this,
                $lis = $('li', self),
                vals = [];

            // Collect values
            $lis.each(function(i, $li) {
                vals.push($('a', $li).text());
            });

            // Sort
            vals.sort();
            if (order === -1) {
                vals.reverse();
            }

            // Reorder list
            $.each(vals, function(i, val) {
                $('li:contains(' + val + ')', self).insertAfter($('li:last', self));
            });

            return self;
        },

        /**
         * Validate email
         *
         * @param {String} email
         * @return {Boolean}
         */
        validateEmail: function(email) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(email)) {
                return true;
            }  else {
                return false;
            }
        },

        /**
         * Capitalize first char
         *
         * @param {String} s
         * @return {String}
         */
        ucfirst: function(s) {
            return s.charAt(0).toUpperCase() + s.slice(1);
        },

        /**
         * Renders unique ID (string)
         *
         * @return {String}
         */
        uniqueId: function() {
            var S4 = function() {
                return Math.floor(
                    Math.random() * 0x10000 /* 65536 */
                ).toString(16);
            };
            return (
                S4() + S4() + S4() + S4() + S4() + S4() + S4()
            );
        }

    };

    $.fn.extend(functionList);

    /**
     * $.browser is frowned upon.
     * More details: http://api.jquery.com/jQuery.browser
     */
    var uaMatch = function(ua) {
            ua = ua.toLowerCase();
            var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
                /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
                /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
                /(msie) ([\w.]+)/.exec( ua ) ||
                ua.indexOf('compatible') < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
                [];
            return {
                browser: match[ 1 ] || '',
                version: match[ 2 ] || '0'
            };
        },
        matched = uaMatch(navigator.userAgent),
        browser = {};
    if (matched.browser) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }
    // Chrome is Webkit, but Webkit is also Safari.
    if (browser.chrome) {
        browser.webkit = true;
    } else if (browser.webkit) {
        browser.safari = true;
    }
    $.browser = browser;


})(jQuery);


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
/**
 * Translate function
 *
 * @param {String} category
 * @param {String} text
 * @param {Object}  params
 * @return {String}
 */
function _t(category, text, params)
{
    // Try to get translation for the text
    if ((typeof translations !== 'undefined') &&
        (typeof translations[category] !== undefined) &&
        (typeof translations[category][appLanguage] !== undefined) &&
        (typeof translations[category][appLanguage][text] !== undefined) &&
        (typeof translations[category][appLanguage][text].translation !== undefined) &&
        (translations[category][appLanguage][text].translation !== '')) {
        text = translations[category][appLanguage][text].translation;
    }
    
    // Replace params
    if (params) {
        $.each(params, function(key, value) {
            text = text.split(key).join(value)
        });
    }

    return text;
}
/**
 * Yii form widget.
 *
 * This is the JavaScript widget used by the yii\widgets\ActiveForm widget.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
(function ($) {

    $.fn.yiiActiveForm = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiActiveForm');
            return false;
        }
    };

    var events = {
        /**
         * beforeValidate event is triggered before validating the whole form.
         * The signature of the event handler should be:
         *     function (event, messages, deferreds)
         * where
         *  - event: an Event object.
         *  - messages: an associative array with keys being attribute IDs and values being error message arrays
         *    for the corresponding attributes.
         *  - deferreds: an array of Deferred objects. You can use deferreds.add(callback) to add a new deferred validation.
         *
         * If the handler returns a boolean false, it will stop further form validation after this event. And as
         * a result, afterValidate event will not be triggered.
         */
        beforeValidate: 'beforeValidate',
        /**
         * afterValidate event is triggered after validating the whole form.
         * The signature of the event handler should be:
         *     function (event, messages, errorAttributes)
         * where
         *  - event: an Event object.
         *  - messages: an associative array with keys being attribute IDs and values being error message arrays
         *    for the corresponding attributes.
         *  - errorAttributes: an array of attributes that have validation errors. Please refer to attributeDefaults for the structure of this parameter.
         */
        afterValidate: 'afterValidate',
        /**
         * beforeValidateAttribute event is triggered before validating an attribute.
         * The signature of the event handler should be:
         *     function (event, attribute, messages, deferreds)
         * where
         *  - event: an Event object.
         *  - attribute: the attribute to be validated. Please refer to attributeDefaults for the structure of this parameter.
         *  - messages: an array to which you can add validation error messages for the specified attribute.
         *  - deferreds: an array of Deferred objects. You can use deferreds.add(callback) to add a new deferred validation.
         *
         * If the handler returns a boolean false, it will stop further validation of the specified attribute.
         * And as a result, afterValidateAttribute event will not be triggered.
         */
        beforeValidateAttribute: 'beforeValidateAttribute',
        /**
         * afterValidateAttribute event is triggered after validating the whole form and each attribute.
         * The signature of the event handler should be:
         *     function (event, attribute, messages)
         * where
         *  - event: an Event object.
         *  - attribute: the attribute being validated. Please refer to attributeDefaults for the structure of this parameter.
         *  - messages: an array to which you can add additional validation error messages for the specified attribute.
         */
        afterValidateAttribute: 'afterValidateAttribute',
        /**
         * beforeSubmit event is triggered before submitting the form after all validations have passed.
         * The signature of the event handler should be:
         *     function (event)
         * where event is an Event object.
         *
         * If the handler returns a boolean false, it will stop form submission.
         */
        beforeSubmit: 'beforeSubmit',
        /**
         * ajaxBeforeSend event is triggered before sending an AJAX request for AJAX-based validation.
         * The signature of the event handler should be:
         *     function (event, jqXHR, settings)
         * where
         *  - event: an Event object.
         *  - jqXHR: a jqXHR object
         *  - settings: the settings for the AJAX request
         */
        ajaxBeforeSend: 'ajaxBeforeSend',
        /**
         * ajaxComplete event is triggered after completing an AJAX request for AJAX-based validation.
         * The signature of the event handler should be:
         *     function (event, jqXHR, textStatus)
         * where
         *  - event: an Event object.
         *  - jqXHR: a jqXHR object
         *  - textStatus: the status of the request ("success", "notmodified", "error", "timeout", "abort", or "parsererror").
         */
        ajaxComplete: 'ajaxComplete'
    };

    // NOTE: If you change any of these defaults, make sure you update yii\widgets\ActiveForm::getClientOptions() as well
    var defaults = {
        // whether to encode the error summary
        encodeErrorSummary: true,
        // the jQuery selector for the error summary
        errorSummary: '.error-summary',
        // whether to perform validation before submitting the form.
        validateOnSubmit: true,
        // the container CSS class representing the corresponding attribute has validation error
        errorCssClass: 'has-error',
        // the container CSS class representing the corresponding attribute passes validation
        successCssClass: 'has-success',
        // the container CSS class representing the corresponding attribute is being validated
        validatingCssClass: 'validating',
        // the GET parameter name indicating an AJAX-based validation
        ajaxParam: 'ajax',
        // the type of data that you're expecting back from the server
        ajaxDataType: 'json',
        // the URL for performing AJAX-based validation. If not set, it will use the the form's action
        validationUrl: undefined,
        // whether to scroll to first visible error after validation.
        scrollToError: true
    };

    // NOTE: If you change any of these defaults, make sure you update yii\widgets\ActiveField::getClientOptions() as well
    var attributeDefaults = {
        // a unique ID identifying an attribute (e.g. "loginform-username") in a form
        id: undefined,
        // attribute name or expression (e.g. "[0]content" for tabular input)
        name: undefined,
        // the jQuery selector of the container of the input field
        container: undefined,
        // the jQuery selector of the input field under the context of the container
        input: undefined,
        // the jQuery selector of the error tag under the context of the container
        error: '.help-block',
        // whether to encode the error
        encodeError: true,
        // whether to perform validation when a change is detected on the input
        validateOnChange: true,
        // whether to perform validation when the input loses focus
        validateOnBlur: true,
        // whether to perform validation when the user is typing.
        validateOnType: false,
        // number of milliseconds that the validation should be delayed when a user is typing in the input field.
        validationDelay: 500,
        // whether to enable AJAX-based validation.
        enableAjaxValidation: false,
        // function (attribute, value, messages, deferred, $form), the client-side validation function.
        validate: undefined,
        // status of the input field, 0: empty, not entered before, 1: validated, 2: pending validation, 3: validating
        status: 0,
        // whether the validation is cancelled by beforeValidateAttribute event handler
        cancelled: false,
        // the value of the input
        value: undefined
    };


    var submitDefer;

    var setSubmitFinalizeDefer = function($form) {
        submitDefer = $.Deferred();
        $form.data('yiiSubmitFinalizePromise', submitDefer.promise());
    };

    // finalize yii.js $form.submit
    var submitFinalize = function($form) {
        if(submitDefer) {
            submitDefer.resolve();
            submitDefer = undefined;
            $form.removeData('yiiSubmitFinalizePromise');
        }
    };


    var methods = {
        init: function (attributes, options) {
            return this.each(function () {
                var $form = $(this);
                if ($form.data('yiiActiveForm')) {
                    return;
                }

                var settings = $.extend({}, defaults, options || {});
                if (settings.validationUrl === undefined) {
                    settings.validationUrl = $form.attr('action');
                }

                $.each(attributes, function (i) {
                    attributes[i] = $.extend({value: getValue($form, this)}, attributeDefaults, this);
                    watchAttribute($form, attributes[i]);
                });

                $form.data('yiiActiveForm', {
                    settings: settings,
                    attributes: attributes,
                    submitting: false,
                    validated: false
                });

                /**
                 * Clean up error status when the form is reset.
                 * Note that $form.on('reset', ...) does work because the "reset" event does not bubble on IE.
                 */
                $form.bind('reset.yiiActiveForm', methods.resetForm);

                if (settings.validateOnSubmit) {
                    $form.on('mouseup.yiiActiveForm keyup.yiiActiveForm', ':submit', function () {
                        $form.data('yiiActiveForm').submitObject = $(this);
                    });
                    $form.on('submit.yiiActiveForm', methods.submitForm);
                }
            });
        },

        // add a new attribute to the form dynamically.
        // please refer to attributeDefaults for the structure of attribute
        add: function (attribute) {
            var $form = $(this);
            attribute = $.extend({value: getValue($form, attribute)}, attributeDefaults, attribute);
            $form.data('yiiActiveForm').attributes.push(attribute);
            watchAttribute($form, attribute);
        },

        // remove the attribute with the specified ID from the form
        remove: function (id) {
            var $form = $(this),
                attributes = $form.data('yiiActiveForm').attributes,
                index = -1,
                attribute = undefined;
            $.each(attributes, function (i) {
                if (attributes[i]['id'] == id) {
                    index = i;
                    attribute = attributes[i];
                    return false;
                }
            });
            if (index >= 0) {
                attributes.splice(index, 1);
                unwatchAttribute($form, attribute);
            }
            return attribute;
        },

        // manually trigger the validation of the attribute with the specified ID
        validateAttribute: function (id) {
            var attribute = methods.find.call(this, id);
            if (attribute != undefined) {
                validateAttribute($(this), attribute, true);
            }
        },

        // find an attribute config based on the specified attribute ID
        find: function (id) {
            var attributes = $(this).data('yiiActiveForm').attributes,
                result = undefined;
            $.each(attributes, function (i) {
                if (attributes[i]['id'] == id) {
                    result = attributes[i];
                    return false;
                }
            });
            return result;
        },

        destroy: function () {
            return this.each(function () {
                $(this).unbind('.yiiActiveForm');
                $(this).removeData('yiiActiveForm');
            });
        },

        data: function () {
            return this.data('yiiActiveForm');
        },

        // validate all applicable inputs in the form
        validate: function () {
            var $form = $(this),
                data = $form.data('yiiActiveForm'),
                needAjaxValidation = false,
                messages = {},
                deferreds = deferredArray(),
                submitting = data.submitting;

            if (submitting) {
                var event = $.Event(events.beforeValidate);
                $form.trigger(event, [messages, deferreds]);
                if (event.result === false) {
                    data.submitting = false;
                    submitFinalize($form);
                    return;
                }
            }

            // client-side validation
            $.each(data.attributes, function () {
                this.cancelled = false;
                // perform validation only if the form is being submitted or if an attribute is pending validation
                if (data.submitting || this.status === 2 || this.status === 3) {
                    var msg = messages[this.id];
                    if (msg === undefined) {
                        msg = [];
                        messages[this.id] = msg;
                    }
                    var event = $.Event(events.beforeValidateAttribute);
                    $form.trigger(event, [this, msg, deferreds]);
                    if (event.result !== false) {
                        if (this.validate) {
                            this.validate(this, getValue($form, this), msg, deferreds, $form);
                        }
                        if (this.enableAjaxValidation) {
                            needAjaxValidation = true;
                        }
                    } else {
                        this.cancelled = true;
                    }
                }
            });

            // ajax validation
            $.when.apply(this, deferreds).always(function() {
                // Remove empty message arrays
                for (var i in messages) {
                    if (0 === messages[i].length) {
                        delete messages[i];
                    }
                }
                if (needAjaxValidation) {
                    var $button = data.submitObject,
                        extData = '&' + data.settings.ajaxParam + '=' + $form.attr('id');
                    if ($button && $button.length && $button.attr('name')) {
                        extData += '&' + $button.attr('name') + '=' + $button.attr('value');
                    }
                    $.ajax({
                        url: data.settings.validationUrl,
                        type: $form.attr('method'),
                        data: $form.serialize() + extData,
                        dataType: data.settings.ajaxDataType,
                        complete: function (jqXHR, textStatus) {
                            $form.trigger(events.ajaxComplete, [jqXHR, textStatus]);
                        },
                        beforeSend: function (jqXHR, settings) {
                            $form.trigger(events.ajaxBeforeSend, [jqXHR, settings]);
                        },
                        success: function (msgs) {
                            if (msgs !== null && typeof msgs === 'object') {
                                $.each(data.attributes, function () {
                                    if (!this.enableAjaxValidation || this.cancelled) {
                                        delete msgs[this.id];
                                    }
                                });
                                updateInputs($form, $.extend(messages, msgs), submitting);
                            } else {
                                updateInputs($form, messages, submitting);
                            }
                        },
                        error: function () {
                            data.submitting = false;
                            submitFinalize($form);
                        }
                    });
                } else if (data.submitting) {
                    // delay callback so that the form can be submitted without problem
                    setTimeout(function () {
                        updateInputs($form, messages, submitting);
                    }, 200);
                } else {
                    updateInputs($form, messages, submitting);
                }
            });
        },

        submitForm: function () {
            var $form = $(this),
                data = $form.data('yiiActiveForm');

            if (data.validated) {
                // Second submit's call (from validate/updateInputs)
                data.submitting = false;
                var event = $.Event(events.beforeSubmit);
                $form.trigger(event);
                if (event.result === false) {
                    data.validated = false;
                    submitFinalize($form);
                    return false;
                }
                return true;   // continue submitting the form since validation passes
            } else {
                // First submit's call (from yii.js/handleAction) - execute validating
                setSubmitFinalizeDefer($form);

                if (data.settings.timer !== undefined) {
                    clearTimeout(data.settings.timer);
                }
                data.submitting = true;
                methods.validate.call($form);
                return false;
            }
        },

        resetForm: function () {
            var $form = $(this);
            var data = $form.data('yiiActiveForm');
            // Because we bind directly to a form reset event instead of a reset button (that may not exist),
            // when this function is executed form input values have not been reset yet.
            // Therefore we do the actual reset work through setTimeout.
            setTimeout(function () {
                $.each(data.attributes, function () {
                    // Without setTimeout() we would get the input values that are not reset yet.
                    this.value = getValue($form, this);
                    this.status = 0;
                    var $container = $form.find(this.container);
                    $container.removeClass(
                        data.settings.validatingCssClass + ' ' +
                            data.settings.errorCssClass + ' ' +
                            data.settings.successCssClass
                    );
                    $container.find(this.error).html('');
                });
                $form.find(data.settings.errorSummary).hide().find('ul').html('');
            }, 1);
        },

        /**
         * Updates error messages, input containers, and optionally summary as well.
         * If an attribute is missing from messages, it is considered valid.
         * @param messages array the validation error messages, indexed by attribute IDs
         * @param summary whether to update summary as well.
         */
        updateMessages: function (messages, summary) {
            var $form = $(this);
            var data = $form.data('yiiActiveForm');
            $.each(data.attributes, function () {
                updateInput($form, this, messages);
            });
            if (summary) {
                updateSummary($form, messages);
            }
        },

        /**
         * Updates error messages and input container of a single attribute.
         * If messages is empty, the attribute is considered valid.
         * @param id attribute ID
         * @param messages array with error messages
         */
        updateAttribute: function(id, messages) {
            var attribute = methods.find.call(this, id);
            if (attribute != undefined) {
                var msg = {};
                msg[id] = messages;
                updateInput($(this), attribute, msg);
            }
        }

    };

    var watchAttribute = function ($form, attribute) {
        var $input = findInput($form, attribute);
        if (attribute.validateOnChange) {
            $input.on('change.yiiActiveForm', function () {
                validateAttribute($form, attribute, false);
            });
        }
        if (attribute.validateOnBlur) {
            $input.on('blur.yiiActiveForm', function () {
                if (attribute.status == 0 || attribute.status == 1) {
                    validateAttribute($form, attribute, !attribute.status);
                }
            });
        }
        if (attribute.validateOnType) {
            $input.on('keyup.yiiActiveForm', function (e) {
                if ($.inArray(e.which, [16, 17, 18, 37, 38, 39, 40]) !== -1 ) {
                    return;
                }
                if (attribute.value !== getValue($form, attribute)) {
                    validateAttribute($form, attribute, false, attribute.validationDelay);
                }
            });
        }
    };

    var unwatchAttribute = function ($form, attribute) {
        findInput($form, attribute).off('.yiiActiveForm');
    };

    var validateAttribute = function ($form, attribute, forceValidate, validationDelay) {
        var data = $form.data('yiiActiveForm');

        if (forceValidate) {
            attribute.status = 2;
        }
        $.each(data.attributes, function () {
            if (this.value !== getValue($form, this)) {
                this.status = 2;
                forceValidate = true;
            }
        });
        if (!forceValidate) {
            return;
        }

        if (data.settings.timer !== undefined) {
            clearTimeout(data.settings.timer);
        }
        data.settings.timer = setTimeout(function () {
            if (data.submitting || $form.is(':hidden')) {
                return;
            }
            $.each(data.attributes, function () {
                if (this.status === 2) {
                    this.status = 3;
                    $form.find(this.container).addClass(data.settings.validatingCssClass);
                }
            });
            methods.validate.call($form);
        }, validationDelay ? validationDelay : 200);
    };

    /**
     * Returns an array prototype with a shortcut method for adding a new deferred.
     * The context of the callback will be the deferred object so it can be resolved like ```this.resolve()```
     * @returns Array
     */
    var deferredArray = function () {
        var array = [];
        array.add = function(callback) {
            this.push(new $.Deferred(callback));
        };
        return array;
    };

    /**
     * Updates the error messages and the input containers for all applicable attributes
     * @param $form the form jQuery object
     * @param messages array the validation error messages
     * @param submitting whether this method is called after validation triggered by form submission
     */
    var updateInputs = function ($form, messages, submitting) {
        var data = $form.data('yiiActiveForm');

        if (submitting) {
            var errorAttributes = [];
            $.each(data.attributes, function () {
                if (!this.cancelled && updateInput($form, this, messages)) {
                    errorAttributes.push(this);
                }
            });

            $form.trigger(events.afterValidate, [messages, errorAttributes]);

            updateSummary($form, messages);

            if (errorAttributes.length) {
                if (data.settings.scrollToError) {
                    var top = $form.find($.map(errorAttributes, function(attribute) {
                        return attribute.input;
                    }).join(',')).first().closest(':visible').offset().top;
                    var wtop = $(window).scrollTop();
                    if (top < wtop || top > wtop + $(window).height()) {
                        $(window).scrollTop(top);
                    }
                }
                data.submitting = false;
            } else {
                data.validated = true;
                var $button = data.submitObject || $form.find(':submit:first');
                // TODO: if the submission is caused by "change" event, it will not work
                if ($button.length && $button.attr('type') == 'submit' && $button.attr('name')) {
                    // simulate button input value
                    var $hiddenButton = $('input[type="hidden"][name="' + $button.attr('name') + '"]', $form);
                    if (!$hiddenButton.length) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: $button.attr('name'),
                            value: $button.attr('value')
                        }).appendTo($form);
                    } else {
                        $hiddenButton.attr('value', $button.attr('value'));
                    }
                }
                $form.submit();
            }
        } else {
            $.each(data.attributes, function () {
                if (!this.cancelled && (this.status === 2 || this.status === 3)) {
                    updateInput($form, this, messages);
                }
            });
        }
        submitFinalize($form);
    };

    /**
     * Updates the error message and the input container for a particular attribute.
     * @param $form the form jQuery object
     * @param attribute object the configuration for a particular attribute.
     * @param messages array the validation error messages
     * @return boolean whether there is a validation error for the specified attribute
     */
    var updateInput = function ($form, attribute, messages) {
        var data = $form.data('yiiActiveForm'),
            $input = findInput($form, attribute),
            hasError = false;

        if (!$.isArray(messages[attribute.id])) {
            messages[attribute.id] = [];
        }
        $form.trigger(events.afterValidateAttribute, [attribute, messages[attribute.id]]);

        attribute.status = 1;
        if ($input.length) {
            hasError = messages[attribute.id].length > 0;
            var $container = $form.find(attribute.container);
            var $error = $container.find(attribute.error);
            if (hasError) {
                if (attribute.encodeError) {
                    $error.text(messages[attribute.id][0]);
                } else {
                    $error.html(messages[attribute.id][0]);
                }
                $container.removeClass(data.settings.validatingCssClass + ' ' + data.settings.successCssClass)
                    .addClass(data.settings.errorCssClass);
            } else {
                $error.empty();
                $container.removeClass(data.settings.validatingCssClass + ' ' + data.settings.errorCssClass + ' ')
                    .addClass(data.settings.successCssClass);
            }
            attribute.value = getValue($form, attribute);
        }
        return hasError;
    };

    /**
     * Updates the error summary.
     * @param $form the form jQuery object
     * @param messages array the validation error messages
     */
    var updateSummary = function ($form, messages) {
        var data = $form.data('yiiActiveForm'),
            $summary = $form.find(data.settings.errorSummary),
            $ul = $summary.find('ul').empty();

        if ($summary.length && messages) {
            $.each(data.attributes, function () {
                if ($.isArray(messages[this.id]) && messages[this.id].length) {
                    var error = $('<li/>');
                    if (data.settings.encodeErrorSummary) {
                        error.text(messages[this.id][0]);
                    } else {
                        error.html(messages[this.id][0]);
                    }
                    $ul.append(error);
                }
            });
            $summary.toggle($ul.find('li').length > 0);
        }
    };

    var getValue = function ($form, attribute) {
        var $input = findInput($form, attribute);
        var type = $input.attr('type');
        if (type === 'checkbox' || type === 'radio') {
            var $realInput = $input.filter(':checked');
            if (!$realInput.length) {
                $realInput = $form.find('input[type=hidden][name="' + $input.attr('name') + '"]');
            }
            return $realInput.val();
        } else {
            return $input.val();
        }
    };

    var findInput = function ($form, attribute) {
        var $input = $form.find(attribute.input);
        if ($input.length && $input[0].tagName.toLowerCase() === 'div') {
            // checkbox list or radio list
            return $input.find('input');
        } else {
            return $input;
        }
    };

})(window.jQuery);

/**
 * Yii Captcha widget.
 *
 * This is the JavaScript widget used by the yii\captcha\Captcha widget.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
(function ($) {
    $.fn.yiiCaptcha = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiCaptcha');
            return false;
        }
    };

    var defaults = {
        refreshUrl: undefined,
        hashKey: undefined
    };

    var methods = {
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                $e.data('yiiCaptcha', {
                    settings: settings
                });

                $e.on('click.yiiCaptcha', function () {
                    methods.refresh.apply($e);
                    return false;
                });

            });
        },

        refresh: function () {
            var $e = this,
                settings = this.data('yiiCaptcha').settings;
            $.ajax({
                url: $e.data('yiiCaptcha').settings.refreshUrl,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    $e.attr('src', data.url);
                    $('body').data(settings.hashKey, [data.hash1, data.hash2]);
                }
            });
        },

        destroy: function () {
            return this.each(function () {
                $(window).unbind('.yiiCaptcha');
                $(this).removeData('yiiCaptcha');
            });
        },

        data: function () {
            return this.data('yiiCaptcha');
        }
    };
})(window.jQuery);


/**
 * Yii GridView widget.
 *
 * This is the JavaScript widget used by the yii\grid\GridView widget.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
(function ($) {
    $.fn.yiiGridView = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiGridView');
            return false;
        }
    };

    var defaults = {
        filterUrl: undefined,
        filterSelector: undefined
    };

    var gridData = {};

    var gridEvents = {
        /**
         * beforeFilter event is triggered before filtering the grid.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         *
         * If the handler returns a boolean false, it will stop filter form submission after this event. As
         * a result, afterFilter event will not be triggered.
         */
        beforeFilter: 'beforeFilter',
        /**
         * afterFilter event is triggered after filtering the grid and filtered results are fetched.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         */
        afterFilter: 'afterFilter'
    };
    
    var methods = {
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                gridData[$e.attr('id')] = {settings: settings};

                var enterPressed = false;
                $(document).off('change.yiiGridView keydown.yiiGridView', settings.filterSelector)
                    .on('change.yiiGridView keydown.yiiGridView', settings.filterSelector, function (event) {
                        if (event.type === 'keydown') {
                            if (event.keyCode !== 13) {
                                return; // only react to enter key
                            } else {
                                enterPressed = true;
                            }
                        } else {
                            // prevent processing for both keydown and change events
                            if (enterPressed) {
                                enterPressed = false;
                                return;
                            }
                        }

                        methods.applyFilter.apply($e);

                        return false;
                    });
            });
        },

        applyFilter: function () {
            var $grid = $(this), event;
            var settings = gridData[$grid.attr('id')].settings;
            var data = {};
            $.each($(settings.filterSelector).serializeArray(), function () {
                data[this.name] = this.value;
            });

            $.each(yii.getQueryParams(settings.filterUrl), function (name, value) {
                if (data[name] === undefined) {
                    data[name] = value;
                }
            });

            var pos = settings.filterUrl.indexOf('?');
            var url = pos < 0 ? settings.filterUrl : settings.filterUrl.substring(0, pos);

            $grid.find('form.gridview-filter-form').remove();
            var $form = $('<form action="' + url + '" method="get" class="gridview-filter-form" style="display:none" data-pjax></form>').appendTo($grid);
            $.each(data, function (name, value) {
                $form.append($('<input type="hidden" name="t" value="" />').attr('name', name).val(value));
            });
            
            event = $.Event(gridEvents.beforeFilter);
            $grid.trigger(event);
            if (event.result === false) {
                return;
            }

            $form.submit();
            
            $grid.trigger(gridEvents.afterFilter);
        },

        setSelectionColumn: function (options) {
            var $grid = $(this);
            var id = $(this).attr('id');
            gridData[id].selectionColumn = options.name;
            if (!options.multiple) {
                return;
            }
            var checkAll = "#" + id + " input[name='" + options.checkAll + "']";
            var inputs = "#" + id + " input[name='" + options.name + "']";
            $(document).off('click.yiiGridView', checkAll).on('click.yiiGridView', checkAll, function () {
                $grid.find("input[name='" + options.name + "']:enabled").prop('checked', this.checked);
            });
            $(document).off('click.yiiGridView', inputs + ":enabled").on('click.yiiGridView', inputs + ":enabled", function () {
                var all = $grid.find("input[name='" + options.name + "']").length == $grid.find("input[name='" + options.name + "']:checked").length;
                $grid.find("input[name='" + options.checkAll + "']").prop('checked', all);
            });
        },

        getSelectedRows: function () {
            var $grid = $(this);
            var data = gridData[$grid.attr('id')];
            var keys = [];
            if (data.selectionColumn) {
                $grid.find("input[name='" + data.selectionColumn + "']:checked").each(function () {
                    keys.push($(this).parent().closest('tr').data('key'));
                });
            }
            return keys;
        },

        destroy: function () {
            return this.each(function () {
                $(window).unbind('.yiiGridView');
                $(this).removeData('yiiGridView');
            });
        },

        data: function () {
            var id = $(this).attr('id');
            return gridData[id];
        }
    };
})(window.jQuery);

/**
 * Yii JavaScript module.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

/**
 * yii is the root module for all Yii JavaScript modules.
 * It implements a mechanism of organizing JavaScript code in modules through the function "yii.initModule()".
 *
 * Each module should be named as "x.y.z", where "x" stands for the root module (for the Yii core code, this is "yii").
 *
 * A module may be structured as follows:
 *
 * ~~~
 * yii.sample = (function($) {
 *     var pub = {
 *         // whether this module is currently active. If false, init() will not be called for this module
 *         // it will also not be called for all its child modules. If this property is undefined, it means true.
 *         isActive: true,
 *         init: function() {
 *             // ... module initialization code go here ...
 *         },
 *
 *         // ... other public functions and properties go here ...
 *     };
 *
 *     // ... private functions and properties go here ...
 *
 *     return pub;
 * })(jQuery);
 * ~~~
 *
 * Using this structure, you can define public and private functions/properties for a module.
 * Private functions/properties are only visible within the module, while public functions/properties
 * may be accessed outside of the module. For example, you can access "yii.sample.isActive".
 *
 * You must call "yii.initModule()" once for the root module of all your modules.
 */
yii = (function ($) {
    var pub = {
        /**
         * List of JS or CSS URLs that can be loaded multiple times via AJAX requests. Each script can be represented
         * as either an absolute URL or a relative one.
         */
        reloadableScripts: [],
        /**
         * The selector for clickable elements that need to support confirmation and form submission.
         */
        clickableSelector: 'a, button, input[type="submit"], input[type="button"], input[type="reset"], input[type="image"]',
        /**
         * The selector for changeable elements that need to support confirmation and form submission.
         */
        changeableSelector: 'select, input, textarea',

        /**
         * @return string|undefined the CSRF parameter name. Undefined is returned if CSRF validation is not enabled.
         */
        getCsrfParam: function () {
            return $('meta[name=csrf-param]').attr('content');
        },

        /**
         * @return string|undefined the CSRF token. Undefined is returned if CSRF validation is not enabled.
         */
        getCsrfToken: function () {
            return $('meta[name=csrf-token]').attr('content');
        },

        /**
         * Sets the CSRF token in the meta elements.
         * This method is provided so that you can update the CSRF token with the latest one you obtain from the server.
         * @param name the CSRF token name
         * @param value the CSRF token value
         */
        setCsrfToken: function (name, value) {
            $('meta[name=csrf-param]').attr('content', name);
            $('meta[name=csrf-token]').attr('content', value);
        },

        /**
         * Updates all form CSRF input fields with the latest CSRF token.
         * This method is provided to avoid cached forms containing outdated CSRF tokens.
         */
        refreshCsrfToken: function () {
            var token = pub.getCsrfToken();
            if (token) {
                $('form input[name="' + pub.getCsrfParam() + '"]').val(token);
            }
        },

        /**
         * Displays a confirmation dialog.
         * The default implementation simply displays a js confirmation dialog.
         * You may override this by setting `yii.confirm`.
         * @param message the confirmation message.
         * @param ok a callback to be called when the user confirms the message
         * @param cancel a callback to be called when the user cancels the confirmation
         */
        confirm: function (message, ok, cancel) {
            if (confirm(message)) {
                !ok || ok();
            } else {
                !cancel || cancel();
            }
        },

        /**
         * Handles the action triggered by user.
         * This method recognizes the `data-method` attribute of the element. If the attribute exists,
         * the method will submit the form containing this element. If there is no containing form, a form
         * will be created and submitted using the method given by this attribute value (e.g. "post", "put").
         * For hyperlinks, the form action will take the value of the "href" attribute of the link.
         * For other elements, either the containing form action or the current page URL will be used
         * as the form action URL.
         *
         * If the `data-method` attribute is not defined, the `href` attribute (if any) of the element
         * will be assigned to `window.location`.
         *
         * Starting from version 2.0.3, the `data-params` attribute is also recognized when you specify
         * `data-method`. The value of `data-params` should be a JSON representation of the data (name-value pairs)
         * that should be submitted as hidden inputs. For example, you may use the following code to generate
         * such a link:
         *
         * ```php
         * use yii\helpers\Html;
         * use yii\helpers\Json;
         *
         * echo Html::a('submit', ['site/foobar'], [
         *     'data' => [
         *         'method' => 'post',
         *         'params' => [
         *             'name1' => 'value1',
         *             'name2' => 'value2',
         *         ],
         *     ],
         * ];
         * ```
         *
         * @param $e the jQuery representation of the element
         */
        handleAction: function ($e) {
            var method = $e.data('method'),
                $form = $e.closest('form'),
                action = $e.attr('href'),
                params = $e.data('params');

            if (method === undefined) {
                if (action && action != '#') {
                    window.location = action;
                } else if ($e.is(':submit') && $form.length) {
                    $form.trigger('submit');
                }
                return;
            }

            var newForm = !$form.length;
            if (newForm) {
                if (!action || !action.match(/(^\/|:\/\/)/)) {
                    action = window.location.href;
                }
                $form = $('<form method="' + method + '"></form>');
                $form.attr('action', action);
                var target = $e.attr('target');
                if (target) {
                    $form.attr('target', target);
                }
                if (!method.match(/(get|post)/i)) {
                    $form.append('<input name="_method" value="' + method + '" type="hidden">');
                    method = 'POST';
                }
                if (!method.match(/(get|head|options)/i)) {
                    var csrfParam = pub.getCsrfParam();
                    if (csrfParam) {
                        $form.append('<input name="' + csrfParam + '" value="' + pub.getCsrfToken() + '" type="hidden">');
                    }
                }
                $form.hide().appendTo('body');
            }

            var activeFormData = $form.data('yiiActiveForm');
            if (activeFormData) {
                // remember who triggers the form submission. This is used by yii.activeForm.js
                activeFormData.submitObject = $e;
            }

            // temporarily add hidden inputs according to data-params
            if (params && $.isPlainObject(params)) {
                $.each(params, function (idx, obj) {
                    $form.append('<input name="' + idx + '" value="' + obj + '" type="hidden">');
                });
            }

            var oldMethod = $form.attr('method');
            $form.attr('method', method);
            var oldAction = null;
            if (action && action != '#') {
                oldAction = $form.attr('action');
                $form.attr('action', action);
            }

            $form.trigger('submit');
            $.when($form.data('yiiSubmitFinalizePromise')).then(
                function () {
                    if (oldAction != null) {
                        $form.attr('action', oldAction);
                    }
                    $form.attr('method', oldMethod);

                    // remove the temporarily added hidden inputs
                    if (params && $.isPlainObject(params)) {
                        $.each(params, function (idx, obj) {
                            $('input[name="' + idx + '"]', $form).remove();
                        });
                    }

                    if (newForm) {
                        $form.remove();
                    }
                }
            );
        },

        getQueryParams: function (url) {
            var pos = url.indexOf('?');
            if (pos < 0) {
                return {};
            }
            var qs = url.substring(pos + 1).split('&');
            for (var i = 0, result = {}; i < qs.length; i++) {
                qs[i] = qs[i].split('=');
                result[decodeURIComponent(qs[i][0])] = decodeURIComponent(qs[i][1]);
            }
            return result;
        },

        initModule: function (module) {
            if (module.isActive === undefined || module.isActive) {
                if ($.isFunction(module.init)) {
                    module.init();
                }
                $.each(module, function () {
                    if ($.isPlainObject(this)) {
                        pub.initModule(this);
                    }
                });
            }
        },

        init: function () {
            initCsrfHandler();
            initRedirectHandler();
            initScriptFilter();
            initDataMethods();
        }
    };

    function initRedirectHandler() {
        // handle AJAX redirection
        $(document).ajaxComplete(function (event, xhr, settings) {
            var url = xhr.getResponseHeader('X-Redirect');
            if (url) {
                window.location = url;
            }
        });
    }

    function initCsrfHandler() {
        // automatically send CSRF token for all AJAX requests
        $.ajaxPrefilter(function (options, originalOptions, xhr) {
            if (!options.crossDomain && pub.getCsrfParam()) {
                xhr.setRequestHeader('X-CSRF-Token', pub.getCsrfToken());
            }
        });
        pub.refreshCsrfToken();
    }

    function initDataMethods() {
        var handler = function (event) {
            var $this = $(this),
                method = $this.data('method'),
                message = $this.data('confirm');

            if (method === undefined && message === undefined) {
                return true;
            }

            if (message !== undefined) {
                pub.confirm(message, function () {
                    pub.handleAction($this);
                });
            } else {
                pub.handleAction($this);
            }
            event.stopImmediatePropagation();
            return false;
        };

        // handle data-confirm and data-method for clickable and changeable elements
        $(document).on('click.yii', pub.clickableSelector, handler)
            .on('change.yii', pub.changeableSelector, handler);
    }

    function initScriptFilter() {
        var hostInfo = location.protocol + '//' + location.host;
        var loadedScripts = $('script[src]').map(function () {
            return this.src.charAt(0) === '/' ? hostInfo + this.src : this.src;
        }).toArray();

        $.ajaxPrefilter('script', function (options, originalOptions, xhr) {
            if (options.dataType == 'jsonp') {
                return;
            }
            var url = options.url.charAt(0) === '/' ? hostInfo + options.url : options.url;
            if ($.inArray(url, loadedScripts) === -1) {
                loadedScripts.push(url);
            } else {
                var found = $.inArray(url, $.map(pub.reloadableScripts, function (script) {
                    return script.charAt(0) === '/' ? hostInfo + script : script;
                })) !== -1;
                if (!found) {
                    xhr.abort();
                }
            }
        });

        $(document).ajaxComplete(function (event, xhr, settings) {
            var styleSheets = [];
            $('link[rel=stylesheet]').each(function () {
                if ($.inArray(this.href, pub.reloadableScripts) !== -1) {
                    return;
                }
                if ($.inArray(this.href, styleSheets) == -1) {
                    styleSheets.push(this.href)
                } else {
                    $(this).remove();
                }
            })
        });
    }

    return pub;
})(jQuery);

jQuery(document).ready(function () {
    yii.initModule(yii);
});

/**
 * Yii validation module.
 *
 * This JavaScript module provides the validation methods for the built-in validators.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

yii.validation = (function ($) {
    var pub = {
        isEmpty: function (value) {
            return value === null || value === undefined || value == [] || value === '';
        },

        addMessage: function (messages, message, value) {
            messages.push(message.replace(/\{value\}/g, value));
        },

        required: function (value, messages, options) {
            var valid = false;
            if (options.requiredValue === undefined) {
                var isString = typeof value == 'string' || value instanceof String;
                if (options.strict && value !== undefined || !options.strict && !pub.isEmpty(isString ? $.trim(value) : value)) {
                    valid = true;
                }
            } else if (!options.strict && value == options.requiredValue || options.strict && value === options.requiredValue) {
                valid = true;
            }

            if (!valid) {
                pub.addMessage(messages, options.message, value);
            }
        },

        boolean: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }
            var valid = !options.strict && (value == options.trueValue || value == options.falseValue)
                || options.strict && (value === options.trueValue || value === options.falseValue);

            if (!valid) {
                pub.addMessage(messages, options.message, value);
            }
        },

        string: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            if (typeof value !== 'string') {
                pub.addMessage(messages, options.message, value);
                return;
            }

            if (options.min !== undefined && value.length < options.min) {
                pub.addMessage(messages, options.tooShort, value);
            }
            if (options.max !== undefined && value.length > options.max) {
                pub.addMessage(messages, options.tooLong, value);
            }
            if (options.is !== undefined && value.length != options.is) {
                pub.addMessage(messages, options.notEqual, value);
            }
        },

        file: function (attribute, messages, options) {
            var files = getUploadedFiles(attribute, messages, options);
            $.each(files, function (i, file) {
                validateFile(file, messages, options);
            });
        },

        image: function (attribute, messages, options, deferred) {
            var files = getUploadedFiles(attribute, messages, options);

            $.each(files, function (i, file) {
                validateFile(file, messages, options);

                // Skip image validation if FileReader API is not available
                if (typeof FileReader === "undefined") {
                    return;
                }

                var def = $.Deferred(),
                    fr = new FileReader(),
                    img = new Image();

                img.onload = function () {
                    if (options.minWidth && this.width < options.minWidth) {
                        messages.push(options.underWidth.replace(/\{file\}/g, file.name));
                    }

                    if (options.maxWidth && this.width > options.maxWidth) {
                        messages.push(options.overWidth.replace(/\{file\}/g, file.name));
                    }

                    if (options.minHeight && this.height < options.minHeight) {
                        messages.push(options.underHeight.replace(/\{file\}/g, file.name));
                    }

                    if (options.maxHeight && this.height > options.maxHeight) {
                        messages.push(options.overHeight.replace(/\{file\}/g, file.name));
                    }
                    def.resolve();
                };

                img.onerror = function () {
                    messages.push(options.notImage.replace(/\{file\}/g, file.name));
                    def.resolve();
                };

                fr.onload = function () {
                    img.src = fr.result;
                };

                // Resolve deferred if there was error while reading data
                fr.onerror = function () {
                    def.resolve();
                };

                fr.readAsDataURL(file);

                deferred.push(def);
            });

        },

        number: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            if (typeof value === 'string' && !value.match(options.pattern)) {
                pub.addMessage(messages, options.message, value);
                return;
            }

            if (options.min !== undefined && value < options.min) {
                pub.addMessage(messages, options.tooSmall, value);
            }
            if (options.max !== undefined && value > options.max) {
                pub.addMessage(messages, options.tooBig, value);
            }
        },

        range: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            if (!options.allowArray && $.isArray(value)) {
                pub.addMessage(messages, options.message, value);
                return;
            }

            var inArray = true;

            $.each($.isArray(value) ? value : [value], function(i, v) {
                if ($.inArray(v, options.range) == -1) {
                    inArray = false;
                    return false;
                } else {
                    return true;
                }
            });

            if (options.not === inArray) {
                pub.addMessage(messages, options.message, value);
            }
        },

        regularExpression: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            if (!options.not && !value.match(options.pattern) || options.not && value.match(options.pattern)) {
                pub.addMessage(messages, options.message, value);
            }
        },

        email: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            var valid = true;

            if (options.enableIDN) {
                var regexp = /^(.*<?)(.*)@(.*)(>?)$/,
                    matches = regexp.exec(value);
                if (matches === null) {
                    valid = false;
                } else {
                    value = matches[1] + punycode.toASCII(matches[2]) + '@' + punycode.toASCII(matches[3]) + matches[4];
                }
            }

            if (!valid || !(value.match(options.pattern) || (options.allowName && value.match(options.fullPattern)))) {
                pub.addMessage(messages, options.message, value);
            }
        },

        url: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            if (options.defaultScheme && !value.match(/:\/\//)) {
                value = options.defaultScheme + '://' + value;
            }

            var valid = true;

            if (options.enableIDN) {
                var regexp = /^([^:]+):\/\/([^\/]+)(.*)$/,
                    matches = regexp.exec(value);
                if (matches === null) {
                    valid = false;
                } else {
                    value = matches[1] + '://' + punycode.toASCII(matches[2]) + matches[3];
                }
            }

            if (!valid || !value.match(options.pattern)) {
                pub.addMessage(messages, options.message, value);
            }
        },

        trim: function ($form, attribute, options) {
            var $input = $form.find(attribute.input);
            var value = $input.val();
            if (!options.skipOnEmpty || !pub.isEmpty(value)) {
                value = $.trim(value);
                $input.val(value);
            }
            return value;
        },

        captcha: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            // CAPTCHA may be updated via AJAX and the updated hash is stored in body data
            var hash = $('body').data(options.hashKey);
            if (hash == null) {
                hash = options.hash;
            } else {
                hash = hash[options.caseSensitive ? 0 : 1];
            }
            var v = options.caseSensitive ? value : value.toLowerCase();
            for (var i = v.length - 1, h = 0; i >= 0; --i) {
                h += v.charCodeAt(i);
            }
            if (h != hash) {
                pub.addMessage(messages, options.message, value);
            }
        },

        compare: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            var compareValue, valid = true;
            if (options.compareAttribute === undefined) {
                compareValue = options.compareValue;
            } else {
                compareValue = $('#' + options.compareAttribute).val();
            }

            if (options.type === 'number') {
                value = value ? parseFloat(value) : 0;
                compareValue = compareValue ? parseFloat(compareValue) : 0;
            }
            switch (options.operator) {
                case '==':
                    valid = value == compareValue;
                    break;
                case '===':
                    valid = value === compareValue;
                    break;
                case '!=':
                    valid = value != compareValue;
                    break;
                case '!==':
                    valid = value !== compareValue;
                    break;
                case '>':
                    valid = value > compareValue;
                    break;
                case '>=':
                    valid = value >= compareValue;
                    break;
                case '<':
                    valid = value < compareValue;
                    break;
                case '<=':
                    valid = value <= compareValue;
                    break;
                default:
                    valid = false;
                    break;
            }

            if (!valid) {
                pub.addMessage(messages, options.message, value);
            }
        }
    };

    function getUploadedFiles(attribute, messages, options) {
        // Skip validation if File API is not available
        if (typeof File === "undefined") {
            return [];
        }

        var files = $(attribute.input).get(0).files;
        if (!files) {
            messages.push(options.message);
            return [];
        }

        if (files.length === 0) {
            if (!options.skipOnEmpty) {
                messages.push(options.uploadRequired);
            }
            return [];
        }

        if (options.maxFiles && options.maxFiles < files.length) {
            messages.push(options.tooMany);
            return [];
        }

        return files;
    }

    function validateFile(file, messages, options) {
        if (options.extensions && options.extensions.length > 0) {
            var index, ext;

            index = file.name.lastIndexOf('.');

            if (!~index) {
                ext = '';
            } else {
                ext = file.name.substr(index + 1, file.name.length).toLowerCase();
            }

            if (!~options.extensions.indexOf(ext)) {
                messages.push(options.wrongExtension.replace(/\{file\}/g, file.name));
            }
        }

        if (options.mimeTypes && options.mimeTypes.length > 0) {
            if (!~options.mimeTypes.indexOf(file.type)) {
                messages.push(options.wrongMimeType.replace(/\{file\}/g, file.name));
            }
        }

        if (options.maxSize && options.maxSize < file.size) {
            messages.push(options.tooBig.replace(/\{file\}/g, file.name));
        }

        if (options.minSize && options.minSize > file.size) {
            messages.push(options.tooSmall.replace(/\{file\}/g, file.name));
        }
    }

    return pub;
})(jQuery);

function appShowErrors(errors, $context) {
    if ($context === undefined) {
        $context = $('body');
    }
    $('.form-group', $context).removeClass('has-error');
    $('.form-group .help-block', $context).remove();
    if (errors) {
        $.each(errors, function(key, value) {
            var $input,
                $group,
                $help = $('<div>').addClass('help-block').html(value);
            if (key === 'recaptcha') {
                Recaptcha.reload();
                $input = $('#recaptcha_widget_div');
            } else {
                $input = $('[name=' + key + ']', $context);
            }
            $group = $input.closest('.form-group');
            $group.addClass('has-error');
            $col = $('div[class^="col-"], div[class*=" col-"]', $group)
            if ($col.length > 0) {
                $help.appendTo($col);
            } else {
                $help.appendTo($group);
            }
        });
        $('.form-group.has-error:first input', $context).focus();
    }
}
function appAuthLogin() {

    /**
     * Resend email button click action
     */
    $('.js-auth-login-resend-confirmation-email').on('click', function(){
        var $thisElement = $(this);
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/resendEmailConfirmation',
            data: {
                confirmationId: $thisElement.data('id')
            },
            success: function() {
                $('.js-auth-login-resend-success').removeClass('hide');
                $thisElement.prop('disabled', false);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				$('.js-auth-login-resend-failed').removeClass('hide');
                $thisElement.prop('disabled', false);
			},
            complete: function() {
                $('.js-auth-login-error').hide();
            }
        });
    });
}

function appAuthPasswordReset() {

    // Reset password request
    $('.btn.reset-password').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/password-reset-send-email',
            data: {
                email: $('.form-group .form-control[name=email]').val(),
                recaptcha_challenge_field: $('#recaptcha_challenge_field').val(),
                recaptcha_response_field:  $('#recaptcha_response_field').val(),
                recaptchaIgnore:           $('.form-group [name=recaptchaIgnore]').is(':checked') ? 1 : 0
            },
            success: function(resposne) {
                appShowErrors(resposne.errors, $form);
                if (resposne.errors) {
                    $thisElement.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/auth/password-reset-sent';
                }
            }
        });
    });

}
function appAuthPasswordResetToken() {

    // Reset password request
    $('.btn.reset-password').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/password-reset-set-new',
            data: {
                token:          $('[name=token]', $form).val(),
                email:          $('[name=email]', $form).val(),
                password:       $('[name=password]', $form).val(),
                passwordRepeat: $('[name=passwordRepeat]', $form).val()
            },
            success: function(resposne) {
                appShowErrors(resposne.errors, $form);
                if (resposne.errors) {
                    $thisElement.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/me';
                }
            }
        });
    });

}
function appAuthSignedup() {

    /**
     * Resend email button click action
     */
    $('.btn-resend-email').on('click', function(){
        var $thisElement = $(this);
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/resendEmailConfirmation',
            data: {
                confirmationId: $thisElement.data('id')
            },
            success: function() {
                $('.alert.alert-success').removeClass('hide');
                $thisElement.prop('disabled', false);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				$('.alert.alert-warning').removeClass('hide');
                $thisElement.prop('disabled', false);
			}
        });
    });
}
function appAuthSignup() {

    /**
     * Show/hide tooltips
     */
    $('input').data({
        'placement': 'left',
        'trigger': 'manual'
    }).on('focus', function() {
        if ($(this).val()) {
            $(this)
                .attr('data-original-title', $(this).prop('placeholder'))
                .tooltip('fixTitle')
                .tooltip('show');
        }
    }).on('blur', function() {
        $(this).tooltip('hide');
    });

    /**
     * On window unload
     */
    window.onbeforeunload = function() {
        if ($('.btn.signup', self.$form).is(':disabled')) {
            return;
        } else if ($('input[type=text]:visible, input[type=password]:visible').filter(function() {
            return ($(this).val().length !== 0);
        }).length > 0) {
            return _t('appjs', 'You have unsaved changes.');
        }
    };

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

    /**
     * Coordinator dropdown
     */
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
     * Init Select2
     */
    $('.form-group .form-control[name=schoolId]').select2({
        minimumInputLength: 2,
        formatNoMatches: function () {
            return $(this.element).data('formatnomatches');
        },
        query: function (query) {
            var data = {
                results: []
            };
            $.ajax({
                url: app.baseUrl + '/auth/schools',
                data:{
                    q: query.term
                },
                success: function(response) {
                    data.results = response;
                },
                complete: function() {
                    query.callback(data);
                }
            });
        }
    });

    /**
     * Signup request
     */
    $('.btn.signup').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/signup',
            data: {
                firstNameEn:    $('[name=firstNameEn]').val(),
                lastNameEn:     $('[name=lastNameEn]').val(),
                phoneHome:      $('[name=phoneHome]').val(),
                phoneMobile:    $('[name=phoneMobile]').val(),
                acmId:          $('[name=acmId]').val(),
                shirtSize:      $('[name=shirtSize]').val(),
                firstNameUk:    $('.form-group .form-control[name=firstNameUk]').val(),
                middleNameUk:   $('.form-group .form-control[name=middleNameUk]').val(),
                lastNameUk:     $('.form-group .form-control[name=lastNameUk]').val(),
                email:          $('.form-group .form-control[name=email]').val(),
                password:       $('.form-group .form-control[name=password]').val(),
                passwordRepeat: $('.form-group .form-control[name=passwordRepeat]').val(),
                schoolId:       $('.form-group .form-control[name=schoolId]').val(),
                type:           $('.form-group .btn.active [name=type]').val(),
                coordinator:    $('.form-group .btn.active [name=coordinator]').val(),
                rulesAgree:     $('.form-group [name=rulesAgree]').is(':checked') ? 1 : 0,
                recaptcha_challenge_field: $('#recaptcha_challenge_field').val(),
                recaptcha_response_field:  $('#recaptcha_response_field').val(),
                recaptchaIgnore:           $('.form-group [name=recaptchaIgnore]').is(':checked') ? 1 : 0
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $thisElement.prop('disabled', false);
                } else {
                    if (response.url === undefined) {
                        location.reload();
                    } else {
                        location.href = response.url;
                    }
                }
            }
        });
    });

}
function appDocsItem() {

    /**
     * Bind delete buttons
     */
    $('.document .document-delete').on('confirmed', function() {
        var $this = $(this),
            $document = $this.closest('.document'),
            redirectUrl = $document.data('after-delete-redirect');
        $this.prop('disabled', true);
        $document.css('opacity', OPACITY_DISABLED);
        $.ajax({
            url: app.baseUrl + '/staff/docs/delete',
            data: {
                id: $document.data('id')
            },
            success: function() {
                if (redirectUrl) {
                    location.href = redirectUrl;
                } else {
                    $document.remove();
                }
            }
        });
    });

}
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
    $('[name=tagList]').select2({
        width: '500'
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
                tagList:    $('[name=tagList]').val()
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
}
function appQaView() {

    /**
     * Init editor for answer
     */
    var editor = CKEDITOR.replace('answer-content', {
        toolbar: [
            [ 'Bold', 'Italic', 'Underline', 'Strike' ],
            [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ],
            [ 'Undo', 'Redo' ],
        ],
        extraPlugins: 'onchange',
        height: '200px'
    });

    /**
     * Give answer
     */
    $('.answer-create').on('click', function(){
        var $this = $(this);
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/qa/answer',
            data: {
                questionId: $('input[name=questionId]').val(),
                content:    editor.getData()
            },
            success: function(response) {
                $this.prop('disabled', false);
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    editor.setData('');
                    $('.qa-answer-list').append(response.answerHtml);
                    $('.qa-answer-count').text(response.answersCount).removeClass('hide');
                }
            }
        });
    });

}
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
        url:              app.baseUrl + '/upload/results',
        filters: {
            mime_types : [
                { title : "HTML files", extensions : "htm,html" }
            ]
        }
    }));

    self.uploader.init();

    self.uploader.bind('FilesAdded', function(up, files) {
        $('#uploadPickfiles').closest('.form-group')
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
        up.settings.multipart_params.geo        = $('[name=filter-geo]:checked').val();
    });

    self.uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    self.uploader.bind('Error', function(up, err) {
        $('#uploadPickfiles').closest('.form-group')
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
            location.href = response.url || app.baseUrl + '/results';
        }

    });
}

appResultsLatest.prototype.onchange = function() {
    $('#uploadResults').prop('disabled', false);
}
function appResultsView() {

    /**
     * Remove team
     */
    $(document).on('click', '.js-remove-team', function() {
        return false;
    }).on('confirmed', '.js-remove-team', function() {
        var $row = $(this).closest('.jqgrow');
        $('td', $row).css('opacity', OPACITY_DISABLED);
        $.ajax({
            url: app.baseUrl + '/staff/results/teamDelete',
            data: {
                id: $row.prop('id')
            },
            success: function() {
                $('#results').jqGrid('delRowData', $row.prop('id'));
            }
        });
        return false;
    });

    /**
     * Mark team as completed phase
     */
    $(document).on('change', '.results-phase-completed', function() {
        var $this = $(this)
            $row = $this.closest('.jqgrow'),
            phase = parseInt($('input[name=results-phase]').val());

        $this.prop('disabled', true).tooltip('hide').trigger('changed');

        // Send request
        $.ajax({
            url: app.baseUrl + '/staff/team/phaseUpdate',
            data: {
                id:     $this.data('team-id'),
                phase:  $this.is(':checked') ? phase + 1 : phase
            },
            success: function() {
                $this.prop('disabled', false);
            }
        });
    }).on('changed', '.results-phase-completed', function() {
        var $this = $(this)
            $row = $this.closest('.jqgrow');
        $('.results-prize-place', $row).prop('disabled', !$this.is(':checked'));
    });

    /**
     * Set prize place
     */
    $(document).on('change', '.results-prize-place', function() {
        var $this = $(this)
            $row = $this.closest('.jqgrow');

        $this.prop('disabled', true).tooltip('hide');

        // Send request
        $.ajax({
            url: app.baseUrl + '/staff/results/prizePlaceUpdate',
            data: {
                id:         $row.prop('id'),
                prizePlace: $this.val()
            },
            success: function() {
                $this.prop('disabled', false);
            }
        });
    });

}
function appStaffCoachesIndex() {

    // Set coach state
    $(document).on('click', '.btn.coach-state', function() {
        var $this = $(this);
        $this.siblings('.btn.coach-state').removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/coaches/set-state',
            data: {
                userId: $this.data('uid'),
                state: $this.data('state')
            }
        });
    });

}
function appStaffCoordinatorsIndex() {

    // Set coordinator state
    $(document).on('click', '.btn.coordinator-state', function() {
        var $this = $(this);
        $this.siblings('.btn.coordinator-state').removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/coordinators/set-state',
            data: {
                userId: $this.data('uid'),
                state: $this.data('state')
            }
        });
    });

}
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
                url: app.baseUrl + '/staff/docs/edit?' + $.param({
                    id:    $('[name=id]', $form).val(),
                    type:  $('[name=type]', $form).val()
                }),
                data: {
                    title: $('[name=title]', $form).val(),
                    desc:  $('[name=desc]', $form).val()
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

    self.uploader = new plupload.Uploader(pluploadHelpersSettings({
        browse_button:    'pickfiles',
        container:        'container',
        url:              app.baseUrl + '/upload/document'
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
/**
 * Langauges translations
 */
function appStaffLangIndex() {

    // Parse files
    $(document).on('click', '.btn.parse', function() {

        var $selfElement = $(this);

        // Send request
        $selfElement.prop('disabled', true);
        $('.alert').hide();
        $.ajax({
            url: app.baseUrl + '/staff/lang/parse',
            success: function() {
                $('.alert-success.parse-alert').show();
                $('table#message')[0].triggerToolbar();
            },
            complete: function() {
                $selfElement.prop('disabled', false);
            }
        });

    });

}
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
            url: app.baseUrl + '/staff/news/deleteImage',
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
                .find('img').attr('src', '/news/image/id/' + response.id);

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
/**
 * Change news status
 */
(function($) {

    var widgetOptions = {

        /**
         * List of default options
         */
        options: {
        },

        /**
         * Constructor
         */
        _create: function() {

            var self = this;

            // Publish news
            $('.btn', self.element).on('click', function() {
                var $selfElement = $(this);
                $selfElement.attr('disabled', true);
                $.ajax({
                    url: app.baseUrl + '/staff/news/publish',
                    data: {
                        id:     $(self.element).data('news-id'),
                        status: $selfElement.data('status')
                    },
                    success: function(response) {
                        if (response.errors) {
                            for (attrName in response.errors) {break;}
                            $('.btn:visible', self.element).tooltip({
                                title: response.errors[attrName][0]
                            }).tooltip('show');
                        } else {
                            $('.btn', self.element).attr('disabled', false).removeClass('hide');
                            $selfElement.addClass('hide');
                        }
                    }
                });
            });

        },

        /**
         * Option setter
         */
        _setOption: function(key, value) {

        },

        /**
         * Destructor
         */
        _destroy: function() {

        }

    };

    $.widget('app.staffNewsStatusSwitcher', widgetOptions);

}(jQuery));
function appStaffQatagsIndex() {

    /**
     * Delete tag button
     */
    $('.btn-delete-tag').on('confirmed', function(){
        var $btn = $(this);
        $.ajax({
            url: app.baseUrl + '/staff/qatags/delete',
            data: {
                id: $btn.data('id')
            },
            success: function(response) {
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    $btn.closest('.tag-row').fadeOut();
                }
            }
        });
    });

}
function appStaffQatagsManage() {

    /**
     * Save tag
     */
    $('.save-tag').on('click', function(){
        $.ajax({
            url: app.baseUrl + '/staff/qatags/manage',
            data: {
                id:   $('input[name=id]').val(),
                name: $('input[name=name]').val(),
                desc: $('textarea[name=desc]').val()
            },
            success: function(response) {
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    location = app.baseUrl + '/staff/qatags';
                }
            }
        });
    });

}
function appStaffStudentsIndex() {

    // Set student state
    $(document).on('click', '.btn.student-state', function() {
        var $this = $(this);
        $this.siblings('.btn.student-state').removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/students/set-state',
            data: {
                userId: $this.data('uid'),
                state: $this.data('state')
            }
        });
    });

}
function appStaffTeamImport(options)
{
   $(".teams").hide();
   $(".btn-save").hide();

   $('.btn-load').on('click', function() {
      var $this = $(this),
         $form = $this.closest('.form');

      $this.prop('disabled', true);

      $.ajax({
         url: app.baseUrl + '/staff/team/postTeams',
         data: {
            email: $('[name=email]').val(),
            password: $('[name=password]').val()
         },
         success: function (response) {
            if (response.errors) {
               var place = $("#formerrors");
               place.html("");
               $.each(response.errors, function(key, value) {
                  var html = '<div class="alert alert-danger text-center">' + value+ '</div>';
                  place.append(html);
               });
               $this.prop('disabled', false);
            } else {
               $list = $form.find('[name=team]');
               $list.html('');

               $.each(response.teams, function(key, value) {
                  var html = '<option value="' + value.id + '">' + value.title + '</option>';
                  $list.append(html);
               });

               $(".teams").show();
               $(".btn-save").show();
               $(".btn-load").hide();

               $('.auth input').prop('disabled', true);
               $this.prop('disabled', true);
            }
         }
      });
   });

   $('.btn-save').on('click', function() {
      var $this = $(this),
      $form = $this.closest('.form');

      $this.prop('disabled', true);

      $.ajax({
         url: app.baseUrl + '/staff/team/postImport',
         data: {
            team:             $('[name=team]').val(),
            email:            $('[name=email]').val(),
            password:         $('[name=password]').val()
         },
         success: function(response) {
            if (response.errors) {
               var place = $("#formerrors");
               place.html("");
               $.each(response.errors, function(key, value) {
                  var html = '<div class="alert alert-danger text-center">' + value+ '</div>';
                  place.append(html);
               });

            } else {
               if (response.teamId !== '' && response.teamId !== undefined) {
                  location.href = app.baseUrl + '/team/view/id/' + response.teamId;
               }
            }
            $this.prop('disabled', false);
         }
      });

   });
}
function appStaffTeamManage(options)
{

    /**
     * Select2 initialization
     */
    $('[name=memberIds]').select2();

    /**
     * Click handler to save school info
     */
    $('.btn-save').on('click', function() {
        var $this = $(this),
            $form = $this.closest('.form');
        $this.prop('disabled', true);

        $.ajax({
            url: app.baseUrl + '/staff/team/manage',
            data: {
                teamId:             options.teamId,
                name:               $('[name=name]').val(),
                memberIds:          $('[name=memberIds]').val(),
                isOutOfCompetition: $('[name=isOutOfCompetition]').is(':checked') ? 1 : 0
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    if (options.teamId !== '') {
                        location.href = app.baseUrl + '/team/view/id/' + options.teamId;
                    } else {
                        location.href = app.baseUrl + '/team/list';
                    }
                }
            }
        });

    });

    /**
     * onKeyUp action to append prefix to team name
     */
    $('[name=name]').on('keyup', function(){
        var $this = $(this),
            prefix = $this.data('prefix'),
            val = $this.val();

        if (val.length <= prefix.length) {
            $this.val(prefix);
        } else {
            $this.val(prefix + val.substr(prefix.length));
        }
    });

}
function appStaffTeamSchoolComplete() {

    /**
     * Save school info
     */
    $('.btn-save').on('click', function(){
        var $this = $(this),
            $form = $this.closest('.form');
        $this.prop('disabled', true);

        $.ajax({
            url: app.baseUrl + '/staff/team/schoolComplete',
            data: {
                shortNameUk:    $('[name=shortNameUk]').val(),
                fullNameEn:     $('[name=fullNameEn]').val(),
                shortNameEn:    $('[name=shortNameEn]').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = response.url;
                }
            }
        });
    });

}
function appTeamView() {

    var $modal = $('#baylor-modal'),
        $inputs = $('input', $modal);

    /**
     * Delete team button action
     */
    $('.btn-delete-team').on('confirmed', function(){
        $.ajax({
            url: app.baseUrl + '/staff/team/delete',
            data: {
                teamId: $(this).data('team-id')
            },
            success: function(response) {
                location.href = '/team/list';
            }
        });
    });

    /**
     * Sync team info
     */
    $('.js-baylor-import').on('click', function() {
        var $this = $(this),
            $progress = $('.progress', $modal).removeClass('hide');
        $this.prop('disabled', true);
        $inputs.prop('disabled', true);
        $('.alert-danger', $modal).addClass('hide');

        $.ajax({
            url: app.baseUrl + '/staff/team/baylorsync',
            data: {
                teamId: $('.btn-sync-team').data('team-id'),
                email: $('#baylor-modal__email').val(),
                password: $('#baylor-modal__password').val()
            },
            success: function(response) {
                if (response.errors) {
                    if (typeof response.errors === 'object') {
                        $('.js-baylor-user-not-found').removeClass('hide')
                            .html('<ul><li>' + response.errors.join('</li><li>') + '</li></ul>');
                    } else {
                        $('.js-baylor-error-creds', $modal).removeClass('hide');
                    }
                } else {
                    $modal.modal('hide');
                    location.reload();
                }
            },
            error: function() {
                $('.js-baylor-error-unknown', $modal).removeClass('hide');
            },
            complete: function() {
                $progress.addClass('hide');
                $this.prop('disabled', false);
                $inputs.prop('disabled', false);
            }
        });
    });

}
function appUserAdditionalCoach(options) {

    /**
     * Save button handler
     */
    $('.js-save').on('click', function(){
        var $this = $(this),
            $form = $this.closest('.form-horizontal');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/additional-coach-save',
            data: {
                language: options.lang,

                dateOfBirth:              $('[name=dateOfBirth]').val(),
                phoneHome:                $('[name=phoneHome]').val(),
                phoneMobile:              $('[name=phoneMobile]').val(),
                skype:                    $('[name=skype]').val(),
                tShirtSize:               $('[name=tShirtSize]:checked').val(),
                acmNumber:                $('[name=acmNumber]').val(),
                schoolName:               $('[name=schoolName]').val(),
                schoolNameShort:          $('[name=schoolNameShort]').val(),
                schoolPostEmailAddresses: $('[name=schoolPostEmailAddresses]').val(),

                position:      $('[name=position]').val(),
                officeAddress: $('[name=officeAddress]').val(),
                phoneWork:     $('[name=phoneWork]').val(),
                fax:           $('[name=fax]').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/additional/lang/' + options.lang;
                }
            }
        });
    });

}
function appUserAdditionalGeneral() {

    // Activate datepicker
    $('#dateOfBirth').datepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1
    });

}
function appUserAdditionalStudent(options) {

    /**
     * Save button handler
     */
    $('.js-save').on('click', function(){
        var $this = $(this),
            $form = $this.closest('.form-horizontal');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/additional-student-save',
            data: {
                language: options.lang,

                dateOfBirth:              $('[name=dateOfBirth]').val(),
                phoneHome:                $('[name=phoneHome]').val(),
                phoneMobile:              $('[name=phoneMobile]').val(),
                skype:                    $('[name=skype]').val(),
                tShirtSize:               $('[name=tShirtSize]:checked').val(),
                acmNumber:                $('[name=acmNumber]').val(),
                schoolName:               $('[name=schoolName]').val(),
                schoolNameShort:          $('[name=schoolNameShort]').val(),
                schoolPostEmailAddresses: $('[name=schoolPostEmailAddresses]').val(),

                studyField:          $('[name=studyField]').val(),
                speciality:          $('[name=speciality]').val(),
                faculty:             $('[name=faculty]').val(),
                group:               $('[name=group]').val(),
                course:              $('[name=course]').val(),
                schoolAdmissionYear: $('[name=schoolAdmissionYear]').val(),

                document:            $('[name=document]').val(),
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/additional/lang/' + options.lang;
                }
            }
        });
    });

}
function appUserApprovalRequest()
{

    /**
     * Send coach approval request
     */
    $('.js-user-approval-request-button').off('click').on('click', function() {
        var $button = $(this),
            $label = $button.next('.js-user-approval-request-label');
        $button.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/approvalRequest',
            data: {
                role: $button.data('role')
            },
            success: function() {
                $button.addClass('hide');
                $label.removeClass('hide');
            }
        });
    });

}

function appUserBaylor() {

    var $modal = $('#baylor-modal'),
        $inputs = $('input', $modal);

    $('.js-baylor-import').on('click', function() {

        var $this = $(this),
            $progress = $('.progress', $modal).removeClass('hide');
        $this.prop('disabled', true);
        $inputs.prop('disabled', true);
        $('.alert-danger', $modal).addClass('hide');

        $.ajax({
            url: app.baseUrl + '/user/baylor',
            data: {
                email: $('#baylor-modal__email').val(),
                password: $('#baylor-modal__password').val()
            },
            success: function(response) {
                if (response.errors) {
                    $('.js-baylor-error-creds', $modal).removeClass('hide');
                } else {
                    $modal.modal('hide');
                    $('.js-baylor-panel').removeClass('hide');

                    $.each(response.data, function(key, value) {
                        $('[data-baylor-' + key + ']').val(value);
                        $('[data-baylor-' + key + '-text]')
                            .removeClass('hide')
                            .find('p')
                            .text(value);
                    });

                    $('input[name=tShirtSize]')
                        .prop('checked', false)
                        .parent('label')
                        .removeClass('active');
                    $('input[name=tShirtSize][value=' + response.data.shirtSize + ']')
                        .prop('checked', true)
                        .parent('label')
                        .addClass('active');

                    $('.js-save').click();
                }
            },
            error: function() {
                $('.js-baylor-error-unknown', $modal).removeClass('hide');
            },
            complete: function() {
                $progress.addClass('hide');
                $this.prop('disabled', false);
                $inputs.prop('disabled', false);
            }
        });

    });

}
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
            url: app.baseUrl + '/user/passwordChange',
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

            $('.js-user-photo').prop('src', app.baseUrl + '/user/photo/id/' + response.photoId + '.jpg');
        }

    });
};