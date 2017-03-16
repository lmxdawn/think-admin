/**
 *
 * Created by lk on 17/1/7.
 *
 * 基础js
 */


layui.extend({ //设定组件别名
    'sidebarMenu': 'admin/sidebarMenu' //相对于上述base目录的子目录 （如果sidebarMenu.js是在根目录，也可以不用设定别名 ）
});


var task_item_tpl = '<li class="lmx-tabitem">' +
    '<i class="fa"></i>' +
    '<span class="lmx-tabitem-text" title=""></span>' +
    '<a class="lmx-tabitem-tabclose" href="javascript:void(0);" title="点击关闭标签">' +
    '<span></span>' +
    '<b class="lmx-tabitem-tabclose-icon fa fa-times-circle"></b>' +
    '</a>' +
    '</li>';

var appiframe_tpl='<iframe style="width: 100%; height: 100%;" frameborder="0" class="appiframe"></iframe>';

var $lmx_tab = $("#lmx-tab")
    ,tabwidth = 120
    ,$loading = null
    ,$loadSpin = null
    ,$loadTime = null //加载定时器
    ,$lmx_main = null


layui.use(['sidebarMenu'],function () {



    // 手风琴菜单
    var sidebarMenu = layui.sidebarMenu;


    $(function () {


        //手风琴菜单
        sidebarMenu.show($('.sidebar-menu'));

        $loading=$("#loading");//正在加载
        $loadSpin = $("#loadSpin");// 页面加载过慢显示
        $lmx_main = $("#lmx-main");



        var headerHeight = $("#lmx-header").height() + 5 //头部高度加上他的底部
            ,tabHeight = $(".lmx-breadcrumbs").height() //tab 高度
        /**
         * 调整页面宽高
         */
        function fixHeight() {
            $lmx_main.height($(window).height() - headerHeight  - tabHeight);
            $(".lmx-left-nav-content").height($(window).height() - headerHeight  - 16);
            // 调整tab 宽度
            calcTaskitemsWidth();
        }

        /**
         * 当页面大小变化 调整页面元素宽高
         */
        $(window).resize(function(){
            fixHeight();

        }).resize();

        $(".simplewind-nav").click(function () {
            $(".simplewind-nav .dropdown-menu").toggle();
        })

        /**
         * 窗口刷新完成隐藏loading
         */
        // $("#lmx-main iframe").load(function(){
        //     loadHide();//隐藏加载
        // });

        /**
         * 左侧收叠按钮
         */
        $("#lmx-left-fold").click(function () {
            var width = 30 //需要收叠的宽度
                ,maxWidth = 200 //最大宽度
                ,border = 1 //边框
            if ($("#lmx-left").width() <= width){
                $("#lmx-left").animate({ "width": maxWidth - border + "px" }, 300, 'swing');//恢复侧边栏宽度
                $("#lmx-content").animate({'margin-left' : maxWidth + 'px'}, 300, 'swing');//恢复内容部分左边距
                // $(".sidebar-menu .treeview-menu").animate({'padding-left' : 5 + 'px'}, 300, 'swing');//恢复手风琴的左边距
                $(".sidebar-menu li.header").animate({'padding-left' : 15 + 'px'}, 300, 'swing');//恢复手风琴每个栏目头部标签的左边距
                $(".sidebar-menu > li > a").animate({'padding-left' : 15 + 'px'}, 300, 'swing');//恢复手风琴标签的左边距
                $(".sidebar-menu .treeview-menu > li > a[level='2']").animate({'padding-left' : 35 + 'px'}, 300, 'swing');//恢复手风琴标签的左边距
                $(".sidebar-menu .treeview-menu > li > a[level='3']").animate({'padding-left' : 60 + 'px'}, 300, 'swing');//恢复手风琴标签的左边距
            }else{
                $("#lmx-left").animate({ "width": width + "px" }, 300, 'swing');//调整侧边栏宽度
                $("#lmx-content").animate({'margin-left' : width + 'px'}, 300, 'swing');//调整内容部分左边距
                // $(".sidebar-menu .treeview-menu").animate({'padding-left' : 0 + 'px'}, 300, 'swing');//调整手风琴的左边距
                $(".sidebar-menu li.header").animate({'padding-left' : 2 + 'px'}, 300, 'swing');//调整手风琴每个栏目头部标签的左边距
                $(".sidebar-menu > li > a").animate({'padding-left' : 5 + 'px'}, 300, 'swing');//调整手风琴标签的左边距
                $(".sidebar-menu .treeview-menu > li > a[level='2']").animate({'padding-left' : 7 + 'px'}, 300, 'swing');//调整手风琴标签的左边距
                $(".sidebar-menu .treeview-menu > li > a[level='3']").animate({'padding-left' : 7 + 'px'}, 300, 'swing');//调整手风琴标签的左边距
            }
            return false;
        })

        /**
         * 点击导航栏
         */
        $("#lmx-tab").on("click",'li', function () {
            // 打开窗口
            openapp($(this).attr("app-url"), $(this).attr("app-id"), $(this).attr("app-name"));
            return false;
        });

        /**
         * 双击导航栏
         */
        $("#lmx-tab").on("dblclick",'li', function () {
            closeapp($(this));
            return false;

        });

        /**
         * 点击关闭窗口按钮
         */
        $("#lmx-tab").on("click",'a.lmx-tabitem-tabclose', function () {
            closeapp($(this).parent());
            return false;
        });

        /**
         * 点击向右按钮
         */
        $("#task-next").click(function () {
            var marginleft = $lmx_tab.css("margin-left");
            marginleft = marginleft.replace("px", "");
            var width = $("#lmx-tab li").length * tabwidth;
            var content_width = $("#lmx-nav").width();
            var lesswidth = content_width - width;
            marginleft = marginleft - tabwidth <= lesswidth ? lesswidth : marginleft - tabwidth;
            $lmx_tab.stop();
            $lmx_tab.animate({ "margin-left": marginleft + "px" }, 300, 'swing');
        });

        /**
         * 点击向左按钮
         */
        $("#task-pre").click(function () {
            var marginleft = $lmx_tab.css("margin-left");
            marginleft = parseInt(marginleft.replace("px", ""));
            marginleft = marginleft + tabwidth > 0 ? 0 : marginleft + tabwidth;
            // $lmx_tab.css("margin-left", marginleft + "px");
            $lmx_tab.stop();
            $lmx_tab.animate({ "margin-left": marginleft + "px" }, 300, 'swing');
        });


        /**
         * 点击刷新按钮
         */
        $("#refresh_wrapper").click(function(){
            var $this = $("#lmx-tab li.current")
                ,url = $this.attr("app-url")
                ,appid = $this.attr("app-id");
            $(".iframe-div").hide();
            loadShow();//显示正在加载

            var $iframe = document.getElementById("appiframe-" + appid);

            //$iframe.src = url;
            $iframe.contentWindow.location.reload();
            // //这是jQuery 2.1.4以前版本的
            // $iframe.load(function(){
            //     loadHide();//隐藏正在加载
            // });

            var $load = $("#iframe-div-" + appid + " .load");
            //定时加载
            var $loadTime = setTimeout(function () {
                $load.show();
            },1500);
            //这是兼容 IE的
            if ($iframe.attachEvent){
                $iframe.attachEvent("onload", function(){
                    loadHide();//隐藏正在加载
                    $load.hide();
                    clearTimeout($loadTime);
                });
            } else {
                $iframe.onload = function(){
                    loadHide();//隐藏正在加载
                    $load.hide();
                    clearTimeout($loadTime);
                };
            }

            $("#iframe-div-" + appid).show();

            return false;
        });


        /**
         * 关闭展开
         */
        $("#close").click(function () {
            var $this = $(this)
                ,width = $("#lmx-left").width();
            if ($this.hasClass('fa-angle-double-left')){
                //关闭
                $("#lmx-left").animate({'left' : -width-1 + 'px'}, 300, 'swing')
                $("#lmx-content").animate({'margin-left' : 0 + 'px'}, 300, 'swing')
                //$("#lmx-header").animate({'margin-left' : 0 + 'px'}, 300, 'swing')
                $this.removeClass('fa-angle-double-left').addClass('fa-angle-double-right').attr('title','展开侧边栏');
            }else if ($this.hasClass('fa-angle-double-right')){
                // 展开
                $("#lmx-left").animate({'left' : 0 + 'px'}, 300, 'swing')
                $("#lmx-content").animate({'margin-left' : width + 'px'}, 300, 'swing')
                //$("#lmx-header").animate({'margin-left' : 200 + 'px'}, 300, 'swing')
                $this.removeClass('fa-angle-double-right').addClass('fa-angle-double-left').attr('title','关闭侧边栏');
            }
            return false;
        })

        //
        // var id = 1;
        // $("body").click(function () {
        //
        //     if (id < 10)
        //         openapp('/think-team-manage/public/index.php/admin/node/index.html',(id < 3 ? id : 0),'测试测试测试测试测试','fa-desktop');
        //     id ++;
        //
        //
        //
        // })


        // 页面初始化完成加载首页
        loadIndex();


    })



})


