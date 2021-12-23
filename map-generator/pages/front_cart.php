<?php 
  
add_filter('woocommerce_cart_item_name','wdm_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('wdm_add_user_custom_option_from_session_into_cart'))
{
	function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {	
        /*code to add custom data on Cart & checkout Page*/    
        if(count($values['wcpa_data']) > 0)
        {
			$return_string = "$product_name</a><dl class='variation'>";
			foreach($values['wcpa_data'] as $item)
			{
				$lbl = $item['label'];
				$value = $item['value'];
				$return_string .= "<dt class='variation-Size'>$lbl:</dt><dd class='variation-Size'><p>$value</p></dd>";
			}
			$return_string .= "</dl>";  
			return $return_string;
        }
        else
        {
            return $product_name;
        }
    }
}
 
// Pending
// Product thumbnail in checkout
add_filter('woocommerce_cart_item_thumbnail','product_thumbnail_in_checkout',1,3);
if(!function_exists('product_thumbnail_in_checkout'))
{
	function product_thumbnail_in_checkout($product_name, $values, $cart_item_key )
	{	
		$variation_id = 0;
		$product_id = 0;
		
		// var_dump(WC()->cart->get_cart());
		foreach( WC()->cart->get_cart() as $cart_item ){
			// echo $variation_id = $cart_item['variation_id'];
			$product_id = $cart_item['product_id'];
			
			 // var_dump($cart_item);
			$products_in_cart[]  = $cart_item['variation']; // possibly array('attribute_pa_color'=>'black')
			 
			 // var_dump($products_in_cart);
			 
			// echo "<pre>";
			// $product_variations = new WC_Product_Variable( $product_id );
			// print_r($product_variations);
			// $product_variations = $product_variations->get_available_variations();
			// print_r($product_variations);
			// echo "</pre>"; 
		}
		 
		// if ( !empty( $variation_id ) ) {
			
			// $_product = new WC_Product_Variation( $variation_id );
			// $variation_data = $_product->get_variation_attributes();
			// $variation_detail = woocommerce_get_formatted_variation( $variation_data, true );
			 
			// var_dump($variation_detail); 
		// }
		// $product = new WC_Product_Variable( $product_id );
		// $variations = $product->get_available_variations();
		// $image = $variations[0]['image']['url'];
		// echo "<pre>";
		// var_dump($image);
		// var_dump($variations[0]);
		// echo "</pre>";
		  
		 
		

		 
		foreach($products_in_cart as $product) {
			// var_dump($product);
			$style = $product['attribute_pa_pinch-of-style'];
			// var_dump($product['attribute_pa_color']); 
			
			$taxonomy_details = get_terms( array(
				'taxonomy' => 'pa_pinch-of-style',
				'slug' => $style,
				'hide_empty' => false,
			));
			 
			$bgcolor = "#000000"; 
			
			$thumbnail_id = get_woocommerce_term_meta( $taxonomy_details[0]->term_id, 'pa_pinch-of-style_swatches_id_photo', true );
			$textureImg = wp_get_attachment_image_src( $thumbnail_id, 'full' );
			// var_dump($textureImg);
			$img_src = $textureImg[0];
			echo "<img style='background-color:$bgcolor;' src='$img_src' />";
		}
		 
        /*code to add custom data on Cart & checkout Page*/    
        if(count($values['wcpa_data']) > 0)
        {
			 

			$img = "<img src='$image' id='img_frame' class='img-responsive'/>";
			$return_string = $img ;
			  
			return $return_string;
        }
        else
        {
            return $product_name;
        }
    }
}
?>