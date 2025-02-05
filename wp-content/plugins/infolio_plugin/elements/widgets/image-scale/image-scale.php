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
 * Elementor image widget.
 *
 * Elementor widget that displays an image into the page.
 *
 * @since 1.0.0
 */
class Infolio_Image_Scale extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve image widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'infolio-image-scale';
    }

    /**
     * Get widget title.
     *
     * Retrieve image widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Infolio Image Scale', 'infolio_plg' );
    }

    public function get_script_depends()
    {
        return ['gsap.min','ScrollTrigger.min','Youtube-Popup.min','infolio-youtube-popup'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve image widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-image';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the image widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
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
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'image', 'photo', 'visual' ];
    }

    /**
     * Register image widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__( 'Image Scale', 'infolio_plg' ),
            ]
        );

        $this->add_responsive_control(
            'container_height',
            [
                'label' => esc_html__( 'Container Height', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 800,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default' => 'large',
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
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
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption',
            [
                'label' => __('Caption', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'caption_text',
            [
                'label' => esc_html__( 'Custom Caption', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => esc_html__( 'Enter your image caption', 'infolio_plg' ),
                'condition' => ['caption' => 'yes'],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'youtube_button',
            [
                'label' => __('Video Button', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'youtube_link',
            [
                'label' => esc_html__( 'Video Link', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::URL,
                'condition' => ['youtube_button' => 'yes'],
                'dynamic' => [
                    'active' => true,
                ],
                'show_label' => false,
            ]
        );
        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
                'condition' => ['youtube_button' => 'yes'],
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label' => esc_html__( 'Link', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__( 'None', 'infolio_plg' ),
                    'file' => esc_html__( 'Media File', 'infolio_plg' ),
                    'custom' => esc_html__( 'Custom URL', 'infolio_plg' ),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'link_to' => 'custom',
                ],
                'show_label' => false,
            ]
        );

        $this->add_control(
            'open_lightbox',
            [
                'label' => esc_html__( 'Lightbox', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'description' => sprintf(
                /* translators: 1: Link open tag, 2: Link close tag. */
                    esc_html__( 'Manage your site’s lightbox settings in the %1$sLightbox panel%2$s.', 'infolio_plg' ),
                    '<a href="javascript: $e.run( \'panel/global/open\' ).then( () => $e.route( \'panel/global/settings-lightbox\' ) )">',
                    '</a>'
                ),
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'infolio_plg' ),
                    'yes' => esc_html__( 'Yes', 'infolio_plg' ),
                    'no' => esc_html__( 'No', 'infolio_plg' ),
                ],
                'condition' => [
                    'link_to' => 'file',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__( 'View', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__( 'Image', 'infolio_plg' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label' => __('Overlay Opacity', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'min' => '0',
                'max' => '10',
                'step' => '0.1',
                'default'=>'4',
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label' => esc_html__( 'Max Width', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Height', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-fit',
            [
                'label' => esc_html__( 'Object Fit', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'condition' => [
                    'image_height[size]!' => '',
                ],
                'options' => [
                    '' => esc_html__( 'Default', 'infolio_plg' ),
                    'fill' => esc_html__( 'Fill', 'infolio_plg' ),
                    'cover' => esc_html__( 'Cover', 'infolio_plg' ),
                    'contain' => esc_html__( 'Contain', 'infolio_plg' ),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-position',
            [
                'label' => esc_html__( 'Object Position', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__( 'Center Center', 'infolio_plg' ),
                    'center left' => esc_html__( 'Center Left', 'infolio_plg' ),
                    'center right' => esc_html__( 'Center Right', 'infolio_plg' ),
                    'top center' => esc_html__( 'Top Center', 'infolio_plg' ),
                    'top left' => esc_html__( 'Top Left', 'infolio_plg' ),
                    'top right' => esc_html__( 'Top Right', 'infolio_plg' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'infolio_plg' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'infolio_plg' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'infolio_plg' ),
                ],
                'default' => 'center center',
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale img' => 'object-position: {{VALUE}};',
                ],
                'condition' => [
                    'object-fit' => 'cover',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'image_effects' );
        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'infolio_plg' ),
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
                    '{{WRAPPER}} .infolio-img-scale img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .infolio-img-scale img',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'opacity_hover',
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
                    '{{WRAPPER}}:hover .infolio-img-scale img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}}:hover .infolio-img-scale img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );
//
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .infolio-img-scale img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_caption',
            [
                'label' => esc_html__( 'Caption', 'infolio_plg' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['caption' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'caption_align',
            [
                'label' => esc_html__( 'Alignment', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale h2' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-img-scale h2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typography',
                'selector' => '{{WRAPPER}} .infolio-img-scale h2',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'styled_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-img-scale h2 span',
            ]
        );
        $this->end_controls_section();
    }
    /**
     * Render image widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="infolio-img-scale">
            <div class="image" data-overlay-dark="<?=esc_attr($settings['overlay_opacity'])?>">
                <div class="img">
                    <img id="grow" src="<?=esc_url($settings['image']['url'])?>" alt="<?php if (!empty($settings['image']['alt'])) echo esc_attr($settings['image']['alt']); ?>" data-speed="0.2" data-lag="0">
                    <?php if ($settings['youtube_button']=='yes') : ?>
                        <a href="<?=esc_url($settings['youtube_link']['url'])?>" class="vid d-flex align-items-center justify-content-center" <?php if ( $settings['youtube_link']['is_external'] ) echo'target="_blank"'; ?>>
                            <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if ($settings['caption']=='yes') : ?>
                <div class="text-center caption">
                    <h2><?=$settings['caption_text']?></h2>
                </div>
                <?php endif;?>
            </div>
        </div>
        <?php
    }

    /**
     * Render image widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template() {

    }

    /**
     * Retrieve image widget link URL.
     *
     * @since 3.11.0
     * @access protected
     *
     * @param array $settings
     *
     * @return array|string|false An array/string containing the link URL, or false if no link.
     */
}
