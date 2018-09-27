<?php

namespace PluginVueStarter;

/**
 * Frontend Base Class
 */
class Frontend {

	/**
     * Constructor
     *
     * Adds "vue-app" shortcode, which calls render_vue_app() function
     */
    public function __construct() {
        add_shortcode( 'vue-app', [ $this, 'render_vue_app' ] );
    }

    /**
     * Render Vue app in frontend
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_vue_app( $atts, $content = '' ) {
		// Load frontend Vue script:

		// Production mode (comment or uncomment)
		// wp_enqueue_script( 'plugin-vue-frontend', PLUGINVUESTARTER_PUBLIC_URL . '/frontend.min.js' );

		// Development mode (comment or uncomment)
		wp_enqueue_script( 'plugin-vue-frontend', PLUGINVUESTARTER_PUBLIC_URL . '/frontend.js' );

		// Main element of the Vue app
        return '<div id="vue-frontend-app"></div>';
    }
}
