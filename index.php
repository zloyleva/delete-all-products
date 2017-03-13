<?php
/*
Plugin Name: Delete all products
Plugin URI: http://wordpress.org/plugins/my-plugin/
Description: This is a plugin for deleted all products from WooCommerce
Author: ZloyLeva
Version: 1.0
Author URI: http://localhost/
*/


class DeleteAllProducts {

    public $db;
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_required_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'delete_ajax_data' ), 99 );
        add_action( 'wp_ajax_call_delete_products', array( $this, 'delete_all_products' ));

        global $wpdb;
        $this->db = $wpdb;
    }

    /**
     *  Register scripts and styles
     */
    public function load_required_scripts() {
        wp_enqueue_script( 'jquery', true );
        wp_enqueue_script( 'delete-all-product', plugins_url( '/js/delete-all-product.js', __FILE__ ), array('jquery'));
    }

    /**
     * Loaded the variables to front-end
     */
    public function delete_ajax_data(){
        wp_localize_script(
            'jquery',
            'deleteAjax',
            array(
                'url' => admin_url('admin-ajax.php')
            )
        );
    }

    public function delete_all_products(){

        $this->db->posts;
        $post_type = 'product';

        if( !(current_user_can('administrator') && wp_verify_nonce( $_REQUEST['verify'], 'delete-products') ) ){
            return 'Error';
        }

        /**
         * DELETE FROM wp_term_relationships WHERE object_id IN (SELECT ID FROM wp_posts WHERE post_type = 'product')
         * DELETE FROM wp_postmeta WHERE post_id IN (SELECT ID FROM wp_posts WHERE post_type = 'product')
         * DELETE FROM wp_posts WHERE post_type = 'product'
         */

        $sql_1 = "DELETE FROM {$this->db->term_relationships} WHERE object_id IN (SELECT ID FROM {$this->db->posts} WHERE post_type = '%s')";
        $sql_2 = "DELETE FROM {$this->db->postmeta} WHERE post_id IN (SELECT ID FROM {$this->db->posts} WHERE post_type = '%s')";
        $sql_3 = "DELETE FROM {$this->db->posts} WHERE post_type = '%s'";

        $x1 = $this->db->query( $this->db->prepare( $sql_1, $post_type) );
        $x2 = $this->db->query( $this->db->prepare( $sql_2, $post_type) );
        $x3 = $this->db->query( $this->db->prepare( $sql_3, $post_type) );

        echo "Deleted: {$x3} products";
        wp_die();
    }
}

$object = new DeleteAllProducts();