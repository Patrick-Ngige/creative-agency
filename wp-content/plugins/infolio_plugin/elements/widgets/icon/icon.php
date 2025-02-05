<?php
namespace InfolioPlugin\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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

/**
 * Elementor icon widget.
 *
 * Elementor widget that displays an icon from over 600+ icons.
 *
 * @since 1.0.0
 */
class Infolio_Icon extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'infolio-icon';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve icon widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Infolio Icon', 'infolio_plg' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-favorite';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the icon widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
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
	public function get_keywords() {
		return [ 'icon' ];
	}

	/**
	 * Register icon widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'infolio_plg' ),
			]
		);

		$this->add_control(
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
			'view',
			[
				'label' => esc_html__( 'View', 'infolio_plg' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'infolio_plg' ),
					'stacked' => esc_html__( 'Stacked', 'infolio_plg' ),
					'framed' => esc_html__( 'Framed', 'infolio_plg' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => esc_html__( 'Shape', 'infolio_plg' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'infolio_plg' ),
					'square' => esc_html__( 'Square', 'infolio_plg' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'infolio_plg' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'infolio_plg' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'infolio_plg' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'infolio_plg' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'infolio_plg' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .infolio-icon-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon', 'infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'infolio_plg' ),
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.infolio-view-stacked .infolio-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-framed .infolio-icon, {{WRAPPER}}.infolio-view-default .infolio-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-framed .infolio-icon, {{WRAPPER}}.infolio-view-default .infolio-icon svg' => 'fill: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);
        $this->add_control(
            'primary_color_dark',
            [
                'label' => esc_html__( 'Primary Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}.infolio-view-stacked .infolio-icon' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}.infolio-view-stacked .infolio-icon' => 'background-color: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}.infolio-view-framed .infolio-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}.infolio-view-framed .infolio-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}.infolio-view-default .infolio-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}.infolio-view-default .infolio-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}.infolio-view-default .infolio-icon svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}.infolio-view-default .infolio-icon svg' => 'fill: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}.infolio-view-framed .infolio-icon svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}.infolio-view-framed .infolio-icon svg' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );
        $this->add_control(
            'path_color',
            [
                'label' => esc_html__( 'Path Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-icon-wrapper .infolio-icon svg path' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );
        $this->add_control(
            'path_dark_color',
            [
                'label' => esc_html__( 'Path Color ( Dark Mode )', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-icon-wrapper .infolio-icon svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-icon-wrapper .infolio-icon svg path' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );
        $this->add_control(
            'path_stroke_color',
            [
                'label' => esc_html__( 'Path Stroke Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-icon-wrapper .infolio-icon svg path' => 'stroke: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $this->add_control(
            'path_dark_stroke_color',
            [
                'label' => esc_html__( 'Path Stroke Color ( Dark Mode )', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-icon-wrapper .infolio-icon svg path' => 'stroke: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-icon-wrapper .infolio-icon svg path' => 'stroke: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $this->add_control(
			'secondary_color',
			[
				'label' => esc_html__( 'Secondary Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.infolio-view-framed .infolio-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-stacked .infolio-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-stacked .infolio-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'infolio_plg' ),
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.infolio-view-stacked .infolio-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-framed .infolio-icon:hover, {{WRAPPER}}.infolio-view-default .infolio-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-framed .infolio-icon:hover, {{WRAPPER}}.infolio-view-default .infolio-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => esc_html__( 'Secondary Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.infolio-view-framed .infolio-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-stacked .infolio-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}}.infolio-view-stacked .infolio-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'infolio_plg' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .infolio-icon svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'fit_to_size',
			[
				'label' => esc_html__( 'Fit to Size', 'infolio_plg' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => 'Avoid gaps around icons when width and height aren\'t equal',
				'label_off' => esc_html__( 'Off', 'infolio_plg' ),
				'label_on' => esc_html__( 'On', 'infolio_plg' ),
				'condition' => [
					'selected_icon[library]' => 'svg',
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon-wrapper svg' => 'width: 100%;',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .infolio-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'rotate',
			[
				'label' => esc_html__( 'Rotate', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
				'default' => [
					'unit' => 'deg',
				],
				'tablet_default' => [
					'unit' => 'deg',
				],
				'mobile_default' => [
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon i, {{WRAPPER}} .infolio-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => esc_html__( 'Border Width', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

        $this->add_control(
            'opacity',
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
                    '{{WRAPPER}} .infolio-icon' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	/**
	 * Render icon widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'infolio-icon-wrapper' );

		$this->add_render_attribute( 'icon-wrapper', 'class', 'infolio-icon' );

		if ( ! empty( $settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$icon_tag = 'div';

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'icon-wrapper', $settings['link'] );

			$icon_tag = 'a';
		}

		if ( empty( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fa fa-star';
		}

		if ( ! empty( $settings['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<<?php Utils::print_unescaped_internal_string( $icon_tag . ' ' . $this->get_render_attribute_string( 'icon-wrapper' ) ); ?>>
			<?php if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
			else : ?>
				<i <?php $this->print_render_attribute_string( 'icon' ); ?>></i>
			<?php endif; ?>
			</<?php Utils::print_unescaped_internal_string( $icon_tag ); ?>>
		</div>
		<?php
	}

	/**
	 * Render icon widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# const link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
				iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' ),
				iconTag = link ? 'a' : 'div';
		#>
		<div class="infolio-icon-wrapper">
			<{{{ iconTag }}} class="infolio-icon elementor-animation-{{ settings.hover_animation }}" {{{ link }}}>
				<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
					{{{ iconHTML.value }}}
				<# } else { #>
					<i class="{{ settings.icon }}" aria-hidden="true"></i>
				<# } #>
			</{{{ iconTag }}}>
		</div>
		<?php
	}
}
