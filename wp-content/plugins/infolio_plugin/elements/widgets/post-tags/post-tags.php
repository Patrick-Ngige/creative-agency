<?php
namespace InfolioPlugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit;

class Infolio_Post_tags extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-post-tags';
    }

    public function get_title()
    {
        return __('infolio Post tags', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_tags()
    {
        return ['infolio-elements'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Post tags Settings', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'select_tag',
            [
                'label' => __('Specific Tags', 'infolio_plg'),
                'description' => esc_html__('By Default Widget Displays All Tags'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'blog_tag',
            [
                'label'   => __('Tags', 'infolio_plg'),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->infolio_tag_options_with_id(),
                'condition' => [
                    'select_tag' => 'yes',
                ],
                'multiple'   => 'true',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style',
            [
                'label' => esc_html('Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Tag Typography', 'infolio_plg'),
                'name' => 'count_typography',
                'selector' => '{{WRAPPER}} .infolio-post-tags a',
            ]
        );

        $this->add_responsive_control(
            'tag_margin',
            [
                'label' => esc_html__('Tag Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-tags a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tag_padding',
            [
                'label' => esc_html__('Tag Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-tags a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-tags a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('link_style');
        $this->start_controls_tab(
            'normal_link',
            [
                'label' => esc_html__( 'Normal', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'tag_color',
            [
                'label' => esc_html__('Tag Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-tags a' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'tag_background_color',
            [
                'label' => esc_html__('Tag Background Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-tags a' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover_link',
            [
                'label' => esc_html__( 'Hover', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'tag_hover_color',
            [
                'label' => esc_html__('Tag Hover Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-tags a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'tag_background_hover_color',
            [
                'label' => esc_html__('Tag Hover Background Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-tags a:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $tags = $this->get_tag_options();
        $show_specific_tags = $settings['select_tag'] === 'yes';
        if ($show_specific_tags) {
            $selected_tags = $settings['blog_tag'];
        } else {
            $selected_tags = $this->get_tag_options();
        }
        ?>
        <div class="infolio-post-tags">
            <?php if ($settings['select_tag']=='yes') : ?>
                <?php foreach ($selected_tags as $term_id) : ?>
                    <?php $tag_name = get_term_field('name', $term_id, 'post_tag'); ?>
                    <a href="<?=esc_url(get_tag_link($term_id))?>"><?=esc_html($tag_name)?></a>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ($selected_tags as $term_id => $tag) : ?>
                    <a href="<?=esc_url(get_tag_link($term_id))?>"><?=esc_html($tag)?></a>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
        <?php
    }

    private function get_tag_options() {
        $args = array(
            'hide_empty' => false,
        );
        $tags = get_tags($args);
        $tag_options = [];

        foreach ($tags as $tag) {
            $tag_options[$tag->term_id] = $tag->name;
        }

        return $tag_options;
    }
    protected function infolio_tag_options_with_id() {
        $tags = $this->get_tag_options();
        $options = [];

        foreach ($tags as $term_id => $tag) {
            $options[$term_id] = $tag;
        }

        return $options;
    }
}


