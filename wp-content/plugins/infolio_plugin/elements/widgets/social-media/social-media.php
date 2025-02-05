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

class Infolio_Social_Media extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-social-media';
    }

    public function get_title()
    {
        return __('Infolio Social Media', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-animation';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    public function get_script_depends() {
        return ['infolio-parallax'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Social Media Settings', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'icon_responsive',
            [
                'label' => __('Icon Responsive', 'infolio_plg'),
                'description' => __('Make Icon Display None', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
                'default'=>'yes'
            ]
        );
        $this->add_control(
            'flex_wrap',
            [
                'label' => __('Wrap Items', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'condition'=>['alignment'=>'d-flex'],
                'label_off' => __('No', 'infolio_plg'),
                'default'=>'no'
            ]
        );
        $this->add_control(
            'cursor_animation',
            [
                'label' => __('Hover Animation', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
                'default'=>'yes'
            ]
        );
        $this->add_control(
            'link_display',
            [
                'label' => esc_html__('Link Display Type', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inline-block',
                'options' => [
                    'block' => esc_html__('Block', 'infolio_plg'),
                    'inline-block' => esc_html__('Inline Block', 'infolio_plg'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media a' => 'display: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'alignment',
            [
                'label' => __('Items Alignment', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('Columns', 'infolio_plg'),
                    'd-flex' => __('Rows', 'infolio_plg'),
                ],
                'default' => 'd-flex',
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'social_title',
            [
                'label' => __('Social Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'social_link',
            [
                'label' => __('Social Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );
        $this->add_control(
            'items_list',
            [
                'label' => __('Social Media List', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{social_title}}}',
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
        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'separator'=>'after',
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-social-media a span',
            ]
        );
        $this->add_responsive_control(
            'space_between_icon_text',
            [
                'label' => esc_html__( 'Space Between Icon and text', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media li a svg' => 'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .infolio-social-media li a i' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'separator'=>'after',
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media a i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .infolio-social-media a svg' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__( 'Icon Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .infolio-social-media a',
            ]
        );
        $this->add_control(
            'border_dark',
            [
                'label' => esc_html__( 'Border Color ( Dark Mode )', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-social-media a' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-social-media a' => 'border-color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );
        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('icon_tabs');
        $this->start_controls_tab(
            'normal',
            [
                'label' => __('Normal', 'infolio_plg')
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text/Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media a i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-social-media a svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-social-media a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_color_dark',
            [
                'label' => esc_html__( 'Text/Icon Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-social-media a i' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-social-media a i' => 'color: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-social-media a svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-social-media a svg' => 'fill: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-social-media a' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-social-media a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            [
                'label' => __('Hover', 'infolio_plg')
            ]
        );
        $this->add_control(
            'text_color_hover',
            [
                'label' => esc_html__( 'Text/Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-social-media a:hover i' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .infolio-social-media a:hover svg' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $items_list = $settings['items_list'];
        ?>
            <ul class="rest infolio-social-media <?=esc_attr($settings['alignment']);?> <?php if ($settings['flex_wrap']=='yes')echo esc_attr('flex-wrap')?>">
                <?php foreach ($items_list as $index=>$item) : ?>
                    <li class="<?php if ($settings['cursor_animation']=='yes') echo 'infolio-hover-this'?> cursor-pointer <?php if ($settings['icon_responsive']=='yes')echo 'icon_responsive'?>">
                        <a href="<?=esc_url($item['social_link']['url'])?>" class="<?php if ($settings['cursor_animation']=='yes') echo 'infolio-hover-anim'?>" <?php if ( $item['social_link']['is_external'] ) echo'target="_blank"'; ?>>
                            <?php if (!empty($item['selected_icon'])) Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php if (!empty($item['social_title']) && (!empty($item['selected_icon']))):?>
                                <span><?=esc_html($item['social_title'])?></span>
                            <?php else:?>
                                <?=esc_html($item['social_title'])?>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php
    }
}
