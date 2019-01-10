<?php
namespace app\api\controller;

use think\Request;
use function think\delete;

class Goods extends BaseHome
{
    public function lister()
    {
        $type_id=\input('type_id');
             
        $res=db("goods")->field('gid,g_image,g_name')->where("fid=$type_id and g_up=1")->order("g_sales desc")->select();
        if($res){
            foreach ($res as $k=>$v){
                $url=parent::getUrl();
                $res[$k]['g_images']=$url.$v['g_image'];
                $res[$k]['g_name']=$v['g_name'];
            }
            $arr=[
                'error_code'=>0,
                'data'=>$res
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂无数据'
            ];
        }
            
     
        echo \json_encode($arr);
    }
    //搜索详情
    public function search()
    {
        $res=db('lb')->field('name')->where("fid=3 and status=1")->order(['sort asc','id desc'])->select();
        if($res){
            $arr=[
                'error_code'=>0,
                'data'=>$res
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂无数据'
            ];
        }
        echo \json_encode($arr);
    }
    //搜索列表页
    public function search_lister()
    {
        $key=\input('key');
        if(empty($key)){
            $arr=[
                'error_code'=>2,
                'data'=>'关键词为空'
            ];
        }else{
            $res=db("goods")->field('gid,g_name,g_xprice,g_image,g_sort')->where('g_name','like',"%$key%")->where("g_up=1")->order(['g_sort asc','gid desc'])->select();
            if($res){
                foreach ($res as $k=>$v){
                    $url=parent::getUrl();
                    $res[$k]['g_images']=$url.$v['g_image'];
                    $res[$k]['g_xprice']=sprintf("%.2f",$v['g_xprice']);
                }
                $arr=[
                    'error_code'=>0,
                    'data'=>$res
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'data'=>'暂无数据'
                ];
            }
        }
       
        echo \json_encode($arr);
    }

