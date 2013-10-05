<?php
class defaultController extends Controller
{
    public function defaultAction(){
        $pageSize=12;
        $page=$_GET['page']?(int)($_GET['page']):1;
        if($page<=0){
            $page=1;
        }
        $pagefrom=($page-1)*$pageSize;
        $booktarget=new library();
        $bookinfo=$booktarget->getList($pagefrom,$pageSize);
        $bookcnt=$booktarget->getBookCount();
        $pagecnt=ceil($bookcnt/$pageSize);
        $this->pagelist=Slot::includeSlot("pagenation",array("uri"=>'index.php?','page'=>$page,'pagecnt'=>$pagecnt));
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
        $bookinfo['image_url']=innerimage::getImage($bookinfo['image_url']);
        $this->book=$bookinfo;
        $this->bookprev=$bookprev;
        $this->booknext=$booknext;
        $this->atype="home";
        return $this->render("default");
    }

    public function downloadsAction(){
        $this->atype="downloads";
        $this->envirment=ENVIRMENT;
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
        return $this->render("default");
    }
    /**
     * 没有获取价格的地方
     */
    public function scanAction()
    {
        $returnval = array();
        $code = $_REQUEST['code'];
        $type = $_REQUEST['type'];
        if ($code) {
            $booktarget = new library();
            $bookinfo = $booktarget->findByISBN($code);
            if (empty($bookinfo)) {
                        $data=$this->spidercontent($code,$type);
                        $booktarget->insertBook($data);
                        $returnval = $data;
            } else {
                if(empty($bookinfo['name'])){
                    $data=$this->spidercontent($code,$type);
                    unset($data['isbn']);
                    $booktarget->updateBook($data,$code);
                    $returnval = $data;
                }else{
                    $returnval = $bookinfo;
                }

            }
        }
        return json_encode($returnval);
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

    /**
     * http://developers.douban.com/wiki/?title=book_v2#get_isbn_book
     */
    public function testAction(){
        $uri="https://api.douban.com/v2/book/isbn/:9787111213826";
        $httptarget = new Httplib();
        $response = $httptarget->get($uri);
        $data=$response['body'];
        $data=json_decode($data,true);
        var_dump($data);
    }
}
