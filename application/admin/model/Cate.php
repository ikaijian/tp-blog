<?php

namespace app\admin\model;

use think\Model;

class Cate extends Model
{
    public function cateTrees()
    {
        $cateres = $this->order('sort desc')->select();
//        return $cateres;
        return $this->sort($cateres);
    }

    public function sort($data, $pid = 0, $level = 0)
    {
        static $arr = array();
        foreach ($data as $k => $v) {
//            dump($v);die;
            if ($v['pid'] == $pid) {
                $v['level'] = $level;
                $arr[] = $v;
                //递归思想
                $res = $this->sort($data, $v['id'], $level + 1);
            }
        }
        return $arr;
    }

    public function getchildrenid($cateid)
    {
        $cateres = $this->select();
        return $this->_getchildrenid($cateres, $cateid);
    }

    public function _getchildrenid($cateres, $cateid)
    {
        static $arr = array();
        foreach ($cateres as $k => $v) {
            if ($v['pid'] == $cateid) {
                $arr[] = $v['id'];
                //递归
                $this->_getchildrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }

}