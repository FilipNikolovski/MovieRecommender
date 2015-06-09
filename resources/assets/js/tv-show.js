(function ($) {
    var topRatedIndex = 5
        , topRatedLoaded = false
        , topRated = $('#top-rated-tv')
        , popularIndex = 5
        , popularLoaded = false
        , popular = $('#popular-tv');

    $(document).ready(function () {
        topRated.slick({
            dots: true,
            arrows: false,
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        popular.slick({
            dots: true,
            arrows: false,
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        if($('#top-rated-tv').length > 0) {
            var topRatedWayp = new Waypoint({
                element: document.getElementById('top-rated-tv'),
                handler: function (direction) {
                    if (direction === 'down' && !topRatedLoaded) {
                        $.ajax({
                            type: 'GET',
                            url: url_base + '/top-rated-tv',
                            dataType: 'json'
                        })
                            .done(function (response) {
                                populateSlick(topRated, response, topRatedIndex);
                                topRatedLoaded = true;
                            })
                            .fail(function (xhr) {
                                //
                            });
                    }
                },
                offset: '180%'
            });
        }
        if($('#popular-tv').length > 0) {
            var popularWayp = new Waypoint({
                element: document.getElementById('popular-tv'),
                handler: function (direction) {
                    if (direction === 'down' && !popularLoaded) {
                        $.ajax({
                            type: 'GET',
                            url: url_base + '/popular-tv',
                            dataType: 'json'
                        })
                            .done(function (response) {
                                populateSlick(popular, response, popularIndex);
                                popularLoaded = true;
                            })
                            .fail(function (xhr) {
                                //
                            });
                    }
                },
                offset: '180%'
            });
        }
    });

})(window.jQuery);