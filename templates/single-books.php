<?php
/**
 * This file adds the custom author_pro post type single post template to the Executive Pro Theme.
 *
 * @author StudioPress
 * @package Executive Pro
 * @subpackage Template
 */

add_action( 'wp_enqueue_scripts', 'genesis_author_pro_load_default_styles' );
add_action( 'genesis_loop', 'genesis_author_pro_setup_single_loop', 9 );

//* Add author_pro body class to the head
add_filter( 'body_class', 'genesis_author_pro_add_body_class'   );
add_filter('post_class' , 'genesis_author_pro_custom_post_class');

genesis();
