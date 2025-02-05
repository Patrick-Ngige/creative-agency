<?php
namespace InfolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\repeater;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Group_Control_Text_Shadow;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/**
 * @since 1.1.0
 */
class Infolio_Rotate_Circle extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve icon list widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'infolio-rotate-circle';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Infolio Rotate Circle', 'infolio_plg' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon list widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-button';
    }
    public function get_script_depends()
    {
        return ['Youtube-Popup.min','infolio-youtube-popup'];
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
        return ['infolio-elements'];
    }

    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */

    protected function register_controls(){
        $this->start_controls_section(
            'content',
            [
                'label' => __('Content', 'infolio_plg')
            ]
        );
        $this->add_control(
            'text',
            [
                'label' => __('Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXTAREA
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'URL', 'infolio_plg' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter URL', 'infolio_plg' ),
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
        $this->end_controls_section();

        $this->start_controls_section(
            'styles',
            [
                'label' => __('Styles', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'circle_size',
            [
                'label' => esc_html__('Circle Size', 'infolio_plg'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-rotate-circle .rotate-circle svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-rotate-circle .vid' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'text_opacity',
            [
                'label' => esc_html__( 'Text Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-rotate-circle .rotate-circle svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .infolio-rotate-circle .rotate-circle',
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .infolio-rotate-circle .rotate-circle',
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
                    '{{WRAPPER}} .infolio-rotate-circle .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-rotate-circle .icon svg ' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings();
        ?>
            <div class="infolio-rotate-circle">
                <?php if (!empty($settings['link']['url'])) : ?>
                <a href="<?=esc_url($settings['link']['url'])?>" class="vid" <?php if ( $settings['link']['is_external'] ) echo'target="_blank"'; ?>>
                    <?php endif;?>
                    <div class="rotate-circle">
                        <svg class="textcircle" viewBox="0 0 500 500">
                            <defs>
                                <path id="textcircle"
                                      d="M250,400 a150,150 0 0,1 0,-300a150,150 0 0,1 0,300Z">
                                </path>
                            </defs>
                            <text>
                                <textPath xlink:href="#textcircle" textLength="900"><?=esc_html($settings['text'])?></textPath>
                            </text>
                        </svg>
                    </div>
                    <div class="icon">
                        <?php Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                <?php if (!empty($settings['link']['url'])) : ?>
                </a>
                <?php endif; ?>
                <?php if ($settings['shap_left']=='yes') : ?>
                    <div class="shap-left-bottom">
                        <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                             class="w-11 h-11">
                            <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#1a1a1a"></path>
                        </svg>
                    </div>
                <?php endif;?>
                <?php if ($settings['shap_right']=='yes') : ?>
                    <div class="shap-right-top">
                        <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                             class="w-11 h-11">
                            <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#1a1a1a"></path>
                        </svg>
                    </div>
                <?php endif;?>
            </div>
        <?php
    }
}