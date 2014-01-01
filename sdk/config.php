<?php
$config = array();
$config['global'] = array(
    "sitename" => "以书会友--你有一本书,我有一本书,我们就有两本书",
    "description"=>"分享书籍,助人为乐,一起分享快乐学习时光",
    "keywords"=>"分享书籍,sharebook,以书会友"
);
$config['mvc']['default'] = array("action" => "default", "layout" => "default", "controller" => "default");
$config['secury'] = array(
    "cookiepre" => "vincent_" . substr(md5("/|"), 0, 4) . "_",
    "authkey" => "sdfqrewr",
);
define("DBPREFIX", "book_");
$config['db'][0] = array(
    "hostname" => "localhost", //服务器地址
    "username" => "root", //数据库用户名
    "password" => "root", //数据库密码
    "database" => "library", //数据库名称
    "charset" => "utf8", //数据库编码
    "pconnect" => 0, //开启持久连接
    "log" => 1, //开启日志
    "logfilepath" => ROOT_PATH."resource/cache/dblog.txt" //开启日志
);
$config['db'][1] = array(
    "hostname" => "localhost", //服务器地址
    "username" => "root", //数据库用户名
    "password" => "root", //数据库密码
    "database" => "appenglish", //数据库名称
    "charset" => "utf8", //数据库编码
    "pconnect" => 0, //开启持久连接
    "log" => 1, //开启日志
    "logfilepath" => ROOT_PATH."resource/cache/dblog.txt" //开启日志
);
$config['saltprekey']="vincentguo";
$config['domain']=".yyabc.test";
