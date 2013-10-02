<?php echo $pagelist;?>
<?php if($data):?>
        <?php foreach($data as $key=>$item):?>
        <?php if($key%3==0):?>
            <div class="row-fluid">
                <ul class="thumbnails">
        <?php endif;?>
                <li class="span4">
                    <div class="thumbnail">
                        <img title="<?php echo $item['title'];?>" src="<?php echo $item['image_url'];?>"  style="width: 250px; height: 300px;"/>
                            <div class="caption">
                            <h4><?php echo $item['title'];?></h4>
                            <p><?php echo $item['creator'];?></p>
                            <p><a  href="index.php?a=bookdetail&id=<?php echo $item['id'];?>">View Detail</a></p>
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
