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
class Infolio_Curve_Title extends \Elementor\Widget_Base {

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
        return 'infolio-curve-title';
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
        return __('Infolio Curve Title', 'infolio_plg');
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
        return [ 'curve', 'title' ];
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
                'label' => esc_html__( 'Infolio Curve Title', 'infolio_plg' ),
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
            'shap_left',
            [
                'label' => esc_html__('Left Bottom Edge', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'shap_right',
            [
                'label' => esc_html__('Right Top Edge', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->add_control(
            "scale",
            [
                'label' => esc_html__( 'Scale', 'infolio_plg' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'infolio_plg' ),
                'label_off' => esc_html__( 'Off', 'infolio_plg' ),
            ]
        );

        $this->add_responsive_control(
            "scale_x",
            [
                'label' => esc_html__( 'Scale X', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'condition' => ["scale" => 'yes'],
                'selectors' => [
                    "{{WRAPPER}} .infolio-curve-title .sub-title" => 'transform: scaleX({{SIZE}});',
                ],
            ]
        );

        $this->add_responsive_control(
            "scale_y",
            [
                'label' => esc_html__( 'Scale Y', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'condition' => ["scale" => 'yes'],
                'selectors' => [
                    "{{WRAPPER}} .infolio-curve-title .sub-title" => 'transform: scaleY({{SIZE}})',
                ],
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
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-curve-title .sub-title',
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
            <div class="infolio-curve-title">
                <h6 class="sub-title"><?=esc_html($settings['title'])?></h6>
                <?php if ($settings['shap_left']=='yes') : ?>
                    <div class="shap-left-bottom">
                        <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                            <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"></path>
                        </svg>
                    </div>
                <?php endif;?>
                <?php if ($settings['shap_right']=='yes') : ?>
                    <div class="shap-right-bottom">
                        <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                            <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"></path>
                        </svg>
                    </div>
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
