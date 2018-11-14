<?php

namespace app\index\controller;

use app\index\model\Conf;
use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
       $newConf=new Conf();

       //获取到数据的是二维数组
       $confArr=$newConf->getAllConf();
//        dump($confArr);die;
       //重组该数组成一维数组
        https://github.com/kevinyan815/laravel_best_practices_cn/tree/master/src/CodeConvention=array();
        foreach($confArr as $k=>$v){
//            echo $k.$v;
            $confres[$v['en_name']]=$v['cn_name'];
        }
//       dump($confres);die;
       $this->assign('confres',$confres);

    }
}
