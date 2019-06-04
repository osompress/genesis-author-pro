<?php

/**
 * Genesis_Author_Pro_Widget class.
 * Generates the Genesis Author Pro Featured Book Widget.
 */
class Genesis_Author_Pro_Widget_Admin {

	private $_instance;

	private $_widget_object;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct( $instance, $widget_object ) {

		$this->_instance = $instance;

		$this->_widget_object = $widget_object;

		$this->form();

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $this->_instance Current settings
	 */
	function form() {

		$this->title();
		$this->book_select();
		$this->divider();
		$this->image_options();
		$this->divider();
		$this->content_options();

	}

	/**
	 * Outputs the title setting.
	 *
	 * @access public
	 * @return void
	 */
	public function title() {
?>
		<p>
			<label for="<?php echo $this->_widget_object->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'genesis-author-pro' ); ?>:</label>
			<input type="text" id="<?php echo $this->_widget_object->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $this->_instance['title'] ); ?>" class="widefat" />
		</p>
		<?php
	}

	/**
	 * Outputs the book selection setting.
	 *
	 * @access public
	 * @return void
	 */
	public function book_select() {
		global $Genesis_Author_Pro_CPT;
?>
		<p>
			<label for="<?php echo $this->_widget_object->get_field_id( 'book_id' ); ?>"><?php _e( 'Book', 'genesis-author-pro' ); ?>:</label>
			<?php wp_dropdown_pages( array(
				'name' => esc_attr( $this->_widget_object->get_field_name( 'book_id' ) ),
				'id'  => $this->_widget_object->get_field_id( 'book_id' ),
				'selected' => $this->_instance['book_id'],
				'post_type' => $Genesis_Author_Pro_CPT->post_type,
			) ); ?>
		</p>
		<?php
	}

	/**
	 * Outputs an HTML divider.
	 *
	 * @access public
	 * @return void
	 */
	public function divider(){
?>
		<hr class="div" />
		<?php
	}

	/**
	 * Outputs the image settings.
	 *
	 * @access public
	 * @return void
	 */
	public function image_options(){
?>
		<p>
			<input id="<?php echo $this->_widget_object->get_field_id( 'show_image' ); ?>" type="checkbox" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'show_image' ) ); ?>" value="1"<?php checked( $this->_instance['show_image'] ); ?> />
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_image' ) ); ?>"><?php _e( 'Show Featured Image', 'genesis-author-pro' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'image_size' ) ); ?>"><?php _e( 'Image Size', 'genesis-author-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'image_size' ) ); ?>" class="genesis-image-size-selector" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'image_size' ) ); ?>">
				<option value="thumbnail">thumbnail (<?php echo absint( get_option( 'thumbnail_size_w' ) ); ?>x<?php echo absint( get_option( 'thumbnail_size_h' ) ); ?>)</option>
				<?php
		$sizes = wp_get_additional_image_sizes();
		foreach ( (array) $sizes as $name => $size )
			echo '<option value="' . esc_attr( $name ) . '" ' . selected( $name, $this->_instance['image_size'], FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . 'x' . absint( $size['height'] ) . ')</option>';
?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'image_alignment' ) ); ?>"><?php _e( 'Image Alignment', 'genesis-author-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'image_alignment' ) ); ?>" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'image_alignment' ) ); ?>">
				<option value="alignnone">- <?php _e( 'None', 'genesis-author-pro' ); ?> -</option>
				<option value="alignleft" <?php selected( 'alignleft', $this->_instance['image_alignment'] ); ?>><?php _e( 'Left', 'genesis-author-pro' ); ?></option>
				<option value="alignright" <?php selected( 'alignright', $this->_instance['image_alignment'] ); ?>><?php _e( 'Right', 'genesis-author-pro' ); ?></option>
				<option value="aligncenter" <?php selected( 'aligncenter', $this->_instance['image_alignment'] ); ?>><?php _e( 'Center', 'genesis-author-pro' ); ?></option>
			</select>
		</p>

		<p>
			<input id="<?php echo $this->_widget_object->get_field_id( 'show_featured_text' ); ?>" type="checkbox" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'show_featured_text' ) ); ?>" value="1"<?php checked( $this->_instance['show_featured_text'] ); ?> />
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_featured_text' ) ); ?>"><?php _e( 'Show Featured Text With Image', 'genesis-author-pro' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Outputs the Content Settings.
	 *
	 * @access public
	 * @return void
	 */
	public function content_options() {
?>
		<p>
			<input id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_title' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'show_title' ) ); ?>" value="1"<?php checked( $this->_instance['show_title'] ); ?> />
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_title' ) ); ?>"><?php _e( 'Show Book Title', 'genesis-author-pro' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_author' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'show_author' ) ); ?>" value="1"<?php checked( $this->_instance['show_author'] ); ?> />
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_author' ) ); ?>"><?php _e( 'Show Book Author', 'genesis-author-pro' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_content' ) ); ?>"><?php _e( 'Content Type', 'genesis-author-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'show_content' ) ); ?>">
				<option value="content" <?php selected( 'content', $this->_instance['show_content'] ); ?>><?php _e( 'Show Content', 'genesis-author-pro' ); ?></option>
				<option value="excerpt" <?php selected( 'excerpt', $this->_instance['show_content'] ); ?>><?php _e( 'Show Excerpt', 'genesis-author-pro' ); ?></option>
				<option value="content-limit" <?php selected( 'content-limit', $this->_instance['show_content'] ); ?>><?php _e( 'Show Content Limit', 'genesis-author-pro' ); ?></option>
				<option value="" <?php selected( '', $this->_instance['show_content'] ); ?>><?php _e( 'No Content', 'genesis-author-pro' ); ?></option>
			</select>
			<br />
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'content_limit' ) ); ?>"><?php _e( 'Limit content to', 'genesis-author-pro' ); ?>
				<input type="text" id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'content_limit' ) ); ?>" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( intval( $this->_instance['content_limit'] ) ); ?>" size="3" />
				<?php _e( 'characters', 'genesis-author-pro' ); ?>
			</label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_price' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'show_price' ) ); ?>" value="1"<?php checked( $this->_instance['show_price'] ); ?> />
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'show_price' ) ); ?>"><?php _e( 'Show Book Price', 'genesis-author-pro' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->_widget_object->get_field_id( 'more_text' ) ); ?>"><?php _e( 'View Book Text', 'genesis-author-pro' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->_widget_object->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->_widget_object->get_field_name( 'more_text' ) ); ?>" value="<?php echo esc_attr( $this->_instance['more_text'] ); ?>" />
		</p>
		<?php
	}

}
