<?php

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {

    $path_stylename_child = get_stylesheet_directory_uri() . '/assets/style-main-child.css' ;
    $ver_stylename_child = date ("zis",filemtime(get_stylesheet_directory() .'/assets/style-main-child.css'));
    wp_enqueue_style( 'website-style-main-child' , $path_stylename_child,array( 'website-stlye-bootstrap-css','website-stlye-main-css' ), $ver_stylename_child , 'all');

    $path_scriptname_child = get_stylesheet_directory_uri() . '/assets/script-main-child.js' ;
    $ver_scriptname_child = date ("zis",filemtime(get_stylesheet_directory() .'/assets/script-main-child.js'));
    wp_enqueue_script( 'website-script-main-child', $path_scriptname_child, array('website-main-js'), $ver_scriptname_child, $infooter = true );

}


function remove_hooks_from_child() {
   remove_all_actions( 'display_inner_banner' );
   remove_action( 'wp_footer', 'add_floating_enquiery', 10 );
   remove_action( 'wp_footer', 'add_floating_chat', 10 );
};

// https://stackoverflow.com/a/50806946
add_action( 'wp', 'remove_hooks_from_child');



include get_theme_file_path( 'inc/functions-child-cpt.php' );
