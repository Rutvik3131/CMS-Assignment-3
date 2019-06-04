<?php
/*
* Plugin Name: Like dislike System
* Plugin URI: 
* Author: Rutvik Patel
* Description: Simple Post Like & Dislike System.
* Version: 1.0.0
* License: GPL2
* License URI:  https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: like dislike
*/

//If this file is called directly, abort.
if (!defined( 'WPINC' )) {
    die;
}

//Define Constants
if ( !defined('RP_PLUGIN_VERSION')) {
    define('RP_PLUGIN_VERSION', '1.0.0');
}
if ( !defined('RP_PLUGIN_DIR')) {
    define('RP_PLUGIN_DIR', plugin_dir_url( __FILE__ ));
}
// Create Table for our plugin.
require plugin_dir_path( __FILE__ ). 'inc/db.php';
register_activation_hook( __FILE__, 'rp_likes_table' );

// remove all option setting on deactivation
register_deactivation_hook( __FILE__, function(){
   
    delete_option('rp_like_btn_label');
    delete_option('rp_dislike_btn_label');
    delete_option('rp_button_position');
    delete_option('rp_hide_like_button');
    delete_option('rp_hide_dislike_button');
    delete_option('rp_stats_position');
});

// rp Validation Functions.
require plugin_dir_path( __FILE__ ). 'inc/validate.php';

// Functions to performa database related quries.
require plugin_dir_path( __FILE__ ). 'inc/db-functions.php';

//Include Scripts & Styles
require plugin_dir_path( __FILE__ ). 'inc/scripts.php';

//Settings Menu & Page
require plugin_dir_path( __FILE__ ). 'inc/settings.php';

// Create Like & Dislike Buttons using filter.
require plugin_dir_path( __FILE__ ). 'inc/btns.php';

// rp Shortcodes.
require plugin_dir_path( __FILE__ ). 'inc/shortcodes.php';


//rp Plugin Ajax Function for Like Button
function rp_like_btn_ajax_action() {
    $like_click = get_option('rp_click_btn');
    $like_click_success = get_option('rp_click_like_btn');
    if(isset($_POST['pid']) && isset($_POST['uid']) && rp_check_post_id($_POST['pid']) && rp_check_user($_POST['uid'])) {

        $user_id = intval($_POST['uid']);
        $post_id = intval($_POST['pid']);

        if( !$user_id ) {
            $user_id = '';
        }
        if( !$post_id ) {
            $post_id = '';
        }
        if ( strlen( $user_id ) > 10 ) {
            $user_id = substr( $user_id, 0, 10 );
        }
        if ( strlen( $post_id ) > 10 ) {
            $post_id = substr( $post_id, 0, 10 );
        }

        $check_like = rp_check_like($post_id, $user_id);
        $check_dislike = rp_check_deslike($post_id, $user_id);
        if($check_like > 0 || $check_dislike > 0) {
            _e( $like_click ,"rp-likedisklike");
        }
        else {
            $insert_like = rp_insert_new_like($user_id, $post_id);
            if($insert_like == 1) {
                _e( $like_click_success ,"rp-likedisklike");
            } else {
                _e("There was an error adding your like count, please try again or contact webmaster!","rp-likedisklike");
            }
        }
        
    }
    wp_die();
}
add_action('wp_ajax_rp_like_btn_ajax_action', 'rp_like_btn_ajax_action');
add_action('wp_ajax_nopriv_rp_like_btn_ajax_action', 'rp_like_btn_ajax_action');
    
//rp Plugin Ajax Function for DisLike Button
function rp_dislike_btn_ajax_action() {
    $like_click = get_option('rp_click_btn');
    $dislike_click_success = get_option('rp_click_dislike_btn');
    if(isset($_POST['pid']) && isset($_POST['uid']) && rp_check_user($_POST['uid']) && rp_check_post_id($_POST['pid'])) {
        
        $user_id = wp_strip_all_tags($_POST['uid']);
        $post_id = wp_strip_all_tags($_POST['pid']);
        
        $check_like = rp_check_like($post_id, $user_id);
        $check_dislike = rp_check_deslike($post_id, $user_id);
        
        if($check_dislike > 0 || $check_like > 0) {
            _e( $like_click ,"rp-likedisklike");
        }
        else {
            $insert_like = rp_insert_new_dislike($user_id, $post_id);
            if($insert_like == 1) {
                _e($dislike_click_success ,"rp-likedisklike");
            } else {
                _e("There was an error adding your dislike count, please try again or contact webmaster!","rp-likedisklike");
            }
        }
        
    }
    wp_die();
}
add_action('wp_ajax_rp_dislike_btn_ajax_action', 'rp_dislike_btn_ajax_action');
add_action('wp_ajax_nopriv_rp_dislike_btn_ajax_action', 'rp_dislike_btn_ajax_action');

?>
