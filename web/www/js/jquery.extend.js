(function($){

    var functionList = {

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

