<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 12/22/13
 * Time: 4:15 PM
 * To change this template use File | Settings | File Templates.
 */
class userRelation
{
    private $target=null;
    public function __construct(){
        $this->target=new Mysql();
    }
    public function insert($params){
        return $this->target->insert("user_relation",$params);
    }

    public function findByOpendid($openid){
        $sql="SELECT * FROM user_relation WHERE openid='{$openid}'";
        return $this->target->get_one($sql);
    }
    public function getNotCompleteUser($limit=10){
        $sql="SELECT * FROM user_relation WHERE flag=0 limit {$limit}";
        return $this->target->get_one($sql);
    }

    public function updateUserInfo($params){
        $fakeid=$params['fake_id'];
        unset($params['fake_id']);
        $this->target->update("user_relation",$params," fakeid={$fakeid} ");
    }

    public function updateByOpenid($openid,$fakeid){
        $this->target->update("user_relation",array(
            "fakeid"=>$fakeid
            ),
            " openid='{$openid}' "
        );
    }
}
