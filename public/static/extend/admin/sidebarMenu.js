/**
 扩展一个手风琴菜单组件
 **/


layui.define(function(exports){ //提示：组件也可以依赖其它组件，如：layui.define('layer', callback);
    var obj = {
        show: function(menu){
            var animationSpeed = 300;
            $(menu).on('click', 'li a', function(e) {
                var $this = $(this);
                var checkElement = $this.next();

                if (checkElement.is('.treeview-menu') && checkElement.is(':visible')) {
                    checkElement.slideUp(animationSpeed, function() {
                        checkElement.removeClass('menu-open');
                    });
                    checkElement.parent("li").removeClass("active");
                }

                //If the menu is not visible
                else if ((checkElement.is('.treeview-menu')) && (!checkElement.is(':visible'))) {
                    //Get the parent menu
                    var parent = $this.parent('ul').first();
                    //Close all open menus within the parent
                    //var ul = parent.find('ul:visible').slideUp(animationSpeed);
                    //Remove the menu-open class from the parent
                    //ul.removeClass('menu-open');
                    //Get the parent li
                    var parent_li = $this.parent("li");
                    //Open the target menu and add the menu-open class
                    checkElement.slideDown(animationSpeed, function() {
                        //Add the class active to the parent li
                        checkElement.addClass('menu-open');
                        parent.find('li.active').removeClass('active');
                        parent_li.addClass('active');
                    });
                }
                //if this isn't a link, prevent the page from being redirected
                if (checkElement.is('.treeview-menu')) {
                    e.preventDefault();
                }
            });
        }
    };

    //输出test接口
    exports('sidebarMenu', obj);
});
