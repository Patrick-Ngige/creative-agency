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
class infolio_Image extends \Elementor\Widget_Base {

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
        return 'infolio-image';
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
        return esc_html__( 'infolio Image', 'infolio_plg' );
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
                'label' => esc_html__( 'Image', 'infolio_plg' ),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'infolio_plg' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
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
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption_source',
            [
                'label' => esc_html__( 'Caption', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'infolio_plg' ),
                    'attachment' => esc_html__( 'Attachment Caption', 'infolio_plg' ),
                    'custom' => esc_html__( 'Custom Caption', 'infolio_plg' ),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'caption',
            [
                'label' => esc_html__( 'Custom Caption', 'infolio_plg' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__( 'Enter your image caption', 'infolio_plg' ),
                'condition' => [
                    'caption_source' => 'custom',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label' => esc_html__( 'Link', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
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
                'type' => Controls_Manager::URL,
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
                'type' => Controls_Manager::SELECT,
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
//        infolio style
        $this->add_control(
            'image_moving_animation',
            [
                'label' => __('Image Moving Animation', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'animation_speed',
            [
                'label' => esc_html__( 'Animation Speed', 'infolio_plg' ) . ' (s)',
                'type' => Controls_Manager::NUMBER,
                'default' => '0.2',
                'min' => 0,
                'step' => 0.1,
                'condition' => [
                    'image_moving_animation' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'animation_lag',
            [
                'label' => esc_html__( 'Animation Lag', 'infolio_plg' ) . ' (s)',
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
                'min' => 0,
                'step' => 0.1,
                'condition' => [
                    'image_moving_animation' => 'yes',
                ],
            ]
        );
//        end of infolio style

        $this->add_control(
            'view',
            [
                'label' => esc_html__( 'View', 'infolio_plg' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__( 'Image', 'infolio_plg' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'infolio_plg' ),
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
                    '{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label' => esc_html__( 'Max Width', 'infolio_plg' ),
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
                    '{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-fit',
            [
                'label' => esc_html__( 'Object Fit', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'height[size]!' => '',
                ],
                'options' => [
                    '' => esc_html__( 'Default', 'infolio_plg' ),
                    'fill' => esc_html__( 'Fill', 'infolio_plg' ),
                    'cover' => esc_html__( 'Cover', 'infolio_plg' ),
                    'contain' => esc_html__( 'Contain', 'infolio_plg' ),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-position',
            [
                'label' => esc_html__( 'Object Position', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
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
                    '{{WRAPPER}} img' => 'object-position: {{VALUE}};',
                ],
                'condition' => [
                    'object-fit' => 'cover',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type' => Controls_Manager::DIVIDER,
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
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} img',
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
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}}:hover img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'transition-duration: {{SIZE}}s',
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

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_caption',
            [
                'label' => esc_html__( 'Caption', 'infolio_plg' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'caption_source!' => 'none',
                ],
            ]
        );

        $this->add_responsive_control(
            'caption_align',
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
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
                    '{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
            ]
        );

        $this->add_control(
            'caption_background_color',
            [
                'label' => esc_html__( 'Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typography',
                'selector' => '{{WRAPPER}} .widget-image-caption',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'caption_text_shadow',
                'selector' => '{{WRAPPER}} .widget-image-caption',
            ]
        );

        $this->add_responsive_control(
            'caption_space',
            [
                'label' => esc_html__( 'Spacing', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Check if the current widget has caption
     *
     * @access private
     * @since 2.3.0
     *
     * @param array $settings
     *
     * @return boolean
     */
    private function has_caption( $settings ) {
        return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
    }

    /**
     * Get the caption for current widget.
     *
     * @access private
     * @since 2.3.0
     * @param $settings
     *
     * @return string
     */
    private function get_caption( $settings ) {
        $caption = '';
        if ( ! empty( $settings['caption_source'] ) ) {
            switch ( $settings['caption_source'] ) {
                case 'attachment':
                    $caption = wp_get_attachment_caption( $settings['image']['id'] );
                    break;
                case 'custom':
                    $caption = ! Utils::is_empty( $settings['caption'] ) ? $settings['caption'] : '';
            }
        }
        return $caption;
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

        if ( empty( $settings['image']['url'] ) ) {
            return;
        }
        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings);

        if ($settings['image_moving_animation'] == 'yes') {
            if (!empty($settings['animation_speed'])){
                $animation_speed = doubleval($settings['animation_speed']);
            }else{
                $animation_speed='auto';
            }
            $animation_lag = doubleval($settings['animation_lag']);
            $image_html = str_replace('<img ', "<img data-speed='$animation_speed' data-lag='$animation_lag' ", $image_html);
        }

        if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) {
            $this->add_render_attribute( 'wrapper', 'class', 'elementor-image' );
        }


        $has_caption = $this->has_caption( $settings );

        $link = $this->get_link_url( $settings );

        if ( $link ) {
            $this->add_link_attributes( 'link', $link );

            if ( Plugin::$instance->editor->is_edit_mode() ) {
                $this->add_render_attribute( 'link', [
                    'class' => 'elementor-clickable',
                ] );
            }

            if ( 'custom' !== $settings['link_to'] ) {
                $this->add_lightbox_data_attributes( 'link', $settings['image']['id'], $settings['open_lightbox'] );
            }
        } ?>
        <?php if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) { ?>
            <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
        <?php } ?>
        <?php if ( $has_caption ) : ?>
        <figure class="wp-caption">
    <?php endif; ?>
        <?php if ( $link ) : ?>
        <a <?php $this->print_render_attribute_string( 'link' ); ?>>
    <?php endif; ?>
        <?php echo $image_html; ?>
        <?php if ( $link ) : ?>
        </a>
    <?php endif; ?>
        <?php if ( $has_caption ) : ?>
            <figcaption class="widget-image-caption wp-caption-text"><?php
                echo wp_kses_post( $this->get_caption( $settings ) );
                ?></figcaption>
        <?php endif; ?>
        <?php if ( $has_caption ) : ?>
        </figure>
    <?php endif; ?>
        <?php if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) { ?>
            </div>
        <?php } ?>
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
        ?>
        <# if ( settings.image.url ) {
        var image = {
        id: settings.image.id,
        url: settings.image.url,
        size: settings.image_size,
        dimension: settings.image_custom_dimension,
        model: view.getEditModel()
        };

        var image_url = elementor.imagesManager.getImageUrl( image );

        if ( ! image_url ) {
        return;
        }

        var hasCaption = function() {
        if( ! settings.caption_source || 'none' === settings.caption_source ) {
        return false;
        }
        return true;
        }

        var ensureAttachmentData = function( id ) {
        if ( 'undefined' === typeof wp.media.attachment( id ).get( 'caption' ) ) {
        wp.media.attachment( id ).fetch().then( function( data ) {
        view.render();
        } );
        }
        }

        var getAttachmentCaption = function( id ) {
        if ( ! id ) {
        return '';
        }
        ensureAttachmentData( id );
        return wp.media.attachment( id ).get( 'caption' );
        }

        var getCaption = function() {
        if ( ! hasCaption() ) {
        return '';
        }
        return 'custom' === settings.caption_source ? settings.caption : getAttachmentCaption( settings.image.id );
        }

        var link_url;

        if ( 'custom' === settings.link_to ) {
        link_url = settings.link.url;
        }

        if ( 'file' === settings.link_to ) {
        link_url = settings.image.url;
        }

        <?php if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) { ?>
            #><div class="elementor-image{{ settings.shape ? ' elementor-image-shape-' + settings.shape : '' }}"><#
        <?php } ?>

        var imgClass = '';

        if ( '' !== settings.hover_animation ) {
        imgClass = 'elementor-animation-' + settings.hover_animation;
        }

        if ( hasCaption() ) {
        #><figure class="wp-caption"><#
            }

            if ( link_url ) {
            #><a class="elementor-clickable" data-elementor-open-lightbox="{{ settings.open_lightbox }}" href="{{ link_url }}"><#
                }
                #><img src="{{ image_url }}" class="{{ imgClass }}" /><#

                if ( link_url ) {
                #></a><#
            }

            if ( hasCaption() ) {
            #><figcaption class="widget-image-caption wp-caption-text">{{{ getCaption() }}}</figcaption><#
            }

            if ( hasCaption() ) {
            #></figure><#
        }

        <?php if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) { ?>
            #></div><#
        <?php } ?>

        } #>
        <?php
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
    protected function get_link_url( $settings ) {
        if ( 'none' === $settings['link_to'] ) {
            return false;
        }

        if ( 'custom' === $settings['link_to'] ) {
            if ( empty( $settings['link']['url'] ) ) {
                return false;
            }

            return $settings['link'];
        }

        return [
            'url' => $settings['image']['url'],
        ];
    }
}
