<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
  protected static function init()
  {
     Article::event('before_insert',function ($data){
//         dump($data);die;
         if ($_FILES['thumb']['tmp_name']) {
             // 获取表单上传文件 例如上传了001.jpg
             $file = request()->file('thumb');
             // 移动到框架应用根目录/public/uploads/ 目录下
             if ($file) {
                 $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                 if ($info) {
                     $thumb = DS . 'uploads' . '/' . $info->getSaveName();
                     $data['thumb'] = $thumb;
                 }
             }
         }
//         die;   //中断入库，测试是否入库时先上传图片
     });

      Article::event('before_update',function ($data){
//          echo 1111;die;
          if ($_FILES['thumb']['tmp_name']) {
              //获取之前的缩略图
              $articles=Article::find($data->id);
//              echo $_SERVER['DOCUMENT_ROOT'];die;
              $thumbpath=$_SERVER['DOCUMENT_ROOT'].$articles['thumb'];
//              dump($thumbpath);die;
              if(file_exists($thumbpath)){
                  unlink($thumbpath);
              }
              // 获取表单上传文件 例如上传了001.jpg
              $file = request()->file('thumb');
              // 移动到框架应用根目录/public/uploads/ 目录下
              if ($file) {
                  $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                  if ($info) {
                      $thumb = DS . 'uploads' . '/' . $info->getSaveName();
                      $data['thumb'] = $thumb;
                  }
              }
          }
//         die;   //中断入库，测试是否入库时先上传图片
      });

      Article::event('before_delete',function ($data){
          $articles=Article::find($data->id);
//              echo $_SERVER['DOCUMENT_ROOT'];die;
          $thumbpath=$_SERVER['DOCUMENT_ROOT'].$articles['thumb'];
          if(file_exists($thumbpath)){
              unlink($thumbpath);
          }
      });
  }
}