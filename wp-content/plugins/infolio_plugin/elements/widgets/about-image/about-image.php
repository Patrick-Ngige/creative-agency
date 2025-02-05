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
 * Elementor image widget.
 *
 * Elementor widget that displays an image into the page.
 *
 * @since 1.0.0
 */
class Infolio_About_Image extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve image widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'infolio-about-image';
    }

    /**
     * Get widget title.
     *
     * Retrieve image widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Infolio About Image', 'infolio_plg' );
    }
    /**
     * Get widget icon.
     *
     * Retrieve image widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-image';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the image widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'infolio-elements' ];
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
    /**
     * Register image widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__( 'About Image Image', 'infolio_plg' ),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default' => 'large',
                'separator' => 'none',
            ]
        );
        $this->add_control(
            'maz_shape',
            [
                'label' => __('Maze Shape', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'titles',
            [
                'label' => __('Titles', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'condition'=>['titles'=>'yes'],
                'default' => '',
                'placeholder' => esc_html__( 'Enter your Title', 'infolio_plg' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__( 'Sub Title', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'condition'=>['titles'=>'yes'],
                'default' => '',
                'placeholder' => esc_html__( 'Enter your Sub Title', 'infolio_plg' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__( 'Image', 'infolio_plg' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
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
                    '{{WRAPPER}} .infolio-about-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label' => esc_html__( 'Max Width', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
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
                    '{{WRAPPER}} .infolio-about-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-fit',
            [
                'label' => esc_html__( 'Object Fit', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'condition' => [
                    'height[size]!' => '',
                ],
                'options' => [
                    '' => esc_html__( 'Default', 'infolio_plg' ),
                    'fill' => esc_html__( 'Fill', 'infolio_plg' ),
                    'cover' => esc_html__( 'Cover', 'infolio_plg' ),
                    'contain' => esc_html__( 'Contain', 'infolio_plg' ),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-position',
            [
                'label' => esc_html__( 'Object Position', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'infolio_plg' ),
                    'center left' => esc_html__( 'Center Left', 'infolio_plg' ),
                    'center right' => esc_html__( 'Center Right', 'infolio_plg' ),
                    'top center' => esc_html__( 'Top Center', 'infolio_plg' ),
                    'top left' => esc_html__( 'Top Left', 'infolio_plg' ),
                    'top right' => esc_html__( 'Top Right', 'infolio_plg' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'infolio_plg' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'infolio_plg' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'infolio_plg' ),
                ],
                'default' => 'center center',
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image img' => 'object-position: {{VALUE}};',
                ],
                'condition' => [
                    'object-fit' => 'cover',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'image_effects' );
        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'opacity',
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
                    '{{WRAPPER}} .infolio-about-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .infolio-about-image img',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'opacity_hover',
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
                    '{{WRAPPER}}:hover .infolio-about-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}}:hover .infolio-about-image img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );
//
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .infolio-about-image img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
//
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .infolio-about-image img',
            ]
        );
//
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_caption',
            [
                'label' => esc_html__( 'Text', 'infolio_plg' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition'=>['titles'=>'yes'],
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .infolio-about-image .info .title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image .info .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'=>'after',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .infolio-about-image .info .sub-title',
            ]
        );
        $this->add_responsive_control(
            'sub_title_margin',
            [
                'label' => esc_html__('Sub Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image .info .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['maz_shape'=>'yes']
            ]
        );
        $this->add_control(
            'path_color',
            [
                'label' => esc_html__( 'Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-about-image .mz-shap svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-about-image .mz-shap svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'path_color_dark',
            [
                'label' => esc_html__( 'Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-about-image .mz-shap svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-about-image .mz-shap svg path' => 'fill: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-about-image .mz-shap svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-about-image .mz-shap svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

    }
    /**
     * Render image widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="infolio-about-image">
            <div class="d-flex align-items-center">
                <?php if ($settings['titles']=='yes') : ?>
                <div>
                    <div class="info">
                        <h6 class="title"><?=$settings['title']?></h6>
                        <p class="sub-title"><?=$settings['sub_title']?></p>
                    </div>
                </div>
                <?php endif;?>
                <div>
                    <div class="img">
                        <img src="<?=esc_url($settings['image']['url'])?>" alt="<?php if (!empty($settings['image']['alt'])) echo esc_attr($settings['image']['alt']); ?>" >
                    </div>
                </div>
            </div>
            <?php if ($settings['maz_shape']=='yes') : ?>
                <div class="mz-shap">
                    <svg height="100%" viewBox="0 0 610 547" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M116.134 529.548C116.134 538.642 123.506 546.015 132.6 546.015H211.63C211.635 546.015 211.638 546.011 211.638 546.007V546.007C211.638 546.003 211.642 545.999 211.646 545.999H592.691C601.786 545.999 609.158 538.627 609.158 529.533L609.157 251.366C609.157 242.272 601.785 234.899 592.691 234.899H401.097C392.003 234.899 384.631 227.527 384.631 218.433V112.465C384.631 103.371 377.259 95.999 368.164 95.999H214.466C205.372 95.999 198 88.6268 198 79.5327V16.4662C198 7.37219 190.628 0 181.534 0H88.4662C79.3722 0 72 7.37219 72 16.4662V104.534C72 113.628 79.3722 121 88.4662 121H166.917C176.011 121 183.383 128.372 183.383 137.466V273.565C183.383 282.659 176.011 290.031 166.917 290.031H116.134H116.134H16.5634C7.46936 290.031 0.0971666 297.403 0.0971666 306.497V445.923C0.0971666 455.017 7.46935 462.39 16.5634 462.39H99.6677C108.762 462.39 116.134 469.762 116.134 478.856V529.548Z" fill="#1d1d1d"></path>
                    </svg>
                </div>
            <?php endif;?>
        </div>
        <?php
    }

    /**
     * Render image widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template() {

    }

    /**
     * Retrieve image widget link URL.
     *
     * @since 3.11.0
     * @access protected
     *
     * @param array $settings
     *
     * @return array|string|false An array/string containing the link URL, or false if no link.
     */
}
