<?php

// set debug version
if (true == WP_DEBUG) {
	$date = new DateTime();
	define('THEME_VERSION_NUM', $date->getTimestamp() );
} else {
	define('THEME_VERSION_NUM', wp_get_theme()->get( 'Version' ));
}



function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );

	// Removes the parent themes stylesheet and scripts from inc/enqueue.php
}

add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

function theme_enqueue_styles() {

	// if debug load non-min css
	if (true == WP_DEBUG) {
		wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.css', array(), $ver_num);
		wp_enqueue_script( 'child-scripts', get_stylesheet_directory_uri() . '/js/child-theme.js', array(), $ver_num, true );
	} else {
		wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $ver_num);
		wp_enqueue_script( 'child-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $ver_num, true );
	}

	wp_enqueue_script( 'child-scripts', get_stylesheet_directory_uri() . '/js/theme.js', array(), $ver_num, true );


}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );