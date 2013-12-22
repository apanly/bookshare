<?php
class defaultController extends Controller
{
    public function __construct(){
        $uid=$_COOKIE['uid'];
        $username=$_COOKIE['username'];
        if($uid && $username){
            $this->logstatus=1;
            $this->userinfo=array('uname'=>$username,"uid"=>$uid);
        }
    }
    public function defaultAction(){
        $pageSize=12;
        $page=$_GET['page']?(int)($_GET['page']):1;
        if($page<=0){
            $page=1;
        }
        $bookname=$_GET['bookname']?strtolower($_GET['bookname']):'';
        $pagefrom=($page-1)*$pageSize;
        $booktarget=new library();
        $bookinfo=$booktarget->getList($pagefrom,$pageSize,$bookname);
        $bookcnt=$booktarget->getBookCount($bookname);
        $pagecnt=ceil($bookcnt/$pageSize);
        $pageuri="index.php?";
        if($bookname){
            $pageuri="index.php?bookname={$bookname}";
        }
        $this->pagelist=Slot::includeSlot("pagenation",array("uri"=>$pageuri,'page'=>$page,'pagecnt'=>$pagecnt));
        foreach($bookinfo as $key=>$item){
            if(mb_strlen($item['title'],"utf-8")>15){
                $item['title']=mb_substr($item['title'],0,15,"utf-8")."...";
            }
            $item['image_url']=innerimage::getImage($item['image_url']);
            $tmpcreator=explode("(",$item['creator']);
            $item['creator']=$tmpcreator[0];
            $bookinfo[$key]=$item;
        }
        $this->data=$bookinfo;
        $this->pagercnt=count($bookinfo);
        $this->atype="home";
        return $this->render("default");
    }

    public function bookdetailAction(){
        $id=$_GET['id']?(int)$_GET['id']:1;
        if(!preg_match("/^[1-9]\d*$/",$id)){
            $id=1;
        }
        $booktarget=new library();
        $bookinfo=$booktarget->findById($id);
        if(empty($bookinfo)){
            $this->location("index.php");exit();
        }
        $bookprev=$booktarget->getPrevById($id);
        $booknext=$booktarget->getNextById($id);
        if(!$bookinfo['name']){
            $bookinfo['name']=$bookinfo['title'];
        }
        $bookinfo['image_url']=innerimage::getImage($bookinfo['image_url']);
        $bookinfo['qrcodeimage_url']=innerimage::getImage(util::generateQRfromGoogle(WEB_DOMAIN."/index.php?a=bookdetail&id={$id}&type=qr",120));
        $ordertarget=new order();
        $orderlist=$ordertarget->getOrderByBookId($id,0);
        if($orderlist){
            foreach($orderlist as $key=>$item){
                 $orderlist[$key]['uname']=$this->half_replace($item['uname']);
            }
        }
        $this->orderlist=$orderlist;
        $this->book=$bookinfo;
        if($bookinfo['booksummary'] && $bookinfo['booktag'] && $bookinfo['creator'] && $bookinfo['pages'] && $bookinfo['publisher'] && $bookinfo['pdate']){
            $this->getbookdetail=1;
        }else{
            $this->getbookdetail=0;
        }
        $this->bookprev=$bookprev;
        $this->booknext=$booknext;
        $this->atype="home";
        return $this->render("default");
    }
    public function mediaAction(){
        $pageSize=12;
        $page=$_GET['page']?(int)($_GET['page']):1;
        if($page<=0){
            $page=1;
        }
        $pagefrom=($page-1)*$pageSize;
        $lifetarget=new lifemedia();
        $lifeinfo=$lifetarget->getlifeList($pagefrom,$pageSize);
        $lifecnt=$lifetarget->getlifeCount();
        $pagecnt=ceil($lifecnt/$pageSize);
        $pageuri="index.php?a=media";
        $this->pagelist=Slot::includeSlot("pagenation",array("uri"=>$pageuri,'page'=>$page,'pagecnt'=>$pagecnt));
        foreach($lifeinfo as $key=>$item){
            $tmpuri=$item['content'];
            $tmpdirectory=date("Y-m-d",strtotime($item['idate']));
            if($item['type']==1){
                $lifeinfo[$key]['uri']=innerimage::getImage($tmpuri,$tmpdirectory);
            }else{
                $tmpmediatype=".mp4";
                if($item['type']==2){
                    $tmpmediatype=".mp3";
                }
                $lifeinfo[$key]['uri']=innerMedia::getvideo($tmpuri,$tmpdirectory,$tmpmediatype);
            }
            $lifeinfo[$key]['desc']="于".$item['idate']."在微信分享";
        }
        $this->data=$lifeinfo;
        $this->pagercnt=count($lifeinfo);
        $this->atype="Media";
        return $this->render("default");
    }
    public function mediadetailAction(){
        $id=$_GET['id']?(int)$_GET['id']:1;
        if(!preg_match("/^[1-9]\d*$/",$id)){
            $id=1;
        }
        $lifetarget=new lifemedia();
        $lifeinfo=$lifetarget->findById($id);
        if(empty($lifeinfo)){
            $this->location("index.php?a=mediadetail");exit();
        }
        if($lifeinfo['type']==1){
            $lifeinfo['uri']=innerimage::getImage($lifeinfo['content'],date("Y-m-d",strtotime($lifeinfo['idate'])));
            $lifeinfo['desc']="于".$lifeinfo['idate']."在微信分享";
            $lifeinfo['title']="图片分享";
        }
        $this->detailinfo=$lifeinfo;
        $this->atype="Media";
        return $this->render("default");
    }
    public function downloadsAction(){
        $this->atype="about";
        $downapk0=WEB_DOMAIN."/static/download/ShareBook.apk";
        $downapk1="https://zxing.googlecode.com/files/BarcodeScanner4.5.apk";
        $this->downapks=array($downapk0,$downapk1);
        $downapk0qrcode=util::generateQRfromGoogle($downapk0);
        $downapk1qrcode=util::generateQRfromGoogle($downapk1);
        $this->downapksqrcode=array(innerimage::getImage($downapk0qrcode),innerimage::getImage($downapk1qrcode));
        return $this->render("default");
    }

    public function viewAction(){
        $id=$_POST['id'];
        if(preg_match("/^[1-9]\d*$/",$id)){
            $target=new library();
            $target->updateBookById($id);
        }
    }

    public function aboutAction(){
        $this->atype="about";
        return $this->render("default");
    }
    public function projectsAction(){
        $this->atype="projects";
        $prouris=array(
            "https://github.com/apanly/piRobot",
            "https://github.com/apanly/piInfrated",
            "https://github.com/apanly/javaproofread",
            "https://github.com/apanly/RemoterUI",
            "https://github.com/apanly/pccontrolerserver",
            "https://github.com/apanly/pccontrollerclinet"
        );
        $prourisqrcode=array();
        foreach($prouris as $uri){
            $prourisqrcode[]=innerimage::getImage(util::generateQRfromGoogle($uri));
        }
        $this->prouris=$prouris;
        $this->prourisqrcode=$prourisqrcode;
        return $this->render("default");
    }
    public function loginAction(){
        if($this->logstatus==1){
            $this->location("index.php");
        }
        return $this->render("default");
    }
    public function logOutAction(){
        $this->clearUserStatus();
        $this->logstatus=0;
        $this->location("index.php");
    }
    public function doregAction(){
        $returnval=array("code"=>0,"message"=>"fail");
        $username=trim($_POST['username']);
        $pwd=trim($_POST['password']);
        $roles=trim($_POST['status']);
        if($username && $pwd && $roles){
            $usertarget=new userinfo();
            $res=$usertarget->getUserByUsername($username);
            if(!$res){
                $fields=array(
                    "username"=>$username,
                    "pwd"=>md5(serialize($pwd)),
                    "roles"=>$roles
                );
                $uid=$usertarget->insertuser($fields);
                $fields['id']=$uid;
                $res=$fields;
                $returnval['code']=1;
                $returnval['message']=$res;
                $this->setLoginStatus($uid,$username);
            }else{
                $returnval['message']="用户名已经被注册了!!";
            }

        }
        return json_encode($returnval);exit();
    }

