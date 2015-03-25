<?php
/**
 * This file adds the book(library) archive template to the Genesis Author Pro plugin.
 *
 * @author StudioPress
 * @package Genesis Author Pro
 * @subpackage Template
 */


add_action( 'wp_enqueue_scripts', 'genesis_author_pro_load_default_styles' );
add_action( 'genesis_loop', 'genesis_author_pro_setup_archive_loop', 9 );

//* Add author_pro body class to the head
add_filter( 'body_class', 'genesis_author_pro_add_body_class'   );
add_filter('post_class' , 'genesis_author_pro_custom_post_class');

genesis();
