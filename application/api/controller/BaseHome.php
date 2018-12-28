<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
class BaseHome extends Controller{
    public function _initialize(){
         $token=Request::instance()->header('token');
         if($token != '50a00a9b8d3402ed4f1b3ed4b890294b'){
             $arrs=[
                 'error_code'=>500,
                 'data'=>'token验证失败'
             ];
             echo \json_encode($arrs);exit;
         }
         
    }
    public function getUrl(){
        $request = Request::instance();
         
        $url=$request->domain();
        return $url;
    }
    /**
     *这里最重要
     * 数据转换 stdClass Object转array
     * @access public
     */
    public function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        }
        if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] =self::object_array($value);
            }
        }
        return $array;
    }
}