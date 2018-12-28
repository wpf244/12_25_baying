<?php
namespace app\api\controller;

use think\Request;

class User extends BaseHome
{
    public function index()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $re=db("user")->where("uid=$uid")->find();
            if($re){
                
                unset($re['pwd'],$re['time'],$re['openid']);
                $arr=[
                    'error_code'=>0,
                    'data'=>$re
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'该用户不存在'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂未登录'
            ];
        }
        echo \json_encode($arr);
    }
    //上传图片
    public function add_img(){
        if(!is_string(input('image'))){
            $image=uploads('image');
        }
        if($image){
            $arr=$image;
        }else{
            $arr="上传失败";
        }
        echo $arr;
    }
    public function save()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $re=db("user")->where("uid=$uid")->find();
            if($re){
                $image=\input('image');
                if(empty($image)){
                    $data['image']=$re['image'];
                }
                $data['sex']=\input('sex');
                $data['birth']=\input('birth');
                $data['nickname']=\input('nickname');
                $res=db("user")->where("uid=$uid")->update($data);
                if($res){
                    $arr=[
                        'error_code'=>0,
                        'data'=>'修改成功'
                    ];
                }else{
                    $arr=[
                        'error_code'=>3,
                        'data'=>'修改失败'
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'该用户不存在'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂未登录'
            ];
        }
        echo \json_encode($arr);
    }
   
    //收货地址列表
    public function addr()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=\db("addr")->where("u_id=$uid")->order("aid desc")->select();
            if($res){
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
                'data'=>'暂未登录'
            ];
        }
        echo \json_encode($arr);
    }
    //修改默认地址
    public function change()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $aid=input("aid");
            $re=db("addr")->where("u_id=$uid and aid=$aid")->find();
            if($re){
                $res=db("addr")->where("aid=$aid")->setField("status",1);
                if($res){
                    $arr=[
                        'error_code'=>0,
                        'data'=>'修改成功'
                    ]; 
                }else{
                    $arr=[
                        'error_code'=>3,
                        'data'=>'修改失败'
                    ]; 
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'非法操作'
                ]; 
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂未登录'
            ]; 
        }
        echo \json_encode($arr);
    }
    //保存收货地址
    public function addr_save()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $data=\input('post.');
            $re=db("addr")->where("u_id=$uid")->find();
            if(empty($re)){
                $data['status']=1;
            }
            $data['u_id']=$uid;
            $rea=db('addr')->insert($data);
            $aid = db('addr')->getLastInsID();
            
            if($rea){
                $arr=[
                    'error_code'=>0,
                    'aid'=>$aid,
                    'data'=>'保存成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'保存失败'
                ];
            }
            
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂未登录'
            ];
        }
        echo \json_encode($arr);
    }
    //收货地址详情
    public function addr_detail()
    {
        $aid=\input('aid');
        $re=db('addr')->where("aid=$aid")->find();
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
    //修改收货地址
    public function addr_usave()
    {
        $aid=\input('aid');
        $re=db("addr")->where("aid=$aid")->find();
        if($re){
            $data=\input('post.');
            $res=db("addr")->where("aid=$aid")->update($data);
            if($res){
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
                'error_code'=>1,
                'data'=>'操作失败'
            ];
        }
        echo \json_encode($arr);
    }
    //删除收货地址
    public function addr_detele()
    {
        $aid=\input('aid');
        $re=\db('addr')->where("aid=$aid")->find();
        if($re){
           $del=\db('addr')->where("aid=$aid")->delete();
           if($del){
               $arr=[
                   'error_code'=>0,
                   'data'=>'删除成功'
               ];
           }else{
               $arr=[
                   'error_code'=>2,
                   'data'=>'删除失败'
               ];
           }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'收货地址不存在'
            ];
        }
        echo \json_encode($arr);
    }
    //手机号码换绑
    public function change_phone()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $re=db("user")->field("phone")->where("uid=$uid")->find();
            if($re){
                $arr=[
                    'error_code'=>0,
                    'data'=>$re
                ];
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
    //保存手机号码
    public function save_phone()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $old_phone=\input('old_phone');
            $phone=\input('phone');
            $code=\input('code');
            $rec=db("code")->where("phone=$phone and code=$code")->find();
            if($rec){
                $del=db("code")->where("phone=$phone")->delete();
                $re=db("user")->field("phone")->where("uid=$uid")->find();
                if($re){
                    $phones=$re['phone'];
                    if($phones == $old_phone){
                        $data['phone']=$phone;
                        $res=db("user")->where("uid=$uid")->update($data);
                        if($res){
                            $arr=[
                                'error_code'=>0,
                                'data'=>'修改成功'
                            ];
                        }else{
                            $arr=[
                                'error_code'=>5,
                                'data'=>'修改失败'
                            ];
                        }
                    }else{
                        $arr=[
                            'error_code'=>4,
                            'data'=>'非法操作'
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
                    'error_code'=>3,
                    'data'=>'验证码已失效'
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
    //我的收藏
    public function my_collect()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=db("collect")->alias("a")->where("u_id=$uid")->join("goods b","a.g_id=b.gid")->select();
            if($res){
                $url=parent::getUrl();
                $arrs=array();
                foreach ($res as $k => $v){
                    $arrs[$k]['gid']=$v['gid'];
                    $arrs[$k]['g_name']=$v['g_name'];
                    $arrs[$k]['g_xprice']=sprintf("%.2f",$v['g_xprice']);
                    $arrs[$k]['g_sales']=$v['g_sales'];
                    $arrs[$k]['g_image']=$url.$v['g_image'];
                    $arrs[$k]['g_skill']=$v['g_skill'];
                }
                $arr=[
                    'error_code'=>0,
                    'data'=>$arrs
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'没有数据'
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
    //我的订单
    public function my_dd()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            if(\input('status')){
                $status=\input('status');
            }else{
                $status=0;
            }
            if($status == 5){
                $res=db("car_dd")->where("uid=$uid and gid=0")->order("did desc")->select();
            }else{
                $res=db("car_dd")->where("uid=$uid and status=$status and gid=0")->order("did desc")->select();
            }
            
            if($res){
                $arrss=array();
                $url=parent::getUrl();
                $arrs=array();
                foreach ($res as $k => $v){
                    $arrs[$k]['did']=$v['did'];
                    $arrs[$k]['code']=$v['code'];
                    $arrs[$k]['time']=$v['time'];
                    $arrs[$k]['z_price']=sprintf("%.2f",$v['zprice']);
                    $arrs[$k]['status']=$v['status'];
                        
                    $pay=$v['pay'];
                    $pays=\explode(",", $pay);
                    foreach ($pays as $kk => $vv){
                        $dd=db("car_dd")->where("code='$vv'")->find();
                        $arrss[$kk]['g_image']=$url.$dd['g_image'];
                        $arrss[$kk]['g_name']=$dd['g_name'];
                        $arrss[$kk]['g_xprice']=sprintf("%.2f",$dd['price']);
                        $arrss[$kk]['num']=$dd['num'];
                        $arrss[$kk]['gid']=$dd['gid'];
                        $arrss[$kk]['x_total']=\sprintf("%.2f",($dd['num']*$dd['price']));
                    }
                    
                    $arrs[$k]['goods']=$arrss;
                }
                $arr=[
                    'error_code'=>0,
                    'data'=>$arrs
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'没有数据'
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
    //取消订单
    public function delete_dd()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $did=\input('did');
            $re=\db('car_dd')->where("uid=$uid and did=$did")->find();
            if($re){
                $del=db('car_dd')->where("uid=$uid and did=$did")->delete();
                $pay=$re['pay'];
                $pays=\explode(",", $pay);
                
                $res=db('car_dd')->where(array('code'=>array('in',$pays)))->select();
                if($res){
                    $dels=db('car_dd')->where(array('code'=>array('in',$pays)))->delete();
                }
                if($del){
                    $arr=[
                        'error_code'=>0,
                        'data'=>'删除成功'
                    ];
                }else{
                    $arr=[
                        'error_code'=>3,
                        'data'=>'删除失败'
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'非法操作'
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
    //确认收货
    public function take_goods()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $did=\input('did');
            $re=\db('car_dd')->where("uid=$uid and did=$did")->find();
            if($re){
                if($re['status'] == 2){
                   $res=db('car_dd')->where("uid=$uid and did=$did")->setField("status",3);
                   $pay=$re['pay'];
                   $pays=\explode(",", $pay);
                   
                   $res=db('car_dd')->where(array('code'=>array('in',$pays)))->select();
                   if($res){
                       $dels=db('car_dd')->where(array('code'=>array('in',$pays)))->setField("status",3);
                   }
                    if($res){
                        $arr=[
                            'error_code'=>0,
                            'data'=>'操作成功'
                        ];
                    }else{
                        $arr=[
                            'error_code'=>3,
                            'data'=>'操作失败'
                        ];
                    }
                }else{
                    $arr=[
                        'error_code'=>2,
                        'data'=>'非法操作'
                    ];
                }
                
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'非法操作'
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
    //订单详情
    public function detail_dd()
    {
        $did=\input('did');
        $re=db("car_dd")->where("did=$did")->find();
        if($re){
            $arrs=array();
            $url=parent::getUrl();
            $arrs['did']=$re['did'];
            $arrs['code']=$re['code'];
            $arrs['status']=$re['status'];
            $arrs['p_type']=$re['p_type'];
            $arrs['p_time']=$re['p_time'];
            $aid=$re['a_id'];
            $addr=db("addr")->where("aid=$aid")->find();
            $arrs['addr']=$addr;
            $pay=$re['pay'];
            $pays=\explode(",", $pay);
            $res=db("car_dd")->where(array('code'=>array('in',$pays)))->select();
            $arrss=array();
            foreach ($res as $k => $v){
                $arrss[$k]['g_image']=$url.$v['g_image'];
                $arrss[$k]['g_name']=$v['g_name'];
                $arrss[$k]['g_xprice']=sprintf("%.2f",$v['price']);
                $arrss[$k]['num']=$v['num'];
            }
            $arrs['goods']=$arrss;
            $arrs['content']=$re['content'];
            $arrs['money']=sprintf("%.2f",$re['zprice']);
            $arrs['time']=$re['time'];
            
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
    //商品评价
    public function goods_assess()
    {
        $did=\input('did');
        $re=db("car_dd")->where("did=$did")->find();
        if($re){
            $url=parent::getUrl();
            $arrs=array();
            
            $pay=$re['pay'];
            $pays=\explode(",", $pay);
            $res=db("car_dd")->where(array('code'=>array('in',$pays)))->select();
            foreach ($res as $k => $v){
                $arrs[$k]['gid']=$v['gid'];
                $arrs[$k]['g_name']=$v['g_name'];
                $arrs[$k]['g_image']=$url.$v['g_image'];
                $arrs[$k]['g_xprice']=sprintf("%.2f",$v['price']);
            }
            $arr=[
                'error_code'=>0,
                'data'=>[
                    'did'=>$did,
                    'goods'=>$arrs
                ]
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有此订单'
            ];
        }
        echo \json_encode($arr);
    }
    //保存评价
    public function save_assess()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $did=\input('did');
            $re=db("car_dd")->where("did=$did")->find();
            if($re){
                if($re['status'] == 3){
                    $res=db("car_dd")->where("did=$did")->setField("status",4);
                    $pay=$re['pay'];
                    $pays=\explode(",", $pay);
                    $res=db("car_dd")->where(array('code'=>array('in',$pays)))->select();
                    if($res){
                        $ress=db("car_dd")->where(array('code'=>array('in',$pays)))->setField("status",4);
                    }
                    $datas=\input('post.');
                    $assess=$datas['assess'];
                    foreach ($assess as $v){
                        $data['u_id']=$uid;
                        $data['g_id']=$v['gid'];
                        $data['number']=$v['num'];
                        $data['content']=$v['content'];
                        $data['addtime']=\time();
                        
                        db("assess")->insert($data);
                    }
                    $arr=[
                        'error_code'=>0,
                        'data'=>'发布成功'
                    ];
                }else{
                    $arr=[
                        'error_code'=>2,
                        'data'=>'非法操作'
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'非法操作'
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
    //获取用户信息
    public function make(){
        $code=input('code');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx5e58284464f622f8&secret=99a486bd8578692121f8774784cec6ca&js_code=".$code."&grant_type=authorization_code";
        $results=json_decode(file_get_contents($url),true);
      //  \var_dump($results);exit;
        $openid=$results['openid'];
        if(!$openid){
            $arr=[
                'error_code'=>1,
                'data'=>'openID获取失败'
            ];
        }else{
            $data=array();
            $data['openid']=$openid;
            $data['nickname']=\input('nickname');
            $data['image']=\input('image');
            $data['time']=\time();
            $ret=db('user')->where(array('openid'=>$openid))->find();
            if($ret['openid']){
                $res=db("user")->where(array('openid'=>$openid))->update($data);
                    $arr=[
                        'error_code'=>0,
                        'data'=>[
                            'uid'=>$ret['uid'],
                            'msg'=>'获取成功'
                        ]
                    ];
            }else{
                $rea=db('user')->insert($data);
                $uid=db('user')->getLastInsID();
                if($rea){
                    $arr=[
                        'error_code'=>0,
                        'data'=>[
                            'uid'=>$uid,
                            'msg'=>'获取成功'
                        ]
                    ];
    
                }else{
                    $arr=[
                        'error_code'=>2,
                        'data'=>'获取失败'
                    ];
                }
               
            }
        }
        echo \json_encode($arr);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}