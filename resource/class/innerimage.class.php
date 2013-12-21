<?php
class innerimage
{
    public static function getImage($uri,$directory=''){
        //return $uri;
        $filename=md5($uri);
        $fileroot=UPLOAD_PATH."bookpics".DS;
        if(!file_exists($fileroot)){
            mkdir($fileroot,0700);
        }
        if($directory){
            $fileroot=$fileroot.$directory.DS;
            if(!file_exists($fileroot)){
                mkdir($fileroot,0700);
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
}
