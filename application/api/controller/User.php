<?php
namespace app\api\controller;

use think\Request;
use think\Db;

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
            $default = db("addr")->where("u_id", $uid)->where('default', 1)->find();
            if($re){
                $res=db("addr")->where("aid=$aid")->setField("default",1);
                if($res){
                    if($default){
                        db("addr")->where("aid", $default['aid'])->setField("default",0);
                    }
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
            // $re=db("addr")->where("u_id=$uid")->find();
            // if(empty($re)){
            //     $data['default']=1;
            // }
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
    //默认收货地址
    public function addr_default(){
        $uid=Request::instance()->header('uid');
        $re=db('addr')->where("u_id", $uid)->where("default",1)->find();
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
               
                $url=parent::getUrl();
                $arrs=array();
                foreach ($res as $k => $v){
                    $arrs[$k]['did']=$v['did'];
                    $arrs[$k]['code']=$v['code'];
                    $arrs[$k]['time']=$v['time'];
                    $arrs[$k]['z_price']=sprintf("%.2f",$v['zprice']);
                    $arrs[$k]['status']=$v['status'];
                    $arrs[$k]['uid']=$v['uid'];
                        
                    $pay=$v['pay'];
                    $pays=\explode(",", $pay);
                    $arrss=array();
                    foreach ($pays as $kk => $vv){
                        
                        $dd=db("car_dd")->where("code='$vv'")->find();
                        $arrss[$kk]['g_image']=$url.$dd['g_image'];
                        $arrss[$kk]['g_name']=$dd['g_name'];
                        $arrss[$kk]['g_xprice']=sprintf("%.2f",$dd['price']);
                        $arrss[$kk]['num']=$dd['num'];
                        $arrss[$kk]['gid']=$dd['gid'];
                        $arrss[$kk]['x_total']=\sprintf("%.2f",($dd['num']*$dd['price']));
                       
                    }
                  //  var_dump($arrss);
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
      //  $data=array();
        $fid = Request::instance()->param('fid', 0);
        if($fid != 0){
            $data['fid']=$fid;
        }
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wxcde9f11cf93da5ba&secret=8d6c6d3e4ff79f7008d51352d6ae0d4b&js_code=".$code."&grant_type=authorization_code";
        $results=json_decode(file_get_contents($url),true);
      //  \var_dump($results);exit;
        $openid=$results['openid'];
        if(!$openid){
            $arr=[
                'error_code'=>1,
                'data'=>'openID获取失败'
            ];
        }else{
            
            $data['openid']=$openid;
            $data['nickname']=Request::instance()->param('nickname', '');
            $data['image']=Request::instance()->param('image', '');
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
    
    /**
     * 代言名片
     *
     * @return void
     */
    public function card(){
        $uid = Request::instance()->header('uid');
        $user = db('user')->where('uid', $uid)->find();
        if($user['card'] != ''){
            $url = parent::getUrl().'/'.$user['card'];
            $arr=[
                'error_code'=>0,
                'data'=>$url
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'重新获取'
            ];
        }
       
        echo \json_encode($arr);
    }

    /**
     * 获取小程序二维码
     *
     * @return void
     */
    public function getqrcode(){
        //接收参数
        $uid = Request::instance()->header('uid');
        $scene = Request::instance()->param('scene', 0);
        $page = Request::instance()->param('page', '');
        //微信token
        $appid = 'wxcde9f11cf93da5ba';
        $secret = '8d6c6d3e4ff79f7008d51352d6ae0d4b';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $results=json_decode(file_get_contents($url)); 
        //请求二维码的二进制资源
        $post_data='{"scene":"'.$scene.'", "page":"'. $page .'"}';
        $res_url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$results->access_token;
        $result=$this->httpRequest($res_url,$post_data,'POST');
        //转码为base64格式并本地保存
        $base64_image ="data:image/jpeg;base64,".base64_encode($result);
        $path = 'uploads/'.uniqid().'.jpg';
        $res = $this->file_put($base64_image, $path);
        //业务处理
        if($res){
            db('user')->where('uid', $uid)->update(['card'=>$path]);
            $url_res=parent::getUrl();
            $arr=[
                'error_code'=>0,
                'data'=>$url_res.'/'.$path,
                'msg'=>'生成成功'
            ];
        }else{
            $arr=[
                'error_code'=>2,
                'data'=>'',
                'msg'=>'生成失败'
            ];
        }
        echo \json_encode($arr);
    }

    /**
     * 图片保存
     *
     * @param [type] $base64_image_content base64格式图片资源
     * @param [type] $new_file 保存的路径，文件夹必须存在
     * @return void
     */
    public function file_put($base64_image_content,$new_file)
    {
        header('Content-type:text/html;charset=utf-8');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * curl函数网站请求封装函数
     *
     * @param [type] $url 请求地址
     * @param string $data 数据
     * @param string $method 请求方法
     * @return void
     */
    function httpRequest($url, $data='', $method='GET'){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if($method=='POST')
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
     
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    
    /**
     * 股权日志
     *
     * @return void
     */
    public function money_log(){
        $uid=Request::instance()->header('uid');
        if($uid){
            $res = db("money_log")->where("u_id", $uid)->select();
            $arr=[
                'error_code'=>0,
                'data'=>$res
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    
    /**
     * 奖励金日志
     *
     * @return void
     */
    public function bonus_log(){
        $uid=Request::instance()->header('uid');
        if($uid){
            $res = db("bonus_log")->where("u_id", $uid)->select();
            $arr=[
                'error_code'=>0,
                'data'=>$res
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo \json_encode($arr);
    }
    
    /**
     * 奖励金提现
     *
     * @return void
     */
    public function bonus_withdrow(){
        $uid=Request::instance()->header('uid');
        if(!$uid){
            return json_encode(array('error_code'=>1,'data'=>'没有登录'));
        }
        $money = Request::instance()->param('money', 0);
        $wx_nickname = Request::instance()->param('wx_nickname', '');
        $wx_account = Request::instance()->param('wx_account', '');
        if($money < 1){
            return json_encode(array('error_code'=>1,'data'=>'提现金额不能小于1元'));
        }
        if(floor($money) != $money){
            return json_encode(array('error_code'=>1,'data'=>'提现金额必须是整数'));
        }
        if($wx_nickname == '' || $wx_account == ''){
            return json_encode(array('error_code'=>1,'data'=>'微信信息未填写完整'));
        }
        $user = db("user")->where("uid=$uid")->find();
        if($user['money'] < $money){
            return json_encode(array('error_code'=>1,'data'=>'余额不足'));
        }
        $res = db("bonus_withdrow")->insert(['uid'=>$uid, 'money'=>$money, 'wx_nickname'=>$wx_nickname, 'wx_account'=>$wx_account, 'time'=>time()]);
        db("user")->where("uid", $uid)->setDec('bonus', $money);
        db("bonus_log")->insert(['u_id'=>$uid,'bonus'=>$money,'time'=>time(),'status'=>0]);
        if($res){
            return json_encode(array('error_code'=>0,'data'=>'提现申请提交成功'));
        }else{
            return json_encode(array('error_code'=>1,'data'=>'提现申请提交失败'));
        }  
    }
    
    public function sum_bonus(){
        $uid=Request::instance()->header('uid');
        $res = db("bonus_log")->where("u_id = $uid and status=1")->sum('bonus');
        return json_encode(array('error_code'=>0,'data'=>$res));
    }
    public function change_success()
    {
        $did=input("did");
        $re=db("mall_dd")->where("id=$did")->find();
        $url=parent::getUrl();
        if($re){
            $re['mimage']=$url.$re['mimage'];
            $arrs=array();
            $aid=$re['a_id'];
            $addr=db("addr")->where("aid=$aid")->find();
            $arrs=[
                'order'=>$re,
                'addr'=>$addr
            ];
            $arr=[
                'error_code'=>0,
                'data'=>$arrs
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'暂无数据'
            ];
        }
        echo json_encode($arr);
    }
    public function shou()
    {
        $id=input('id');
        $re=db("mall_dd")->where("id=$id")->find();
        if($re){
           $res=db("mall_dd")->where("id=$id")->setField("m_status",2);
           if($res){
            $arr=[
                'error_code'=>0,
                'data'=>'确认成功'
            ]; 
           }else{
            $arr=[
                'error_code'=>1,
                'data'=>'确认失败'
            ];
           }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'确认失败'
            ];
        }
        echo json_encode($arr);
    }
    public function tui()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $did=input('did');
            $re=db("car_dd")->where("uid=$uid and did=$did")->find();
            if($re){
                if($re['status'] != 0){
                    $arr['tui_content']=input("content");
                    $arr['tui_time']=time();
                    $arr['status']=6;
                    $pay=$re['pay'];
                    $pays=explode(",",$pay);
                    foreach($pays as $v){
                        $red=db("car_dd")->where("code='$v'")->find();
                        if($red){
                            db("car_dd")->where("code='$v'")->update($arr);
                        }
                    }
                    $res=db("car_dd")->where("uid=$uid and did=$did")->update($arr);
                    if($res){
                        $arr=[
                            'error_code'=>0,
                            'data'=>'申请提交成功'
                        ];
                    }else{
                        $arr=[
                            'error_code'=>4,
                            'data'=>'申请提交失败'
                        ];
                    }
                }else{
                    $arr=[
                        'error_code'=>3,
                        'data'=>'未付款订单不能退货'
                    ];  
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'没有此订单'
                ]; 
            }

        }else{
            $arr=[
                'error_code'=>1,
                'data'=>'没有登录'
            ];
        }
        echo json_encode($arr);
    }


    
    
    
}