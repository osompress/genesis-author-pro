<?php

/**
 * customDirectoryListing_Save class.
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

	private $_meta_data;

	private $_prefix = '_genesis_author_pro';

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

	private function _update_meta_data() {
		
		update_post_meta( $this->post_id, $this->_prefix, $this->_meta_data );
		
	}

	private function _sanitize_date( $value ){
		
		if( $value ){
			return strtotime( $value );
		}
		
		return '';
		
	}

	private function _sanitize_uri( $value ){
		
		return esc_url( $value );
		
	}

	private function _sanitize_html( $value ){
		
		return esc_html( $value );
		
	}

}
