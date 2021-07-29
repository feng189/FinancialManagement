<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\common\model\User;
use app\common\model\Admin;
class LoginController extends Controller
{
    // 用户登录表单
    public function index()
    {
         return $this->fetch();
    }

    // 处理用户提交的登录数据
    public function login()
    {
        // 接收post信息
        $postData = Request::instance()->post();

        // 验证用户名是否存在
        $map = array('username'  => $postData['login']);
        $User = User::get($map);
        $tag=1;
        if(is_null($User)){
            $User = Admin::get($map);
            $tag=2;
            
        }
        // $User要么是一个对象，要么是null。
        if (!is_null($User) && $User->getData('password') === $postData['pwd'])
         {
            // 用户名密码正确，将userId存session，并跳转至用户界面
           
            if($tag===1){
                        session('tag',1);
                         session('UserId', $User->getData('id'));
                        return $this->success('登录成功', url('account/index'));
                    }
            if($tag===2){
                        session('tag',2);
                        session('AdminId', $User->getData('id'));
                        return $this->success('登录成功', url('User/index'));
                    }
        }
         else 
        {
            // 用户名不存在，跳转到登录界面。
            return $this->error('用户名或密码错误', url('index'));
        }
    }
    
    // 注销
    public function logOut()
    {
        if (User::logOut()) 
        {
            return $this->success('logout success', url('index'));
        } else
         {
            return $this->error('logout error', url('index'));
        }
    }
}