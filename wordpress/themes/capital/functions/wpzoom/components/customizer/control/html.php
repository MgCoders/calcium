<?php
/**
 * @package WPZOOM
 */

/**
 * Class WPZOOM_Customizer_Control_HTML
 *
 * JS-based control for adding arbitrary HTML to Customizer sections.
 *
 * @since 1.7.0.
 */
class WPZOOM_Customizer_Control_HTML extends WP_Customize_Control {
	/**
	 * The current setting name.
	 *
	 * @since 1.7.0.
	 *
	 * @var   string|array    The current setting name.
	 */
	public $settings = array();

	/**
	 * The control type.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	public $type = 'zoom_html';

	/**
	 * The HTML to display with the control.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	public $html = '';

	/**
	 * WPZOOM_Customizer_Control_HTML constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
		parent::__construct( $manager, $id, $args );

		// Ensure this instance maintains the proper type value.
		$this->type = 'zoom_html';
	}

	/**
	 * Add extra properties to JSON array.
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	public function json() {
		$json = parent::json();

		$json['html'] = $this->html;

		return $json;
	}

	/**
	 * Define the JS template for the control.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	protected function content_template() { ?>
		<# if (data.label) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		
		<# if (data.html) { #>
			<div class="zoom-html-container">
				<h4 class="zoom-group-title">{{{ data.html }}}</h4>
			</div>
		<# } #>

		<# if (data.description) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
	<?php }
}