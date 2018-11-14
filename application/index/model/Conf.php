<?php
namespace app\index\model;
use think\Model;

class Conf extends Model{
    public function getAllConf()
    {
        $confres=$this->field('en_name,cn_name')->select();
        return $confres;
    }
}