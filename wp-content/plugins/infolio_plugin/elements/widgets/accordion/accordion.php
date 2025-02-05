<?php
namespace InfolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\repeater;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Group_Control_Text_Shadow;

if (!defined('ABSPATH')) exit;

class Infolio_Accordion extends Widget_Base
{
    public function get_name()
    {
        return 'infolio-accordion';
    }

    public function get_title()
    {
        return __('Infolio Accordion', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-accordion';
    }

    public function get_script_depends() {

        return ['infolio-accordion'];
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }


    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_items',
            [
                'label' => __('Accordion Items', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'number_count',
            [
                'label' => __('Count Items', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Designing Content With AI Power', 'infolio_plg'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __('Content', 'infolio_plg'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'infolio_plg' ) . '</p>',
            ]
        );

        $this->add_control(
            'accordion_items',
            [
                'label' => __('Accordion Items', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'separator'=>'before',
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_title_section',
            [
                'label' => esc_html__( 'Title Style', 'infolio_plg' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Title Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_container_margin',
            [
                'label' => esc_html__( 'Title Container Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_text_margin',
            [
                'label' => esc_html__( 'Title Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-accordion .accordion .item .title h6',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title h6' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_dark',
            [
                'label' => esc_html__( 'Title Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-accordion .accordion .item .title h6' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-accordion .accordion .item .title h6' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'selector' => '{{WRAPPER}} .infolio-accordion .accordion .item .title',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_border_dark',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-accordion .accordion .item .title' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-accordion .accordion .item .title' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_text_section',
            [
                'label' => esc_html__( 'Text Style', 'infolio_plg' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'background',
            [
                'label' => __('Background Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .accordion-info' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_dark',
            [
                'label' => esc_html__( 'Background Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-accordion .accordion .item .accordion-info' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-accordion .accordion .item .accordion-info' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__( 'Text Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .accordion-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __('Text Typography', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-accordion .accordion .item .accordion-info p',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ddd',
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .accordion-info p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_color_dark',
            [
                'label' => esc_html__( 'Text Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-accordion .accordion .item .accordion-info p' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-accordion .accordion .item .accordion-info p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .infolio-accordion .accordion .item .accordion-info',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_dark',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-accordion .accordion .item .accordion-info' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-accordion .accordion .item .accordion-info' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .accordion-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_icon_section',
            [
                'label' => esc_html__( 'Icon Style', 'infolio_plg' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'separator'=>'after',
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-accordion .accordion .item .title svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_dark',
            [
                'label' => esc_html__( 'Icon Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-accordion .accordion .item .title i' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-accordion .accordion .item .title i' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-accordion .accordion .item .title svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-accordion .accordion .item .title svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="infolio-accordion">
                <div class="accordion bord">
                    <?php $animationDelay=0.1;$itemCount=1; foreach ($settings['accordion_items'] as $item) : ?>
                    <div class="item <?php if ($itemCount==1) echo 'active'?> wow fadeInUp" data-wow-delay="<?=esc_attr($animationDelay)?>s">
                        <div class="title">
                            <h6><?php if ($settings['number_count']=='yes') : ?><?=($itemCount < 10) ? "0$itemCount" : $itemCount?>  <?php endif;?><?=esc_html($item['title'])?></h6>
                            <?php if (empty($settings['selected_icon']['value'])) : ?>
                            <span class="ico"></span>
                            <?php else : ?>
                                <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );?>
                            <?php endif;?>
                        </div>
                        <div class="accordion-info">
                            <?php
                                echo $item['content'];
                            ?>
                        </div>
                    </div>
                    <?php $animationDelay+=0.2;$itemCount++; endforeach;?>
                </div>
            </div>
        <?php
    }
}