/**
 * 获取宽度
 */
function getTabWidth() {
    var width = 0;
    $("#lmx-tab li").each(function (index,item) {
        width += $(this).width() + 3;
    })
    return width - 2;
}

/**
 * 调整tab栏宽度
 */
function calcTaskitemsWidth() {
    var width = $("#lmx-tab li").length * tabwidth;
    $lmx_tab.width(width);
    if (($(document).width()-320-tabwidth- 30 * 2) < width) {
        $("#lmx-nav").width($(document).width() -320-tabwidth- 30 * 2);
        $("#task-next,#task-pre").show();
    } else {
        $("#task-next,#task-pre").hide();
        $("#lmx-nav").width(width);
    }
}

/**
 * 关闭导航栏
 * @param $this 当前导航栏
 */
function closeapp($this){
    if(!$this.is(".noclose")){
        var $box = $this.prev();
        $this.remove();
        $("#iframe-div-"+$this.attr("app-id")).remove();
        calcTaskitemsWidth();
        $box.click()
        $("#task-next").click();
    }

}

// 隐藏正在加载
function loadHide() {
    $loading.hide();

    // $loadSpin.hide();
    // clearTimeout($loadTime);//清除加载过慢出现的定时器
}

/**
 * 显示正在加载
 */
function loadShow() {
    $loading.show();

    //加载过慢出现 2 秒出现
    // $loadTime = setTimeout(function () {
    //     $loadSpin.show();
    // },1500);
}

