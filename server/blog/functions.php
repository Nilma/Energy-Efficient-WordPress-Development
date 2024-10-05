<?php

// Enqueue the theme's styles and Font Awesome
function custom_theme_enqueue_styles() {
    wp_enqueue_style( 'custom-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
    
    // Enqueue Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4' );
}
add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_styles' );

add_action('init', function() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules(); // Be cautious about using this line, as it can be intensive on the server
});


// Theme setup
function custom_theme_setup() {
    // Enable title tag support
    add_theme_support( 'title-tag' );

    // Enable post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Register menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'textdomain' ),
        'footer'  => __( 'Footer Menu', 'textdomain' )  // This line registers the footer menu
    ) );

    // Load theme text domain for translations
    load_theme_textdomain( 'textdomain', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

?>
