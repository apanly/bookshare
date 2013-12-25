<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 10/1/13
 * Time: 9:52 PM
 * To change this template use File | Settings | File Templates.
 */
class library{
    private $target=null;
    public function __construct(){
        $this->target=new Mysql();
    }
    public function insertBook($fields){
        $bookdetail=array();
        $bookdetail['booksummary']=$fields['booksummary'];
        $bookdetail['booktag']=$fields['booktag'];
        unset($fields['booksummary']);
        unset($fields['booktag']);
        $this->target->insert("book",$fields);
        $bookdetail['bookid']=$this->target->insert_id();
        $this->target->insert("bookdetail",$bookdetail);
    }

    public function updateBook($fields,$isbn,$uid){
        $this->target->update("book",$fields," isbn='{$isbn}' and uid={$uid}");
    }

    public function updateBookById($id){
        $sql="update book set clicknum = clicknum+1 where  id={$id}";
        $this->target->query($sql);
    }

    public function updateBookFlagById($id,$flag,$orderid,$booknum){
        if($booknum){
            $sql="update book set flag ={$flag},rentor='{$orderid}',booknumber=booknumber+({$booknum})  where  id={$id}";
        }
        $this->target->query($sql);
    }

    public function findByISBN($isbn){
       $sql="SELECT * FROM book where isbn='{$isbn}'";
       $result=$this->target->get_one($sql);
       return $result;
    }

    public function findById($id){
        $sql="SELECT * FROM book as a ,bookdetail as b where a.id=b.bookid and a.id={$id}";
        $result=$this->target->get_one($sql);
        return $result;
    }
    public function getPrevById($id){
        $sql="SELECT * FROM book where id<{$id} order by id desc limit 1";
        $result=$this->target->get_one($sql);
        return $result;
    }
    public function getNextById($id){
        $sql="SELECT * FROM book where id>{$id} order by id asc limit 1";
        $result=$this->target->get_one($sql);
        return $result;
    }



    public function getList($from,$limit,$bookname=''){
        if($bookname==''){
            $condition=" ";
        }else{
            $condition=" where lower(title) like '%{$bookname}%'";
        }
        $sql="SELECT * FROM book   {$condition} ORDER BY id asc  LIMIT {$from},{$limit}";
        return $this->target->get_all($sql);
    }


    public function getHotBookList($pageSize=3){
        $sql="SELECT * FROM book  ORDER BY clicknum desc  LIMIT {$pageSize}";
        return $this->target->get_all($sql);
    }

    public function getBookCount($bookname=''){
        if($bookname==''){
            $condition=" ";
        }else{
            $condition=" where lower(name) like '%{$bookname}%'";
        }
        $sql="SELECT COUNT(*) AS num  FROM book  {$condition} ";
        $res=$this->target->get_one($sql);
        if($res){
            return $res['num'];
        }
        return 0;
    }


    public function updateBookDetail($id,$fields){
        $this->target->update("book",$fields," id={$id}");
    }

    public function saveBookRecord($content,$opendid=''){
       return  $this->target->insert("draftrecord",
        array(
            "content"=>$content,
            'openid'=>$opendid,
            "idate"=>date("Y-m-d")
        ));
    }
    public function getnotelist($openid,$limit=3){
       $sql="SELECT * FROM draftrecord WHERE openid= '{$openid}' limit {$limit}";
       return $this->target->get_all($sql);
    }
    public function getBookRecordId(){
        return $this->target->insert_id();
    }
}
