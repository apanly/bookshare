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
    public static function cdnstaicUri(){
        return "http://cdnstatic.".self::getBaseDomain()."/";
    }
    public static function docsUri(){
        return "http://docs.".self::getBaseDomain()."/";
    }
    protected  static function getBaseDomain(){
        $domain=$_SERVER['HTTP_HOST'];
        $strdomain=explode(".",$domain);
        if(count($strdomain)>2){
            unset($strdomain[0]);
        }
        return implode(".",$strdomain);
    }

} 