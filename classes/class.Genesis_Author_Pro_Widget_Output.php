<?php

/**
 * Genesis_Author_Pro_Widget class.
 * Generates the Genesis Author Pro Featured Book Widget.
 */
class Genesis_Author_Pro_Widget_Output {
	
	private $_args;
	
	private $_instance;
	
	private $_widget_object;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct( $args, $instance, $widget_object ) {
		
		$this->_args          = $args;
		$this->_instance      = $instance;
		$this->_widget_object = $widget_object;
		
		require_once( GENESIS_AUTHOR_PRO_FUNCTIONS_DIR . 'template.php' );

		$this->widget_output();
		
	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query Query object.
	 * @global integer  $more
	 */
	function widget_output() {

		global $wp_query, $Genesis_Author_Pro_CPT;

		echo $this->_args['before_widget'];

		//* Set up the author bio
		if ( ! empty( $this->_instance['title'] ) )
			echo $this->_args['before_title'] . apply_filters( 'widget_title', $this->_instance['title'], $this->_instance, $this->_widget_object->id_base ) . $this->_args['after_title'];

		$wp_query = new WP_Query( array( 'post__in' => array( $this->_instance['book_id'] ), 'post_type' => $Genesis_Author_Pro_CPT->post_type ) );

		if ( have_posts() ) : while ( have_posts() ) : the_post();

			genesis_markup( array(
				'html5'   => '<article %s>',
				'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
				'context' => 'entry',
			) );

			$image = genesis_get_image( array(
				'format'  => 'html',
				'size'    => $this->_instance['image_size'],
				'context' => 'featured-page-widget',
				'attr'    => genesis_parse_attr( 'entry-image-widget' ),
			) );

			if ( $this->_instance['show_image'] && $image ) {
				
				$banner = ( $text = genesis_author_pro_get_book_meta( 'featured_text' ) ) ? sprintf( '<span class="book-featured-text-banner">%s</span>', $text ) : '';
				
				printf( '<div class="author-pro-featured-image %s"><a href="%s" title="%s">%s</a>%s</div>', esc_attr( $this->_instance['image_alignment'] ), get_permalink(), the_title_attribute( 'echo=0' ), $image, $banner );
				
			}

			if ( ! empty( $this->_instance['show_title'] ) ) {

				$title = get_the_title() ? get_the_title() : __( '(no title)', 'genesis' );

				/**
				 * Filter the featured book title.
				 *
				 *
				 * @param string $title    Featured book title.
				 * @param array  $this->_instance {
				 *     Widget settings for this instance.
				 *
				 *     @type string $title           Widget title.
				 *     @type int    $book_id         ID of the featured page.
				 *     @type bool   $show_image      True if featured image should be shown, false
				 *                                   otherwise.
				 *     @type string $image_alignment Image alignment: alignnone, alignleft,
				 *                                   aligncenter or alignright.
				 *     @type string $image_size      Name of the image size.
				 *     @type bool   $show_title      True if featured page title should be shown,
				 *                                   false otherwise.
				 *     @type bool   $show_content    True if featured page content should be shown,
				 *                                   false otherwise.
				 *     @type int    $content_limit   Amount of content to show, in characters.
				 *     @type int    $more_text       Text to use for More link.
				 * }
				 * @param array  $this->_args     {
				 *     Widget display arguments.
				 *
				 *     @type string $before_widget Markup or content to display before the widget.
				 *     @type string $before_title  Markup or content to display before the widget title.
				 *     @type string $after_title   Markup or content to display after the widget title.
				 *     @type string $after_widget  Markup or content to display after the widget.
				 * }
				 */
				$title = apply_filters( 'genesis_author_pro_featured_book_title', $title, $this->_instance, $this->_args );

				if ( genesis_html5() )
					printf( '<header class="entry-header"><h2 class="entry-title"><a href="%s">%s</a></h2></header>', get_permalink(), $title );
				else
					printf( '<h2><a href="%s">%s</a></h2>', get_permalink(), $title );

			}

			if ( ! empty( $this->_instance['show_content'] ) ) {

				echo genesis_html5() ? '<div class="entry-content">' : '';

				if ( empty( $this->_instance['content_limit'] ) ) {

					global $more;

					$orig_more = $more;
					$more = 0;

					the_content( $this->_instance['more_text'] );

					$more = $orig_more;

				} else {
					the_content_limit( (int) $this->_instance['content_limit'], esc_html( $this->_instance['more_text'] ) );
				}

				echo genesis_html5() ? '</div>' : '';

			}

			genesis_markup( array(
				'html5' => '</article>',
				'xhtml' => '</div>',
			) );

			endwhile;
		endif;

		//* Restore original query
		wp_reset_query();

		echo $this->_args['after_widget'];

	}

}
