<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin;

class Login extends Controller
{
    public function index()
    {
        if (request()->isPost()){
            $data=input('post.');
            $new=new Admin();
            $retu=$new->login($data);
            if($retu==1){
                $this->error('该用户不存在！');
            }
            if($retu==2){
                $this->success('登录成功！',url('index/index'));
            }
            if($retu==3){
                $this->error('用户名或密码错误！');
            }
        }
        return view('login');
    }
}
