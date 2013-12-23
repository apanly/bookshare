<link href="static/css/mediapic.css" rel="stylesheet">
<div class="row-fluid">
    <ul class="nav nav-tabs">
        <li  class="active"><a href="index.php?a=media&type=1">图片</a></li>
        <li><a href="index.php?a=media&type=2">音频</a></li>
        <li><a href="index.php?a=media&type=3">视频</a></li>
    </ul>
</div>
<?php echo $pagelist;?>
<?php if($data):?>
    <div class="row-fluid" id="main-container">
            <ul  id="picfluid">
                <?php foreach($data as $key=>$item):?>
                    <li class="span4">
                        <img src="<?php echo $item['uri'];?>" hrefsrc="index.php?a=mediadetail&id=<?php echo $item['id'];?>">
                    </li>
                <?php endforeach;?>
            </ul>
    </div>
<?php endif;?>
<?php echo $pagelist;?>
<script type="text/javascript" src="static/js/jquery.wookmark.js"></script>
<script type="text/javascript">
    var handler = null;
    // Prepare layout options.
    var options = {
        autoResize: true, // This will auto-update the layout when the browser window is resized.
        container: $('#main-container'), // Optional, used for some extra CSS styling
        offset: 2, // Optional, the distance between grid items
    };
    /**
     * When scrolled all the way to the bottom, add more tiles.
     */
    function onScroll(event) {
        // Check if we're within 100 pixels of the bottom edge of the broser window.
        var winHeight = window.innerHeight ? window.innerHeight : $(window).height(); // iphone fix
        var closeToBottom = ($(window).scrollTop() + winHeight > $(document).height() - 100);
        if(closeToBottom) {
            // Get the first then items from the grid, clone them, and add them to the bottom of the grid.
            var items = $('#tiles li'),
            firstTen = items.slice(0, 10);
            $('#picfluid').append(firstTen.clone());
            // Create a new layout handler.
            handler = $('#tiles li');
            handler.wookmark(options);
        }
    };
    $(document).ready(new function() {
        // Capture scroll event.
        $(document).bind('scroll', onScroll);
        // Call the layout function.
        handler = $('#picfluid li');
        handler.wookmark(options);
    });
</script>
