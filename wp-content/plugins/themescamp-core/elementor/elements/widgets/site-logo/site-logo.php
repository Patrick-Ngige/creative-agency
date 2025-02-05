<?php
namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Widget_Image;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TCG_Site_Logo extends Widget_Image {

	public function get_name() {
		return 'tcg-site-logo';
	}

	public function get_title() {
		return __( 'TCG Site Logo', 'themescamp-plugin' );
	}

	public function get_icon() {
		return 'eicon-site-logo';
	}

	public function get_categories() {
		return [ 'themescamp-elements' ];
	}

	protected function register_controls() {
        parent::register_controls(); 

        		// Remove the caption control
		$this->remove_control( 'caption_source' );
		$this->remove_control( 'caption' );
        
        // Hide the default image control
        $this->update_control(
            'image',
            [
                'type' => \Elementor\Controls_Manager::HIDDEN,
            ]
        );

		$this->update_control(
			'image',
			[
				'default' => [
					'url' => '',
				],
				'dynamic' => [
					'default' => [],
				],

			]
		);

		$this->update_control(
			'image_size',
			[
				'separator' => 'before',
				'default' => 'full',
			]
		);

		$this->update_control(
			'link_to',
			[
				'options' => [
					'none' => esc_html__( 'None', 'themescamp-core' ),
					'site_url' => esc_html__( 'Site URL', 'themescamp-core' ),
					'custom' => esc_html__( 'Custom URL', 'themescamp-core' ),
					'file' => esc_html__( 'Media File', 'themescamp-core' ),
				],
				'default' => 'site_url',
			],
			[
				'recursive' => true,
			]
		);


		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Logo Settings', 'themescamp-core' ),
			]
		);

		$this->add_control(
			'logo_type',
			[
				'label' => __( 'Logo type', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light' => __( 'Light', 'themescamp-core' ),
					'dark' => __( 'Dark', 'themescamp-core' ),
					'auto' => __( 'Auto', 'themescamp-core' ),
				],
				'frontend_available' => true,
			]
		);


		$this->end_controls_section();

	}

	protected function render() { 
		$settings = $this->get_settings();
                            
        $tcg_header_logo_light= themescamp_settings('tcg_header_logo_light');
        $tcg_header_logo_light = isset($tcg_header_logo_light['url']) && $tcg_header_logo_light['url'] ? $tcg_header_logo_light['url'] : '';

        $tcg_header_logo_drk= themescamp_settings('tcg_header_logo_drk');
        $tcg_header_logo_drk = isset($tcg_header_logo_drk['url']) && $tcg_header_logo_drk['url'] ? $tcg_header_logo_drk['url'] : '';
        
    	?> 

        <div class="tcg-logo">
            <div class="top-logo"> 
                <?php if( !empty($tcg_header_logo_light) && !empty($tcg_header_logo_drk) ): ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"> 


                        <?php if ($settings['logo_type']=='light'){?>

                            <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1" 
                                src="<?php  echo esc_url($tcg_header_logo_drk); ?>"> 

                        <?php }elseif($settings['logo_type']=='dark'){ ?>

                            <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1" 
                            src="<?php  echo esc_url($tcg_header_logo_light); ?>">

                        <?php } else { ?>
                            <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1 logo-dark" 
                                src="<?php  echo esc_url($tcg_header_logo_drk); ?>"> 

                                <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1 logo-white" 
                            src="<?php  echo esc_url($tcg_header_logo_light); ?>">
                        <?php };?>
    
                    </a>
                <?php else:?> <p class="site-title"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' rel="home"><?php bloginfo( 'name' ); ?></a></p> 
                <?php endif; ?>
            </div>
        </div><!--End Logo-->
        

        <?php
	}
}
