<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 10/8/13
 * Time: 3:33 PM
 * To change this template use File | Settings | File Templates.
 */
class order
{

    private $target=null;
    public function __construct(){
        $this->target=new Mysql();
    }
    public function insertBookOrder($fields){
        $this->target->insert("orderlist",$fields);
        return $this->target->insert_id();
    }
    public function getOrderByBookId($bookid,$flag=1,$uid=''){
        $bookid=mysql_real_escape_string($bookid);
        if($flag===0){
            $sql="SELECT uid,uname,rentData,flag FROM orderlist where bookid={$bookid} order by flag asc limit 5";
            return $this->target->get_all($sql);
        }else{
            $sql="SELECT uid FROM orderlist where bookid={$bookid} and uid={$uid} and flag=1";
            $result=$this->target->get_one($sql);
            return $result;
        }

    }



    public function getOrderListByUid($uid){
        $sql="SELECT a.id,a.rentData,b.name,a.flag,a.bookid FROM orderlist as a ,book as b where a.bookid = b.id and a.uid={$uid} order by a.id desc";
        $result=$this->target->get_all($sql);
        return $result;
    }

    public function getAllOrderList(){
        $sql="SELECT a.id,a.uname,a.rentData,b.name,a.flag,a.bookid FROM orderlist as a ,book as b where a.bookid = b.id  order by a.id desc";
        $result=$this->target->get_all($sql);
        return $result;
    }

    public function getOrderById($id){
        $id=mysql_real_escape_string($id);
        $sql="SELECT uid,flag FROM orderlist where id={$id}";
        $result=$this->target->get_one($sql);
        return $result;
    }

    public function updateOrderStatus($id){
        return $this->target->update("orderlist",array("flag"=>2,"backData"=>date("Y-m-d H:i:s"))," id={$id}");
    }
}
