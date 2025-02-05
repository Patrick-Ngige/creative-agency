!(function (e) {
    "use strict";
    var t,
        a,
        n = window.ElementKitLibreryData || {};
    (a = {
        TcTemplateHeaderView: null,
        TcTemplateLoadingView: null,
        TcTemplateLayoutView: null,
        TcTemplateErrorView: null,
        TcTemplateBodyView: null,
        TcTemplateCollectionView: null,
        TcTemplateTabsCollectionView: null,
        TcTemplateTabsItemView: null,
        TcTemplateTemplateItemView: null,
        TcTemplatePreviewView: null,
        TcTemplateHeaderBack: null,
        TcTemplateHeaderInsertButton: null,
        TcTemplateInsertTemplateBehavior: null,
        TcTemplateProButton: null,
        TcTemplateTabsCollection: null,
        TcTemplateCollection: null,
        TcTemplateLibraryTemplateModel: null,
        TcFiltersCollectionView: null,
        TcFiltersItemView: null,
        TcCategoriesCollection: null,
        TcCategoryModel: null,
        TcTabModel: null,
        init: function () {
            var e = this;
            (e.TcTemplateLibraryTemplateModel = Backbone.Model.extend({ defaults: { id: 0, template_id: 0, title: "", thumbnail: "", demo_url: "", is_pro: "", preview: "", source: "", package: "", date: "", categories: "" } })),
                (e.TcCategoryModel = Backbone.Model.extend({ defaults: { term_slug: "", term_name: "", count: 0 } })),
                (e.TcTabModel = Backbone.Model.extend({ defaults: { term_slug: "", term_name: "", count: 0 } })),
                (e.TcTemplateCollection = Backbone.Collection.extend({ model: e.TcTemplateLibraryTemplateModel })),
                (e.TcCategoriesCollection = Backbone.Collection.extend({ model: e.TcCategoryModel })),
                (e.TcTemplateTabsCollection = Backbone.Collection.extend({ model: e.TcTabModel })),
                (e.TcTemplateLoadingView = Marionette.ItemView.extend({ id: "tc-elementkit-template-library-loading", template: "#view-tc-elementkit-template-library-loading" })),
                (e.TcTemplateErrorView = Marionette.ItemView.extend({ id: "tc-elementkit-template-library-error", template: "#view-tc-elementkit-template-library-error" })),
                (e.TcTemplateHeaderView = Marionette.LayoutView.extend({
                    id: "tc-elementkit-template-library-header",
                    template: "#view-tc-elementkit-template-library-header",
                    ui: { closeModal: "#tc-elementkit-template-library-header-close-modal", syncBtn: "#tc-elementkit-template-library-header-sync.elementor-templates-modal__header__item>i" },
                    events: { "click @ui.closeModal": "onCloseModalClick", "click @ui.syncBtn": "onSyncBtnClick" },
                    regions: { headerTabs: "#tc-elementkit-template-library-header-tabs", headerActions: "#tc-elementkit-template-library-header-actions" },
                    onCloseModalClick: function () {
                        t.closeModal();
                    },
                    onSyncBtnClick: function () {
                        t.syncDataNow();
                    },
                })),
                (e.TcTemplatePreviewView = Marionette.ItemView.extend({
                    template: "#view-tc-elementkit-template-library-preview",
                    id: "elementor-template-library-preview",
                    ui: { iframe: "iframe" },
                    onRender: function () {
                        t.hideHeaderLogo(), this.ui.iframe.attr("src", this.getOption("preview"));
                    },
                })),
                (e.TcTemplateHeaderBack = Marionette.ItemView.extend({
                    template: "#view-tc-elementkit-template-library-header-back",
                    id: "tc-elementkit-template-library-header-back",
                    ui: { button: "button" },
                    events: { "click @ui.button": "onBackClick" },
                    onBackClick: function () {
                        t.setPreview("back"), t.showHeaderLogo();
                    },
                })),
                (e.TcTemplateInsertTemplateBehavior = Marionette.Behavior.extend({
                    ui: { insertButton: ".tc-elementkit-template-library-template-insert" },
                    events: { "click @ui.insertButton": "onInsertButtonClick" },
                    onInsertButtonClick: function () {
                        var e,
                            a,
                            n,
                            l = this.view.model;
                        t.layout.showLoadingView(),
                            (n = { unique_id: (e = l.get("template_id")), data: { edit_mode: !0, display: !0, template_id: e } }),
                            (a = {
                                success: function (e) {
                                    $e.run("document/elements/import", { model: window.elementor.elementsModel, data: e, options: {} }), t.closeModal();
                                },
                                error: function (e) {
                                    "required_activated_license" == e ? t.layout.showLicenseError() : alert("An error occurred. Pls try again!");
                                },
                            }) && jQuery.extend(!0, n, a),
                            elementorCommon.ajax.addRequest("get_tcg_elementkit_template_data", n);
                    },
                })),
                (e.TcTemplateHeaderInsertButton = Marionette.ItemView.extend({
                    template: "#view-tc-elementkit-template-library-insert-button",
                    id: "tc-elementkit-template-library-insert-button",
                    behaviors: { insertTemplate: { behaviorClass: e.TcTemplateInsertTemplateBehavior } },
                })),
                (e.TcTemplateProButton = Marionette.ItemView.extend({ template: "#view-tc-elementkit-template-library-pro-button", id: "tc-elementkit-template-library-pro-button" })),
                (e.TcTemplateTemplateItemView = Marionette.ItemView.extend({
                    template: "#view-tc-elementkit-template-library-item",
                    className: function () {
                        var e = " tc-elementkit-template-has-url",
                            t = " elementor-template-library-template-";
                        return (
                            "" === this.model.get("demo_url") && (e = " tc-elementkits-template-no-url"),
                            "tc-elementkit-local" == this.model.get("is_pro") ? (t += "local") : (t += "remote"),
                            "elementor-template-library-template" + t + e
                        );
                    },
                    ui: function () {
                        return { previewButton: ".elementor-template-library-template-preview" };
                    },
                    events: function () {
                        return { "click @ui.previewButton": "onPreviewButtonClick" };
                    },
                    onPreviewButtonClick: function () {
                        "" !== this.model.get("demo_url") && t.setPreview(this.model);
                    },
                    behaviors: { insertTemplate: { behaviorClass: e.TcTemplateInsertTemplateBehavior } },
                })),
                (e.TcFiltersItemView = Marionette.ItemView.extend({
                    template: "#view-tc-elementkit-template-library-filters-item",
                    className: function () {
                        return "tc-elementkit-filter-item";
                    },
                    ui: function () {
                        return { filterLabels: ".tc-elementkit-template-library-filter-label" };
                    },
                    events: function () {
                        return { "click @ui.filterLabels": "onFilterClick" };
                    },
                    onFilterClick: function (e) {
                        var a = jQuery(e.target);
                        t.setFilter("searchkeyword", ""), t.setFilter("category", a.val()), jQuery("#elementor-template-library-filter-text").val("");
                    },
                })),
                (e.TcTemplateTabsItemView = Marionette.ItemView.extend({
                    template: "#view-tc-elementkit-template-library-tabs-item",
                    className: function () {
                        return "elementor-template-library-menu-item";
                    },
                    ui: function () {
                        return { tabsLabels: "label", tabsInput: "input" };
                    },
                    events: function () {
                        return { "click @ui.tabsLabels": "onTabClick" };
                    },
                    onRender: function () {
                        this.model.get("term_slug") === t.getTab() && this.ui.tabsInput.attr("checked", "checked");
                    },
                    onTabClick: function (e) {
                        var a = jQuery(e.target);
                        t.setTab(a.val()), t.setFilter("searchkeyword", "");
                    },
                })),
                (e.TcTemplateCollectionView = Marionette.CompositeView.extend({
                    template: "#view-tc-elementkit-template-library-templates",
                    id: "tc-elementkit-template-library-templates",
                    childViewContainer: "#tc-elementkit-template-library-templates-container",
                    initialize: function () {
                        this.listenTo(t.channels.templates, "filter:change", this._renderChildren);
                    },
                    filter: function (e) {
                        var a = t.getFilter("searchkeyword");
                        if (a) return (a = a.toLowerCase()), -1 !== e.get("title").toLowerCase().indexOf(a.toLowerCase()) && ((t.countResult = t.countResult + 1), !0);
                        var n = t.getFilter("category");
                        return n ? e.get("categories") == n : e.get("categories") != n || e.get("categories") == n;
                    },
                    getChildView: function (t) {
                        return e.TcTemplateTemplateItemView;
                    },
                    onRenderCollection: function () {
                        t.showSearchCounter();
                    },
                })),
                (e.TcTemplateTabsCollectionView = Marionette.CompositeView.extend({
                    template: "#view-tc-elementkit-template-library-tabs",
                    childViewContainer: "#tc-elementkit-template-library-tabs-items",
                    initialize: function () {},
                    getChildView: function (t) {
                        return e.TcTemplateTabsItemView;
                    },
                })),
                (e.TcFiltersCollectionView = Marionette.CompositeView.extend({
                    id: "tc-elementkit-template-library-filters",
                    template: "#view-tc-elementkit-template-library-filters",
                    childViewContainer: "#tc-elementkit-template-library-filters-container",
                    getChildView: function (t) {
                        return e.TcFiltersItemView;
                    },
                })),
                (e.TcTemplateBodyView = Marionette.LayoutView.extend({
                    id: "tc-elementkit-template-library-content",
                    className: function () {
                        return "library-tab-" + t.getTab();
                    },
                    ui: function () {
                        return { SearchInput: "input#elementor-template-library-filter-text" };
                    },
                    events: function () {
                        return { "keyup @ui.SearchInput": "onTextFilterInput" };
                    },
                    onTextFilterInput: function () {
                        var e = this.ui.SearchInput.val();
                        (t.countResult = 0), t.setFilter("searchkeyword", e);
                    },
                    template: "#view-tc-elementkit-template-library-content",
                    regions: { contentTemplates: ".tc-elementkit-templates-list", contentFilters: ".tc-elementkit-filters-list" },
                })),
                (e.TcTemplateLayoutView = Marionette.LayoutView.extend({
                    el: "#tc-elementkit-template-library-modal",
                    regions: n.modalRegions,
                    initialize: function () {
                        this.getRegion("modalHeader").show(new e.TcTemplateHeaderView()), this.listenTo(t.channels.tabs, "filter:change", this.switchTabs), this.listenTo(t.channels.layout, "preview:change", this.switchPreview);
                    },
                    switchTabs: function () {
                        this.showLoadingView(), t.getTemplatedata(t.getTab());
                    },
                    switchPreview: function () {
                        var a = this.getHeaderView(),
                            l = t.getPreview();
                        if ("back" === l) return a.headerTabs.show(new e.TcTemplateTabsCollectionView({ collection: t.collections.tabs })), a.headerActions.empty(), void t.setTab(t.getTab());
                        "initial" !== l
                            ? (this.getRegion("modalContent").show(new e.TcTemplatePreviewView({ preview: l.get("demo_url") })),
                              a.headerTabs.show(new e.TcTemplateHeaderBack()),
                              1 != l.get("is_pro") || n.license.activated ? a.headerActions.show(new e.TcTemplateHeaderInsertButton({ model: l })) : a.headerActions.show(new e.TcTemplateProButton({ model: l })))
                            : a.headerActions.empty();
                    },
                    getHeaderView: function () {
                        return this.getRegion("modalHeader").currentView;
                    },
                    getContentView: function () {
                        return this.getRegion("modalContent").currentView;
                    },
                    showLoadingView: function () {
                        this.modalContent.show(new e.TcTemplateLoadingView());
                    },
                    showLicenseError: function () {
                        this.modalContent.show(new e.TcTemplateErrorView());
                    },
                    showTemplatesView: function (a, n) {
                        this.getRegion("modalContent").show(new e.TcTemplateBodyView());
                        var l = this.getContentView(),
                            i = this.getHeaderView();
                        (t.collections.tabs = new e.TcTemplateTabsCollection(t.getTabs())),
                            i.headerTabs.show(new e.TcTemplateTabsCollectionView({ collection: t.collections.tabs })),
                            l.contentTemplates.show(new e.TcTemplateCollectionView({ collection: a })),
                            l.contentFilters.show(new e.TcFiltersCollectionView({ collection: n }));
                    },
                }));
        },
    }),
        (t = {
            modal: !1,
            layout: !1,
            collections: {},
            tabs: {},
            defaultTab: "",
            countResult: 0,
            channels: {},
            atIndex: null,
            init: function () {
                window.elementor.on("preview:loaded", window._.bind(t.onPreviewLoaded, t)), a.init();
            },
            onPreviewLoaded: function () {
                let e = setInterval(() => {
                    window.elementor.$previewContents.find(".elementor-add-new-section").length && (this.initLibraryButton(), clearInterval(e));
                }, 100);
                window.elementor.$previewContents.on("click", ".elementor-editor-element-setting.elementor-editor-element-add", this.initLibraryButton),
                    window.elementor.$previewContents.on("click.addTcgElementKitTemplate", ".elementor-add-tc-button", _.bind(this.showTemplatesModal, this)),
                    (this.channels = { templates: Backbone.Radio.channel("TC_THEME_EDITOR:templates"), tabs: Backbone.Radio.channel("TC_THEME_EDITOR:tabs"), layout: Backbone.Radio.channel("TC_THEME_EDITOR:layout") }),
                    (this.tabs = n.tabs),
                    (this.defaultTab = n.defaultTab);
            },
            initLibraryButton: function () {
                var a = window.elementor.$previewContents.find(".elementor-add-new-section"),
                    l = '<div class="elementor-add-section-area-button elementor-add-tc-button"></div>';
                a.find(".elementor-add-tc-button").length ||
                    (a.length && n.libraryButton && e(l).prependTo(a),
                    window.elementor.$previewContents.on("click.addTcgElementKitTemplate", ".elementor-editor-section-settings .elementor-editor-element-add", function () {
                        var a = e(this).closest(".elementor-top-section"),
                            i = a.data("model-cid");
                        window.elementor.sections &&
                            window.elementor.sections.currentView.collection.length &&
                            e.each(window.elementor.sections.currentView.collection.models, function (e, a) {
                                i === a.cid && (t.atIndex = e);
                            }),
                            n.libraryButton && a.prev(".elementor-add-section").find(".elementor-add-new-section").prepend(l);
                    }));
            },
            getFilter: function (e) {
                return this.channels.templates.request("filter:" + e);
            },
            setFilter: function (e, t) {
                this.channels.templates.reply("filter:" + e, t), this.channels.templates.trigger("filter:change");
            },
            getTab: function () {
                return this.channels.tabs.request("filter:tabs");
            },
            setTab: function (e, t) {
                this.channels.tabs.reply("filter:tabs", e), t || this.channels.tabs.trigger("filter:change");
            },
            getTabs: function () {
                var e = [];
                return (
                    _.each(this.tabs, function (t, a) {
                        e.push({ term_slug: a, title: t.title });
                    }),
                    e
                );
            },
            getPreview: function (e) {
                return this.channels.layout.request("preview");
            },
            setPreview: function (e, t) {
                this.channels.layout.reply("preview", e), t || this.channels.layout.trigger("preview:change");
            },
            showTemplatesModal: function () {
                this.getModal().show(), this.layout || ((this.layout = new a.TcTemplateLayoutView()), this.layout.showLoadingView()), this.setTab(this.defaultTab, !0), this.getTemplatedata(this.defaultTab), this.setPreview("initial");
            },
            getTemplatedata: function (t) {
                var n = this,
                    l = n.tabs[t];
                n.setFilter("category", !1),
                    l.data.templates && l.data.categories
                        ? n.layout.showTemplatesView(l.data.templates, l.data.categories)
                        : e.ajax({
                              url: ajaxurl,
                              type: "post",
                              dataType: "json",
                              data: { action: "tcg_element_kit_template_library_get_layouts", tab: t },
                              success: function (e) {
                                  var l = new a.TcTemplateCollection(e.data.templates),
                                      i = new a.TcCategoriesCollection(e.data.categories);
                                  (n.tabs[t].data = { templates: l, categories: i }), n.layout.showTemplatesView(l, i);
                              },
                          });
            },
            syncDataNow: function () {
                this.layout.showLoadingView();
                var t = this;
                e.ajax({
                    url: ajaxurl,
                    type: "post",
                    dataType: "json",
                    data: { action: "tcg_element_kit_template_library_making_syncing" },
                    success: function (e) {
                        var a = t.getTab(),
                            n = t.tabs[a];
                        (n.data.templates = ""), (n.data.categories = ""), t.getTemplatedata(a);
                    },
                });
            },
            showHeaderLogo: function () {
                e("#tc-elementkit-template-library-header-logo-area").show();
            },
            hideHeaderLogo: function () {
                e("#tc-elementkit-template-library-header-logo-area").hide();
            },
            showSearchCounter: function () {
                t.getFilter("searchkeyword")
                    ? (e("#tc-elementkit-template-library-content .search-result-counter span").html(this.countResult), e("#tc-elementkit-template-library-content .search-result-counter").show())
                    : this.hideSearchCounter();
            },
            hideSearchCounter: function () {
                e("#tc-elementkit-template-library-content .search-result-counter").hide(), e("#tc-elementkit-template-library-content .search-result-counter span").html(0);
            },
            closeModal: function () {
                this.getModal().hide(), this.showHeaderLogo();
            },
            getModal: function () {
                return this.modal || (this.modal = elementor.dialogsManager.createWidget("lightbox", { id: "tc-elementkit-template-library-modal", closeButton: !1 })), this.modal;
            },
        }),
        e(window).on("elementor:init", t.init);
})(jQuery);
