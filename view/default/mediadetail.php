<ul class="breadcrumb">
    <li><a href="index.php">ShareBook</a> <span class="divider">/</span></li>
    <li><a href="index.php?a=media">Media</a> <span class="divider">/</span></li>
    <li class="active"><?php echo $detailinfo['title'];?></li>
</ul>
<div class="row-fluid">
    <div class="span12">
        <!-- JiaThis Button BEGIN -->
        <div class="jiathis_style">
            <span class="jiathis_txt">分享到：</span>
            <a class="jiathis_button_qzone">QQ空间</a>
            <a class="jiathis_button_weixin">微信</a>
            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
            <a class="jiathis_counter_style"></a>
        </div>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
        <!-- JiaThis Button END -->
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="thumbnail">
            <img  src="<?php echo $detailinfo['uri'];?>" />
            <div class="caption">
                <p style="text-align: center;"><?php echo $detailinfo['desc'];?></p>
            </div>
        </div>
    </div>
</div>
