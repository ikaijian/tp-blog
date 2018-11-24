<?php

namespace app\index\controller;

use app\index\model\Conf;
use think\Controller;
use app\index\model\Cate;

class Common extends Controller
{
    public function _initialize()
    {

        //网站导航栏
        $this->getNavCates();

//        网站配置项
        $this->getConf();

        //当前位置
        if(input('cateid')){
            $this->getPos(input('cateid'));
        }
        if(input('artid')){
            $articles=db('article')->field('cateid')->find(input('artid'));
            $cateid=$articles['cateid'];
            $this->getPos($cateid);
        }

    }

    //导航栏
    public function getNavCates(){
        $cateRes=db('cate')->where(array('pid'=>0))->select();
        foreach ($cateRes as $k => $v) {
            $children=db('cate')->where(array('pid'=>$v['id']))->select();
            if($children){
                $cateRes[$k]['children']=$children;
            }else{
                $cateRes[$k]['children']=0;
            }
        }
        $this->assign('cateRes',$cateRes);
    }

    //网站配置项
    public function getConf()
    {
        $newConf=new Conf();

        //获取到数据的是二维数组
        $confArr=$newConf->getAllConf();
//        dump($confArr);die;
        //重组该数组成一维数组
        foreach($confArr as $k=>$v){
//            echo $k.$v;
            $confres[$v['en_name']]=$v['cn_name'];
        }
//       dump($confres);die;
        $this->assign('confres',$confres);

    }

    //当前位置
    public function getPos($cateid){
        $cate= new Cate();
        $posArr=$cate->getparents($cateid);
        // dump($posArr); die;
        $this->assign('posArr',$posArr);
    }
}
