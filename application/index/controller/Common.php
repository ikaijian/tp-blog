<?php

namespace app\index\controller;

use app\index\model\Conf;
use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
       $newConf=new Conf();
       $confres=$newConf->getAllConf();
       dump($confres);die;
       $this->assign('confres',$confres);

    }
}
