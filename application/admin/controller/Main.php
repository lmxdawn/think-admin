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

use think\Db;


/**
 * Class Index 后台模块首页
 * @package app\admin\controller
 */
class Main extends Base
{

    /**
     * 首页
     */
    public function index(){


        $version = Db::query('SELECT VERSION() AS ver');
        $config  = [
            'url'             => ['name' => '网站域名','value' => $_SERVER['HTTP_HOST']],
            'document_root'   => ['name' => '网站目录','value' => $_SERVER['DOCUMENT_ROOT']],
            'server_os'       => ['name' => '服务器操作系统','value' => PHP_OS],
            'server_port'     => ['name' => '服务器端口','value' => $_SERVER['SERVER_PORT']],
            'server_soft'     => ['name' => '服务器环境','value' => $_SERVER['SERVER_SOFTWARE']],
            'php_version'     => ['name' => 'PHP版本','value' => PHP_VERSION],
            'thikphp_version' => ['name' => 'ThinkPHP版本','value' => THINK_VERSION],
            'mysql_version'   => ['name' => 'MySQL版本','value' => $version[0]['ver']],
            'max_upload_size' => ['name' => '最大上传限制','value' => ini_get('upload_max_filesize')]
        ];

        return $this->view->fetch('index',[
            'title'     =>      '首页',
            'config'    =>      $config,
        ]);
    }
}
