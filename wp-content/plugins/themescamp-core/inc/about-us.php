<?php class themescamp_about extends WP_Widget {

	// Defines the widget name
	public function __construct() {
		parent::__construct(false, $name = __('THEMESCAMP - About Us', 'themescamp-core') );
	}

	// Creates the widget in the WP admin area
	function form($instance) {

		// values
		if( $instance) {
		     $title = $instance['title'];
			 $subtitle = $instance['subtitle'];
		     $textarea = $instance['textarea'];
		     $image_uri = esc_url($instance['image_uri']);
		     $twitter = esc_url($instance['twitter']);
		     $facebook = esc_url($instance['facebook']);
		     $linkedin = esc_url($instance['linkedin']);
		     $instagram = esc_url($instance['instagram']);
		     $pinterest = esc_url($instance['pinterest']);
		     $youtube = esc_url($instance['youtube']);
		} else {
			$subtitle = '';
		    $title = '';
		    $textarea = '';
		    $image_uri = '';
		    $twitter = '';
		    $facebook = '';
		    $linkedin = '';
		    $instagram = '';
		    $pinterest = '';
		    $youtube = '';
		}
		?>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'themescamp-core'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
   

		<p>
		<label for="<?php echo $this->get_field_id('social'); ?>"><?php esc_html_e('Social Media:', 'themescamp-core'); ?></label><br />
		</p>
		
		<p>
        <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php esc_html_e('Facebook', 'themescamp-core'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
		</p>
		
		<p>
        <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php esc_html_e('Twitter', 'themescamp-core'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>"  />
		</p>

		<p>
        <label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php esc_html_e('Linkedin', 'themescamp-core'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>" />
		</p>

		<p>
        <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php esc_html_e('Instagram', 'themescamp-core'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>" />
		</p>

		<p>
        <label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php esc_html_e('Pinterest', 'themescamp-core'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text" value="<?php echo esc_attr( $pinterest ); ?>" />
		</p>

		<p>
        <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php esc_html_e('Youtube', 'themescamp-core'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>"/>
		</p>

	<?php
	}// end admin area form

	// Widget Update
	function update($new_instance, $old_instance) {
	    $instance = $old_instance;
	    // Fields
	    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title']: '';
		$instance['subtitle'] = ( ! empty( $new_instance['subtitle'] ) ) ? $new_instance['subtitle']: '';
	    $instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? strip_tags($new_instance['textarea'], '<a>, <strong>,<br>,<b>'): '';
	   	$instance['image_uri'] = ( ! empty( $new_instance['image_uri'] ) ) ? strip_tags( $new_instance['image_uri'] ) : '';
	   	$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
	   	$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
	   	$instance['linkedin'] = ( ! empty( $new_instance['linkedin'] ) ) ? strip_tags( $new_instance['linkedin'] ) : '';
	   	$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
	   	$instance['pinterest'] = ( ! empty( $new_instance['pinterest'] ) ) ? strip_tags( $new_instance['pinterest'] ) : '';
	   	$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['vimeo'] = ( ! empty( $new_instance['vimeo'] ) ) ? strip_tags( $new_instance['vimeo'] ) : '';
	    return $instance;
	}

	// Output the content on frontend
	function widget($args, $instance) {
	   extract( $args );

	   // Widget options
	   $title = $instance['title'];
	   $subtitle = $instance['subtitle'];
	   $textarea = $instance['textarea'];
	   $image_uri = $instance['image_uri'];
	   $twitter = $instance['twitter']; 
	   $facebook = $instance['facebook']; 
	   $linkedin = $instance['linkedin']; 
	   $instagram = $instance['instagram']; 
	   $pinterest = $instance['pinterest']; 
	   $youtube = $instance['youtube'];
	   $vimeo = $instance['vimeo'];

	   echo $before_widget;
	   // Display the widget
	   echo '<div class="widget-about-us clearfix">';

	   echo '<div class="abtw-box" style="background-image:url('.$image_uri.');background-position: center;background-size: cover;"><div class="slider-mask"></div>';

		   
		  
		   // if title is exist
		   if ( $title ) { ?>
		     <div class="bordering-widget">
             	                    
                  <h3><?php echo wp_kses_post ($title); ?></h3>
                  <div class="widget-border"></div>
                  
                  <?php 
				   	// Social Media Group
		

					if ($twitter or $facebook or $linkedin or $instagram or $pinterest or $youtube) {
					echo '<ul class="abtw-soc">';
					
					   // if Facebook is exist
					   if( $facebook ) { ?>
						 <li><a href="<?php echo $facebook; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
					   <?php
					   }
					   
					   // if Twitter is exist
					   if( $twitter ) { ?>
						 <li><a href="<?php echo $twitter; ?>" target="_blank"><i class="fab fa-x-twitter"></i></a></li>
					   <?php
					   }
			
					   
			
					   // if Linkedin+ is exist
					   if( $linkedin ) { ?>
						 <li><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
					   <?php
					   }
			
					   // if Instagram is exist
					   if( $instagram ) { ?>
						 <li><a href="<?php echo $instagram; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
					   <?php
					   }
			
					   // if pinterest is exist
					   if( $pinterest ) { ?>
						 <li><a href="<?php echo $pinterest; ?>" target="_blank"><i class="fab fa-pinterest"></i></a></li>
					   <?php
					   }
			
					   // if Youtube is exist
					   if( $youtube ) { ?>
						 <li><a href="<?php echo $youtube; ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
					   <?php
					   }
					   // if Vimeo is exist
					   if( $vimeo ) { ?>
						 <li><a href="<?php echo $vimeo; ?>" target="_blank"><i class="fab fa-vimeo-square"></i></a></li>
					   <?php
					   }
			
				   echo '</ul>';
				   } // end social check
				  ?>
              </div>
		   <?php }
		   
	  echo '</div><div class="ab-bordering">';
		   
		   // if textarea is exist
		   if( $textarea ) { ?>
		     
		   	<?php echo wpautop ($textarea); ?>
		 
          <?php }
		   

	   echo '</div></div>';
	   echo $after_widget;
	} // end frontend output
}// end class

// Register widget

function themescamp_register_about_us() {
	register_widget( 'themescamp_about' );
}
add_action( 'widgets_init', 'themescamp_register_about_us' );

