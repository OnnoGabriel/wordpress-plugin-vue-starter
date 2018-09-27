<?php
/**
 * Plugin Name:     Plugin Vue Starter
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     plugin-vue-starter
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Plugin_Vue_Starter
 */

// Prevent direct script calls
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Plugin_Vue_Starter class
 *
 * @class Plugin_Vue_Starter Base class
 */
final class Plugin_Vue_Starter {

    /**
     * Constructor
     *
     * Calls init_plugin() at the plugins_loaded action hook
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
	}

    /**
     * Initialize this class
     *
     * Creates a new instance, if not already done (singleton pattern)
     */
    public static function init() {
        static $instance = false;
        if ( ! $instance ) {
            $instance = new Plugin_Vue_Starter();
        }
        return $instance;
    }

    /**
     * Load and initialize this plugin
     *
     * @return void
     */
    public function init_plugin() {

		// Define constant with path to plugin's include folder
        define( 'PLUGINVUESTARTER_INCLUDES_PATH', dirname( __FILE__ ) . '/includes' );
		// Define constant with url to plugin's public folder
        define( 'PLUGINVUESTARTER_PUBLIC_URL',  plugins_url( '', __FILE__ ) . '/public' );

        // Load textdomain (localization) at init action hook
		add_action( 'init', array( $this, 'localization_setup' ) );
		// Load classes at init action hook
        add_action( 'init', array( $this, 'init_classes' ) );

    }

    /**
     * Initialize classes
     *
	 * If you do not need to handle all of these request types
	 * (admin, frontend, ajax or rest),
	 * you can delete any section in this class
	 * and remove the correspondent subfolders in includes/.
	 *
     * @return void
     */
    public function init_classes() {

		// Request type: frontend
        if ( $this->is_request( 'frontend' ) ) {
			require_once PLUGINVUESTARTER_INCLUDES_PATH . '/class-frontend.php';
			$this->container['frontend'] = new PluginVueStarter\Frontend();
		}

		// Request type: admin area
		elseif ( $this->is_request( 'admin' ) ) {
			require_once PLUGINVUESTARTER_INCLUDES_PATH . '/class-admin.php';
			$this->container['admin'] = new PluginVueStarter\Admin();
        }

		// Request type: admin REST API call
        // elseif ( $this->is_request( 'rest' ) ) {
			require_once PLUGINVUESTARTER_INCLUDES_PATH . '/class-rest-api.php';
			$this->container['rest'] = new PluginVueStarter\REST_API();
        // }
    }

    /**
     * Load plugin textdomain (localization)
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'plugin-vue-starter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Check request types
     *
     * @param  string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
			case 'rest' :
                return defined( 'REST_REQUEST' );
            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! wp_doing_cron();
		}
		return false;
    }
}

$pluginVueStarter = Plugin_Vue_Starter::init();
