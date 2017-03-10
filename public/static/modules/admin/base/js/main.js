layui.use(['layer'], function(){

    $(".delete").click(function () {

        var $this = $(this)
            ,url = $this.attr('href')
            ,id = $this.data('id')
            ,data = {'id' : id}

        //询问框
        layer.confirm('你确定删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            //确定
            layer.closeAll();

            if (!id){
                return false;
            }
            $this.css('background-color','#ccc');
            $this.data('id','');
            $.ajax({
                type : 'post',
                url : url,
                data : data,
                dataType : 'json',
                success : function (res) {
                    //提示层
                    setTimeout(function () {
                        layer.msg(res.msg);
                    },500);


                    if (res.code == 1){
                        $this.parents('tr').remove();
                    }else {
                        $this.css('background-color','#FF5722');
                        $this.data('id',id);
                    }
                },
                error : function (e) {
                    $this.css('background-color','#FF5722');
                    $this.data('id',id);
                }
            });
        }, function(){

        });


        return false;
    })

});