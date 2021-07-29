<?php
namespace app\common\model;
use think\Model;

class Admin extends Model
{   
	    /**
     * 用户登录
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool   成功返回true，失败返回false。
     */
    static public function login($username, $password)
    {   
        // 验证用户是否存在
        $map = array('username' => $username);
        $Admin = self::get($map);
        
        if (!is_null($Admin)) {
            // 验证密码是否正确
            if ($Admin->checkPassword($password)) {
                // 登录
                session('AdminId', $Admin->getData('id'));
                return true;
            }
        }
        return false;
    }

    /**
     * 验证密码是否正确
     * @param  string $password 密码
     * @return bool           
     */
    public function checkPassword($password)
    {
        if ($this->getData('password') === $password)
        {
            return true;
        } else {
            return false;
        }
    }
     static public function logOut()
    {
        // 销毁session中数据
        session('AdminId', null);
        return true;
    }
        /**
     * 判断用户是否已登录
     * @return boolean 已登录true
     * @author  panjie <panjie@yunzhiclub.com>
     */
    static public function isLogin()
    {
        $AdminId = session('AdminId');
                // isset()和is_null()是一对反义词
           
        if (isset($AdminId)) {
            return true;
        } else {
            return false;
        }
    }
        

}