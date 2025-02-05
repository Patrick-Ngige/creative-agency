<?php

namespace ThemescampPlugin\Elementor;

if (!class_exists('Elementor\Group_Control_Background')) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Group_Control_Base;

defined('ABSPATH') || exit(); // Exit if accessed directly

class TCG_Group_Background extends Group_Control_Background
{

    public $controls = [];
    protected static $fields;
    private static $background_types;

    public function array_insert_after(array $array, $key, array $new)
    {
        $keys = array_keys($array);
        $index = array_search($key, $keys);
        $pos = false === $index ? count($array) : $index + 1;
        return array_merge(array_slice($array, 0, $pos), $new, array_slice($array, $pos));
    }

    public function init_fields()
    {

        $active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();

        $location_device_args = [];
        $location_device_defaults = [
            'default' => [
                'unit' => '%',
            ],
        ];

        $angel_device_args = [];
        $angel_device_defaults = [
            'default' => [
                'unit' => 'deg',
            ],
        ];

        $position_device_args = [];
        $position_device_defaults = [
            'default' => 'center center',
        ];

        foreach ($active_breakpoints as $breakpoint_name => $breakpoint) {
            $location_device_args[$breakpoint_name] = $location_device_defaults;
            $angel_device_args[$breakpoint_name] = $angel_device_defaults;
            $position_device_args[$breakpoint_name] = $position_device_defaults;
        }

        $controls['color_c'] = [
            'label' => esc_html__('Third Color', 'elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f2295b',
            'render_type' => 'ui',
            'condition' => [
                'background' => ['tcg_gradient'],
            ],
            'of_type' => 'gradient',
        ];

        $controls['color_c_stop'] = [
            'label' => esc_html_x('Location', 'Background Control', 'elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%', 'custom'],
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'device_args' => $location_device_args,
            'responsive' => true,
            'render_type' => 'ui',
            'condition' => [
                'background' => ['tcg_gradient'],
            ],
            'of_type' => 'gradient',
        ];

        $controls['tcg_gradient_angle'] = [
            'label' => esc_html__('Angle', 'elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['deg', 'grad', 'rad', 'turn', 'custom'],
            'default' => [
                'unit' => 'deg',
                'size' => 180,
            ],
            'device_args' => $angel_device_args,
            'responsive' => true,
            'selectors' => [
                '{{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}}, {{color_c.VALUE}} {{color_c_stop.SIZE}}{{color_c_stop.UNIT}})',
            ],
            'condition' => [
                'background' => ['tcg_gradient'],
                'gradient_type' => 'linear',
            ],
            'of_type' => 'tcg_gradient',
        ];

        $controls['tcg_gradient_position'] = [
            'label' => esc_html__('Position', 'elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'center center' => esc_html__('Center Center', 'elementor'),
                'center left' => esc_html__('Center Left', 'elementor'),
                'center right' => esc_html__('Center Right', 'elementor'),
                'top center' => esc_html__('Top Center', 'elementor'),
                'top left' => esc_html__('Top Left', 'elementor'),
                'top right' => esc_html__('Top Right', 'elementor'),
                'bottom center' => esc_html__('Bottom Center', 'elementor'),
                'bottom left' => esc_html__('Bottom Left', 'elementor'),
                'bottom right' => esc_html__('Bottom Right', 'elementor'),
            ],
            'default' => 'center center',
            'device_args' => $position_device_args,
            'responsive' => true,
            'selectors' => [
                '{{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}}, {{color_c.VALUE}} {{color_c_stop.SIZE}}{{color_c_stop.UNIT}})',
            ],
            'condition' => [
                'background' => ['tcg_gradient'],
                'gradient_type' => 'radial',
            ],
            'of_type' => 'tcg_gradient',
        ];

        $fields = parent::init_fields(); // TODO: Change the autogenerated stub

        $fields = $this->array_insert_after(
            $fields,
            'color_b_stop',
            $controls
        );
        $modified_fields = [];

        foreach ($fields as $key => $field) {
            if (isset($field['condition']) && array_key_exists('background', $field['condition']) && in_array('gradient', $field['condition']['background']) && $key != 'gradient_position' && $key != 'gradient_angle') {
                array_push($field['condition']['background'], 'tcg_gradient');
                $modified_fields[$key] = $field;
            } else {
                $modified_fields[$key] = $field; // Add unmodified fields as well
            }
        }

        //var_dump($modified_fields);

        return $modified_fields;
    }

    protected function prepare_fields($fields)
    {
        $args = $this->get_args();

        $background_types = parent::get_background_types();

        // Add new background type 'gradient3'.
        $background_types['tcg_gradient'] = [
            'title' => esc_html__('3 Colors Gradient', 'elementor'),
            'icon' => 'eicon-barcode',
        ];

        $choose_types = [];

        foreach ($args['types'] as $type) {
            if (isset($background_types[$type])) {
                $choose_types[$type] = $background_types[$type];
            }
        }

        $fields['background']['options'] = $choose_types;

        //var_dump(Group_Control_Base::prepare_fields( $fields ));

        return Group_Control_Base::prepare_fields($fields);
    }
}

/**
 *  Elementor extra features
 */
class TCG_Group_Control_Extender
{

    public function __construct()
    {
        // extend Group_Control_Background
        add_action('elementor/controls/controls_registered', function () {

            $controls_manager = \Elementor\Plugin::$instance->controls_manager;
            $controls_manager->add_group_control('background', new TCG_Group_Background());
        });
    }
}
