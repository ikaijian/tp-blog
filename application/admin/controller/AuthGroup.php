<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule;
use think\Loader;

class AuthGroup extends Common
{

    public function lst()
    {
        $authGroupNum = AuthGroupModel::paginate(2);
        $this->assign('authGroupRes', $authGroupNum);
        return view();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            //权限列表
            if($data['rules']){
                //将数组转化成字符串
                $data['rules']=implode(',',$data['rules']);
            }
//            dump($data);die;
            $authGroupSave = db('auth_group')->insert($data);
            if ($authGroupSave) {
                $this->success('添加用户组成功！', url('AuthGroup/lst'));
            } else {
                $this->error('添加用户组失败！');
            }
            return;
        }
        $authRule=new AuthRule();
        $authRuleRes=$authRule->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
        return view();
    }

    public function edit()
    {
        //注意复选框的数据提交情况:只有选中才有数据提交，
        if (request()->isPost()) {
            $data = input('post.');
//            dump($data);die;
            if($data['rules']){
                //将数组转化成字符串
                $data['rules']=implode(',',$data['rules']);
            }

            $dataArr = array();
            foreach ($data as $k => $v) {
                $dataArr[] = $k;
            }
//            dump($dataArr);die;
            if (!in_array('status', $dataArr)) {
                $data['status'] = 0;
            }
            $newGroup = new AuthGroupModel();
            $authGroupSave = $newGroup->update($data);
            if ($authGroupSave !== false) {
                $this->success('修改用户组成功！', url('AuthGroup/lst'));
            } else {
                $this->error('修改用户组失败！');
            }
            return;
        }

        $authgroups = db('auth_group')->find(input('id'));

        //权限
        $authRule=new AuthRule();
        $authRuleRes=$authRule->authRuleTree();
        $this->assign([
            'authgroups'=>$authgroups,
            'authRuleRes'=>$authRuleRes
        ]);
        return view();
    }

    public function del()
    {
        $data = input('id');
        $del = db('auth_group')->delete($data);
        if ($del) {
            $this->success('删除用户组成功！', url('lst'));
        } else {
            $this->error('删除用户组失败！');
        }
    }

}
