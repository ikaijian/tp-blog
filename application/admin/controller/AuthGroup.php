<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\AuthGroup as AuthGroupModel;
use think\Loader;

class AuthGroup extends Common
{

    public function lst()
    {
        $authGroupNum=AuthGroupModel::paginate(2);
        $this->assign('authGroupRes',$authGroupNum);
        return view();
    }

    public function add()
    {
        if(request()->isPost()){
            $data=input('post.');
            $authGroupSave=db('auth_group')->insert($data);
            if($authGroupSave){
                $this->success('添加用户组成功！',url('AuthGroup/lst'));
            }else{
                $this->error('添加用户组失败！');
            }
            return;
        }

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
