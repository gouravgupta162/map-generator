<?php 
function order_meta_customized_display($item_id, $item, $product){
	
	$all_meta_data=get_metadata( 'order_item', $item_id, "", "");

	$useless = array(
	 "_qty","_tax_class","_variation_id","_product_id","_line_subtotal","_line_total","_line_subtotal_tax","_WCPA_order_meta_data","_line_tax","_line_tax_data"
	);// Add key values that you want to ignore
	$return = "";
	$customized_array = array();
	foreach($all_meta_data as $data_meta_key => $value)
	{
		if(!in_array($data_meta_key,$useless)){
			$data_meta_key = ltrim(trim($data_meta_key),'_');
			$newKey = ucwords(str_replace('_',"-",$data_meta_key ));//To remove underscrore and capitalize
			$customized_array[$newKey]=ucwords(str_replace('_'," ",$value[0])); // Pushing each value to the new array
		}
	}
	if (!empty($customized_array))
	{
		echo "<form></form>";
		$url = admin_url('admin.php?page=map-generator/index.php/order');
		$html = "<form target='_blank' id='form_$item_id' action='$url' method='POST'>";
		foreach($customized_array as $data_meta_key => $value)
		{	
			$html .= '<input type="hidden" name="' . __( $data_meta_key ) . '" value="'.$value.'" />';
		}
		$html .= "<input type='hidden' name='action' value='generate_canvas'/><input type='submit' value='Generate' class='button' style='padding:2px 10px;background-color:green;color:white;' /></form>";
		echo $html;
	}
} 
add_action( 'woocommerce_after_order_itemmeta', 'order_meta_customized_display', 10, 3 );


 
add_shortcode( 'admin_starmap_init', 'getAdminCanvasPreview'  );

