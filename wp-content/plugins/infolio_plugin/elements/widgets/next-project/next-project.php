<?php
namespace infolioPlugin\Widgets;

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

if (!defined('ABSPATH')) exit;

class infolio_Next_Project extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-next-project';
    }

    public function get_title()
    {
        return __('infolio Next Project', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-menu-card';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_right_content',
            [
                'label' => __('Right Settings', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Project Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('OPT Media Agency', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Next Project', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'proj_link',
            [
                'label' => __('Project Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'background',
            [
                'label' => __('Background Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
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
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .text-align' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_align',
            [
                'label' => esc_html__( 'Content Container Alignment', 'infolio_plg' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .margin' => 'margin-{{VALUE}}: auto;',
                ],
            ]
        );
        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__( 'Icon Position', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'before' => [
                        'title' => esc_html__( 'Before', 'infolio_plg' ),
                    ],
                    'after' => [
                        'title' => esc_html__( 'After', 'infolio_plg' ),
                    ],
                ],
                'default' => 'before',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ttitle_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .cont .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-next-project .cont .title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .cont .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'sub_color',
            [
                'label' => esc_html__( 'Sub Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .cont .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-next-project .cont .sub-title',
            ]
        );
        $this->add_responsive_control(
            'sub_margin',
            [
                'label' => esc_html__('Sub Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .cont .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .cont svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-next-project .cont i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .cont svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-next-project .cont i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-next-project .cont svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-next-project .cont i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="infolio-next-project">
            <div class="text-align box bg-img" data-background="<?=esc_url($settings['background']['url'])?>">
                <div class="margin">
                    <div class="cont d-flex align-items-center">
                        <?php if ($settings['icon_position']=='before') : ?>
                        <div>
                            <?php Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true' , 'class' => 'icon']); ?>
                        </div>
                        <?php endif;?>
                        <div>
                            <h6 class="sub-title"><?=esc_html($settings['sub_title'])?></h6>
                            <a href="<?=esc_url($settings['proj_link']['url'])?>" class="title" <?php if ( $settings['proj_link']['is_external'] ) echo'target="_blank"'; ?>><?=esc_html($settings['title'])?></a>
                        </div>
                        <?php if ($settings['icon_position']=='after') : ?>
                            <div>
                                <?php Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true' , 'class' => 'icon']); ?>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}