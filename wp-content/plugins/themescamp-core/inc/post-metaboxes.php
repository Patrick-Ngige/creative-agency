<?php
/**
 * Initialize the Post Post Meta Boxes. 
 */
add_action( 'admin_init', 'themescamp_post_mb' );
function themescamp_post_mb() {
  
  /**
   * Create a custom meta boxes array that we pass to 
   * the theme options Meta Box API Class.
   */
  $themescamp_post_mb = array(
    'id'          => 'post_meta_box',
    'title'       => esc_html__( 'Post Setting', 'themescamp-core' ), 
    'desc'        => '',
    'pages'       => array( 'post' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
	 array(
        'id'          => 'post_setting_block',
        'label'       => esc_html__('Note for Image', 'themescamp-core' ),
        'desc'        => esc_html__('Always use the same ratio/size for images in slider/gallery below.  ', 'themescamp-core' ),
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
        'label'       => esc_html__( 'Choose Post Format Here', 'themescamp-core' ),
        'id'          => 'post_format',
        'type'        => 'select',
		'std'		 => 'post_standard',
		'choices'     => array( 
			  array(
                'value'       => 'post_standard',
                'label'       => esc_html__( 'Post Standard', 'themescamp-core' )
              ),
			  array(
                'value'       => 'post_gallery',
                'label'       => esc_html__( 'Post Gallery', 'themescamp-core' )
              ),
			  array(
                'value'       => 'post_slider',
                'label'       => esc_html__( 'Post Slider', 'themescamp-core' )
              ),
			  array(
                'value'       => 'post_video',
                'label'       => esc_html__( 'Post Video', 'themescamp-core' )
              ),
			  array(
                'value'       => 'post_audio',
                'label'       => esc_html__( 'Post Audio', 'themescamp-core' )
              ),
		)
      ),
	  
	  array(
        'label'       => esc_html__( 'Gallery Setting', 'themescamp-core' ),
        'id'          => 'post_gallery_setting',
        'type'        => 'gallery',
        'desc'        => esc_html__( 'Create your Post gallery here. <br/>Try to use same ratio for each image.', 'themescamp-core' ),
        'condition'   => 'post_format:is(post_gallery)'
      ),
	  array(
        'label'       => esc_html__( 'Slider Setting', 'themescamp-core' ),
        'id'          => 'post_slider_setting',
        'type'        => 'gallery',
        'desc'        => esc_html__( 'Create your Post Slider here.', 'themescamp-core' ),
        'condition'   => 'post_format:is(post_slider)'
      ),
	  array(
        'label'       => esc_html__( 'Video Setting', 'themescamp-core' ),
        'id'          => 'post_video_setting',
        'type'        => 'text',
        'desc'        => esc_html__( 'Insert the link for video embed here.<br/> For video from youtube/vimeo just put the link without any attribute like ?wmode=opaque.<br/>eg: http://www.youtube.com/embed/IzgAYZTuBA8 or http://player.vimeo.com/video/64078587', 'themescamp-core' ),
        'condition'   => 'post_format:is(post_video)'
      ),
	   array(
        'label'       => esc_html__( 'Audio Setting', 'themescamp-core' ),
        'id'          => 'post_audio_setting',
        'type'        => 'textarea',
		'rows'        => '3',
        'desc'        => esc_html__( 'Insert your iframe/embedded code for audio here.<br/>
		You can input iframe/embed code from youtube/vimeo here too, if you don\'t like the default style of Post video.', 'themescamp-core' ),
        'condition'   => 'post_format:is(post_audio)'
      ),
	  array(
        'label'       => esc_html__( 'Sidebar', 'themescamp-core' ),
        'id'          => 'post_sidebar',
        'type'        => 'on-off',
		'desc'        => esc_html__( 'You can hide the sidebar by turning it off.', 'themescamp-core' ),
		'std'		 => 'on',
      )
    )
  );


}

