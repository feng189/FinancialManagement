<?php
namespace app\index\controller;     
use think\Controller;
use app\common\model\Detail;
use think\Request;
use app\common\model\Subject;
use think\Db;
use app\common\model\User;
class AddController extends IndexController
{
    public function index()
    {   
    	$postData =Request::instance()->post();
    	if($postData)
    	{
    	  $subject =(int)$postData['subject'];
    	  $choose =$postData['choose'];
        }
        else
        {
          $subject=1;
          $choose=0;
        }
        $UserId= session('UserId');

    	$User= User::get($UserId);
        
        $Subjects = Db::name('subject')->select();
        $this->assign('User',$User);
        $this->assign('Subjects',$Subjects);
        $this->assign('sub',$subject);
        $this->assign('choose',$choose);
        return $this->fetch();
    }
    public function save()
    {
        $postData = Request::instance()->post();

        

        $Detail = new Detail;
        $Detail->user_id= session('UserId');
        $Detail->subject = (int)$postData['subject'];
        $Detail->lender = $postData['lender'];
        $Detail->borrower=$postData['borrower'];
        $Detail->money = (double)$postData['money'];
        $Detail->ps= $postData['ps']; 

        $result= $Detail->validate()->save();

        if (false === $result)
        {   
            // 验证未通过，发生错误
            $message = '新增失败:' . $Detail->getError();
            return $this->error($message);
        } else {
            // 提示操作成功，并跳转至管理列表
            return $this->success('新增成功。', url('index'));
        }    
        
    }
}

