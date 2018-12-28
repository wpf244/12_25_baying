<?php
namespace app\api\controller;


class Login extends BaseHome
{
    //获取验证码
    public function getcode(){
        $phone=input('phone');
        $re=db('user')->where("phone=$phone")->find();
        if($re){
            $arr=[
                'error_code'=>1,
                'data'=>"此手机号已注册"
            ];
        }else{
            $code =mt_rand(100000,999999);
            Post($phone,$code);
            $data['phone']=$phone;
            $data['code']=$code;
            $rea=db("code")->insert($data);
            if($rea){
                $arr=[
                    'error_code'=>0,
                    'data'=>'发送成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'发送失败'
                ];
            }
           
        }
        echo json_encode($arr);
    }
    //修改密码获取验证码
    public function getcodes(){
        $phone=input('phone');
        $re=db('user')->where("phone=$phone")->find();
        if($re){
            $code =mt_rand(100000,999999);
            Post($phone,$code);
            $data['phone']=$phone;
            $data['code']=$code;
            $rea=db("code")->insert($data);
            if($rea){
                $arr=[
                    'error_code'=>0,
                    'data'=>'发送成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'发送失败'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>"此手机号未注册"
            ];
        }
        echo json_encode($arr);
    }
    //注册
    public function save()
    {
        $data=array();
        $phone=\input('phone');
        $pwd=\input('pwd');
        $data['phone']=$phone;
        $data['pwd']=$pwd;
        $res=$this->validate($data, 'logins');
        if($res === true){
            $code=\input('code');
            $re=db("code")->where("phone=$phone and code=$code")->find();
            if($re){
                $data['time']=\time();
                $rea=db("user")->insert($data);
                $del=db("code")->where("phone=$phone")->delete();
                if($rea){
                    $arr=[
                        'error_code'=>0,
                        'data'=>'注册成功'
                    ];
                }else{
                    $arr=[
                        'error_code'=>2,
                        'data'=>'注册失败'
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>3,
                    'data'=>'验证码已失效'
                ];
            }
            
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>$res
            ];
        }
        echo \json_encode($arr);
    }
    //修改密码
    public function usave()
    {
        $data=array();
        $phone=\input('phone');
        $pwd=\input('pwd');
        $data['phone']=$phone;
        $data['pwd']=$pwd;
        $res=$this->validate($data, 'logins');
        if($res === true){
            $code=\input('code');
            $rec=db("code")->where("phone=$phone and code=$code")->find();
            if($rec){
                $re=db("user")->where("phone=$phone")->find();
                if($re){
                    $arrs['pwd']=$pwd;
                    $ress=db("user")->where("phone=$phone")->update($arrs);
                    $del=db("code")->where("phone=$phone")->delete();
                    if($ress){
                        $arr=[
                            'error_code'=>0,
                            'data'=>'修改成功'
                        ];
                    }else{
                        $arr=[
                            'error_code'=>2,
                            'data'=>'修改失败'
                        ];
                    }
                }else{
                    $arr=[
                        'error_code'=>3,
                        'data'=>'验证码已失效'
                    ];
                }
           
            }else{
                $arr=[
                    'error_code'=>3,
                    'data'=>'此用户不存在'
                ];
            }
           
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>$res
            ];
        }
        echo \json_encode($arr);
    }
    //手机号码登录
    public function login(){
        $phone=input('phone');
        $pwd=input('pwd');
        $re=db('user')->where("phone=$phone")->find();
        if($re){
            $reu=db("user")->where(array('phone'=>$phone,'pwd'=>$pwd))->find();
            if($reu){
                $uid=$reu['uid'];
                $arr=[
                    'error_code'=>0,
                    'data'=>[
                        'msg'=>'登录成功',
                        'uid'=>$uid,
                    ]
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'账号或密码错误'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'此手机号未注册'
            ];
        }
        echo json_encode($arr);
    }
    
}