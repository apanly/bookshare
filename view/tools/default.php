<div class="row-fluid">
    <?php echo Slot::includeSlot("leftbar",array("userinfo"=>$userinfo));?>
    <div class="span9">
        <?php if($orderlist):?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>OrderId</th>
                <th>书籍名称</th>
                <th>借阅日期</th>
                <th>应归还日期</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($orderlist as $item):?>
                <tr>
                    <td><?php echo $item['id'];?></td>
                    <td><a href="index.php?a=bookdetail&id=<?php echo $item['bookid'];?>"><?php echo $item['name'];?></a></td>
                    <td><?php echo $item['rentData'];?></td>
                    <td><?php echo $item['shoulddate'];?></td>
                    <td><?php echo $item['flag'];?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;?>
    </div><!--/span-->
</div>