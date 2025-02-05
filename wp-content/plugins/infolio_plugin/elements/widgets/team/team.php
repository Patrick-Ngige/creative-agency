<?php

namespace infolioPlugin\Widgets;

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
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class Infolio_Team extends Widget_Base
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
        return 'infolio-team';
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
        return __('Infolio Team', 'infolio_plg');
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
        return 'eicon-user-circle-o';
    }
    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
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

    protected function register_controls()
    {
        $this->start_controls_section(
            'content',
            [
                'label' => __('Content', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'name',
            [
                'label' => __('Name', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Type Name Here',
                'default' => __('Robert De Niro', 'infolio_plg')
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => __('Position', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Type Position Here',
                'default' => __('Web Developer', 'infolio_plg')
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );


        $social_icons = new Repeater();

        $social_icons->add_control(
            'icon',
            [
                'label' => __('Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $social_icons->add_control(
            'link',
            [
                'label' => __('Social Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-social-link.com', 'infolio_plg'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'social_icons_list',
            [
                'label' => __('Social Icons List', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $social_icons->get_controls(),
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'client_style',
            [
                'label' => esc_html('Client Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Team Member Name Typography', 'infolio_plg'),
                'name' => 'client_name_typography',
                'selector' => '{{WRAPPER}} .infolio-team .item .info .name',
            ]
        );
        $this->add_control(
            'client_name_color',
            [
                'label' => esc_html__('Team Member Name Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-team .item .info .name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'client_position_color',
            [
                'label' => esc_html__('Team Member Position Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-team .item .info .position' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Team Member Position Typography', 'infolio_plg'),
                'name' => 'client_position_typography',
                'selector' => '{{WRAPPER}} .infolio-team .item .info .position',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'social_media_style',
            [
                'label' => esc_html('Social Media Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('tabs_social_media_style');

        $this->start_controls_tab(
            'tab_social_media_normal',
            [
                'label' => esc_html__('Normal', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'social_media_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-team .item .social .links a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-team .item .social .links a svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'social_media_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .infolio-team .item .social .links a',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_social_media_hover',
            [
                'label' => esc_html__('Hover', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'social_media_color_hover',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-team .item .social .links a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-team .item .social .links a:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'social_media_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .infolio-team .item .social .links a:hover',
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings();
        ?>
            <div class="infolio-team">
                <div class="item">
                    <div class="img">
                        <img src="<?= esc_url($settings['image']['url']) ?>" alt="<?php if (!empty($settings['image']['alt'])) echo esc_attr($settings['image']['alt']); ?>" >
                        <div class="info">
                            <span class="position"><?=esc_html($settings['position'])?></span>
                            <h6 class="name"><?=esc_html($settings['name'])?></h6>
                        </div>
                    </div>
                    <div class="social">
                        <div class="links">
                            <?php foreach ($settings['social_icons_list'] as $icon) : ?>
                                <a href="<?= esc_url($icon['link']['url']); ?>" <?php if ( $icon['link']['is_external'] ) echo'target="_blank"'; ?>>
                                    <?php Icons_Manager::render_icon($icon['icon'], ['aria-hidden' => 'true']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}
