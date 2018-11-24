<?php
namespace app\index\model;

use think\Model;
use app\index\model\Cate;

class Article extends Model{
    public function getAllArticles($cateid){
        $cate=new Cate();
        $allCateID=$cate->getchilrenid($cateid);
        $artRes=db('article')->where("cateid IN($allCateID)")->order('id desc')->paginate(3);
        return $artRes;
    }

    //热点文章
    public function getHotRes($cateid){
        $cate=new Cate();
        $allCateID=$cate->getchilrenid($cateid);
        $artRes=db('article')->where("cateid IN($allCateID)")->order('click desc')->limit(5)->select();
        return $artRes;
    }
}