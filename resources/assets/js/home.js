/**
 * Created by filip on 20.5.15.
 */
(function ($) {
    var topRatedIndex = 5
        , topRatedLoaded = false
        , topRated = $('#top-rated')
        , popularIndex = 5
        , popularLoaded = false
        , popular = $('#popular');

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

        var topRatedWayp = new Waypoint({
            element: document.getElementById('top-rated'),
            handler: function (direction) {
                if (direction === 'down' && !topRatedLoaded) {
                    $.ajax({
                        type: 'GET',
                        url: url_base + '/top-rated',
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
        })
            , popularWayp = new Waypoint({
                element: document.getElementById('popular'),
                handler: function (direction) {
                    if (direction === 'down' && !popularLoaded) {
                        $.ajax({
                            type: 'GET',
                            url: url_base + '/popular',
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

        $("#loginForm").on('submit', function (e) {
            e.preventDefault();

            var username = this.elements['username'].value;
            var password = this.elements['password'].value;
            var _token = this.elements['_token'].value;

            $.ajax({
                type: 'POST',
                url: url_base + '/auth/login',
                data: {
                    username: username,
                    password: password,
                    _token: _token
                },
                dataType: 'json'
            })
                .done(function (response) {
                    location.reload();
                })
                .fail(function (xhr) {
                    var error = xhr.responseJSON;

                    console.log(error);

                    var $errors = $("#errors");

                    $errors.html('');
                    for (var key in error) {
                        if (error.hasOwnProperty(key)) {
                            var obj = error[key];
                            $errors.append('<p>' + obj + '</p>').hide().show('fast');
                        }
                    }
                });

        });
    });

    var populateSlick = function(slick, items, slideIndex) {
        var i = slideIndex;
        items.map(function (item) {
            if(i !== 0) {
                slick.slick('slickRemove', i - 1);
                i--;
                slideIndex--;
            }

            var imgSrc = (item.backdrop_path !== undefined) ? 'http://image.tmdb.org/t/p/w500' + item.backdrop_path : '';
            var html = '<div class="list-item animated bounceIn">' +
                '<img class="img-responsive" src="' + imgSrc + '" alt="' + item.title + '">' +
                '</div>';

            slick.slick('slickAdd', html);
            slideIndex++;
        });
    };

})(window.jQuery);