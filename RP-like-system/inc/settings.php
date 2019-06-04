<?php
function rp_settings_page_html() {
    //Check if current user have admin access.
    if(!is_admin()) {
        return;
    }
    ?>
        <div class="wrap">
            <h1 class="rp-plugin-settings-head"><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post" class="rp-setting-form">
                <?php 
                    // output security fields for the registered setting "wpac-settings"
                    settings_fields( 'rp-settings' );

                    // output setting sections and their fields
                    // (sections are registered for "wpac-settings", each field is registered to a specific section)
                    do_settings_sections( 'rp-settings' );

                    // output save settings button
                    submit_button( 'Save Changes' );
                ?>
            </form>
        </div>
    <?php

}

//Top Level Administration Menu
function rp_register_menu_page() {
    add_menu_page(
        'RP Like System',
        'RP Settings',
        'manage_options',
        'rp-settings',
        'rp_settings_page_html',
        'dashicons-thumbs-up', 30 );
}
add_action('admin_menu', 'rp_register_menu_page');


// Register settings, sections & fields.
function rp_plugin_settings(){

    // register settings for "wpac-settings" page
    register_setting( 'rp-settings', 'rp_like_btn_label' ,['default' => 'Like']);
    register_setting( 'rp-settings', 'rp_dislike_btn_label' ,['default' => 'Dislike']);
    register_setting( 'rp-settings', 'rp_button_position' ,['default' => '2']);
    register_setting( 'rp-settings', 'rp_hide_like_button' ,['default' => 'off']);
    register_setting( 'rp-settings', 'rp_hide_dislike_button' ,['default' => 'off']);
    register_setting( 'rp-settings', 'rp_stats_position' ,['default' => '1']);
    register_setting( 'rp-settings', 'rp_like_count' ,['default' => 'This post has been Liked ']);
    register_setting( 'rp-settings', 'rp_dislike_count' ,['default' => '& Disliked ']);
    register_setting( 'rp-settings', 'rp_after_count_caption' ,['default' => 'time(s) ']);
    register_setting( 'rp-settings', 'rp_click_btn' ,['default' => 'Sorry, you already liked/disliked this post or you are not logged-in']);
    register_setting( 'rp-settings', 'rp_click_like_btn' ,['default' => 'Thank you for likig this post']);
    register_setting( 'rp-settings', 'rp_click_dislike_btn' ,['default' => 'Post has been disliked successfully!']);

    // register a new section in the "rp-setings" page
    add_settings_section(
        'rp_label_settings_section',
        'rp Button Labels',
        'rp_label_settings_section_cb',
        'rp-settings'
    );
    add_settings_section(
        'rp_button_settings_section',
        'rp Button Settings',
        'rp_button_settings_section_cb',
        'rp-settings'
    );
    add_settings_section(
        'rp_message_settings_section',
        'rp Messages Customize',
        'rp_message_settings_section_cb',
        'rp-settings'
    );

    // register fields for settings in "rp-settings" page

    // Button Label Fields
    add_settings_field(
        'rp_like_label_field',
        'Like Button Label',
        'rp_like_label_field_cb',
        'rp-settings',
        'rp_label_settings_section'
    );
    add_settings_field(
        'rp_dislike_label_field',
        'Dislike Button Label',
        'rp_dislike_label_field_cb',
        'rp-settings',
        'rp_label_settings_section'
    );

    // Button Display & Position Fields
    add_settings_field( 
        'rp_button_position',
        'Buttons Positions',
        'rp_button_position_cb',
        'rp-settings',
        'rp_button_settings_section' 
    );
    add_settings_field( 
        'rp_hide_like_button',
        'Hide Like Button?',
        'rp_hide_like_button_cb',
        'rp-settings',
        'rp_button_settings_section' 
    );
    add_settings_field( 
        'rp_hide_dislike_button',
        'Hide DisLike Button?',
        'rp_hide_dislike_button_cb',
        'rp-settings',
        'rp_button_settings_section'
    );
    add_settings_field( 
        'rp_stats_position',
        'Like & Dislike Count Position',
        'rp_stats_position_cb',
        'rp-settings',
        'rp_button_settings_section' 
    );

    //meassge customize 
    add_settings_field(
        'rp_like_count_label_field',
        'Meassage befor Like Count',
        'rp_message_like_count_section_cb',
        'rp-settings',
        'rp_message_settings_section'
    );
    add_settings_field(
        'rp_dislike_count_label_field',
        'Message Before Dislike Count',
        'rp_message_dislike_count_section_cb',
        'rp-settings',
        'rp_message_settings_section'
    );
    add_settings_field(
        'rp_after_count_label_field',
        'After Count Caption',
        'rp_message_after_count_section_cb',
        'rp-settings',
        'rp_message_settings_section'
    );
    add_settings_field(
        'rp_after_click_btn',
        'Message if User Already Like/Disklike',
        'rp_message_click_btn_cb',
        'rp-settings',
        'rp_message_settings_section'
    );
    add_settings_field(
        'rp_after_click_like_btn',
        'Like Succes message',
        'rp_message_click_like_btn_cb',
        'rp-settings',
        'rp_message_settings_section'
    );
    add_settings_field(
        'rp_after_click_dislike_btn',
        'Disklike Succes message',
        'rp_message_click__dislike_btn_cb',
        'rp-settings',
        'rp_message_settings_section'
    );
}
add_action('admin_init', 'rp_plugin_settings');

