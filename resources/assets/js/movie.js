/**
 * Created by filip on 2.6.15.
 */

(function ($) {
    var similar = $('#similar-movies')
        , similarIndex = 4
        , similarLoaded = false;

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

        var raty = $('#raty');
        if(raty.length > 0) {
            raty.raty({
                half: true,
                number: 10,
                path: '../images',
                click: function(score, evt) {

                },
                readOnly: function() {
                    return false;
                }
            })
        }
    });

})(window.jQuery);