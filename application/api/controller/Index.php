<?php
namespace app\api\controller;

use think\Request;

class Index extends BaseHome
{
    public function index()
    {
        
        $url=parent::getUrl();
        //首页轮播
        $lb=db("lb")->field('id,url,image,thumb,desc')->where("fid=1 and status=1")->order(['sort asc','id desc'])->select();
        foreach ($lb as $k => $v){
            if(empty($v['desc'])){
                $lb[$k]['status']=0;
            }else{
                $lb[$k]['status']=1;
            }
            $lb[$k]['image']=$url.$v['image'];
            unset($lb[$k]['thumb']);
        }
        
        //首页公告
        $notic=db("lb")->field('id,name')->where("fid=2 and status=1")->order(['sort asc','id desc'])->select();
        $arr=[
            'error_code'=>0,
            'data'=>[
                'lb'=>$lb,
                'notic'=>$notic,
            ]
        ];
        echo \json_encode($arr);
    }
    //公告详情
    public function detail()
    {
        $id=input("id");
        $re=db("lb")->field('id,name,desc')->where("id=$id")->find();
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
        echo \json_encode($arr);
    }
   
    //产品列表
    public function goods()
    {
        $res=db("goods")->field('gid,g_name,g_xprice,g_image,g_sort')->where("g_up=1 and g_status=1")->order(['g_sort asc','gid desc'])->select();
        if($res){
            foreach ($res as $k=>$v){
                $url=parent::getUrl();
                $res[$k]['g_image']=$url.$v['g_image'];
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
        echo \json_encode($arr);
    }
    //酒水回购
    public function wine()
    {
        $re=db("lb")->field('image')->where("fid=15")->find();
        if($re){
            $url=parent::getUrl();
            $re['image']=$url.$re['image'];
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
    //婚嫁车队
    public function car()
    {
        $re=db("lb")->field('image,desc')->where("fid=16")->find();
        if($re){
            $url=parent::getUrl();
            $arrs['image']=$url.$re['image'];
            $arrs['content1']=$re['desc'];
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
        echo \json_encode($arr);
    }
    //信息发布
    public function info()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $re=db("rush")->field("money")->where("id=2")->find();
            if($re){
                $arr=[
                    'error_code'=>0,
                    'data'=>$re
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
    //上传图片
    function add_img(){
        if(!is_string(input('image'))){
            $image=uploads('image');
        }
        if($image){
            $arr=$image;
        }else{
            $arr="发布失败";
        }
        echo $arr;
    }
    
    //多图上传
    function add_imgs(){
       \var_dump('1234');exit;
        $files = request()->file('image');
        $data='';
        foreach($files as $file){
            $info = $file->move(str_replace("\\", "/", ROOT_PATH) . 'public' . DS . 'uploads');
            $pa=$info->getSaveName();
            $path=str_replace("\\", "/", $pa);
            $images=\think\Image::open(ROOT_PATH.'/public'.$path);
            $images->save(ROOT_PATH.'/public'.$path,null,60,true);
            $paths='uploads/'.$path.',';
            $data['image']=$paths;
        }
        echo $data;
    }
    //保存发布信息
    public function save_info()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $data=\input('post.');
            
          //  \var_dump($data);exit;
            $data['u_id']=$uid;
            $data['code']=\date("YmdHis");
            $data['addtime']=\time();
            if($data['imgs']){
                $data['imgs']=implode(",", $data['imgs']);
            }
            $re=db("info")->insert($data);
            $id=db('info')->getLastInsID();
            if($id){
                $arr=[
                    'error_code'=>0,
                    'id'=>$id,
                    'data'=>'订单生成成功'
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
    //全部信息列表
    public function all_info()
    {
        $res=\db("info")->where("status=1")->order("id desc")->select();
        if($res){
            $arrs=array();
            $url=parent::getUrl();
            foreach ($res as $k => $v){
                $uid=$v['u_id'];
                $user=\db("user")->where("uid=$uid")->find();
                $arrs[$k]['id']=$v['id'];
                $arrs[$k]['phone']=$v['phone'];
                $arrs[$k]['username']=$user['nickname'];
                $arrs[$k]['title']=$v['title'];
                $arrs[$k]['time']=$v['addtime'];
                $arrs[$k]['content']=$v['content'];
                $arrs[$k]['headimage']=$user['image'];
                $imgs=$v['imgs'];
                $imgss=\explode(",", $imgs);
                foreach ($imgss as $kk => $vv){
                    $arrs[$k]['image'][$kk]=$url.$vv;
                }
            }
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
        echo \json_encode($arr);
    }
    //信息详情
    public function detail_info()
    {
        $id=\input('id');
        $re=db("info")->where("id=$id")->find();
        if($re){
            $arrs=array();
            $url=parent::getUrl();
            $uid=$re['u_id'];
            $user=\db("user")->where("uid=$uid")->find();
            $arrs['id']=$re['id'];
            $arrs['phone']=$re['phone'];
            $arrs['username']=$user['nickname'];
            $arrs['title']=$re['title'];
            $arrs['time']=$re['addtime'];
            $arrs['content']=$re['content'];
            $arrs['headimage']=$user['image'];
            $imgs=$re['imgs'];
            $imgss=\explode(",", $imgs);
            foreach ($imgss as $kk => $vv){
                $arrs['image'][$kk]=$url.$vv;
            }
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
        echo \json_encode($arr);
    }
    //我的信息列表
    public function my_info()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=\db("info")->where("status=1 and u_id=$uid")->order("id desc")->select();
            if($res){
                $arrs=array();
                $url=parent::getUrl();
                foreach ($res as $k => $v){
                    $user=\db("user")->where("uid=$uid")->find();
                    $arrs[$k]['id']=$v['id'];
                    $arrs[$k]['phone']=$v['phone'];
                    $arrs[$k]['username']=$user['nickname'];
                    $arrs[$k]['title']=$v['title'];
                    $arrs[$k]['time']=$v['addtime'];
                    $arrs[$k]['content']=$v['content'];
                    $arrs[$k]['headimage']=$user['image'];
                    $imgs=$v['imgs'];
                    $imgss=\explode(",", $imgs);
                    foreach ($imgss as $kk => $vv){
                        $arrs[$k]['image'][$kk]=$url.$vv;
                    }
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
    public function save_msg()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $content=\input('content');
            $data['uid']=$uid;
            $data['content']=$content;
            $data['time']=\time();
            $re=db("message")->insert($data);
            if($re){
                $arr=[
                    'error_code'=>0,
                    'data'=>"提交成功"
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>"提交失败"
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>"没有登录"
            ];
        }
        echo \json_encode($arr);
    }
    public function my_msg()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $res=db("message")->where("status != 0 and uid=$uid")->order("id desc")->select();
            if($res){
                $arr=[
                    'error_code'=>0,
                    'data'=>$res
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>"暂无数据"
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'data'=>"没有登录"
            ];
        }
        echo \json_encode($arr);
    }
    //常见问题
    public function problem()
    {
        $re=db("lb")->field("desc")->where("fid=4")->find();
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
    
    
    
    
    
    
    
    
    
    
    
    
    
}