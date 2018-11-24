<?php

namespace app\index\controller;

class Page extends Common
{
    public function index()
    {
        $cates=db('cate')->find(input('cateid'));
        $this->assign(array(
            'cates'=>$cates,
        ));
        return view('page');
    }
}
