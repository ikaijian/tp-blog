<?php

namespace app\admin\controller;

use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
        if (!session('id') || !session('name')) {
            $this->error('你尚未登陆系统', url('Login/index'));
        }
    }
}
