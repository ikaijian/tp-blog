<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;

class Cate extends Common
{
    //可以为某个或者某些操作指定前置执行的操作方法
    protected $beforeActionList = [
        // 'first',    //先执行该法方法
        // 'second' =>  ['except'=>'hello'],  //除了hello法方，
        'delsoncate'  =>  ['only'=>'del'],    //当执行del法方，先执行delsoncate法方
    ];

    public function lst()
    {

        //模型
        $cate = new CateModel();
        if(request()->isPost()){
            $sorts=input('post.');
//            dump($sorts);die;
            foreach ($sorts as $k => $v) {
                $cate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功！',url('Cate/lst'));
            return;
        }
        $cateres = $cate->cateTrees();
        $this->assign('cateres', $cateres);
        return view();
    }

    public function add()
    {
        $cate = new CateModel();
        if (request()->isPost()) {
        $data=input('post.');
        $addNum=$cate->save($data);
            if($addNum){
                $this->success('添加栏目成功！',url('lst'));
            }else{
                $this->error('添加栏目失败！');
            }
        }
        $cateres=$cate->catetrees();
        $this->assign('cateres',$cateres);
        return view();
    }

    public function edit()
    {
        $cate = new CateModel();
        if(request()->isPost()) {
            $data = input('post.');
            $save=$cate->save($data,['id'=>$data['id']]);
            if($save !== false){
                $this->success('修改栏目成功！',url('Cate/lst'));
            }else{
                $this->error('修改栏目失败！');
            }
            return;
        }
        $cateres=$cate->catetrees();
        $cateId=input('id');
        $cateNum=$cate->find($cateId);
        $this->assign(array(
            'cateres'=>$cateres,
            'cateNum'=>$cateNum,
        ));
        return view();
    }

    public function del()
    {
        $data=input('id');
        $del=db('cate')->delete($data);
        if($del){
            $this->success('删除栏目成功！',url('lst'));
        }else{
            $this->error('删除栏目失败！');
        }
    }

    public function delsoncate()
    {
        $cateid=input('id'); //要删除的当前栏目的id
        $cate=new CateModel();
        $sonids=$cate->getchildrenid($cateid);
//        dump($sonids);die;
        //删除栏目时同时删除该栏目的文章
        $allCateId= $sonids;
        $allCateId[]=$cateid;
        foreach ($allCateId as $k=>$v){
            $article=new ArticleModel();
            $article->where(array('cateid'=>$v))->delete();
        }
        //end删除栏目时同时删除该栏目的文章
        if($sonids){
            db('cate')->delete($sonids);
        }
    }
}
