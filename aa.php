<?php
date_default_timezone_set('Asia/Shanghai');
if(count($argv)==3){
    $_GET['c']=$argv[1]?$argv[1]:"wxcrontab";
    $_GET['a']=$argv[2]?$argv[2]:"default";
}
include("./sdk/bootstart.php");
?>