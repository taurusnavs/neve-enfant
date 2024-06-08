<?php
/**
**  activation theme
**/

// enqueue styles for child theme
function neveenfant_enqueue_styles() {
	
	// enqueue parent styles
	wp_enqueue_style('parent-theme', get_template_directory_uri() .'/style.css');
	
	// enqueue child styles
	wp_enqueue_style('child-theme', get_stylesheet_directory_uri() .'/style.css', array('parent-theme'));

	// enqueue child script
	wp_enqueue_script( 'child-theme', get_stylesheet_directory_uri() . '/custom.js', array(), null, true );
	
}
add_action('wp_enqueue_scripts', 'neveenfant_enqueue_styles');

//Remove Version number
remove_action('wp_head', 'wp_generator');

function logika_remove_version() {
return '';
}
add_filter('the_generator', 'logika_remove_version');

//Add cookies
add_action('wp_head', 'add_cookie_header');
function add_cookie_header(){
    ?>
    <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/8aaec182c3a3064396ca9a4d/script.js"></script>
    <?php
}

//logout
add_filter('logout_url', 'logika_logout_page', 10, 2);
function logika_logout_page($logout_url){
	return home_url('/super-logika.php');
}

//Lost password
add_filter('lostpassword_url', 'logika_lostpassword_page', 10, 2);
function logika_lostpassword_page($lostpassword_url){
	return home_url('/super-logika.php?action=lostpassword');
}

//Automatically clear cache w3total
function flush_w3tc_cache(){
	$w3_plupin_totalcache->flush_all();
}

//Schedule cleaning
function flush_cache_event(){
	if(!wp_next_scheduled('flush_cach_event')){
		wp_schedule_event(current_time('timestamp'), 'daily', 'flush_w3tc_cache');
	}
}
add_action('wp', 'flush_cache_event');

//Hide plugins
/*
add_filter('all_plugins', '__return_empty_array');
*/

//Disable autosave
add_action( 'admin_init', 'disable_autosave' );
function disable_autosave() {
wp_deregister_script( 'autosave' );
}