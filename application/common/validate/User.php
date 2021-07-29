<?php
namespace app\common\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
    	'name'  => 'require|length:2,25',
    	'username'  => 'require|unique:user|unique:admin|length:2,25',
    	'password'  => 'require|length:2,25',
    ];
}