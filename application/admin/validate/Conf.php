<?php
namespace app\admin\validate;
use think\Validate;
class Conf extends Validate
{

    protected $rule=[
        'cn_name'=>'unique:conf|require|max:60',
        'en_name'=>'unique:conf|require|max:60',
        'type'=>'require',
    ];


    protected $message=[
        'cn_name.require'=>'中文名称不得为空！',
        'cn_name.unique'=>'中文名称不得重复！',
        'en_name.unique'=>'英文名称不得重复！',
        'en_name.require'=>'英文名称不得为空！',
        'cn_name.max'=>'中文名称不能大于60个字符！',
        'en_name.max'=>'英文名称不能大于60个字符！',
        'type.require'=>'配置类型不得为空！',
    ];

    protected $scene=[
        'edit'=>['cn_name','en_name'],
    ];






    

    




   

	












}
