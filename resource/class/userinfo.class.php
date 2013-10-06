<?php
class userinfo
{
    private $target=null;
    public function __construct(){
        $this->target=new Mysql();
    }
    public function insertuser($fields){
        $this->target->insert("userinfo",$fields);
        return $this->target->insert_id();
    }
    public function getUserByUsername($username){
        $username=mysql_real_escape_string($username);
        $sql="SELECT * FROM userinfo where username='{$username}'";
        $result=$this->target->get_one($sql);
        return $result;
    }

    public function checkLogin($username,$pwd){
        $username=mysql_real_escape_string($username);
        $pwd=md5(serialize($pwd));
        $pwd=mysql_real_escape_string($pwd);
        $sql="SELECT * FROM userinfo where username='{$username}' and pwd='{$pwd}'";
        $result=$this->target->get_one($sql);
        return $result;
    }
}
