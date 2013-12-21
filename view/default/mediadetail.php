<ul class="breadcrumb">
    <li><a href="index.php">ShareBook</a> <span class="divider">/</span></li>
    <li><a href="index.php?a=media">Media</a> <span class="divider">/</span></li>
    <li class="active"><?php echo $detailinfo['title'];?></li>
</ul>
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
