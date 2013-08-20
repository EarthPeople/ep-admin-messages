<?php

/**
 * Class to handle showing messages in WP admin
 */
class Ep_Admin_Messages {

	private $config_file = "ep-config.json";
	private $config = array();
	private $plugin_name = "EP Admin Messages";

	function __construct() {
		
		add_action("init", array($this, "init"));

	}

	function init() {

		$this->load_config();

		// Use current screen hook to add messages, because first then the current screen function is available
		add_action("current_screen", array($this, "setup_messages"));

	}

	/*

	where we are in wp can be determined using the wp screen object

	WP_Screen Object

	dashboard
	    [base] => dashboard
	    [id] => dashboard

	WordPress Updates / update core
	    [base] => update-core
	    [id] => update-core
	
	pages overview / edit.php?post_type=page
	    [base] => edit
	    [id] => edit-page
    	[post_type] => page
	
	page add new / post-new.php?post_type=page
	    [action] => add
	    [base] => post
	    [id] => page
        [post_type] => page
	
	page edit / post.php?post=749&action=edit
	    [base] => post
	    [id] => page
        [post_type] => page

    post overview
   	    [base] => edit
        [id] => edit-post
        [post_type] => post

    post new
        [action] => add
        [base] => post
        [id] => post
        [post_type] => post

	media
	    [base] => upload
        [id] => upload

    custom post overview (js error log)
   	    [base] => edit
	    [id] => edit-js_error_log
        [post_type] => js_error_log

	*/


	function setup_messages() {

		$current_screen = get_current_screen();

		if ( isset( $this->config->messages ) ) {

			foreach ( $this->config->messages as $one_message ) {
			
				// Get settings for message
				$locations = array();
				if (! empty($one_message->location) )
					$locations = $this->get_array_from_string( $one_message->location );

				$post_slugs = array();
				if (! empty($one_message->post_slug) )
					$post_slugs = $this->get_array_from_string( $one_message->post_slug );

				$capabilities = array();
				if (! empty($one_message->capability) )
					$capabilities = $this->get_array_from_string( $one_message->capability );

				// Detect language
				// @todo: Actually detect language
				$message_to_show = "";
				if ( ! empty( $one_message->message ) )
					$message_to_show = $one_message->message;

				
				// Determine if message should be shown on current screen
				// By default all messages are shown
				$do_show = true;
				$position = "admin_notices";

				// First of all we must have a message to show
				if ( empty( $message_to_show ) )
					continue;

				// If locations is set then limit where to show
				if ( ! empty( $locations ) ) {
					$do_show = false;
				}

				// If capabilites is set then limit who to show to
				if ( ! empty( $capabilites ) ) {
					$do_show = false;
				}
				
				// If post_slugs is set then limit who to show to
				if ( ! empty( $post_slugs ) ) {
					$do_show = false;
				}

				// Show message at admin_notices/top
				// Works for all screens
				if ( $do_show && "admin_notices" === $position ) {
					add_action("admin_notices", function() use ($one_message) {
						?>
						<div class="updated">
							<p><?php echo $one_message->message ?></p>
						</div>
						<?php
					});
				}

			}

		}

	}

	/**
	 * Convert from comma separated string to array. Trims whitespace and removes empty values.
	 *
	 * @return array
	 */
	function get_array_from_string($str) {
		$arr = explode(",", $str);
		$arr = array_map("trim", $arr);
		$arr = array_filter($arr);
		return $arr;
	}

	function load_config() {

		$config_contents = false;

		// Look for config file, first in child dir and then in parent dir
		$child_theme_config = STYLESHEETPATH . "/" . $this->config_file;
		$parent_theme_config = TEMPLATEPATH . "/" . $this->config_file;
		if ( file_exists( $child_theme_config ) ) {
			$config_contents = file_get_contents( $child_theme_config );
		} elseif ( file_exists( $parent_theme_config ) ) {
			$config_contents = file_get_contents( $parent_theme_config );
		}

		if ( false === $config_contents ) {
			add_action( 'admin_notices', array($this, "message_no_config_file_found") );
			return false;
		}

		$config_json = json_decode($config_contents);
		if ( is_null($config_json) ) {
			add_action( 'admin_notices', array($this, "message_config_file_error") );
			return false;
		}

		// Get here = valid json config
		$this->config = $config_json;

	}

	function message_config_file_error() {
		?>
		<div class="error">
			<p><?php echo sprintf( __( '%1$s: Config file "%2$s" does not contain valid JSON.', 'ep-admin-messages' ), $this->plugin_name, $this->config_file ); ?></p>
		</div>
		<?php		
	}

	function message_no_config_file_found() {
		?>
		<div class="error">
			<p><?php echo sprintf( __( '%1$s: Could not find config file "%2$s" in your theme directory.', 'ep-admin-messages' ), $this->plugin_name, $this->config_file ); ?></p>
		</div>
		<?php
	}

}

$GLOBALS['ep_admin_messags'] = new Ep_Admin_Messages();



