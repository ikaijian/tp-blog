<?php

namespace app\index\controller;

use app\index\model\Article;
class Artlist extends Common
{
    public function index()
    {
        $article=new Article();
        $cateid=input('cateid');
        $artRes=$article->getAllArticles($cateid);
        $hotRes=$article->getHotRes($cateid);
        $this->assign(array(
            'artRes'=>$artRes,
            'hotRes'=>$hotRes,
        ));
        return view('artlist');
    }
}
