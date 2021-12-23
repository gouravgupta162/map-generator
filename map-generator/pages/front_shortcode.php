<?php 
	
	function starmap_init_function( $atts, $content, $shortcode_tag ){
	
		$dir = plugins_url('map-generator');
		
		// wp_enqueue_script('jquery-min', "$dir/js/jquery.js" );
		wp_enqueue_script('jquery-min', "$dir/js/jquery-1.10.0.min.js" ); 
		wp_enqueue_script('jquery-maps-api','https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyC_ndCYk7BpsdhKCNEw8K4I0BqjGmW4lGI&sensor=false&libraries=places');
		wp_enqueue_script('moment-min', "$dir/js/moment.min.js" );  
		wp_enqueue_script('virtualsky', "$dir/js/virtualsky.js" );
		wp_enqueue_script('jquery-geocomplete', "$dir/js/jquery.geocomplete.js" );
		wp_enqueue_script('bootstrap-datetimepicker', "$dir/js/bootstrap-datetimepicker.min.js" );
		// wp_enqueue_script('bootstrap', "$dir/js/bootstrap.js" );
		wp_enqueue_script('script', "$dir/js/script.js" );
		
		wp_enqueue_style('bootstrap-datetimepicker', "$dir/css/bootstrap-datetimepicker.min.css" );
		wp_enqueue_style('bootstrap', "$dir/css/bootstrap.css");
		 
		
		$html = "<div class='form-group '> 
				<button type='button' id='generate' data-dir='$dir' class='btn  btn-lg btn-block btn-gen'>Generate</button>    
			</div>";
		return $html;
	}
	add_shortcode( 'starmap_init', 'starmap_init_function'  );
	
	// add_action( 'woocommerce_after_add_to_cart_button', 'html_after_add_to_cart' , 10, 3 );
	
	// function html_after_add_to_cart(){
		// echo do_shortcode('[starmap_init]');   
	// }
	
	// add_action( 'woocommerce_single_product_summary', 'starmap_cstm_form', 20 );
	add_action( 'woocommerce_before_add_to_cart_button', 'starmap_cstm_form', 20 );
	 
	function starmap_cstm_form() { 
		echo do_shortcode('[starmap_init]');  
	}
	
	function remove_gallery_and_product_images() {
	if ( is_product() ) {
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		}
	}
	add_action('loop_start', 'remove_gallery_and_product_images');

 
	
	// the_title( '<h6 class="product_title entry-title">', '</h6>');
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5  );
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',10  );
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt',20  );
	// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30 );
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta',40 );
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing' ,50);
	// remove_action('woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()',60 );
	
	
	function custom_show_product_images( ){
		// $terms = get_terms("pa_pinch-of-style");
		// foreach ( $terms as $term ) {
			// echo "<option>" . $term->name . "</option>";
		// }
		
		// $taxonomy_details = get_terms( array(
			// 'taxonomy' => 'pa_pinch-of-style',
			// 'hide_empty' => false,
			// 'post_parent'   => get_the_ID()
		// ));
		
		// $bgcolor = "#000000";
		// // var_dump($taxonomy_details);
		
		// $args = array(
			// 'post_type'     => 'product_variation',
			// 'post_status'   => array( 'private', 'publish' ),
			// 'numberposts'   => -1,
			// 'orderby'       => 'menu_order',
			// 'order'         => 'asc',
			// 'post_parent'   => get_the_ID() // get parent post-ID
		// );
		// $variations = get_posts( $args );
		// foreach ( $taxonomy_details as $variation ) {
			// var_dump($variation);
			// // get variation ID
			// echo $variation_ID = $variation->ID;

			// $thumbnail_id = get_woocommerce_term_meta( $variation_ID, 'pa_pinch-of-style_swatches_id_photo', true );
			// $textureImg = wp_get_attachment_image_src( $thumbnail_id, 'full' );
			// // var_dump($textureImg);
			// echo $img_src = $textureImg[0];
		
			 

		// }
        include 'content-single-product-custom.php'; 
    } 
	add_action( 'woocommerce_before_single_product_summary', 'custom_show_product_images', 20);
?>