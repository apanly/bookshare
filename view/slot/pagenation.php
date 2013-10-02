<?php if($pagecnt):?>
<div class="row-fluid">
    <div class="pagination pagination-large">
        <ul>
            <?php if($page>1):?>
                <li><a title="prev" href="<?php echo $uri;?>&page=<?php echo ($page-1);?>">«</a></li>
            <?php endif;?>
            <?php for($p=1;$p<=$pagecnt;$p++):?>
               <?php if($page==$p):?>
                <li><a href="javascript:void(0);"><?php echo $p;?></a></li>
               <?php else:?>
                    <li><a href="<?php echo $uri;?>&page=<?php echo $p;?>"><?php echo $p;?></a></li>
               <?php endif;?>
            <?php endfor;?>
            <?php if($page<$pagecnt):?>
                <li><a title="next" href="<?php echo $uri;?>&page=<?php echo ($page+1);?>">»</a></li>
            <?php endif;?>
        </ul>
    </div>
</div>
<?php endif;?>