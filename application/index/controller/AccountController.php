<?php
namespace app\index\controller;     
use think\Controller;

class AccountController extends Controller
{
    public function index()
    {
        
        return $this->fetch();
    }
}