/**
 * 创建Iframe
 * @param url 加载的url地址
 * @param appid 应用的appid
 */
function createIframe(url, appid) {
    var $appiframe = document.createElement("iframe");
    $appiframe.id = "appiframe-" + appid;
    $appiframe.src = url;
    $appiframe.className = 'appiframe';

    var $div = document.createElement('div');
    $div.id = "iframe-div-" + appid;
    $div.className = 'iframe-div';
    var $loadSpin = document.createElement('div');
    $loadSpin.className = 'loadSpin';
    var $spinner = document.createElement('i');
    $spinner.className = 'fa fa-spinner fa-spin';
    $loadSpin.appendChild($spinner);
    var $load = document.createElement('div');
    $load.className = 'load';
    $load.appendChild($loadSpin);

    //定时加载
    var $loadTime = setTimeout(function () {
        $load.style.display = 'block';
    },1500);
    //这是兼容 IE的
    if ($appiframe.attachEvent){
        $appiframe.attachEvent("onload", function(){
            loadHide();//隐藏正在加载
            $load.style.display = 'none';
            clearTimeout($loadTime);
        });
    } else {
        $appiframe.onload = function(){
            loadHide();//隐藏正在加载
            $load.style.display = 'none';
            clearTimeout($loadTime);
        };
    }
    $div.appendChild($load);
    $div.appendChild($appiframe);

    document.getElementById('lmx-main').appendChild($div);
}


