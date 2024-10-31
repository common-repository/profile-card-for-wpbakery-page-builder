<?php
/*
Plugin Name: Profile Card for WPBakery Page Builder
Plugin URI: https://themebon.com/item/profile-card-for-wpbakery-page-builder/
Description: Helps you to add beautiful styled profile card in your website. 
Author: themebon
Author URI: http://themebon.com/
License: GPLv2 or later
Text Domain: pcvc
Version: 1.0.0
*/

// Don't load directly
if (!defined('ABSPATH')){die('-1');}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'js_composer/js_composer.php' ) ){
    
    /* Constants */
    define( 'PCVC_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
    define( 'PCVC_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
    if ( ! function_exists( 'profile_card_WordPressCheckup' ) ) {
        function profile_card_WordPressCheckup( $version = '3.8' ) {
            global $wp_version;
            if ( version_compare( $wp_version, $version, '>=' ) ) {
                return "true";
            } else {
                return "false";
            }
        }
    }

    // Admin Style CSS
    function pcvc_admin_enqeue() {
        
        wp_enqueue_style( 'pcvc_admin_css', plugins_url( 'admin/admin.css', __FILE__ ) );
    }
    add_action( 'admin_enqueue_scripts', 'pcvc_admin_enqeue' );


    // Initialize profile card addon
    add_action( 'vc_before_init', 'init_pcvc_addon' );
    function init_pcvc_addon() {
        //google fonts
        require_once 'inc/google-fonts.php';
        
        //params
        require_once 'admin/params/index.php';
        
        //google fonts
        require_once 'inc/google-fonts.php';
            
        //profile card shortcode
        require_once( 'profile-card/profile-card.php' );
         
    }
}

// Check If VC is not activate
else {
    function pcvc_required_plugin() {
        if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'js_composer/js_composer.php' ) ) {
            add_action( 'admin_notices', 'pcvc_required_plugin_notice' );

            deactivate_plugins( plugin_basename( __FILE__ ) ); 

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }

    }
add_action( 'admin_init', 'pcvc_required_plugin' );

    function pcvc_required_plugin_notice(){
        ?><div class="error"><p>Error! you need to install or activate the <a target="_blank" href="https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=themebonwp">WPBakery Page Builder for WordPress (formerly Visual Composer)</a> plugin to run "<span style="font-weight: bold;">Profile Card for WPBakery Page Builder</span>" plugin.</p></div><?php
    }
}
?>