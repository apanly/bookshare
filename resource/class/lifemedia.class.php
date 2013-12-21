<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/21/13
 * Time: 10:53 AM
 */

class lifemedia {
    private $target=null;
    public function __construct(){
        $this->target=new Mysql();
    }
    public function insert($params){
        $this->target->insert("lifemedia",$params);
    }

    public function getlifeList($from,$limit){
        $sql="SELECT * FROM lifemedia ORDER BY id desc  LIMIT {$from},{$limit}";
        return $this->target->get_all($sql);
    }

    public function getlifeCount(){
        $sql="SELECT COUNT(*) AS num  FROM lifemedia ";
        $res=$this->target->get_one($sql);
        if($res){
            return $res['num'];
        }
        return 0;
    }
    public function findById($id){
        $sql="SELECT * FROM lifemedia where id={$id}";
        $result=$this->target->get_one($sql);
        return $result;
    }
} 