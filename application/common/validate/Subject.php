<?php
namespace app\common\validate;
use think\Validate;

class Subject extends Validate
{
    protected $rule = [
    	'name'  => 'require|length:2,25',
    ];
}