<?php echo $pagelist;?>
<?php if($data):?>
    <?php foreach($data as $key=>$item):?>
        <?php if($key%3==0):?>
            <div class="row-fluid">
            <ul class="thumbnails">
        <?php endif;?>
        <li class="span4">
            <div class="thumbnail" style="position: relative;">
                <img  src="<?php echo $item['uri'];?>"   hrefsrc="index.php?a=mediadetail&id=<?php echo $item['id'];?>"/>
                <div class="caption">
                    <p style="text-align: center;"><?php echo $item['desc'];?></p>
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
