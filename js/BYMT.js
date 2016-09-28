/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */

jQuery(document).ready(function() {

    //侧边栏TAB自动切换
    $(function() {
        var o = 0;
        var timeInterval = 5000;
        var $cont = $(".tab-content ul");
        var $title = $(".tab-title span");
        $cont.hide();
        $($cont[0]).show();

        function auto() {
            o = o < $cont.length - 1 ? o++ : 0;
            $cont.eq(o).fadeIn(800).siblings().hide();
            $title.eq(o).addClass("selected").siblings().removeClass("selected");
        }
        set = window.setInterval(auto, timeInterval);
    });
    //侧边栏TAB效果
    $('.tab-title span').click(function() {
        jQuery(this).addClass("selected").siblings().removeClass();
        jQuery(".tab-content > ul").eq(jQuery('.tab-title span').index(this)).fadeIn(1500).siblings().hide();
    });
    //加载中特效
    $("#circletext").text("加载肿");
    $(window).load(function() {
        $("#circle").fadeOut(400);
        $("#circle1").fadeOut(600);
        $("#circletext").text("完成鸟").fadeOut(800);
    });
    //菜单多级
    $('#menu li:has(> ul) > a').append(' &rsaquo;');
    //弹性搜索框
    $(".field").focus(function() {
            $(this).stop(true, false).animate({ width: "177px" }, "slow");
        })
        .blur(function() {
            $(this).animate({ width: "110px" }, "slow");
        });
    //返回顶部
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('#backtop').css({ bottom: "1px" }).attr("title", "返回顶部");
        } else {
            jQuery('#backtop').css({ bottom: "-100px" });
        }
    });
    jQuery('#backtop').click(function() {
        jQuery('html, body').animate({ scrollTop: '0px' }, 500);
        return false;
    });
    //文章标题链接点击滑动
    $('.excerpt h2 a').hover(function() {
        jQuery(this).stop().animate({ marginLeft: "5px" }, 300);
    }, function() {
        jQuery(this).stop().animate({ marginLeft: "0px" }, 300);
    });
    //检测侧边栏
    $(function($) {
        var conheight = document.getElementById("sidebar").offsetHeight;
        var conwidth = document.getElementById("header_inner").offsetWidth;
        if (conheight === 0 && conwidth > 979) {
            $('#sidebar').hide();
            $('#index_content').css("width", conwidth - 3);
            $('#content').css("width", conwidth - 3);
        }
    });
    //关闭侧边栏
    $('#closesidebar').click(function() {
        var conwidth = document.getElementById("header_inner").offsetWidth;
        $('#sidebar').hide(1000);
        $('#index_content').animate({ "width": conwidth - 3 }, 1000);
        $('#content').animate({ "width": conwidth - 3 }, 1000);
        $('#closesidebar').hide(1000);
    });
    //侧边栏链接点击滑动
    $('#sidebar li a').hover(function() {
        $(this).stop().animate({ 'left': '4px' }, '600');
    }, function() {
        $(this).stop().animate({ 'left': '0px' }, '600');
    });
    //图片渐隐
    $('img').hover(
        function() { jQuery(this).fadeTo("fast", 0.8); },
        function() {
            jQuery(this).fadeTo("fast", 1);
        });
    //新窗口打开
    $("a[rel='external'],a[rel='external nofollow']").click(
        function() {
            window.open(this.href);
            return false;
        });
    //伸缩栏
    $(".toggle_content").hide();
    $(".toggle_title").click(function() {
        $(this).toggleClass("active").next().slideToggle('fast');
        return false;
    });
    //鼠标title样式
    $(function() {
        $("#wrapper-inner a").each(function(b) {
            if (this.title) {
                var c = this.title;
                var a = 30;
                var z = 15;
                $(this).mouseover(function(d) {
                    this.title = "";
                    $("body").append('<div id="tooltip">' + c + "</div>");
                    $("#tooltip").css({
                        left: (d.pageX - z) + "px",
                        top: (d.pageY + a) + "px",
                        opacity: "0.8"
                    }).fadeIn(250)
                }).mouseout(function() {
                    this.title = c;
                    $("#tooltip").remove()
                }).mousemove(function(d) {
                    $("#tooltip").css({
                        left: (d.pageX - z) + "px",
                        top: (d.pageY + a) + "px"
                    });
                });
            }
        });
    });
    //预加载广告
    function speed_ads(loader, ad) {
        ad = document.getElementById(ad);
        loader = document.getElementById(loader);
        if (ad && loader) {
            ad.appendChild(loader);
            loader.style.display = 'block';
            ad.style.display = 'block';
        }
    }
    window.onload = function() {
        speed_ads('adsense-loader1', 'adsense1');
        speed_ads('adsense-loader2', 'adsense2');
        speed_ads('adsense-loader3', 'adsense3');
        speed_ads('adsense-loader4', 'adsense4');
        speed_ads('adsense-loader5', 'adsense5');
        speed_ads('adsense-loader6', 'adsense6');
        speed_ads('adsense-loader7', 'adsense7');
    };
    //边栏滚动跟随
    $(function() {
        $.fn.smartFloat = function() {
            var position = function(element) {
                var top = element.position().top,
                    pos = element.css("position"),
                    sidebar = document.getElementById("sidebar").offsetHeight;
                $(window).scroll(function() {
                    var scrolls = $(this).scrollTop();
                    if (scrolls > sidebar) {
                        if (window.XMLHttpRequest) {
                            element.css({
                                position: "fixed",
                                top: 30
                            });
                        } else {
                            element.css({
                                top: scrolls
                            });
                        }
                    } else {
                        element.css({
                            position: pos,
                            top: top
                        });
                    }
                });
            };
            return $(this).each(function() {
                position($(this));
            });
        };
        //绑定
        $("#widget_ada").smartFloat();
    });
});
