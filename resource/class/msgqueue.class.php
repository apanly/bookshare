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

    public function getqueueList($limit=100){
        $sql="SELECT * FROM msgqueue where queueflag=0 ORDER BY msgid asc  LIMIT {$limit}";
        return $this->target->get_all($sql);
    }

    public function update($fields,$msgid){
        $this->target->update("msgqueue",$fields," msgid={$msgid}");
    }
}
