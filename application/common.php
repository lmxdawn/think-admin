<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

if (!function_exists('form_res')) {
    /**
     * 格式化数据
     * @param $code
     * @param $msg
     * @param array $data
     * @param string $error
     * @return \think\response\Json
     */
    function form_res($code = 200, $msg = '', $data = [], $error = 'success')
    {

        $res = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'error' => $error
        ];

        return json($res);
    }
}



if (!function_exists('sp_get_asset_static_path')) {
    /**
     * 获取静态资源相对路径
     * @param string $asset_url 文件的URL
     * @return string
     */
    function sp_get_asset_static_path($asset_url = ''){

        $filepath = config('sys_config.lmx_static_url').$asset_url;
        return $filepath;
    }
}


if (!function_exists('sp_get_static_version')) {
    /**
     * 获取静态资源版本号
     * @param int $version 版本号
     * @return int|mixed
     */
    function sp_get_static_version($version = 0){

        $version = !empty($version) ? $version : config('sys_config.lmx_version');
        return $version;
    }
}

if (!function_exists('sp_get_image_preview_url')) {
    /**
     * 获取文件相对路径
     * @param string $asset_url 文件的URL
     * @return string
     */
    function sp_get_image_preview_url($asset_url = ''){

        return sp_get_asset_upload_path($asset_url);
    }
}

if (!function_exists('sp_get_asset_upload_path')) {
    /**
     * 转化数据库保存的文件路径，为可以访问的url
     * @param string $file
     * @return string
     */
    function sp_get_asset_upload_path($file = ''){

        if(strpos($file,"http")===0){
            return $file;
        }else if(strpos($file,"/")===0){
            return $file;
        }

        $filepath = config('sys_config.lmx_upload_url').$file;

        if(strpos($filepath,"http")===0){
            return $filepath;
        }

        $http =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
        $host = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
        $port = $_SERVER["SERVER_PORT"] == 80 ? '' : ':'.$_SERVER["SERVER_PORT"];

        $filepath =  $http.$host.$port.$filepath;

        return $filepath;

    }
}

if (!function_exists('substr')) {
    /**
     * 截取字符串
     * @param  string   $string
     * @param  int      $start
     * @param  int|null $length
     * @return string
     */
    function substr($string, $start, $length = null){
        return mb_substr($string, $start, $length, 'UTF-8');
    }
}

