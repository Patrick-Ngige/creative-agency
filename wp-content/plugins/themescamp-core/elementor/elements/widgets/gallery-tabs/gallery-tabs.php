<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit;

class TCG_Gallery_Tabs extends Widget_Base
{
    public function get_name()
    {
        return 'tcg-gallery-tabs';
    }

    public function get_title()
    {
        return __('TCG Gallery Tabs', 'themescamp-plugin');
    }

    public function get_icon()
    {
        return 'eicon-gallery-masonry';
    }

    public function get_categories()
    {
        return ['themescamp-elements'];
    }

    public function get_script_depends()
    {
        return ['isotope.min', 'gallery-tabs'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'filter_controls',
            [
                'label' => __('Filter Controls', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'filters',
            [
                'label' => __('Filters', 'themescamp-plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter filter values separated by commas (e.g., filter1, filter2)', 'themescamp-plugin'),
                'description' => esc_html__('Example: dark, light, custom_filter', 'themescamp-plugin'),
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Demos Gallery', 'themescamp-plugin'),
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__('Sub Title', 'themescamp-plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Create a Professional Website!', 'themescamp-plugin'),
            ]
        );
        $this->add_control(
            'main_title',
            [
                'label' => esc_html__('Main Title', 'themescamp-plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Home Pages.', 'themescamp-plugin'),
            ]
        );
        $this->add_control(
            'styled_title',
            [
                'label' => esc_html__('Styled Title', 'themescamp-plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('20+ pre-made', 'themescamp-plugin'),
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'demo_title',
            [
                'label' => esc_html__('Demo Title', 'themescamp-plugin'),
                'type' => Controls_Manager::TEXT,
                'ai' => [
                    'type' => 'text',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'placeholder' => esc_html__('Enter your title', 'themescamp-plugin'),
                'default' => esc_html__('Add Text Here', 'themescamp-plugin'),
            ]
        );
        $repeater->add_control(
            'demo_image',
            [
                'label' => __('Demo Image', 'themescamp-plugin'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
        $repeater->add_control(
            'demo_link',
            [
                'label' => __('Demo Link', 'themescamp-plugin'),
                'type' => Controls_Manager::URL,
            ]
        );
        $repeater->add_control(
            'demo_filter',
            [
                'label' => esc_html__('Filter for this Demo', 'themescamp-plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('dark', 'themescamp-plugin'),
                'description' => esc_html__('Enter the filter value for this demo (e.g., dark, light, custom_filter)', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'demos',
            [
                'label' => __('Demos', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ demo_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sec_heading_style',
            [
                'label' => esc_html('Text Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Sub Title Typography', 'themescamp-plugin'),
                'name' => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .tcg-gallery-tabs .sec-head .sub-title',
            ]
        );
        $this->add_control(
            'sub_title_color',
            [
                'label' => esc_html__( 'Sub Text Color', 'themescamp-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-gallery-tabs .sec-head .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'themescamp-plugin'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .tcg-gallery-tabs .sec-head .main-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Styled Title Typography', 'themescamp-plugin'),
                'name' => 'styled_title_typography',
                'selector' => '{{WRAPPER}} .tcg-gallery-tabs .sec-head .main-title .styled',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Text Color', 'themescamp-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-gallery-tabs .sec-head .main-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Filter Buttons Typography', 'themescamp-plugin'),
                'name' => 'filter_typography',
                'separator'=>'before',
                'selector' => '{{WRAPPER}} .tcg-gallery-tabs .sec-head .buttons .filter span',
            ]
        );
        $this->add_control(
            'filter_color',
            [
                'label' => esc_html__( 'Filter Buttons Color', 'themescamp-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-gallery-tabs .sec-head .buttons .filter span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'demos_style',
            [
                'label' => esc_html('Demos Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Demo Title Typography', 'themescamp-plugin'),
                'name' => 'demo_typography',
                'selector' => '{{WRAPPER}} .tcg-gallery-tabs .item .title',
            ]
        );
        $this->add_control(
            'demo_color',
            [
                'label' => esc_html__( 'Demo Title Color', 'themescamp-plugin' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-gallery-tabs .item .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Demo Title Margin', 'themescamp-plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-gallery-tabs .item .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $filters = !empty($settings['filters']) ? explode(',', $settings['filters']) : [];

        ?>
        <div class="tcg-gallery-tabs">
            <div class="sec-head">
                <h6 class="sub-title"><?=esc_html($settings['sub_title'])?></h6>
                <div class="bord">
                    <h2 class="d-rotate wow main-title">
                        <span class="rotate-text"><span class="styled"><?=esc_html($settings['styled_title'])?></span> <span><?=esc_html($settings['main_title'])?></span></span>
                    </h2>
                    <div class="buttons">
                        <!-- filter links -->
                        <div class="filtering">
                            <div class="filter">
                                <span data-filter='*' class='active'><?=esc_html__('All','themescamp-plugin')?></span>
                                <?php foreach ($filters as $filter) : ?>
                                    <span data-filter=".<?= trim($filter) ?>"><?= trim($filter) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gallery row md-marg">
                <?php foreach ($settings['demos'] as $demo) : ?>
                <div class="col-lg-3 col-md-6 items <?= $demo['demo_filter'] ?>">
                    <div class="item text-center">
                        <a href="<?= esc_url($demo['demo_link']['url']) ?>" target="_blank">
                            <div class="img">
                                <img src="<?= esc_url($demo['demo_image']['url']) ?>" alt="<?php if (!empty($demo['demo_image']['alt'])) echo esc_attr($demo['demo_image']['alt']); ?>">
                            </div>
                            <h6 class="title"><?= $demo['demo_title'] ?></h6>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}
