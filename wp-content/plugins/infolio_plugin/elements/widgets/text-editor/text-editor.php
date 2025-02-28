<?php
namespace infolioPlugin\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;

/**
 * Elementor text editor widget.
 *
 * Elementor widget that displays a WYSIWYG text editor, just like the WordPress
 * editor.
 *
 * @since 1.0.0
 */
class infolio_Text_Editor extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve text editor widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'infolio-text-editor';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve text editor widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'infolio Text Editor', 'infolio_plg' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve text editor widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-text';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the text editor widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
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
		return [ 'text', 'editor' ];
	}

	/**
	 * Register text editor widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_editor',
			[
				'label' => esc_html__( 'Text Editor', 'infolio_plg' ),
			]
		);

		$this->add_control(
			'editor',
			[
				'label' => '',
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'infolio_plg' ) . '</p>',
			]
		);

		$this->add_control(
			'drop_cap', [
				'label' => esc_html__( 'Drop Cap', 'infolio_plg' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'infolio_plg' ),
				'label_on' => esc_html__( 'On', 'infolio_plg' ),
				'prefix_class' => 'elementor-drop-cap-',
				'frontend_available' => true,
			]
		);

		$text_columns = range( 1, 10 );
		$text_columns = array_combine( $text_columns, $text_columns );
		$text_columns[''] = esc_html__( 'Default', 'infolio_plg' );

		$this->add_responsive_control(
			'text_columns',
			[
				'label' => esc_html__( 'Columns', 'infolio_plg' ),
				'type' => Controls_Manager::SELECT,
				'separator' => 'before',
				'options' => $text_columns,
				'selectors' => [
					'{{WRAPPER}}' => 'columns: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Columns Gap', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vw' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'%' => [
						'max' => 10,
						'step' => 0.1,
					],
					'vw' => [
						'max' => 10,
						'step' => 0.1,
					],
					'em' => [
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Text Editor', 'infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'infolio_plg' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'text_color_dark',
            [
                'label' => esc_html__( 'Text Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'opacity',
			[
				'label' => __('Opacity', 'infolio_plg'),
				'type' => Controls_Manager::NUMBER,
				'min' => '0',
				'max' => '1',
				'step' => '0.1',
				'selectors' => [
					'{{WRAPPER}}' => 'opacity: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'links_color',
			[
				'label' => esc_html__( 'Links Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .infolio-text-editor a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'links_color_hover',
			[
				'label' => esc_html__( 'Links Color Hover', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .infolio-text-editor a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Text Typography', 'infolio_plg'),
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .infolio-text-editor, {{WRAPPER}} .infolio-text-editor p',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Links Typography', 'infolio_plg'),
				'name' => 'links_typography',
				'selector' => '{{WRAPPER}} .infolio-text-editor a',
			]
		);

		$this->add_control(
			'stroke_width',
			[
				'label' => __('Stroke Width', 'infolio_plg'),
				'type' => Controls_Manager::NUMBER,
				'selectors' => [
					'{{WRAPPER}} .infolio-text-editor a' => '-webkit-text-stroke-width: {{VALUE}}px;'
				]
			]
		);

		$this->add_control(
			'stroke_color',
			[
				'label' => __('Stroke Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-text-editor a' => '-webkit-text-stroke-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Links Hover Typography', 'infolio_plg'),
				'name' => 'links_hover_typography',
				'selector' => '{{WRAPPER}} .infolio-text-editor a:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_drop_cap',
			[
				'label' => esc_html__( 'Drop Cap', 'infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'drop_cap' => 'yes',
				],
			]
		);

		$this->add_control(
			'drop_cap_view',
			[
				'label' => esc_html__( 'View', 'infolio_plg' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'infolio_plg' ),
					'stacked' => esc_html__( 'Stacked', 'infolio_plg' ),
					'framed' => esc_html__( 'Framed', 'infolio_plg' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-drop-cap-view-',
			]
		);

		$this->add_control(
			'drop_cap_primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap, {{WRAPPER}}.elementor-drop-cap-view-default .elementor-drop-cap' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'drop_cap_secondary_color',
			[
				'label' => esc_html__( 'Secondary Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'color: {{VALUE}};',
				],
				'condition' => [
					'drop_cap_view!' => 'default',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'drop_cap_shadow',
				'selector' => '{{WRAPPER}} .elementor-drop-cap',
			]
		);

		$this->add_control(
			'drop_cap_size',
			[
				'label' => esc_html__( 'Size', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-drop-cap' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'drop_cap_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'drop_cap_space',
			[
				'label' => esc_html__( 'Space', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-drop-cap' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .elementor-drop-cap' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'drop_cap_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-drop-cap' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'drop_cap_border_width', [
				'label' => esc_html__( 'Border Width', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-drop-cap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'drop_cap_view' => 'framed',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'drop_cap_typography',
				'selector' => '{{WRAPPER}} .elementor-drop-cap-letter',
				'exclude' => [
					'letter_spacing',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render text editor widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$is_dom_optimized = Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		$is_edit_mode = Plugin::$instance->editor->is_edit_mode();
		$should_render_inline_editing = ( ! $is_dom_optimized || $is_edit_mode );

		$editor_content = $this->get_settings_for_display( 'editor' );
		$editor_content = $this->parse_text_editor( $editor_content );
		?>
		<div class="infolio-text-editor">
			<?php
			if ( $should_render_inline_editing ) {
				$this->add_render_attribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );
			}

			$this->add_inline_editing_attributes( 'editor', 'advanced' );
			?>
			<?php if ( $should_render_inline_editing ) { ?>
				<div <?php $this->print_render_attribute_string( 'editor' ); ?>>
			<?php } ?>
			<?php // PHPCS - the main text of a widget should not be escaped.
					echo $editor_content;
				// phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php if ( $should_render_inline_editing ) { ?>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Render text editor widget as plain content.
	 *
	 * Override the default behavior by printing the content without rendering it.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_plain_content() {
		// In plain mode, render without shortcode
		$this->print_unescaped_setting( 'editor' );
	}

	/**
	 * Render text editor widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
	}
}
