/**
 * Created by filip on 2.6.15.
 */

(function ($) {
    var similar = $('#similar-movies')
        , similarIndex = 4
        , similarLoaded = false
        , searchList = $('#search-list')
        , searchPage = 2
        , raty = $('#raty')
        , _token = $('input[name="_token"]').val()
        , nanobar = new Nanobar({
            bg: '#FFD633',
            id: 'nano'
        });

    var rateMovie = function (raty, score, movieId) {
        $.ajax({
            type: 'POST',
            url: url_base + '/movies/rating',
            data: {
                _token: _token,
                movie_id: movieId,
                score: score
            },
            dataType: 'json'
        })
            .done(function (response) {
                raty.raty('readOnly', true);
            });
    };

    var search = function (query, page, list) {
        nanobar.go(30);
        $.ajax({
            type: 'GET',
            url: url_base + '/movies/search',
            data: {
                _token: _token,
                search: query,
                page: page
            },
            dataType: 'html'
        })
            .done(function (response) {
                var progress = 50;
                if (page > 1) {
                    var loadImages = $('#loadImages');
                    loadImages.html(response);
                    loadImages.imagesLoaded()
                        .always(function () {
                        nanobar.go(100);
                        list.append(response);
                    })
                        .progress(function(instance, image) {
                            nanobar.go(progress);
                            progress += 2;
                        });
                } else {
                    list.html(response);
                    list.imagesLoaded()
                        .always(function () {
                            nanobar.go(100);
                            list.removeClass('hide');
                        })
                        .progress(function(instance, image) {
                            nanobar.go(progress);
                            progress += 2;
                        });
                }


            })
            .fail(function (response) {
                //
            });
    };

    $(document).ready(function () {
        if (similar.length > 0) {
            $.ajax({
                type: 'GET',
                url: url_base + '/movies/' + $('#movieId').val() + '/similar-movies',
                dataType: 'json'
            })
                .done(function (response) {
                    populateSlick(similar, response, similarIndex);
                    similarLoaded = true;
                })
                .fail(function (xhr) {
                    //
                });

            similar.slick({
                dots: true,
                arrows: false,
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
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
        }

        if (raty.length > 0) {
            raty.raty({
                half: true,
                number: 10,
                path: '../images',
                score: function () {
                    return $(this).data('score');
                },
                click: function (score, evt) {
                    rateMovie(raty, score, $('#movieId').val());
                },
                readOnly: function () {
                    return $(this).data('readonly');
                }
            })
        }

        $('#favoritesForm').on('submit', function (e) {
            e.preventDefault();
            var favoriteBtn = $('#add-to-favorite');
            favoriteBtn.prop('disabled', true);

            var media_type = $('input[name="media_type"]').val()
                , media_id = $('input[name="media_id"]').val()
                , favorite = $('input[name="favorite"]').val();
            $.ajax({
                type: 'POST',
                url: url_base + '/movies/favorites',
                data: {
                    _token: _token,
                    media_type: media_type,
                    media_id: media_id,
                    favorite: favorite
                },
                dataType: 'json'
            })
                .done(function (response) {
                    favoriteBtn.prop('disabled', false);
                    if (response.status_code == 1) {
                        $('input[name="favorite"]').val('false');
                        favoriteBtn.html('Remove from favorites');
                        favoriteBtn.removeClass('btn-success').addClass('btn-primary');
                    } else {
                        $('input[name="favorite"]').val('true');
                        favoriteBtn.html('Add to favorites');
                        favoriteBtn.removeClass('btn-primary').addClass('btn-success');
                    }
                })
                .fail(function (response) {
                    favoriteBtn.prop('disabled', false);
                });
        });

        $('#watchlistForm').on('submit', function (e) {
            e.preventDefault();
            var watchlistBtn = $('#add-to-watchlist');
            watchlistBtn.prop('disabled', true);

            var media_type = $('input[name="media_type"]').val()
                , media_id = $('input[name="media_id"]').val()
                , watchlist = $('input[name="watchlist"]').val();
            $.ajax({
                type: 'POST',
                url: url_base + '/movies/watchlist',
                data: {
                    _token: _token,
                    media_type: media_type,
                    media_id: media_id,
                    watchlist: watchlist
                },
                dataType: 'json'
            })
                .done(function (response) {
                    watchlistBtn.prop('disabled', false);
                    if (response.status_code == 1) {
                        $('input[name="watchlist"]').val('false');
                        watchlistBtn.html('Remove from watchlist');
                        watchlistBtn.removeClass('btn-warning').addClass('btn-danger');
                    } else {
                        $('input[name="watchlist"]').val('true');
                        watchlistBtn.html('Add to watchlist');
                        watchlistBtn.removeClass('btn-danger').addClass('btn-warning');
                    }
                })
                .fail(function (response) {
                    watchlistBtn.prop('disabled', false);
                });
        });

        $("#searchForm").on('submit', function (e) {
            e.preventDefault();

            var query = $('input[name="search"]').val();

            searchList.html('');
            searchPage = 2;
            search(query, 1, searchList);

            return false;
        });

        $(window).scroll(function () {
            if (searchList.html() != '') {
                if ($(window).height() + $(window).scrollTop() == $(document).height()) {
                    var query = $('input[name="search"]').val();
                    search(query, searchPage++, searchList);
                }
            }
        });
    });

})(window.jQuery);