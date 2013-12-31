<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/31/13
 * Time: 9:24 AM
 */

class uri {
    public static function englishComUri(){
        return "http://www.".self::getBaseDomain();
    }
    public static function loginUri(){
        return "http://oauth.".self::getBaseDomain()."/?from=book";
    }
    public static function logoutUri(){
        return "http://oauth.".self::getBaseDomain()."/logout?from=book";
    }
    public static function homeinterUri(){
        return "http://blog.".self::getBaseDomain();
    }
    public static function itechUri(){
        return "http://tech.".self::getBaseDomain();
    }

    protected  static function getBaseDomain(){
        $domain=$_SERVER['HTTP_HOST'];
        $strdomain=explode(".",$domain);
        unset($strdomain[0]);
        return implode(".",$strdomain);
    }

} 