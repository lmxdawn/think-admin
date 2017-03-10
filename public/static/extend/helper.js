/**
 * Created by admin on 2017/1/13.
 * 公共方法文件
 */

layui.define(function(exports){ //提示：组件也可以依赖其它组件，如：layui.define('layer', callback);
    var obj = {
        /**
         * 获取设备信息
         * @returns {string} 设备信息
         */
        getUa : function () {
            return navigator.userAgent.toLowerCase();
        },
        /**
         * 判断是否是ios设备
         * @returns {Array|{index: number, input: string}}
         */
        isIos : function () {
            return !!this.getUa().match(/(ipad|iphone|ipod).*os\s([\d_]+)/);
        },
        /**
         * 判断是否是android设备
         * @returns {Array|{index: number, input: string}}
         */
        isAndroid : function () {
            return !!this.getUa().match(/(android)\s+([\d.]+)/);
        }
    };

    //输出test接口
    exports('helper', obj);
});