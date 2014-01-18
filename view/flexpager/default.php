<link rel="stylesheet" type="text/css" href="<?php echo uri::cdnstaicUri();?>css/flexpaper/flexpaper.css" />
<script type="text/javascript" src="<?php echo uri::cdnstaicUri();?>js/flexpaper/flexpaper.js"></script>
<script type="text/javascript" src="<?php echo uri::cdnstaicUri();?>js/flexpaper/flexpaper_handlers.js"></script>
<div style="position:relative;left:10px;top:10px;">
    <div id="documentViewer" class="flexpaper_viewer" style="width:770px;height:500px"></div>
    <script type="text/javascript">
        $('#documentViewer').FlexPaperViewer(
            { config : {
                jsDirectory:'<?php echo uri::cdnstaicUri();?>',
                SWFFile : '<?php echo uri::docsUri();?>test.swf',
                Scale : 1,
                ZoomTransition : 'easeOut',
                ZoomTime : 0.5,
                ZoomInterval : 0.2,
                FitPageOnLoad : false,
                FitWidthOnLoad : false,
                FullScreenAsMaxWindow : false,
                ProgressiveLoading : false,
                MinZoomSize : 0.2,
                MaxZoomSize : 5,
                SearchMatchAll : false,
                InitViewMode : 'Portrait',
                RenderingOrder : 'flash',
                StartAtPage : '',

                ViewModeToolsVisible : true,
                ZoomToolsVisible : true,
                NavToolsVisible : true,
                CursorToolsVisible : true,
                SearchToolsVisible : true,
                WMode : 'window',
                localeChain: 'en_US'
            }}
        );
    </script>
</div>