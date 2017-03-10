


layui.use([],function () {


    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            $('#login_btn').click();
        }
    };
    var lock = false;
    $(function () {

        $('#switch_qlogin').click(function(){
            $('#switch_login').removeClass("switch_btn_focus").addClass('switch_btn');
            $('#switch_qlogin').removeClass("switch_btn").addClass('switch_btn_focus');
            $('#switch_bottom').animate({left:'0px',width:'70px'});
            $('#qlogin').css('display','none');
            $('#web_qr_login').css('display','block');

        });
        $('#switch_login').click(function(){

            $('#switch_login').removeClass("switch_btn").addClass('switch_btn_focus');
            $('#switch_qlogin').removeClass("switch_btn_focus").addClass('switch_btn');
            $('#switch_bottom').animate({left:'154px',width:'70px'});

            $('#qlogin').css('display','block');
            $('#web_qr_login').css('display','none');
        });


        $('#login_btn').click(function(){
            if(lock){
                return;
            }
            var $login_err_msg = $("#login_err_msg");
            $login_err_msg.hide();
            var user_name = $('#user_name').val();
            var user_pass = $('#user_pass').val();
            var $code = $('#code')
                ,code = $code.val();
            if (user_name == ''){
                $login_err_msg.show().html("<span style='color:red'>请输入用户名</span>");
                $('#user_name').focus();
                return false;
            }
            if (user_pass == ''){
                $login_err_msg.show().html("<span style='color:red'>请输入密码</span>");
                $('#user_pass').focus();
                return false;
            }
            if (code == ''){
                console.log(code);
                $login_err_msg.show().html("<span style='color:red'>请输入验证码</span>");
                $code.focus();
                return false;
            }
            lock = true;
            $('#login_btn').removeClass('btn-success').addClass('btn-danger').val('登陆中...');
            var url = $("#loginForm").attr('action');
            $.post(url,{'user_name':user_name, 'user_pass':user_pass, 'code':code},function(res){
                lock = false;
                $('#login_btn').val('登录').removeClass('btn-danger').addClass('btn-success');
                if(res.code!=1){
                    $login_err_msg.show().html("<span style='color:red'>"+res.msg+"</span>");
                    $code.val('');
                    $code.next().click();
                    return false;
                }else{
                    top.window.location.href = res.url;
                }
            });

            return false;

        });
    });



})
