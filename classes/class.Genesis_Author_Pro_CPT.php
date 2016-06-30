<?php

/**
 * Genesis_Author_Pro_CPT class.
 */
class Genesis_Author_Pro_CPT {

	/**
	 * The post type.
	 *
	 * @var string
	 * @access public
	 */
	var $post_type;

	/**
	 * Heirarcical taxonomy for book Authors.
	 *
	 * @var string
	 * @access public
	 */
	var $author;

	/**
	 * The heirarcical taxonomy.
	 *
	 * @var string
	 * @access public
	 */
	var $series;

	/**
	 * The non heirarcical taxonomy.
	 *
	 * @var string
	 * @access public
	 */
	var $tag;

	/**
	 * Action added on the init hook.
	 * Sets the global $Genesis_Author_Pro_CPT variable
	 * and instantiates the Genesis_Author_Pro_CPT object.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function init() {

		global $Genesis_Author_Pro_CPT;

		$Genesis_Author_Pro_CPT = new Genesis_Author_Pro_CPT;

	}

	/**
	 * Action on the after_setup_theme hook.
	 * Checks to see if the author_pro_archive image size exists
	 * then adds author_pro_archive image size if it isn't set.
	 * This allows the child theme or another plugin to override the image size.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static function maybe_add_image_size() {

		global $_wp_additional_image_sizes;

		if( ! isset( $_wp_additional_image_sizes['author-pro-image'] ) ) {

			add_image_size( 'author-pro-image', 360, 570, TRUE );

		}

	}

	/**
	 * Genesis_Author_Pro_CPT constructor method.
	 * Sets the $post_type class variable
	 * Calls the register_post_type() method.
	 * Calls the register_taxonomy()method.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {

		$this->post_type = 'books';
		$this->author    = 'book-authors';
		$this->series    = 'book-series';
		$this->tag       = 'book-tags';

		$this->register_post_type();
		$this->register_taxonomy();

	}

	/**
	 * Registers the Book post type.
	 *
	 * @access public
	 * @return void
	 */
	function register_post_type() {

		$labels = apply_filters( 'genesis_author_pro_cpt_labels', array(
				'name'               => _x( 'Library'     , 'post type general name' , 'genesis-author-pro' ),
				'singular_name'      => _x( 'Book'        , 'post type singular name', 'genesis-author-pro' ),
				'add_new'            => _x( 'Add New Book', 'add_new_book'           , 'genesis-author-pro' ),
				'menu_name'          => __( 'Library'                                , 'genesis-author-pro' ),
				'add_new_item'       => __( 'Add New Book'                           , 'genesis-author-pro' ),
				'edit_item'          => __( 'Edit Book'                              , 'genesis-author-pro' ),
				'new_item'           => __( 'New Book'                               , 'genesis-author-pro' ),
				'all_items'          => __( 'All Books'                              , 'genesis-author-pro' ),
				'view_item'          => __( 'View Book'                              , 'genesis-author-pro' ),
				'search_items'       => __( 'Search Books'                           , 'genesis-author-pro' ),
				'not_found'          => __( 'No Books Found'                         , 'genesis-author-pro' ),
				'not_found_in_trash' => __( 'No Books Found in Trash'                , 'genesis-author-pro' ),
			) );

		$args = apply_filters( 'genesis_author_pro_cpt_args', array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'menu_icon'          => 'dashicons-book-alt',
				'query_var'          => true,
				'rewrite'            => array( 'slug' => apply_filters( 'genesis_author_pro_book_slug', 'book' ) , 'feeds' => true, 'with_front' => true, ),
				'capability_type'    => 'post',
				'has_archive'        => apply_filters( 'genesis_author_pro_archive_slug', 'books' ),
				'hierarchical'       => true,
				'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'genesis-seo', 'genesis-scripts',  'genesis-cpt-archives-settings', 'genesis-simple-menus' ),
				'menu_position'      => 22,
			) );

