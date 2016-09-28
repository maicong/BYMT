/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */
$(document).ready(function() {
    var miniBlogShare = function() {
        $('<img id="imgSinaShare" class="img_share" title="将选中内容分享到新浪微博" src="/wp-content/themes/BYMT/images/t_sina.gif" /><img id="imgQqShare" class="img_share" title="将选中内容分享到腾讯微博" src="/wp-content/themes/BYMT/images/t_qq.gif" />').appendTo('body');
        $('.img_share').css({
            display: 'none',
            position: 'absolute',
            cursor: 'pointer'
        });
        var funGetSelectTxt = function() {
            var txt = '';
            if (document.selection) {
                txt = document.selection.createRange().text;
            } else { txt = document.getSelection(); }
            return txt.toString();
        };
        $('html,body').mouseup(function(e) {
            if (e.target.id == 'imgSinaShare' || e.target.id == 'imgQqShare') {
                return;
            }
            e = e || window.event;
            var txt = funGetSelectTxt(),
                sh = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0,
                left = (e.clientX - 40 < 0) ? e.clientX + 20 : e.clientX - 40,
                top = (e.clientY - 40 < 0) ? e.clientY + sh + 20 : e.clientY + sh - 40;
            if (txt) {
                $('#imgSinaShare').css({
                    display: 'inline',
                    left: left,
                    top: top
                });
                $('#imgQqShare').css({
                    display: 'inline',
                    left: left + 30,
                    top: top
                });
            } else {
                $('#imgSinaShare').css('display', 'none');
                $('#imgQqShare').css('display', 'none');
            }
        });
        $('#imgSinaShare').click(function() {
            var txt = funGetSelectTxt(),
                title = $('title').html();
            if (txt) {
                window.open('http://v.t.sina.com.cn/share/share.php?title=' + txt + ' —— 转载自：' + title + '&url=' + window.location.href);
            }
        });
        $('#imgQqShare').click(function() {
            var txt = funGetSelectTxt(),
                title = $('title').html();
            if (txt) {
                window.open('http://v.t.qq.com/share/share.php?title=' + encodeURIComponent(txt + ' —— 转载自：' + title) + '&url=' + window.location.href);
            }
        });
    }();
});
