<link href="static/video/video-js.css" rel="stylesheet" type="text/css">
<script src="static/video/video.js"></script>
<link href="static/audio/audio.css" rel="stylesheet" type="text/css">
<script src="static/audio/audio.min.js"></script>
<script>
    videojs.options.flash.swf = "static/video/video-js.swf";
    audiojs.events.ready(function() {
        audiojs.createAll();
    });
</script>
<?php echo $pagelist;?>
<?php if($data):?>
    <?php foreach($data as $key=>$item):?>
        <?php if($key%3==0):?>
            <div class="row-fluid">
            <ul class="thumbnails">
        <?php endif;?>
        <li class="span4">
            <div class="thumbnail" style="position: relative;">
                <?php if($item['type']==1):?>
                    <img  src="<?php echo $item['uri'];?>"   hrefsrc="index.php?a=mediadetail&id=<?php echo $item['id'];?>"/>
                <?php elseif($item['type']==3):?>
                <video id="example_video_<?php echo $item['id'];?>" class="video-js vjs-default-skin" controls preload="auto"  poster="http://video-js.zencoder.com/oceans-clip.png" data-setup="{}" style="width:100%;">
                    <source src="<?php echo $item['uri'];?>" type='video/mp4' />
                </video>
                <?php elseif($item['type']==2):?>
                    <audio src="<?php echo $item['uri'];?>" preload="auto" style="width:100%;"></audio>
                <?php endif;?>
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
