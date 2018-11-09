<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;

class Article extends Common
{
    public function lst()
    {
        $artres = db('article')->field('a.*,b.cate_name')->alias('a')->join('blog_cate b','a.cateid=b.id')->paginate(2);
        $this->assign('artres', $artres);
        return view();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data['time'] = time();
//            dump($data);die;
            $article = new ArticleModel();

//            //图片上传  控制器层处理（注意必须给文件上传表单添加属性:enctype="multipart/form-data"）
//            if ($_FILES['thumb']['tmp_name']) {
//                // 获取表单上传文件 例如上传了001.jpg
//                $file = request()->file('thumb');
//                // 移动到框架应用根目录/public/uploads/ 目录下
//                if ($file) {
//                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//                    if ($info) {
//                        $thumb = 'http://www.tp.blog.com' . DS . 'uploads' . '/' . $info->getSaveName();
//                        $data['thumb'] = $thumb;
//                    }
//                }
//            }

            //图片上传2 ，在模型层实现上传（通过模型的事件（钩子）执行） 注意：必须用模型进行添加操作
            //不可以使用其他法方：例如： db('article')->insert($data)进行插入
            $articleNum = $article->save($data);
            if ($articleNum) {
                $this->success('添加文章成功', url('lst'));
            } else {
                $this->error('添加文章失败！');
            }
            return;

        }
        $cate = new CateModel();
        $cateres = $cate->catetrees();
        $this->assign('cateres', $cateres);
        return view();
    }

    public function edit()
    {
        if(request()->isPost()){
            $data=input('post.');
            $new=new ArticleModel();
            $articleNum=$new->update($data);
//            dump($articleNum);die;
            if($articleNum){
                $this->success('修改文章成功！',url('Article/lst'));
            }else{
                $this->error('修改文章失败！');
            }
            return;
        }

        $cate = new CateModel();
        $cateres = $cate->catetrees();
        $article=db('article')->where(array('id'=>input('id')))->find();
        $this->assign(array(
            'cateres'=>$cateres,
            'article'=>$article,
        ));
        return view();
    }

    public function del()
    {
        $articleDel=ArticleModel::destroy(input('id'));
        if($articleDel){
            $this->success('删除文章成功！',url('lst'));
        }else{
            $this->error('删除文章失败！');
        }
    }

}
