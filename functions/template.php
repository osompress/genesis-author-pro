<?php
/**
 * This file contains functions used in the creation of the Genesis Author Pro template files.
 *
 * @author StudioPress
 * @package Genesis Author Pro
 * @subpackage Template
 */

/**
 * Removes action from all provided hooks.
 * This checks to see if the hook has the action
 * then builds a remove_action() with the $hook, $action, and returned $priority value.
 *
 * @access public
 * @param string $action
 * @param array $hooks (default: array())
 * @return void
 */
function genesis_author_pro_remove_actions( $action, $hooks = array() ) {

	foreach ( $hooks as $hook ) {
		if ( $priority = has_action( $hook, $action ) ) {
			remove_action( $hook, $action, $priority );
		}
	}

}

/**
 * Removes action from all entry hooks.
 *
 * @uses genesis_author_pro_remove_actions()
 * @access public
 * @param string $action
 * @return void
 */
function genesis_author_pro_remove_entry_actions( $action ) {

	$hooks = array(
		'genesis_entry_header',
		'genesis_before_entry_content',
		'genesis_entry_content',
		'genesis_after_entry_content',
		'genesis_entry_footer',
		'genesis_after_entry',
	);

	genesis_author_pro_remove_actions( $action, $hooks );

}

/**
 * Loads the default style sheets.
 *
 * @access public
 * @return void
 */
function genesis_author_pro_load_default_styles() {

	if( apply_filters( 'genesis_author_pro_load_default_styles', true ) ) {

		wp_register_style( 'genesis_author_pro',
			GENESIS_AUTHOR_PRO_RESOURCES_URL . 'css/default.css',
			false,
			'1.0.0'
		);
		wp_enqueue_style( 'genesis_author_pro' );

	}

}

/**
 * Remove actions on before entry and setup the author_pro entry actions.
 *
 * @access public
 * @return void
 */
function genesis_author_pro_setup_loop(){

	$hooks = array(
		'genesis_before_entry',
		'genesis_entry_header',
		'genesis_before_entry_content',
		'genesis_entry_content',
		'genesis_after_entry_content',
		'genesis_entry_footer',
		'genesis_after_entry',
	);

	foreach( $hooks as $hook ){
		remove_all_actions( $hook );
	}

	add_action( 'genesis_entry_content'      , 'genesis_author_pro_grid'               );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_open' , 5  );
	add_action( 'genesis_after_entry_content', 'genesis_do_post_title'                 );
	add_action( 'genesis_after_entry_content', 'genesis_author_pro_do_by_line'    , 12 );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_close', 15 );

}

/**
 * Adds the 'genesis-author-pro'body class.
 *
 * @access public
 * @param array $classes
 * @return array
 */
function genesis_author_pro_add_body_class( $classes ) {

	$classes[] = 'genesis-author-pro';
	return $classes;

}

/**
 * Adds the 'genesis-author-pro-book' entry class.
 *
 * @access public
 * @param array $classes
 * @return array
 */
function genesis_author_pro_custom_post_class( $classes ) {

	if (is_main_query()) {
		$classes[] = 'genesis-author-pro-book';
	}

	return $classes;

}

/**
 * Creates the grid output used on book archives.
 *
 * @access public
 * @return void
 */
function genesis_author_pro_grid() {

	if ( $image = genesis_get_image( 'format=url&size=author_pro_archive' ) ) {
		printf( '<div class="author-pro-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

	}

}

/**
 * Outputs the "by" with a link to the Author Archive.
 *
 * @access public
 * @return void
 */
function genesis_author_pro_do_by_line(){

	global $Genesis_Author_Pro_CPT;

	$terms = wp_get_post_terms( get_the_ID(), $Genesis_Author_Pro_CPT->author );

	if( empty( $terms ) || is_wp_error( $terms ) ){
		return;
	}

	$authors = array();

	foreach( $terms as $term ){

		$authors[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $term ) ), $term->name );

	}

	/*
		This uses a couple of joins and array_slices to put the array together with commas and the word "and" without the oxford comma.
		It should make the list of authors work grammatically with 1, 2 or 3+ authors for most Western languages.
		This needs to be cleaned up for correct translation into non western languages.
	*/
	if( ! empty( $authors ) ){
		printf(
			'<div class="book-by-line">%s%s</div>',
			__( 'By ', 'genesis_author-pro' ),
			join(
				__( ' and ', 'genesis-author-pro' ),
				array_filter(
					array_merge(
						array( join( ', ', array_slice( $authors, 0, -1 ) ) ),
						array_slice( $authors, -1 )
					)
				)
			)
		);
	}

}
