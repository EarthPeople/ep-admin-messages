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
		$this->setup_messages();

	}

	function setup_messages() {

		if ( isset( $this->config->messages ) ) {

			foreach ( $this->config->messages as $one_message ) {

				// @todo: determine where to show message, and for who, and all da stuff
				sf_d($one_message);

			}

		}

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
		}

		$config_json = json_decode($config_contents);
		if ( is_null($config_json) ) {
			add_action( 'admin_notices', array($this, "message_config_file_error") );
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



