/**
 * Created by filip on 20.5.15.
 */
(function($){
    $(document).ready(function (){

        $("#loginForm").on('submit', function(e) {
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
                .done(function(response) {
                    location.reload();
                })
                .fail(function(xhr) {
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


    /*

     $(window).load(function() {

     });

     $(window).resize(function() {

     });

     */

})(window.jQuery);