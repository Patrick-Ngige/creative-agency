<?php
namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TCG_Post_Comments extends Widget_Base {

    public function get_name() {
        return 'tcg-comments';
    }

    public function get_title() {
        return __( 'TCG Post Comments', 'themescamp-plugin' );
    }

    public function get_icon() {
        return 'eicon-comments';
    }

    public function get_categories() {
        return [ 'themescamp-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'themescamp-plugin' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            '_skin',
            [
                'type' => Controls_Manager::HIDDEN,
            ]
        );

        $this->add_control(
            'skin_temp',
            [
                'label' => esc_html__( 'Skin', 'themescamp-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Theme Comments', 'themescamp-core' ),
                ],
                'description' => esc_html__( 'The Theme Comments skin uses the currently active theme comments design and layout to display the comment form and comments.', 'themescamp-core' ),
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {
        comments_template();
    }

    protected function _content_template() {
        // You can include a JS-based template for live preview here, 
        // but for simplicity, we will not include one in this example.
    }
}
