<?php

/**
 * Genesis_Author_Pro_Widget class.
 * Generates the Genesis Author Pro Featured Book Widget.
 */
class Genesis_Author_Pro_Widget extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct() {

		$this->defaults = array(
			'title'              => '',
			'show_author'        => '',
			'book_id'            => '',
			'show_image'         => 0,
			'image_alignment'    => '',
			'image_size'         => 'author-pro-image',
			'show_featured_text' => '',
			'show_title'         => 0,
			'show_content'       => 0,
			'content_limit'      => '',
			'show_price'         => '',
			'more_text'          => __( 'View Book', 'genesis-author-pro' ),
		);

		$widget_ops = array(
			'classname'   => 'featured-content featuredpage featuredbook',
			'description' => __( 'Displays a single book with several customizable display options.', 'genesis-author-pro' ),
		);

		$control_ops = array(
			'id_base' => 'featured-book',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct( 'featured-book', __( 'Genesis Author Pro - Featured Book', 'genesis-author-pro' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts') );

	}
	
	/**
	 * Action added on the wp_enqueue_scripts hook.
	 * Loads the author stylesheet if the widget is active and the default styles are not being overridden.
	 * 
	 * @access public
	 * @return void
	 */
	function enqueue_scripts(){
	
		if( apply_filters( 'genesis_author_pro_load_default_styles', true ) && is_active_widget( false, false, $this->id_base, true ) ) {
			
			wp_enqueue_style( 'genesis_author_pro',
				GENESIS_AUTHOR_PRO_RESOURCES_URL . 'css/default.css',
				false,
				'1.0.0'
			);
			
		}           
	
	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query Query object.
	 * @global integer  $more
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		new Genesis_Author_Pro_Widget_Output( $args, $instance, $this );

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		new Genesis_Author_Pro_Widget_Admin( $instance, $this );

	}

}
