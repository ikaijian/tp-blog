<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Conf as ConfModel;
use think\Loader;

class Conf extends Common
{

    public function lst()
    {
        if (request()->isPost()) {
            $sorts = input('post.');
//            dump($sorts);die;
            $conf = new ConfModel();
            foreach ($sorts as $k => $v) {
                $conf->update(['id' => $k, 'sort' => $v]);
            }
            $this->success('更新排序成功！', url('Conf/lst'));
            return;
        }
       $confNum=ConfModel::order('sort desc')->paginate(2);
       $this->assign('confres',$confNum);
        return view();
    }

    public function add()
    {
        if(request()->isPost()){
            $data=input('post.');
//            dump($data);die;
            $validate=Loader::validate('Conf');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            if($data['values']){
                $data['values']=str_replace('，',',', $data['values']);
            }
            $confNew=new ConfModel();
            $confres=$confNew->save($data);
            if($confres){
                $this->success('添加配置成功！',url('Conf/lst'));
            }else{
                $this->error('添加配置失败！');
            }
        }


        return view();
    }

    public function edit()
    {
        if(request()->isPost()){
            $data=input('post.');
            $validate=Loader::validate('Conf');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            if($data['values']){
                $data['values']=str_replace('，',',', $data['values']);
            }
            $confNew=new ConfModel();
            $saveNum=$confNew->save($data,['id'=>$data['id']]);
            if($saveNum!==false){
                $this->success('修改配置成功！',url('Conf/lst'));
            }else{
                $this->error('修改配置失败！');
            }
        }
        $confs=ConfModel::find(input('id'));
        $this->assign('confs',$confs);
        return view();
    }

    public function del()
    {
        $data=(int)input('id');
        $delNum=ConfModel::destroy($data);
        if($delNum){
            $this->success('删除配置项成功！',url('Conf/lst'));
        }else{
            $this->error('删除配置项失败！');
        }
    }

    public function conf()
    {
        if(request()->isPost()){
            $data=input('post.');

//            dump($data);die;

            //问题一：如果复选框没有选中，表单就不会提交该复选框（导致不能修改数据表的值）
            //解决思路：对比表单你的所有值，在将该复选框的值清空
            $forForm=array();
            foreach ($data as $k => $v) {
                $forForm[]=$k;
            }
//            dump($forForm);die;
            $_arrconf=db('conf')->field('en_name')->select();
            $confarr=array();
            foreach ($_arrconf as $k => $v) {
                $confarr[]=$v['en_name'];
            }
//            dump($confarr);die;
            //比较表单提交数据和数据库里查询数据进行对比；交不在表单中数据组成数组
            $checkboxarr=array();
            foreach ($confarr as $k => $v) {
                if(!in_array($v, $forForm)){
                    $checkboxarr[]=$v;
                }
            }
//            dump($checkboxarr);die;
            if($checkboxarr){
                foreach ($checkboxarr as $ke => $v) {
                    ConfModel::where('en_name',$v)->update(['value'=>'']);
                }
            }


            if($data){
                foreach ($data as $k=>$v){
                    ConfModel::where('en_name',$k)->update(['value'=>$v]);
                }
            }
            $this->success('修改配置成功！');
            return;
        }
        $confres=ConfModel::order('sort desc')->select();
        $this->assign('confres',$confres);
        return view();
    }

}
