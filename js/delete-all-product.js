/**
 * Delete all products: Plugin's JS
 */

(function ($) {
    $(function () {

        $(document).submit('.delete-all-products', function (event) {
            event.preventDefault();

            var data = {
                action: 'call_delete_products',
                verify: $('#verify').val()
            };

            $.ajax({
                url     :   deleteAjax.url,
                method  :   'post',
                data    :   data,
                success :   function (recponce) {
                    console.log(recponce);
                }
            });
        })

    });
})(jQuery);