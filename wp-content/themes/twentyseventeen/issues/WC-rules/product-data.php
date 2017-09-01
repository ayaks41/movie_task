<?php
//Adding register extra field (skype)
function extra_register_field() { ?>
       <p class="form-row form-row-wide">
       <label for="skype"><?php _e( 'Skype', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="skype" id="skype" value="<?php esc_attr_e( $_POST['skype'] ); ?>" />
       </p>
       <div class="clear"></div>
       <?php
 }
add_action( 'woocommerce_register_form_start', 'extra_register_field' );

//Adding register extra field saving
function save_extra_register_field( $customer_id ) {
    if ( isset( $_POST['skype'] ) ) {
             update_user_meta( $customer_id, 'skype', sanitize_text_field( $_POST['skype'] ) );
          }
}
add_action( 'woocommerce_created_customer', 'save_extra_register_field' );

//Redirect after user registration
function registration_redirect() {
    return get_permalink( get_page_by_path( 'movies-shop' ) );
}
add_action('woocommerce_registration_redirect', 'registration_redirect', 2);

//Weak password resolution
function remove_password_strength() {
  if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
    wp_dequeue_script( 'wc-password-strength-meter' );
  }
}
add_action( 'wp_print_scripts', 'remove_password_strength', 100 );

//Adding movie custom field like a price to woocommerce
add_filter('woocommerce_get_price','reigel_woocommerce_get_price',20,2);
function reigel_woocommerce_get_price($price,$post){
	if ($post->post->post_type === 'movie')
		$price = get_post_meta($post->id, "_price", true);
	return $price;
}

//Rewrite WooCommecre class to custom class, which add possibility to add to cart movie posts
function woocommerce_data_stores ( $stores ) {
	$stores['product'] = 'Movie_Product_Data_Store_CPT';
	return $stores;
}
add_filter( 'woocommerce_data_stores', 'woocommerce_data_stores' );

//WC product data class rewrite
class Movie_Product_Data_Store_CPT extends WC_Product_Data_Store_CPT {

    /**
     * Method to read a product from the database.
     * @param WC_Product
     */

    public function read( &$product ) {

        $product->set_defaults();

        if ( ! $product->get_id() || ! ( $post_object = get_post( $product->get_id() ) ) || ! in_array( $post_object->post_type, array( 'movie', 'product' ) ) ) { // change birds with your post type
            throw new Exception( __( 'Invalid product.', 'woocommerce' ) );
        }

        $id = $product->get_id();

        $product->set_props( array(
            'name'              => $post_object->post_title,
            'slug'              => $post_object->post_name,
            'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
            'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
            'status'            => $post_object->post_status,
            'description'       => $post_object->post_content,
            'short_description' => $post_object->post_excerpt,
            'parent_id'         => $post_object->post_parent,
            'menu_order'        => $post_object->menu_order,
            'reviews_allowed'   => 'open' === $post_object->comment_status,
        ) );

        $this->read_attributes( $product );
        $this->read_downloads( $product );
        $this->read_visibility( $product );
        $this->read_product_data( $product );
        $this->read_extra_data( $product );
        $product->set_object_read( true );
    }

    /**
     * Get the product type based on product ID.
     *
     * @since 3.0.0
     * @param int $product_id
     * @return bool|string
     */
    public function get_product_type( $product_id ) {
        $post_type = get_post_type( $product_id );
        if ( 'product_variation' === $post_type ) {
            return 'variation';
        } elseif ( in_array( $post_type, array( 'movie', 'product' ) ) ) { // change birds with your post type
            $terms = get_the_terms( $product_id, 'product_type' );
            return ! empty( $terms ) ? sanitize_title( current( $terms )->name ) : 'simple';
        } else {
            return false;
        }
    }
}
