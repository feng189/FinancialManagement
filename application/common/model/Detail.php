<?php
namespace app\common\model;
use think\Model;
use app\common\model\Subject;
class Detail extends Model
{   
	static public function getName($Subject_id)
	{ 
         $Subject =Subject::get($Subject_id);
         
         return $Subject->data['name'];
	} 

}