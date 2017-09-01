<?php
//Registration custom post type (movie)
function register_post_movie()
{
	if ( ! is_blog_installed() || post_type_exists( 'movie' ) ) {
		return;
	}

	do_action( 'woocommerce_register_post_type' );

	$supports = array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'publicize', 'wpcom-markdown' );

	if ( 'yes' === get_option( 'woocommerce_enable_reviews', 'yes' ) ) {
		$supports[] = 'comments';
	}

	register_post_type( 'movie',
	array(
		'labels'              => array(
			'name'                  => __( 'Movies', 'woocommerce' ),
			'singular_name'         => __( 'Movie', 'woocommerce' ),
			'all_items'             => __( 'All Movies', 'woocommerce' ),
			'menu_name'             => _x( 'Movies', 'Admin menu name', 'woocommerce' ),
			'add_new'               => __( 'Add New', 'woocommerce' ),
			'add_new_item'          => __( 'Add new movie', 'woocommerce' ),
			'edit'                  => __( 'Edit', 'woocommerce' ),
			'edit_item'             => __( 'Edit movie', 'woocommerce' ),
			'new_item'              => __( 'New movie', 'woocommerce' ),
			'view'                  => __( 'View movie', 'woocommerce' ),
			'view_item'             => __( 'View movie', 'woocommerce' ),
			'search_items'          => __( 'Search movies', 'woocommerce' ),
			'not_found'             => __( 'No movies found', 'woocommerce' ),
			'not_found_in_trash'    => __( 'No movies found in trash', 'woocommerce' ),
			'parent'                => __( 'Parent movie', 'woocommerce' ),
			'featured_image'        => __( 'Movie image', 'woocommerce' ),
			'set_featured_image'    => __( 'Set product image', 'woocommerce' ),
			'remove_featured_image' => __( 'Remove movie image', 'woocommerce' ),
			'use_featured_image'    => __( 'Use as movie image', 'woocommerce' ),
			'insert_into_item'      => __( 'Insert into movie', 'woocommerce' ),
			'uploaded_to_this_item' => __( 'Uploaded to this movie', 'woocommerce' ),
			'filter_items_list'     => __( 'Filter movie', 'woocommerce' ),
			'items_list_navigation' => __( 'Movies navigation', 'woocommerce' ),
			'items_list'            => __( 'Movies list', 'woocommerce' ),
		),
		'description'         => __( 'This is where you can add new movies to your store.', 'woocommerce' ),
		'public'              => true,
		'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
		'menu_icon'						=> 'dashicons-video-alt',
		'taxonomies'					=> array( 'post_cat' ),
		'capability_type'     => 'product',
		'map_meta_cap'        => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'hierarchical'        => false,
		'query_var'           => true,
		'supports'            => $supports,
		'has_archive'         => true,
		'show_in_nav_menus'   => true,
		'show_in_rest'        => true,
		)
	);
}
add_action( 'init', 'register_post_movie',0);

//Registration taxonomies to movie posts
function register_taxonomy_movie()
{
	if ( ! is_blog_installed() ) {
		return;
	}

	do_action( 'woocommerce_register_taxonomy' );

	register_taxonomy( 'movie_cat', array( 'movie' ) ,
		array(
			'hierarchical'          => true,
			'update_count_callback' => '_wc_term_recount',
			'label'                 => __( 'Categories', 'woocommerce' ),
			'labels' => array(
					'name'              => __( 'Movie categories', 'woocommerce' ),
					'singular_name'     => __( 'Category', 'woocommerce' ),
					'menu_name'         => _x( 'Categories', 'Admin menu name', 'woocommerce' ),
					'search_items'      => __( 'Search categories', 'woocommerce' ),
					'all_items'         => __( 'All categories', 'woocommerce' ),
					'parent_item'       => __( 'Parent category', 'woocommerce' ),
					'parent_item_colon' => __( 'Parent category:', 'woocommerce' ),
					'edit_item'         => __( 'Edit category', 'woocommerce' ),
					'update_item'       => __( 'Update category', 'woocommerce' ),
					'add_new_item'      => __( 'Add new category', 'woocommerce' ),
					'new_item_name'     => __( 'New category name', 'woocommerce' ),
					'not_found'         => __( 'No categories found', 'woocommerce' ),
				),
			'show_ui'               => true,
			'query_var'             => true,
			'capabilities'          => array(
				'manage_terms' => 'manage_product_terms',
				'edit_terms'   => 'edit_product_terms',
				'delete_terms' => 'delete_product_terms',
				'assign_terms' => 'assign_product_terms',
			),
			'rewrite'          => array(
				'slug'         => 'movie-category',
				'with_front'   => false,
				'hierarchical' => true,
			),
		)
	);
}
add_action( 'init', 'register_taxonomy_movie',0);

//Regisration custom metabox (price)
function add_movie_pricebox()
{
  add_meta_box(
    'price',      // Unique ID
    esc_html__( 'Movie Price', 'example' ),    // Title
    'movie_price_meta_box',   // Callback function
    'movie',         // Рost type
    'side',         // Context
    'default'         // Priority
  );
}

//Custom pricebox body
function movie_price_meta_box( $post )
{ ?>
  <?php wp_nonce_field( basename( __FILE__ ), 'movie_pricebox_nonce' ); ?>

  <p>
    <input class="widefat" type="text" name="_price" id="movie-price" value="<?php echo esc_attr( get_post_meta( $post->ID, '_price', true ) ); ?>" size="30" />
  </p>
<?php }

//Adding custom metabox
function movie_pricebox_setup()
{
  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'add_movie_pricebox' );

	add_action( 'save_post', 'save_movie_pricebox', 10, 2 );
}
add_action( 'load-post.php', 'movie_pricebox_setup' );
add_action( 'load-post-new.php', 'movie_pricebox_setup' );

//Saving for pricebox
function save_movie_pricebox( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['movie_pricebox_nonce'] ) || !wp_verify_nonce( $_POST['movie_pricebox_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['_price'] ) ? sanitize_html_class( $_POST['_price'] ) : '' );

  /* Get the meta key. */
  $meta_key = '_price';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );

	update_post_meta( $post_id, '_regular_price', $new_meta_value );
}
