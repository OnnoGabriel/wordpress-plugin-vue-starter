<?php

namespace PluginVueStarter;

/**
 * Admin Base Class
 */
class Admin {

	/**
     * Minimum capability required to access plugin's settings page
     *
     * @var string
     */
	protected $capability = 'manage_options';

	/**
     * Constructor
     *
	 * Calls admin_menu() at the admin_menu action hook
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	/**
     * Register admin menu page
     *
     * @return void
     */
    public function admin_menu() {

        if ( current_user_can( $this->capability ) ) {

			add_action('admin_init', array( $this, 'register_settings' ) );

			// Add menu item "Plugin-Vue Starter" to settings menu
			add_options_page(
				"Plugin-Vue Starter",
				"Plugin-Vue Starter",
				$this->capability,
				"plugin-vue-starter-settings",
				array( $this, 'settings_page' )
			);
        }
	}

	/**
     * Register admin settings
     *
     * @return void
     */
	public function register_settings() {

		// Register settings
		register_setting(
			'plugin_vue_starter_settings',
			'plugin_vue_starter_common',
			[ 'sanitize_callback' => array( $this, 'sanitize_settings' ) ]
		);

		// New settings section "common"
		add_settings_section(
			'plugin_vue_starter_section_common',
			__('Example Settings', 'plugin-vue-starter'),
			null,
			'plugin_vue_starter_common'
		);

		// New settings field
		add_settings_field(
			'plugin_vue_starter_setting_message',
			__( 'Message to frontend plugin:', 'plugin-vue-starter' ),
			array( $this, 'settings_page_section_common_message' ),
			'plugin_vue_starter_common',
			'plugin_vue_starter_section_common',
			[
				'label_for' => 'plugin_vue_starter_setting_message',
			]
		);
	}

	public function settings_page() {

		if ( current_user_can( $this->capability ) ) {

?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
<?php
			// Output hidden settings fields
			settings_fields( 'plugin_vue_starter_settings' );
			// Output section and field
			do_settings_sections( 'plugin_vue_starter_common' );
			// Output submit button
			submit_button();
?>
			</form>
		</div>
<?php
		}
	}

	public function settings_page_section_common_message( $args ) {

		// Load settings
		$options = get_option( 'plugin_vue_starter_common' );

		// Output input field
		$id = esc_attr( $args['label_for'] );
?>
		<input type="text" id="<?php echo $id; ?>"
			name="plugin_vue_starter_common[<?php echo $id; ?>]"
			value="<?php echo isset( $options[$id] ) ? $options[$id] : '';?>"
			placeholder="Example message" />
		<p class="description">
			This text string will be read and displayed by the Vue frontend app.
		</p>
<?php
	}

	public function sanitize_settings( $data ) {
		if ( isset( $data['plugin_vue_starter_setting_message'] ) && ! $data['plugin_vue_starter_setting_message'] ) {
			add_settings_error(
				'requiredMessage',
				'empty',
				__('Please enter a message.', 'plugin-vue-starter'),
				'error'
			);
		}
		return $data;
	}

}
