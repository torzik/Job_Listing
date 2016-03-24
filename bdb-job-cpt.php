<?php


//Registering custom job post_type
function bdb_register_post_type() {
    
    $singular = 'Job Listing';
    $plural = 'Job Listings';
    $labels = array(
        'name' 			=> $plural,
        'singular_name' 	=> $singular,
        'add_new' 		=> 'Add New',
        'add_new_item'  	=> 'Add New ' . $singular,
        'edit'		        => 'Edit',
        'edit_item'	        => 'Edit ' . $singular,
        'new_item'	        => 'New ' . $singular,
        'view' 			=> 'View ' . $singular,
        'view_item' 		=> 'View ' . $singular,
        'search_term'   	=> 'Search ' . $plural,
        'parent' 		=> 'Parent ' . $singular,
        'not_found' 		=> 'No ' . $plural .' found',
        'not_found_in_trash' 	=> 'No ' . $plural .' in Trash'
        );
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_in_nav_menus'   => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-businessman',
        'can_export'          => true,
        'delete_with_user'    => false,
        'hierarchical'        => false,
        'has_archive'         => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        // 'capabilities' => array(),
        'rewrite'             => array( 
            'slug'       => $slug,
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        ),
        'supports'            => array( 
            'title', 
//            'editor', 
//            'author', 
//            'custom-fields' 
        )
    );
    register_post_type( 'job', $args );
}
add_action( 'init', 'bdb_register_post_type' );

function bdb_register_taxonomy() {
    $singular = 'Location';
    $plural = 'Locations';
    $slug = str_replace( ' ', '_', strtolower( $singular ) );
    $labels = array(
        'name' => $plural,
        'singular_name' => $singular,
        'search_items' => 'Search ' . $plural,
        'popular_items' => 'Popular ' . $plural,
        'all_items' => 'All ' . $plural,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Edit ' . $singular,
        'update_item' => 'Update ' . $singular,
        'add_new_item' => 'Add New ' . $singular,
        'new_item_name' => 'New ' . $singular . ' Name',
        'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
        'add_or_remove_items' => 'Add or remove ' . $plural,
        'choose_from_most_used' => 'Choose from the most used ' . $plural,
        'not_found' => 'No ' . $plural . ' found.',
        'menu_name' => $plural,
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => $slug ),
    );
    register_taxonomy( $slug, 'job', $args );    
}
add_action( 'init', 'bdb_register_taxonomy' );
function bdb_load_templates( $original_template ) {

       if ( get_query_var( 'post_type' ) !== 'job' ) {

               return;

       }

       if ( is_archive() || is_search() ) {

               if ( file_exists( get_stylesheet_directory(). '/archive-job.php' ) ) {

                     return get_stylesheet_directory() . '/archive-job.php';

               } else {

                       return plugin_dir_path( __FILE__ ) . 'templates/archive-job.php';

               }

       } elseif(is_singular('job')) {

               if (  file_exists( get_stylesheet_directory(). '/single-job.php' ) ) {

                       return get_stylesheet_directory() . '/single-job.php';

               } else {

                       return plugin_dir_path( __FILE__ ) . 'templates/single-job.php';

               }

       }else{
       	return get_page_template();
       }

        return $original_template;


}
add_action( 'template_include', 'bdb_load_templates' );