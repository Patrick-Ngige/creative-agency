<?php

namespace ElementKit\Includes\TemplateLibrary;


use ElementKit\Notices;
use Elementor\TemplateLibrary\Source_Local;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
class ElementKit_Template_Library extends ElementKit_Template_Library_Base{

    const PAGE_ID = 'element_kit_options';

    /**
     * @var string
     * api resources server
     */

    //query params
    protected $paged;
    protected $new_demo_rang_date = '';

    function __construct() {
        if ( ! defined( 'TCEK_HIDE' ) ) {
            add_action( 'admin_menu', [ $this, 'admin_menu' ], 201 );
        }

        $this->new_demo_rang_date = date('Y-m-d', strtotime('-31 days'));

        parent::__construct();
        add_action( 'wp_ajax_ep_elementor_demo_importer_data_import', array( $this, 'ajax_import_data' ) );
        add_action( 'wp_ajax_ep_elementor_demo_importer_data_loading', array( $this, 'demo_tab_ajax_loading_demo' ) );
        add_action( 'wp_ajax_ep_elementor_demo_importer_data_sync_demo_with_server', array( $this, 'sync_demo_with_server' ) );
        add_action( 'wp_ajax_ep_elementor_demo_importer_send_report', array( $this, 'send_report' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        add_action( 'admin_notices', [$this, 'admin_notice'] );
    }


    function admin_menu() {

        if ( ! defined( 'TCEK_LO' ) ) {
            add_submenu_page(
                self::PAGE_ID,
                TCEK_TITLE,
                esc_html__( 'Template Library', 'themescamp-core' ),
                'manage_options',
                'element-kit-template-library',
                [ $this, 'plugin_page' ]
            );
        }

    }


    public function enqueue_scripts() {

        wp_enqueue_script( 'tc-elementor-demo-importer-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/element-kit-template-library.js', array( 'jquery' ), TCEK_VER, false );

    }

    ## Import Template
    function templates_get_content_remote_request( $url ) {

        $response = wp_remote_get( $url, array(
            'timeout'   => 60,
            'sslverify' => false
        ) );

        $result = json_decode( wp_remote_retrieve_body( $response ), true );

        return $result;
    }

    /**
     * Ajax request.
     */
    public function ajax_import_data() {

        if ( isset( $_REQUEST ) ) {
            $demo_url         = $_REQUEST['demo_url'];
            $demo_id          = $_REQUEST['demo_id'];
            $page_title       = $_REQUEST['page_title'];
            $defaultPageTitle = $_REQUEST['default_page_title'];
            $importType       = $_REQUEST['demo_import_type'];

            $response_data = $this->templates_get_content_remote_request( $demo_url );
            $sourceData    = "";
            if ( is_array( $response_data ) ) {
                $manager    = new Source_Local();
                $sourceData = $manager->import_template( 'test.json', $demo_url );
            }

            if ( ! is_array( $response_data ) || ! is_array( $sourceData ) ) {
                echo json_encode(
                    array(
                        'success' => false,
                        'id'      => '',
                        'edittxt' => esc_html__( 'Fail to upload. Try again.', 'themescamp-core' )
                    )
                );
                wp_die();
            }

            if ( is_array( $sourceData ) && count( $sourceData ) == 1 && isset( $sourceData[0]['template_id'] ) && $sourceData[0]['template_id'] > 1 ) {
                $template_id = $sourceData[0]['template_id'];
                if ( $importType == 'page' ) {
                    $metaData = get_post_meta( $template_id );
                    if ( isset( $metaData['_elementor_data'] ) && isset( $metaData['_elementor_data'][0]  ) ) {

                        $_elementor_data          = wp_slash( $metaData['_elementor_data'][0] );

                        $defaulttitle = ( ! empty( $page_title ) ) ? $page_title : $defaultPageTitle;

                        $args = [
                            'post_type'    => 'page',
                            'post_status'  => empty( $page_title ) ? 'draft' : 'publish',
                            'post_title'   => ! empty( $page_title ) ? $page_title : $defaulttitle,
                            'post_content' => '',
                        ];

                        $new_post_id = wp_insert_post( $args );
                        update_post_meta( $new_post_id, '_elementor_data', $_elementor_data );
                        if(isset($metaData['_elementor_page_settings']) && isset($metaData['_elementor_page_settings'][0])){
                            $_elementor_page_settings = maybe_unserialize( $metaData['_elementor_page_settings'][0] );
                            update_post_meta( $new_post_id, '_elementor_page_settings', $_elementor_page_settings );
                        }
                        update_post_meta( $new_post_id, '_elementor_template_type', $response_data['type'] );
                        update_post_meta( $new_post_id, '_elementor_edit_mode', 'builder' );

                        if ( $new_post_id && ! is_wp_error( $new_post_id ) ) {
                            update_post_meta( $new_post_id, '_wp_page_template', ! empty( $response_data['page_template'] ) ? $response_data['page_template'] : 'elementor_header_footer' );
                        }

                        echo json_encode(
                            array(
                                'success' => true,
                                'id'      => $new_post_id,
                                'edittxt' => ( $importType == 'page' ) ? esc_html__( 'Edit Page', 'themescamp-core' ) : esc_html__( 'Edit Template', 'themescamp-core' )
                            )
                        );
                        wp_die();
                    }
                } else {

                    echo json_encode(
                        array(
                            'success' => true,
                            'id'      => $template_id,
                            'edittxt' => esc_html__( 'Edit Template', 'themescamp-core' )
                        )
                    );
                    wp_die();
                }
            }
        }

        echo json_encode(
            array(
                'success' => false,
                'id'      => '',
                'edittxt' => esc_html__( 'Fail to upload. Try again', 'themescamp-core' )
            )
        );
        wp_die();
    }

    protected function loadHtmlItems( $demoData ) {
        foreach ( $demoData as $data ):
            include 'template-parts/demo-template-item.php';
        endforeach;
    }

    public function admin_notice(){

        Notices::add_notice(
            [
                'id'               => 'template-library-issue',
                'type'             => 'warning',
                'dismissible'      => true,
                'dismissible-time' => 1043200,
                'message'          => __( 'This template library will be deprecated soon so please use our brand new template library in your editor (Make sure you activated it from <a href="admin.php?page=element_kit_options#element_kit_other_settings">element kit settings</a>).', 'themescamp-core' ),
            ]
        );
    }


    /** All Pages Tab (First time load / on refresh load)**/
    function plugin_page() {
        $naviationItems = $this->getNaviationItems();
        $demoData = $this->getData();
        $current_user = wp_get_current_user();
        ?>
        <div class="wrap element-kit-dashboard">
            <h1>Template Library</h1>
            <?php if ( is_array( $demoData ) ) : ?>
                <div class="tc-template-library">
                    <div id="tc-template-library-params">
                        <input type="hidden" class="tc-template-category-slug" value=""/>
                        <input type="hidden" class="tc-template-type-filter" value="*"/>
                        <input type="hidden" class="tc-template-sort-by-date" value="desc"/>
                        <input type="hidden" class="tc-template-sort-by-title" value=""/>
                        <input type="hidden" class="tc-template-search-query" value=""/>
                        <input type="hidden" class="tc-template-paged" value="0"/>
                        <input type="hidden" class="tc-template-is-load-more" value="0"/>
                    </div>

                    <div class="tc-template-library-container tc-grid" tc-grid >
                        <div class="tc-template-library-sidebar tc-width-1-4@m tc-width-1-5@l">
                            <div class="tc-sidebar-container tc-height-1-1">
                                <div class="tc-sidebar-header">
                                    <a href="javascript:void(0)" class="sync-demo-template-btn" id="sync_demo_template_btn" title="Sync the template library">
                                        <span class="dashicons dashicons-update"></span>
                                    </a>
                                    <h3>Template Library</h3>
                                    <p>Hello <?php echo esc_html($current_user->user_firstname); ?> <?php echo esc_html($current_user->user_lastname); ?>. We have total: <?php echo esc_attr($this->demo_total); ?>. You will get new template occasionally.</p>
                                </div>
                                <ul class="tc-list tc-list-divider">
                                    <?php
                                    foreach ( $naviationItems as $data ):
                                        include 'template-parts/demo-naviation-item.php';
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="tc-template-grid-container tc-width-3-4@m tc-width-4-5@l">
                            <div class="tc-flex tc-grid tc-margin-medium-bottom" tc-grid>
                                <div class="tc-template-library-sort tc-width-auto">
                                    <select class="tc-select sort-by-title" name="selecot-sorting">
                                        <option value="">Sort By Title</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>

                                <div class="tc-template-library-sort tc-width-auto">
                                    <select class="tc-select sort-by-date" name="selecot-sorting">
                                        <option value="">Sort By Date</option>
                                        <option value="desc">Latest</option>
                                        <option value="asc">Oldest</option>
                                    </select>
                                </div>

                                <div class="tc-template-search tc-width-expand tc-text-right">
                                    <div class="tc-search">
                                        <input class="tc-search-input search-demo-template-value" type="search" name="s" placeholder="Search Template" autofocus>
                                    </div>
                                </div>
                            </div>

                            <div class="tc-grid tc-child-width-1-2@s tc-child-width-1-2@m tc-child-width-1-3@l tc-child-width-1-4@xl tc-flex-center tc-text-center tc-demo-template-library-group"
                                 id="tc-template-library-content-body" tc-grid="masonry: true">
                                <?php
                                    $totalPage  = $this->totalPage;
                                    $this->loadHtmlItems( $demoData );
                                    $paged   = 1;
                                ?>
                            </div>
                            <div class="tc-hidden" id="tc-template-library-content-loader">
                                <p><img src="<?php echo TCEK_ASSETS_URL; ?>/images/template-item.svg" alt="template loading..."></p>
                                <p><img src="<?php echo TCEK_ASSETS_URL; ?>/images/template-item.svg" alt="template loading..."></p>
                                <p><img src="<?php echo TCEK_ASSETS_URL; ?>/images/template-item.svg" alt="template loading..."></p>
                            </div>
                            <?php include 'template-parts/demo-load-more-btn.php'; ?>
                        </div>
                    </div>
                    <?php $this->import_modal(); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function import_modal() {

        ?>
        <div id="demo-importer-modal-section" tc-modal>
            <div class="tc-modal-dialog">
                <button class="tc-modal-close-default" type="button" tc-close></button>
                <div class="tc-modal-header">
                    <h2 class="tc-modal-title tc-margin-remove">Import Template</h2>
                </div>
                <div class="tc-modal-body">

                    <div class="demo-importer-form">
                        <input type="hidden" name="demo_id" class="demo_id" value=""/>
                        <input type="hidden" name="demo_json_url" class="demo_json_url" value=""/>
                        <input type="hidden" name="admin_url" class="admin_url"
                               value="<?php echo admin_url(); ?>"/>
                        <input type="hidden" name="default_page_title" class="default_page_title" value=""/>

                        <div class="tc-grid tc-flex tc-flex-middle">
                            <div class="tc-width-1-2@m">
                                <div class="">
                                    <fieldset class="tc-margin-bottom">
                                        <label><input class="" type="radio" name="template_import" value="library" checked="checked"><span class="title">Import to Elementor Library</span></label><br>
                                        <label><input class="" type="radio" name="template_import" value="page"><span class="title">Import to Page</span></label>
                                    </fieldset>

                                    <label class="tc-margin-bottom tc-flex tc-width-1-1">
                                        <input class="tc-input tc-width-1-1 page_title" type="text"
                                               placeholder="Enter Template Title">
                                    </label>

                                    <a href="javascript:void(0)"
                                       class="tc-button tc-button-secondary import-into-library">Import Now</a>

                                </div>
                            </div>

                            <div class="tc-width-1-2@m">
                                <div class="tc-plg-required-part">
                                    <h3 class="tc-margin-remove-top">Required Plugin</h3>
                                    <ul class="tc-list required-plugin-list">
                                        <!-- dynamic contest goes there   -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="demo-importer-callback tc-hidden">
                        <p class="callback-message" style="font-size: 17px"></p>
                        <div class="edit-page"></div>
                    </div>

                    <div class="demo-importer-loading tc-hidden">
                        <h3 class="message">Please wait...</h3>
                    </div>
                </div>
                <div class="tc-modal-footer">
                    <div class="tc-grid tc-child-width-1-2 tc-flex tc-flex-middle tc-grid-collapse">
                        <div class="tc-text-left">
                            <a href="#" class="tc-template-report-button" title="Import Problem? Report it."></a>
                        </div>
                        <div class="tc-text-right">
                            <button class="tc-button tc-button-primary tc-modal-close" type="button">Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /** Load data when click on Demo Tab **/
    function demo_tab_ajax_loading_demo() {
        $this->searchVal      = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';
        $this->termSlug       = isset($_REQUEST['term_slug']) ? sanitize_text_field($_REQUEST['term_slug']) : '';
        $this->demoType       = isset($_REQUEST['demo_type']) ? sanitize_text_field($_REQUEST['demo_type']) : '';
        $this->sortByTitle    = isset($_REQUEST['sort_By_title']) ? sanitize_text_field($_REQUEST['sort_By_title']) : '';
        $this->sortByDate     = isset($_REQUEST['sort_By_date']) ? sanitize_text_field($_REQUEST['sort_By_date']) : '';
        $paged                = isset($_REQUEST['paged']) ? intval($_REQUEST['paged']) : 0;

        $filterData = $this->getData($paged);
        ob_start();
        $this->loadHtmlItems( $filterData );
        $paged   = $paged + 1;

        $html = ob_get_contents();
        ob_end_clean();
        echo json_encode(
            array(
                'success'   => true,
                'data'      => $html,
                'paged'     => $paged,
                'total_page'=> $this->totalPage
            )
        );
        wp_die();
    }

    public function sync_demo_with_server(){

        $this->createTemplateTables();

        echo json_encode(
            array(
                'success' => true,
                'data'    => array(),
            )
        );

        wp_die();
    }

    public function send_report(){
        if(isset($_REQUEST['demo_id']) && $_REQUEST['demo_id'] > 0 && isset($_REQUEST['demo_json_url'])){
            $demo_id        = $_REQUEST['demo_id'];
            $demo_json_url  = $_REQUEST['demo_json_url'];
            $json_url       = 'Demo ID:'+$demo_id;
            $demo_url       = $demo_json_url;
            $demo_title     = 'No Demo Title';

            $postTable      = $this->table_post;
            $resultData = $this->wpdb->get_row("SELECT * FROM $postTable WHERE demo_id=$demo_id");

            if($resultData){
                $json_url       = $resultData->json_url;
                $demo_url       = $resultData->demo_url;
                $demo_title     = $resultData->title;
            }elseif($error = $this->wpdb->last_error){
                $demo_title     = $error;
            }

            $data['json_url']   = $json_url;
            $data['demo_title'] = $demo_title;
            $data['demo_url']   = $demo_url;
            $userInfo = wp_get_current_user();
            $data['display_name'] = $userInfo->data->display_name;
            $data['user_email'] = $userInfo->data->user_email;
            $data['site_url'] = site_url();

            if($this->sendMail($data)){
                echo json_encode(
                    array(
                        'success' => true,
                        'data'    => array(),
                    )
                );
                wp_die();
            };
        }

        echo json_encode(
            array(
                'success' => false,
                'data'    => array(),
            )
        );
        wp_die();
    }

}

new ElementKit_Template_Library();
