/**
 * Created by filip on 7.6.15.
 */
(function ($) {

    var populateRecommended = function (movies, grid) {
        var html = ''
            , imgSrc = '';
        movies.map(function (item) {
            imgSrc = (item.backdrop_path != null || item.backdrop_path != undefined) ? 'http://image.tmdb.org/t/p/w500' + item.backdrop_path : url_base + '/images/no_image.jpg';

            html = $('<div class="item">' +
            '<a href="' + url_base + "/movies/" + item.id + '">' +
            '<img class="img-responsive" src="' + imgSrc + '" title="' + item.title + '">' +
            '</a></div>');

            grid.masonry()
                .append(html)
                .masonry('appended', html);
        });

        grid.imagesLoaded(function() {
            grid.masonry('layout');
        });
    };

    $(document).ready(function () {

        var movieIds = []
            , current = 1
            , grid = $('.grid');

        if($('#movie-ids').length > 0) {
            movieIds = JSON.parse($('#movie-ids').val());
        }

        grid.masonry({
            itemSelector: '.item',
            columnWidth: '.grid-sizer',
            percentPosition: true
        });

        if (movieIds.length > 0) {
            $.ajax({
                type: 'GET',
                url: url_base + '/account/recommended',
                data: {
                    id: movieIds[0]
                },
                dataType: 'json'
            })
                .done(function (response) {
                    populateRecommended(response.results, grid);
                });
        }

        $('#load-more').on('click', function() {
            if(current < movieIds.length) {
                $.ajax({
                    type: 'GET',
                    url: url_base + '/account/recommended',
                    data: {
                        id: movieIds[current]
                    },
                    dataType: 'json'
                })
                    .done(function (response) {
                        current++;
                        populateRecommended(response.results, $('.grid'));
                    });
            }
        });

        $('#favorites-pagination a').on('click', function (event) {
            event.preventDefault();
            if ( $(this).attr('href') != '#' ) {
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('href'),
                    dataType: 'html'
                })
                    .done(function(response) {
                        favoritesPage++;
                        $('#favorites-pagination').html(response);
                    });
            }
        });

        $('#watchlist-pagination a').on('click', function (event) {
            event.preventDefault();
            if ( $(this).attr('href') != '#' ) {
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('href'),

                    dataType: 'html'
                })
                    .done(function(response) {
                        watchlistPage++;
                        $('#watchlist-pagination').html(response);
                    });
            }
        });
    });

})(window.jQuery);