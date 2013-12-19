<?php echo $pagelist;?>
<?php if($data):?>
        <?php foreach($data as $key=>$item):?>
        <?php if($key%3==0):?>
            <div class="row-fluid">
                <ul class="thumbnails">
        <?php endif;?>
                <li class="span4">
                    <div class="thumbnail" style="position: relative;">
                        <img title="<?php echo $item['title'];?>" src="<?php echo $item['image_url'];?>"  style="width: 250px; height: 300px;" hrefsrc="index.php?a=bookdetail&id=<?php echo $item['id'];?>"/>
                        <?php if(!$item['booknumber']):?>
                            <img src="static/img/rent.png" class="rent" hrefsrc="index.php?a=bookdetail&id=<?php echo $item['id'];?>"/>
                        <?php endif;?>
                            <div class="caption">
                            <h4><?php echo $item['title'];?></h4>
                            <p><?php echo $item['creator'];?></p>
                            <p>
                                <a href="index.php?a=bookdetail&id=<?php echo $item['id'];?>">View Detail</a>
                                <?php if($logstatus && $item['booknumber']):?>
                                    <button class="btn btn-primary borrowbook" style="float: right;" data="<?php echo $item['id'];?>">借阅</button>
                                <?php endif;?>
                            </p>
                        </div>
                    </div>
                </li>
        <?php if($key%3==2):?>
            </ul>
            </div>
        <?php elseif((($pagercnt-1)%3!=2) && ($key==($pagercnt-1))):?>
            </ul>
            </div>
        <?php endif;?>
        <?php endforeach;?>
<?php endif;?>
<?php echo $pagelist;?>
