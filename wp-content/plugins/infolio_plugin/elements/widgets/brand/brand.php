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
class Infolio_Brand extends \Elementor\Widget_Base {

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
        return 'infolio-brand';
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
        return __('Infolio Brand', 'infolio_plg');
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
        return 'eicon-image-before-after';
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
            'section_brand',
            [
                'label' => esc_html__( 'Brand', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'option',
            [
                'label' => __('Select', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'image' => __('Image', 'infolio_plg'),
                    'text' => __('Text', 'infolio_plg'),
                ],
                'default' => 'image',
            ]
        );
        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__( 'Icon Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                        '{{WRAPPER}} .infolio-brand-item .top-left::after' => 'background: {{VALUE}};',
                        '{{WRAPPER}} .infolio-brand-item .top-right::after' => 'background: {{VALUE}};',
                        '{{WRAPPER}} .infolio-brand-item .bottom-right::after' => 'background: {{VALUE}};',
                        '{{WRAPPER}} .infolio-brand-item .bottom-left::after' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_background_color_dark',
            [
                'label' => esc_html__( 'Icon Background Color (Dark)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-brand-item .top-left::after' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-brand-item .top-left::after' => 'background-color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-brand-item .top-right::after' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-brand-item .top-right::after' => 'background-color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-brand-item .bottom-left::after' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-brand-item .bottom-left::after' => 'background-color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-brand-item .bottom-right::after' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-brand-item .bottom-right::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'top_left',
            [
                'label' => esc_html__('Top Left', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'top_right',
            [
                'label' => esc_html__('Top Right', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );        $this->add_control(
            'bottom_left',
            [
                'label' => esc_html__('Bottom Left', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'bottom_right',
            [
                'label' => esc_html__('Bottom Right', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .infolio-brand-item',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__( 'Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-brand-item ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__( 'Brand Image', 'infolio_plg' ),
                'condition'=>['option'=>'image']
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
        $this->end_controls_section();
        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Brand Text', 'infolio_plg' ),
                'condition'=>['option'=>'text']
            ]
        );
        $this->add_control(
            'number',
            [
                'label' => __('Number', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => '6k'
            ]
        );
        $this->add_control(
            'unit',
            [
                'label' => __('Unit', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => '+'
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Satisfied Clients'
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__( 'General', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                
            ]
        );
        $this->start_controls_tabs(
            'general_tabs'
        );
        
        $this->start_controls_tab(
            'general_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'infolio_plg' ),
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'general_background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .infolio-brand-item::after',
			]
		);
        $this->end_controls_tab();
        $this->start_controls_tab(
            'general_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'infolio_plg' ),
            ]
        );
 
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'general_bg_hover',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .infolio-brand-item:hover::after', // Adjust your selector
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient',
                    ],
                    'color' => [
                        'default' => '#FFFFFF00', // Default color for solid (not used if gradient is default)
                    ],
                    'color_b' => [
                        'default' => '#14cf93', // Second gradient color
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 130,
                        ],
                    ],
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
     
        $this->end_controls_section();
        $this->start_controls_section(
            'section_heading_style',
            [
                'label' => esc_html__( 'Section Heading', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['option'=>'text'],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'label' => esc_html__( 'Sub Title', 'infolio_plg' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-brand-item .text .sub-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'label' => esc_html__( 'Number', 'infolio_plg' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-brand-item .text .numb',
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
        ?>
        <div class="infolio-brand-item">
            <?php if ($settings['option']=='image') : ?>
            <div class="img">
                <img src="<?=esc_url($settings['image']['url'])?>" alt="<?php if (!empty($settings['image']['alt'])) echo esc_attr($settings['image']['alt']); ?>" >
            </div>
            <?php elseif ($settings['option']=='text'):?>
            <div class="text">
                <h2 class="numb"><?=esc_html($settings['number'])?><span class="unit"><?=esc_html($settings['unit'])?></span></h2>
                <h6 class="sub-title"><?=esc_html($settings['sub_title'])?></h6>
            </div>
            <?php endif;?>
            <?php if ($settings['top_left']=='yes') : ?>
                <span class="top-left">
                    <svg viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-23 2xl:w-[3.2rem] h-auto">
                        <rect y="11" width="23" height="0.671958" fill="white"></rect>
                        <rect x="12" width="23" height="0.671957" transform="rotate(90 12 0)" fill="white"></rect>
                    </svg>
                </span>
            <?php endif;?>
            <?php if ($settings['top_right']=='yes') : ?>
                <span class="top-right">
                    <svg viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-23 2xl:w-[3.2rem] h-auto">
                        <rect y="11" width="23" height="0.671958" fill="white"></rect>
                        <rect x="12" width="23" height="0.671957" transform="rotate(90 12 0)" fill="white"></rect>
                    </svg>
                </span>
            <?php endif;?>
            <?php if ($settings['bottom_left']=='yes') : ?>
                <span class="bottom-left">
                    <svg viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-23 2xl:w-[3.2rem] h-auto">
                        <rect y="11" width="23" height="0.671958" fill="white"></rect>
                        <rect x="12" width="23" height="0.671957" transform="rotate(90 12 0)" fill="white"></rect>
                    </svg>
                </span>
            <?php endif;?>
            <?php if ($settings['bottom_right']=='yes') : ?>
                <span class="bottom-right">
                    <svg viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-23 2xl:w-[3.2rem] h-auto">
                        <rect y="11" width="23" height="0.671958" fill="white"></rect>
                        <rect x="12" width="23" height="0.671957" transform="rotate(90 12 0)" fill="white"></rect>
                    </svg>
                </span>
            <?php endif;?>
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
}
