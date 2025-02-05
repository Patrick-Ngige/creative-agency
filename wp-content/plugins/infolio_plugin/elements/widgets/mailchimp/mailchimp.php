<?php
namespace infolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


		
/**
 * @since 1.0.0
 */
class infolio_MailChimp extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'infolio-mailchimp';
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
	public function get_title() {
		return __( 'infolio MailChimp Form', 'infolio_plg' );
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
	public function get_icon() {
		return 'fa fa-wpforms';
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
	public function get_categories() {
		return [ 'infolio-elements' ];
	}


		/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'from', 'input', 'contact' ];
	}

    
    public function infolio_mailChimp_forms(){
        $formlist = array();
        $forms_args = array( 
        	'posts_per_page' => -1,
        	'post_status' => 'publish',
        	'post_type'=> 'mwp_form', 
        );

        $forms = get_posts( $forms_args );
        if( $forms ){
            foreach ( $forms as $form ){
                $formlist[$form->ID] = $form->form_id;
            }
        }else{
            $formlist['0'] = __('Form not found', 'infolio_plg');
        }
        return $formlist;
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
	protected function _register_controls() {
	
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'MailChimp form', 'infolio_plg' ),
			]
		);

        $this->add_control(
			'form_id',
			[
				'label' => __( 'Select MailChimp form', 'infolio_plg' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => array_keys($this->infolio_mailChimp_forms())[0],
			]
		);

		$this->add_control(
			'form_layout',
			[
				'label' => __( 'Layout', 'infolio_plg' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'button-inside' => __( 'Button Inside', 'infolio_plg' ),
					'button-under' => __( 'Button Under', 'infolio_plg' ),
				],
				'default' => 'button-inside',
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'form_settings',
			[
				'label' => __( 'Form Setting','infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'input_height',
			[
				'label' => __( 'Input height', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp.button-inside input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'form_placeholder_typography',
				'label'     => __( 'Typography', 'infolio_plg' ),
				'selector'  => '{{WRAPPER}} .infolio-mailchimp input',
			]
		);
		
		$this->add_control(
			'form_placeholder',
			[
				'label' => __( 'Placeholder Color','infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp input::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp input:-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp input:-moz-placeholder' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_control(
			'form_text',
			[
				'label' => __( 'Text Color','infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .infolio-mailchimp input:not(.wpcf7-submit) ' => 'color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp textarea' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'form_bg',
			[
				'label' => __( 'Background Color','infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_height',
			[
				'label' => __( 'Fields height', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_group_alignment',
			[
				'label' => __('Alignment', 'infolio_plg'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'infolio_plg'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'infolio_plg'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'infolio_plg'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input, {{WRAPPER}} .infolio-mailchimp textarea' => 'text-align: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'form_border',
				'label' => esc_html__( 'Border', 'infolio_plg' ),
				'selector' => '{{WRAPPER}} .infolio-mailchimp input, {{WRAPPER}} .infolio-mailchimp textarea',
			]
		);
		
		$this->add_responsive_control(
			'form_border_radius',
			[
				'label' => __( 'Border Radius', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp textarea' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'form_padding',
			[
				'label' => __( 'Padding', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp textarea' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'form_margin',
			[
				'label' => __( 'Margin', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp textarea' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'form_group_margin',
			[
				'label' => __( 'Form Group Margin', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .form-group' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'form_border_clr',
			[
				'label' => __( 'Border Color','infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .infolio-mailchimp input' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp textarea' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'form_border_color_active',
			[
				'label' => __( 'Border Color on Focus','infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp input:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp textarea:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'fields_box_shadow',
				'selector' => '{{WRAPPER}} .infolio-mailchimp input, {{WRAPPER}} .infolio-mailchimp select, {{WRAPPER}} .infolio-mailchimp textarea',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_settings',
			[
				'label' => __( 'Icon Setting','infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'x_positioning',
			[
				'label' => __('X Positioning', 'infolio_plg'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'infolio_plg'),
						'icon' => 'eicon-text-align-left',
					],
					'right' => [
						'title' => __('Right', 'infolio_plg'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->add_responsive_control(
			'icon_x',
			[
				'label' => __( 'Icon X Position', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .icon' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
				'condition' => [
					'x_positioning' => 'left'
				]
			]
		);

		$this->add_responsive_control(
			'icon_x_right',
			[
				'label' => __( 'Icon X Position', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .icon' => 'right: {{SIZE}}{{UNIT}}; left: auto ;',
				],
				'condition' => [
					'x_positioning' => 'right'
				]
			]
		);

		$this->add_responsive_control(
			'icon_y',
			[
				'label' => __( 'Icon Y position', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .icon' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_wrapper_width',
			[
				'label' => __( 'Icon Wrapper Width', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .icon' => 'width: {{SIZE}}{{UNIT}}; text-align: center;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_wrapper_height',
			[
				'label' => __( 'Icon Wrapper Height', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .icon' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => esc_html__( 'Border', 'infolio_plg' ),
				'selector' => '{{WRAPPER}} .infolio-mailchimp .icon',
			]
		);
		
		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color','infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'btn_settings',
			[
				'label' => __( 'Button Setting','infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'btn_width',
			[
				'label' => __( 'Button Width', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp.button-inside button' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp .infolio-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_height',
			[
				'label' => __( 'Button height', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp.button-inside button' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'form_layout' => 'button-inside'
				]
			]
		);

		$this->add_responsive_control(
			'btn_x',
			[
				'label' => __( 'Button X Position', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp.button-inside button' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'form_layout' => 'button-inside'
				]
			]
		);

		$this->add_responsive_control(
			'btn_y',
			[
				'label' => __( 'Button Y position', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp.button-inside button' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'form_layout' => 'button-inside'
				]
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Button Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp button span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp .infolio-button' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'btn_typography',
				'label'     => __( 'Button Typography', 'infolio_plg' ),
				'selector'  => '{{WRAPPER}} .infolio-mailchimp button',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'btn_background',
				'label' => __('Button Backround', 'infolio_plg'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .infolio-mailchimp button, {{WRAPPER}} .infolio-mailchimp .infolio-button',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'btn_background_hover',
				'label' => __('Button Backround', 'infolio_plg'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .infolio-mailchimp button:hover',
			]
		);

		$this->add_control(
			'btn_background_hover_animation',
			[
				'label' => esc_html__( 'Button Hover Animation Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .infolio-button .infolio-button-circle' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'btn_margin',
			[
				'label' => __( 'Margin', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .infolio-button' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp.button-inside button' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => __( 'Padding', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} .infolio-mailchimp .infolio-button, {{WRAPPER}} .infolio-mailchimp button',
                'separator' => 'before',
            ]
        );
		
		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => __( 'Border Radius', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp .infolio-button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'btn_icon_settings',
			[
				'label' => __( 'Button Icon Setting','infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_icon_color',
			[
				'label' => esc_html__( 'Button Icon Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp button i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .infolio-mailchimp button svg' => 'fill: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'btn_icon_margin',
			[
				'label' => __( 'Button Icon Margin', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp button i' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp button svg' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_icon_size',
			[
				'label' => __( 'Icon Size', 'infolio_plg' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-mailchimp button i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .infolio-mailchimp button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$id = $settings['form_id' ];
		$shortcode=do_shortcode( '[mc4wp_form id="'. $id .'"]' );

		?>

		<div class="infolio-mailchimp <?php echo esc_attr($settings['form_layout']); ?>"><?php echo $shortcode; ?></div>

		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() { 
	
	}
}


