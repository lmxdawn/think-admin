/**
 * Created by admin on 2017/1/20.
 */

layui.use(['form'], function(){

    var form = layui.form();

    var is_submit = false;
    //监听提交
    form.on('submit(theForm)', function(data){
        var $this = $(this);
        $this.html('提交中...');
        if (is_submit){
            return false;
        }
        is_submit = true;
        $.ajax({
            type : 'post',
            url : '',
            data : data.field,
            dataType : 'json',
            success : function (res) {
                is_submit = false;
                $this.html('立即提交');
                //提示层
                layer.msg(res.msg);
                if (res.code == 1){
                    setTimeout(function () {
                        window.location.href = NODE_INDEX_URL;
                    },1000);
                }
            },
            error : function (e) {
                is_submit = false;
                $this.html('立即提交');
            }
        })
        return false;
    });

})