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


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function infolio_breadcrumbs(){



    # breadcrumbs ----------

    $home_text  = esc_html__( 'Home', 'infolio' );
    $before     = '<span><span class="current">';
    $after      = '</span></span>';

    $breadcrumbs = array();


    # WordPress breadcrumbs ----------
    if ( ! is_home() && ! is_front_page() || is_paged() ){

        $post     = get_post();
        $home_url = esc_url(home_url( '/' ));

        # Home ----------
        $breadcrumbs[] = array(
            'url'   => $home_url,
            'name'  => $home_text,
        );

        # Category ----------
        if ( is_category() ){

            $category = get_query_var( 'cat' );
            $category = get_category( $category );

            if( $category->parent !== 0 ){

                $parent_categories = array_reverse( get_ancestors( $category->cat_ID, 'category' ) );

                foreach ( $parent_categories as $parent_category ) {
                    $breadcrumbs[] = array(
                        'url'  => cached_get_term_link( $parent_category, 'category' ),
                        'name' => get_cat_name( $parent_category ),
                    );
                }
            }

            $breadcrumbs[] = array(
                'name' => get_cat_name( $category->cat_ID ),
            );
        }

        # Day ----------
        elseif ( is_day() ){

            $breadcrumbs[] = array(
                'url'  => get_year_link( get_the_time( 'Y' ) ),
                'name' => get_the_time( 'Y' ),
            );

            $breadcrumbs[] = array(
                'url'  => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
                'name' => get_the_time( 'F' ),
            );

            $breadcrumbs[] = array(
                'name' => get_the_time( 'd' ),
            );
        }


        # Month ----------
        elseif ( is_month() ){

            $breadcrumbs[] = array(
                'url'  => get_year_link( get_the_time( 'Y' ) ),
                'name' => get_the_time( 'Y' ),
            );

            $breadcrumbs[] = array(
                'name' => get_the_time( 'F' ),
            );
        }

        # Year ----------
        elseif ( is_year() ){

            $breadcrumbs[] = array(
                'name' => get_the_time( 'Y' ),
            );
        }

        # Tag ----------
        elseif ( is_tag() ){

            $breadcrumbs[] = array(
                'name' => get_the_archive_title(),
            );
        }

        # Author ----------
        elseif ( is_author() ){

            $author = get_query_var( 'author' );
            $author = get_userdata($author);

            $breadcrumbs[] = array(
                'name' => $author->display_name,
            );
        }

        # 404 ----------
        elseif ( is_404() ){

            $breadcrumbs[] = array(
                'name' => esc_html_e( ' ' , 'infolio'  ),
            );
        }

        # Pages ----------
        elseif ( is_page() ){

            if ( $post->post_parent ){

                $parent_id   = $post->post_parent;
                $page_parents = array();

                while ( $parent_id ){
                    $get_page  = get_page( $parent_id );
                    $parent_id = $get_page->post_parent;

                    $page_parents[] = array(
                        'url'  => get_permalink( $get_page->ID ),
                        'name' => get_the_title( $get_page->ID ),
                    );
                }

                $page_parents = array_reverse( $page_parents );

                foreach( $page_parents as $single_page ){

                    $breadcrumbs[] = array(
                        'url'  => $single_page['url'],
                        'name' => $single_page['name'],
                    );
                }
            }

            $breadcrumbs[] = array(
                'name' => get_the_title(),
            );
        }

        # Attachment ----------
        elseif ( is_attachment() ){

            if( ! empty( $post->post_parent ) ){
                $parent = get_post( $post->post_parent );

                $breadcrumbs[] = array(
                    'url'  => get_permalink( $parent ),
                    'name' => $parent->post_title,
                );
            }

            $breadcrumbs[] = array(
                'name' => get_the_title(),
            );
        }

        # Single Posts ----------
        elseif ( is_singular() ){

            # Single Post ----------
            if ( get_post_type() == 'post' ){

                $category = infolio_get_primary_category_id();
                $category = get_category( $category );

                if( ! empty( $category ) ){

                    if( $category->parent !== 0 ){
                        $parent_categories = array_reverse( get_ancestors( $category->term_id, 'category' ) );

                        foreach ( $parent_categories as $parent_category ) {
                            $breadcrumbs[] = array(
                                'url'  => cached_get_term_link( $parent_category, 'category' ),
                                'name' => get_cat_name( $parent_category ),
                            );
                        }
                    }

                    $breadcrumbs[] = array(
                        'url'  => cached_get_term_link( $category->term_id, 'category' ),
                        'name' => get_cat_name( $category->term_id ),
                    );
                }
            }

            # Custom Post type ----------
            else{
                $post_type = get_post_type_object( get_post_type() );
                $slug      = $post_type->rewrite;
                $slug = !empty($slug) ? '/' . $slug['slug'] : '';

                $breadcrumbs[] = array(
                    'url'  => $home_url . '/' . $slug,
                    'name' => $post_type->labels->singular_name,
                );
            }

            $breadcrumbs[] = array(
                'name' => get_the_title(),
            );
        }

        # Print the BreadCrumb
        if( ! empty( $breadcrumbs ) ){
            $cunter = 0;
            $breadcrumbs_schema = array(
                '@context'        => 'http://schema.org',
                '@type'           => 'BreadcrumbList',
                '@id'             => '#Breadcrumb',
                'itemListElement' => array(),
            );

            foreach( $breadcrumbs as $item ) {

                $cunter++;

                if( ! empty( $item['url'] )){
                    $icon = ! empty( $item['icon'] ) ? $item['icon'] : '';
                    echo '<span class=" '. $cunter .' breadcrumb-first"><a href="'. esc_url( $item['url'] ) .'">'. $icon .' '. $item['name'] .'</a><span class="sep">|</span></span>';
                } else {
                    echo wp_kses_post(  $before . $item['name'] . $after );
                    global $wp;
                    $item['url'] = esc_url( home_url( add_query_arg( array(),$wp->request ) ) );
                }

                $breadcrumbs_schema['itemListElement'][] = array(
                    '@type'    => 'ListItem',
                    'position' => $cunter,
                    'item'     => array(
                        'name' => str_replace( '<span class="fa fa-home" aria-hidden="true"></span> ', '', $item['name']),
                        '@id'  => $item['url'],
                    )
                );

            }
        }
    }
    wp_reset_postdata();
}
		
