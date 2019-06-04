<?php
// Shortcodes for Plugin
function rp_like_count_shortcode($atts) {
    
    extract(shortcode_atts( array(
		'id' => '',
		'string' => ''
    ), $atts ));
    
    if(isset($id) && $id != "" && is_numeric($id)) {
        $post_id = $atts['id'];
    } else {
        $post_id = get_the_ID();
    }
    $count_likes = rp_count_likes($post_id);

    if(isset($string) && $string != "") {
        $return_type = "string";
        $explode_string = explode("%", $atts['string']);
        if(isset($explode_string[0]) && isset($explode_string[1])){
            $string_before = $explode_string[0];
            $string_after = $explode_string[1];
            $count_likes_string = $string_before." ".$count_likes." ".$string_after;
        } else {
            $count_likes_string = "Count string is not formatted correctly, please check plugin documentation.";
        }
        
    } else {
        $return_type = "int";
    }
    
    if($return_type == "string") {
        return $count_likes_string;
    } else {
        return $count_likes;
    }
    
}
add_shortcode( 'RP_LIKE_COUNT' , 'rp_like_count_shortcode' );