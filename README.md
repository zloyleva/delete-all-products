
<h2>Insert next code to page:</h2>

   <div class="row">
        <form action="" method="post" class="delete-all-products">
            <?php wp_nonce_field( 'delete-products', 'verify' )?>
            <input type="submit"  value="Delete all products">
    </div>