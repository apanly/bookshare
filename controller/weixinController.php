<?php
class weixinController extends Controller
{
   private $appid="wxbc00883339fb7a7f";
   private $appseckey="8d426e4f3a7f1571a2db10b26705230f";
    public function defaultAction(){
        echo $this->resMsg();
        $this->writeLog();
        exit();
        $accessToken=$this->getAccessToken();
        $this->writeLog();
        $echoStr = $_GET["echostr"];
	    echo $echoStr;
        exit;
    }
    private function resMsg(){
        $postStr= $GLOBALS["HTTP_RAW_POST_DATA"];//获取POST数据
        $postObj= simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
        $fromUsername= $postObj->FromUserName;//获取发送方帐号（OpenID）
        $toUsername= $postObj->ToUserName;//获取接收方账号
        $MsgType=$postObj->MsgType;
        $keyword= trim($postObj->Content);//获取消息内容
        $time= time(); //获取当前时间戳
        //---------- 返 回 数 据 ---------- //
        $type="text";
        if(strlen($keyword)>2){
            $str_q=trim(substr($keyword,2));
            $keyword=substr($keyword,0,2);
        }
        switch($keyword){
            case "bs":
                $type="multi";
                $contentStr=$this->searchbook($str_q);
                break;
            case "br":
                $contentStr=$this->saveBookRecord($str_q);
                break;
            case "bl":
                $type="multi";
                $contentStr=$this->getHotBookList();
                break;
            case "eo":
                $type="multi";
                $contentStr=$this->getHotEnglishOne();
                break;
            case "ec":
                $type="multi";
                $contentStr=$this->getEngCRead();
                break;
            case "ew":
                break;
            default:
                $contentStr=$this->Usage();
        }
        if($type=="text"){
            return $this->textTpl($fromUsername,$toUsername,$time,$contentStr);
        }else if($type=="multi"){
            return $this->multiTpl($fromUsername,$toUsername,$time,$contentStr);
        }
    }

    private function textTpl($fromUsername,$toUsername,$time,$contentStr){
        //返回消息模板
        $textTpl= "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>0</FuncFlag>
        </xml>";
        $msgType= "text";//消息类型
        //格式化消息模板
        return sprintf($textTpl,$fromUsername,$toUsername,$time,$msgType,$contentStr);
    }

    private function multiTpl($fromUsername,$toUsername,$time,$contentStr){
//返回消息模板
        $textTpl= "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        %s
        </xml> ";
        $msgType= "news";//消息类型
        //格式化消息模板
        return sprintf($textTpl,$fromUsername,$toUsername,$time,$msgType,$contentStr);
    }

