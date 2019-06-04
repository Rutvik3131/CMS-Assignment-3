<?php

if( !function_exists('rp_plugin_scripts')) {
    function rp_plugin_scripts() {
        $user_id = get_current_user_id();
        //Plugin Frontend CSS
        wp_enqueue_style('rp-css', RP_PLUGIN_DIR. 'assets/css/front-end.css');

        //FontAwesome CSS
        wp_enqueue_style( 'rp-font-awesome', RP_PLUGIN_DIR. 'assets/font-awesome/css/fontawesome-all.min.css', array(), NULL);

        //Plugin Ajax JS
        wp_enqueue_script('rp-ajax', RP_PLUGIN_DIR. 'assets/js/ajax.js', 'jQuery', '1.0.0', true );

        wp_localize_script( 'rp-ajax', 'rp_ajax_url', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'user_id'  => '1'
        ));
    }
    add_action('wp_enqueue_scripts', 'rp_plugin_scripts');

    function rp_plugin_admin_scripts(){

        //Plugin Back-end CSS
        wp_enqueue_style('rp-css', RP_PLUGIN_DIR. 'assets/css/main.css');
        //Plugin Back-end JS
        wp_enqueue_script('rp-js', RP_PLUGIN_DIR. 'assets/js/main.js', 'jQuery', '1.0.0', true );

    }
    add_action( 'admin_enqueue_scripts', 'rp_plugin_admin_scripts' );
}