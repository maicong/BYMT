/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

jQuery(document).ready(function($) {
	var bymt_token = 1,home_url = $('#logo a').attr('href'),
	vote_ajax_url = home_url + 'wp-admin/admin-ajax.php';
	function getCookie(name) {
    var start = document.cookie.indexOf( name + "=" );
    var len = start + name.length + 1;
    if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) )
        return null;
    if ( start == -1 )
        return null;
    var end = document.cookie.indexOf( ';', len );
    if ( end == -1 )
        end = document.cookie.length;
    return unescape( document.cookie.substring( len, end ) );
	}
    $('.vote_up,.vote_down').on('click',function(p){
		var loading='<img src="'+ home_url +'wp-content/themes/BYMT/images/ajaxload.gif">';
		var commid = $(this).siblings(".datetime").attr("id");
		var voteid = commid.substr(5);
		var pointX = p.pageX;
	  	var pointY = p.pageY;
		function vote_show(text) {
			$(".vote_ok").stop(true,true).css({left:(pointX - 12) + "px",top: (pointY - 40) + "px"}).html(text).fadeIn(300);
			setTimeout(function() {$(".vote_ok").fadeOut(800)}, 1000);
		}
		if(getCookie('bymt_voted_'+voteid)!=null) {
			vote_show('您已经表过态了！');
            return false;
		}
        if( bymt_token != 1 ) {
             vote_show('您的鼠标点得也太快了吧！');
            return false;
        }
		if(!$.isNumeric(voteid)||($(this).attr('class')!='vote_up icon-up-1'&&$(this).attr('class')!='vote_down icon-down-1')){
			vote_show('你要做什么？');
			return false;
		}
		if($(this).attr('class')=='vote_up icon-up-1'){
			var rating = 'up';
			vote_s='顶了一下';
		}else if($(this).attr('class')=='vote_down icon-down-1'){
			var rating = 'down';
			vote_s='踩了一脚';
		}
		bymt_token = 0;
        $.ajax({
			type:'POST',
            url:vote_ajax_url,
            data:'action=vote_comm&rating=' + rating + '&commid=' + voteid,
			dataType: 'text',
			beforeSend: function() {
				vote_show(loading);
			},
            success:function(results){
                if (results=='y'){
                    $("#"+rating+'_'+voteid).text(parseInt($("#"+rating+'_'+voteid).text())+1);
					vote_show(vote_s);
				}else if (results=='h'){
					vote_show('您已经表过态了！');
                }else if(results=='n'||results=='e'){
					vote_show('失败了，请重试');
				}else{
					vote_show('未知错误');
				}
            },
			error: function() {
				vote_show('失败了，请重试');
			},
			complete: function(){setTimeout(function() {bymt_token = 1}, 1500); }
        });
    });
});
