<?php
namespace app\api\controller;

use think\Request;

class Mall extends BaseHome
{
    public function lister()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
           $user=db("user")->where("uid=$uid")->find();
           if($user){
               $integ=$user['money'];
               $res=db("mall")->where("mup=1")->order("minteg asc")->select();
               if($res){
                  $url=parent::getUrl();
                  $arrs=array();
                  foreach ($res as $k => $v){
                      $arrs[$k]['gid']=$v['mid'];
                      $arrs[$k]['g_name']=$v['mname'];
                      $arrs[$k]['g_image']=$url.$v['mimage'];
                      $arrs[$k]['g_integ']=$v['minteg'];
                      $arrs[$k]['g_price']=$v['mprice'];
                      if($integ < $v['minteg']){
                          $arrs[$k]['type']=0;
                      }else{
                          $arrs[$k]['type']=1;
                      }
                  }
                  $arr=[
                      'error_code'=>0,
                      'data'=>$arrs
                  ];
               }else{
                   $arr=[
                       'error_code'=>3,
                       'data'=>'暂无数据'
                   ];
               }
           }else{
               $arr=[
                   'error_code'=>2,
                   'data'=>'非法登录'
               ];
           }
           
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    public function detail()
    {
        $gid=\input('gid');
        $re=db("mall")->where("mid=$gid")->find();
        $url=parent::geturl();
        $re['mimage']=$url.$re['mimage'];
        if($re){
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
    //立即兑换
    public function change()
    {
        $gid=\input('gid');
        $re=db("mall")->where("mid=$gid")->find();
        if($re){
            $url=parent::getUrl();
            $arrs=array();
            $arrs['gid']=$re['mid'];
            $arrs['g_name']=$re['mname'];
            $arrs['g_image']=$url.$re['mimage'];
            $arrs['g_integ']=sprintf("%.2f",$re['minteg']);
            $arrs['g_price']=sprintf("%.2f",$re['mprice']);
            $arr=[
                'error_code'=>0,
                'data'=>[$arrs]
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂无数据'
            ];
        }
        echo \json_encode($arr);
    }
    //确认兑换
    public function go_change()
    {
       $uid=Request::instance()->header('uid');
       if($uid){
           $gid=\input('gid');
           $content=\input('content');
           //查询商品信息
           $re=db("mall")->where("mid=$gid")->find();
           $aid=\input('aid');
           //生成订单
           $data=array();
           $data['uid']=$uid;
           $data['mid']=$re['mid'];
           $data['mname']=$re['mname'];
           $data['minteg']=$re['minteg'];
           $data['mimage']=$re['mimage'];
           $data['time']=\time();
           $data['code']="AK-".uniqid();
           $data['a_id']=$aid;
           $data['content']=$content;
           
           //减少用户积分
           $integ=$re['minteg'];
           $user=db("user")->where("uid=$uid")->find();
           $integu=$user['money'];
           if($integu >= $integ){
               $res=db("user")->where("uid=$uid")->setDec("money",$integ);
           
               //增加兑换日志
               $arr['u_id']=$uid;
             
               $arr['money']=$integ;
               $arr['time']=\time();
               $arr['status']=0;
               $rej=db("money_log")->insert($arr);
           
               $rem=db("mall_dd")->insert($data);
           
               $did = db('mall_dd')->getLastInsID();
           
               $arr=[
               'error_code'=>0,
               'data'=>[
                   'did'=>$did,
                   'msg'=>'兑换成功'
                ]
               ];
           }else{
               $arr=[
               'error_code'=>2,
               'data'=>'用户积分不足'
               ];
           }
       }else{
           $arr=[
               'error_code'=>1,
               'data'=>'没有登录'
           ];
       }
       echo \json_encode($arr);
        
    }
    //兑换成功
    public function change_success()
    {
        $did=\input('did');
        $re=db("mall_dd")->where("id=$did")->find();
        if($re){
            $arrs=array();
            $arrs['code']=$re['code'];
            $aid=$re['a_id'];
            $addr=db("addr")->where("aid=$aid")->find();
            $arrs['addr']=$addr;
            $arrs['integ']=\sprintf("%.2f",$re['minteg']);
            $arrs['content']=$re['content'];
            $arr=[
                'error_code'=>0,
                'data'=>$arrs
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有此订单'
            ];
        }
        echo \json_encode($arr);
    }
    //积分明细
    public function integ_mx()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=db("money_log")->where("u_id=$uid")->order("id desc")->select();
            if($res){
                foreach ($res as $k => $v){
                    $res[$k]['time']=\intval($v['time']);
                }
                $arr=[
                    'error_code'=>0,
                    'data'=>$res
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'暂无数据'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    //兑换记录
    public function record()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=db("mall_dd")->where("uid=$uid")->order("id desc")->select();
            if($res){
                $arrs=array();
                $url=parent::getUrl();
                foreach ($res as $k => $v){
                    $arrs[$k]['did']=$v['id'];
                    $arrs[$k]['g_name']=$v['mname'];
                    $arrs[$k]['integ']=$v['minteg'];
                    $arrs[$k]['time']=\intval($v['time']);
                    $arrs[$k]['status']=$v['m_status'];
                }
                
                $arr=[
                    'error_code'=>0,
                    'data'=>$arrs
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'暂无数据'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}