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