    public function dologinAction(){
        $returnval=array("code"=>0,"message"=>"fail");
        $username=trim($_POST['username']);
        $pwd=trim($_POST['password']);
        if($username && $pwd){
            $usertarget=new userinfo();
            $res=$usertarget->checkLogin($username,$pwd);
            if($res){
                $returnval['code']=1;
                $returnval['message']=$res;
                $this->setLoginStatus($res['id'],$res['username']);
            }
        }
        return json_encode($returnval);exit();
    }

    public function borrowBookAction(){
        $userinfo=$this->userinfo;
        $bookid=$_POST['bookid'];
        $returnval=array("code"=>0,"message"=>"借阅失败");
        if(!$userinfo){
            $returnval['message']="请先登陆";
        }else if(preg_match("/^[1-9]\d*$/",$bookid)){
            $booktarget=new library();
            $bookinfo=$booktarget->findById($bookid);
            if($bookinfo['booknumber']>=1){
                $ordertarget=new order();
                $res=$ordertarget->getOrderByBookId($bookid,1,$userinfo['uid']);
                if(!$res){
                    $fields=array(
                        "uid"=>$userinfo['uid'],
                        "uname"=>$userinfo['uname'],
                        "bookid"=>$bookid,
                        "flag"=>1,
                        "rentData"=>date("Y-m-d H:i:s")
                    );
                    $orderid=$ordertarget->insertBookOrder($fields);
                    if($orderid){
                        $librarytarget=new library();
                        $librarytarget->updateBookFlagById($bookid,1,$orderid,-1);
                        $returnval["code"]=1;
                        $returnval["message"]="借阅成功,请联系分享者!!";
                    }
                }else{
                    $returnval["message"]="借阅失败,同一本书只能借阅一本!!";
                }
            }else{
                $returnval["message"]="借阅失败,库存不够!!";
            }
        }
        return json_encode($returnval);
    }
    private function setLoginStatus($id,$username){
        setcookie("uid",$id);
        setcookie("username",$username);
    }

    private function clearUserStatus(){
        setcookie("uid","");
        setcookie("username","");
    }
    /**
     * 没有获取价格的地方,目前看来还不需要价格，没什么用
     */
    public function scanAction()
    {
        $returnval = array();
        $code = $_REQUEST['code'];
        $type = $_REQUEST['type'];
        $uid=$_REQUEST['uid'];
        if ($code && $uid>0) {
            $booktarget = new library();
            $bookinfo = $booktarget->findByISBN($code);
            if (empty($bookinfo)) {
                        $data=$this->doubanApi($code,$type);
                        $data['uid']=$uid;
                        $booktarget->insertBook($data);
                        $returnval = $data;
            } else {
                if(empty($bookinfo['name'])){
                    $data=$this->doubanApi($code,$type);
                    unset($data['isbn']);
                    $booktarget->updateBook($data,$code,$uid);
                    $returnval = $data;
                }else{
                    $returnval = $bookinfo;
                }

            }
        }
        $returnval['name']=$returnval['title'];
        return json_encode($returnval);
    }


