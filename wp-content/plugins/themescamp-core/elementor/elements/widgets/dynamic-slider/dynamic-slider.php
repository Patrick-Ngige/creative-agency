<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\POPOVER_TOGGLE;
use ThemescampPlugin\Elementor\Controls\Helper as ControlsHelper;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TCG_Dynamic_Slider extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tcg-dynamic-slider';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('TC Dynamic Slider', 'themescamp-plugin');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-posts-ticker';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['themescamp-plugin'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['effect-material.min', 'dynamic-slider'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'slides_section',
            [
                'label' => __('slides', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'tcg_select_type',
            [
                'label' => esc_html__('Select Slides Type', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'blocks',
                'options' => [
                    'blocks' => esc_html__('Blocks', 'themescamp-plugin'),
                    'query'  => esc_html__('Query', 'themescamp-plugin'),
                ],
            ]
        );

        $this->add_control(
            'tcg_query_select_block',
            [
                'label' => esc_html__('Select Query Block', 'themescamp-plugin'),
                'type' => 'tcg-select2',
                'multiple' => false,
                'label_block' => true,
                'source_name' => 'block',
                'source_type' => 'tcg_teb',
                'meta_query' => [
                    [
                        'key' => 'template_type',
                        'value' => 'block',
                        'compare' => '='
                    ]
                ],
                'condition' => [
                    'tcg_select_type' => 'query'
                ]
            ]
        );

        $slides_repeater = new \Elementor\Repeater();

        $slides_repeater->add_control(
            'tcg_select_block',
            [
                'label' => esc_html__('Select Block', 'themescamp-plugin'),
                'type' => 'tcg-select2',
                'multiple' => false,
                'label_block' => true,
                'source_name' => 'block',
                'source_type' => 'tcg_teb',
                'meta_query' => [
                    [
                        'key' => 'template_type',
                        'value' => 'block',
                        'compare' => '='
                    ]
                ],
            ]
        );

        $slides_repeater->add_control(
            'edit_slider',
            [
                'label' => esc_html__('Edit Slide', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => esc_html__('Edit', 'themescamp-plugin'),
                'event' => 'tcgDynamicSlideEditor',
                'condition' => [
                    'tcg_select_block!' => '',
                ]
            ]
        );

        $this->add_control(
            'tcg_dynamic_slides_repeater',
            [
                'label' => esc_html__('Slides', 'themescamp-plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $slides_repeater->get_controls(),
                'default' => [
                    [
                        'project_title' => esc_html__('Hayden Co. Market Data Analysis', 'themescamp-plugin'),
                    ],
                    [
                        'project_title' => esc_html__('Hayden Co. Market Data Analysis', 'themescamp-plugin'),
                    ],
                    [
                        'project_title' => esc_html__('Hayden Co. Market Data Analysis', 'themescamp-plugin'),
                    ],
                ],
                'condition' => [
                    'tcg_select_type' => 'blocks'
                ]
            ]
        );

        $this->add_control(
            'add_slider',
            [
                'label' => esc_html__('Add Slide', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => esc_html__('Add Slide', 'themescamp-plugin'),
                'event' => 'tcgAddDynamicBlock',
            ]
        );

        $post_types = ControlsHelper::get_post_types();
        $post_types['by_id'] = __('Manual Selection', 'themescamp-plugin');

        $taxonomies = get_taxonomies([], 'objects');

        $this->add_control(
            'post_type',
            [
                'label' => __('Source', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => $post_types,
                'default' => key($post_types),
                'condition' => [
                    'tcg_select_type' => 'query'
                ]
            ]
        );

        $this->add_control(
            'tcg_global_dynamic_source_warning_text',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Warning', 'themescamp-core'),
                'content' => esc_html__('This option will only affect in <strong>Archive page of Elementor Theme Builder</strong> dynamically.', 'themescamp-core'),
                'condition' => [
                    'post_type' => 'source_dynamic',
                    'tcg_select_type' => 'query'
                ]
            ]
        );

        $this->add_control(
            'posts_ids',
            [
                'label' => __('Search & Select', 'themescamp-plugin'),
                'type' => 'tcg-select2',
                'options' => ControlsHelper::get_post_list(),
                'label_block' => true,
                'multiple'    => true,
                'source_name' => 'post_type',
                'source_type' => 'any',
                'condition' => [
                    'post_type' => 'by_id',
                    'tcg_select_type' => 'query'
                ],
            ]
        );

        $this->add_control(
            'authors',
            [
                'label' => __('Author', 'themescamp-plugin'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => [],
                'options' => ControlsHelper::get_authors_list(),
                'condition' => [
                    'post_type!' => ['by_id', 'source_dynamic'],
                    'tcg_select_type' => 'query'
                ],
            ]
        );

        foreach ($taxonomies as $taxonomy => $object) {
            if (!isset($object->object_type[0]) || !in_array($object->object_type[0], array_keys($post_types))) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label' => $object->label,
                    'type' => 'tcg-select2',
                    'label_block' => true,
                    'multiple' => true,
                    'source_name' => 'taxonomy',
                    'source_type' => $taxonomy,
                    'condition' => [
                        'post_type' => $object->object_type,
                        'tcg_select_type' => 'query'
                    ],
                ]
            );
        }

        $this->add_control(
            'post__not_in',
            [
                'label'       => __('Exclude', 'themescamp-plugin'),
                'type'        => 'tcg-select2',
                'label_block' => true,
                'multiple'    => true,
                'source_name' => 'post_type',
                'source_type' => 'any',
                'condition'   => [
                    'post_type!' => ['by_id', 'source_dynamic'],
                    'tcg_select_type' => 'query'
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
                'min' => '1',
                'condition' => [
                    'tcg_select_type' => 'query'
                ]
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
                'condition' => [
                    'orderby!' => 'rand',
                    'tcg_select_type' => 'query'
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => ControlsHelper::get_post_orderby_options(),
                'default' => 'date',
                'condition' => [
                    'tcg_select_type' => 'query'
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',
                'condition' => [
                    'tcg_select_type' => 'query'
                ]

            ]
        );

        $this->add_control(
            'display_for_active_slide',
            [
                'label' => esc_html__('Display Content Only on Active Slide', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'display_for_active_slide_note',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Important Note', 'themescamp-core'),
                'content' => esc_html__('Add class "dynamic-slider-content" to the content you want to hide and display only on the active slide.', 'themescamp-core'),
                'condition' => [
                    'display_for_active_slide' => 'true'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_settings',
            [
                'label' => __('Slider Settings', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50000,
                'step' => 100,
                'default' => 500,
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => esc_html__('Direction', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => esc_html__('horizontal', 'themescamp-plugin'),
                    'vertical' => esc_html__('vertical', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'horizontal',
            ]
        );

        $this->add_control(
            'effect',
            [
                'label' => esc_html__('Effect', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'slide' => esc_html__('Slide', 'themescamp-plugin'),
                    'fade' => esc_html__('Fade', 'themescamp-plugin'),
                    'parallax' => esc_html__('Parallax', 'themescamp-plugin'),
                    'cube' => esc_html__('Cube', 'themescamp-plugin'),
                    'coverflow' => esc_html__('Cover flow', 'themescamp-plugin'),
                    'flip' => esc_html__('Flip', 'themescamp-plugin'),
                    'cards' => esc_html__('Cards', 'themescamp-plugin'),
                    'material' => esc_html__('Material', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'slide',
            ]
        );

        $this->add_control(
            'effect_important_note',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Effect Important Note', 'themescamp-core'),
                'content' => esc_html__('Only Slide and Cover flow effects are support more than one slide per view.', 'themescamp-core'),
                'condition' => [
                    'effect!' => ['slide', 'coverflow']
                ]
            ]
        );

        $this->add_control(
            'cardsRotate',
            [
                'label' => esc_html__('Cards Rotate', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 50000,
                'step' => 1,
                'default' => 2,
                'condition' => [
                    'effect' => 'cards',
                ]
            ]
        );

        $this->add_control(
            'cardsOffset',
            [
                'label' => esc_html__('Cards Offset', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 50000,
                'step' => 1,
                'default' => 8,
                'condition' => [
                    'effect' => 'cards',
                ]
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'loop_important_note',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Loop Important Note', 'themescamp-core'),
                'content' => esc_html__('The number of slides must be more than the slides per view.', 'themescamp-core'),
                'condition' => [
                    'loop' => 'true'
                ]
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => esc_html__('Autoplay Delay', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50000,
                'step' => 100,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'true',
                ]
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'reverseDirection',
            [
                'label' => esc_html__('Reverse Direction', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'autoplay' => 'true',
                ]
            ]
        );

        $this->add_control(
            'disableOnInteraction',
            [
                'label' => esc_html__('Disable On Interaction', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'autoplay' => 'true',
                ]
            ]
        );

        $this->add_control(
            'centeredSlides',
            [
                'label' => esc_html__('Centered Slides', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'oneWayMovement',
            [
                'label' => esc_html__('One Way Movement', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'autoHeight',
            [
                'label' => esc_html__('Auto Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'mousewheel',
            [
                'label' => esc_html__('Slide With Mouse Wheel', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'keyboard',
            [
                'label' => esc_html__('Slide With Keyboard', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'arrows',
            [
                'label' => esc_html__('Slider Arrows', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Slider Pagination', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'paginationType',
            [
                'label' => esc_html__('Pagination Type', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'bullets' => esc_html__('Bullets', 'themescamp-plugin'),
                    'fraction' => esc_html__('Fraction', 'themescamp-plugin'),
                    'progressbar' => esc_html__('Progress Bar', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'bullets',
                'condition' => [
                    'pagination' => 'true'
                ]
            ]
        );

        $this->add_control(
            'arrows_pagination_container',
            [
                'label' => esc_html__('Arrow & Pagination Container', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'scrollbar',
            [
                'label' => esc_html__('Slider Scrollbar', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_arrows',
            [
                'label' => __('Slider Arrows', 'themescamp-plugin'),
                'condition' => [
                    'arrows' => 'true',
                ]
            ]
        );

        $this->add_control(
            'arrows_style',
            [
                'label' => esc_html__('Arrows Style', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'themescamp-plugin'),
                    'text' => esc_html__('Text', 'themescamp-plugin'),
                    'text-icon' => esc_html__('Text With Icon', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'next_arrow_icon',
            [
                'label' => __('Next Arrow Icon', 'themescamp-plugin'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'arrows_style' => ['icon', 'text-icon'],
                ]
            ]
        );

        $this->add_control(
            'prev_arrow_icon',
            [
                'label' => __('Prev Arrow Icon', 'themescamp-plugin'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-left',
                    'library' => 'solid',
                ],
                'condition' => [
                    'arrows_style' => ['icon', 'text-icon'],
                ]
            ]
        );

        $this->add_control(
            'next_arrow_text',
            [
                'label' => esc_html__('Next Arrow Text', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Next', 'themescamp-plugin'),
                'placeholder' => esc_html__('Type your text here', 'themescamp-plugin'),
                'condition' => [
                    'arrows_style' => ['text', 'text-icon'],
                ]
            ]
        );

        $this->add_control(
            'prev_arrow_text',
            [
                'label' => esc_html__('Prev Arrow Text', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Prev', 'themescamp-plugin'),
                'placeholder' => esc_html__('Type your text here', 'themescamp-plugin'),
                'condition' => [
                    'arrows_style' => ['text', 'text-icon'],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_responsive',
            [
                'label' => __('Slider Responsive', 'themescamp-plugin'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'breakpoint',
            [
                'label' => esc_html__('Break Point', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'default' => 992,
            ]
        );

        $repeater->add_control(
            'spaceBetween',
            [
                'label' => esc_html__('Space Between', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 550,
                'step' => 1,
                'default' => 30,
            ]
        );

        $repeater->add_control(
            'slidesPerView_auto',
            [
                'label' => esc_html__('Auto Slides Per View', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-plugin'),
                'label_off' => esc_html__('Off', 'themescamp-plugin'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $repeater->add_control(
            'slidesPerView',
            [
                'label' => esc_html__('Slides Per View', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 1,
                'condition' => [
                    'slidesPerView_auto!' => 'true'
                ]
            ]
        );

        $this->add_control(
            'responsive_settings',
            [
                'label' => esc_html__('Custom Break Points', 'themescamp-plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'breakpoint' => 1200,
                        'slidesPerView' => 1,
                        'spaceBetween' => 0
                    ],
                    [
                        'breakpoint' => 992,
                        'slidesPerView' => 1,
                        'spaceBetween' => 0
                    ],
                    [
                        'breakpoint' => 600,
                        'slidesPerView' => 1,
                        'spaceBetween' => 0
                    ],
                ],
                'title_field' => 'screen size {{{ breakpoint }}}px',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_container_style',
            [
                'label' => __('Slider Container Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'slider_container_overflow',
            [
                'label' => esc_html__('Slider Container Overflow', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'hidden' => esc_html__('Hidden', 'themescamp-plugin'),
                    'visible' => esc_html__('Visible', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'hidden',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-container' => 'overflow: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'slider_container_style',
            [
                'label' => esc_html__('Slider Container Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'block_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slide > div, {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slide, {{WRAPPER}} .tcg-dynamic-slider .swiper-slide' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slides_style',
            [
                'label' => __('Slides Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'slides_height',
            [
                'label' => esc_html__('Slide Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slides_content_height',
            [
                'label' => esc_html__('Content Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .tcg-dynamic-slide' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content .tcg-dynamic-slide' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide > div > div' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content > div > div' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide > div > div > div' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content > div > div > div' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slides_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slides_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'tabs_slides_style'
        );

        $this->start_controls_tab(
            'style_slides_normal_tab',
            [
                'label' => esc_html__('Normal', 'themescamp-plugin'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'slides_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide, {{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content',
            ]
        );

        $this->add_responsive_control(
            'slides_border_radius',
            [
                'label' => esc_html__('Slides Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slides_opacity_normal',
            [
                'label' => esc_html__( 'Opacity', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide' => 'opacity: {{SIZE}} !important;',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content' => 'opacity: {{SIZE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'slides_index_normal',
            [
                'label' => esc_html__( 'z-index', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide' => 'z-index: {{SIZE}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content' => 'z-index: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'slides_content_scale_normal',
            [
                'label' => esc_html__( 'Content Scale', 'themescamp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .tcg-dynamic-slide' => 'transform: scale({{SIZE}});',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content .tcg-dynamic-slide' => 'transform: scale({{SIZE}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'prev_slides_transform_origin',
            [
                'label' => esc_html__( 'Previous Content Transform', 'themescamp-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'themescamp-elements' ),
                    'center left' => esc_html__( 'Center Left', 'themescamp-elements' ),
                    'center right' => esc_html__( 'Center Right', 'themescamp-elements' ),
                    'top center' => esc_html__( 'Top Center', 'themescamp-elements' ),
                    'top left' => esc_html__( 'Top Left', 'themescamp-elements' ),
                    'top right' => esc_html__( 'Top Right', 'themescamp-elements' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'themescamp-elements' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'themescamp-elements' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'themescamp-elements' ),
                ],
                'default' => 'center center',
                'condition' => ['slides_content_scale_normal[size]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-prev .tcg-dynamic-slide' => 'transform-origin: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-prev .swiper-material-content .tcg-dynamic-slide' => 'transform-origin: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'next_slides_transform_origin',
            [
                'label' => esc_html__( 'Next Content Transform', 'themescamp-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'themescamp-elements' ),
                    'center left' => esc_html__( 'Center Left', 'themescamp-elements' ),
                    'center right' => esc_html__( 'Center Right', 'themescamp-elements' ),
                    'top center' => esc_html__( 'Top Center', 'themescamp-elements' ),
                    'top left' => esc_html__( 'Top Left', 'themescamp-elements' ),
                    'top right' => esc_html__( 'Top Right', 'themescamp-elements' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'themescamp-elements' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'themescamp-elements' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'themescamp-elements' ),
                ],
                'default' => 'center center',
                'condition' => ['slides_content_scale_normal[size]!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-next .tcg-dynamic-slide' => 'transform-origin: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-next .swiper-material-content .tcg-dynamic-slide' => 'transform-origin: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'slides_content_transition',
            [
                'label' => esc_html__( 'Content Transition', 'themescamp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .tcg-dynamic-slide' => 'transition: all {{SIZE}}s ease;',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content .tcg-dynamic-slide' => 'transition: all {{SIZE}}s ease;',
                ],
            ]
        );
        $this->add_control(
            'effect_important_note_content_background',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Content & Background Important Note', 'themescamp-core'),
                'content' => esc_html__('This Will Override Any Color & Background In The Element', 'themescamp-core'),
                'condition' => [
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dynamic_slide_background_color',
                'label' => esc_html__('Background', 'themescamp-elements'),
                'types' => [ 'classic','gradient','tcg_gradient' ],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide',
            ]
        );
        $this->add_control(
            'content_color_normal',
            [
                'label' => esc_html__('Content Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .tcg-dynamic-slide *' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide .swiper-material-content .tcg-dynamic-slide *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_slides_hover_tab',
            [
                'label' => esc_html__('Hover', 'themescamp-plugin'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'slides_border_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide:hover, {{WRAPPER}} .tcg-dynamic-slider .swiper-slide:hover .swiper-material-content',
            ]
        );

        $this->add_responsive_control(
            'slides_border_radius_hover',
            [
                'label' => esc_html__('Slides Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide:hover .swiper-material-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'slides_index_hover',
            [
                'label' => esc_html__( 'z-index', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide:hover' => 'z-index: {{SIZE}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide:hover .swiper-material-content' => 'z-index: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_slides_active_tab',
            [
                'label' => esc_html__('Active', 'themescamp-plugin'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'slides_border_active',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active, {{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .swiper-material-content',
            ]
        );

        $this->add_responsive_control(
            'slides_border_radius_active',
            [
                'label' => esc_html__('Slides Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .swiper-material-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slides_opacity_active',
            [
                'label' => esc_html__( 'Opacity', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active' => 'opacity: {{SIZE}} !important;',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .swiper-material-content' => 'opacity: {{SIZE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'slides_index_active',
            [
                'label' => esc_html__( 'z-index', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active' => 'z-index: {{SIZE}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .swiper-material-content' => 'z-index: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'slides_content_scale_active',
            [
                'label' => esc_html__( 'Content Scale', 'themescamp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .tcg-dynamic-slide' => 'transform: scale({{SIZE}});',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .swiper-material-content .tcg-dynamic-slide' => 'transform: scale({{SIZE}});',
                ],
            ]
        );
        $this->add_control(
            'effect_important_note_content_background_active',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Content & Background Important Note', 'themescamp-core'),
                'content' => esc_html__('This Will Override Any Color & Background In The Element', 'themescamp-core'),
                'condition' => [
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dynamic_slide_background_color_active',
                'label' => esc_html__('Background', 'themescamp-elements'),
                'types' => [ 'classic','gradient','tcg_gradient' ],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active',
            ]
        );
        $this->add_control(
            'content_color_active',
            [
                'label' => esc_html__('Content Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .tcg-dynamic-slide *' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-slide.swiper-slide-active .swiper-material-content .tcg-dynamic-slide *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_arrows_style',
            [
                'label' => __('Arrows Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrows' => 'true',
                ]
            ]
        );

        $this->add_control(
            'arrows_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'absolute',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_arrows_style'
        );

        $this->start_controls_tab(
            'style_arrows_normal_tab',
            [
                'label' => esc_html__('Normal', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'arrows_arrow_color',
            [
                'label' => esc_html__('Arrow Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_icon_size',
            [
                'label' => esc_html__('Icon Size', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'arrows_arrow_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows .tcg-dynamic-slider-arrow-text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'arrows_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows',
                'exclude' => ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'arrows_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows',
            ]
        );

        $this->add_responsive_control(
            'arrows_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrows_box_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_arrows_hover_tab',
            [
                'label' => esc_html__('Hover', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'arrows_arrow_color_hover',
            [
                'label' => esc_html__('Arrow Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'arrows_arrow_typography_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows:hover .tcg-dynamic-slider-arrow-text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'arrows_background_hover',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows:hover',
                'exclude' => ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'arrows_border_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows:hover',
            ]
        );

        $this->add_responsive_control(
            'arrows_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrows_box_shadow_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_position',
            [
                'label' => esc_html__('Arrows Position', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'arrows_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'arrows_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'arrows_offset_orientation_v' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_z_index',
            [
                'label' => esc_html__('Z-Index', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_each_arrow_style',
            [
                'label' => __('Each Arrow Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrows' => 'true',
                ]
            ]
        );

        $this->add_control(
            'next_arrow_options',
            [
                'label' => esc_html__('Next Arrow Options', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'next_arrow_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'absolute',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'next_arrow_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'next_arrow_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_next_arrow_style'
        );

        $this->start_controls_tab(
            'style_next_arrow_normal_tab',
            [
                'label' => esc_html__('Normal', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'next_arrow_color',
            [
                'label' => esc_html__('Arrow Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'next_arrow_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next .tcg-dynamic-slider-arrow-text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'next_arrow_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next',
                'exclude' => ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'next_arrow_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next',
            ]
        );

        $this->add_responsive_control(
            'next_arrow_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'next_arrow_box_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_next_arrow_hover_tab',
            [
                'label' => esc_html__('Hover', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'next_arrow_color_hover',
            [
                'label' => esc_html__('Arrow Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'next_arrow_typography_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next:hover .tcg-dynamic-slider-arrow-text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'next_arrow_background_hover',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next:hover',
                'exclude' => ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'next_arrow_border_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next:hover',
            ]
        );

        $this->add_responsive_control(
            'next_arrow_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'next_arrow_box_shadow_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'next_arrow_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'next_arrow_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'next_arrow_position',
            [
                'label' => esc_html__('Arrows Position', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'next_arrow_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'next_arrow_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'next_arrow_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'next_arrow_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'next_arrow_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'next_arrow_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'next_arrow_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'next_arrow_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'next_arrow_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'next_arrow_offset_orientation_v' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'next_arrow_z_index',
            [
                'label' => esc_html__('Z-Index', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-next' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'prev_arrow_options',
            [
                'label' => esc_html__('Prev Arrow Options', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'prev_arrow_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'absolute',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_prev_arrow_style'
        );

        $this->start_controls_tab(
            'style_prev_arrow_normal_tab',
            [
                'label' => esc_html__('Normal', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'prev_arrow_color',
            [
                'label' => esc_html__('Arrow Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'prev_arrow_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev .tcg-dynamic-slider-arrow-text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'prev_arrow_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev',
                'exclude' => ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'prev_arrow_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev',
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'prev_arrow_box_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_prev_arrow_hover_tab',
            [
                'label' => esc_html__('Hover', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'prev_arrow_color_hover',
            [
                'label' => esc_html__('Arrow Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'prev_arrow_typography_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev:hover .tcg-dynamic-slider-arrow-text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'prev_arrow_background_hover',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev:hover',
                'exclude' => ['image']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'prev_arrow_border_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev:hover',
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'prev_arrow_box_shadow_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'prev_arrow_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'prev_arrow_position',
            [
                'label' => esc_html__('Arrows Position', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'prev_arrow_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'prev_arrow_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'prev_arrow_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'prev_arrow_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'prev_arrow_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'prev_arrow_offset_orientation_v' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'prev_arrow_z_index',
            [
                'label' => esc_html__('Z-Index', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .tcg-dynamic-slider-arrows.swiper-button-prev' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination_progress_bar_style',
            [
                'label' => __('Pagination Progress Bar Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination' => 'true',
                    'paginationType' => 'progressbar'
                ]
            ]
        );
        $this->add_control(
            'progressbar_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'absolute',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'position: {{VALUE}};',
                ],
            ]
        );
        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'progressbar_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'progressbar_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'progressbar_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'progressbar_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'progressbar_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'progressbar_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'progressbar_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'progressbar_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'progressbar_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'progressbar_offset_orientation_v' => 'end',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_progress_bar_size',
            [
                'label' => esc_html__('Size', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar.swiper-pagination-horizontal' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar.swiper-pagination-vertical' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'progress_bar_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; width: calc(100% - ({{RIGHT}}{{UNIT}} + {{LEFT}}{{UNIT}}));',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar.swiper-progressbar-vertical' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: calc(100% - (({{TOP}}{{UNIT}} + {{BOTTOM}}{{UNIT}}) * 3));',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_progress_bar_progress',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar .swiper-pagination-progressbar-fill',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html_x('Progress Bar Color', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_progress_bar_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html_x('Progress Bar Background', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pagination_progress_bar_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar',
            ]
        );

        $this->add_responsive_control(
            'pagination_progress_bar_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination_bullets_style',
            [
                'label' => __('Pagination Bullets Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination' => 'true',
                    'paginationType' => 'bullets'
                ]
            ]
        );

        $this->add_control(
            'pagination_bullets_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'absolute',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets' => 'position: {{VALUE}};',
                ],
            ]
        );

        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'pagination_bullets_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'pagination_bullets_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-horizontal' => 'left: {{SIZE}}{{UNIT}}; right: unset; transform: translateX(50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-horizontal' => 'right: {{SIZE}}{{UNIT}}; left: unset; transform: translateX(-50%);',
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-vertical' => 'left: {{SIZE}}{{UNIT}}; right: unset; transform: translateY(50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-vertical' => 'right: {{SIZE}}{{UNIT}}; left: unset; transform: translateY(50%);',
                ],
                'condition' => [
                    'pagination_bullets_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullets_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-horizontal' => 'right: {{SIZE}}{{UNIT}}; left: unset; transform: translateX(-50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-horizontal' => 'left: {{SIZE}}{{UNIT}}; right: unset; transform: translateX(50%);',
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-vertical' => 'right: {{SIZE}}{{UNIT}}; left: unset; transform: translateY(50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets.swiper-pagination-vertical' => 'left: {{SIZE}}{{UNIT}}; right: unset; transform: translateY(50%);',
                ],
                'condition' => [
                    'pagination_bullets_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'pagination_bullets_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'pagination_bullets_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets' => 'top: {{SIZE}}{{UNIT}}; bottom: unset; transform: translateY(50%) translateX(50%);',
                ],
                'condition' => [
                    'pagination_bullets_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullets_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}}; top: unset; transform: translateY(-50%) translateX(50%);',
                ],
                'condition' => [
                    'pagination_bullets_offset_orientation_v' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullets_z_index',
            [
                'label' => esc_html__('Z-Index', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_space',
            [
                'label' => esc_html__('Space', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pagination_bullets_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets',
            ]
        );

        $this->add_responsive_control(
            'pagination_bullets_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_pagination_bullets_style'
        );

        $this->start_controls_tab(
            'style_pagination_bullets_normal_tab',
            [
                'label' => esc_html__('Normal', 'themescamp-plugin'),
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_size',
            [
                'label' => esc_html__('Size', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_bullet_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html_x('Bullet Background', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_opacity',
            [
                'label' => esc_html__('Bullet Opacity', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_bullet_outline',
            [
                'label' => esc_html__('Outline', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-plugin'),
                'label_on' => esc_html__('Custom', 'themescamp-plugin'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'pagination_bullet_outline_type',
            [
                'label' => esc_html__('Border Type', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-plugin'),
                    'none' => esc_html__('None', 'themescamp-plugin'),
                    'solid' => esc_html__('Solid', 'themescamp-plugin'),
                    'double' => esc_html__('Double', 'themescamp-plugin'),
                    'dotted' => esc_html__('Dotted', 'themescamp-plugin'),
                    'dashed' => esc_html__('Dashed', 'themescamp-plugin'),
                    'groove' => esc_html__('Groove', 'themescamp-plugin'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'outline-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_outline_width',
            [
                'label' => esc_html__('Bullet Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'pagination_bullet_outline_type!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'outline-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_outline_color',
            [
                'label' => esc_html__('Border Color', 'themescamp-plugin'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'outline-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_bullet_outline_type!' => ['', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_outline_offset',
            [
                'label' => esc_html__('Bullet Offset', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'pagination_bullet_outline_type!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'outline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pagination_bullet_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet',
            ]
        );

        $this->add_responsive_control(
            'pagination_bullet_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'pagination_bullets_dark_mode_heading',
            [
                'label' => esc_html__('Dark Mode Controls', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_bullet_background_dark_mode',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'gradient_angle' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'gradient_position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                    'position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                        ],
                    ],
                    'xpos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'ypos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'attachment' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                            '} body.tcg-dark-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                        ],
                    ],
                    'repeat' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                        ],
                    ],
                    'size' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                        ],
                    ],
                    'bg_width' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                        ],
                    ],
                    'video_fallback' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                        ],
                    ],
                    'background' => [
                        'label' => esc_html_x('Bullet Background', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_pagination_bullets_active_tab',
            [
                'label' => esc_html__('Active', 'themescamp-plugin'),
            ]
        );

        $this->add_responsive_control(
            'pagination_active_bullet_size',
            [
                'label' => esc_html__('Size', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_active_bullet_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_active_bullet_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html_x('Active Bullet Color', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'pagination_active_bullet_opacity',
            [
                'label' => esc_html__('Bullet Opacity', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_active_bullet_outline',
            [
                'label' => esc_html__('Outline', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-plugin'),
                'label_on' => esc_html__('Custom', 'themescamp-plugin'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'pagination_active_bullet_outline_type',
            [
                'label' => esc_html__('Border Type', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-plugin'),
                    'none' => esc_html__('None', 'themescamp-plugin'),
                    'solid' => esc_html__('Solid', 'themescamp-plugin'),
                    'double' => esc_html__('Double', 'themescamp-plugin'),
                    'dotted' => esc_html__('Dotted', 'themescamp-plugin'),
                    'dashed' => esc_html__('Dashed', 'themescamp-plugin'),
                    'groove' => esc_html__('Groove', 'themescamp-plugin'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'outline-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_active_bullet_outline_width',
            [
                'label' => esc_html__('Bullet Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'pagination_active_bullet_outline_type!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'outline-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_active_bullet_outline_color',
            [
                'label' => esc_html__('Border Color', 'themescamp-plugin'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'outline-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_active_bullet_outline_type!' => ['', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_active_bullet_outline_offset',
            [
                'label' => esc_html__('Bullet Offset', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'pagination_active_bullet_outline_type!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'outline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pagination_active_bullet_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active',
            ]
        );

        $this->add_responsive_control(
            'pagination_active_bullet_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'pagination_bullets_dark_mode_heading_active',
            [
                'label' => esc_html__('Dark Mode Controls', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_bullet_background_dark_mode_active',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'gradient_angle' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'gradient_position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                    'position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                        ],
                    ],
                    'xpos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'ypos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'attachment' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                            '} body.tcg-dark-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                        ],
                    ],
                    'repeat' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                        ],
                    ],
                    'size' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                        ],
                    ],
                    'bg_width' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                        ],
                    ],
                    'video_fallback' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                        ],
                    ],
                    'background' => [
                        'label' => esc_html_x('Active Bullet Background', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pagination_bullets_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_bullets_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-bullets' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination_fraction_style',
            [
                'label' => __('Pagination Fraction Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination' => 'true',
                    'paginationType' => 'fraction'
                ]
            ]
        );
        $this->add_responsive_control(
            'section_pagination_fraction_width',
            [
                'label' => esc_html__( 'Width', 'themescamp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'pagination_fraction_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'pagination_fraction_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'right: {{SIZE}}{{UNIT}}; transform: translateX(50%);',
                ],
                'condition' => [
                    'pagination_fraction_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_fraction_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'right: {{SIZE}}{{UNIT}}; transform: translateX(50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
                ],
                'condition' => [
                    'pagination_fraction_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'pagination_fraction_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'pagination_fraction_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'top: {{SIZE}}{{UNIT}}; bottom: unset; transform: translateY(50%);',
                ],
                'condition' => [
                    'pagination_fraction_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_fraction_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}}; top: unset; transform: translateY(-50%);',
                ],
                'condition' => [
                    'pagination_fraction_offset_orientation_v' => 'end',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_fraction_z_index',
            [
                'label' => esc_html__('Z-Index', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_pagination_fraction_style'
        );

        $this->start_controls_tab(
            'style_pagination_fraction_normal_tab',
            [
                'label' => esc_html__('Normal', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'pagination_fraction_color',
            [
                'label' => esc_html__('Text Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_fraction_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'pagination_fraction_text_stroke',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'pagination_fraction_text_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction',
            ]
        );

        $this->add_control(
            'pagination_fraction_blend_mode',
            [
                'label' => esc_html__('Blend Mode', 'elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Normal', 'elementor'),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'difference' => 'Difference',
                    'exclusion' => 'Exclusion',
                    'hue' => 'Hue',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_pagination_fraction_current_tab',
            [
                'label' => esc_html__('Current', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'pagination_fraction_current_color',
            [
                'label' => esc_html__('Text Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-current' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_fraction_current_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-current',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'pagination_fraction_current_text_stroke',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-current',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'pagination_fraction_current_text_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-current',
            ]
        );

        $this->add_control(
            'pagination_fraction_current_blend_mode',
            [
                'label' => esc_html__('Blend Mode', 'elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Normal', 'elementor'),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'difference' => 'Difference',
                    'exclusion' => 'Exclusion',
                    'hue' => 'Hue',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-current' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'pagination_fraction_current_margin',
            [
                'label' => esc_html__('Current Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-current' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_pagination_fraction_total_tab',
            [
                'label' => esc_html__('Total', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'pagination_fraction_total_color',
            [
                'label' => esc_html__('Text Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-total' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_fraction_total_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-total',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'pagination_fraction_total_text_stroke',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-total',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'pagination_fraction_total_text_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-total',
            ]
        );

        $this->add_control(
            'pagination_fraction_total_blend_mode',
            [
                'label' => esc_html__('Blend Mode', 'elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Normal', 'elementor'),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'difference' => 'Difference',
                    'exclusion' => 'Exclusion',
                    'hue' => 'Hue',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-total' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'pagination_fraction_total_margin',
            [
                'label' => esc_html__('Total Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-pagination-fraction .swiper-pagination-total' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_scroll_bar_style',
            [
                'label' => __('Scroll Bar Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'scrollbar' => 'true',
                ]
            ]
        );

        $this->add_control(
            'pagination_scroll_bar_position',
            [
                'label' => esc_html__('Scroll Bar Position', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_scroll_bar_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'pagination_scroll_bar_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal' => 'left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, {{WRAPPER}} body.rtl .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal' => 'right: {{SIZE}}{{UNIT}}; transform: translateX(50%);',
                ],
                'condition' => [
                    'pagination_scroll_bar_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_scroll_bar_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal' => 'right: {{SIZE}}{{UNIT}}; transform: translateX(50%);',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, {{WRAPPER}} body.rtl .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal' => 'left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
                ],
                'condition' => [
                    'pagination_scroll_bar_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'pagination_scroll_bar_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'pagination_scroll_bar_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal' => 'top: {{SIZE}}{{UNIT}}; bottom: unset; transform: translateY(50%);',
                ],
                'condition' => [
                    'pagination_scroll_bar_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_scroll_bar_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal' => 'bottom: {{SIZE}}{{UNIT}}; top: unset; transform: translateY(-50%);',
                ],
                'condition' => [
                    'pagination_scroll_bar_offset_orientation_v' => 'end',
                ],
            ]
        );

        $this->add_control(
            'pagination_scroll_bar_bg',
            [
                'label' => esc_html__('Scroll Bar Background', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'scroll_bar_progress',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar .swiper-scrollbar-drag',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html_x('Progress Bar Color', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'scroll_bar_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html_x('Progress Bar Background', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );

        $this->add_control(
            'pagination_scroll_bar_styling',
            [
                'label' => esc_html__('Scroll Bar Styling', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pagination_scroll_bar_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal, {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal .swiper-scrollbar-drag' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical .swiper-scrollbar-drag' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_scroll_bar_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal, {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-horizontal .swiper-scrollbar-drag' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical, {{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.scrollbar-vertical .swiper-scrollbar-drag' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_bar_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.swiper-scrollbar-horizontal' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; width: calc(100% - ({{RIGHT}}{{UNIT}} + {{LEFT}}{{UNIT}}));',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar.swiper-scrollbar-vertical' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: calc(100% - (({{TOP}}{{UNIT}} + {{BOTTOM}}{{UNIT}}) * 3));',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'scroll_bar_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar',
            ]
        );

        $this->add_responsive_control(
            'scroll_bar_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-slider .swiper-scrollbar .swiper-scrollbar-drag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'arrows_pagination_container_style',
            [
                'label' => __('Arrows Pagination Container Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrows_pagination_container' => 'true',
                ]
            ]
        );

        $this->add_control(
            'arrows_pagination_container_bg',
            [
                'label' => esc_html__('Container Background', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'arrows_pagination_container_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container',
            ]
        );

        $this->add_control(
            'arrows_pagination_container_position',
            [
                'label' => esc_html__('Container Position', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows_pagination_container_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'absolute',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_pagination_container_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'arrows_pagination_container_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'arrows_pagination_container_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'arrows_pagination_container_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'arrows_pagination_container_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'arrows_pagination_container_offset_orientation_v' => 'end',
                ],
            ]
        );

        $this->add_control(
            'arrows_pagination_container_styling',
            [
                'label' => esc_html__('Container Styling', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'arrows_pagination_container_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container',
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrows_pagination_container_box_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container',
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_pagination_container_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-slider .arrows-pagination-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        //resposive setttings
        $resposive_settings = [];
        $slider_settings = [];

        foreach ($settings['responsive_settings'] as $index => $item) {
            $resposive_settings[$item['breakpoint']] = [
                'slidesPerView' => $item['slidesPerView_auto'] === 'true' ? 'auto' : $item['slidesPerView'],
                'spaceBetween' => $item['spaceBetween'],
            ];
        };

        $slider_settings = [
            'breakpoints' => $resposive_settings,
            'speed' => $settings['speed'],
            'direction' => $settings['direction'],
            'autoHeight' => $settings['autoHeight'],
            'effect' => $settings['effect'],
            'loop' => $settings['loop'],
            'centeredSlides' => $settings['centeredSlides'],
            'oneWayMovement' => $settings['oneWayMovement'],
            'keyboard' => $settings['keyboard'],
            'mousewheel' => $settings['mousewheel'],
            'paginationType' => $settings['paginationType'],
            'cardsOffset' => $settings['cardsOffset'],
            'cardsRotate' => $settings['cardsRotate']
        ];

        if ($settings['autoplay'] === 'true') {
            $slider_settings['autoplay'] = [
                'delay' => $settings['autoplay_delay'],
                'reverseDirection' => $settings['reverseDirection'],
                'disableOnInteraction' => $settings['disableOnInteraction']
            ];
        }

        $max_slider_id = uniqid('tcg-dynamic-slider-');

        $query_settings = $this->get_settings();
        $query_settings = ControlsHelper::fix_old_query($query_settings);
        $args = ControlsHelper::get_query_args($query_settings);
        $args = ControlsHelper::get_dynamic_args($query_settings, $args);
        $query = new \WP_Query($args);


?>

        <div id="<?php echo esc_attr($max_slider_id) ?>" class="tcg-dynamic-slider<?php if($settings['display_for_active_slide'] == 'true') echo esc_attr(' dynamic-slider-active-content'); ?>" data-tcg-dynamic-slider='<?php echo esc_attr(json_encode($slider_settings)); ?>'>

            <div class="swiper-container <?php if ($settings['effect'] == 'parallax') echo esc_attr('tcg-dynamic-parallax-slider'); ?>">
                <div class="swiper-wrapper">
                    <?php if ($settings['tcg_select_type'] == 'blocks') : ?>
                        <?php foreach ($settings['tcg_dynamic_slides_repeater'] as $index => $slide) : if (!empty($slide['tcg_select_block'])) : ?>
                                <div class="swiper-slide">
                                    <div class="tcg-dynamic-slide <?php echo esc_attr($slide['tcg_select_block']); ?>">
                                        <?php

                                        $frontend = new \Elementor\Frontend();
                                        $slide_ID  = $slide['tcg_select_block'];

                                        echo $frontend->get_builder_content_for_display($slide_ID);

                                        ?>
                                    </div>
                                </div>
                            <?php endif;
                        endforeach;
                    elseif ($settings['tcg_select_type'] == 'query') :
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $frontend = new \Elementor\Frontend();
                                $block_ID  = $settings['tcg_query_select_block']; ?>
                                <div class="swiper-slide">
                                    <?php if($settings['effect'] == 'material'): ?>
                                    <div class="swiper-material-wrapper">
                                        <div class="swiper-material-content">
                                    <?php endif; ?>
                                            <div class="tcg-dynamic-slide <?php echo esc_attr($settings['tcg_query_select_block']); ?>" data-swiper-material-scale="1.25">
                                                <?php
                                                echo $frontend->get_builder_content_for_display($block_ID); ?>
                                            </div>
                                    <?php if($settings['effect'] == 'material'): ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                    <?php
                            };
                        } else {
                            _e('<p class="no-posts-found">No posts found!</p>', 'themescamp-plugin');
                        }
                        wp_reset_postdata();
                    endif; ?>
                </div>
            </div>

            <?php if ($settings['arrows_pagination_container'] === 'true') : echo '<div class="arrows-pagination-container">';
            endif; ?>

            <?php if ($settings['pagination'] === 'true') : ?>
                <!-- If we need pagination -->
                <div class="swiper-pagination swiper-pagination-<?= $settings['direction'] ?>"></div>
            <?php endif; ?>

            <?php if ($settings['arrows'] === 'true') : ?>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev tcg-dynamic-slider-arrows">
                    <?php if ($settings['arrows_style'] === 'icon') :
                        Icons_Manager::render_icon($settings['prev_arrow_icon'], ['aria-hidden' => 'true']);
                    elseif ($settings['arrows_style'] === 'text') :
                        echo wp_kses_post($settings['prev_arrow_text']);
                    elseif ($settings['arrows_style'] === 'text-icon') :
                        Icons_Manager::render_icon($settings['prev_arrow_icon'], ['aria-hidden' => 'true']);
                        echo '<span class="tcg-dynamic-slider-arrow-text">' . wp_kses_post($settings['prev_arrow_text']) . '</span>';
                    endif; ?>
                </div>
                <div class="swiper-button-next tcg-dynamic-slider-arrows">
                    <?php if ($settings['arrows_style'] === 'icon') :
                        Icons_Manager::render_icon($settings['next_arrow_icon'], ['aria-hidden' => 'true']);
                    elseif ($settings['arrows_style'] === 'text') :
                        echo wp_kses_post($settings['next_arrow_text']);
                    elseif ($settings['arrows_style'] === 'text-icon') :
                        echo '<span class="tcg-dynamic-slider-arrow-text">' . wp_kses_post($settings['next_arrow_text']) . '</span>';
                        Icons_Manager::render_icon($settings['next_arrow_icon'], ['aria-hidden' => 'true']);
                    endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($settings['arrows_pagination_container'] === 'true') : echo '</div>';
            endif; ?>

            <?php if ($settings['scrollbar'] === 'true') : ?>
                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar scrollbar-<?= $settings['direction'] ?>"></div>
            <?php endif; ?>

        </div>

    <?php
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function content_template()
    {
    ?>
<?php
    }
}
