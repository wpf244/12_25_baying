<?php
namespace app\api\controller;

use think\Controller;
use think\Loader;
use think\Request;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');
Loader::import('WxPay.WxPay', EXTEND_PATH, '.JsApiPay.php');
class Pay extends Controller
{
    public function getopenid()
    {
        $code=\input('code');
        $appid="wxcde9f11cf93da5ba";
        $secret="18bayingshangmaohuizhongchuangda";
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
        $results=json_decode(file_get_contents($url),true);
        \var_dump($results);exit;
        $openid=$results['openid'];
        return $openid;
    }
    public function pays()
    {
        $did=\input('did');
        $uid=Request::instance()->header('uid');
        $user=db("user")->where("uid=$uid")->find();
       
       $openid=$user['openid'];
     //   $openid="oZwh45FZmYEuMXJoB04m9-bBAn4s";
     //   \var_dump($openid);exit;
        $red=db("car_dd")->where("did=$did")->find();
        $order=$red['code'];
        $money=($red['zprice']*100);
        $gname=$red['g_name'];
        
        
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("商品");
        $input->SetOut_trade_no("$order");
        $input->SetTotal_fee("$money");
        $input->SetNotify_url("https://by.dd371.com/Api/Pay/notify/");
        $input->SetTrade_type("JSAPI");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        //     由小程序端传给服务端
        $input->SetOpenid($openid);
        //     向微信统一下单，并返回order，它是一个array数组
        $order = \WxPayApi::unifiedOrder($input);
        //     json化返回给小程序端
        $tools=new \JsApiPay();
        $jsApiParameters = $tools->GetJsApiParameters($order);
        
//         $arr=[
//             'error_code'=>0,
//             'data'=>$jsApiParameters
//         ];
        echo $jsApiParameters;
    }
    public function notify()
    {
        
        //获取返回的xml
        $testxml  = file_get_contents("php://input");
        //将xml转化为json格式
        $jsonxml = json_encode(simplexml_load_string($testxml, 'SimpleXMLElement', LIBXML_NOCDATA));
        
        //转成数组
        $result = json_decode($jsonxml, true);
        
        if($result){
            //如果成功返回了
            if($result['return_code'] == 'SUCCESS'){
                //进行改变订单状态等操作。。。。
                $order_code= $result['out_trade_no'];
                $re=db("car_dd")->where("code='$order_code'")->find();
                $id=$re['did'];
                if($re['status'] == 0){
                    $changestatus=db("car_dd")->where("did=$id")->setField("status",1);
                    if($changestatus){
                        $pay = $re['pay'];
                        $res = explode(",",$pay);
                        foreach($res as $v){
                            $dd = db("car_dd")->where("code='$v'")->find();
                            $uid = $dd['uid'];
                            $gid = $dd['gid'];
                            $did = $dd['did'];
                            $num = $dd['num'];
                            $re_d = db("car_dd")->where("did=$did")->setField("status",1);
                            
                            //增加销量
                            $sales=db("goods")->where("gid=$gid")->setInc("g_sales",$num);
    
                            //减少库存
                            db("goods")->where("gid=$gid")->setDec("g_kc",$num);
    
                        }
                        $moneys=$re['zprice'];
                        //公益金
                        $fund=($moneys/100*1);
                        db("fund")->where("id=1")->setInc("money",$fund);
    
                        //分红比例
                        $cobber=db("cobber")->where("id=2")->find();
                        $agio=$cobber['rabate'];
                        //分红金额
                        $money=($moneys/100*$agio);
                        //查询平台总股数
                        $shares=db("user")->sum("money"); 
                        if($shares != 0){
                            //每股应返多少
                            $one=($money/$shares);
                            //查询用户的总股数
                            $user=db("user")->where("money > 0")->select();
                            if($user){
                                foreach($user as $k => $v){
                                    $new_shares=($v['money']*$one);
                                    db("user")->where("uid={$v['uid']}")->setInc("money",$new_shares);
    
                                    //增加分红日志
                                    $data['u_id']=$v['uid'];
                                    $data['money']=$new_shares;
                                    $data['time']=time();
                                    db("money_log")->insert($data);
                                }
                            }
                        }
                    }
                }
                
            }
        }
        
    }
    public function pays_order()
    {
        $id=\input('go_id');
        $uid=Request::instance()->header('uid');
        $user=db("user")->where("uid=$uid")->find();
       
        $openid=$user['openid'];
    
        $red=db("go_up")->where("go_id=$id")->find();
        $order=$red['code'];
        $money=($red['money']*100);
    
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("升级会员");
        $input->SetOut_trade_no("$order");
        $input->SetTotal_fee("$money");
        $input->SetNotify_url("https://by.dd371.com/Api/Pay/notify_info/");
        $input->SetTrade_type("JSAPI");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        //     由小程序端传给服务端
        $input->SetOpenid($openid);
        //     向微信统一下单，并返回order，它是一个array数组
        $order = \WxPayApi::unifiedOrder($input);
        //     json化返回给小程序端
        
        $tools=new \JsApiPay();
        $jsApiParameters = $tools->GetJsApiParameters($order);
    
//         $arr=[
//             'error_code'=>0,
//             'data'=>$jsApiParameters
//         ];
        echo $jsApiParameters;
    }
    public function notify_info()
    {
        //获取返回的xml
        $testxml  = file_get_contents("php://input");
        //将xml转化为json格式
        $jsonxml = json_encode(simplexml_load_string($testxml, 'SimpleXMLElement', LIBXML_NOCDATA));
        //转成数组
        $result = json_decode($jsonxml, true);
    
        if($result){
            //如果成功返回了
            if($result['return_code'] == 'SUCCESS'){
                //进行改变订单状态等操作。。。。
                $order_code= $result['out_trade_no'];
                $re=db("go_up")->where("code='$order_code'")->find();
                $id=$re['go_id'];
                if($re['status'] == 0){
                    $changestatus=db("go_up")->where("go_id=$id")->setField("status",1);
                   
                    //改变用户等级
                    $uid=$re['u_id'];
                    $reu=db("user")->where("uid=$uid")->find();
                    $data['money']=($re['agio']+$reu['money']);
                    $data['level']=$re['level'];
                    $res=db("user")->where("uid=$uid")->update($data);
                    
                    //增加用户股份数量日志
                    $arrs['money']=$re['agio'];
                    $arrs['u_id']=$uid;
                    $arrs['time']=time();
                   
                    db("money_log")->insert($arrs);
    
                   //给上级会员5%奖励金
                   if($reu['fid'] != 0){
                        $f_user = db("user")->where("uid", $reu['fid'])->find();
                        if($f_user){
                            //获取系统设置
                            $bonus_set = db("cobber")->where("id", 3)->find();
                            if($bonus_set){
                                $bonus = $bonus_set/100;
                            }else{
                                $bonuse = 0.05;
                            }
                            $add_bonus = $re['money']*$bonuse;
                            db("user")->where("uid", $reu['fid'])->setInc('bonus', $add_bonus);
                            db("bonus_log")->insert(['u_id'=>$f_user['uid'], 'bonus'=>$add_bonus, 'time'=>time(), 'status'=>1]);
                        }
                   }
                }
              
               
            }
        }
    }
    //使用佣金支付
    public function pays_y()
    {
         $did=input('did');
         $red=db("car_dd")->where("did=$did")->find();
         if($red){
            if($red['status'] == 0){
                $uid=Request::instance()->header('uid');
                $user=db("user")->where("uid=$uid")->find();
                if($user){
                     $money=$user['money'];
                     $price=$red['zprice'];
                     if($money >= $price){
                        $datas['status']=1;
                        $datas['pay_type']=1;
                        $resd=db("car_dd")->where("did=$did")->update($datas);
                        if($resd){
                            $pay = $red['pay'];
                            $res = explode(",",$pay);
                            foreach($res as $v){
                                $dd = db("car_dd")->where("code='$v'")->find();
                                $uid = $dd['uid'];
                                $gid = $dd['gid'];
                                $did = $dd['did'];
                                $num = $dd['num'];
                                $re_d = db("car_dd")->where("did=$did")->update($datas);
                                
                                //增加销量
                                $sales=db("goods")->where("gid=$gid")->setInc("g_sales",$num);
        
                                //减少库存
                                db("goods")->where("gid=$gid")->setDec("g_kc",$num);
        
                            }
                            $res=db("user")->where("uid=$uid")->setDec("money",$price);
                            $arrs['money']=$price;
                            $arrs['u_id']=$uid;
                            $arrs['time']=time();
                            $arrs['status']=0;
                            db("money_log")->insert($arrs);
                            $arr=[
                                'error_code'=>0,
                                'data'=>'支付成功'
                            ]; 
                        }else{
                            $arr=[
                                'error_code'=>5,
                                'data'=>'支付失败'
                            ]; 
                        }

                     }else{
                        $arr=[
                            'error_code'=>4,
                            'data'=>'股金不足'
                        ]; 
                     }
                }else{
                    $arr=[
                        'error_code'=>3,
                        'data'=>'用户不存在'
                    ]; 
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'订单状态异常'
                ];
            }
         }else{
             $arr=[
                 'error_code'=>1,
                 'data'=>'此订单不存在'
             ];
         }
         echo json_encode($arr);
    }
    
    
    
    
    
    
    
    
}