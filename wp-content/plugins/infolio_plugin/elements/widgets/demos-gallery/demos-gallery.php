<?php

namespace infolioPlugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit;

class infolio_Demos_Gallery extends Widget_Base
{
    public function get_name()
    {
        return 'infolio-demos-gallery';
    }

    public function get_title()
    {
        return __('infolio Demos Gallery', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-gallery-masonry';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    public function get_script_depends()
    {
        return ['isotope.min', 'infolio-demos-gallery'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'filter_controls',
            [
                'label' => __('Filter Controls', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'filters',
            [
                'label' => __('Filters', 'infolio_plg'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter filter values separated by commas (e.g., filter1, filter2)', 'infolio_plg'),
                'description' => esc_html__('Example: dark, light, custom_filter', 'infolio_plg'),
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Demos Gallery', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__('Sub Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Create a Professional Website!', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'main_title',
            [
                'label' => esc_html__('Main Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Home Pages.', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'styled_title',
            [
                'label' => esc_html__('Styled Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('20+ pre-made', 'infolio_plg'),
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'demo_title',
            [
                'label' => esc_html__('Demo Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'ai' => [
                    'type' => 'text',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'placeholder' => esc_html__('Enter your title', 'infolio_plg'),
                'default' => esc_html__('Add Text Here', 'infolio_plg'),
            ]
        );
        $repeater->add_control(
            'demo_image',
            [
                'label' => __('Demo Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
        $repeater->add_control(
            'demo_link',
            [
                'label' => __('Demo Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
            ]
        );
        $repeater->add_control(
            'demo_filter',
            [
                'label' => esc_html__('Filter for this Demo', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('dark', 'infolio_plg'),
                'description' => esc_html__('Enter the filter value for this demo (e.g., dark, light, custom_filter)', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'demos',
            [
                'label' => __('Demos', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ demo_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sec_heading_style',
            [
                'label' => esc_html('Text Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Sub Title Typography', 'infolio_plg'),
                'name' => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .infolio-demos .sec-head .sub-title',
            ]
        );
        $this->add_control(
            'sub_title_color',
            [
                'label' => esc_html__( 'Sub Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-demos .sec-head .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'infolio_plg'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .infolio-demos .sec-head .main-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Styled Title Typography', 'infolio_plg'),
                'name' => 'styled_title_typography',
                'selector' => '{{WRAPPER}} .infolio-demos .sec-head .main-title .styled',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-demos .sec-head .main-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Filter Buttons Typography', 'infolio_plg'),
                'name' => 'filter_typography',
                'separator'=>'before',
                'selector' => '{{WRAPPER}} .infolio-demos .sec-head .buttons .filter span',
            ]
        );
        $this->add_control(
            'filter_color',
            [
                'label' => esc_html__( 'Filter Buttons Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-demos .sec-head .buttons .filter span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'demos_style',
            [
                'label' => esc_html('Demos Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Demo Title Typography', 'infolio_plg'),
                'name' => 'demo_typography',
                'selector' => '{{WRAPPER}} .infolio-demos .item .title',
            ]
        );
        $this->add_control(
            'demo_color',
            [
                'label' => esc_html__( 'Demo Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-demos .item .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Demo Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-demos .item .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        <div class="infolio-demos">
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
                                <span data-filter='*' class='active'><?=esc_html__('All','infolio_plg')?></span>
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
