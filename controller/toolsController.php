<?php
class toolsController extends Controller
{
    public function __construct(){
        $cookiloginoauth=dcookie::dgetcookie("loginoauth");
        if($cookiloginoauth){
            global $config;
            list($username,$uid)=explode("|",$cookiloginoauth);
            $seckey=dcookie::dgetcookie("seckey");
            $saltkey=dcookie::dgetcookie("saltkey");
            $saltprekey=$config['saltprekey'];
            $saltkey=$saltprekey.$saltkey;
            $tmpseckey=md5(serialize($username.$uid,$saltkey));
            if($seckey==$tmpseckey){
                if($uid && $username){
                    $this->logstatus=1;
                    $this->userinfo=array('uname'=>$username,"uid"=>$uid);
                }
            }else{
                dcookie::dsetcookie("loginoauth",'',-86400);
                dcookie::dsetcookie("seckey",'',-86400);
            }
        }else{
            $this->location("index.php");
        }
    }
    public function defaultAction(){
        $userinfo=$this->userinfo;
        $ordertarget=new order();
        $orderlist=$ordertarget->getOrderListByUid($userinfo['uid']);
        foreach($orderlist as $key=>$item){
            if(mb_strlen($item['name'],"utf-8")>8){
                $item['name']=mb_substr($item['name'],0,8,"utf-8")."...";
            }
            if($item['flag']==1){
                $item['flag']="借阅中<a href='javascript:void(0);' class='rebackbook' data='{$item['id']},{$item['bookid']}'>归还</a>";
            }else if($item['flag']==2){
                $item['flag']="已归还";
            }
            $item['shoulddate']= util::rentbackDate($item['rentData']);
            $orderlist[$key]=$item;
        }
        $this->orderlist=$orderlist;
        return $this->render("default");
    }

    public function rebackbookAction(){
        $bookid=$_POST['bookid'];
        $orderid=$_POST['orderid'];
        $returnval=array("code"=>0,"message"=>"还书失败");
        if($bookid && $orderid){
            $userinfo=$this->userinfo;
            $ordertarget=new order();
            $orderinfo=$ordertarget->getOrderById($orderid);
            if($orderinfo && $orderinfo['uid']==$userinfo['uid']){
                if($orderinfo['flag']==1){
                    $ordertarget->updateOrderStatus($orderid);
                    $booktarget=new library();
                    $booktarget->updateBookFlagById($bookid,0,'',1);
                    $returnval["code"]=1;
                    $returnval["message"]="还书成功,请还给分享者!!";
                }
            }else{
                $returnval['message'].="还书失败,是不是你的书呀";
            }
        }
        return json_encode($returnval);
    }

    public function adminorderAction(){
        $ordertarget=new order();
        $orderlist=$ordertarget->getAllOrderList();
        foreach($orderlist as $key=>$item){
            if(mb_strlen($item['name'],"utf-8")>8){
                $item['name']=mb_substr($item['name'],0,8,"utf-8")."...";
            }
            if($item['flag']==1){
                $item['flag']="借阅中<a href='javascript:void(0);' class='rebackbook' data='{$item['id']},{$item['bookid']}'>归还</a>";
            }else if($item['flag']==2){
                $item['flag']="已归还";
            }
            $item['shoulddate']= util::rentbackDate($item['rentData']);
            $orderlist[$key]=$item;
        }
        $this->orderlist=$orderlist;
        return $this->render("default");
    }
}
