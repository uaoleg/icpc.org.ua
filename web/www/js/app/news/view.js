function appNewsView() {

    /**
     * Thumbnail click action
     */

    $('.news-view__image_item').on('click', function(){
        var $this = $(this);

        $('.modal')
            .first()
            .modal({})
            .find('img')
            .attr('src', $this.attr('src'));
    });

}