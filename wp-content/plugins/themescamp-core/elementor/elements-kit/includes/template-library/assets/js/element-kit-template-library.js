(function (window, document, $, undefined) {

    'use strict';

    const tcgTemplateLibrary = {
        //Initializing properties and methods
        init: function (e) {
            tcgTemplateLibrary.GlobalProps();
            tcgTemplateLibrary.methods();
        },

        //global properties
        GlobalProps: function (e) {
            this._window = $(window);
            this._document = $(document);
            this._body = $('body');
            this._html = $('html');
            this.librayWrapper = $(document);
            // this.librayWrapper = $('.tc-template-library');

        },
        //methods
        methods: function (e) {
            tcgTemplateLibrary.clickDoc();
            tcgTemplateLibrary.scrollingLoading();
        },

        scrollingLoading:function(){
            (this._window).on('scroll', function () {
                var totalGridHeight = $(this._document).height() - $(this._window).height();
                if ( $(this._window).scrollTop() >= (totalGridHeight - 600) ) {
                    var clickedLi = $('div.tc-template-library .tc-list-divider').find('li.tc-active');
                    if ( clickedLi.length == 1 ) {
                        $('.tc-template-grid-container').find('a.load_more_btn').trigger('click');
                    }
                }
            });
        },
        clickDoc:function(){
            var importModalDataLoad, importDemoData, loadMoreDemoItem, switchCategoryItem, switchDemoTypeData,
                sortByDate, sortByTitle, searchDemoData, resetDemoData, reportDemoImportingError;

            importModalDataLoad = function (e) {
                var _this             = $(this);
                var modalSelector     = '#demo-importer-modal-section';
                var demo_id           = _this.data('demo-id');
                var json_url          = _this.data('demo-url');
                var demoTitle         = _this.data('demo-title');
                var plugins           = _this.parents('.demo-importer-template-item').find('.plugin-content-item').html();
                var sendReportBtnHtml = '<span class="dashicons dashicons-warning"></span> Report Problem';

                $(modalSelector).find('.tc-template-report-button').html(sendReportBtnHtml);
                $(modalSelector).find('.demo-importer-form').removeClass('tc-hidden');
                $(modalSelector).find('.demo-importer-callback').addClass('tc-hidden');
                $(modalSelector).find('.demo-importer-loading').addClass('tc-hidden');
                $(modalSelector).find('.demo-importer-callback .edit-page').html('');
                $(modalSelector).find('.demo-importer-callback .callback-message').html('');
                $(modalSelector).find('.required-plugin-list').html('');
                $(modalSelector).find('.required-plugin-list').html(plugins);


                $(modalSelector).find('.demo_id').val(demo_id);
                $(modalSelector).find('.demo_json_url').val(json_url);
                $(modalSelector).find('.default_page_title').val(demoTitle);
                $(modalSelector).find('.page_title').val('');
                tcgUIkit.modal(modalSelector).show();
            }

            importDemoData = function (e) {
                e.preventDefault();
                var modalSelector    = $('#demo-importer-modal-section');
                var demo_id          = modalSelector.find('.demo_id').val();
                var json_url         = modalSelector.find('.demo_json_url').val();
                var admin_url        = modalSelector.find('.admin_url').val();
                var import_type      = '';
                var page_title       = modalSelector.find('.page_title').val();
                var defaultPageTitle = modalSelector.find('.default_page_title').val();

                var template_import = modalSelector.find('input[name=template_import]:checked').val();

                if ( template_import == 'library' ) {
                    import_type = 'library';
                } else {
                    import_type = 'page';
                }

                $.ajax({
                    url       : ajaxurl,
                    data      : {
                        'action'            : 'ep_elementor_demo_importer_data_import',
                        'demo_url'          : json_url,
                        'demo_id'           : demo_id,
                        'demo_import_type'  : import_type,
                        'page_title'        : page_title,
                        'default_page_title': defaultPageTitle
                    },
                    dataType  : 'JSON',
                    beforeSend: function () {
                        $(modalSelector).find('.demo-importer-form').addClass('tc-hidden');
                        $(modalSelector).find('.demo-importer-callback').removeClass('tc-hidden');
                        $(modalSelector).find('.demo-importer-loading').removeClass('tc-hidden');
                    },
                    success   : function (data) {
                        if ( data.success ) {
                            $(modalSelector).find('.demo-importer-callback .callback-message').html('Successfully <strong>' + defaultPageTitle + '</strong> has been imported.');
                            var page_url = admin_url + '/post.php?post=' + data.id + '&action=elementor';
                            $(modalSelector).find('.demo-importer-callback .edit-page').html('<a href="' + page_url + '" class="tc-button tc-button-secondary" target="_blank">' + data.edittxt + '</a>');
                        } else {
                            $(modalSelector).find('.demo-importer-callback .callback-message').text(data.edittxt);
                        }
                    },
                    complete  : function (data) {
                        $(modalSelector).find('.demo-importer-loading').addClass('tc-hidden');
                    },
                    error     : function (errorThrown) {
                        $(modalSelector).find('.demo-importer-loading').addClass('tc-hidden');
                    }
                });
            }

            loadMoreDemoItem = function (e) {
                var _this        = $(this);
                var _paged       = _this.data('paged');
                var _total_paged = _this.data('total');
                var clicked = _this.data('clicked');

                if (_paged < _total_paged){
                    if (clicked==0){
                        $('.tc-template-library #tc-template-library-params').find('.tc-template-paged').val(_paged);
                        $('.tc-template-library #tc-template-library-params').find('.tc-template-is-load-more').val(1);
                        tcgTemplateLibrary.getDemoData();
                        _this.data('clicked',1);
                    }
                }else{
                    _this.addClass('tc-hidden');
                }
            }

            switchCategoryItem = function (e) {
                var _this    = $(this);
                var TermSlug = _this.data('demo');

                if ( !TermSlug ) {
                    return false;
                }
                $('.tc-template-library #tc-template-library-params').find('.tc-template-category-slug').val(TermSlug);

                $('.tc-template-library .template-category-item').removeClass('tc-active');
                $(this).addClass('tc-active');

                tcgTemplateLibrary.resetLibraryParams()
                tcgTemplateLibrary.showLoader();
                tcgTemplateLibrary.getDemoData();
            }

            switchDemoTypeData = function(e){
                e.preventDefault();
                var _this  = $(this);
                var filter = _this.data('filter');

                $('.tc-template-library .pro-free-nagivation-item').removeClass('tc-active');
                $(this).addClass('tc-active');

                $('.tc-template-library #tc-template-library-params').find('.tc-template-type-filter').val(filter);
                tcgTemplateLibrary.showLoader();
                tcgTemplateLibrary.getDemoData();
            }

            sortByDate = function (e) {
                var SortType = $(this).val();
                $('.tc-template-library #tc-template-library-params').find('.tc-template-sort-by-date').val(SortType);
                tcgTemplateLibrary.showLoader();
                tcgTemplateLibrary.getDemoData();
            }

            sortByTitle = function (e) {
                var SortType = $(this).val();
                $('.tc-template-library #tc-template-library-params').find('.tc-template-sort-by-title').val(SortType);
                tcgTemplateLibrary.showLoader();
                tcgTemplateLibrary.getDemoData();
            }


            var searchTimer = null, searchDelaySec = 2000;
            searchDemoData = function (e) {
                e.preventDefault();
                var _this           = $(this);
                var searchVal       = _this.val();
                // clear previous timer
                clearTimeout(searchTimer);

                // start new timer
                searchTimer = setTimeout(function() {
                    tcgTemplateLibrary.showLoader();
                    tcgTemplateLibrary.getDemoData();
                }, searchDelaySec);
            }



            resetDemoData = function (e) {
                e.preventDefault();
                $(this).find('span').addClass('tc-tmpl-loading');
                $.ajax({
                    url       : ajaxurl,
                    data      : {
                        'action': 'ep_elementor_demo_importer_data_sync_demo_with_server'
                    },
                    dataType  : 'JSON',
                    beforeSend: function () {},
                    success   : function (response) {
                        window.location.href = window.location.href;
                    },
                    error     : function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

            reportDemoImportingError = function (e) {
                e.preventDefault();
                var modalSelector = '#demo-importer-modal-section';
                var demo_id       = $(modalSelector).find('.demo_id').val();
                var demo_json_url = $(modalSelector).find('.demo_json_url').val();
                var _this         = $(this);

                $(_this).find('span').removeClass('dashicons-warning');
                $(_this).find('span').addClass('dashicons-update loading');


                $.ajax({
                    url       : ajaxurl,
                    type      : 'post',
                    data      : {
                        'action'       : 'ep_elementor_demo_importer_send_report',
                        'demo_id'      : demo_id,
                        'demo_json_url': demo_json_url
                    },
                    dataType  : 'JSON',
                    beforeSend: function () {
                    },
                    success   : function (response) {
                        //console.log(response.success);
                        if ( response.success ) {
                            _this.html('Report has been sent!');
                        } else {
                            _this.html('Fail to sent report!');
                            window.location.href = window.location.href;
                        }

                    },
                    error     : function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }


            this.librayWrapper.on('click', '.demo-template-action a.import-demo-btn', importModalDataLoad)
            this.librayWrapper.on('click', '#demo-importer-modal-section .import-into-library, #demo-importer-modal-section .import-into-page',importDemoData);
            this.librayWrapper.on('click', '.tc-template-grid-container .load_more_btn',loadMoreDemoItem);
            this.librayWrapper.on('click', 'li.template-category-item',switchCategoryItem);
            this.librayWrapper.on('click', '.pro-free-nagivation-item',switchDemoTypeData);
            this.librayWrapper.on('change', '.tc-template-library-sort select.sort-by-date',sortByDate);
            this.librayWrapper.on('change', '.tc-template-library-sort select.sort-by-title',sortByTitle);
            this.librayWrapper.on('keyup', '.tc-template-library .search-demo-template-value',searchDemoData);
            this.librayWrapper.on('click', '#sync_demo_template_btn',resetDemoData);
            this.librayWrapper.on('click', '#demo-importer-modal-section .tc-template-report-button', reportDemoImportingError);
        },
        resetLibraryParams: function  (){
            var pararmsSelector = $('.tc-template-library #tc-template-library-params');
            pararmsSelector.find('.tc-template-type-filter').val('*');
            pararmsSelector.find('.tc-template-sort-by-title').val('');
            pararmsSelector.find('.tc-template-sort-by-date').val('desc');
            pararmsSelector.find('.tc-template-paged').val(0);
            pararmsSelector.find('.tc-template-is-load-more').val(0);

            $('.tc-template-library .search-demo-template-value').val('')
            $('.tc-template-library .pro-free-nagivation-item').removeClass('tc-active').find('.tc-first-column').addClass('tc-active')
            $('.tc-template-library .pro-free-nagivation-item.tc-first-column').addClass('tc-active')
            $('.tc-template-library .search-demo-template-value').val('')
            $('.tc-template-library-sort select.sort-by-date').val('')
            $('.tc-template-library-sort select.sort-by-title').val('')
        },

        resetPagination: function (){
            var pararmsSelector = $('.tc-template-library #tc-template-library-params');
            pararmsSelector.find('.tc-template-paged').val(0);
            pararmsSelector.find('.tc-template-is-load-more').val(0);
        },

        showLoader: function(){
            var loaderHtml = $('#tc-template-library-content-loader p').clone();
            $('.tc-template-library #tc-template-library-content-body').html(loaderHtml);
            tcgTemplateLibrary.resetPagination()
        },

    // get data
        getDemoData: function(){

            var contentSelector = $('.tc-template-library #tc-template-library-content-body');
            var pararmsSelector = $('.tc-template-library #tc-template-library-params');

            var libraryCategory     = pararmsSelector.find('.tc-template-category-slug').val();
            var libraryTypeFilter   = pararmsSelector.find('.tc-template-type-filter').val();
            var librarySortTitle    = pararmsSelector.find('.tc-template-sort-by-title').val();
            var librarySortDate     = pararmsSelector.find('.tc-template-sort-by-date').val();
            var libraryPage         = pararmsSelector.find('.tc-template-paged').val();
            var is_load_more        = pararmsSelector.find('.tc-template-is-load-more').val();
            var moreBtnSelector     = $('.tc-template-grid-container .load_more_btn');

            if (is_load_more == 1){
                is_load_more = true;
            }else{
                is_load_more = false;
            }

            $.ajax({
                url: ajaxurl,
                data: {
                    'action'        : 'ep_elementor_demo_importer_data_loading',
                    's'             : $('.tc-template-library .search-demo-template-value').val(),
                    'term_slug'     : libraryCategory,
                    'demo_type'     : libraryTypeFilter,
                    'sort_By_title' : librarySortTitle,
                    'sort_By_date'  : librarySortDate,
                    'paged'         : libraryPage
                },
                dataType  : 'JSON',
                beforeSend: function () {
                },
                success   : function (response) {
                    if ( response.success ) {
                        if (is_load_more){
                            contentSelector.append(response.data)
                        }else{
                            contentSelector.html(response.data);
                        }

                        var _paged = response.paged;
                        var _total_paged = response.total_page;

                        moreBtnSelector.data('paged',_paged);
                        moreBtnSelector.data('total',_total_paged);

                        if (_paged < _total_paged){
                            moreBtnSelector.removeClass('tc-hidden');
                        }else{
                            moreBtnSelector.addClass('tc-hidden');
                        }
                    } else {
                        $(contentSelector).find('p').text(response.data);
                    }
                },
                error     : function (errorThrown) {
                    console.log(errorThrown);
                },
                complete:function () {
                    moreBtnSelector.data('clicked',0);
                }
            });
        }

    }
    tcgTemplateLibrary.init();

})(window, document, jQuery);
