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
            //验证码
            $new=new Admin();
            $retu=$new->login($data);
            $this->checkCode($data['code']);
            if($retu==1){
                $this->error('该用户不存在！');
            }
            if($retu==2){
                $this->success('登录成功！',url('Index/index'));
            }
            if($retu==3){
                $this->error('用户名或密码错误！');
            }

        }

        return view('login');
    }

    public function checkCode($code='')
    {
        if (!captcha_check($code)) {
            $this->error('验证码错误');
        } else {
            return true;
        }
    }
}
