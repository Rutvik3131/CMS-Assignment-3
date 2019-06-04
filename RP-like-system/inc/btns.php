<?php
$btns_position = get_option('rp_button_position', '2');
function rp_like_dislike_buttons($content) {

    // Get display & position settings for buttons
    $btns_position = get_option('rp_button_position', '2');
    $like_btn_hide = get_option('rp_hide_like_button', 'off');
    $dislike_btn_hide = get_option('rp_hide_dislike_button', 'off');
    $stat_position = get_option('rp_stats_position', '1');
    $like_counte = get_option('rp_like_count');
    $dislike_counte = get_option('rp_dislike_count');
    $count_caption = get_option('rp_after_count_caption');

    // Fetch labels for buttons
    $like_btn_label = get_option( 'rp_like_btn_label', 'Like' );
    $dislike_btn_label = get_option( 'rp_dislike_btn_label', 'Dislike' );

    $user_id = get_current_user_id();
    $post_id = get_the_ID();
    $like_count = rp_count_likes($post_id);
    $like_count = number_format($like_count);
    $dislike_count = rp_count_dislikes($post_id);
    $dislike_count  = number_format($dislike_count);

    // Make sure single post is being viewed.
    if(is_single()) {
        
        $btns_wrap_start = '<div class="rp-buttons-container">';
        $like_btn = '<div class="rp-btn-container">';
        $like_btn .= '<a href="javascript:;" onclick="rp_like_btn_ajax('.$post_id.')" class="rp-btn rp-like-btn rp-flat-btn">';

        if($stat_position == 2) {
            $like_btn .= '<span class="rp-btn-icon"><i class="fas fa-thumbs-up"></i> '.$like_count.' </span>';

        } else {
            $like_btn .= '<span class="rp-btn-icon"><i class="fas fa-thumbs-up"></i></span>';
        }
        $like_btn .= '<span class="rp-btn-label">'.$like_btn_label.'</span>';
        $like_btn .= '</a>';
        $like_btn .= '</div>';

        $dislike_btn = '<div class="rp-btn-container">';
        $dislike_btn .= '<a href="javascript:;" onclick="rp_dislike_btn_ajax('.$post_id.')" class="rp-btn rp-dislike-btn rp-flat-btn">';
        
        if($stat_position == 2) {
            $dislike_btn .= '<span class="rp-btn-icon"><i class="fas fa-thumbs-down"></i> '.$dislike_count.' </span>';
        } else {
            $dislike_btn .= '<span class="rp-btn-icon"><i class="fas fa-thumbs-down"></i></span>';
        }
        $dislike_btn .= '<span class="rp-btn-label">'.$dislike_btn_label.'</span>';
        $dislike_btn .= '</a>';
        $dislike_btn .= '</div>';
        $btns_wrap_end = '</div>';

        if($stat_position == 1) {
            $stat_count_string = '<div class="rp-count-stats"><p>'. $like_counte .' <strong>'.$like_count.' </strong> '. $count_caption .' '. $dislike_counte . ' <strong> '. $dislike_count.'</strong> '. $count_caption .' </p></div>';
        }

        $rp_ajax_response = '<div id="rpAjaxResponse" class="rp-ajax-response"><span></span></div>';

        if(isset($btns_position) && $btns_position == 1) {

            $before_content_btns = "";
            $before_content_btns .= $btns_wrap_start;
            if(isset($like_btn_hide) && $like_btn_hide =="on") {
                $like_btn = "" ;
            }
            if(isset($dislike_btn_hide) && $dislike_btn_hide =="on") {
                $dislike_btn == "";
            }
            $before_content_btns .= $like_btn;
            $before_content_btns .= $dislike_btn;
            
            $before_content_btns .= $btns_wrap_end;
            $before_content_btns .= $rp_ajax_response;
            if($stat_position == 1) {
                $before_content_btns .= $stat_count_string;
            }
            $content = $before_content_btns . $content;

        } else {

            $content .= $btns_wrap_start;
            if(isset($like_btn_hide) && $like_btn_hide =="on") {
                $like_btn = "";
            }
            if(isset($dislike_btn_hide) && $dislike_btn_hide =="on") {
                $dislike_btn = "";
            }
            $content .= $like_btn;
            $content .= $dislike_btn;
            $content .= $btns_wrap_end;
            $content .= $rp_ajax_response;
            if($stat_position == 1) {
                $content .= $stat_count_string;
            }

        }
    }
    return $content;

}
function rp_shortcode_position_notice(){
    $notice = "<h3>You need to select CUSTOM location to use this SHORTCODE</h3>";
    return $notice;
}
if($btns_position == 3) {
    add_shortcode( 'rp_LIKE_SYSTEM' , 'rp_like_dislike_buttons' );
} else {
    add_filter('the_content', 'rp_like_dislike_buttons');
    add_shortcode( 'rp_LIKE_SYSTEM' , 'rp_shortcode_position_notice' );
}
