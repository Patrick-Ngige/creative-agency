<?php
namespace InfolioPlugin\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Infolio_Heading extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve heading widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'infolio-heading';
    }

    /**
     * Get widget title.
     *
     * Retrieve heading widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Infolio Heading', 'infolio_plg');
    }
    /**
     * Get widget icon.
     *
     * Retrieve heading widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-heading';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the heading widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['infolio-elements'];
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'heading', 'title', 'text' ];
    }

    public function get_script_depends() {
        return [ 'infolio-background-image'];
    }

    /**
     * Register heading widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Infolio Title', 'infolio_plg' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'infolio_plg' ),
                'type' => Controls_Manager::TEXTAREA,
                'ai' => [
                    'type' => 'text',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'Enter your title', 'infolio_plg' ),
                'default' => __( 'Add Your Heading Text Here', 'infolio_plg' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'infolio_plg' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__( 'Size', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'infolio_plg' ),
                    'small' => esc_html__( 'Small', 'infolio_plg' ),
                    'medium' => esc_html__( 'Medium', 'infolio_plg' ),
                    'large' => esc_html__( 'Large', 'infolio_plg' ),
                    'xl' => esc_html__( 'XL', 'infolio_plg' ),
                    'xxl' => esc_html__( 'XXL', 'infolio_plg' ),
                ],
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label' => esc_html__( 'HTML Tag', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'infolio_plg' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'separator_border1',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
//        infolio style options
        $this->add_control(
            'view',
            [
                'label' => esc_html__( 'View', 'infolio_plg' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'rotate_animation',
            [
                'label'         => __( 'Rotate Animation', 'infolio_plg' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'infolio_plg' ),
                'label_off'     => __( 'No', 'infolio_plg' ),
                'return_value'  => 'yes',
                'default'  		=> 'no',
            ]
        );
        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'img',
            [
                'label' => __('Choose Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
                'condition' => ['background_image' => 'yes']
            ]
        );

        $this->add_control(
            'text_wrap',
            [
                'label' => __('Text No Wrap', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'after_icon',
            [
                'label'         => __( 'Icon', 'infolio_plg' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'infolio_plg' ),
                'label_off'     => __( 'No', 'infolio_plg' ),
                'return_value'  => 'yes',
                'default'  		=> 'no',
            ]
        );
        $this->add_control(
            'icon_block_responsive',
            [
                'label' => __('Responsive Icon Display', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'condition'=>['after_icon'=>'yes'],
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'default'  		=> 'yes',
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'after_icon' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'heading_color' );
        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_dark_mode',
            [
                'label' => esc_html__( 'Text Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-heading' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .infolio-heading' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'hover_title_color',
            [
                'label' => esc_html__( 'Hover Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_hover_dark_mode',
            [
                'label' => esc_html__( 'Hover Text Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-heading:hover' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-heading:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'separator_border2',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
            'text_breakline',
            [
                'label' => __('Make Break Line Tag Hidden', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-heading',
            ]
        );

        $this->add_control(
            'heading_opacity',
            [
                'label' => esc_html__( 'Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_opacity_dark',
            [
                'label' => esc_html__( 'Opacity (Dark Mode)', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .elementor-icon-list-item > .elementor-icon-list-text' => 'opacity: {{SIZE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .elementor-icon-list-item > .elementor-icon-list-text' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .infolio-heading',
            ]
        );
        $this->add_control(
            'text_stroke_dark',
            [
                'label' => esc_html__( 'Text Stroke (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-heading' => '-webkit-text-stroke-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-heading' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .infolio-heading',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label' => esc_html__( 'Blend Mode', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Normal', 'infolio_plg' ),
                    'multiply' => esc_html__( 'Multiply', 'infolio_plg' ),
                    'screen' => esc_html__( 'Screen', 'infolio_plg' ),
                    'overlay' => esc_html__( 'Overlay', 'infolio_plg' ),
                    'darken' => esc_html__( 'Darken', 'infolio_plg' ),
                    'lighten' => esc_html__( 'Lighten', 'infolio_plg' ),
                    'color-dodge' => esc_html__( 'Color Dodge', 'infolio_plg' ),
                    'saturation' => esc_html__( 'Saturation', 'infolio_plg' ),
                    'color' => esc_html__( 'Color', 'infolio_plg' ),
                    'difference' => esc_html__( 'Difference', 'infolio_plg' ),
                    'exclusion' => esc_html__( 'Exclusion', 'infolio_plg' ),
                    'hue' => esc_html__( 'Hue', 'infolio_plg' ),
                    'luminosity' => esc_html__( 'Luminosity', 'infolio_plg' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );
        $this->add_responsive_control(
            'offset_x',
            [
                'label' => esc_html__( 'Offset X', 'infolio_plg' ),
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
                'default' => [
                    'size' => '-25',
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading .infolio-lins ' => 'left: {{SIZE}}{{UNIT}}',
                    ],
                'condition' => [
                    'heading_image' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'offset_y',
            [
                'label' => esc_html__( 'Offset Y', 'infolio_plg' ),
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
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ],
                'default' => [
                    'size' => '-7',
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading .infolio-lins' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'heading_image' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Image Width', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '30',
                    'unit' => 'px',
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading .infolio-lins' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_image' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Image Height', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '30',
                    'unit' => 'px',
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading .infolio-lins' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_image' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_styled_text',
            [
                'label' => esc_html__( 'Styled Text', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'styled_color',
            [
                'label' => esc_html__( 'Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'styled_text_stroke',
                'selector' => '{{WRAPPER}} .infolio-heading span',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'styled_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-heading span',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'styled_border',
                'selector' => '{{WRAPPER}} .infolio-heading span',
            ]
        );
        $this->add_control(
            'styled_opacity',
            [
                'label' => esc_html__( 'Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading span' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'styled_margin',
            [
                'label' => esc_html__('Styled Text Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__( 'Icon', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'after_icon' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading-text .icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-heading-text .icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_dark',
            [
                'label' => esc_html__( 'Icon Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-heading-text .icon i' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-heading-text .icon i' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-heading-text .icon svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-heading-text .icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_indent',
            [
                'label' => esc_html__('Icon Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading-text .icon ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'infolio_plg'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading-text .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-heading-text .icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render heading widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( '' === $settings['title'] ) {
            return;
        }
        $this->add_render_attribute( 'title', 'class', 'infolio-heading' );

        if ( ! empty( $settings['size'] ) ) {
            $this->add_render_attribute( 'title', 'class', 'elementor-size-' . $settings['size'] );
        }
        if(!empty($settings['selected_icon']['value'])) {
            $this->add_render_attribute( 'title', 'class', 'inline-block' );
        }
        if ($settings['text_breakline'] == 'yes') {
            $this->add_render_attribute( 'title', 'class', 'infolio-text-breakline' );
        }
        if ($settings['text_wrap'] == 'yes') {
            $this->add_render_attribute( 'title', 'class', 'infolio-text-no-wrap' );
        }
        if ( $settings['background_image'] === 'yes' && ! empty( $settings['img']['url'] ) ) {
            $this->add_render_attribute( 'title', 'class', 'bg-img' );
            $this->add_render_attribute( 'title', 'data-background', esc_url( $settings['img']['url'] ) );
        }
        $rotate_animation = 'yes' == $settings['rotate_animation'] ? ' d-rotate wow' : '';
        $rotate_animation_child = 'yes' == $settings['rotate_animation'] ? ' rotate-text' : '';
        $this->add_render_attribute( 'title', 'class', $rotate_animation_child );

        $this->add_inline_editing_attributes( 'title' );

        $title = $settings['title'];
        $title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $title );
        // PHPCS - the variable $title_html holds safe data.
        ?>
        <div class="infolio-heading-text<?php echo $rotate_animation; ?><?php if ($settings['icon_block_responsive']=='yes') echo ' block-icon'?>">
            <?php
             if ( ! empty( $settings['link']['url'] ) ) : ?>
                <a <?php if(!empty($settings['selected_icon']['value'])) echo 'class= "d-flex align-items-end flex-wrap" '?> href="<?php echo $settings['link']['url'] ?>" <?php if ( $settings['link']['is_external'] ) echo'target="_blank"'; ?>>
            <?php endif;
                echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            if(!empty($settings['selected_icon']['value'])) {
                echo "<span class='icon$rotate_animation_child'>";
                    \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                echo '</span>';
            }
            if ( ! empty( $settings['link']['url'] ) ) : ?>
                </a>
            <?php endif; ?>
        </div>

        <?php
    }

    /**
     * Render heading widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template() {
        ?>
        <#
        var title = settings.title;

        if ( '' !== settings.link.url ) {
        title = '<a href="' + settings.link.url + '">' + title + '</a>';
        }

        view.addRenderAttribute( 'title', 'class', [ 'infolio-heading', 'elementor-size-' + settings.size ] );

        view.addInlineEditingAttributes( 'title' );

        var headerSizeTag = elementor.helpers.validateHTMLTag( settings.header_size ),
        title_html = '<' + headerSizeTag  + ' ' + view.getRenderAttributeString( 'title' ) + '>' + title + '</' + headerSizeTag + '>';

        print( title_html );
        #>
        <?php
    }
}
