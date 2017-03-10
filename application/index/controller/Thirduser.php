<?php


namespace app\api\controller;

use app\common\validate\ThirdUsers;
use think\Request;


/**
 * 第三方用户
 * Class Sys
 * @package app\index\controller
 */
class Thirduser extends Base
{
    /**
     * 显示第三方用户列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 新增用户
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add(Request $request)
    {
        $msg = '新增用户';
        if ($request->isPost()){
            $data = $request->post();
            $validate = new ThirdUsers();
            if (!$validate->check($data)){
                return self::res(1002,$msg,[],$validate->getError());
            }

            $where['openid'] = $data['openid'];
            $count = \app\common\model\ThirdUsers::where($where)
                ->field([''])
                ->find();
            if ($count > 0){

            }

            $res['code'] = '200';
            $res['data'] = $data;

            return self::res(200,$msg,$data);

        }
        return self::res(1001,$msg,[],'请求类型错误');
    }

    /**
     * 获取用户信息
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 更新用户信息
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除用户
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }



}
