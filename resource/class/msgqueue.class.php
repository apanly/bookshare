<?php
class msgqueue
{
    private $target=null;
    public function __construct(){
        $this->target=new Mysql();
    }
    public function insert($params){
        return $this->target->insert("msgqueue",$params);
    }
}
