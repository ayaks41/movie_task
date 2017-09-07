<?php
/**
 *Template Name: Movies
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

 $args = array(
   'post_type' => 'movie',
   'posts_per_page' => -1,
   'orderby' => 'comment_count'
 );

 $query = new WP_Query( $args );

 get_header( 'shop' ); ?>

 	<?php
 		do_action( 'woocommerce_before_main_content' );
 	?>

 		<?php if ( $query->have_posts() )  : ?>

 			<?php
 				do_action( 'woocommerce_before_shop_loop' );
 			?>
      <ul class="products">

 				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

 					<?php
 						do_action( 'woocommerce_shop_loop' );

            ?>
            <li <?php post_class('product'); ?>>
              <?php
              global $post;
              $product = wc_get_product(get_the_ID());

              $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog');
              echo $product ? $product->get_image( $image_size ) : '';
              ?>

              <h2 class="woocommerce-loop-product__title"><?php echo get_the_title();?></h2>
              <?php
              wc_get_template( 'loop/price.php');
              wc_get_template( 'loop/add-to-cart.php');
              ?>
            </li>

 				<?php endwhile; ?>


      </ul>

 		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

 			<?php
 				do_action( 'woocommerce_no_products_found' );
 			?>

 		<?php endif; ?>
    <?php wp_reset_postdata(); ?>

 	<?php
 	// 	do_action( 'woocommerce_after_main_content' );
 	?>

 	<?php
 	// 	do_action( 'woocommerce_sidebar' );
 	?>

 <?php get_footer( 'shop' ); ?>
