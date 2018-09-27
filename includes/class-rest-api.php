<?php

namespace PluginVueStarter;

/**
 * REST Base Class
 */
class REST_API {

	/**
     * Constructor
     *
     */
    public function __construct() {

		// Register REST route for data access
		register_rest_route(
			'plugin-vue-starter/v1',
			'/message',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_data' )
			)
		);

    }


	/**
	 * Callback function for REST route
	 *
     * @return void
     */
	public function get_data( $request ) {
		// Load settings
		$options = get_option( 'plugin_vue_starter_common' );

		// Set message string
		$message = 'A message text has not yet been set.';
		if (!empty( $options['plugin_vue_starter_setting_message']) ) {
			$message = $options['plugin_vue_starter_setting_message'];
		}

		// Return JSON object with message string
		return rest_ensure_response(
			json_encode(
				[ 'message' => $message ],
				JSON_UNESCAPED_SLASHES
			)
		);
	}

}
