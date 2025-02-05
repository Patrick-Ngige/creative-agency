<?php
/**
 * Initialize the Post Post Meta Boxes. 
 */
add_action( 'admin_init', 'themescamp_page_mb' ); 
function themescamp_page_mb() {
  
  /**
   * Create a custom meta boxes array that we pass to 
   * the theme options Meta Box API Class.
   */
  $themescamp_page_mb = array(
    'id'          => 'page_meta_box',
    'title'       => esc_html__( 'Page Settings', 'themescamp-core' ),
    'desc'        => '',
    'pages'       => array( 'page','portfolio','post'),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
	
	  array(
        'id'          => 'custom_footer_header_note',
        'label'       => esc_html__('Please Note', 'themescamp-core' ),
        'desc'        => esc_html__('The Custom Header & Custom Footer only appear on the actual page, not in elementor editor.', 'themescamp-core' ),
        'std'         => '',
        'type'        => 'textblock-titthemescamp',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	  
	  
	   
	  
	  array(
        'label'       => esc_html__( 'Header Settings', 'themescamp-core' ),
        'id'          => 'header_setting_section',
        'type'        => 'tab',
      ),
	  
	  array(
        'label'       => esc_html__( 'Header Options', 'themescamp-core' ),
		'desc'          =>  '',
        'id'          => 'custom_header_choice',
        'type'        => 'select',
		'std'		 => 'global',
		'choices'     => array( 
			 array(
                'value'       => 'global',
                'label'       => esc_html__( 'Use Global Settings (in Theme Options)', 'themescamp-core' )
              ),
			  array(
                'value'       => 'standard',
                'label'       => esc_html__( 'Use Default Header', 'themescamp-core' )
              ),
			  array(
                'value'       => 'custom_header',
                'label'       => esc_html__( 'Use Custom Header', 'themescamp-core' )
              ),
			  array(
                'value'       => 'no_header',
                'label'       => esc_html__( 'No Header', 'themescamp-core' )
              ),
			  
		)
      ),
	  
      array(
        'id'          => 'header_list',
        'label'       => esc_html__( 'Choose Custom Header', 'themescamp-core' ),
        'desc'        => '',
        'std'         => '',
		'condition'   => 'custom_header_choice:is(custom_header)',
        'type' => 'custom-post-type-select',
        'rows'        => '',
        'post_type'   => 'header',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  
	  array(
        'label'       => esc_html__( 'Header Format', 'themescamp-core' ),
		'desc'          => '',
        'id'          => 'menu_format',
        'type'        => 'select',
		'condition'   => 'custom_header_choice:is(standard)',
		'std'		 => 'head_clean',
		'choices'     => array( 
			  array(
                'value'       => 'head_clean',
                'label'       => esc_html__( 'Black Text with White Background Header in Relative Position', 'themescamp-core' )
              ),
			  array(
                'value'       => 'head_standard',
                'label'       => esc_html__( 'White Text with Transparent Background Header in Absolute Position', 'themescamp-core' )
              ),
			  
		)
      ),


	  
	  array(
        'label'       => esc_html__( 'Footer Settings', 'themescamp-core' ),
        'id'          => 'footer_setting_section',
        'type'        => 'tab',
      ),
 
	  array(
        'label'       => esc_html__( 'Use Custom Footer', 'themescamp-core' ),
		    'desc'          =>  '',
        'id'          => 'custom_footer_choice',
        'type'        => 'select',
    		'std'		 => 'global',
    		'choices'     => array( 
    			  array(
                    'value'       => 'global',
                    'label'       => esc_html__( 'Use Global Settings (in Theme Options) Footer', 'themescamp-core' )
                  ),
    			  array(
                    'value'       => 'standard',
                    'label'       => esc_html__( 'Use Default Footer', 'themescamp-core' )
                  ),
    			  array(
                    'value'       => 'custom_footer',
                    'label'       => esc_html__( 'Use Custom Footer', 'themescamp-core' )
                  ),
    			  array(
                    'value'       => 'no_footer',
                    'label'       => esc_html__( 'No Footer', 'themescamp-core' )
                  ),
    			  
    		)
      ),
	  
	
	  
	  array(
        'id'          => 'footer_list',
        'label'       => esc_html__( 'Choose Custom Footer', 'themescamp-core' ),
        'desc'        => '',
        'std'         => '',
    		'condition'   => 'custom_footer_choice:is(custom_footer)',
            'type' => 'custom-post-type-select',
            'rows'        => '',
            'post_type'   => 'footer',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => ''
          ),
	  
     ),

    array(
        'label'       => esc_html__( 'side panel Settings', 'themescamp-core' ),
        'id'          => 'offcanvas_setting_section',
        'type'        => 'tab',
      ),
    array(
        'label'       => esc_html__( 'Use Custom offcanvas', 'themescamp-core' ),
        'desc'          =>  '',
        'id'          => 'custom_offcanvas_choice',
        'type'        => 'select',
        'std'    => 'global',
        'choices'     => array( 
            array(
                    'value'       => 'global',
                    'label'       => esc_html__( 'Use Global Settings (in Theme Options) offcanvas', 'themescamp-core' )
                  ),
            array(
                    'value'       => 'standard',
                    'label'       => esc_html__( 'Use Default Footer', 'themescamp-core' )
                  ),
            array(
                    'value'       => 'custom_offcanvas',
                    'label'       => esc_html__( 'Use Custom Footer', 'themescamp-core' )
                  ),
            array(
                    'value'       => 'no_offcanvas',
                    'label'       => esc_html__( 'No offcanvas', 'themescamp-core' )
                  ),
            
        )
      ),
    array(
        'id'          => 'offcanvas_list',
        'label'       => esc_html__( 'Choose Custom offcanvas', 'themescamp-core' ),
        'desc'        => '',
        'std'         => '',
        'condition'   => 'custom_offcanvas_choice:is(custom_offcanvas)',
            'type' => 'custom-post-type-select',
            'rows'        => '',
            'post_type'   => 'offcanvas',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => ''
          ),

  );

}

