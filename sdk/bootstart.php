<?php
header("Content-type: text/html; charset=utf-8");
//error_reporting(E_ALL);
//ini_set( 'display_errors', 'On' );
define("DS",DIRECTORY_SEPARATOR);
define("IN_WEB", "1");
define("ROOT_PATH", realpath(dirname(__FILE__) . "/../") . DS);
define("UPLOAD_PATH", realpath(dirname(__FILE__) . "/../") . DS."static".DS);
$base_uri=DIRECTORY_SEPARATOR=='/'?dirname($_SERVER["SCRIPT_NAME"]):str_replace('\\','/',dirname($_SERVER["SCRIPT_NAME"]));
$domain = $_SERVER['HTTP_HOST'];
if (!preg_match("/^http/", $domain)) {
    define("WEB_DOMAIN", "http://" . $domain.$base_uri);
} else {
    define("WEB_DOMAIN", $domain.$base_uri);
}
define("IMG_PREFIX",WEB_DOMAIN."/static/");
define("SLOT_PATH", ROOT_PATH . "view".DS."slot".DS);
define("AUTOPATH", ROOT_PATH . "resource".DS."cache".DS."autoload.php");
define('LOG4PHP_DIR',ROOT_PATH."../log4php".DS);
include(ROOT_PATH . "sdk".DS."function.php");
include(ROOT_PATH . "sdk".DS."config.php");
include(ROOT_PATH . "etc".DS."config.php");
include(ROOT_PATH . "etc".DS."const.php");
$_GET = util::dstripslashes($_GET);
$_POST = util::dstripslashes($_POST);
$_COOKIE = util::dstripslashes($_COOKIE);
$filepath = $_SERVER['SCRIPT_FILENAME'];
if (strpos($filepath, ".php")) {
    $beginpos = strrpos($filepath, "/");
    $endpos = strrpos($filepath, ".php");
    $tmpindex = substr($filepath, $beginpos + 1, $endpos - $beginpos - 1);
    unset($filepath);
    unset($beginpos);
    unset($endpos);
}
try{
    Dispatcher::getInstance()->dispatch($config['mvc'][$tmpindex] ? $config['mvc'][$tmpindex] : $config['mvc']['default']);
}catch(Exception $e){
    throw new Exception($e->getMessage());
}