    private function getHotBookList(){
        $booktarget=new library();
        $booklist=$booktarget->getHotBookList();
        $contentStr="";
        if($booklist){
            $bookcnt=count($booklist);
            if($bookcnt){
                $contentStr.="<ArticleCount>{$bookcnt}</ArticleCount>";
                $contentStr.="<Articles>";
                foreach($booklist as $tmp){
                    $title=$tmp['title'];
                    $picurl=innerimage::getImage($tmp['image_url']);
                    $url="http://book.yyabc.org/index.php?a=bookdetail&id={$tmp['id']}";
                    $contentStr.="<item>
                    <Title><![CDATA[{$title}]]></Title>
                    <Description><![CDATA[{$title}]]></Description>
                    <PicUrl><![CDATA[{$picurl}]]></PicUrl>
                    <Url><![CDATA[{$url}]]></Url>
                    </item>";
                }
                $contentStr.="</Articles>";
            }
        }
        return $contentStr;
    }
    private function searchbook($bookname){
        $booktarget=new library();
        $booklist=$booktarget->getList(0,3,$bookname);
        $contentStr="";
        if($booklist){
            $bookcnt=count($booklist);
            if($bookcnt){
                $contentStr.="<ArticleCount>{$bookcnt}</ArticleCount>";
                $contentStr.="<Articles>";
                foreach($booklist as $tmp){
                    $title=$tmp['title'];
                    $picurl=innerimage::getImage($tmp['image_url']);
                    $url="http://book.yyabc.org/index.php?a=bookdetail&id={$tmp['id']}";
                    $contentStr.="<item>
                    <Title><![CDATA[{$title}]]></Title>
                    <Description><![CDATA[{$title}]]></Description>
                    <PicUrl><![CDATA[{$picurl}]]></PicUrl>
                    <Url><![CDATA[{$url}]]></Url>
                    </item>";
                }
                $contentStr.="</Articles>";
            }
        }
        return $contentStr;
    }
    private function saveBookRecord($content){
        $booktarget=new library();
        $contentStr="临时读书笔记保存成功,请到book.yyabc.org查看";
        if(!$booktarget->saveBookRecord($content)){
            $contentStr="临时读书笔记保存失败";
        }
        return $contentStr;
    }
    private function getHotEnglishOne(){
        $englishtarget=new english();
        $data=$englishtarget->getList();
        $contentStr="";
        if($data){
            $datacnt=count($data);
            if($data){
                $contentStr.="<ArticleCount>{$datacnt}</ArticleCount>";
                $contentStr.="<Articles>";
                foreach($data as $tmp){
                    $title=$tmp['econtent']."\n".$tmp['zcontent'];
                    $idate=date("Y-m-d",$tmp['idate']);
                    $hash=$tmp['innermguri'];
                    $picurl="http://www.yyabc.org/display/{$idate}/{$hash}";
                    $url="http://www.yyabc.org/tinyenglish";
                    $contentStr.="<item>
                    <Title><![CDATA[YYabc每日一句]]></Title>
                    <Description><![CDATA[{$title}]]></Description>
                    <PicUrl><![CDATA[{$picurl}]]></PicUrl>
                    <Url><![CDATA[{$url}]]></Url>
                    </item>";
                }
                $contentStr.="</Articles>";
            }
        }
        return $contentStr;
    }
    private function getEngCRead(){
        $englishtarget=new english();
        $data=$englishtarget->getReadList();
        $contentStr="";
        if($data){
            $datacnt=count($data);
            if($data){
                $contentStr.="<ArticleCount>{$datacnt}</ArticleCount>";
                $contentStr.="<Articles>";
                foreach($data as $tmp){
                    $title=$tmp['engtitle']."\n".$tmp['chititle'];
                    $picurl="";
                    $url="http://www.yyabc.org/engchidetail?id={$tmp['id']}";
                    $contentStr.="<item>
                    <Title><![CDATA[{$title}]]></Title>
                    <Description><![CDATA[{$title}]]></Description>
                    <PicUrl><![CDATA[{$picurl}]]></PicUrl>
                    <Url><![CDATA[{$url}]]></Url>
                    </item>";
                }
                $contentStr.="</Articles>";
            }
        }
        return $contentStr;
    }
    private  function Usage(){
        $help=<<<EOT
服务分三部分
图书服务
bs--搜索数据
bl--热门书籍列表
br--记录读书笔记\n
英语社区服务
eo--每日一句
ec--双语阅读
en--英语新闻
EOT;
    return $help;
    }
    private function getAccessToken(){
        $accessToken=$this->GetCookie();
        if($accessToken){
            return $accessToken;
        }
        $uri="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appseckey}";
        $httptarget=new Httplib();
        $data=$httptarget->get($uri);
        if($data){
            $resp=$data['body'];
            $resp=json_decode($resp,true);
            $accessToken=$resp['access_token'];
            if($accessToken){
                return $accessToken;
            }
        }
        return null;
    }
    private function checkSignature($token){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    private function SetCookie($accessToken){
        setcookie("accesstoken",$accessToken,3600);
    }

    private function GetCookie(){
       return $_COOKIE['accesstoken'];
    }

    private function writeLog(){
        file_put_contents(ROOT_PATH."weixin.log",var_export($GLOBALS["HTTP_RAW_POST_DATA"],true),FILE_APPEND);
    }

    private function writeCustomLog($content){
        file_put_contents(ROOT_PATH."weixincustom.log",$content);
    }

    public function testAction(){
        $arr = array(
            'account' => 'xxx',
            'password' => 'xxx'
        );
        $w = new weixin($arr);
        var_dump($w->getAllUserInfo());//获取所有用户信息
        exit();
        $a = $w->sendMessage('群发内123123123容');
        var_dump($a);
    }
}
