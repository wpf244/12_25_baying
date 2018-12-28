<?php
namespace app\api\controller;

use think\Request;

class About extends BaseHome
{
    public function index()
    {
        $re=db("sys")->where("id=1")->find();
        if($re){
            $url=parent::getUrl();
            $re['pclogo']=$url.$re['pclogo'];
            $re['waplogo']=$url.$re['waplogo'];
            $re['qrcode']=$url.$re['qrcode'];
            $re['wx']=$url.$re['wx'];
            $arr=[
                'error_code'=>0,
                'data'=>$re
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂无数据'
            ];
        }
        echo \json_encode($arr);
    }
    public function save()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $data['uid']=$uid;
            $data['content']=\input('content');
            $data['time']=\time();
            $re=db("message")->insert($data);
            if($re){
                $arr=[
                    'error_code'=>0,
                    'data'=>'提交成功'
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'data'=>'提交失败'
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'data'=>'暂未登录'
            ];
        }
       
       
        echo \json_encode($arr);
    }
    
    
    
    
}