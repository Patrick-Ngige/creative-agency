<?php
namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class TCG_Post_Content extends Widget_Base {
 
	public function get_name() {
		// `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
		return 'tcg-post-content';
	}

	public function get_title() {
		return esc_html__( 'TC Post Content', 'themescamp-core' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	public function get_categories() {
		return [ 'themescamp-elements' ];
	}

	public function get_keywords() {
		return [ 'content', 'post' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'themescamp-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themescamp-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'themescamp-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'themescamp-core' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'themescamp-core' ),
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
				'label' => esc_html__( 'Text Color', 'themescamp-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
	return $this->render_post_content();
	}

	public function render_plain_content() {} 

	public function render_post_content( $with_wrapper = false ) {
		static $did_posts = [];
		$elementor_instance = \Elementor\Plugin::instance();
		$post = get_post();

		if ( post_password_required( $post->ID ) ) {
			echo get_the_password_form( $post->ID );
			return;
		}

		// Avoid recursion
		if ( isset( $did_posts[ $post->ID ] ) ) {
			return;
		}

		$did_posts[ $post->ID ] = true;
		// End avoid recursion

		$editor = $elementor_instance->editor;
		$is_edit_mode = $editor->is_edit_mode();

		if ( !$is_edit_mode && !is_preview() ) { 

			the_content();
		} else {
			echo '<p>This is a sample text for illustrative purposes. It will be replaced with actual post content or an excerpt. <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras facilisis, sem a dapibus dignissim, sapien est volutpat odio, at ullamcorper augue sem nec elit. Fusce in commodo sapien. Nullam at diam nec arcu suscipit efficitur non eget arcu. Sed sit amet eros at elit commodo cursus. Fusce ac enim ex. Vestibulum aliquam, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet gravida sem, vitae cursus tortor gravida sit amet. Aenean vel purus commodo, posuere urna sed, finibus tellus. Mauris auctor, augue a cursus varius, dolor odio dapibus dui, at dapibus sapien orci in orci. Fusce et quam at lorem dapibus finibus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Quisque ut erat a sapien facilisis ullamcorper. Cras non sapien nec est fringilla auctor. Proin non magna at dolor sollicitudin aliquam. Proin vitae tellus in sem aliquet commodo.</p><p>Mauris ut mi nec velit cursus dictum at eu dui. Praesent vel scelerisque mi, vel finibus sem. Proin quis commodo nunc. Morbi a turpis accumsan, ultricies sem nec, cursus arcu. Nulla facilisi. Sed ut velit id augue convallis tincidunt. Fusce non tincidunt mauris, non tempus erat. Proin ut facilisis quam, nec ullamcorper magna. Vestibulum sit amet dolor a dolor dictum rhoncus. Nulla facilisi. Quisque sit amet sapien in sapien iaculis blandit. Aliquam erat volutpat. Sed vel ultrices ipsum, quis ultrices ipsum. Praesent tincidunt, erat ut auctor viverra, lorem erat pharetra libero, nec sollicitudin lorem enim non risus. Nam condimentum, justo et sagittis feugiat, ipsum est ornare libero, at imperdiet magna ante ac enim. Integer faucibus, elit nec consequat elementum, neque sem viverra eros, vitae tempus elit orci a odio. End of the sample content.</p>';
		} // End if().

		// Restore edit mode state
		$elementor_instance->editor->set_edit_mode( $is_edit_mode );
	}
}
\Elementor\Plugin::instance()->widgets_manager->register(new TCG_Post_Content());