/**
 * 加载首页
 */
function loadIndex() {
    var $this = $("#lmx-tab li:eq(0)")
        ,url = $this.attr("app-url")
        ,appid = $this.attr("app-id");
    $(".iframe-div").hide();
    loadShow();//显示正在加载
    // $appiframe=$(appiframe_tpl).attr("src",url).attr("id","appiframe-"+appid);
    //$appiframe.appendTo("#lmx-main");
    // //这是jQuery 2.1.4以前版本的
    // $appiframe.load(function(){
    //     loadHide();//隐藏正在加载
    // });

    createIframe(url,appid);
}

/**
 * 打开网页
 * @param url 地址
 * @param appid 菜单id
 * @param appname 菜单名称
 * @param icon 菜单图标
 * @param refresh 是否刷新
 */
function openapp(url, appid, appname, icon, refresh) {
    // 获取tab按钮
    var $app = $("#lmx-tab li[app-id='"+appid+"']");
    $("#lmx-tab .current").removeClass("current");
    if ($app.length == 0) {
        var task = $(task_item_tpl).attr("app-id", appid).attr("app-url",url).attr("app-name",appname).addClass("current");
        task.find(".lmx-tabitem-text").html(appname).attr("title",appname);
        task.find("i.fa").addClass(icon);
        $lmx_tab.append(task);
        $(".iframe-div").hide();
        loadShow();//显示正在加载
        //$appiframe=$(appiframe_tpl).attr("src",url).attr("id","appiframe-"+appid);
        //$appiframe.appendTo("#lmx-main");
        // //这是jQuery 2.1.4以前版本的
        // $appiframe.load(function(){
        //     loadHide();//隐藏正在加载
        // });

        createIframe(url,appid);

        // 调整页面
        calcTaskitemsWidth();
    } else {
        $app.addClass("current");
        $(".iframe-div").hide();
        // var $iframe = $("#appiframe-" + appid);
        var $iframe = document.getElementById("appiframe-" + appid);
        if(refresh === true){//刷新
            loadShow();//显示正在加载
            $iframe.src = url;
            // //这是jQuery 2.1.4以前版本的
            // $iframe.load(function(){
            //     loadHide();//隐藏正在加载
            // });

            var $load = $("#iframe-div-" + appid + " .load");
            //定时加载
            var $loadTime = setTimeout(function () {
                $load.show();
            },1500);
            //这是兼容 IE的
            if ($iframe.attachEvent){
                $iframe.attachEvent("onload", function(){
                    loadHide();//隐藏正在加载
                    $load.hide();
                    clearTimeout($loadTime);
                });
            } else {
                $iframe.onload = function(){
                    loadHide();//隐藏正在加载
                    $load.hide();
                    clearTimeout($loadTime);
                };
            }
        }
        $("#iframe-div-" + appid).show();
    }



    var itemoffset= $("#lmx-tab li[app-id='"+appid+"']").index()* tabwidth;
    var width = $("#lmx-tab li").length * tabwidth;

    var content_width = $("#lmx-nav").width();
    var offset=itemoffset+tabwidth-content_width;

    var lesswidth = content_width - width;

    var marginleft = $lmx_tab.css("margin-left");

    marginleft =parseInt( marginleft.replace("px", "") );
    var copymarginleft=marginleft;
    if(offset>0){
        marginleft=marginleft>-offset?-offset:marginleft;
    }else{
        marginleft=itemoffset+marginleft>=0?marginleft:-itemoffset;
    }

    if(-itemoffset==marginleft){
        marginleft = marginleft + tabwidth > 0 ? 0 : marginleft + tabwidth;
    }

    if(content_width-copymarginleft-tabwidth==itemoffset){
        marginleft = marginleft - tabwidth <= lesswidth ? lesswidth : marginleft - tabwidth;
    }

    $lmx_tab.animate({ "margin-left": marginleft + "px" }, 300, 'swing');


}