     //产品分类
     public function types()
     {
         $res=db("type")->field("type_id,type_name")->order(['type_sort asc','type_id desc'])->limit('4')->select();
         if($res){
            
             $arr=[
                 'error_code'=>0,
                 'data'=>$res
             ];
         }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂无数据'
            ]; 
         }
         echo \json_encode($arr);
     }

    //限时抢购
    public function rush()
    {
        $url=parent::getUrl();
        
        $rush=db("lb")->field('image')->where("fid=6")->find();
        $rush['image']=$url.$rush['image'];
        
        $end_time=db("rush")->where("id=1")->find()['end_time'];
        $time=\time();
        if($time > $end_time){
            $rush['end_time']="限时抢购已结束";
        }else{
            $rush['end_time']=\intval($end_time);
        }
        
        $res=db("goods")->field('gid,g_name,g_xprice,g_image,g_sales,g_sort')->where("g_skill=1 and g_up=1")->order(['g_sort asc','gid desc'])->select();
        if($res){
            foreach ($res as $k=>$v){
                $url=parent::getUrl();
                $res[$k]['g_image']=$url.$v['g_image'];
                $res[$k]['g_xprice']=sprintf("%.2f",$v['g_xprice']);
            }
            $rush['goods']=$res;
        }else{
            $rush['goods']="暂无数据";
        }
        
        $arr=[
            'error_code'=>0,
            'data'=>$rush
        ];
        echo \json_encode($arr);
    }
    //节日专区
    public function feast()
    {
        $url=parent::getUrl();
        
        $feast=db("lb")->field('image')->where("fid=7")->find();
        $feast['image']=$url.$feast['image'];
        
        $res=db("goods")->field('gid,g_name,g_imagej,key,advert')->where("g_te=1 and g_up=1")->order(['g_sort asc','gid desc'])->select();
        if($res){
            foreach ($res as $k=>$v){
                $url=parent::getUrl();
                $res[$k]['g_imagej']=$url.$v['g_imagej'];
            }
            $feast['goods']=$res;
        }else{
            $feast['goods']="暂无数据";
        }
        $arr=[
            'error_code'=>0,
            'data'=>$feast
        ];
        echo \json_encode($arr);
    }
    //宴会专区
    public function banqust()
    {
        $url=parent::getUrl();
        
        $banqust=db("lb")->field('image,desc')->where("fid=8")->find();
        $banqust['image']=$url.$banqust['image'];

        
        $phone=db("sys")->where("id=1")->find()['phone'];
        $banqust['phone']=$phone;
        
        $res=db("goods")->field('gid,g_name,g_xprice,g_imagey,key,advert,num,spec')->where("g_hot=1 and g_up=1")->order(['g_sort asc','gid desc'])->select();
        if($res){
            foreach ($res as $k=>$v){
                $url=parent::getUrl();
                $res[$k]['g_imagey']=$url.$v['g_imagey'];
            }
            $banqust['goods']=$res;
        }else{
            $banqust['goods']="暂无数据";
        }
        $arr=[
            'error_code'=>0,
            'data'=>$banqust
        ];
        echo \json_encode($arr);
    }
    //商品详情
    public function detail()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $user=db("user")->where("uid=$uid")->find();
            if($user){

                //根据会员等级判断打几折
               
                $level=$user['level'];
                $cobber=db("cobber")->where("id=1")->find();
                if($level == 0){
                    $agio=$cobber['rabate'];
                }
                if($level == 1){
                    $agio=$cobber['rabatey'];
                }
                if($level == 2){
                    $agio=$cobber['rabatee'];
                }

                $url=parent::getUrl();
        
                $gid=\input('gid');
                $re=db("goods")->field("gid,g_name,g_image,g_sales,g_content,g_xprice")->where("gid=$gid")->find();
                
                $re['g_image']=$url.$re['g_image'];
             //   $re['g_xprice']=($re['g_xprice']);
                $re['g_xprice']=($re['g_xprice']/100*$agio);
                $re['g_xprice']=sprintf("%.2f",$re['g_xprice']);
                
                //轮播图
                $img=db("goods_img")->where("g_id=$gid and i_status=1")->select();
                if($img){
                    foreach ($img as $k => $v){
                        $re['banner'][$k]=$url.$v['image'];
                    }
                }else{
                    $re['banner']=array($re['g_image']);
                }
        
                //商品规格
                $spec=db("goods_spec")->field("sid,s_name")->where("g_id=$gid and s_status=1")->select();
                if($spec){
                    $re['spec']=$spec;
                }else{
                    $re['spec']=array();
                }
                
                //商品评价
                $count=db("assess")->where("g_id=$gid and status=1")->count();
                
                $assess=db("assess")->alias('a')->field('number,addtime,content,image,nickname')->where("g_id=$gid and status=1")->join('user b','a.u_id = b.uid')->order('id desc')->limit(1)->find();
                
                if($assess){
                    $assess['addtime']=\intval($assess['addtime']);
                    $re['assess']=[
                        'count'=>$count,
                        'content'=>$assess
                    ];
                }else{
                    $re['assess']=[
                        'count'=>$count,
                        'content'=>array()
                    ];
                }
                
                
                $arr=[
                    'error_code'=>0,
                    'data'=>$re
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'登录失效'
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
    public function judge()
    {
        $uid=Request::instance()->header('uid');
        $gid=\input('gid');
        $re=array();
     
        //购物车数量
        if(!empty($uid)){
            $car_cou=db("car")->where("u_id=$uid")->count();
            $re['car_cou']=$car_cou;
        }else{
            $re['car_cou']=0;
        }
        $arr=[
            'error_code'=>0,
            'data'=>$re
        ];
        echo \json_encode($arr);
    }
    //获取规格价格
    public function get_spec()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $user=db("user")->where("uid=$uid")->find();
            if($user){

                //根据会员等级判断打几折
               
                $level=$user['level'];
                $cobber=db("cobber")->where("id=1")->find();
                if($level == 0){
                    $agio=$cobber['rabate']/100;
                }
                if($level == 1){
                    $agio=$cobber['rabatey']/100;
                }
                if($level == 2){
                    $agio=$cobber['rabatee']/100;
                }
                $sid=input('sid');
                $re=db("goods_spec")->field("s_xprice")->where("sid=$sid")->find();
             //   $re['s_xprice']=sprintf("%.2f",$re['s_xprice']);
               $re['s_xprice']=sprintf("%.2f",$re['s_xprice']*$agio);
                if($re){
                    $arr=[
                        'error_code'=>0,
                        'data'=>$re
                    ];
                }else{
                    $arr=[
                        'error_code'=>1,
                        'data'=>"参数错误"
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>"登录失效"
                ];
            }
        }else{
            $arr=[
                'error_code'=>3,
                'data'=>"没有登录"
            ];
        }
        echo json_encode($arr);
    }
    //收藏
    public function collect()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $gid=\input('gid');
            $re=db("collect")->where("u_id=$uid and g_id=$gid")->find();
            if($re){
                $del=db("collect")->where("id={$re['id']}")->delete();
                if($del){
                    $arr=[
                        'error_code'=>0,
                        'data'=>'取消收藏成功'
                    ];
                }else{
                    $arr=[
                        'error_code'=>2,
                        'data'=>'操作失败'
                    ];
                }
            }else{
                $data['u_id']=$uid;
                $data['g_id']=$gid;
                $rea=db("collect")->insert($data);
                if($rea){
                    $arr=[
                        'error_code'=>0,
                        'data'=>'收藏成功'
                    ];
                }else{
                    $arr=[
                        'error_code'=>2,
                        'data'=>'操作失败'
                    ];
                }
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    //详情
    public function goods_detail()
    {
        $gid=\input('gid');
        $re=db("goods")->field('g_content')->where("gid=$gid")->find();
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
    //规格
    public function goods_spec()
    {
        $gid=\input('gid');
        $re=db("goods")->field('spec')->where("gid=$gid")->find();
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
    //评论
    public function goods_assess()
    {
        $gid=\input('gid');
        
        $re=array();
        //商品评价
        $count=db("assess")->where("g_id=$gid and status=1")->count();
        $re['count']=$count;
        
        $assess=db("assess")->alias('a')->field('number,addtime,content,image,nickname')->where("g_id=$gid and status=1")->join('user b','a.u_id = b.uid')->order('id desc')->select();
        if($assess){
            foreach ($assess as $k => $v){
                $assess[$k]['addtime']=\intval($v['addtime']);
            }
            $re['assess']=$assess;
        }else{
            $re['assess']='暂无评价';
        }
        $arr=[
            'error_code'=>0,
            'data'=>$re
        ];
        
        echo \json_encode($arr);
    }
    //加入购物车
    public function add_car()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $gid=\input('gid');
            $num=\input('num');
            $sid=input('sid');
            $re=db("goods")->where("gid=$gid")->find();
            $res=db("goods_spec")->where("sid=$sid and g_id=$gid")->find();
            if($re && $res){
               $rec=db('car')->where("u_id=$uid and g_id=$gid and s_id=$sid")->find();
               if($rec){
                   $del=db('car')->where("u_id=$uid and g_id=$gid and s_id=$sid")->setInc("num",$num);
                   if($del){
                       $arr=[
                           'error_code'=>0,
                           'data'=>'加入成功'
                       ];
                   }else{
                       $arr=[
                           'error_code'=>3,
                           'data'=>'加入失败'
                       ];
                   }
               }else{
                   $data['u_id']=$uid;
                   $data['g_id']=$gid;
                   $data['num']=$num;
                   $data['c_name']=$re['g_name'];
                   $data['c_image']=$re['g_image'];
                   $data['price']=$res['s_xprice'];
                   $data['s_id']=$sid;
                   $data['s_name']=$res['s_name'];
                   $rea=db("car")->insert($data);
                   if($rea){
                       $arr=[
                           'error_code'=>0,
                           'data'=>'加入成功'
                       ];
                   }else{
                       $arr=[
                           'error_code'=>3,
                           'data'=>'加入失败'
                       ];
                   }
               }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'系统繁忙，请稍后再试'
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
    //立即购买
    public function go_buy()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $url=parent::getUrl();
            $gid=\input('gid');
            $sid=input('sid');
            $num=\input('num');
            
            $user=db("user")->where("uid=$uid")->find();
            $level=$user['level'];
            $cobber=db("cobber")->where("id=1")->find();
            if($level == 0){
                $agio=$cobber['rabate']/100;
            }
            if($level == 1){
                $agio=$cobber['rabatey']/100;
            }
            if($level == 2){
                $agio=$cobber['rabatee']/100;
            }
            
            $arrs=array();
            //商品详情
            $re=\db("goods")->field('gid,g_name,g_image,g_xprice')->where("gid=$gid")->find();
            $spec=db("goods_spec")->where("sid=$sid")->find();
            $re['sid']=$sid;
            $re['s_name']=$spec['s_name'];
            
            $re['g_image']=$url.$re['g_image'];
            $re['g_xprice']=sprintf("%.2f",$spec['s_xprice']);
            $re['x_total']=($num*$re['g_xprice']);
            $re['x_total']=sprintf("%.2f",$re['x_total']);
            $re['num']=\intval($num);
            
     
            //商品总金额
            $money=($re['g_xprice']*$num);
            $arrs['money']=sprintf("%.2f",$money*$agio);
            $arrs['goods']=[$re];
            
            $arr=[
                'error_code'=>0,
                'data'=>$arrs
            ];
            
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    //生成订单
    public function sdd()
    {
       $uid=Request::instance()->header('uid');
       if($uid){
            $user=db("user")->where("uid=$uid")->find();
            $level=$user['level'];
            $cobber=db("cobber")->where("id=1")->find();
            if($level == 0){
                $agio=$cobber['rabate']/100;
            }
            if($level == 1){
                $agio=$cobber['rabatey']/100;
            }
            if($level == 2){
                $agio=$cobber['rabatee']/100;
            }

           $gid=input('gid');
           $sid=input('sid');
           $num=input('num');
           $aid=\input('aid');
           
           $content=\input('content');
           $ob=db("car_dd");
           $old_dd=db("car_dd")->where("gid=$gid and uid=$uid  and status=0")->find();
           if($old_dd){
               $del=$ob->where("gid=$gid and uid=$uid  and status=0")->delete();
               $code=$old_dd['code'];
               $dels=$ob->where("pay='$code'")->find();
               if($dels){
                   $delss=$ob->where("did={$dels['did']}")->delete();
               }
           }
           $good=db("goods")->where("gid=$gid")->find();
           $spec=db("goods_spec")->where("sid=$sid")->find();
           
           $arr=array();
           $arr['gid']=$gid;
           $arr['uid']=$uid;
           
           $arr['s_name']=$spec['s_name'];
           $arr['num']=$num;
           $arr['price']=$spec['s_xprice'];
           $arr['zprice']=($spec['s_xprice']*$num*$agio);
           $arr['g_name']=$good['g_name'];
           $arr['g_image']=$good['g_image'];
           $arr['a_id']=$aid;
          
           $arr['code']="CK-".uniqid();
           $arr['time']=time();
           $arr['content']=$content;
           $re=$ob->insert($arr);
           
           $all['gid']='0';
           $all['uid']=$uid;
           $all['num']=1;
           
           $all['s_name']=$spec['s_name'];
           $all['price']=$spec['s_xprice'];
           $all['g_name']=$good['g_name'];
           $all['g_image']=$good['g_image'];;
           $all['zprice']=($spec['s_xprice']*$num*$agio);
           $all['code']="AK-".uniqid().'a';
           $all['pay']=$arr['code'];
           $all['time']=time();
           $all['a_id']=$aid;
           
           $all['content']=$content;
           $rez=$ob->insert($all);
           
           $did = db('car_dd')->getLastInsID();
           if($did){
               $arr=[
               'error_code'=>0,
               'data'=>[
                   'did'=>$did,
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
               'data'=>'没有登录'
           ];
       }
       echo \json_encode($arr); 
    }
    //购物车
    public function car()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=db("car")->where("u_id=$uid")->select();
            if($res){
                $url=parent::getUrl();
                $arrs=array();
                foreach ($res as $k => $v){
                    $arrs[$k]['cid']=$v['cid'];
                    $arrs[$k]['g_name']=$v['c_name'];
                    $arrs[$k]['g_image']=$url.$v['c_image'];
                    $arrs[$k]['g_xprice']=sprintf("%.2f",$v['price']);
                    $arrs[$k]['s_name']=$v['s_name'];
                    $arrs[$k]['gid']=$v['g_id'];
                    $arrs[$k]['num']=$v['num'];
                    $arrs[$k]['status']=$v['status'];
                }
                $cou=\db('car')->where("u_id=$uid and status=0")->count();
                if($cou == 0){
                    $checkall=1;
                }else{
                    $checkall=0;
                }
                $arr=[
                    'error_code'=>0,
                    'checkall'=>$checkall,
                    'data'=>$arrs
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'checkall'=>0,
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
    //增加数量
    public function add_num()
    {
        $cid=\input('cid');
        $re=db("car")->where("cid=$cid")->find();
        if($re){
            $res=db("car")->where("cid=$cid")->setInc("num",1);
            if($res){
                $arr=[
                    'error_code'=>0,
                    'data'=>'操作成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'操作失败'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'非法操作'
            ];
        }
        echo \json_encode($arr);
    }
    //减少数量
    public function cut_num()
    {
        $cid=\input('cid');
        $re=db("car")->where("cid=$cid")->find();
        if($re){
            $res=db("car")->where("cid=$cid")->setDec("num",1);
            if($res){
                $arr=[
                    'error_code'=>0,
                    'data'=>'操作成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'操作失败'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'非法操作'
            ];
        }
        echo \json_encode($arr);
    }
    //选中状态
    public function change()
    {
        $cid=\input('cid');
        $re=db("car")->where("cid=$cid")->find();
        if($re){
            if($re['status'] == 0){
                $res=db("car")->where("cid=$cid")->setField("status",1);
            }else{
                $res=db("car")->where("cid=$cid")->setField("status",0);
            }
            if($res){
                $arr=[
                    'error_code'=>0,
                    'data'=>'操作成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'操作失败'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'非法操作'
            ];
        }
        echo \json_encode($arr);
    }
    //全选
    public function change_all()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $type=\input('type');
            if($type == 0){
                $res=db("car")->where("u_id=$uid")->setField("status",0);
            }else{
                $res=db("car")->where("u_id=$uid")->setField("status",1);
            }
            if($res){
                $arr=[
                    'error_code'=>0,
                    'data'=>'操作成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'操作失败'
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
    //删除
    public function delete_car()
    {
        $cid=\input('cid');
        $re=db("car")->where("cid=$cid")->find();
        if($re){
            $del=db("car")->where("cid=$cid")->delete();
            if($del){
                $arr=[
                    'error_code'=>0,
                    'data'=>'操作成功'
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'操作失败'
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'非法操作'
            ];
        }
        echo \json_encode($arr);
    }
    //确认订单
    public function buy()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=db("car")->where("u_id=$uid and status=1")->select();
            $arrs=array();
            $url=parent::getUrl();
            $moneys=0;
            foreach ($res as $k => $v){
                $arrs[$k]['g_name']=$v['c_name'];
                $arrs[$k]['g_image']=$url.$v['c_image'];
                $arrs[$k]['g_xprice']=sprintf("%.2f",$v['price']);
                $arrs[$k]['num']=$v['num'];
                $arrs[$k]['s_name']=$v['s_name'];
                
                $money=sprintf("%.2f",($v['price']*$v['num']));
                $arrs[$k]['x_total']=$money;
                $moneys+=$money;
            }
            //根据会员等级判断打几折
            $reu=db("user")->where("uid=$uid")->find();
            $level=$reu['level'];
            $cobber=db("cobber")->where("id=1")->find();
            if($level == 0){
                $agio=$cobber['rabate'];
            }
            if($level == 1){
                $agio=$cobber['rabatey'];
            }
            if($level == 2){
                $agio=$cobber['rabatee'];
            }

            $moneys=sprintf("%.2f",($moneys/100*$agio));
            $arr=[
                'error_code'=>0,
                'data'=>[
                    'moneys'=>$moneys,
                    'goods'=>$arrs,
                    'level'=>$level,
                    'agio'=>$agio
                ]
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    //购物车结算
    public function pan()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $aid=\input('aid');
            $content=\input('content');

             //根据会员等级判断打几折
             $reu=db("user")->where("uid=$uid")->find();
             $level=$reu['level'];
             $cobber=db("cobber")->where("id=1")->find();
             if($level == 0){
                 $agio=$cobber['rabate'];
             }
             if($level == 1){
                 $agio=$cobber['rabatey'];
             }
             if($level == 2){
                 $agio=$cobber['rabatee'];
             }
            
            $res=db("car")->where("u_id=$uid and status=1")->select();
            $gname="";
            $zprice=0;
            
            foreach ($res as $k=>$v){
               $arr=array();
               $arr['gid']=$v['g_id'];
               $arr['uid']=$v['u_id'];
               $arr['num']=$v['num'];
               $arr['price']=$v['price'];
               $arr['zprice']=($v['price']*$v['num']);
               $arr['g_name']=$v['c_name'];
               $arr['g_image']=$v['c_image'];
               $arr['s_name']=$v['s_name'];
               $arr['a_id']=$aid;
               $arr['code']="CK-".uniqid();
               $arr['time']=time();
               $arr['content']=$content;
           
                $re=db('car_dd')->insert($arr);
                $str[$k]=$arr['code'];
                $zprice+=($arr['zprice']/100*$agio);
                $gname.=$v['c_name'];
                
              $del=db('car')->where("cid={$v['cid']}")->delete();
            }
           
            $str1=implode(',', $str);
            $all['gid']='0';
            $all['uid']=$uid;
            $all['num']=1;
            $all['zprice']=$zprice;
            $all['g_name']=$gname;
            $all['code']="AK-".uniqid().'a';
            $all['pay']=$str1;
            $all['time']=time();
            $all['a_id']=$aid;
            $all['content']=$content;
            $re=db('car_dd')->insert($all);
            $did = db('car_dd')->getLastInsID();
            
            if($did){
                $arr=[
                    'error_code'=>0,
                    'data'=>[
                        'did'=>$did,
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
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    //支付成功
    public function buy_success()
    {
        $did=\input('did');
        $re=db("car_dd")->where("did=$did")->find();
        if($re){
            $aid=$re['a_id'];
            $addr=db("addr")->field("username,phone")->where("aid=$aid")->find();
            
            $p_type=$re['p_type'];
            
            
            $arrs=array();
            $arrs['code']=$re['code'];
            $arrs['addr']=$addr;
            $arrs['g_xprice']=sprintf("%.2f",$re['zprice']);
            $arrs['content']=$re['content'];
            if($p_type == 0){
                $arrs['dis']="立即送达";
            }else{
                $arrs['dis']="预约配送".  $re['p_time'];
            }
            
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
    
    
    
    
    
    
    
}