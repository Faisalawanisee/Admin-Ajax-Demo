<?php
/*
Plugin Name: Admin Ajax Demo
Plugin URI: faisalawanisee.wordpress.com
Description: Admin Ajax Testing
Version: 1.1
Author: Faisal Awan
Author URI: facebook.com/faisalawanisee
*/

function aad_admin_page(){
	global $add_settings;
	$add_settings = add_options_page(__('Admin Ajax Demo', 'aad'), __('Admin Ajax', 'aad'), 'manage_options', 'admin-ajx-demo', 'add_render_admin');
}

add_action('admin_menu', 'aad_admin_page');

function add_render_admin(){ ?>
	<div class="wrap">
		<h2><?php _e('Admin Ajax Demo', 'aad'); ?></h2>
		<form id="aad-ajax" action="" method="POST" >
			<input type="submit" id="add-submit" name="add-submit" class="button button-primary" value="<?php _e('Get Result', 'aad'); ?>">
			<img src="<?php echo admin_url('/images/spinner.gif'); ?>" style="display:none" id="spinner" alt="Spinner">
		</form>
		<div id="aad_responce"></div>
	</div>
<?php }

function aad_load_script($hook){
	global $add_settings;

	if($hook != $add_settings)
		return;
	wp_enqueue_script( 'add-admin-ajax', plugin_dir_url(__FILE__). 'js/ajax-demo.js', array('jquery'));
	wp_localize_script( 'add-admin-ajax', 'aad_vars', array(
		'aad_nonce' => wp_create_nonce('aad_nonce')
	) );
}
add_action('admin_enqueue_scripts', 'aad_load_script');

function add_process_ajax(){

	if(!isset($_POST['aad_nonce']) || !wp_verify_nonce($_POST['aad_nonce'], 'aad_nonce'))
		die('Permision check failed');

	$posts = get_posts(array('post_type' => 'post', 'posts_per_page' => 225));

	if($posts):
		echo '<ol>';
			foreach ($posts as $post):
				echo '<li>'.get_the_title($post->ID).'</li>';
			endforeach;
		echo '</ol>';
	else :
		echo 'Results not found';
	endif;

	die();

}
add_action('wp_ajax_aad_get_results', 'add_process_ajax');