/**
 * @since 1.0.0
 */
class infolio_Breadcrumbs extends Widget_Base {

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
		return 'infolio-breadcrumbs';
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
		return __( 'infolio Breadcrumbs', 'infolio_plg' );
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
		return 'eicon-button';
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
		return [ 'infolio-category' ];
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
			'section_content',
			[
				'label' => __( 'Breadcrumbs Settings', 'infolio_plg' ),
			]
		);

		$this->add_responsive_control(
			'breadcrumbs_align',
			[
				'label' => __( 'Button Alignment', 'infolio_plg' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'infolio_plg' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'infolio_plg' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'infolio_plg'),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .infolio-breadcrumbs' => 'text-align: {{VALUE}};',
				],
			]
		);
		

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Content Style', 'infolio_plg' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Price Plan Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumbs_text_typography',
				'label' => esc_html__( 'Typography', 'infolio_plg' ),
				'selector' => '{{WRAPPER}} .infolio-breadcrumbs a, {{WRAPPER}} .infolio-breadcrumbs span',
			]
		);

		$this->add_control(
			'breadcrumbs_text_color',
			[
				'label' => esc_html__( 'Text Color', 'infolio_plg' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-breadcrumbs span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-breadcrumbs a' => 'color: {{VALUE}};',
				],
			]
        );

        $this->add_control(
            'breadcrumbs_text_color_dark',
            [
                'label' => esc_html__( 'Text Color (Dark Mode)', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-breadcrumbs span' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-breadcrumbs span' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-breadcrumbs a' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-breadcrumbs a' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'breadcrumbs_link_color',
			[
				'label' => esc_html__( 'Link Color', 'infolio_plg' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-breadcrumbs .current' => 'color: {{VALUE}};',
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
		$settings = $this->get_settings();
		
        // Styles selections.
		
		?>

		<div class="infolio-breadcrumbs">
			<div class="path">
			<?php infolio_breadcrumbs(); ?>
			</div>
		</div>

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


