<?php if($data):?>
    <?php foreach($data as $item):?>
        <div class="row-fluid" style="border-top: 1px solid #DDDDDD;min-height: 50px;">
            <div class="span1">
                <!--Sidebar content-->
            </div>
            <div class="span10" style="padding-top: 5px;">
                    <?php echo $item['content'];?><br/><br/>
                    <?php echo $item['idate'];?>
            </div>
        </div>
    <?php endforeach;?>
<?php else:?>
    没有评论,立即<a class="btn btn-link" href="javascript:ops.tabChange(1);void(0);">点评</a>去
<?php endif;?>