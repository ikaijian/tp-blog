<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\AuthRule as AuthRuleModel;
use think\Loader;

class AuthRule extends Common
{

    public function lst()
    {
        $authRule=new AuthRuleModel();
        if(request()->isPost()){
            $sorts=input('post.');
            foreach ($sorts as $k => $v) {
                $authRule->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功！',url('lst'));
            return;
        }
        $authRuleRes=$authRule->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
        return view();
    }

    public function add()
    {
        if(request()->isPost()){
            $data=input('post.');
            $upLevel=db('auth_rule')->where(['id'=>$data['pid']])->field('level')->find();
//            dump($upLevel);die;
            if($upLevel){
                $data['level']=$upLevel['level']+1;
            }else{
                $data['level']=0;
            }
            $AddRule=db('auth_rule')->insert($data);
            if($AddRule){
                $this->success('添加权限成功！',url('AuthRule/lst'));
            }else{
                $this->error('添加权限失败！');
            }
            return;
        }
        $authRule=new AuthRuleModel();
        $authRuleRes=$authRule->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
        return view();
    }

    public function edit()
    {
        $authRule=new AuthRuleModel();
        if(request()->isPost()){
            $data=input('post.');
            $upLevel=db('auth_rule')->where(['id'=>$data['pid']])->field('level')->find();
//            dump($upLevel);die;
            if($upLevel){
                $data['level']=$upLevel['level']+1;
            }else{
                $data['level']=0;
            }
            $save=$authRule->save($data,['id'=>$data['id']]);
            if($save!==false){
                $this->success('修改权限成功！',url('lst'));
            }else{
                $this->error('修改权限失败！');
            }
            return;
        }

        $authRuleRes=$authRule->authRuleTree();
        $authRules=$authRule->find(input('id'));
        $this->assign(array(
            'authRuleRes'=>$authRuleRes,
            'authRules'=>$authRules,
        ));
        return view();
    }

    public function del()
    {
        $authRule=new AuthRuleModel();
        $authRuleIds=$authRule->getchilrenid(input('id'));
        $authRuleIds[]=input('id');
        $del= AuthRuleModel::destroy($authRuleIds);
        if($del){
            $this->success('删除权限成功！',url('AuthRule/lst'));
        }else{
            $this->error('删除权限失败！');
        }
    }

}
