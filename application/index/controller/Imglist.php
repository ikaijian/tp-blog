<?php

namespace app\index\controller;

use app\index\model\Article;
class Imglist extends Common
{
    public function index()
    {

        $article=new Article();
        $cateid=input('cateid');
        $artRes=$article->getAllArticles($cateid);
        $this->assign(array(
            'artRes'=>$artRes,
        ));
        return view('imglist');
    }
}
