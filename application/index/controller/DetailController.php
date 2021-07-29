<?php
namespace app\index\controller;     
use think\Controller;
use app\common\model\Detail;
use think\Request;
use app\common\model\Subject;
use think\Db;
use app\common\model\User;

class DetailController extends IndexController
{
    public function index()
    {
        
        $op = Request::instance()->param('op/d');
        $sub_id = Request::instance()->param('subject/d');
        //分页数目
    	$pageSize= 3;

    	$UserId= session('UserId');

    	$User= User::get($UserId);
        // 实例化
    	$detail = new Detail;

    	if($sub_id) 
    	{ $map['subject']=$sub_id;
          $Subject =Subject::get($sub_id);
        }
        else  {
        	$Subject = new Subject;
        	$Subject->name = "总";
        }
        
        $map['user_id']=$UserId;
        if($op===1){
        $map['create_time']  = ['>',strtotime('-7 days')];
        }
        elseif ($op===2) {
        	$map['create_time']  = ['>',strtotime('-1 months')];
        }
        elseif ($op===2) {
        	$map['create_time']  = ['>',strtotime('-1 years')];
        }

         
        // 按条件查询数据并调用分页
        
    	$details= $detail->where($map)->paginate($pageSize, false); 
        
        $lendNum=0.00;
        $borrowNum=0.00;
        $sum=0.00;
        foreach ($details as  $detail) {
        	if($detail['lender']===$User->name)
        	{
        		$lendNum+=$detail['money'];
        	}
        	else{
        		$borrowNum+=$detail['money'];
        	}
        }
        $sum=$borrowNum - $lendNum;


    	$Subjects = Db::name('subject')->select();
        $this->assign([
          'sum' =>$sum,
          'lendNum'=>$lendNum,
          'borrowNum'=>$borrowNum,
          'User'=>$User,
          'op'=>$op,
          'Subjects'=>$Subjects,
          'sub'=>$sub_id,
          'Subject1'=>$Subject,
          'details'=>$details,
        ]);

        // 将数据返回给用户
        return $this->fetch();
        
    }
    
}

