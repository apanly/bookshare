<?php
class innerimage
{
    public static function getImage($uri){
        //return $uri;
        $filename=md5($uri);
        $fileroot=UPLOAD_PATH."bookpics".DS;
        if(!file_exists($fileroot.$filename)){
            $picdata=file_get_contents($uri);
            if(!file_exists($fileroot)){
                mkdir($fileroot,0700);
            }
            file_put_contents($fileroot.$filename,$picdata);
        }
        return IMG_PREFIX."bookpics".DS.$filename;
    }
}
