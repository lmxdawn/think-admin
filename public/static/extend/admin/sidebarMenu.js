/**
 扩展一个手风琴菜单组件
 **/


layui.define(function(exports){ //提示：组件也可以依赖其它组件，如：layui.define('layer', callback);
    var obj = {
        show: function(menu){
            var animationSpeed = 150;

            $(menu).on( "click",function(event) {
                var closest_a = $(event.target).closest("a");
                if (!closest_a || closest_a.length == 0) {
                    return
                }
                var closest_a_next = closest_a.next().get(0);
                if (!$(closest_a_next).is(":visible")) {
                    var closest_ul = $(closest_a_next.parentNode).closest("ul");
                    closest_ul.find("> .treeview > .treeview-menu").each(function() {
                        if (this != closest_a_next && !$(this.parentNode).hasClass("active")) {
                            $(this).slideUp(animationSpeed).parent().removeClass("treeview")
                        }
                    });
                }
                $(closest_a_next).slideToggle(animationSpeed).parent().addClass("treeview");
                return false;
            });

        }
    };

    //输出test接口
    exports('sidebarMenu', obj);
});
