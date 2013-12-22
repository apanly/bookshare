<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 12/22/13
 * Time: 5:44 PM
 * To change this template use File | Settings | File Templates.
 */
class innerMedia
{
        public static function Image($uri,$directory){
            $filename=md5($uri);
            $fileroot=UPLOAD_PATH."bookpics".DS;
            if(!file_exists($fileroot)){
                mkdir($fileroot,0705);
            }
            if($directory){
                $fileroot=$fileroot.$directory.DS;
                if(!file_exists($fileroot)){
                    mkdir($fileroot,0705);
                }
            }
            if(!file_exists($fileroot.$filename)){
                $picdata=file_get_contents($uri);
                file_put_contents($fileroot.$filename,$picdata);
            }
            if($directory){
                return IMG_PREFIX."bookpics".DS.$directory.DS.$filename;
            }
            return IMG_PREFIX."bookpics".DS.$filename;
        }

        public static function setvideo($data,$uri,$directory,$mediatype){
            $filename=md5($uri).$mediatype;
            $fileroot=UPLOAD_PATH."bookpics".DS;
            if(!file_exists($fileroot)){
                mkdir($fileroot,0705);
            }
            if($directory){
                $fileroot=$fileroot.$directory.DS;
                if(!file_exists($fileroot)){
                    mkdir($fileroot,0705);
                }
            }
            if(!file_exists($fileroot.$filename)){
                file_put_contents($fileroot.$filename,$data);
                return true;
            }else{
                return false;
            }
        }

        public static function getvideo($uri,$directory,$mediatype){
            $filename=md5($uri).$mediatype;
            if($directory){
                return IMG_PREFIX."bookpics".DS.$directory.DS.$filename;
            }
            return IMG_PREFIX."bookpics".DS.$filename;
        }
}
