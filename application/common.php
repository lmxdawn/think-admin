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