// add_action('init', 'getAdminCanvasPreview');
function getAdminCanvasPreview(){
	// var_dump($_POST);
	
	if($_POST["action"] == 'generate_canvas')
	{
		$dir = plugins_url('map-generator/');
		//a3 	- 3605 x 4961
		//a4 	- 2480 x 3508
		//24*36 - 2304 x 3456
		
		// unset($_POST['action']);
		// echo "<table border='1'>";
		// echo "<tr>";
		// echo "<th>Label</th><th>Values</th>";
		// echo "</tr>";
		// foreach($_POST as $key=>$val)
		// {
			// echo "<tr>";
			// echo "<td>$key</td><td>$val</td>";
			// echo "</tr>";
		// }
		// echo "</table>"; 
		 
		 
		 
		 
		$size = $_POST['Pa-size'];
		$color = $_POST['Pa-color'];
		$style = $_POST['Pa-pinch-of-style'];
		$Date_Of_Birth = $_POST['Date_Of_Birth'];
		$Time = $_POST['Time'];
		$Location = $_POST['Location'];
		$Latitude = $_POST['Latitude'];
		$Longitude = $_POST['Longitude'];  
		$message1 = $_POST['Give_A_Title'];
		$message2 = $_POST['Give_A_Foot_Note_Or_Leave_It_Blank'];
		
		$date=date_create("$Date_Of_Birth $Time");// at 8:26 AM
		

		$Latitude_short = number_format((float)$Latitude, 2, '.', '');
		$Longitude_short = number_format((float)$Longitude, 2, '.', '');
		
		$taxonomy_details = get_terms( array(
			'taxonomy' => 'pa_pinch-of-style',
			'slug' => $_POST['Pa-pinch-of-style'],
			'hide_empty' => false,
		));
		
		$bgcolor = "#000000";
		// var_dump($taxonomy_details);
		 
		
		$thumbnail_id = get_woocommerce_term_meta( $taxonomy_details[0]->term_id, 'pa_pinch-of-style_swatches_id_photo', true );
		$textureImg = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		// var_dump($textureImg);
		$img_src = $textureImg[0];
		// $img_src = "http://localhost/wordpress/starmap/wp-content/uploads/2021/a/Blue-bird_a4.png";
		// $img_src = "http://localhost/wordpress/starmap/wp-content/uploads/2021/a/Blue-bird_a3.png";
		// echo "<img  src='$img_src' style='z-index:99999' />";
		
		?>
		
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		
		
		<div id="order_preview" class="col-md-6"  >
		
		<style>
			body ,*
			{
				margin: 0px;
			}
			.preview_text{
				margin-top: -225px;
				color: #ffffff;
				position: relative;
				z-index: 99999;
			}
			 
			.page {
				width: 210mm;
				min-height: 297mm; 
			}

			.subpage {
			  padding: 0px; 
			  height: 297mm;
			 
			}

			@page {
				size: A4;
				margin: 0;
			}
			.preview{
				position:absolute !important;
				 
				margin:145px 102px;
			}
			#img_frame{
					width: 100%;
					z-index: 999;
					position: relative;
				}
			@media print { 
				 
				.page {
					margin: 0;
					border: initial;
					border-radius: initial;
					width: initial;
					min-height: initial;
					box-shadow: initial;
					background: initial;
					page-break-after: always;
				  }
				
			}


		</style> 
			<div class="book">
			  <div class="page">
				<div id="subpage" class="subpage"> 
					<div class="backimg" id="img_frame_bg"   >
						<div id="preview" class="preview" style="background-color:black;  margin:142px 101px" >
						</div> 
						<img src="<?php echo $img_src; ?>" id="img_frame"  >
					</div>
					<div class="preview_text" style="color:<?php echo $color ?>">
						<div class="header-starts">
							<center><p id="show_title"><?php echo $message1; ?></p></center>
						</div>
						<div class="footer-starts">
							<center><p id="footer_text"><?php echo $message2; ?></p></center>
							<center><p id="footer_second_text">&nbsp;</p></center>
							<div class="footer-last"><center><p id="footer_third">STAR OVER <br> <?php echo $Location; ?> | <?php echo $Latitude_short; ?> , <?php echo $Longitude_short; ?></p></center>
							<center><p id="footer_forth">ON, <?php echo date_format($date,"d-M-Y"); ?> at <?php echo date_format($date,"h:i A"); ?></p></center>
							</div>
						</div> 
					</div>
				</div>
			  </div> 
			</div>
		</div>
		<input type="button" onclick="printDiv('order_preview')" value="Print A4" class="col-md-2 " />
		<?php
		// wp_enqueue_script('jquery-min', "$dir/js/jquery-1.10.0.min.js" ); 
		wp_enqueue_script('jquery-maps-api','https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyC_ndCYk7BpsdhKCNEw8K4I0BqjGmW4lGI&sensor=false&libraries=places');
		wp_enqueue_script('moment-min', "$dir/js/moment.min.js" );  
		wp_enqueue_script('virtualsky', "$dir/js/virtualsky.js" );
		wp_enqueue_script('jquery-geocomplete', "$dir/js/jquery.geocomplete.js" );
		wp_enqueue_script('bootstrap-datetimepicker', "$dir/js/bootstrap-datetimepicker.min.js" );
		 
		wp_enqueue_style('bootstrap-datetimepicker', "$dir/css/bootstrap-datetimepicker.min.css" );
		wp_enqueue_style('bootstrap', "$dir/css/bootstrap.css");
		wp_enqueue_script('print 1.0.59', "$dir/js/print.js");
		
		
		?> 
		<script> 
		
		
			function printDiv(divName) {
				printJS(divName, 'html');
			}
			
		  jQuery(document).ready(function(){
			directory = '<?php echo $dir; ?>';
			datepicker = '<?php echo $Date_Of_Birth; ?>';
			timepicker = '<?php echo $Time; ?>'; 
			Latitude = '<?php echo $Latitude; ?>'; 
			Longitude = '<?php echo $Longitude; ?>'; 
			
			date = new Date(datepicker + " " + timepicker ) ;
			// console.log(datepicker + " " + timepicker);
			jsonarray = {
				"id":"preview",
				"dir" : directory,
				"mouse":false,
				"projection" :'polar',
				"width":587,
				"height":587,
				"gradient":true,
				"showgalaxy":false,
				"constellations":true,
				"constellationlabels":true,
				"constellationboundaries":false,
				"showdate":false,
				"showposition":false,
				"showstars":true,
				"meteorshowers":false,
				"showstarlabels":false,
				"negative":false,
				"transparent":true,
				/*"background":"#ffffff",*/
				"color":"#000000",
				"credit": false,
				"showplanets": false,
				"showplanetlabels": false,
				fontsize:"10px",
				fontfamily :"verdana",
				longitude: Longitude,
				latitude: Latitude,
				clock: date 
			};			
			planetarium = jQuery.virtualsky(jsonarray);
			planetarium.draw(); 
		   });
		</script>
		<?php
	}
}

?>