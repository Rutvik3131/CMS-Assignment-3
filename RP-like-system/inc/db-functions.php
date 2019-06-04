<?php
// Count total number of likes for given post ID
function rp_count_likes($pid){

    global $wpdb;

    $table_name = $wpdb->prefix . "rp_like_system";
    $post_id = $pid;

    $like_count = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM `$table_name` WHERE post_id = %d AND like_count=1 ",
        $post_id
    ) );

    return $like_count;
}
// Count total number of dislikes for given post ID
function rp_count_dislikes($pid){
        global $wpdb;

        $table_name = $wpdb->prefix . "rp_like_system";
        $post_id = $pid;

        $dislike_count = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM `$table_name` WHERE post_id = %d AND dislike_count=1 ",
            $post_id
        ) );
    return $dislike_count;
}
// Check if a user has already liked the post
function rp_check_like($pid, $uid) {
    global $wpdb;
    $table_name = $wpdb->prefix . "rp_like_system";
    $user_id = $uid;
    $post_id = $pid;
    $check_like = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM `$table_name` WHERE user_id = %d AND post_id = %d AND like_count=1 ",
        $user_id,
        $post_id
    ) );
    return $check_like;
}
// Check if a user has already disliked the post
function rp_check_deslike($pid, $uid){
    global $wpdb;
    $table_name = $wpdb->prefix . "rp_like_system";
    $user_id = $uid;
    $post_id = $pid;
    $check_dislike = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM `$table_name` WHERE user_id = %d AND post_id = %d AND dislike_count=1 ",
        $user_id,
        $post_id
    ) );
    return $check_dislike;
}

// Add new like to database
function rp_insert_new_like($uid, $pid) {

    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table_name = $wpdb->prefix . "rp_like_system";

    $user_id = wp_strip_all_tags($uid);
    $post_id = wp_strip_all_tags($pid);

    $status = 0;
    $wpdb->insert( 
        ''.$table_name.'', 
        array( 
            'post_id' => $post_id,
            'user_id' => $user_id,
            'like_count' => 1
        ), 
        array( 
            '%d', 
            '%d',
            '%d'
        )
    );
    if($wpdb->insert_id) {
        $status = 1;
        return $status;
    } else {
        $status = 0;
        return $status;
    }
}
// Add new dislike to database
function rp_insert_new_dislike($uid, $pid) {

    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table_name = $wpdb->prefix . "rp_like_system";

    $user_id = wp_strip_all_tags($uid);
    $post_id = wp_strip_all_tags($pid);

    $status = 0;
    $wpdb->insert(
        ''.$table_name.'',
        array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'dislike_count' => 1
            ),
        array(
            '%d',
            '%d',
            '%d'
            )
    );
    if($wpdb->insert_id) {
        $status = 1;
        return $status;
    } else {
        $status = 0;
        return $status;
    }
    
}