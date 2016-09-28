/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

jQuery(document).ready(function($) {
	//文章字体大小
	$('.resizer li').on('click',function() {
		var name = $(this).attr('id');
		if (name === 'f_s') {
			$('.post-content').stop(false, true).animate({'font-size': '-=1px','line-height': '-=1px'},'fast');
		} else if (name === 'f_l') {
			$('.post-content').stop(false, true).animate({'font-size': '+=1px','line-height': '+=1px'},'fast');
		} else if (name === 'f_m') {
			$('.post-content').animate({'font-size': '14px'},'fast').removeAttr('style');
		}
	});
	//文章伸缩栏
	$(".toggle_content").hide();
	$(".toggle_title").on('click',function(){
		$(this).toggleClass("toggle_active").next().slideToggle('fast');
		return false;
	});
	//tabs切换
	$(".bymt-tabs .tabs-title a").on("click",function(e) {
        e.preventDefault();
        $(this).parents('li').addClass('tabon').siblings('li.tabon').removeClass('tabon');
        var tab_id = $(this).parents('li').index();
        $(this).parents('.bymt-tabs').find('.tabs-content').eq(tab_id).show().siblings('.tabs-content').hide();
        return false;
    });
	//回复添加@
	$('.reply').live('click',function() {
		var atid = '"#' + $(this).parent().parent().parent().attr("id") + '"';
		var atname = $(this).parent().find('.commentid').text();
		$("#comment").val("<a href=" + atid + ">@" + atname + "</a> ").focus();
	});
	$('#cancel-comment-reply-link').live('click',function() {
		$("#comment").val('');
	});
	$(function(){
		commat_hover = function() {
			$('.comment_text a').hover( function(p) {
				var atid = $(this).attr('href').substr(1),
				atidtext =  $('#div-'+atid).html(),
				atidht = $('#div-'+atid).height();
				if(atidht==null) return false;
				$(this).before('<div id="insert_at"></div>');
				$(this).parent().parent().css('position','relative');
				$('#insert_at').stop(true,true).css({top: -(atidht+10)+"px"}).html(atidtext).fadeIn();
			},function() {
				$('#insert_at').remove();
			});
		};
		commat_hover();
	});
	//隐藏输入框
	if ($('#edit-author').length > 0) {
		$('#author-info').hide();
		$('#edit-author').live('click',function() {
			if ($('#author-info').css('display') == 'none') {
				$(this).text('[取消]');
			} else {
				$(this).text('[编辑]');
			}
			$('#author-info,#real-avatar').stop(false, true).slideToggle();
		});
	}
	//快捷回复 Ctrl+Enter
	$(document).keypress(function(e) {
		if (e.ctrlKey && e.which == 13 || e.which == 10) {
			$("#submit").click();
			document.body.focus();
		} else if (e.shiftKey && e.which == 13 || e.which == 10) {
			$("#submit").click();
		}
	});
	//弹出头像
	$('#welcome strong').hover(function() {
		var avaimg = $('#real-avatar').html();
		$('#avatar-img').html(avaimg);
		$('.user-avatar').stop(false,true).fadeIn(300);
	},function() {
		$(".user-avatar").stop(false,true).fadeOut(800);
	});
	var postid = $("#comment_post_ID").val();
	var ajaxurl = $("#comment_home_url").val();
	var ajaxlimit =1;
	//获取邮箱头像
	$('#email').live('blur',function() {
		var email = $(this).val();
		if(ajaxlimit==0) return false;
		ajaxlimit = 0;
		$.ajax({
			url: ajaxurl,
			type:'POST',
			data: "action=bymt_ajax_avatar&email="+email,
			beforeSend: function(){
				$('#real-avatar').html('<img src="'+ ajaxurl +'/wp-content/themes/BYMT/images/loading.gif" style="padding:13px;" alt=""/>');
			},
			success: function(d) {
				$('#real-avatar').html(d);
				setTimeout(function() {ajaxlimit = 1}, 3000);
			}
		});
	});
	//评论框编辑器
	$.fn.addvalue = function(value) {
	  var $t = $(this)[0];
	  if (document.selection) {
		  this.focus();
		  sel = document.selection.createRange();
		  sel.text = value;
		  this.focus();
	  }else if ($t.selectionStart || $t.selectionStart == '0') {
		  var startPos = $t.selectionStart;
		  var endPos = $t.selectionEnd;
		  var scrollTop = $t.scrollTop;
		  $t.value = $t.value.substring(0, startPos) + value + $t.value.substring(endPos, $t.value.length);
		  this.focus();
		  $t.selectionStart = startPos + value.length;
		  $t.selectionEnd = startPos + value.length;
		  $t.scrollTop = scrollTop;
	  }else {
		  this.value += value;
		  this.focus();
	  }
	};
	if(!$('#comment-tools ul >li').size()){
		$('#comment-tools').css('border','0');
		$('#comment').css('border-radius','3px');
	}
	$('#smilies-box li').on('click',function() {
		$('#comment').addvalue($(this).children('img').data('value'));
	});
	$('#add-code-ok a').on('click',function() {
		var codelang_s = $('#add-codelang-s').val(),
		codelang_i = $('#add-codelang-i').val(),
		codetext = $('#add-codetext').val();
		if(codelang_i){
			codelang = codelang_i;
		}else{
			codelang = codelang_s;
		}
		if(codetext) {
			$('#add-code-ok small').css('color','red').text('请先贴入代码');
			$('#add-codetext').focus();
		}else{
			$('li#tools-code').removeClass('tools-on');
			$('#add-code').slideUp();
			$('#add-codetext').val('');
			$('#add-code-ok small').removeAttr('style').text('无需对代码进行转义，程序会自动转义');
			$('#comment').addvalue("<pre lang=\""+ codelang +"\">\n"+codetext+"\n</pre>\n");
		}
	});
	$('#add-image-ok a').on('click',function() {
		var filter = /((http|https|ftp):\/\/){1}(.*?)\.(.*?)\w+\.(jpg|png|gif)/i,
		imgurl = $('#add-imgurl').val(),
		imgalt = $('#add-imgalt').val(),
		imginfo = '<img src="'+imgurl+'" alt="'+imgalt+'" />';
		if(imgurl=='') {
			$('#add-image-ok small').css('color','red').text('图片地址不能为空');
			$('#add-imgurl').focus();
		}else if(!filter.test(imgurl)) {
			$('#add-image-ok small').css('color','red').text('不支持该图片地址');
			$('#add-imgurl').focus();
		}else{
			$('li#tools-image').removeClass('tools-on');
			$('#add-image').slideUp();
			$('#add-imgurl,#add-imgalt').val('');
			$('#add-image-ok small').removeAttr('style').text('仅支持 .jpg .png .gif 格式的图片');
			$('#comment').addvalue(imginfo);
		}
	});
	$('#comment').on('click',function() {
		$('#smilies-box,#add-image,#add-code').slideUp();
		$('#tools-smilies,#tools-image,#tools-code').removeClass('tools-on');
	});
	$('#comment-tools li').on('click',function() {
		var T = $(this);
		var D = new Date();
		var N = D.toLocaleTimeString();
		var C = $('#comment');
		if(T.attr('id')!='tools-image' || T.attr('id')!='tools-code'){
			$('#tools-image,#tools-code').removeClass('tools-on');
			$('#add-image,#add-code').slideUp();
		}
		switch(T.attr('id')){
		case 'tools-smilies' :
			T.toggleClass('tools-on');
			$('#smilies-box').stop(true, false).slideToggle();
		break;
		case 'tools-strong' :
			C.addvalue('<strong>文字</strong>');
		break;
		case 'tools-em' :
			C.addvalue('<em>文字</em>');
		break;
		case 'tools-underline' :
			C.addvalue('<u>文字</u>');
		break;
		case 'tools-del' :
			C.addvalue('<del>文字</del>');
		break;
		case 'tools-quote' :
			C.addvalue('<blockquote>文字</blockquote>');
		break;
		case 'tools-image' :
			T.toggleClass('tools-on');
			$('#add-image').stop(true, false).slideToggle();
		break;
		case 'tools-code' :
			T.toggleClass('tools-on');
			$('#add-code').stop(true, false).slideToggle();
		break;
		case 'tools-come' :
			C.addvalue('<blockquote>签到成功！签到时间：' + N +'每日打卡，生活更精彩哦~</blockquote>');
			T.remove();
		break;
		case 'tools-good' :
			C.addvalue('<blockquote> :grin:  :grin: 好羞射，文章真的好赞啊，顶博主！</blockquote>');
			T.remove();
		break;
		case 'tools-bad' :
			C.addvalue('<blockquote> :twisted:  :twisted: 有点看不懂哦，希望下次写的简单易懂一点！</blockquote>');
			T.remove();
		break;
		case 'tools-admin' :
			C.addvalue('[private]管理员可见的内容[/private]');
		break;
		default:
			return false;
		}
	});
	//ajax提交评论
	if (0 < $("#comment_form").length) {
		var s = $("#comment_form"),
		t = '<i class="icon-error"></i>',
		u = '<div id="loading"><img src="' + (ajaxurl + "/wp-content/themes/BYMT/images/loading.gif") + '" alt=""/> \u6b63\u5728\u63d0\u4ea4, \u8bf7\u7a0d\u5019...</div>',
		v = '"><i class="icon-ok"></i> \u63d0\u4ea4\u6210\u529f',
		i,
		d = 0,
		m = [],
		n = $("#cancel-comment-reply-link"),
		w = n.text(),
		f = $("#submit");
		f.attr("disabled", !1);
		$body = window.opera ? "CSS1Compat" == document.compatMode ? $("html") : $("body") : $("html,body");
		$(".comment-btns").before(u + '<div id="error"></div>');
		$("#loading").hide();
		$("#error").hide();
		if (!$(".commentlist").length) {
			$(".respond").before('<ol class="commentlist"></ol>');
		}
		s.submit(function() {
			$("#comment").attr("readonly", !0);
			$("#loading").slideDown();
			f.attr("disabled", !0).fadeTo("slow", 0.65);
			if (i) {
				$("#comment").after('<input type="text" name="edit_id" id="edit_id" value="' + i + '" style="display:none;" />');
			}
			$.ajax({
				url: ajaxurl,
				data: $(this).serialize() + "&action=bymt_ajax_comment",
				type: 'POST',
				complete: function(b) {
					var data = b.responseText;
					if (data.substr(0, 8) === 'Error!!!') {
						$("#loading").slideUp();
						$("#error").slideDown().html(t + data.substr(8));
						setTimeout(function() {
							$("#comment").attr("readonly", !1);
							f.attr("disabled", !1).fadeTo("slow", 1);
							$("#error").slideUp();
						},3E3);
						return false;
					}
					$("#loading").hide();
					$("#comment").attr("readonly", !1);
					m.push($("#comment").val());
					$("textarea").each(function() {
						this.value = "";
					});
					var c = addComment,
					g = c.I("cancel-comment-reply-link"),
					e = c.I("wp-temp-form-div"),
					h = c.I(c.respondId);
					c.I("comment_post_ID");
					var o = c.I("comment_parent").value;
					new_htm = 'id="new_comm_' + d + '"></';
					new_htm = "0" == o ? "<div " + new_htm + "div>": '\n<ul class="children' + new_htm + "ul>";
					ok_htm = '\n<span id="success' + v;
					ok_htm += "</span>\n";
					if ("0" === o) {
						$(".commentlist").append(new_htm);
					} else {
						$("#respond").before(new_htm);
					}
					$("#new_comm_" + d).hide().append(data);
					$("#new_comm_" + d + " .comment-body").append(ok_htm);
					$("#new_comm_" + d).fadeIn(4E3);
					$("#comments-number").text(parseInt($("#comments-number").text()) + 1);
					$body.animate({scrollTop: $("#new_comm_" + d).offset().top - 200},900);
					p();
					d++;
					i = "";
					$("*").remove("#edit_id");
					g.style.display = "none";
					g.onclick = null;
					c.I("comment_parent").value = "0";
					if (e && h) {
						e.parentNode.insertBefore(h, e);
						e.parentNode.removeChild(e);
					}
					code_highlight();
					images_error();
					mouse_title();
					commat_hover();
				}
			});
			return !1;
		});
		addComment = {
			moveForm: function(b, c, g, e, h) {
				var d = this.I(g),
				f = this.I("cancel-comment-reply-link"),
				k = this.I("comment_parent"),
				j = this.I("comment_post_ID");
				b = this.I(b);
				if (i) {
					q();
				}
				0 < m.length && h ? (this.I("comment").value = m[h], i = this.I("new_comm_" + h).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $("#success_" + h), $new_sucs.hide(), $new_comm = $("#new_comm_" + h), $new_comm.hide(), n.text("\u53d6\u6d88\u7f16\u8f91")) : n.text(w);
				this.respondId = g;
				e = e || !1;
				this.I("wp-temp-form-div") || (g = document.createElement("div"), g.id = "wp-temp-form-div", g.style.display = "none", d.parentNode.insertBefore(g, d)); ! b ? (temp = this.I("wp-temp-form-div"), this.I("comment_parent").value = "0", temp.parentNode.insertBefore(d, temp), temp.parentNode.removeChild(temp)) : b.parentNode.insertBefore(d, b.nextSibling);
				$body.animate({scrollTop: $("#respond").offset().top - 180},400);
				j && e && (j.value = e);
				k.value = c;
				f.style.display = "";
				f.onclick = function() {
					i && q();
					var a = addComment,
					b = a.I("wp-temp-form-div"),
					c = a.I(a.respondId);
					a.I("comment_parent").value = "0";
					if (b && c) {
						b.parentNode.insertBefore(c, b);
						b.parentNode.removeChild(b);
					}
					this.style.display = "none";
					this.onclick = null;
					return false;
				};
				try {
					this.I("comment").focus();
				} catch(l) {}
				return !1;
			},
			I: function(a) {
				return document.getElementById(a);
			}
		};
		var q = function() {
			$new_comm.show();
			$new_sucs.show();
			$("textarea").each(function() {
				this.value = "";
			});
			i = "";
		},
		j = 5,
		x = f.val(),
		p = function() {
			0 < j ? (f.val(j), j--, setTimeout(p, 1E3)) : (f.val(x).attr("disabled", !1).fadeTo("slow", 1), j = 5);
		};
	}
	//ajax评论翻页
	if ($("#wrapper-inner").attr("data-bymts").indexOf("ajax-comment") >= 0) {
		var l = $(".commentshow"),
		y = postid,
		r = ajaxurl,
		z = '<div id="ajax_loading"></div>';
		l.on("click", ".pagination a", function(e) {
			e.preventDefault();
			var b = $(this).attr("href"),
			c = 1;
			/comment-page-/i.test(b) ? c = b.split(/comment-page-/i)[1].split(/(\/|#|&).*$/)[0] : /cpage=/i.test(b) && (c = b.split(/cpage=/)[1].split(/(\/|#|&).*$/)[0]);
			$.ajax({
				url: r + "?action=bymt_ajax_pagenavi&post=" + y + "&page=" + c,
				dataType:"html",
				beforeSend: function() {
					l.html(z);
					if ($("body").attr("class").indexOf("admin-bar") >= 0) {
						$("body, html").animate({scrollTop: l.offset().top - 40},'slow');
					} else {
						$("body, html").animate({scrollTop: l.offset().top - 12},'slow');
					}
				},
				error: function(a) {
					l.html(a.responseText);
				},
				success: function(b) {
					l.html(b);
				},
				complete: function(){
					code_highlight();
					images_error();
					check_thumb();
					auto_sidebar();
					mouse_title();
					commat_hover();
				}
			});
		});
	}
});
