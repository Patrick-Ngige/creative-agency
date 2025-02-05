<?php
namespace infolioPlugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;

if (!defined('ABSPATH')) exit;

class infolio_Awards_item extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-awards-items';
    }

    public function get_title()
    {
        return __('infolio Award item', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-menu-card';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Awards Settings', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'award_title',
            [
                'label' => __('Award Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Award', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            'platform_title',
            [
                'label' => __('Platform Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Platform', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Digital Marketing', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'date',
            [
                'label' => __('Date', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('2023', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        // Add the control for the second title
        $repeater->add_control(
            'second_title',
            [
                'label' => __('Second Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Behance', 'infolio_plg'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'btn_link',
            [
                'label' => __('Button Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'items_list',
            [
                'label' => __('Items List', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'award_settings',
            [
                'label' => __( 'Awards Items Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label'=> esc_html__( 'Title Typography','infolio_plg' ),
                'selector' => '{{WRAPPER}} .infolio-awards-items .item-title h6',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'label'=> esc_html__( 'Item Typography','infolio_plg' ),
                'selector' => '{{WRAPPER}} .infolio-awards-items .item-line h6',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items_list = $settings['items_list'];
        ?>
        <div class="infolio-awards-items">
            <div class="item-title row">
                <div class="col-md-6">
                    <div>
                        <h6 class="sub-title"><?= esc_html($settings['award_title']) ?></h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <h6 class="sub-title"><?= esc_html($settings['platform_title']) ?></h6>
                    </div>
                </div>
            </div>
            <?php foreach ($items_list as $item) : ?>
                <div class="item-line row">
                    <div class="col-md-6">
                        <div class="project-date">
                            <h6><?= esc_html($item['title']) ?> <span class="date"><?= esc_html($item['date']) ?></span></h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="honors">
                            <h6><?= esc_html($item['second_title']) ?></h6>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= esc_url($item['btn_link']['url']) ?>" class="link" <?php if ( $item['btn_link']['is_external'] ) {echo'target="_blank"';} ?>>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z" fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

}