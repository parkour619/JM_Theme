jQuery(function ($) {
    var currentPage = infinite_scroll_params.current_page;
    var maxPage = infinite_scroll_params.max_page;

    function load_more_posts() {
        if (currentPage < maxPage) {
            currentPage++;
            var data = {
                action: 'load_more_posts',
                page: currentPage,
            };

            $.post(infinite_scroll_params.ajax_url, data, function (response) {
                if (response) {
                    $('.post-design-sec').append(response);
                }
            });
        }
    }

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            load_more_posts();
        }
    });
});