    private function doubanApi($isbn,$type='EAN_13'){
        $returnVal=array();
        $returnVal['isbn']=$isbn;
        $returnVal['bartype']=$type;
        $returnVal['name']='';
        $returnVal['title']='';
        $returnVal['booksummary']="";
        $returnVal['booktag']="";
        $returnVal['creator']="";
        $returnVal['binding']='';
        $returnVal['pages']="";
        $returnVal['publisher']="";
        $returnVal['pdate']="";
        $returnVal['image_url']='';
        $returnVal['lrdate']=date("Y-m-d");
        $uri="https://api.douban.com/v2/book/isbn/:{$isbn}";
        $httptarget = new Httplib();
        $response = $httptarget->get($uri);
        $data=$response['body'];
        $data=json_decode($data,true);
        if($data){
            if(!isset($data['code'])){
                $returnVal['name']=$data['subtitle'];
                $returnVal['title']=$data['title'];
                $tags=$data['tags'];
                foreach($tags as $item){
                    $returnVal['booktag'][]=$item['name'];
                }
                $returnVal['booktag']=implode(",",$returnVal['booktag']);
                $returnVal['booksummary']=$data['summary'];
                if(count($data['author'])==1){
                    $returnVal['creator']=implode("~",$data['author']);
                }else{
                    $returnVal['creator']=$data['author'];
                }
                $returnVal['binding']=$data['binding'];
                $returnVal['pages']=$data['pages'];
                $returnVal['publisher']=$data['publisher'];
                $returnVal['pdate']=$data['pubdate'];
                $returnVal['image_url']=$data['images']['large'];
            }
        }
        return $returnVal;
    }
    /**
     * http://developers.douban.com/wiki/?title=book_v2#get_isbn_book
     * $uri="https://api.douban.com/v2/book/isbn/:9787111213826";
    $httptarget = new Httplib();
    $response = $httptarget->get($uri);
    $data=$response['body'];
    $data=json_decode($data,true);
    var_dump($data);
     */
    public function testAction(){
        $res=$this->doubanApi("9787508615158");
        var_dump($res);
    }

    private function half_replace($str){
        $c = strlen($str)/2;
        return preg_replace('|(?<=.{'.(ceil($c/2)).'})(.{'.floor($c).'}).*?|',str_pad('',floor($c),'*'),$str,1);
    }

    private function spidercontent($code, $type)
    {
        $returnval=array();
        $url = "http://www.bbbao.com/prod?cat_id=10&gtin=0{$code}&query={$code}&browse_id=";
        file_put_contents("/var/www/test.log",date("Y-m-d H:i:s")."=>".$url."\n",FILE_APPEND);
        $httptarget = new Httplib();
        $response = $httptarget->get($url);
        if ($response) {
            $data = $response['body'];
            preg_match_all("/var share_info = {};(.*?)<\/script>/is", $data, $matches);
            if ($matches) {
                $detail = $matches[1][0];
                $lines = explode(";", $detail);
                $data = $this->formatData($lines);
                if (!isset($data['isbn'])) {
                    $data['isbn'] = $code;
                }
                if (!isset($data['bartype'])) {
                    $data['bartype'] = $type;
                }
                if (!isset($data['lrdate'])) {
                    $data['lrdate'] = date("Y-m-d");
                }
                $returnval=$data;
            }
        }
        return $returnval;
    }
    private function formatData($content)
    {
        $returnVal = array();
        if ($content) {
            foreach ($content as $item) {
                if (strpos($item, "creator")) {
                    $tmp = explode("'", $item);
                    $returnVal['creator'] = $tmp[1];
                } else if (strpos($item, "binding")) {
                    $tmp = explode("'", $item);
                    $returnVal['binding'] = $tmp[1];
                } else if (strpos($item, "number_of_pages")) {
                    $tmp = explode("'", $item);
                    $returnVal['pages'] = $tmp[1];
                } else if (strpos($item, "publication_date")) {
                    $tmp = explode("'", $item);
                    $returnVal['pdate'] = $tmp[1];
                } else if (strpos($item, "publisher")) {
                    $tmp = explode("'", $item);
                    $returnVal['publisher'] = $tmp[1];
                } else if (strpos($item, "name")) {
                    $tmp = explode("'", $item);
                    $returnVal['name'] = $tmp[1];
                } else if (strpos($item, "image_url")) {
                    $tmp = explode("'", $item);
                    $returnVal['image_url'] = $tmp[1];
                } else if (strpos($item, "title")) {
                    $tmp = explode("'", $item);
                    $returnVal['title'] = $tmp[1];
                }
            }
        }
        return $returnVal;
    }

}
