<?php
// +----------------------------------------------------------------------
// | ThinkPHP 5 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 .
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 黎明晓 <lmxdawn@gmail.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;


/**
 * Class Base 基础控制器
 * @package app\admin\controller
 */
class Upload extends Controller
{


    public function images(){

        $data = self::file('image',['size'=>15678,'ext'=>'jpg,png,gif']);

        //dump($data);exit;

        $this->result($data,1,'上传图片','json');

    }


    /**
     * 上传多个文件
     */
    protected static function files($name = '',$config = ['size'=>15678,'ext'=>'jpg,png,gif']){
        // 获取表单上传文件 例如上传了001.jpg
        $files = request()->file($name);
        //dump($file);exit;
        // 移动到框架应用根目录/public/uploads/ 目录下
        $path = ROOT_PATH . 'public' . DS . 'uploads';
        foreach($files as $file){
            $info = $file->validate($config)->move($path);
            $data['src'] = '';
            $data['title'] = '';
            $data['msg'] = '上传成功！';
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $data['ext'] = $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $data['title'] = $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                $data['file_name'] = $info->getFilename();
            }else{
                // 上传失败获取错误信息
                $data['msg'] = $file->getError();
            }
        }

        return $data;
    }

    /**
     * 上传单个文件
     */
    protected static function file($name = '',$config = ['size'=>15678,'ext'=>'jpg,png,gif']){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($name);
        //dump($file);exit;
        // 移动到框架应用根目录/public/uploads/ 目录下
        $path = ROOT_PATH . 'public' . DS . 'uploads';
        $info = $file->validate($config)->move($path);
        $data['src'] = '';
        $data['title'] = '';
        $data['msg'] = '上传成功！';
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            $data['ext'] = $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $data['src'] = $path.'/'.$data['title'];
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            $data['file_name'] = $info->getFilename();
        }else{
            // 上传失败获取错误信息
            $data['msg'] = $file->getError();
        }

        return $data;
    }

}