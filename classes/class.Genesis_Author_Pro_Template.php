<?php
/**
 * Contains the Genesis_Author_Pro_Template class.
 * Conditionally changes the template files.
 *
 * @author StudioPress
 * @package Genesis Author Pro
 * @subpackage Template
 */

/**
 * Genesis_Author_Pro_Template class.
 */
class Genesis_Author_Pro_Template {

	/**
	 * The template file
	 *
	 * @var string
	 * @access public
	 */
	public $template;

	/**
	 * Genesis_Author_Pro_Template constructor.
	 * Sets the initial object $template variable.
	 * Calls the set_template method with the appropriate template type.
	 *
	 * @access public
	 * @param string $template
	 * @return void
	 */
	public function __construct( $template ){

		global $Genesis_Author_Pro_CPT;

		$this->template = $template;

		if ( is_single() ) {

			$this->set_template( 'single-books' );

		} elseif( is_post_type_archive( $Genesis_Author_Pro_CPT->post_type ) ){

			$this->set_template( 'archive-books' );

		} elseif( is_tax() ) {

			global $wp_query;

			$this->set_template( 'taxonomy-' . $wp_query->query_vars['taxonomy'] );

		}

	}

	/**
	 * Sets the object $template variable to use the appropriate template file.
	 * Checks to see if the theme has the template file and uses that file if available
	 * Otherwise it uses the file from the plugin template directory.
	 *
	 * @access public
	 * @param string $template
	 * @return void
	 */
	public function set_template( $template ){

		// Get the template slug
		$template_slug = rtrim( $template, '.php' );
		$template = $template_slug . '.php';

		// Check if a custom template exists in the theme folder, if not, load the plugin template file
		if ( $theme_file = locate_template( array( $template ) ) ) {
			$file = $theme_file;
		}
		else {
			$file = GENESIS_AUTHOR_PRO_TEMPLATES_DIR . $template;
		}

		$this->template = apply_filters( 'genesis_author_pro_repl_template_' . $template, $file );

	}

	/**
	 * Filter applied to the template_includes filters.
	 * Verifies the current view is a post_type, archive, or taxonomy associated with the Author Pro plugin
	 * then instantiates the Genesis_Author_Pro_Template class to retrieve the correct template file location
	 * before returning the template file location.
	 *
	 * @access public
	 * @static
	 * @param string $template
	 * @return string
	 */
	static public function maybe_include_template( $template ){

		if( is_front_page() ) {
			return $template;
		}

		global $Genesis_Author_Pro_CPT;

		if(
			( is_single() && $Genesis_Author_Pro_CPT->post_type == get_post_type( get_the_ID() ) ) ||
			is_post_type_archive( $Genesis_Author_Pro_CPT->post_type ) ||
			is_tax( array(
					$Genesis_Author_Pro_CPT->author,
					$Genesis_Author_Pro_CPT->series,
					$Genesis_Author_Pro_CPT->tag,
				) )
		) {

			require_once( GENESIS_AUTHOR_PRO_FUNCTIONS_DIR . 'template.php' );

			add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

			$Genesis_Author_Pro_Template = new Genesis_Author_Pro_Template( $template );

			$template = $Genesis_Author_Pro_Template->template;

		}

		return $template;

	}

}
