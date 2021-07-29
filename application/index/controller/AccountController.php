<?php
namespace app\index\controller;     
use think\Controller;
use app\common\model\Subject;
use app\common\model\Detail;
use think\Db;
use think\Request;
use app\common\model\User;
use app\common\model\Admin;
class AccountController extends IndexController
{
    public function index()
    {
        $Subjects = Db::name('subject')->select();
        $details = Db::name('detail')->select();
        $UserId= session('UserId');

    	$User= User::get($UserId);

        $lendNum=0.00;
        $borrowNum=0.00;
        $sum=0.00;
        foreach ($details as  $detail) {
        	if($detail['user_id']===$UserId &&   $detail['lender']===$User->name)
        	{
        		$lendNum+=$detail['money'];
        	}
        	elseif($detail['user_id']===$UserId &&  $detail['borrower']===$User->name)
        	{
        		$borrowNum+=$detail['money'];
        	}
        }
        $sum=$borrowNum - $lendNum;

        $this->assign([
          'User'=>$User,
          'sum' =>$sum,
          'lendNum'=>$lendNum,
          'borrowNum'=>$borrowNum,
          'Subjects'=>$Subjects,
        ]);
        return $this->fetch();
    }

    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        $Subjects = Db::name('subject')->select();

        // 在表模型中获取当前记录
        $tag=session('tag');
        if($tag===1)
        {
        	$User = User::get($id);
        }
        elseif ($tag===2) {
        	$User = Admin::get(session('AdminId'));
        }
        
        // 将数据传给V层
        $this->assign('tag', $tag);
        $this->assign('User', $User);
        $this->assign('Subjects',$Subjects);

        // 获取封装好的V层内容
        $htmls = $this->fetch();

        // 将封装好的V层内容返回给用户
        return $htmls;
    }

    //修改密码
    public function  update() {
        $UserId = input('post.id');
        $oldPassword = input('post.oldPassword');
        $password = input('post.password');
        $tag=session('tag');
        if($tag===1)
        { 
        	$User = User::get(session('UserId'));
        }
        elseif ($tag===2) {
        	$User = Admin::get(session('AdminId'));
        }
        if(is_null($User)) {
            return $this->error('未获取到任何用户');
        }
        $newPasswordAgain = input('post.newPasswordAgain');


        //判断旧密码是否正确
        
        if($oldPassword != $User->password) {
           return $this->error('旧密码错误', url('edit'));
        }

        //判断新旧密码是否一致
        if($oldPassword === $password) {
           return $this->error('新旧密码一致', url('edit'));
        }

        //判断两次新密码是否一致
         if($newPasswordAgain != $password) {
           return $this->error('两次输入的新密码不一致', url('edit'));
        }

        // 判断新密码位数是否符合标准
        if(strlen($password) < 6 || strlen($password)>25) {
            return $this->error('密码长度应为6到25之间', url('edit'));
        }

        $User->password=$password;
        if(!$User->save()) {
            return $this->error('密码更新失败', url('edit'));
        }
        session('id', null);
        return $this->success('修改成功，请重新登录', url('login/'));
    }

}

