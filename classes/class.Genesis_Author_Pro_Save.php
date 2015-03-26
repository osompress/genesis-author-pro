<?php

/**
 * Genesis_Author_Pro_Save class.
 */
class Genesis_Author_Pro_Save {

	/**
	 * The post ID of the entry currently being saved
	 *
	 * @var int
	 * @access public
	 */
	var $post_id;

	/**
	 * The post object of the entry currently being saved
	 *
	 * @var int
	 * @access public
	 */
	var $post;

	/**
	 * The book meta data for the item currently being saved.
	 * This value will contain the posted meta data which is then sanitized before being saved.
	 *
	 * @var array
	 * @access private
	 */
	private $_meta_data;

	/**
	 * The prefix key used to update the meta data.
	 * This key should also contain the posted book meta data.
	 *
	 * (default value: '_genesis_author_pro')
	 *
	 * @var string
	 * @access private
	 */
	private $_prefix = '_genesis_author_pro';

	/**
	 * Constuctor method for the Genesis_Author_Pro_Save class.
	 * Sets the initial values for the object $post_id, $post, and $_meta_data variables.
	 * Calls the _sanitize_meta_data() and _update_meta_data() methods.
	 *
	 * @access public
	 * @param string $post_id
	 * @param object $post
	 * @return void
	 */
	public function __construct( $post_id, $post ) {

		if( empty( $_POST[$this->_prefix] ) ){
			return;
		}

		$this->post_id    = $post_id;
		$this->post       = $post;
		$this->_meta_data = $_POST[$this->_prefix];

		$this->_sanitize_meta_data();
		$this->_update_meta_data();

	}

	/**
	 * Runs the object $_meta_data through data sanitization methods.
	 *
	 * @access private
	 * @return void
	 */
	private function _sanitize_meta_data(){

		foreach( $this->_meta_data as $key => $value ){

			switch( $key ){

			case 'publication_date':
				$this->_meta_data[$key] = $this->_sanitize_date( $value );
				break;

			case ( false !== strpos( $key, '_uri' ) ):
				$this->_meta_data[$key] = $this->_sanitize_uri( $value );
				break;

			default:
				$this->_meta_data[$key] = $this->_sanitize_html( $value );
				break;

			}

		}

	}

	/**
	 * Updates the book meta using the $_prefix object variable to set the key and the sanitized $_meta_data.
	 *
	 * @access private
	 * @return void
	 */
	private function _update_meta_data() {

		update_post_meta( $this->post_id, $this->_prefix, $this->_meta_data );

	}

	/**
	 * Converts common date formated strings into machine readible time.
	 * If the data does not match a known date format it will return false.
	 *
	 * @access private
	 * @param string $value
	 * @return void
	 */
	private function _sanitize_date( $value ){

		if( $value ){
			return strtotime( $value );
		}

		return '';

	}

	/**
	 * Escapes the $value for use as a URI.
	 *
	 * @access private
	 * @param string $value
	 * @return void
	 */
	private function _sanitize_uri( $value ){

		return esc_url( $value );

	}

	/**
	 * Escapes characters used for HTML into HTML entities.
	 *
	 * @access private
	 * @param string $value
	 * @return void
	 */
	private function _sanitize_html( $value ){

		return esc_html( $value );

	}

}
