<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 2/21/13
 * Time: 11:27 PM
 * To change this template use File | Settings | File Templates.
 */
if(!defined('IN_WEB')) {
    exit('Access Denied');
}
class dcookie
{
    public static   function dsetcookie($var, $value = '', $life = 0, $httponly = false) {
        global $config;
        if($value == '' || $life < 0) {
            $value = '';
            $life = -1;
        }
        $life = $life > 0 ? time() + $life : ($life < 0 ? time() - 31536000 : 0);
        $path = $httponly && PHP_VERSION < '5.2.0' ? '; HttpOnly' :"/";
        $secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
        $domain=$config['domain'];
        if(PHP_VERSION < '5.2.0') {
            setcookie($var, $value, $life, $path, $domain, $secure);
        } else {
            setcookie($var, $value, $life, $path, $domain, $secure, $httponly);
        }
    }

    public static function dgetcookie($key) {
        global $_G;
        $cookiepre=$_G['config']['cookiepre'];
        $key=$cookiepre.$key;
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : '';
    }
}
