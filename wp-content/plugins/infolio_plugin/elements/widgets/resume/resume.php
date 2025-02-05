<?php
namespace InfolioPlugin\Widgets;

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


if (!defined('ABSPATH')) exit;

class Infolio_Resume extends Widget_Base
{
    public function get_name()
    {
        return 'infolio-resume';
    }

    public function get_title()
    {
        return __('Infolio Resume', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-editor-list-ul';
    }
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_items',
            [
                'label' => __('Resume Items', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'items',
            [
                'label' => __('Resume Items', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'date',
                        'label' => __('Date', 'infolio_plg'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('2018 - Present', 'infolio_plg'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'title',
                        'label' => __('Title', 'infolio_plg'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('Art Director', 'infolio_plg'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'subtitle',
                        'label' => __('Subtitle', 'infolio_plg'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('[ at Ui-Themez ]', 'infolio_plg'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => __('Description', 'infolio_plg'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => __('Crafting captivating digital experiences that put users at the heart of the design. Elevate your product to increased.', 'infolio_plg'),
                        'label_block' => true,
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-resume .items:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-resume .items .title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-resume .items .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-resume .items .sub-title',
            ]
        );
        $this->add_responsive_control(
            'sub_title_margin',
            [
                'label' => esc_html__('Sub Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-resume .items .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-resume .items p',
            ]
        );
        $this->add_responsive_control(
            'text_margin',
            [
                'label' => esc_html__('Description Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-resume .items p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="infolio-resume">
            <?php foreach ($settings['items'] as $index=>$item) : ?>
            <div class="items">
                <h6 class="date"><?=esc_html($item['date'])?></h6>
                <h5 class="title"><?=esc_html($item['title'])?> <span class="sub-title"><?=esc_html($item['subtitle'])?></span></h5>
                <div class="row">
                    <div class="col-md-10">
                        <p><?=esc_html($item['description'])?></p>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <?php
    }
}
