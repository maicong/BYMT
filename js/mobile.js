/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

jQuery(document).ready(function($) {
	//菜单
	$('#main-nav ul li:has(ul) > a').css("display","initial").append('<b class="caret"></b>');
	$("#mobile-nav").on("click",function(a) {
		a.preventDefault();
   		$("#main-nav").stop(false,true).slideToggle();
	});
	$('#main-nav ul li:has(ul)').on("click",function() {
		$(this).children('ul').stop(false,true).slideDown();
	});
	//焦点图上下按钮
	$(".slideBox ul").each(function() {
		if($(this).children("li").size()<2){
			$(this).parent().parent().children(".prev,.next").remove();
		}
	});
	code_highlight = function(){
		if($("#wrapper-inner").attr("data-bymts").indexOf("highlight") >= 0 ){
			$('pre').each(function(i, e) {hljs.highlightBlock(e);});
		}
	};
	images_error = function(){	/* 图片加载失败 */
		$('img').error(function () {
			var ersrc = $(this).attr("src"),
			home_url = $('#logo a').attr('href');
			$(this).unbind("error").attr({"data-original":ersrc,"src":home_url+"wp-content/themes/BYMT/images/images_error.jpg"});
		});
	};
	check_thumb = function(){	/* 检查缩略图 */
		$('.post-thumbnail img').each(function() {
			var home_url = $('#logo a').attr('href');
			if($(this).attr('src')==''){
				$(this).attr('src',home_url+'wp-content/themes/BYMT/images/random/BYMT'+Math.floor(1+Math.random()*(21-1))+'.jpg');
			}
		});
	};
	code_highlight();
	images_error();
	check_thumb();
	//广告后加载
	function speed_ads(loader, ad) {
		ad = document.getElementById(ad);
		loader = document.getElementById(loader);
		if (ad && loader) {
			ad.appendChild(loader);
			loader.style.display='block';
			ad.style.display='block';
		}
	}
	window.onload=function() {
		speed_ads('adsense-loader1', 'adsense1');
		speed_ads('adsense-loader2', 'adsense2');
		speed_ads('adsense-loader3', 'adsense3');
		speed_ads('adsense-loader4', 'adsense4');
		speed_ads('adsense-loader5', 'adsense5');
		speed_ads('adsense-loader6', 'adsense6');
		speed_ads('adsense-loader7', 'adsense7');
		speed_ads('adsense-loader8', 'adsense8');
		speed_ads('adsense-loader9', 'adsense9');
		speed_ads('adsense-loader10', 'adsense10');
		speed_ads('adsense-loader11', 'adsense11');
	};
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
        $(this).parents('.bymt-tabs').find('.tabs-content').eq(tab_id).fadeIn().siblings('.tabs-content').hide();
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
	//ajax提交评论
	var ajaxurl = bymt.ajaxurl;
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
});
