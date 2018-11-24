<?php

namespace app\admin\controller;

use app\admin\model\AuthGroupAccess;
use think\Controller;
//use  think\Db;
use app\admin\model\Admin as AdminModel;
use think\Loader;

class Admin extends Common
{
    public function lst()
    {
        //同样有三种法方
//        $res=db('admin')->select();
//        $res=db('admin')->field('name,password')->select();
//        $res=db('admin')->where('id',1)->select();

        //管理员分配用户
        $auth=new Auth();
        $group=$auth->getGroups(session('id'));
//        dump($group);die;
        //模型
        $new = new AdminModel();
//        $res=$new->select();
        $adminres = $new->getadmin();
//        dump($adminres);die;
        foreach ($adminres as $k => $v) {
            $_groupTitle=$auth->getGroups($v['id']);
            $groupTitle=$_groupTitle[0]['authgroup'];
            $v['groupTitle']=$groupTitle;
        }

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

            $validate = Loader::validate('Admin');
            if (!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            $new = new AdminModel();
            $res = $new->addadmin($data);
            if ($res) {
                $this->success('新增管理员成功', url('lst'));
            } else {
                $this->error('新增管理员失败', url('add'));
            }
            return;
        }
        $authGroupRes=db('auth_group')->select();
        $this->assign('authGroupRes',$authGroupRes);
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

            $validate = Loader::validate('Admin');
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
            }
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

        //管理员组分配
        $newGroupAccess=new AuthGroupAccess();
        $authGroupAccess=$newGroupAccess->where('uid',$id)->find();
//        dump($authGroupAccess['group_id']);die;
        $authGroupRes=db('auth_group')->select();
        $this->assign([
            'admin'=>$admins,
            'groupId'=>$authGroupAccess['group_id'],
            'authGroupRes'=>$authGroupRes,
        ]);
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

    //退出登陆
    public function logout()
    {
        session(null);
        $this->success('退出系统成功',url('Login/index'));
    }
}
