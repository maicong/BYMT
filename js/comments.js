/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */

$(document).ready(function() {

    //字体大小控制
    $('#resizer li').click(function() {
        var fontSize = 13;
        var name = $(this).attr('id');
        if (name == 'f_s') {
            fontSize -= 2;
        } else if (name == 'f_l') {
            fontSize += 2;
        } else if (name == 'f_m') {
            fontSize = 13;
        }
        $('.context').css('font-size', fontSize + 'px');
    });

    //社交分享
    function Ashare() {
        var thelink = encodeURIComponent(document.location),
            thetitle = encodeURIComponent(document.title.substring(0, 60)),
            windowName = '分享到',
            param = getParamsOfShareWindow(600, 560),
            A_qzone = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + thelink + '&title=',
            A_tqq = 'http://v.t.qq.com/share/share.php?title=' + thetitle + '&url=' + thelink + '&site=',
            A_sina = 'http://v.t.sina.com.cn/share/share.php?url=' + thelink + '&title=' + thetitle,
            A_wangyi = 'http://t.163.com/article/user/checkLogin.do?info=' + thetitle + thelink,
            A_renren = 'http://share.renren.com/share/buttonshare?link=' + thelink + '&title=' + thetitle,
            A_kaixin = 'http://www.kaixin001.com/repaste/share.php?rtitle=' + thetitle + '&rurl=' + thelink,
            A_xiaoyou = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou&url=' + thelink + '&title=' + thetitle,
            A_baidu = 'http://cang.baidu.com/do/add?it=' + thetitle + '&iu=' + thelink;
        $('.Ashare').each(
            function() {
                $(this).attr('title', windowName + $(this).text());
                $(this).click(
                    function() {
                        var httpUrl = eval($(this).attr('class').substring($(this).attr('class').lastIndexOf('A_')));
                        window.open(httpUrl, windowName, param);
                    });
            });

        function getParamsOfShareWindow(width, height) {
            return [
                'toolbar=0,status=0,resizable=1,width=' + width + ',height=' + height + ',left=',
                (screen.width - width) / 2, ',top=',
                (screen.height - height) / 2
            ].join('');
        }
    }
    Ashare();

    //评论框编辑器
    $(function() {
        $("#editor_tools").hide();
        $("#smiley").hide();
        $("#comment").focus(function() {
            $("#editor_tools").slideDown('slow');
            $("#smiley").slideDown('slow');
        });
    });
    $(function() {
        function addEditor(a, b, c) {
            if (document.selection) {
                a.focus();
                sel = document.selection.createRange();
                c ? sel.text = b + sel.text + c : sel.text = b;
                a.focus();
            } else if (a.selectionStart || a.selectionStart == '0') {
                var d = a.selectionStart;
                var e = a.selectionEnd;
                var f = e;
                c ? a.value = a.value.substring(0, d) + b + a.value.substring(d, e) + c + a.value.substring(e, a.value.length) : a.value = a.value.substring(0, d) + b + a.value.substring(e, a.value.length);
                c ? f += b.length + c.length : f += b.length - e + d;
                if (d == e && c) f -= c.length;
                a.focus();
                a.selectionStart = f;
                a.selectionEnd = f;
            } else {
                a.value += b + c;
                a.focus();
            }
        }
        var myDate = new Date();
        var mytime = myDate.toLocaleTimeString();
        var g = document.getElementById('comment') || 0;
        var h = {
            daka: function() {
                addEditor(g, '<blockquote>签到成功！签到时间：' + mytime, '，每日打卡，生活更精彩哦~</blockquote>');
                $('#editor_tools').hide(500);
                $("#smiley").hide(500);
            },
            good: function() {
                addEditor(g, '<blockquote> :grin:  :grin: 好羞射，文章真的好赞啊，顶博主！', '</blockquote>');
                $('#editor_tools').hide(500);
                $("#smiley").hide(500);
            },
            bad: function() {
                addEditor(g, '<blockquote> :twisted:  :twisted: 有点看不懂哦，希望下次写的简单易懂一点！', '</blockquote>');
                $('#editor_tools').hide(500);
                $("#smiley").hide(500);
            },
            strong: function() {
                addEditor(g, '<strong>', '</strong>');
            },
            em: function() {
                addEditor(g, '<em>', '</em>');
            },
            del: function() {
                addEditor(g, '<del>', '</del>');
            },
            quote: function() {
                addEditor(g, '<blockquote>', '</blockquote>');
            },
            private: function() {
                addEditor(g, '[private]', '[/private]');
            }
        };
        window.SIMPALED = {};
        window.SIMPALED.Editor = h;
    });
    //点击回复显示@用户名
    $('.reply').click(function() {
        var atid = '"#' + $(this).parent().parent().parent().attr("id") + '"';
        var atname = $(this).parent().find('.commentid').text();
        $("#comment").attr("value", "<a href=" + atid + ">@" + atname + "</a> ").focus();
    });
    $('.cancel-comment-reply a').click(function() {
        $("#comment").attr("value", '');
    });
});
//边栏自适应高度
$(function($) {
    var conheight = document.getElementById("content").offsetHeight;
    if (conheight < 750) {
        $('#widget_ada').hide();
        $('#widget_rcomments').hide();
        $('#widget_statistics').hide();
        $('#widget_user').hide();
    } else if (conheight < 1100) {
        $('#widget_rcomments').hide();
        $('#widget_statistics').hide();
        $('#widget_user').hide();
    } else if (conheight < 1500) {
        $('#widget_statistics').hide();
        $('#widget_user').hide();
    }
    //ajax评论翻页
    $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
    $('.comments .navigation a').live('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            beforeSend: function() {
                location.href = "#comments";
                $('.navigation').remove();
                $('.commentlist').remove();
                $('#loading-comments').slideDown();
            },
            dataType: "html",
            success: function(out) {
                result = $(out).find('.commentlist');
                nextlink = $(out).find('.navigation');
                $('#loading-comments').slideUp(300);
                $('#loading-comments').after(result.fadeIn(500));
                $('.commentlist').after(nextlink);
            }
        });
    });
});
