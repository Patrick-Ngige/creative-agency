<?php
namespace ThemescampPlugin\TemplateBuilder;

class Themescamp_TemplateRule {

    /**
     * Current page type
     *
     * @var $current_page_type
     *
     * @access private
     * @static
     */
    private static $current_page_type = null;

    /**
     * Current page data
     *
     * @var $current_page_data
     *
     * @access private
     * @static
     */
    private static $current_page_data = [];

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @return \Template_Rule
     */
    public static function instance() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }


    /**
     * Get current page type
     *
     * @return string Page Type. 
     */
    public function get_current_page_type() {
        if ( null === self::$current_page_type ) {
            $page_type  = '';
            $current_id = false;

            if ( is_front_page() ) {
                $page_type  = 'is_front_page';
                $current_id = get_the_id();
            } 

            elseif ( is_home() ) {
                $page_type = 'is_home';
            } 

            elseif ( is_page() ) {
	            $page_type  = 'is_page';
	            $current_id = get_the_id();

	            if ( function_exists( 'is_shop' ) && is_shop() ) {
	                $page_type = 'is_shop_page';
	            }

            } 

            elseif ( is_archive() ) {
                $page_type = 'is_archive';
                if ( is_date() ) {
                    $page_type = 'is_date';
                } 

                elseif ( is_author() ) {
                    $page_type = 'is_author';
	            } 

	            elseif (is_tax('portfolio_category') || is_tax('porto_tag') || is_post_type_archive('portfolio')) {
	                $page_type = 'is_portfolio_cat_archive';
	            }
            } 

            elseif ( is_search() ) {
                $page_type = 'is_search';
            } 

            elseif ( is_404() ) {
                $page_type = 'is_404';
            } 

            elseif ( is_singular( 'post' ) ) {
                $page_type  = 'is_single';
                $current_id = get_the_id();
            } 

            elseif ( is_singular( 'product' ) ) {
                $page_type  = 'is_product';
                $current_id = get_the_id();
            } 

            elseif ( is_singular( 'portfolio' ) ) {
                $page_type  = 'is_portfolio';
                $current_id = get_the_id();
            } 



            else {
                $current_id = get_the_id();
            }

            self::$current_page_data['page_id'] = $current_id;
            self::$current_page_type            = $page_type;
        }
        return self::$current_page_type;
    }

    /**
     * Get templates by condition
     *
     * @return object  Posts.
     */

	public function get_templates_by_condition() {
	    global $post;

	    $post_type 			= 'tcg_teb';
	    $include 			= 'tcg_tb_include';
	    $exclude 			= 'tcg_tb_exclude';

	    $pages_ids_include  = 'pages_ids_include';
	    $pages_ids_exclude  = 'pages_ids_exclude';

	    $posts_ids_include	= 'posts_ids_include';
	    $posts_ids_exclude	= 'posts_ids_exclude';

	    $portfolios_ids_include	= 'portfolios_ids_include';
	    $portfolios_ids_exclude	= 'portfolios_ids_exclude';

	    if (is_array(self::$current_page_data) && isset(self::$current_page_data[$post_type])) {
	        return self::$current_page_data[$post_type];
	    }

	    $current_page_type = $this->get_current_page_type();
	    self::$current_page_data[$post_type] = [];
	    $current_post_id = get_the_id();


	    $include_meta_args = array(); // Conditions to include templates
	    $exclude_meta_args = array(); // Conditions to exclude templates

	    $include_meta_args = array(
	        'relation' => 'OR',
	        array(
	            'key' => $include,
	            'value' => 'entire_website',
	            'compare' => 'LIKE'
	        )
	    );

		// Modify the $meta_args based on the $current_page_type
		switch ($current_page_type) {

		    case 'is_page':
		        $current_id = esc_sql(get_the_id());

		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => 'all_pages',
		            'compare' => 'LIKE'
		        );

		        // Handling the specific_pages scenario
		        $include_meta_args[] = array(
		            'relation' => 'AND',
		            array(
		                'key' => $include,
		                'value' => 'specific_pages',
		                'compare' => 'LIKE'
		            ),
		            array(
		                'key' => $pages_ids_include,
		                'value' => $current_id,
		                'compare' => 'LIKE'
		            )
		        );

		        break;

		    case 'is_front_page':
		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => 'front_page',
		            'compare' => 'LIKE'
		        );
		        break;

		    case 'is_home':
		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => 'post_page',
		            'compare' => 'LIKE'
		        );
		        break;

		    case 'is_portfolio':
		        $current_id = esc_sql(get_the_id());

		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => 'all_portfolios',
		            'compare' => 'LIKE'
		        );

		        // Handling the specific_portfolios scenario
		        $include_meta_args[] = array(
		            'relation' => 'AND',
		            array(
		                'key' => $include,
		                'value' => 'specific_portfolios',
		                'compare' => 'LIKE'
		            ),
		            array(
		                'key' => $portfolios_ids_include,
		                'value' => $current_id,
		                'compare' => 'LIKE'
		            )
		        );

		        break;

			case 'is_single':
				$current_id = esc_sql(get_the_id());

		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => 'post_details',
		            'compare' => 'LIKE'
		        );

				// Handling the specific_posts scenario
		        $include_meta_args[] = array(
		            'relation' => 'AND',
		            array(
		                'key' => $include,
		                'value' => 'specific_posts',
		                'compare' => 'LIKE'
		            ),
		            array(
		                'key' => $posts_ids_include,
		                'value' => $current_id,
		                'compare' => 'LIKE'
		            )
		        );

	        break;

		    case 'is_archive':
		    case 'is_date':
		    case 'is_author':
		    case 'is_portfolio_cat_archive':
		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => 'all_archive',
		            'compare' => 'LIKE'
		        );

		        if ('is_date' == $current_page_type) {
		            $include_meta_args[] = array(
		                'key' => $include,
		                'value' => 'date_archive',
		                'compare' => 'LIKE'
		            );


		        } elseif ('is_author' == $current_page_type) {
		            $include_meta_args[] = array(
		                'key' => $include,
		                'value' => 'author_archive',
		                'compare' => 'LIKE'
		            );
		        
		        } elseif ('is_portfolio_cat_archive' == $current_page_type) {
		            $include_meta_args[] = array(
		                'key' => $include,
		                'value' => 'portfolio_archive',
		                'compare' => 'LIKE'
		            );

		        }
	        break;

		    case 'is_404':
		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => '404_page',
		            'compare' => 'LIKE'
		        );

	        break;
	        
		    case 'is_search':
		        $include_meta_args[] = array(
		            'key' => $include,
		            'value' => 'search_page',
		            'compare' => 'LIKE'
		        );

	        break;
		}

        // The exclusion conditions.

	    switch ($current_page_type) {

		    case 'is_page':
		        $current_id = esc_sql(get_the_id());

		        $exclude_meta_args[] = array(
		            'key' => $exclude,
		            'value' => 'all_pages',
		            'compare' => 'NOT LIKE'
		        );

		        // Handling the specific_pages scenario
		        $exclude_meta_args[] = array(
		            'relation' => 'OR',
		            array(
		                'key' => $exclude,
		                'value' => 'specific_pages',
		                'compare' => 'NOT LIKE'
		            ),
		            array(
		                'key' => $pages_ids_exclude,
		                'value' => $current_id,
		                'compare' => 'NOT LIKE'
		            )
		        );

		        break;

		    case 'is_front_page':
		        $exclude_meta_args[] = array(
		            'key' => $exclude,
		            'value' => 'front_page',
		            'compare' => 'NOT LIKE'
		        );
		        break;

		    case 'is_archive':
		    case 'is_date':
		    case 'is_author':
		    case 'is_portfolio_cat_archive':
		        $exclude_meta_args[] = array(
		            'key' => $exclude,
		            'value' => 'all_archive',
		            'compare' => 'NOT LIKE'
		        );

		        if ('is_date' == $current_page_type) {
		            $exclude_meta_args[] = array(
		                'key' => $exclude,
		                'value' => 'date_archive',
		                'compare' => 'NOT LIKE'
		            );
		        } elseif ('is_author' == $current_page_type) {
		            $exclude_meta_args[] = array(
		                'key' => $exclude,
		                'value' => 'author_archive',
		                'compare' => 'NOT LIKE'
		            );
		        
		        } elseif ('is_portfolio_cat_archive' == $current_page_type) {
		            $exclude_meta_args[] = array(
		                'key' => $exclude,
		                'value' => 'portfolio_archive',
		                'compare' => 'NOT LIKE'
		            );
		        }
	        break;

		    case 'is_search':
		        $exclude_meta_args[] = array(
		            'key' => $exclude,
		            'value' => 'search_page',
		            'compare' => 'NOT LIKE'
		        );
		        break;
		        
		    case 'is_portfolio':
		        $current_id = esc_sql(get_the_id());

		        $exclude_meta_args[] = array(
		            'key' => $exclude,
		            'value' => 'all_portfolios',
		            'compare' => 'NOT LIKE'
		        );

		        // Handling the specific_posts scenario
		        $exclude_meta_args[] = array(
		            'relation' => 'OR',
		            array(
		                'key' => $exclude,
		                'value' => 'specific_portfolios',
		                'compare' => 'NOT LIKE'
		            ),
		            array(
		                'key' => $portfolios_ids_exclude,
		                'value' => $current_id,
		                'compare' => 'NOT LIKE'
		            )
		        );

		        break;

		    case 'is_single':
		        $current_id = esc_sql(get_the_id());

		        $exclude_meta_args[] = array(
		            'key' => $exclude,
		            'value' => 'post_details',
		            'compare' => 'NOT LIKE'
		        );

		        // Handling the specific_posts scenario
		        $exclude_meta_args[] = array(
		            'relation' => 'OR',
		            array(
		                'key' => $exclude,
		                'value' => 'specific_posts',
		                'compare' => 'NOT LIKE'
		            ),
		            array(
		                'key' => $posts_ids_exclude,
		                'value' => $current_id,
		                'compare' => 'NOT LIKE'
		            )
		        );

		        break;

		    case 'is_404':
		        $exclude_meta_args[] = array(
		            'key' => $exclude,
		            'value' => '404_page',
		            'compare' => 'NOT LIKE'
		        );
		        break;

	    }


        // Merge both include and exclude conditions
		$meta_args = array(
		    'relation' => 'AND',
		    $include_meta_args,
		    array(
		        'relation' => 'AND',
		        $exclude_meta_args
		    )
		);

        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'meta_query' => $meta_args,
            'orderby' => 'post_modified',
            'order' => 'DESC'
        );

		$query = new \WP_Query($args);

	    $templates = $query->get_posts();


	    foreach ($templates as $local_template) {
	        $meta = get_post_meta($local_template->ID, 'template_type', true);

	        if (isset($meta)) {
	            $template_type = $meta;
	        } else {
	            $template_type = '';
	        }

	        self::$current_page_data[$post_type][$local_template->ID] = [
	            'id' => $local_template->ID,
	            'type' => $template_type,
	            'location' => maybe_unserialize(get_post_meta($local_template->ID, $include, true))
	        ];
	    }

	    return self::$current_page_data[$post_type];
	}


}

Themescamp_TemplateRule::instance();