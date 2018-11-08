<?php

namespace app\admin\controller;

use think\Controller;
//use  think\Db;
use app\admin\model\Admin as AdminModel;

class Admin extends Common
{
    public function lst()
    {
        //同样有三种法方
//        $res=db('admin')->select();
//        $res=db('admin')->field('name,password')->select();
//        $res=db('admin')->where('id',1)->select();

        //模型
        $new = new AdminModel();
//        $res=$new->select();
        $adminres = $new->getadmin();
        $this->assign('adminres', $adminres);
        return view();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            //第一种：助手函数
//            $res=db('admin')->insert($data);
            //第二种：查询构造器
//            $res=Db::name('admin')->insert($data);
//            $res=Db::table('blog_admin')->insert($data);
            //第三种：通过模型
            $new = new AdminModel();
            $res = $new->addadmin($data);
            if ($res) {
                $this->success('新增管理员成功', url('lst'));
            } else {
                $this->error('新增管理员失败', url('add'));
            }
            return;
        }
        return view();
    }

    public function edit($id)
    {
        $admins = db('admin')->find($id);
        if(request()->isPost()){
            $data=input('post.');
//            if(!$data['name']){
//                $this->error('管理员用户名不得为空！');
//            }
//            if(!$data['password']){
//                $data['password']=$admins['password'];
//            }else{
//                $data['password']=md5($data['password']);
//            }
//            $res=db('admin')->update($data);
            //通过模型
            $new=new AdminModel();
//            $res=$new->save($data,$admins);
            $saveNum=$new->saveadmin($data,$admins);
            if($saveNum == '2'){
                $this->error('管理员用户名不得为空！');
            }
            if ($saveNum !==false) {
                $this->success('修改管理员成功', url('lst'));
            } else {
                $this->error('修改管理员失败');
            }
            return;
        }

        if (!$admins) {
            $this->error('该管理不存在');
        }
        $this->assign('admin', $admins);
        return view();
    }

    public function del($id)
    {
        $new=new AdminModel();
        $delNum=$new->delAdmin($id);
        if($delNum == '1'){
            $this->success('删除管理员成功！',url('lst'));
        }else{
            $this->error('删除管理员失败！');
        }
    }
    public function logout()
    {
        session(null);
        $this->success('退出系统成功',url('Login/index'));
    }
}
