<?php

/*
Plugin Name: Job Listing
Version: 1.0.0
Author: Konstantin
Description: job listing
*/

//Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

require_once ( plugin_dir_path(__FILE__) . 'bdb-job-cpt.php' );
require_once ( plugin_dir_path(__FILE__) . 'bdb-job-settings.php' );
require_once ( plugin_dir_path(__FILE__) . 'bdb-job-fields.php' );
require_once ( plugin_dir_path(__FILE__) . 'bdb-job-shortcode.php' );

/**
 * Enqueueing scripts
 */
function bdb_admin_enqueue_scripts()
{
    //These varibales allow us to target the post type and the post edit screen.
    global $pagenow, $typenow;
    //Plugin Main CSS File.
    if ( $typenow == 'job') {
        
        wp_enqueue_style( 'bdb-admin-css', plugins_url( 'css/admin-jobs.css', __FILE__ ) );      

    }
    if ( ($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'job' ) {
       
        //Plugin Main js File.
        wp_enqueue_script( 'bdb-job-js', plugins_url( 'js/admin-jobs.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), '20150204', true );
        //Quicktags js file.
        wp_enqueue_script( 'bdb-custom-quicktags', plugins_url( 'js/bdb-quicktags.js', __FILE__ ), array( 'quicktags' ), '20150206' );
        //Datepicker Styles
        wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
    }
    if ( $pagenow =='edit.php' && $typenow == 'job') {

        wp_enqueue_script( 'reorder-js', plugins_url( 'js/reorder.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), '20150626' );
        wp_localize_script( 'reorder-js', 'BDB_JOB_LISTING', array(
            'security' => wp_create_nonce( 'bdb-job-order' ),
            'success' => __( 'Jobs sort order has been saved.' ),
            'failure' => __( 'There was an error saving the sort order, or you do not have proper permissions.' )
        ) );

    }
}
//This hook ensures our scripts and styles are only loaded in the admin.
add_action( 'admin_enqueue_scripts', 'bdb_admin_enqueue_scripts' );
