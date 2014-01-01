<script src="static/js/detail.js"></script>
<script src="static/js/ctrenter.js"></script>
<link href="static/css/detail.css" rel="stylesheet">
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
    <div class="span4" style="position: relative;">
        <img src="<?php echo $book['image_url'];?>" class="bookimg"/>
        <?php if($book['rentor']):?>
            <img src="static/img/rent.png" class="rent"/>
        <?php endif;?>
            <img src="<?php echo $book['qrcodeimage_url'];?>" style="position: absolute;bottom:5px;left:30px;"/>
    </div>
    <div class="span8">
        <h3><?php echo $book['name'];?>
            <?php if($logstatus && $book['booknumber']):?>
                <button class="btn btn-primary btn-large borrowbook" style="float: right;" data="<?php echo $book['id'];?>">借阅</button>
            <?php endif;?>
        </h3>
        <h4>作者:<?php echo $book['creator'];?><input type="hidden" id="bookdetail" value="<?php echo $getbookdetail;?>"></h4>
        <h4>库存:<?php echo $book['booknumber'];?></h4>
        <h4>装订:<?php echo $book['binding']."/".$book['pages']."页";?></h4>
        <h4>出版社:<?php echo $book['publisher']."(".$book['pdate'].")";?></h4>
        <h4>ISBN:<?php echo $book['isbn'];?></h4>
        <h4>Tag:<?php echo $book['booktag'];?></h4>
        <h4>简介:<?php echo $book['booksummary'];?></h4>
        <?php if($orderlist):?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>借阅人</th>
                <th>借阅时间</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($orderlist as $item):?>
            <tr>
                <td><a target="_blank" href="index.php?uid=<?php echo $item['uid'];?>"><?php echo $item['uname'];?></a></td>
                <td><?php echo $item['rentData'];?></td>
                <td>
                    <?php if($item['flag']==1):?>
                        借阅中
                    <?php elseif($item['flag']==2):?>
                        已归还
                    <?php endif;?>
                </td>
            </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;?>
    </div>
</div>
<div class="row-fluid">
    <ul class="nav nav-tabs">
        <li class="active"><a href="javascript:void(0);">评论</a></li>
        <li><a href="javascript:void(0);">点评</a></li>
    </ul>
</div>
<div class="replylist row-fluid">

</div>
<div class="reply row-fluid" style="display: none;">
    <div class="alert alert-success span12">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>发布成功</strong>
    </div>
    <div class="span12">
        请输入你对本书的点评或者笔记
    </div>
    <div class="span12">
        <textarea  style="height:85px;width:100%;" placeholder="请输入你的点评或者读书笔记" id="replycontent"></textarea>
    </div>
    <div class="span8">
        <a class="btn btn-link" href="javascript:ops.tabChange(0);void(0);">查看点评</a>
    </div>
    <div class="span4">
        <button type="button" class="btn btn-primary" >发布</button>(Ctr+Enter)
    </div>
</div>