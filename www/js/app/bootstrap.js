function appBootstrap(appConf) {

    // Constants
    DATE_FORMAT_DATEPICKER = 'yyyy-mm-dd';
    DATE_FORMAT_INPUT_MASK = {
        alias: 'yyyy-mm-dd',
        placeholder: 'гггг-мм-дд'
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

        // Form submit animation
        $('form[data-submit-animation]').on('submit', function() {
            $(document).trigger('ajax-load');
        });

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
