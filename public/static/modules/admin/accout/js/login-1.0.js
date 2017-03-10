

layui.use([],function () {

    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            $('#login_btn').click();
        }
    };
    var lock = false;
    $(function () {
        $('#login_btn').click(function(){
            if(lock){
                return;
            }
            lock = true;
            $('#err_msg').hide();
            var username = $('#username').val();
            var password = $('#password').val();
            var code = $('#code').val();
            if (username == ''){
                $('#err_msg').show().html("<span style='color:red'>请输入用户名</span>");
                return false;
            }
            if (password == ''){
                $('#err_msg').show().html("<span style='color:red'>请输入密码</span>");
                return false;
            }
            if (code == ''){
                $('#err_msg').show().html("<span style='color:red'>请输入验证码</span>");
                return false;
            }

            $('#login_btn').removeClass('btn-success').addClass('btn-danger').val('登陆中...');
            var url = $("#loginForm").attr('action');
            $.post(url,{'username':username, 'password':password, 'code':code},function(data){
                lock = false;
                $('#login_btn').val('登录').removeClass('btn-danger').addClass('btn-success');
                if(data.code!=1){
                    $('#err_msg').show().html("<span style='color:red'>"+data.msg+"</span>");
                    return false;
                }else{
                    window.location.href=data.data;
                }
            });
            return false;

        });
    });



})
