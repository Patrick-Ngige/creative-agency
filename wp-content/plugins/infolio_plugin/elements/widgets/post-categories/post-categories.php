<?php
namespace InfolioPlugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit;

class Infolio_Post_Categories extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-post-categories';
    }

    public function get_title()
    {
        return __('infolio Post Categories', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Post Categories Settings', 'infolio_plg'),
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between Categories', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-post-categories ul li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'select_cat',
            [
                'label' => __('Specific Categories', 'infolio_plg'),
                'description' => esc_html__('By Default Widget Displays All Categories'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'blog_cat',
            [
                'label'   => __('Category', 'infolio_plg'),
                'type'    => Controls_Manager::SELECT2,
                'options'    => $this->infolio_category_options_with_id(),
                'condition' => [
                    'select_cat' => 'yes',
                ],
                'multiple' => true,
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
        $this->add_control(
            'cat_heading',
            [
                'label' => esc_html__('Category', 'infolio_plg'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Category Typography', 'infolio_plg'),
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} .infolio-post-categories .category',
            ]
        );
        $this->add_control(
            'count_heading',
            [
                'label' => esc_html__('Counter', 'infolio_plg'),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Count Typography', 'infolio_plg'),
                'name' => 'count_typography',
                'selector' => '{{WRAPPER}} .infolio-post-categories .count',
            ]
        );

        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $show_specific_categories = $settings['select_cat'] === 'yes';
        if ($show_specific_categories) {
            $selected_categories = $settings['blog_cat'];
        } else {
            $selected_categories = $this->infolio_category_options();
        }
        ?>
        <div class="infolio-post-categories">
            <ul class="rest">
                <?php if ($settings['select_cat']=='yes') : ?>
                <?php foreach ($selected_categories as $term_id) : ?>
                    <?php $category = get_cat_name($term_id); ?>
                    <li>
                        <span><a class="category" href="<?= esc_url(get_category_link($term_id)); ?>"><?= esc_html($category) ?></a></span>
                        <?php $count = $this->get_category_post_count($term_id); ?>
                        <span class="count"><?= ($count < 10 && $count != 0) ? "0$count" : "$count" ?></span>

                    </li>
                <?php endforeach; ?>
                <?php else:?>
                    <?php foreach ($selected_categories as $term_id => $category) : ?>
                        <li>
                            <span><a class="category" href="<?= esc_url(get_category_link($term_id)); ?>"><?=esc_html($category)?></a></span>
                            <?php $count = $this->get_category_post_count($term_id);?>
                            <span class="count"><?= ($count < 10 && $count != 0) ? "0$count" : $count ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif;?>
            </ul>
        </div>
        <?php
    }


    private function get_category_post_count($category_id) {
        $category = get_term($category_id, 'category');
        return $category->count;
    }
    private function infolio_category_options() {
        $args = array(
            'hide_empty' => false,
        );
        $categories = get_categories($args);
        $category_options = [];

        foreach ($categories as $category) {
            $category_options[$category->term_id] = $category->name;
        }

        return $category_options;
    }
    protected function infolio_category_options_with_id() {
        $categories = $this->infolio_category_options();
        $options = [];

        foreach ($categories as $term_id => $category) {
            $options[$term_id] = $category;
        }

        return $options;
    }
}


