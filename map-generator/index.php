<?php
/**
 * Plugin Name: Star Map Generator
 * Plugin URI: https://www.wondersoftsolutions.com
 * Description: This plugin increase your wordpress post views.
 * Version: 1.0
 * Author: Wondersoft Solutions
 * Author URI: https://www.wondersoftsolutions.com
 */


include 'pages/admin_init.php';
include 'pages/front_shortcode.php';
include 'pages/front_cart.php';

function admin_left_menu(){
	
	$pluginFolder = plugins_url('map-generator',__DIR__);
	
	$page_title = "Star Map - Gen";
	$menu_title = "Star Map - Gen";
	$capability = "";
	$menu_slug = __FILE__;
	$function = 'my_thank_you_text';
	$icon_url = "$pluginFolder/img/icon.png";
	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url);
    
	
	$page_title = "Manage";
	$menu_title = "Manage";
	$capability = "manage_options";
	$menu_slug = __FILE__;
	$function = 'admin_init'; 
   
    add_submenu_page($menu_slug,$page_title, $page_title, 'manage_options', $menu_slug.'/order', $function);
	 
	$page_title = "About";
	$menu_title = "About Us";
	$capability = "manage_options";
	$menu_slug = __FILE__;
	$function = 'admin_about';
 
    add_submenu_page($menu_slug,$page_title, $page_title, 'manage_options', $menu_slug.'/about', $function);
}
add_action('admin_menu','admin_left_menu');

function admin_about ( $content ) {
	include 'pages/admin_about.php'; 
}
function admin_init ( $content ) {
	echo do_shortcode('[admin_starmap_init]');   
}

