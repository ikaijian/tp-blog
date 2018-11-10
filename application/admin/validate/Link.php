<?php

namespace app\admin\validate;

use think\Validate;

class Link extends Validate
{

    protected $rule = [
        'title' => 'unique:link|require|max:25',
        'url' => 'url|unique:link|require',
        'desc' => 'require|max:225',
    ];

    protected $message = [
        'title.require' => '链接标题不得为空！',
        'title.unique' => '链接标题不得重复！',
        'title.max' => '链接标题长度大的大于25个字符！',
        'url.unique' => '链接地址不得重复！',
        'url.require' => '链接地址不得为空！',
        'url.url' => '链接地址格式不正确！',
        'desc.require' => '链接描述必须填写',
        'desc.max' => '链接描述最多不能超过225个字符',
    ];
    protected $scene = [
//        可以添加指定的规则
        'add' => ['title', 'url', 'desc'],
        'edit'=>['title','url'],
    ];

}