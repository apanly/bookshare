<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 12/22/13
 * Time: 3:26 PM
 * To change this template use File | Settings | File Templates.
 */
class wxcrontabController extends Controller
{
       private $token=null;
       private $wxtarget=null;
       public function defaultAction(){
           $pageSize=50;
           $msgqtarget=new msgqueue();
           $queuedata=$msgqtarget->getqueueList($pageSize);
           if($queuedata){
               $arr = array(
                   'account' => WXUSER,
                   'password' => WXPASS
               );
               $this->wxtarget=$w = new weixin($arr);
               $msgdata=$w->getLastestMessage($pageSize);
               $this->token=$w->getToken();
               if($msgdata){
                   foreach($queuedata as $key=>$item){
                       $extradata=$this->findBestMatch($item,$msgdata);
                       $queuedata[$key]['extra']=$extradata;
                   }
                   $userRelation=array();
                   $lifemedia=array();
                   foreach($queuedata as $item){
                       $queueflag=1;
                       $wxmsgid=0;
                       $fakeid=0;
                       if($item['extra']){
                           $wxmsgid=$item['extra']['id'];
                           $fakeid=$item['extra']['fakeid'];
                       }else{
                           $queueflag=2;
                       }
                       $msgqtarget->update(
                            array(
                                "queueflag"=>$queueflag,
                                "wxmsgid"=>$wxmsgid
                            ),
                            $item['msgid']
                       );
                       if(in_array($item['msgtype'],array(3,4))){
                           $lifemedia[]=array(
                              "type"=>$item['msgtype']-1,
                               "wxmsgid"=>$wxmsgid
                           );
                       }
                       if($fakeid && !isset($userRelation[$fakeid])){
                            $userRelation[$fakeid]=$item['openid'];
                       }
                   }
                   if($userRelation){
                       $userReTarget=new userRelation();
                       foreach($userRelation as $wxfakeid=>$openid){
                            $tmpUserInfo=$userReTarget->findByOpendid($openid);
                            if($tmpUserInfo){
                                if(!$tmpUserInfo['fakeid']){
                                    $userReTarget->updateByOpenid($openid,$wxfakeid);
                                }
                            }else{
                                $userReTarget->insert(
                                    array(
                                        "openid"=>$openid,
                                        "fakeid"=>$wxfakeid
                                    )
                                );
                            }
                       }
                   }
                   if($lifemedia){
                       $lifetarget=new lifemedia();
                       foreach($lifemedia as $sublifemedia){
                           $sqldata=array();
                           $sqldata['content']=$this->contructUri($sublifemedia['wxmsgid'],$sublifemedia['type']);
                           $sqldata['idate']=date("Y-m-d H:i:s");
                           $sqldata['openid']='oIdgguC1V-XNuLh2xYA1kYKLYuyY';
                           $sqldata['type']=$sublifemedia['type'];
                           if($sqldata['content']){
                               $lifetarget->insert($sqldata);
                           }
                       }
                   }
               }
           }
       }

        private function findBestMatch($item,$msgdata){
            $returnVal=array();
            foreach($msgdata as $submsg){
                if($item['msgtype']==$submsg['type'] && abs($item['msgtime']-$submsg['date_time'])<=2){
                    if($item['msgtype']==1){//文本
                        if($submsg['content']==$item['content']){
                            $returnVal=$submsg;
                        }
                    }else if($item['msgtype']==2){//图片
                        $returnVal=$submsg;
                            //todo
                    }else if($item['msgtype']==3){//声音
                        $returnVal=$submsg;
                    }else if($item['msgtype']==4){//视频
                        $returnVal=$submsg;
                    }
                }
            }
            return $returnVal;
        }

        private function contructUri($id,$type=2){
            $data=$this->wxtarget->downMultiMedia($id);
            if($data){
                $uri=$data['url'];
                $mediatype=".mp4";
                $mediadata=$data['body'];
                if($type==2){
                    $mediatype=".mp3";
                }
                $flag=innerMedia::setvideo($mediadata,$uri,date("Y-m-d"),$mediatype);
                if($flag){
                    return $uri;
                }
            }
            return null;
        }

        public function testAction(){
            $arr = array(
                'account' => WXUSER,
                'password' => WXPASS
            );
            $w = new weixin($arr);
            $data=$w->downMultiMedia("10000157");
            var_dump($data['header']);exit();
            if($data){
                file_put_contents(ROOT_PATH."wx.mp4",$data['body']);
            }
        }
}
