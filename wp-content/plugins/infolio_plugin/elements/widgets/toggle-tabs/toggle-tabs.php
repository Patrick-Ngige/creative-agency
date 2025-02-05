<?php

namespace infolioPlugin\Widgets;


use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor toggle widget.
 *
 * Elementor widget that displays a collapsible display of content in an toggle
 * style, allowing the user to open multiple items.
 *
 * @since 1.0.0
 */
class infolio_Toggle_Tabs extends Widget_Base
{

	/**
	 * Get widget name.
	 *
	 * Retrieve toggle widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'infolio-toggle-tabs';
	}

	//script depend
	public function get_script_depends()
	{
		return ['infolio-toggle-tabs'];
	}


	/**
	 * Get widget title.
	 *
	 * Retrieve toggle widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('infolio Toggle Tabs', 'infolio_plg');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve toggle widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-toggle';
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
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['tabs', 'accordion', 'toggle'];
	}

	/**
	 * Register toggle widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */

	protected function register_controls()
	{
		$this->start_controls_section(
			'content',
			[
				'label' => __('Content', 'infolio_plg')
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __('Heading', 'infolio_plg'),
				'type' => Controls_Manager::TEXT
			]
		);
        $this->add_control(
			'sub_heading',
			[
				'label' => __('Sub Title', 'infolio_plg'),
				'type' => Controls_Manager::TEXT
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __('Description', 'gekkfolio_plg'),
				'type' => Controls_Manager::TEXT
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => __('Tab Title', 'infolio_plg'),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'back_img',
			[
				'label' => __('Background Image', 'infolio_plg'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => __('Icon Image', 'infolio_plg'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'text',
			[
				'label' => __('Text', 'infolio_plg'),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => __('Button Text', 'infolio_plg'),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'button_url',
			[
				'label' => __('Button Link', 'infolio_plg'),
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '#0',
                ]
			]
		);

		$repeater->add_control(
			'button_icon',
			[
				'label' => __('Button Icon', 'infolio_plg'),
				'type' => Controls_Manager::ICONS,
			]
		);


		$this->add_control(
			'tabs_repeater',
			[
				'label' => __('Tabs Repeater', 'infolio_plg'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{tab_title}}}'
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'sub_heading_style',
			[
				'label' => __('Sub Heading Styles', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'sub_heading_margin',
			[
				'label' => esc_html__('Margin', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .sec-head .heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'sub_heading_padding',
			[
				'label' => esc_html__('Padding', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .sec-head .heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'sub_heading_border_radius',
			[
				'label' => esc_html__('Border Radius', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .sec-head .heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_heading_typography',
				'label' => __('Title Typography', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .heading',
			]
		);
		$this->add_control(
			'sub_heading_color',
			[
				'label' => esc_html__('Heading Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .heading' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'sub_heading_stroke',
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .heading',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sub_heading_border',
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .heading',
			]
		);

		$this->add_control(
			'sub_display',
			[
				'label' => __('Display', 'infolio_plg'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'block' => __('Block', 'infolio_plg'),
					'inline-block' => __('Inline Block', 'infolio_plg')
				],
				'default' => 'inline',
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .heading' => 'display: {{VALUE}}'
				]
			]
		);
		$this->end_controls_section();	$this->start_controls_section(
			'heading_style',
			[
				'label' => __('Heading Styles', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'heading_margin',
			[
				'label' => esc_html__('Margin', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%','rem'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .sec-head .main-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'heading_padding',
			[
				'label' => esc_html__('Padding', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .sec-head .main-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'heading_border_radius',
			[
				'label' => esc_html__('Border Radius', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .sec-head .main-heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => __('Title Typography', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .sec-head .main-heading',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'heading_stroke',
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .sec-head .main-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'heading_border',
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .sec-head .main-heading',
			]
		);

		$this->add_control(
			'display',
			[
				'label' => __('Display', 'infolio_plg'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'block' => __('Block', 'infolio_plg'),
					'inline-block' => __('Inline Block', 'infolio_plg')
				],
				'default' => 'inline',
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .sec-head .main-heading' => 'display: {{VALUE}}'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'desc_style',
			[
				'label' => __('Description Styles', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'desc_margin',
			[
				'label' => esc_html__('Margin', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', 'rem', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .text .desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'desc_padding',
			[
				'label' => esc_html__('Padding', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .text .desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __('Title Typography', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .text .desc',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'desc_border',
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .text .desc',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'card_styles',
			[
				'label' => __('Card Styles', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'card_margin',
			[
				'label' => esc_html__('Margin', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em' , 'rem', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'card_padding',
			[
				'label' => esc_html__('Padding', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'card_border_radius',
			[
				'label' => esc_html__('Border Radius', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_width',
			[
				'label' => esc_html__('Width', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => ['%', 'px', 'vw'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 150,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('card_tabs');
		$this->start_controls_tab(
			'normal_card',
			[
				'label' => __('Normal', 'infolio_plg'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'card_background',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover_card',
			[
				'label' => __('Hover', 'infolio_plg')
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'card_background_hover',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border_hover',
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .serv-tab-cont .item .cont:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label' => __('Title Styles', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Margin', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em' , 'rem', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .item-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Title Typography', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .item-link',
			]
		);
        $this->add_responsive_control(
            'number_margin',
            [
                'label' => esc_html__('Number Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'sepa21rator'=>'before',
                'size_units' => ['px', 'em' , 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-toggle-tabs .item-link .numb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'label' => __('Number Typography', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-toggle-tabs .item-link .numb',
            ]
        );
        $this->add_control(
            'number_opacity',
            [
                'label' => esc_html__( 'Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-toggle-tabs .item-link .numb' => 'opacity: {{SIZE}};',
                ],
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'text_style',
			[
				'label' => __('Text Style', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __('Text Typography', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .text p',
			]
		);
		$this->add_responsive_control(
			'text_margin',
			[
				'label' => esc_html__('Margin', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_styles',
			[
				'label' => __('Image Styles', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__('Width', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => ['%', 'px', 'vw'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 150,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon-img' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__('Height', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => ['px', 'vh', '%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			[
				'label' => __('Button Style', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __('Button Typography', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-toggle-tabs .button',
			]
		);
		$this->add_responsive_control(
			'button_margin',
			[
				'label' => esc_html__('Margin', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .infolio-toggle-tabs .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
            'space_icon',
            [
                'label' => esc_html__('Space Between', 'infolio_plg'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-toggle-tabs .button span' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'infolio_plg'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 14,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-toggle-tabs .button i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-toggle-tabs .button svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_section();

	}

	protected function render()
	{
		$settings = $this->get_settings();
        $tab_id = uniqid();
?>
		<div class="infolio-toggle-tabs">
			<div class="row lg-marg" id="infolio-tabs-<?= $tab_id ?>">
                <div class="col-lg-6 valign">
                    <div class="serv-tab-cont">
                        <?php
                        $first = true;
                        foreach ($settings['tabs_repeater'] as $index => $item) : ?>
                            <div class="tab-content <?php if ($first) echo 'current'; ?>" id="tabs-<?= $tab_id.$item['_id'].$index?>">
                                <div class="item">
                                    <div class="img">
                                        <img src="<?= esc_url($item['back_img']['url']); ?>" alt="<?php if (!empty($item['back_img']['alt'])) echo esc_attr($item['back_img']['alt']); ?>">
                                    </div>
                                    <div class="cont sub-bg">
                                        <div class="icon-img">
                                            <img src="<?= esc_url($item['icon']['url']) ?>" alt="<?php if (!empty($item['icon']['alt'])) echo esc_attr($item['icon']['alt']); ?>">
                                        </div>
                                        <div class="text">
                                            <p><?= esc_html($item['text']); ?></p>
                                        </div>
                                        <a href="<?php echo esc_url($item['button_url']['url']); ?>" class="button" <?php if ( $item['button_url']['is_external'] ) echo'target="_blank"'; ?>>
                                            <span><?php echo __($item['button_text'], 'infolio_plg'); ?></span>
                                            <?php Icons_Manager::render_icon($item['button_icon'], ['aria-hidden' => 'true']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php $first = false;
                        endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-6 valign">
                    <div class="serv-tab-link tab-links">
                        <div class="sec-head">
                            <h6 class="heading"><?php echo __($settings['sub_heading'], 'infolio_plg'); ?></h6>
                            <p class="main-heading"><?php echo __($settings['heading'], 'infolio_plg'); ?></p>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-11">
                                <div class="text">
                                    <p class="desc"><?php echo __($settings['description'], 'infolio_plg'); ?></p>
                                </div>
                                <ul class="rest">
                                    <?php $first = true;
                                    $counter=0;
                                    foreach ($settings['tabs_repeater'] as $index => $item) : $counter++; ?>
                                        <li class="item-link <?php if ($first) echo 'current'; ?>" data-tab="tabs-<?= $tab_id.$item['_id'].$index?>"><span class="numb">0<?php echo __($counter, 'infolio_plg'); ?></span> <?php echo __($item['tab_title'], 'infolio_plg'); ?></li>
                                        <?php $first = false;
                                    endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
<?php
	}
}
