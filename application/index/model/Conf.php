<?php
namespace app\index\model;
use think\Model;

class Conf extends Model{
    public function getAllConf()
    {
        $confres=$this->select();
        return $confres;
    }
}