		register_post_type( $this->post_type, $args );

	}

	/**
	 * Registers taxonomies for the Book post type.
	 *
	 * @access public
	 * @return void
	 */
	function register_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Book Authors', 'taxonomy general name' , 'genesis-author-pro' ),
			'singular_name'              => _x( 'Book Author' , 'taxonomy singular name', 'genesis-author-pro' ),
			'search_items'               => __( 'Search Book Authors'                   , 'genesis-author-pro' ),
			'all_items'                  => __( 'All Book Authors'                      , 'genesis-author-pro' ),
			'edit_item'                  => __( 'Edit Book Author'                      , 'genesis-author-pro' ),
			'update_item'                => __( 'Update Book Author'                    , 'genesis-author-pro' ),
			'add_new_item'               => __( 'Add New Book Author'                   , 'genesis-author-pro' ),
			'new_item_name'              => __( 'New Book Author Name'                  , 'genesis-author-pro' ),
			'add_or_remove_items'        => __( 'Add or remove Book Author'             , 'genesis-author-pro' ),
			'not_found'                  => __( 'No Book Authors found.'                , 'genesis-author-pro' ),
			'menu_name'                  => __( 'Authors'                               , 'genesis-author-pro' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => apply_filters( 'genesis_author_pro_author_slug', 'book-author' ) ),
		);

		register_taxonomy( $this->author, array( $this->post_type ), $args );

		$labels = array(
			'name'                       => _x( 'Book Series' , 'taxonomy general name' , 'genesis-author-pro' ),
			'singular_name'              => _x( 'Book Series' , 'taxonomy singular name', 'genesis-author-pro' ),
			'search_items'               => __( 'Search Book Series'                    , 'genesis-author-pro' ),
			'all_items'                  => __( 'All Book Series'                       , 'genesis-author-pro' ),
			'edit_item'                  => __( 'Edit Book Series'                      , 'genesis-author-pro' ),
			'update_item'                => __( 'Update Book Series'                    , 'genesis-author-pro' ),
			'add_new_item'               => __( 'Add New Book Series'                   , 'genesis-author-pro' ),
			'new_item_name'              => __( 'New Book Series Name'                  , 'genesis-author-pro' ),
			'add_or_remove_items'        => __( 'Add or remove Book Series'             , 'genesis-author-pro' ),
			'not_found'                  => __( 'No Book Series found.'                 , 'genesis-author-pro' ),
			'menu_name'                  => __( 'Series'                                , 'genesis-author-pro' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => apply_filters( 'genesis_author_pro_series_slug', 'book-series' ) ),
		);

		register_taxonomy( $this->series, array( $this->post_type ), $args );

		$labels = array(
			'name'                       => _x( 'Book Tags' , 'taxonomy general name' , 'genesis-author-pro' ),
			'singular_name'              => _x( 'Book Tag' , 'taxonomy singular name' , 'genesis-author-pro' ),
			'search_items'               => __( 'Search Book Tags'                    , 'genesis-author-pro' ),
			'all_items'                  => __( 'All Book Tags'                       , 'genesis-author-pro' ),
			'edit_item'                  => __( 'Edit Book Tag'                       , 'genesis-author-pro' ),
			'update_item'                => __( 'Update Book Tag'                     , 'genesis-author-pro' ),
			'add_new_item'               => __( 'Add New Book Tag'                    , 'genesis-author-pro' ),
			'new_item_name'              => __( 'New Book Tag Name'                   , 'genesis-author-pro' ),
			'add_or_remove_items'        => __( 'Add or remove Book Tag'              , 'genesis-author-pro' ),
			'not_found'                  => __( 'No Book Tags found.'                 , 'genesis-author-pro' ),
			'menu_name'                  => __( 'Tags'                                , 'genesis-author-pro' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => apply_filters( 'genesis_author_pro_tag_slug', 'book-tag' ) ),
		);

		register_taxonomy( $this->tag, array( $this->post_type ), $args );

	}

}
