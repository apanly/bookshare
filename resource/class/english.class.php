<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 12/18/13
 * Time: 10:50 PM
 * To change this template use File | Settings | File Templates.
 */
class english
{
    private $target=null;
    public function __construct(){
        $this->target=new Mysql(1);
    }
    public function getList($pageSize=1){
        $sql="SELECT * FROM tinyenglish  ORDER BY id desc  LIMIT {$pageSize}";
        return $this->target->get_all($sql);
    }

    public function getReadList($pageSize=3){
        $sql="SELECT * FROM  articles  ORDER BY id desc  LIMIT {$pageSize}";
        return $this->target->get_all($sql);
    }
}
