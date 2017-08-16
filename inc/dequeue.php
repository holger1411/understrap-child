<?php
/**
 * Understrap Child dequeue scripts
 *
 * @package understrap
 */

if ( ! function_exists( 'understrap_remove_scripts' ) ) {
	/**
	 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
	 */
	function understrap_remove_scripts() {
	    wp_dequeue_style( 'understrap-styles' );
	    wp_deregister_style( 'understrap-styles' );

	    wp_dequeue_script( 'understrap-scripts' );
	    wp_deregister_script( 'understrap-scripts' );
	}
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
