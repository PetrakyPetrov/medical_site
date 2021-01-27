<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.js"></script>-->
<!--<form action="up.php" method="post" enctype="multipart/form-data">-->
<!--    <input type="file" name="userfile[]" id="fileElem" multiple accept="image/*"-->
<!--           onchange="handleFiles(this.files)">-->
<!--    <input type="submit" value="Upload Images">-->
<!--</form>-->
<!--<script>-->
<!--	$(function(){-->
<!---->
<!--        $.ajax({-->
<!--            url: "http://localhost/exchange_web/admin/pages/getcontentimages",-->
<!--            success: function(result){-->
<!--                console.log(result);-->
<!---->
<!--            }-->
<!--        });-->
<!---->
<!--        //Optional: specify custom height-->
<!--        window.frameElement.style.height = '500px';-->
<!--		/*-->
<!--		USE THIS FUNCTION TO SELECT CUSTOM ASSET WITH CUSTOM VALUE TO RETURN-->
<!--		An asset can be a file, an image or a page in your own CMS-->
<!--		*/-->
<!--		function selectAsset(assetValue) {-->
<!--			//Get selected URL-->
<!--			console.log(assetValue);-->
<!--			var inp = parent.top.$('#active-input').val();-->
<!--			parent.top.$('#' + inp).val(assetValue);-->
<!---->
<!--			//Close dialog-->
<!--			if (window.frameElement.id == 'ifrFileBrowse') parent.top.$("#md-fileselect").data('simplemodal').hide();-->
<!--			if (window.frameElement.id == 'ifrImageBrowse') parent.top.$("#md-imageselect").data('simplemodal').hide();-->
<!--		}-->
<!--	});-->
<!--</script>-->

<style>
    .content-body {
        height: 100%;
        margin: 0;
    }

    .lookbook-canvas-wrapper .panel-products {
        width: 100%;
    }
</style>

<div>
    <form>
        <input type="file" name="fileupload[]" id="fileupload">
    </form>

</div>

<!--<script src="--><?php //echo base_url(); ?><!--assets/third_party/mustache.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<!--<script type="text/template" id="tpl-tiny-product">-->
<!--    <div class="browse-item item-tiny"-->
<!--         data-item-url="{{productUrl}}"-->
<!--         data-idx="{{id}}"-->
<!--         data-image-proxy="{{itemImageProxyLarge}}"-->
<!--         data-image="{{itemImage}}"-->
<!--         data-image-transparent="{{itemImageTransparent}}">-->
<!--        <div class="preview">-->
<!--			<span class="thumb">-->
<!--				<span class="link img-clip" style="background-image: url('{{itemImageProxy}}')" href="{{productUrl}}">-->
<!--					<img src="{{itemImageProxy}}" />-->
<!--				</span>-->
<!--			</span>-->
<!--        </div>-->
<!--    </div>-->
<!--</script>-->