// Section callback functions
function rp_label_settings_section_cb(){
    _e('<p>Define Button Labels</p>', 'rplike');
}
function rp_button_settings_section_cb(){
    _e('<p>Button position and display settings</p>', 'rplike');
}
// Field callback functions
// Button Label Fields Callback Functions
function rp_like_label_field_cb(){ 
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('rp_like_btn_label');
    // output the field
    ?>
    <input type="text" name="rp_like_btn_label" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}

function rp_dislike_label_field_cb(){ 
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('rp_dislike_btn_label');
    // output the field
    ?>
    <input type="text" name="rp_dislike_btn_label" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}

// Button Display Setting Fields Functions
function rp_button_position_cb(){ 
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('rp_button_position');
    $check_position = "";
    $position_label = "";
    $position_style = "";
    if(isset($setting) & $setting == 1) {
        $position_value = 1;
        $position_label = "Before Content";

    } elseif(isset($setting) & $setting == 2){
        $position_value = 2;
        $position_label = "After Content";
    } elseif(isset($setting) & $setting == 3){
        $position_value = 3;
        $position_label = "Custom";
        $position_style = ' style="display: block"';
    } else {
        $position_value = "";
        $position_label = "";
    }
    // output the field
    ?>
    <select name="rp_button_position" id="btnPosition" onchange="rp_btn_position_select()">
        <?php if(isset($position_value) && $position_value != "") { ?>
        <option value="<?php echo $position_value ?>"><?php echo $position_label ?></option>
        <?php } ?>
        <option value="1">Before Content</option>
        <option value="2">After Content</option>
        <option value="3">Custom</option>
    </select>
    <pre class="rp-short-code-notice"<?php echo $position_style ?>>Use this shortcode to display on custom location <strong>[RP_LIKE_SYSTEM]</strong></pre>
    <?php
}
// Button Display Setting Fields Functions
function rp_stats_position_cb(){ 
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('rp_stats_position');
    $position_value = "";
    $position_label = "";
    if(isset($setting) & $setting == 1) {

        $position_value = 1;
        $position_label = "Below The Buttons";

    } elseif(isset($setting) & $setting == 2){

        $position_value = 2;
        $position_label = "Inside The Buttons";

    } else{

        $position_value = 3;
        $position_label = "Hide Stats";

    } 
    // output the field
    ?>
    <select name="rp_stats_position" id="btnPosition" onchange="rp_btn_position_select()">
        <?php if(isset($position_value) && $position_value != "") { ?>
        <option value="<?php echo $position_value ?>"><?php echo $position_label ?></option>
        <?php } ?>
        <option value="1">Below The Buttons</option>
        <option value="2">Inside The Buttons</option>
        <option value="3">Hide Stats</option>
    </select>
    <?php
}
function rp_hide_like_button_cb(){ 
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('rp_hide_like_button');
    $check_status = "";
    if(isset($setting) & $setting == "on") {
        $check_status = "checked";
    }
    // output the field
    ?>
    <input type="checkbox" name="rp_hide_like_button" <?php echo ( $check_status )?>>
    <?php
}
function rp_hide_dislike_button_cb(){ 
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('rp_hide_dislike_button');
    $check_status = "";
    if(isset($setting) & $setting == "on") {
        $check_status = "checked";
    }
    // output the field
    ?>
    <input type="checkbox" name="rp_hide_dislike_button" <?php echo ( $check_status )?>>
    <?php
}
function rp_message_settings_section_cb(){
    _e('<p>Custom your font end messages / notice</p>', 'rplike');
}
function rp_message_like_count_section_cb(){
     // get the value of the setting we've registered with register_setting()
     $setting = get_option('rp_like_count');
     // output the field
     ?>
     <input type="text" name="rp_like_count" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
     <?php
}
function rp_message_dislike_count_section_cb(){
     // get the value of the setting we've registered with register_setting()
     $setting = get_option('rp_dislike_count');
     // output the field
     ?>
     <input type="text" name="rp_dislike_count" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
     <?php
}
function rp_message_after_count_section_cb(){
     // get the value of the setting we've registered with register_setting()
     $setting = get_option('rp_after_count_caption');
     // output the field
     ?>
     <input type="text" name="rp_after_count_caption" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
     <?php
}
function rp_message_click_btn_cb(){
     // get the value of the setting we've registered with register_setting()
     $setting = get_option('rp_click_btn');
     // output the field
     ?>
     <input type="text" name="rp_click_btn" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
     <?php
}
function rp_message_click_like_btn_cb(){
     // get the value of the setting we've registered with register_setting()
     $setting = get_option('rp_click_like_btn');
     // output the field
     ?>
     <input type="text" name="rp_click_like_btn" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
     <?php
}
function rp_message_click__dislike_btn_cb(){
     // get the value of the setting we've registered with register_setting()
     $setting = get_option('rp_click_dislike_btn');
     // output the field
     ?>
     <input type="text" name="rp_click_dislike_btn" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
     <?php
}