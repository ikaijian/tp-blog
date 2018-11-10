<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Link as LinkModel;
use think\Loader;

class Link extends Common
{

    public function lst()
    {
        $link = new LinkModel();
        if (request()->isPost()) {
            $sorts = input('post.');
            foreach ($sorts as $k => $v) {
                $link->update(['id' => $k, 'sort' => $v]);
            }
            $this->success('更新排序成功！', url('Link/lst'));
            return;
        }
        $linkres = $link->paginate(2);
        $this->assign('linkres', $linkres);
        return view();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            //验证提交数据
            $validate = Loader::validate('Link');
            if (!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            $new = new LinkModel();
            $linkNum = $new->save($data);
            if ($linkNum) {
                $this->success('添加友情链接成功！', url('lst'));
            } else {
                $this->error('添加友情链接失败！');
            }
        }
        return view();
    }

    public function edit()
    {
        $new = new LinkModel();
        if (request()->isPost()) {
            $data = input('post.');
            $validate = Loader::validate('Link');
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
            }
            $save = $new->save($data, ['id' => $data['id']]);
            if ($save !== false) {
                $this->success('修改链接成功！', url('Link/lst'));
            } else {
                $this->error('修改链接失败！');
            }
            return;
        }
        $linkId = input('id');
        $links = $new->find($linkId);
        $this->assign('links', $links);
        return view();
    }

    public function del()
    {
        $id = input('id');
        $LinkDel = LinkModel::destroy($id);
        if ($LinkDel) {
            $this->success('删除链接成功！', url('lst'));
        } else {
            $this->error('删除链接失败！');
        }
    }

}
