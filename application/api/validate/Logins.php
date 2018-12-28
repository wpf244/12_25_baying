<?php
namespace app\api\validate;

use think\Validate;

class Logins extends Validate
{
    protected $rule = [
        'phone'     => ['/^1[3456789]\d{9}$/'],
        'pwd'       => ['length:6,20'],
    ];
    protected $message = [
        'phone'     => '手机号格式不正确',
        'pwd'       => '密码长度6-20位',
    ];

}