<script>
    $(function(){
        console.log('riboti');
        $("#fileupload").on("change",function(e){

            console.log('riboti');

            var action = "<?php echo site_url('/admin/pages/uploadimage')?>";
            var ins = document.getElementById('fileupload').files.length;
            var formData = new FormData();
            for(var i=0; i< ins; i++)
            {
                var portfolio_values = document.getElementById('fileupload').files[i];
                formData.append('file[]', portfolio_values);
            }
            $.ajax({
                type:"post",
                url: action,
                data:formData,
                dataType:"json",
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType

                success: function(result){
                    console.log(result);

                },

            });
        });

        //Optional: specify custom height
        window.frameElement.style.height = '500px';




        /*
        USE THIS FUNCTION TO SELECT CUSTOM ASSET WITH CUSTOM VALUE TO RETURN
        An asset can be a file, an image or a page in your own CMS
        */
        function selectAsset(assetValue) {
            //Get selected URL
            console.log(assetValue);
            var inp = parent.top.$('#active-input').val();
            parent.top.$('#' + inp).val(assetValue);

            //Close dialog
            if (window.frameElement.id == 'ifrFileBrowse') parent.top.$("#md-fileselect").data('simplemodal').hide();
            if (window.frameElement.id == 'ifrImageBrowse') parent.top.$("#md-imageselect").data('simplemodal').hide();
        }

        // // Calculate internal height (used for local scroll)
        // // this function is from the old localMode I think?
        // function infsrc_local_hiddenHeight(element) {
        //     var height = 0;
        //     jQuery(element).children().each(function() {
        //         height = height + jQuery(this).outerHeight(false);
        //     });
        //     return height;
        // }
        //
        // jQuery.extend(jQuery.infinitescroll.prototype, {
        //     _nearbottom_local: function infscr_nearbottom_local() {
        //         var opts = this.options, instance = this,
        //             pixelsFromWindowBottomToBottom = infsrc_local_hiddenHeight(opts.binder)
        //                 - jQuery(opts.binder).scrollTop() - jQuery(opts.binder).height();
        //
        //         if (opts.local_pixelsFromNavToBottom == undefined){
        //             opts.local_pixelsFromNavToBottom = infsrc_local_hiddenHeight(opts.binder) +
        //                 jQuery(opts.binder).offset().top - jQuery(opts.navSelector).offset().top;
        //         }
        //         instance._debug('local math:', pixelsFromWindowBottomToBottom,
        //             opts.local_pixelsFromNavToBottom);
        //
        //         return (pixelsFromWindowBottomToBottom - opts.bufferPx < opts.local_pixelsFromNavToBottom);
        //     }
        // });
        //
        // $('.lookbook-canvas-wrapper').height($( window ).height());
        //
        // $('.pane-scrollable').each(function(){
        //     $(this).css('top', ($('.panel-products .nav-tabs').height() + 11 + $(this).parent().find('.tab-toolbar').outerHeight()) + 'px');
        // });
        //
        // $(window).resize(function(){
        //     $('.lookbook-canvas-wrapper').height($( window ).height());
        //     $('.pane-scrollable').each(function(){
        //         $(this).css('top', ($('.panel-products .nav-tabs').height() + 11 + $(this).parent().find('.tab-toolbar').outerHeight()) + 'px');
        //
        //     });
        //
        //     $('.panel-products .dropdown-menu').each(function(){
        //         $(this).css('height', $(this).parents('.tab-pane').find('.pane-scrollable').height() - 30);
        //         $(this).css('width', $(this).parents('.tab-pane').width() - 30);
        //     });
        // });
        //
        //
        // $('.panel-form').submit(function(e){
        //     e.preventDefault();
        // });
        //
        // $('.panel-products .dropdown-menu a').click(function(e){
        //     e.preventDefault();
        //     var tab = $(this).parents('.tab-pane')
        //         , href= $(this).attr('data-url');
        //     tab.find('.product-list').attr('data-url', href);
        //     // loadTab(tab);
        // });

        // function loadTab($tab){
        //     var targetHref = $tab.attr('href')
        //         , productContainer = $('.product-list', $tab)
        //         , productItemContainer = $(' .scroll-content', $tab)
        //         , isDataLoaded = (productContainer.attr('data-loaded') == "1") ? true : false;
        //
        //     $.get(productContainer.attr('data-url'), function(response){
        //         if(response.data && !response.error){
        //             productItemContainer.empty();
        //
        //             var items = response.data.items
        //                 , itemsCount = items.length;
        //             if(itemsCount == 0){
        //                 productItemContainer.html('<p class="ac no-data">Няма намерени продукти</p>');
        //             }
        //             for(var i = 0; i < itemsCount; i++){
        //                 var item = items[i];
        //                 var $append = $(Mustache.render($('#tpl-tiny-product').html(), item));
        //                 productItemContainer.append($append);
        //             }
        //
        //             $(productContainer).attr('data-loaded', 1);
        //             $(productContainer).attr('data-totalcount', response.data.itemCount);
        //             $(productContainer).attr('data-page', response.data.page);
        //             $('.item-tiny').click(function(){
        //                 selectAsset($(this).attr('data-image-proxy'));
        //             });
        //             if(response.data.itemCount > response.data.page){
        //                 productContainer.attr('data-perpage', response.data.limit);
        //                 productContainer.attr('data-nextpage', response.data.limit + response.data.page);
        //                 productItemContainer.append('<div class="nav cb"><a href="#next">a</a></div>');
        //             }
        //         }
        //     }, 'json');
        //
        //
        // }

        // $('.nav-tabs a').on('shown.bs.tab', function (e) {
        //     //e.target // activated tab
        //     //e.relatedTarget // previous tab
        //     $(window).resize();
        //     var target = $(e.target)
        //         , targetHref = target.attr('href')
        //         , targetId = targetHref.replace('#')
        //         , productContainer = $( targetHref + ' .product-list')
        //         , productItemContainer = $( targetHref + ' .scroll-content')
        //         , isDataLoaded = (productContainer.attr('data-loaded') == "1") ? true : false;
        //
        //     if(productContainer.attr('data-loaded') != "1"){
        //         // loadTab($(targetHref));
        //     }
        // });
        // $('.nav-tabs a:first').tab('show');
        // $('.infinite.pane-scrollable').each(function(){
        //     $(this).infinitescroll({
        //         debug: true,
        //         loading: {
        //             finished: function(){},
        //             start: function(obj){
        //                 var $productContainer = $(obj.binder);
        //                 var $productItemContainer = $(obj.binder).find('.scroll-content');
        //
        //                 var page = $productContainer.attr('data-nextpage')
        //                     , total = $productContainer.attr('data-totalcount')
        //                     , url = $productContainer.attr('data-url');
        //
        //                 console.log('Start Infinite');
        //                 console.log('Total Count: ', $productContainer.attr('data-totalcount'));
        //                 console.log('page: ', page);
        //                 if(page && parseInt($productContainer.attr('data-totalcount')) > page){
        //                     console.log('loading page');
        //                     $.get(url + '&page=' + page, function(response){
        //                         console.log(response);
        //                         if(response.data && !response.error){
        //
        //                             var items = response.data.items
        //                                 , itemsCount = items.length;
        //                             for(var i = 0; i < itemsCount; i++){
        //                                 var item = items[i];
        //                                 var $append = $(Mustache.render($('#tpl-tiny-product').html(), item));
        //                                 $productItemContainer.append($append);
        //                             }
        //                             $('.item-tiny').click(function(){
        //                                 selectAsset($(this).attr('data-image-proxy'));
        //                             });
        //                             $productItemContainer.find('.nav').remove();
        //                             if(response.data.itemCount > parseInt(response.data.page)){
        //                                 $productContainer.attr('data-perpage', response.data.limit);
        //                                 $productContainer.attr('data-nextpage', parseInt(response.data.limit) + parseInt(response.data.page));
        //                                 $productItemContainer.append('<div class="nav cb"><a href="#next">a</a></div>');
        //                             }
        //                             obj.state.isDone = false;
        //                             //obj.state.currPage = 2;
        //                             obj.state.isDuringAjax = false;
        //                         }
        //                     }, 'json');
        //                 }
        //                 return true;
        //             }
        //         },
        //         state : {
        //             currPage: $(this).attr('data-page')
        //         },
        //         localMode    : true,
        //         behavior: 'local',
        //         binder: $(this), // used to cache the selector for the element that will be scrolling
        //         nextSelector: ".nav a:first",
        //         navSelector: '.nav',
        //         path: function(index){
        //             console.log(index)
        //             return '?page=' + ((index - 1) * $('#item-result').attr('data-perpage'));
        //         },
        //         dataType: 'html+callback',
        //         appendCallback: true,
        //         //bufferPx: 100,
        //     });
        // });
    });
</script>