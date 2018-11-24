<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    public function addadmin($data)
    {
        if (empty($data) || !is_array($data)) {
            return false;
        }
        if ($data['password']) {
            $data['password'] = md5($data['password']);
        }
// 过滤post数组中的非数据表字段数据allowField(true)
        $res = $this->allowField(true)->save($data);
        if ($res) {
            $groupAccess['uid']=$this->id;
            $groupAccess['group_id']=$data['group_id'];
            $newGroupAccess=new AuthGroupAccess();
            $newGroupAccess->save($groupAccess);
            return true;
        } else {
            return false;
        }
    }

    public function getadmin()
    {
        return $this::paginate(2);
    }

    public function saveadmin($data, $admins)
    {
        if (!$data['name']) {
            //管理员用户名不得为空！
            return 2;
        }
        if (!$data['password']) {
            $data['password'] = $admins['password'];
        } else {
            $data['password'] = md5($data['password']);
        }
//        dump($data);die;
        $newGroupAccess=new AuthGroupAccess();

        $newGroupAccess->where(array('uid'=>$data['id']))->update(['group_id'=>$data['group_id']]);
//        return $this::update($data, $admins);
        return $this::update(['name'=>$data['name'],'password'=>$data['password']],['id'=>$data['id']]);
    }

    public function delAdmin($id)
    {
        $res = $this::destroy($id);
        if ($res) {
            return 1;
        } else {
            return 2;
        }
    }

    public function login($data)
    {
        $adminNum = Admin::get(['name'=>$data['name']]);
//        dump($adminNum);die;
        if ($adminNum) {
            if ($adminNum['password'] == md5($data['password'])) {
                session('id', $adminNum['id']);
                session('name',$adminNum['name']);
                return 2; //登陆密码正确情况
            }else{
                return 3; //登录密码错误情况
            }
        } else {
            return 1; //用户不存在的情况
        }
    }


}