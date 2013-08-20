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

	function setup_messages() {

		$current_screen = get_current_screen();

		// If current screen is showing a post then get the post
		if ( "post" === $current_screen->base ) {
			
			$post_id = 0;
			if ( isset( $_GET['post'] ) )
			 	$post_id = $post_ID = (int) $_GET['post'];
			elseif ( isset( $_POST['post_ID'] ) )
			 	$post_id = $post_ID = (int) $_POST['post_ID'];

			 $post = get_post($post_id);

		 }

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
					
					$do_show_location = false;

					foreach ($locations as $one_location) {
						
						if ( strpos( $one_location, "post_type:" ) !== false ) {

							// Location is a post type, i.e. location begins with "post_type:"

							$location_post_type = str_replace("post_type:", "", $one_location);
							
							if ( empty($location_post_type) )
								continue;

							if ( "post" === $current_screen->base && $location_post_type === $current_screen->post_type )
								$do_show_location = true;

						} elseif ( strpos( $one_location, "post_type_overview:" ) !== false ) {
							
							// Location is a post type overview screen

							$location_post_type = str_replace("post_type_overview:", "", $one_location);
							
							if ( empty($location_post_type) )
								continue;

							if ( "edit" === $current_screen->base && $location_post_type === $current_screen->post_type )
								$do_show_location = true;

						} elseif ( strpos( $one_location, "post_type_metabox:" ) !== false ) {
							
							// Location is a post type overview screen

							$location_post_type = str_replace("post_type_metabox:", "", $one_location);

							if ( empty($location_post_type) )
								continue;

							if ( "post" === $current_screen->base && $location_post_type === $current_screen->post_type ) {
								$do_show_location = true;
								$position = "meta_box";
							}

						} elseif ( "dashboard" === $one_location ) {

							if ( "dashboard" === $current_screen->base  )
								$do_show_location = true;

						} elseif ( "plugins" === $one_location ) {

							if ( "plugins" === $current_screen->base  )
								$do_show_location = true;

						} elseif ( "users" === $one_location ) {

							if ( "users" === $current_screen->base  )
								$do_show_location = true;

						} elseif ( "profile" === $one_location ) {

							if ( "profile" === $current_screen->base  )
								$do_show_location = true;
						
						} // if check locations

						// @todo: should we just be able to query any screen in the config?
						// Like: "screen_base:upload"
						// However problems with multiple conditions

					}

					if ( ! $do_show_location )
						$do_show = false;

				}

				// If capabilites is set then limit who to show to
				// User need to have at least of the capabilities
				if ( ! empty( $capabilities ) ) {

					$do_show_capability = false;

					foreach ( $capabilities as $one_capability ) {

						if ( current_user_can( $one_capability ) ) {
							$do_show_capability = true;
							break;
						}

					}

					if ( ! $do_show_capability )
						$do_show = false;
				}
				
				// If post_slugs is set then limit who to show to
				if ( ! empty( $post_slugs ) ) {

					$do_show_post_slug = false;

					if ( ! empty( $post ) ) {
					
						foreach ( $post_slugs as $one_slug ) {

							// check post slug for exact match 
							if ( $one_slug === $post->post_name ) {
								$do_show_post_slug = true;
								break;
							}

							// check post slug for partial match, if one_slug ends with wildcard (*)
							if ( strpos( $one_slug, "*" ) !== false ) {
								
								// found a wildcard, match a regexp out of it
								$regexp = "/" . str_replace("*", ".+", $one_slug) . "/";
								if ( preg_match($regexp, $post->post_name) === 1) {
									$do_show_post_slug = true;
									break;
								}

							}
						}

					} // if not empty post

					if ( ! $do_show_post_slug )
						$do_show = false;

				}

				if ( $do_show ) {

					if ( "admin_notices" === $position ) {
					
						// Show message at admin_notices/top
						// Works for all screens
						add_action("admin_notices", function() use ($one_message) {
							?>
							<div class="updated">
								<p><?php echo $one_message->message ?></p>
							</div>
							<?php
						});

					} elseif ( "meta_box" === $position ) {

						// Show message in a meta box on the edit post screen
						$meta_box_priority = "high"; // high', 'core', 'default' or 'low'
						$meta_box_title = __("Admin Message", "ep-admin-message");
						add_meta_box( "", $meta_box_title, function() use ($one_message, $message_to_show) {
							?>
							<?php echo $message_to_show ?>
							<?php
						}, $post->post_type, "side", $meta_box_priority );

					}

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



