<?php
/**
 * @package WPZOOM
 */

/**
 * Class WPZOOM_Customizer_Control_Sortable
 *
 * Customize Select Control class
 *
 * @since 1.7.0.
 *
 * @see WP_Customize_Control
 */
class WPZOOM_Customizer_Control_Sortable extends WP_Customize_Control {
    /**
     * The control type.
     *
     * @since 1.7.0.
     *
     * @var string
     */
    public $type = 'zoom_sortable';

    /**
     * WPZOOM_Customizer_Control_Sortable constructor.
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
        $this->type = 'zoom_sortable';
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

        if ( ! empty( $json['defaultValue'] ) && empty( $json['value'] ) ) {
            $json['value'] = $json['defaultValue'];
        }

        if ( ! empty( $json['value'] ) ) {

            $value = str_split($json['value']);
            $newarray = array();

            foreach ($value as $key) {
                $newarray[ $key ] = $json['choices'][ $key ];
            }

            $json['choices'] = $newarray;

        } else {
            foreach ($json['choices'] as $key => $value) {
                $json['value'] .= $key;
            }
        }

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

        <div id="input_{{ data.id }}" class="zoom-sortable-container">
            <ol id="{{ data.id }}" class="zoom-elements-order-sortable jquery-sortable" tabindex="-1" {{{ data.link }}}>
                <# for (key in data.choices) { #>
                    <li id="order-item-{{ key }}" data-item-value="{{ key }}" class="zoom-elements-order-sortable-{{ key }}">{{ data.choices[key] }}</li>
                <# } #>
            </ol>
            <input type="hidden" name="_customize-select-{{ data.id }}" value="{{ data.value }}">
        </div>

        <# if (data.description) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
        <# } #>
    <?php
    }
}