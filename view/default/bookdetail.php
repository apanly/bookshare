<script src="static/js/detail.js"></script>
<div class="row-fluid">
    <ul class="pager">
        <?php if($bookprev):?>
            <li><a href="index.php?a=bookdetail&id=<?php echo $bookprev['id'];?>">上一本:<?php echo $bookprev['title'];?></a></li>
        <?php endif;?>
        <?php if($booknext):?>
            <li><a href="index.php?a=bookdetail&id=<?php echo $booknext['id'];?>">下一本:<?php echo $booknext['title'];?></a></li>
        <?php endif;?>
    </ul>
</div>
<div class="row-fluid">
    <div class="span4">
        <img src="<?php echo $book['image_url'];?>"/>
    </div>
    <div class="span8">
        <h3><?php echo $book['name'];?></h3>
        <h4>作者:<?php echo $book['creator'];?></h4>
        <h4>装订:<?php echo $book['binding']."/".$book['pages']."页";?></h4>
        <h4>出版社:<?php echo $book['publisher']."(".$book['pdate'].")";?></h4>
    </div>
</div>
<div class="row-fluid">
    <ul class="pager">
        <?php if($bookprev):?>
        <li><a href="index.php?a=bookdetail&id=<?php echo $bookprev['id'];?>">上一本:<?php echo $bookprev['title'];?></a></li>
        <?php endif;?>
        <?php if($booknext):?>
        <li><a href="index.php?a=bookdetail&id=<?php echo $booknext['id'];?>">下一本:<?php echo $booknext['title'];?></a></li>
        <?php endif;?>
    </ul>
</div>