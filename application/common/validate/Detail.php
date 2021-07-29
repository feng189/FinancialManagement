<?php
namespace app\common\validate;
use think\Validate;

class Detail extends Validate
{
    protected $rule = [
    	'lender'  => 'require|length:2,25',
    	'borrower'  => 'require|length:2,25',
    	'subject'=> 'require',
    	'money'=> 'require',
    	'user_id'=>'require',
    ];
}