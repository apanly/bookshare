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
        $this->target->insert("book",$fields);
    }

    public function updateBook($fields,$isbn){
        $this->target->update("book",$fields," isbn='{$isbn}'");
    }

    public function updateBookById($id){
        $sql="update book set clicknum = clicknum+1 where  id={$id}";
        $this->target->query($sql);
    }

    public function findByISBN($isbn){
       $sql="SELECT * FROM book where isbn='{$isbn}'";
       $result=$this->target->get_one($sql);
       return $result;
    }

    public function findById($id){
        $sql="SELECT * FROM book where id={$id}";
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


    public function getList($from,$limit){
        $sql="SELECT * FROM book ORDER BY clicknum desc,id asc  DESC LIMIT {$from},{$limit}";
        return $this->target->get_all($sql);
    }

    public function getBookCount(){
        $sql="SELECT COUNT(*) AS num FROM book";
        $res=$this->target->get_one($sql);
        if($res){
            return $res['num'];
        }
        return 0;
    }
}
