
##WP Plugin for deleting all products from WooCommerce
***
####Insert next code to page:

```html
   <div class="row">
        <form action="" method="post" class="delete-all-products">
            <?php wp_nonce_field( 'delete-products', 'verify' )?>
            <input type="submit"  value="Delete all products">
    </div>
```