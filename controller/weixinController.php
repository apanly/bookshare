<?php
class weixinController extends Controller
{
   private $appid=APPID;
   private $appseckey=APPSECKEY;
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
        $type="text";
        $msgqueue=array();
        $msgqueue['openid']=$fromUsername;
        $msgqueue['msgtime']=$postObj->CreateTime;
        $msgqueue['queueflag']=0;
        if($MsgType=="text"){
            $msgqueue['content']=$keyword;
            $msgqueue['msgtype']=1;
            if(strlen($keyword)>2){
                $str_q=trim(substr($keyword,2));
                $keyword=substr($keyword,0,2);
            }
        }else if($MsgType=="image"){
            $keyword=$MsgType;
            $str_q=$postObj->PicUrl;
            $msgqueue['content']=$str_q;
            $msgqueue['msgtype']=2;
        }else if($MsgType=="voice"){
            $keyword=$MsgType;
            $str_q=$postObj->MediaId;
            $msgqueue['content']=$str_q;
            $msgqueue['msgtype']=3;
        }else if($MsgType=="video"){
            $keyword=$MsgType;
            $str_q=$postObj->MediaId;
            $msgqueue['content']=$str_q;
            $msgqueue['msgtype']=4;
        }else if($MsgType=="event"){
            $keyword=$MsgType;
            $str_q=$postObj->Event;
        }
        $msgqtarget=new msgqueue();
        $msgqtarget->insert($msgqueue);
        unset($msgqueue);
        switch($keyword){
            case "bs":
                if($str_q){
                    $type="multi";
                    $contentStr=$this->searchbook($str_q);
                }else{
                    $contentStr="操作有误,bs后面需要有内容，例如 bs redis";
                }
                break;
            case "nl":
                $type="multi";
                $contentStr=$this->getnotelist($fromUsername);
                break;
            case "br":
                if($str_q){
                    $contentStr=$this->saveBookRecord($str_q,$fromUsername);
                }else{
                    $contentStr="操作有误,br后面需要有内容，例如 br I love you!!";
                }
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
                $contentStr="本服务暂未提供,敬请期待";
                break;
            case "voice":
                //$mediatype=2;
                //$contentStr=$this->saveLiftMedia($str_q,$fromUsername,$mediatype);
                $contentStr="感谢你使用微信记录生活!可以到http://book.yyabc.org/index.php?a=media查看";
                break;
            case "video":
                //$mediatype=3;
                //$contentStr=$this->saveLiftMedia($str_q,$fromUsername,$mediatype);
                $contentStr="感谢你使用微信记录生活!可以到http://book.yyabc.org/index.php?a=media查看";
                break;
            case "sa":
                if($str_q){
                    $this->writeCustomLog($fromUsername."的建议是:".$str_q);
                    $contentStr="感谢你的建议,我们会做的更好";
                }else{
                    $contentStr="操作有误,sa后面需要有内容，例如 sa 如果可以显示我分享的图片列表就好了";
                }
                break;
            case "image":
                $mediatype=1;
                $contentStr=$this->saveLiftMedia($str_q,$fromUsername,$mediatype);
                break;
            case "event":
                if($str_q=="subscribe"){
                    $contentStr=$this->eventUsage();
                }else if($str_q=="unsubscribe"){
                    $contentStr=$this->eventUsage();
                }
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
    private function getnotelist($openid){
        $booktarget=new library();
        $data=$booktarget->getnotelist($openid,10);
        $contentStr="";
        if($data){
            $datacnt=count($data);
            if($data){
                $contentStr.="<ArticleCount>{$datacnt}</ArticleCount>";
                $contentStr.="<Articles>";
                foreach($data as $tmp){
                    $title=$tmp['content'];
                    $url="http://book.yyabc.org/?a=br&id={$tmp['id']}&openid={$openid}";
                    $contentStr.="<item>
                    <Title><![CDATA[{$title}]]></Title>
                    <Description><![CDATA[{$title}]]></Description>
                    <Url><![CDATA[{$url}]]></Url>
                    </item>";
                }
                $contentStr.="</Articles>";
            }
        }
        return $contentStr;
    }
    private function saveBookRecord($content,$openid){
        $booktarget=new library();
        if(!$booktarget->saveBookRecord($content,$openid)){
            $contentStr="临时读书笔记保存失败";
        }else{
            $recordid=$booktarget->getBookRecordId();
            $contentStr="临时读书笔记保存成功,请到http://book.yyabc.org/?a=br&id={$recordid}查看";
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
    private function saveLiftMedia($mediasrc,$openid,$type=1){
            $contentStr="保存生活图片失败!";
            if(!$mediasrc){
                return $contentStr;
            }
            $sqldata=array();
            $sqldata['content']=$mediasrc;
            $sqldata['idate']=date("Y-m-d H:i:s");
            $sqldata['openid']=$openid;
            $sqldata['type']=$type;
            $lifetarget=new lifemedia();

            if($lifetarget->insert($sqldata)){
                $contentStr="保存生活多媒体成功!可以到http://book.yyabc.org/index.php?a=media查看";
            }
        return $contentStr;
    }
    private  function Usage(){
        $help=<<<EOT
服务分三部分
图书服务
bs--搜索书籍
bl--热门书籍列表
br--记录临时笔记
nl--临时笔记列表\n
英语社区服务
eo--每日一句
ec--双语阅读
ew--英语新闻\n
综合服务
sa--给些建议
图片,音频,视频
EOT;
    return $help;
    }

    private function eventUsage(){
        $help=<<<EOT
欢迎关注心灵分享
本站提供三个服务
图书分享
英语分享
生活多媒体分享
所有分享的图片视频音频都会保存都到网站
回复 ? 获取操作命令
或者可以关注我们的网站 book.yyabc.org
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
        file_put_contents(ROOT_PATH."weixinlog/".date("Ymd")."weixin.log",var_export($GLOBALS["HTTP_RAW_POST_DATA"],true),FILE_APPEND);
    }

    private function writeCustomLog($content){
        file_put_contents(ROOT_PATH."weixinlog/".date("Ymd")."weixincustom.log",$content."\n",FILE_APPEND);
    }

    public function testAction(){
        $arr = array(
            'account' => WXUSER,
            'password' => WXPASS
        );
        $w = new weixin($arr);
        $w->getLastestMessage();
        var_dump($w->getAllUserInfo());//获取所有用户信息
        exit();
        $a = $w->sendMessage('群发内123123123容');
        var_dump($a);
    }
}
