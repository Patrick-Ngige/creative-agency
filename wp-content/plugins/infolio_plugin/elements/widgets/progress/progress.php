<?php
namespace InfolioPlugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit;

class Infolio_Progress extends Widget_Base
{
    public function get_name()
    {
        return 'infolio-progress';
    }

    public function get_title()
    {
        return __('Infolio Progress', 'infolio_plg');
    }

    public function get_script_depends() {
        return ['infolio-progress'];
    }

    public function get_icon()
    {
        return 'eicon-progress-tracker';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Progress Settings', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'progress_value_option',
            [
                'label' => __('Progress Value Option', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'value-above' => __('Above Bar', 'infolio_plg'),
                    'value-after' => __('After Bar', 'infolio_plg'),
                    'value-hidden' => __('Hidden', 'infolio_plg'),
                ],
                'default' => 'value-above',
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'skill',
            [
                'label' => __('Skill Name', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('UI / UX DESIGN', 'infolio_plg'),
            ]
        );
        $repeater->add_control(
            'progress_value',
            [
                'label' => __('Progress Value', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '90',
            ]
        );

        $this->add_control(
            'progress_items',
            [
                'label' => __('progress Items', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'skill' => __('UI / UX DESIGN', 'infolio_plg'),
                        'progress_value'=>__('90','infolio_plg')
                    ],
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style Section', 'infolio_plg' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'skill_name_typography',
                'label' => __('Skill Typography', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-progress .sub-title',
            ]
        );

        $this->add_control(
            'skill_color',
            [
                'label' => __('Skill Color', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-progress .sub-title' => 'color: {{VALUE}};',
                ],
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
                    '{{WRAPPER}} .infolio-progress .skill-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => __('Skill Color', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'separator'=>'before',
                'selectors' => [
                    '{{WRAPPER}} .infolio-progress .skill-progress .progres:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'value_typography',
                'label' => __('Value Typography', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-progress .skill-progress .progres:after',
            ]
        );


        $this->add_responsive_control(
            'progress_height',
            [
                'label' => esc_html__( 'Progress Height', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-progress .skill-progress' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'progress_bar_background_color',
            [
                'label' => __('Progress Bar Background Color', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-progress .skill-progress' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'progress_bar_color',
            [
                'label' => __('Progress Bar Color', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-progress .skill-progress .progres' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $progress_items = $settings['progress_items'];
        ?>
        <div class="infolio-progress">
            <?php foreach ($progress_items as $item) :?>
            <div class="skill-item">
                <h5 class="sub-title"><?=esc_html($item['skill'])?></h5>
                <div class="skill-progress">
                    <div class="progres <?=esc_attr($settings['progress_value_option'])?>" data-value="<?=esc_attr($item['progress_value'])?>%"></div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <?php
    }
}