!(function ($) {
    "use strict";
    
    const url = window.location.origin + window.location.pathname;

    function tcgDynamicBlockSetId() {
        $('.elementor-control-tcg_dynamic_slides_repeater .elementor-repeater-fields, .elementor-control-tcg_select_block').each(function () {
            let blockId
            $(this).find('[data-select2-id]:selected').each(function () {
                blockId = $(this).val();
                console.log(blockId);
            });
            $(this).find('[data-event="tcgDynamicSlideEditor"], [data-event="tcgDynamicTabEditor"], [data-event="tcgDynamicQueryEditor"]').each(function () {
                $(this).attr('data-tcg-dynamic-block-id', blockId);
            });
            $('[data-event="tcgDynamicQueryEditor"]').each(function () {
                $(this).attr('data-tcg-dynamic-block-id', blockId);
            });
        });
    }

    function createTcgDynamicBlock(postName) {
        console.log(postName);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                action: 'tcg_create_dynamic_block',
                post_title: postName
            },
            beforeSend: function ()
            {
                console.log('sending');
            },
            success: function(data)
            {
                console.log(data);
                $(".tcg-dynamic-editor").remove();
                $('#elementor-editor-wrapper').append(
                    tcgEditDynamicBlockView(url, data)
                );

            },
            error: function()
            {
                console.log('nay');

            }
        })
    }

    function tcgAddDynamicBlockView(){
        return  `<div class="tcg-dynamic-editor">
            <div class="editor-container">
                <div class="editor-controllers">
                    <i class="eicon-editor-close close-tcg-dynamic-editor"></i>
                </div>
                <div class="tcg-add-dynamic-block">
                    <h2 class="tcg-add-dynamic-title">Add new slide</h2>
                    <form class="tcg-add-dynamic-form" method="POST">
                        <input placeholder="Slide Title" id="tcg-dynamic-name" type="text" name="tcg-dynamic-name" />
                        <input id="add-tcg-dynamic-block" type="button" value="Add"/>
                    </form>
                </div>
            </div>
        </div>`
    }

    function tcgEditDynamicBlockView(url, slideId) {
        return `<div class="tcg-dynamic-editor">
            <div class="editor-container">
                <div class="editor-controllers">
                    <i class="eicon-editor-close close-tcg-dynamic-editor"></i>
                </div>
                <iframe class="editor-view" src="${url}?post=${slideId}&action=elementor"></iframe>
            </div>
        </div>`
    }

    $(document).ready(function () {

        elementor.hooks.addAction('panel/open_editor/widget/tcg-dynamic-slider', function (panel, model, view) {
            let $this = $(panel.$el);
            tcgDynamicBlockSetId();
    
            $this.on('change', '.tcg-select2', function () {
                tcgDynamicBlockSetId();
            });

            $this.find('[data-event="tcgAddDynamicBlock"]').on('click', function () {
                $('#elementor-editor-wrapper').append(
                    tcgAddDynamicBlockView()
                );
            });
    
            $this.find('[data-event="tcgDynamicSlideEditor"]').on('click', function () {
                tcgDynamicBlockSetId();
                const slideId = $(this).attr('data-tcg-dynamic-block-id');
                $('#elementor-editor-wrapper').append(
                    tcgEditDynamicBlockView(url, slideId)
                );
            });
    
            $('#elementor-editor-wrapper').off('click', '.close-tcg-dynamic-editor').on('click', '.close-tcg-dynamic-editor', function () {
                let c = 1;
                console.log(c+c);
                $(".tcg-dynamic-editor").remove();
                elementor.reloadPreview();
            });

            $('#elementor-editor-wrapper').off('click', '.tcg-add-dynamic-block #add-tcg-dynamic-block').on('click', '.tcg-add-dynamic-block #add-tcg-dynamic-block', function () {
                const postName = $('#tcg-dynamic-name').val();
                createTcgDynamicBlock(postName);
            });
        });

        elementor.hooks.addAction('panel/open_editor/widget/tcg-dynamic-tabs', function (panel, model, view) {
            let $this = $(panel.$el);
            tcgDynamicBlockSetId();
    
            $this.on('change', '.tcg-select2', function () {
                tcgDynamicBlockSetId();
            });

            $this.find('[data-event="tcgAddDynamicBlock"]').on('click', function () {
                $('#elementor-editor-wrapper').append(
                    tcgAddDynamicBlockView()
                );
            });
    
            $this.find('[data-event="tcgDynamicTabEditor"]').on('click', function () {
                tcgDynamicBlockSetId();
                const slideId = $(this).attr('data-tcg-dynamic-block-id');
                $('#elementor-editor-wrapper').append(
                    tcgEditDynamicBlockView(url, slideId)
                );
            });
    
            $('#elementor-editor-wrapper').off('click', '.close-tcg-dynamic-editor').on('click', '.close-tcg-dynamic-editor', function () {
                let c = 1;
                console.log(c+c);
                $(".tcg-dynamic-editor").remove();
                elementor.reloadPreview();
            });

            $('#elementor-editor-wrapper').off('click', '.tcg-add-dynamic-block #add-tcg-dynamic-block').on('click', '.tcg-add-dynamic-block #add-tcg-dynamic-block', function () {
                const postName = $('#tcg-dynamic-name').val();
                createTcgDynamicBlock(postName);
            });
        });

        elementor.hooks.addAction( 'panel/open_editor/widget/tcg-dynamic-query', function( panel, model, view ) {
            let $this = $(panel.$el);
            tcgDynamicBlockSetId();
    
            $this.on('change', '.tcg-select2', function () {
                tcgDynamicBlockSetId();
            });

            $this.find('[data-event="tcgAddDynamicBlock"]').on('click', function () {
                $('#elementor-editor-wrapper').append(
                    tcgAddDynamicBlockView()
                );
            });
    
            $this.find('[data-event="tcgDynamicQueryEditor"]').on('click', function () {
                tcgDynamicBlockSetId();
                const slideId = $(this).attr('data-tcg-dynamic-block-id');
                $('#elementor-editor-wrapper').append(
                    tcgEditDynamicBlockView(url, slideId)
                );
            });
    
            $('#elementor-editor-wrapper').off('click', '.close-tcg-dynamic-editor').on('click', '.close-tcg-dynamic-editor', function () {
                let c = 1;
                console.log(c+c);
                $(".tcg-dynamic-editor").remove();
                elementor.reloadPreview();
            });

            $('#elementor-editor-wrapper').off('click', '.tcg-add-dynamic-block #add-tcg-dynamic-block').on('click', '.tcg-add-dynamic-block #add-tcg-dynamic-block', function () {
                const postName = $('#tcg-dynamic-name').val();
                createTcgDynamicBlock(postName);
            });
        });
        
    });

})(jQuery); 