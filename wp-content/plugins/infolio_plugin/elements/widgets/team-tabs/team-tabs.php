<?php

namespace InfolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class Infolio_Team_Tabs extends Widget_Base
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
        return 'infolio-team-tabs';
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
        return __('Infolio Team Tabs', 'infolio_plg');
    }

    public function get_script_depends()
    {
        return ['infolio-team-tabs'];
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
        return 'eicon-image-before-after';
    }

    /**
     * Retrieve the list of positionegories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one positionegory.
     * When multiple positionegories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget positionegories.
     */
    public function get_positionegories()
    {
        return ['infolio-elements'];
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
    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('team Tabs Settings.', 'infolio_plg'),
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'image',
            [
                'label' => __( 'Image', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );
        $repeater->add_control(
            'name',
            [
                'label' => __( 'Member Name', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Robert De Niro', 'infolio_plg' ),
            ]
        );
        $repeater->add_control(
            'position',
            [
                'label' => __( 'Member Position', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'WEB DESIGNER', 'infolio_plg' ),
            ]
        );
        $repeater->add_control(
            'btn_text',
            [
                'label' => __( 'Text', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'VIEW MORE', 'infolio_plg' ),
            ]
        );
        $repeater->add_control(
            'btn_link',
            [
                'label' => __( 'Link', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'infolio_plg' ),
            ]
        );
        $repeater->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Choose Icon', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'team_list',
            [
                'label' => __('Team List', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'text_settings',
            [
                'label' => __( 'Text Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between Text Section', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'separator'=>'after',
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .content .cluom:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .infolio-team-tabs .info .name',
            ]
        );

        $this->add_responsive_control(
            'name_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%','rem', 'em','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .info .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'name_padding',
            [
                'label' => esc_html__('Title Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%','rem', 'em','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .info .name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'selector' => '{{WRAPPER}} .infolio-team-tabs .info .position',
            ]
        );

        $this->add_control(
            'position_opacity',
            [
                'label' => esc_html__( 'Position Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .info .position' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'position_margin',
            [
                'label' => esc_html__('Position Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%','rem', 'em','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .info .position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'position_padding',
            [
                'label' => esc_html__('Position Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .info .position' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'button_settings',
            [
                'label' => __( 'Read More Button Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-team-tabs .cluom .more',
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Read More Icon size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .cluom .more svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-team-tabs .cluom .more i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Button Icon Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' ,'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-team-tabs .cluom .more svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-team-tabs .cluom .more i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $settings = $this->get_settings();
        ?>

        <div class="infolio-team-tabs">
            <div class="row">
                <div class="col-lg-5 rest">
                    <div class="glry-img">
                        <?php $itemCount=1; foreach ($settings['team_list'] as $item) : ?>
                        <div id="tab-<?=$itemCount?>" class="bg-img tab-img <?php if ($itemCount==1)echo 'current'?>" data-background="<?=esc_url($item['image']['url'])?>"></div>
                        <?php $itemCount++; endforeach;?>
                    </div>
                </div>
                <div class="col-lg-7 rest content">
                <?php $itemCount=1; foreach ($settings['team_list'] as $item) : ?>
                    <div class="cluom <?php if ($itemCount==1)echo 'current'?>" data-tab="tab-<?=$itemCount?>">
                        <div class="info">
                            <h6 class="position"><?=esc_html($item['position'])?></h6>
                            <h4 class="name"><?=esc_html($item['name'])?></h4>
                        </div>
                        <div class="more">
                            <a href="<?=esc_url($item['btn_link']['url'])?>" <?php if ( $item['btn_link']['is_external'] ) echo 'target="_blank"'; ?> ><?=esc_html($item['btn_text'])?>
                                <?php Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']); ?>
                            </a>
                        </div>
                    </div>
                <?php $itemCount++; endforeach;?>

                </div>
            </div>
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
    }
}