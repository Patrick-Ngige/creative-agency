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

class infolio_Pagination extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-pagination';
    }

    public function get_title()
    {
        return __('infolio Pagination', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-menu-card';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_right_content',
            [
                'label' => __('Right Settings', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'all_projects_text',
            [
                'label' => __('All Projects Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('All Projects', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'projects_link',
            [
                'label' => __('All Projects Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '#0',
                ],
            ]
        );
        $this->add_control(
            'next_project_text',
            [
                'label' => __('Next Project Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Next Project', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            'prev_project_text',
            [
                'label' => __('Prev Project Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Prev Project', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            'all_projects_icon',
            [
                'label' => esc_html__('All Projects Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
            ]
        );
        $this->add_control(
            'next_icon',
            [
                'label' => esc_html__('Next Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
            ]
        );
        $this->add_control(
            'prev_icon',
            [
                'label' => esc_html__('Prev Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
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
        $this->add_control(
            'ttitle_color',
            [
                'label' => esc_html__('Title Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-pagination .cont .title' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .infolio-pagination .cont .title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-pagination .cont .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'sub_color',
            [
                'label' => esc_html__('Sub Title Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-pagination .cont .sub-title' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .infolio-pagination .cont .sub-title',
            ]
        );
        $this->add_responsive_control(
            'sub_margin',
            [
                'label' => esc_html__('Sub Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-pagination .cont .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon size', 'infolio_plg'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-pagination .cont svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-pagination .cont i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-pagination .cont svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-pagination .cont i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-pagination .cont svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-pagination .cont i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if ($prev_post && is_object($prev_post)) {
            $prev_link = get_permalink($prev_post->ID);
            $prev_image = get_the_post_thumbnail_url($prev_post->ID, 'full');
            $prev_title = $prev_post->post_title;
        } else {
            $prev_link = '';
            $prev_image = ''; // or a default image URL
            $prev_title = ''; // or a default title
        }

        if ($next_post && is_object($next_post)) {
            $next_link = get_permalink($next_post->ID);
            $next_image = get_the_post_thumbnail_url($next_post->ID, 'full');
            $next_title = $next_post->post_title;
        } else {
            $next_link = '';
            $next_image = ''; // or a default image URL
            $next_title = ''; // or a default title
        }

?>
        <div class="infolio-pagination">
            <div class="row no-gutters">
                <div class="col-md-6 rest">
                    <?php if ($prev_post && is_object($prev_post)) { ?>
                        <div class="text-left box bg-img" style="background-image: url(<?php echo $prev_image; ?>);">
                            <div class="cont d-flex align-items-center">
                                <div class="infolio-pagination-icon-prev">
                                    <?php Icons_Manager::render_icon($settings['prev_icon'], ['aria-hidden' => 'true', 'class' => 'icon']); ?>
                                </div>
                                <div>
                                    <h6 class="sub-title"><?php echo $settings['prev_project_text']; ?></h6>
                                    <?php if ($prev_link) : ?>
                                        <a href="<?php echo $prev_link; ?>" class="title"><?php echo $prev_title; ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
                <div class="col-md-6 rest">
                    <?php if ($next_post && is_object($next_post)) { ?>
                        <div class="text-right d-flex box bg-img" style="background-image: url(<?php echo $next_image; ?>);">
                            <div class="ml-auto">
                                <div class="cont d-flex align-items-center">
                                    <div>
                                        <h6 class="sub-title"><?php echo $settings['next_project_text']; ?></h6>
                                        <?php if ($next_link) : ?>
                                            <a href="<?php echo $next_link; ?>" class="title"><?php echo $next_title; ?></a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="infolio-pagination-icon-next">
                                        <?php Icons_Manager::render_icon($settings['next_icon'], ['aria-hidden' => 'true', 'class' => 'icon']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
            </div>
            <div>
                <a href="<?php echo esc_url($settings['projects_link']['url']); ?>" class="all-works-butn text-center">
                    <div class="all-projects-icon">
                        <?php Icons_Manager::render_icon($settings['all_projects_icon'], ['aria-hidden' => 'true', 'class' => 'icon']); ?>
                    </div>
                    <span class="d-block fz-12 text-u ls1"><?php echo $settings['all_projects_text']; ?></span>
                </a>
            </div>
        </div>
<?php
    }
}
