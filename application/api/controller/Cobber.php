<?php
namespace app\api\controller;
use think\Request;
class Cobber extends BaseHome
{
    public function index()
    {
        $re=db("lb")->field("desc")->where("fid=5")->find();
        if($re){
            $arr=[
                'error_code'=>0,
                'data'=>$re
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>"暂无数据"
            ];
        }
        echo \json_encode($arr);
    }
    //获取验证码
    public function getcode(){      
        $phone=input('phone');
        $code =mt_rand(100000,999999);       
        $data['phone']=$phone;
        $data['code']=$code;
        $data['time']=time();
        $re=\db("sms_code")->where("phone='$phone'")->find();
        if($re){
            $del=db("sms_code")->where("phone='$phone'")->delete();
        }
        $rea=db("sms_code")->insert($data);
        Post($phone,$code);
        if($rea){
            $arr=[
                'error_code'=>0,
                'data'=>'发送成功'
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'发送失败'
            ];
        }
        
        echo json_encode($arr);
    }
    //保存用户信息
    public function save()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $phone=input('phone');
            $code=input('code');
            $re=db("sms_code")->where(['phone'=>$phone,'code'=>$code])->find();
            if($re){
                $time=$re['time'];
                $times=time();
                $c_time=($times-$time);
                if($c_time < 300){
                    $del=db("sms_code")->where("id={$re['id']}")->delete();           
                    $data['u_id']=$uid;
                    $data['phone']=$phone;
                    $data['sex']=input('sex');
                    $data['username']=input('username');
                    $data['idcode']=input('idcode');
                    $rea=db("go_up")->insert($data);
                    $go_id = db('go_up')->getLastInsID();
                    $arr=[
                        'error_code'=>0,
                        'data'=>['go_id'=>$go_id]
                    ];

                }else{
                    $arr=[
                        'error_code'=>3,
                        'data'=>'验证码已失效'
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'验证码错误'
                ];
            }
       }else{
        $arr=[
            'error_code'=>1,
            'data'=>'暂未登录'
        ];
       }
        echo json_encode($arr);
    }
    public function level()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            //会员信息
            $arrs=array();
            $re=db("user")->where("uid=$uid")->find();
            $arrs['image']=$re['image'];
            $arrs['nickname']=$re['nickname'];
            $arrs['level']=$re['level'];

            //等级信息
            $res=db("level")->select();

            //用户协议
            $rea=db("lb")->field("desc")->where("fid=5")->find();

            $arr=[
                'error_code'=>0,
                'data'=>[
                    'user'=>$arrs,
                    'level'=>$res,
                    'agre'=>$rea
                ]
            ];




        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'请先登录'
            ]; 
        }
        echo json_encode($arr);
    }
    public function order()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
             $go_id=input('go_id');
             $id=input('id');
             $re=db("level")->where("id=$id")->find();
             $data['level']=$re['level'];
             $data['money']=$re['money'];
             $data['agio']=$re['agio'];
             $data['time']=time();
             $data['code']=time();

             $res=db("go_up")->where("go_id=$go_id")->update($data);
             if($res){
                $arr=[
                    'error_code'=>0,
                    'data'=>[
                        'go_id'=>$go_id,
                        'msg'=>'订单生成成功'
                    ]
                ];  
             }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'订单生成失败'
                ];  
             }
        
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'请先登录'
            ];  
        }
        echo json_encode($arr);
    }













}