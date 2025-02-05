<?php
namespace InfolioPlugin\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Group_Control_Background;


/**
 * Elementor icon widget.
 *
 * Elementor widget that displays an icon from over 600+ icons.
 *
 * @since 1.0.0
 */
class Infolio_Search extends Widget_Base {

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
        return 'infolio-search';
    }

    public function get_script_depends() {
        return ['infolio-search'];
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
        return esc_html__( 'infolio Search', 'infolio_plg' );
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
        return 'eicon-search';
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
    public function get_categories() {
        return [ 'infolio-menu-elements' ];
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
        return [ 'search', 'icon', 'link' ];
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
            'search_style',
            [
                'label'   => __('Search Form Style', 'infolio_plg'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'field' => __('Field', 'infolio_plg'),
                    'icon' =>  __('Icon', 'infolio_plg'),
                ],
                'default' => 'field',
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
            'open_icon',
            [
                'label' => esc_html__( 'Open Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
                'condition'=>['search_style'=>'icon'],
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );
        $this->add_control(
            'close_icon',
            [
                'label' => esc_html__( 'Close Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
                'condition'=>['search_style'=>'icon'],
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'place_holder_text',
            [
                'label' => __('Place Holder Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Search', 'infolio_plg'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'field_style',
            [
                'label' => __( 'Field Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'infolio_plg'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'field_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field .searchform .searchsubmit svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-icon .searchsubmit svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-field .searchform .searchsubmit' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-icon .searchsubmit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_icon_color_dark',
            [
                'label' => esc_html__( 'Icon Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-search-field .searchform .searchsubmit svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-search-field .searchform .searchsubmit svg' => 'fill: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-search-icon .searchsubmit svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-search-icon .searchsubmit svg' => 'fill: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-search-field .searchform .searchsubmit' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-search-field .searchform .searchsubmit' => 'color: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-search-icon .searchsubmit' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-search-icon .searchsubmit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'close_open_icon_color',
            [
                'label' => esc_html__( 'Close/Open Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['search_style'=>'icon'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-icon .search-icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-icon .search-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'close_open_icon_color_dark',
            [
                'label' => esc_html__( 'Close/Open Icon Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['search_style'=>'icon'],
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-search-icon .search-icon svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-search-icon .search-icon svg' => 'fill: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-search-icon .search-icon i' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-search-icon .search-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field .searchform .searchsubmit svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-search-icon .searchsubmit svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-search-field .searchform .searchsubmit i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-search-icon .searchsubmit i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'field_heading',
            [
                'label' => esc_html__('Field', 'infolio_plg'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'field_text',
            [
                'label' => esc_html__( 'Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field .searchform input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-icon input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_text_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-search-field .searchform input,{{WRAPPER}} .infolio-search-icon input',
            ]
        );

        $this->add_control(
            'field_text_placeholder',
            [
                'label' => esc_html__( 'Placeholder Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field .searchform input::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-icon input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_bg',
            [
                'label' => esc_html__( 'Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field input' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-icon input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label' => __('padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field input' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-search-icon input' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'label' => esc_html__( 'Border', 'infolio_plg' ),
                'selector' => '{{WRAPPER}} .infolio-search-field input ,{{WRAPPER}} .infolio-search-icon input ',
            ]
        );

        $this->add_control(
            'field_focus_border_color',
            [
                'label' => esc_html__( 'Focus Border Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field input:focus' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-search-icon input:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_border_radius',
            [
                'label' => __('Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-search-field input' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-search-icon input' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $settings = $this->get_settings_for_display();?>
        <?php if($settings['search_style'] == 'field'): ?>
            <div class="infolio-search-field">
                <?php $infolio_unique_id = infolio_unique_id( 'search-form-' ); ?>
                <form role="search" method="get" id="<?php echo esc_attr( $infolio_unique_id ); ?>" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" placeholder="<?php echo esc_attr__($settings['place_holder_text'],'infolio'); ?>" value="<?php get_search_query()?>" name="s">
                        <button type="submit" class="searchsubmit right">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'features-icon' ] ); ?>
                        </button>
                </form>
            </div>
        <?php else:?>
            <div class="infolio-search-form">
                <div class="infolio-search-icon">
                    <div class="form-group">
                        <?php $infolio_unique_id = infolio_unique_id( 'search-form-' ); ?>
                        <form role="search" method="get" id="<?php echo esc_attr( $infolio_unique_id ); ?>" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <input type="text" name="s" placeholder="<?php echo esc_attr__($settings['place_holder_text'],'infolio'); ?>" value="<?php get_search_query()?>">
                            <button type="submit" class="searchsubmit">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'features-icon' ] ); ?>
                            </button>
                        </form>
                    </div>
                    <div class="search-icon">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['open_icon'], [ 'aria-hidden' => 'true', 'class' => 'open-search' ] ); ?>
                        <?php \Elementor\Icons_Manager::render_icon( $settings['close_icon'], [ 'aria-hidden' => 'true', 'class' => 'close-search' ] ); ?>
                    </div>
                </div>
            </div>
        <?php endif;?>
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
    protected function content_template() {}
}
