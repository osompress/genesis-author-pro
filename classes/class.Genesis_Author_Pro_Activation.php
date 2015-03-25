<?php

/**
 * Genesis_Author_Pro_Activation class.
 */
class Genesis_Author_Pro_Activation {

	/**
	 * Registered activation hook callback.
	 * When this plugin is activated, the method is run.
	 * Instantiates the Genesis_Author_Pro_CPT class.
	 * Flushes the rewrite rules.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function activate() {

		new Genesis_Author_Pro_CPT;

		flush_rewrite_rules();

	}

}
