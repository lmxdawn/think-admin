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
use app\common\model\Options;
use think\Db;


/**
 * Class Auth 测试控制器
 * @package app\index\controller
 */
class System extends Base {

    /**
     * 站点配置
     */
    public function siteConfig()
    {
        $site_config = Options::get_value('site_config');

        return $this->fetch('site_config', [
            'title' => '网站配置',
            'site_config' => $site_config
        ]);
    }

    /**
     * 更新配置
     */
    public function updateSiteConfig()
    {
        if ($this->request->isPost()) {
            $site_config                = $this->request->post('site_config/a');
            $site_config['site_tongji'] = htmlspecialchars_decode($site_config['site_tongji']);
            if (Options::up_value('site_config',$site_config)) {
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        }
    }

    /**
     * 清除缓存
     */
    public function clear()
    {
        if (delete_dir_file(CACHE_PATH) || delete_dir_file(TEMP_PATH)) {
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }

    /**
     * android 配置
     * @return mixed
     */
    public function setAppAndroidConfig(){

        $app_android_config = Options::get_value('app_android_config');

        return $this->fetch('app_android_config', [
            'title' => 'Android配置',
            'app_android_config' => $app_android_config
        ]);

    }

    /**
     * 更新配置
     */
    public function upAppAndroidConfig()
    {
        if ($this->request->isPost()) {
            $app_android_config                = $this->request->post('app_android_config/a');
            $app_android_config['toggle'] = (!empty($app_android_config['toggle']) && $app_android_config['toggle'] == 'on') ? true : false;
            //dump($app_android_config);exit;
            if (Options::up_value('app_android_config',$app_android_config)) {
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        }
    }


}
