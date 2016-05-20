<?php
/**
 * This file contains functions used in the creation of the Genesis Author Pro template files.
 *
 * @author StudioPress
 * @package Genesis Author Pro
 * @subpackage Template
 */

/**
 * Gets the book meta data value from the provided key.
 * If the value is not available it will return false
 *
 * @access public
 * @param string $key
 * @return mixed boolean/string
 */
function genesis_author_pro_get_book_meta( $key, $post_id = '' ){

	$post_id =  $post_id ? $post_id : get_the_ID();

	$genesis_author_pro_book_meta = get_post_meta( $post_id, '_genesis_author_pro', true );

	if( empty( $genesis_author_pro_book_meta[$key] ) ){
		return false;
	}

	return $genesis_author_pro_book_meta[$key];

}

/**
 * Wrapper function to echo genesis_author_pro_get_book_meta().
 * It will return the value if set or returns false if not set.
 *
 * @access public
 * @param string $key
 * @return mixed boolean/string
 */
function genesis_author_pro_book_meta( $key ){

	if( $value = genesis_author_pro_get_book_meta( $key ) ) {

		echo $value;

		return $value;

	}

	return false;

}

/**
 * Removes all the actions on the entry hooks.
 *
 * @access public
 * @return void
 */
function genesis_author_pro_remove_all_entry_actions(){

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
 * Removes all entry actions and setup the author_pro archive entry actions.
 *
 * @access public
 * @return void
 */
function genesis_author_pro_setup_archive_loop(){

	//remove all actions from the entry section to setup the loop
	genesis_author_pro_remove_all_entry_actions();

	add_action( 'genesis_entry_content'      , 'genesis_author_pro_grid'               );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_open' , 5  );
	add_action( 'genesis_after_entry_content', 'genesis_do_post_title'                 );
	add_action( 'genesis_after_entry_content', 'genesis_author_pro_do_by_line'    , 12 );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_close', 15 );

}

/**
 * Removes all entry actions and setup the author_pro archive single actions.
 *
 * @access public
 * @return void
 */
function genesis_author_pro_setup_single_loop(){

	//remove all actions from the entry section to setup the loop
	genesis_author_pro_remove_all_entry_actions();


	add_action( 'genesis_before_entry_content', 'genesis_entry_header_markup_open' , 5  );
	add_action( 'genesis_before_entry_content', 'genesis_do_post_title'                 );
	add_action( 'genesis_before_entry_content', 'genesis_author_pro_do_by_line'    , 12 );
	add_action( 'genesis_before_entry_content', 'genesis_entry_header_markup_close', 15 );
	add_action( 'genesis_entry_content'       , 'genesis_author_pro_single_content'     );
	add_action( 'genesis_entry_content'       , 'genesis_do_post_content_nav'      , 12 );
	add_action( 'genesis_after_entry_content' , 'genesis_author_pro_book_footer'        );

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

	if ( $image = genesis_get_image( 'format=url&size=author-pro-image' ) ) {

		$banner = ( $text = genesis_author_pro_get_book_meta( 'featured_text' ) ) ? sprintf( '<span class="book-featured-text-banner">%s</span>', $text ) : '';

		printf( '<div class="author-pro-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a>%s</div>', get_permalink(), $image, the_title_attribute( 'echo=0' ), $banner );

	}

}

/**
 * Outputs the single content markup.
 *
 * @uses genesis_author_pro_book_details()
 * @access public
 * @return void
 */
function genesis_author_pro_single_content(){

	echo '<div class="one-third genesis-author-pro-book-details">';
	genesis_author_pro_book_details();
	echo '</div>';

	echo '<div class="two-thirds first genesis-author-pro-book-description">';
	the_content();
	echo '</div>';

	echo '<br class="clear" />';

}

/**
 * Builds the book details.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return string
 */
function genesis_author_pro_get_book_details( $post_id = '' ){

	$book_meta = array();

	$book_meta[] = ( $opt = genesis_author_pro_get_formated_meta( __( 'Publisher'   , 'genesis-author-pro' ), 'publisher', $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$book_meta[] = ( $opt = genesis_author_pro_get_formated_meta( __( 'Editor'      , 'genesis-author-pro' ), 'editor'   , $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$book_meta[] = ( $opt = genesis_author_pro_get_formated_meta( __( 'Edition'     , 'genesis-author-pro' ), 'edition'  , $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$book_meta[] = ( $opt = genesis_author_pro_get_formated_meta( __( 'Available in', 'genesis-author-pro' ), 'available', $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$book_meta[] = ( $opt = genesis_author_pro_get_formated_meta( __( 'ISBN'        , 'genesis-author-pro' ), 'isbn'     , $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';

	$book_meta[] = ( $opt = genesis_author_pro_get_publication_date( $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';

	foreach( $book_meta as $key => $value ){
		if( empty( $value ) ){
			unset( $book_meta[$key] );
		}
	}

	$details = '<div class="book-details">';

	$details .= genesis_author_pro_get_book_image( $post_id );

	$details .= genesis_author_pro_get_price( $post_id );

	if( ! empty( $book_meta ) ){

		$details .= sprintf( '<ul class="book-details-meta">%s</ul>', implode( '', $book_meta ) );

	}

	$details .= genesis_author_pro_get_buttons( $post_id );

	$details .= '</div>';

	return $details;

}

/**
 * Wrapper function to echo the book details.
 *
 * @uses genesis_author_pro_get_book_details()
 * @access public
 * @param string $post_id (default: '')
 * @return void
 */
function genesis_author_pro_book_details( $post_id = '' ) {

	echo genesis_author_pro_get_book_details( $post_id );

}

/**
 * Gets the book image if available and
 * wraps the image in standard markup for the book styling.
 * Also includes the featured text banner if set.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return string
 */
function genesis_author_pro_get_book_image(){

	if ( $image = genesis_get_image( array( 'format' => 'url', 'size' => 'author-pro-image' ) ) ) {

		$banner = ( $text = genesis_author_pro_get_book_meta( 'featured_text' ) ) ? sprintf( '<div class="book-featured-text-banner">%s</div>', $text ) : '';

		$image = sprintf( '<div class="author-pro-featured-image"><img src="%s" alt="%s" />%s</div>', $image, the_title_attribute( 'echo=0' ), $banner );

	}

	return $image;
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

		$authors[] = sprintf( '<a class="book-author-link" href="%s">%s</a>', esc_url( get_term_link( $term ) ), $term->name );

	}

	/*
		This uses a couple of joins and array_slices to put the array together with commas and the word "and" without the oxford comma.
		It should make the list of authors work grammatically with 1, 2 or 3+ authors for most Western languages.
		This needs to be cleaned up for correct translation into non western languages.
	*/
	if( ! empty( $authors ) ){
		printf(
			'<p class="book-author">%s%s</p>',
			__( 'By ', 'genesis-author-pro' ),
			join(
				__( ' and ', 'genesis-author-pro' ),
				array_filter(
					array_merge(
						array( join( __( ', ', 'genesis-author-pro' ), array_slice( $authors, 0, -1 ) ) ),
						array_slice( $authors, -1 )
					)
				)
			)
		);
	}

}

/**
 * Outputs the entry <footer> for the book.
 * Includes Series and Tag terms
 *
 * @access public
 * @return void
 */
function genesis_author_pro_book_footer() {

	global $Genesis_Author_Pro_CPT;

	$footer_meta = do_shortcode( apply_filters( 'genesis_author_pro_footer_meta', sprintf(
				'[post_terms taxonomy="%s" before="%s"][post_terms taxonomy="%s" before=" %s"]',
				$Genesis_Author_Pro_CPT->series,
				__( 'Series: ', 'genesis-author-pro'),
				$Genesis_Author_Pro_CPT->tag,
				__( 'Tagged with: ', 'genesis-author-pro' )
			) ) );

	if( $footer_meta ){
		printf( '<footer class="entry-footer"><p class="entry-meta">%s</p></footer>', $footer_meta );
	}

}

/**
 * Formats provided meta data into a standard HTML markup.
 *
 * @access public
 * @param string $label
 * @param string $meta
 * @param string $class
 * @return string
 */
function genesis_author_pro_format_meta( $label, $meta, $class ){

	return sprintf(
		'<span class="genesis-author-pro-meta-detail %s"><span class="label">%s: </span><span class="meta">%s</span></span>',
		$class,
		$label,
		$meta
	);

}

/**
 * Gets the indicated meta and formats it if available.
 * Returns false if meta not set.
 *
 * @uses genesis_author_pro_get_formated_meta()
 * @access public
 * @param string $label
 * @param string $key
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function genesis_author_pro_get_formated_meta( $label, $key, $post_id = '' ){

	$meta  = genesis_author_pro_get_book_meta( $key, $post_id );
	$class = $key;

	return empty( $meta ) ? false : genesis_author_pro_format_meta( $label, $meta, $class );

}

/**
 * Builds the price output from book meta if available.
 * Returns false if meta is not available.
 * Wraps price in a span with class="book-price".
 *
 * @access public
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function genesis_author_pro_get_price( $post_id = '' ){

	$meta  = genesis_author_pro_get_book_meta( 'price', $post_id );

	return empty( $meta ) ? false : sprintf( '<span class="book-price">%s</span>', $meta );

}

/**
 * Builds the publication date from book meta if available.
 * Returns false if no meta available.
 * Checks the publication date against current time stamp and changes label from Available to Published if book has already been published.
 * Formats date using date_i18n() and the date_format option to match the settings for the site.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function genesis_author_pro_get_publication_date( $post_id = '' ){

	$key   = 'publication_date';
	$meta  = genesis_author_pro_get_book_meta( $key, $post_id );
	$class = $key;

	if( empty( $meta ) ){
		return false;
	}

	$label = time() < $meta ? __( 'Available', 'genesis-author-pro' ) : __( 'Published', 'genesis-author-pro' );

	return genesis_author_pro_format_meta( $label, date_i18n( get_option( 'date_format' ), $meta ), $class );

}

/**
 * Builds the buttons if available from the book meta.
 * returns false if no buttons available.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function genesis_author_pro_get_buttons( $post_id = '' ) {

	$buttons = array( 'button_1', 'button_2', 'button_3' );
	$values  = array();

	foreach( $buttons as $button ){

		$uri  = genesis_author_pro_get_book_meta( $button . '_uri' , $post_id );
		$text = genesis_author_pro_get_book_meta( $button . '_text', $post_id );

		if( empty( $uri ) || empty( $text ) ){
			continue;
		}

		$values[] = sprintf( '<a href="%s" class="button button-book" target="_blank">%s</a>', $uri, $text );

	}

	return empty( $values ) ? false : implode( '', $values );

}
