<?php
/**
 * @package WPZOOM
 */

/**
 * Class WPZOOM_Customizer_Control_Select
 *
 * Customize Select Control class
 *
 * @since 1.7.0.
 *
 * @see WP_Customize_Control
 */
class WPZOOM_Customizer_Control_Select extends WP_Customize_Control {
    /**
     * The control type.
     *
     * @since 1.7.0.
     *
     * @var string
     */
    public $type = 'zoom_select';

    /**
     * The control contextual dependency.
     *
     * @since 1.7.0.
     *
     * @var string
     */
    public $dependency = false;

    /**
     * WPZOOM_Customizer_Control_Select constructor.
     *
     * @since 1.7.0.
     *
     * @param WP_Customize_Manager $manager
     * @param string               $id
     * @param array                $args
     */
    public function __construct( WP_Customize_Manager $manager, $id, $args = array() ) {
        parent::__construct($manager, $id, $args);

        // Ensure this instance maintains the proper type value.
        $this->type = 'zoom_select';
    }
    
    /**
     * Enqueue necessary scripts for this control.
     *
     * @since 1.7.0.
     *
     * @return void
     */
    public function enqueue() {
        
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

        $json['id'] = $this->id;
        $json['choices'] = $this->choices;
        $json['value'] = $this->value();
        $json['datalink'] = $this->get_link();
        $json['defaultValue'] = $this->setting->default;
        $json['dependency'] = $this->dependency;

        return $json;
    }

    /**
     * Define the JS template for the control.
     *
     * @since 1.7.0.
     *
     * @return void
     */
    protected function content_template() {
        ?>
        <# if (data.label) { #>
            <span class="customize-control-title">{{ data.label }}</span>
        <# } #>
        <div id="input_{{ data.id }}" class="zoom-select-container">
            <select id="{{ data.id }}" name="_customize-select-{{ data.id }}" {{{ data.link }}}>
            <# for (key in data.choices) { #>
                <option value="{{ key }}"<# if (key == data.value) { #> selected="selected" <# } #>>{{ data.choices[key] }}</option>
            <# } #>
            </select>
        </div>
    <?php
    }
}