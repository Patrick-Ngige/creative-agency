<?php
/**
 * Single post Tab For Theme Option.
 *
 * @package tcg
 */

// -> START Single post Options

Redux::setSection($tcg_pre, array(
        'title' => esc_html__('Single Post', 'themescamp-core'),
        'id' => 'blog-single-option',
        'subsection' => false,
        'icon' => 'fa-brands fa-usps',
        'fields' => [
            [
                'id' => 'tcg_single_type_layout',
                'type' => 'button_set',
                'title' => esc_html__('Default Post Layout', 'themescamp-core'),
                'desc' => esc_html__('Note: each Post can be additionally customized within its Meta boxes section.', 'themescamp-core'),
                'options' => [
                    '1' => esc_html__('Elegant', 'themescamp-core'),
                    '2' => esc_html__('Classic', 'themescamp-core'),
                    '3' => esc_html__('Overlay Image', 'themescamp-core')
                ],
                'default' => '2'
            ],
            [
                'id' => 'blog_single_page_title-start',
                'type' => 'section',
                'title' => esc_html__('Page Title', 'themescamp-core'),
                'indent' => true,
            ],
            [
                'id' => 'blog_title_conditional',
                'type' => 'switch',
                'title' => esc_html__('Page Title Text', 'themescamp-core'),
                'on' => esc_html__('Custom', 'themescamp-core'),
                'off' => esc_html__('Default', 'themescamp-core'),
                'default' => true,
            ],
            [
                'id' => 'post_single_page_title_text',
                'type' => 'text',
                'title' => esc_html__('Custom Page Title Text', 'themescamp-core'),
                'default' => esc_html__('Blog Post', 'themescamp-core'),
                'required' => ['blog_title_conditional', '=', true],
            ],
            [
                'id' => 'blog_single_page_title_breadcrumbs_switch',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'themescamp-core'),
                'on' => esc_html__('Use', 'themescamp-core'),
                'off' => esc_html__('Hide', 'themescamp-core'),
                'default' => true,
            ],
            [
                'id' => 'post_single_page_title_bg_image',
                'type' => 'background',
                'title' => esc_html__('Background Image', 'themescamp-core'),
                'preview' => false,
                'preview_media' => true,
                'background-color' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#101d27',
                ],
            ],
            [
                'id' => 'single_padding_layout_3',
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'title' => esc_html__('Padding Top/Bottom', 'themescamp-core'),
                'desc' => esc_html__('Note: this setting affects only the "Overlay Image" post layout.', 'themescamp-core'),
                'default' => [
                    'padding-top' => '320px',
                    'padding-bottom' => '0px',
                ],
            ],
            [
                'id' => 'blog_single_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],

            [
                'id' => 'blog_single_appearance-start',
                'type' => 'section',
                'title' => esc_html__('Appearance', 'themescamp-core'),
                'indent' => true,
                'required' => array( 'tcg_single_type_layout', '=', '2' )
            ],
            [
                'id' => 'featured_image_type', 
                'type' => 'button_set',
                'title' => esc_html__('Featured Image', 'themescamp-core'),
                'options' => [
                    'default' => esc_html__('Default', 'themescamp-core'),
                    'off' => esc_html__('Off', 'themescamp-core'),
                ],
                'default' => 'default'
            ],


            [
                'id' => 'blog_single_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],



            [
                'id' => 'single_post_related-start',
                'type' => 'section',
                'title' => esc_html__('Related posts', 'themescamp-core'),
                'indent' => true,
            ],
            [
                'title' => esc_html__( 'Single Related Post Count', 'themescamp-core' ),
                'id' => 'related_perpage',
                'type' => 'slider',
                'default' => 3,
                'min' => 1,
                'step' => 1,
                'max' => 24,
                'display_value' => 'text',
                //'required' => array( 'single_related_visibility', '=', '1' )
            ],
            [
                'id' => 'tcg_related_layout',
                'type' => 'button_set',
                'title' => esc_html__('Default Post Layout', 'themescamp-core'),
                'desc' => esc_html__('Note: each Post can be additionally customized within its Meta boxes section.', 'themescamp-core'),
                'options' => [
                    '0' => esc_html__('None', 'themescamp-core'),
                    '1' => esc_html__('Standard', 'themescamp-core'),
                    '2' => esc_html__('Slider', 'themescamp-core')
                ],
                'default' => '1'
            ],
            [
                'id' => 'single_post_extras-start',
                'type' => 'section',
                'title' => esc_html__('Post Extras', 'themescamp-core'),
                'indent' => true,
            ],

            [
                'id' => 'tcg_post_share_box',
                'type' => 'switch',
                'title' => esc_html__('Share Box', 'themescamp-core'),
                'default' => false
            ],
        ]
));

?>