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
                    success: function() {
                        $('.btn', self.element).attr('disabled', false).removeClass('hide');
                        $selfElement.addClass('hide');
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