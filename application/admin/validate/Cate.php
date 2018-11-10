<?php

namespace app\admin\validate;

use think\Validate;

class Cate extends Validate
{

    protected $rule=[
        'cate_name'=>'unique:cate|require|max:25',
    ];


    protected $message=[
        'cate_name.require'=>'栏目名称不得为空！',
        'cate_name.unique'=>'栏目名称不得重复！',
        'cate_name.max'=>'栏目长度不能超过 25！',
    ];
    protected $scene = [
//        可以添加指定的规则
        'add'=>['cate_name'],
        'edit'=>['cate_name'],
    ];

}