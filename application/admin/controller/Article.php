<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;

class Article extends Common
{
    public function lst()
    {
        $cate=new CateModel();
        $artres=$cate->catetrees();
        $this->assign('artres',$artres);
        return view();
    }

    public function add()
    {
        $cate=new CateModel();
        $cateres=$cate->catetrees();
        $this->assign('cateres',$cateres);
        return view();
    }

    public function edit()
    {

        return view();
    }

    public function del()
    {

    }

}
