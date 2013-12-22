<?php
class innerimage
{
    public static function getImage($uri,$directory=''){
        //return $uri;
        return innerMedia::Image($uri,$directory);
    }
}
