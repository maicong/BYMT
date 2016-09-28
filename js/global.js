/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

jQuery(document).ready(function($) {
	//操作cookie
	$.cookie = function(b, j, m) {
		if (typeof j != "undefined") {
			m = m || {};
			if (j === null) { j = ""; m.expires = -1; }
			var e = "";
			if (m.expires && (typeof m.expires == "number" || m.expires.toUTCString)) {
				var f;
				if (typeof m.expires == "number") {
					f = new Date();
					f.setTime(f.getTime() + (m.expires * 24 * 60 * 60 * 1000))
				} else {
					f = m.expires
				}
				e = "; expires=" + f.toUTCString();
			}
			var l = m.path ? "; path=" + (m.path) : "",
			g = m.domain ? "; domain=" + (m.domain) : "",
			a = m.secure ? "; secure": "";
			document.cookie = [b, "=", encodeURIComponent(j), e, l, g, a].join("");
		} else {
			var d = null;
			if (document.cookie && document.cookie != "") {
				var k = document.cookie.split(";");
				for (var h = 0; h < k.length; h++) {
					var c = $.trim(k[h]);
					if (c.substring(0, b.length + 1) == (b + "=")) {
						d = decodeURIComponent(c.substring(b.length + 1));
						break;
					}
				}
			}
			return d;
		}
	};

	//加载中特效
	$("#circle,#circle1,#circletext").show(100);
	$("#circletext").text("加载中");
	$(window).load(function() {
		$("#circle").fadeOut(400);
		$("#circle1").fadeOut(600);
		$("#circletext").text("完成了").fadeOut(800);
	});

	//菜单
	if ($.browser.msie && ($.browser.version < 8)) {
		$('#nav-menu li:has(> ul) > a').append('');
	}else{
		$('#nav-menu li:has(> ul) > a').append('<b class="caret"></b>');
	}
	$('#nav-menu li').hover(function(){
		$(this).children('ul').stop(false,true).slideDown("fast");
	},function(){
		$(this).children('ul').stop(false,true).slideUp("fast");
	});
	$('#mobile-nav').on("click",function(a){
		a.preventDefault();
		$(' #nav-menu').stop(false,true).slideToggle("slow");
		$('#nav-menu ul li:has(ul) > a').css("display", "initial");
    });

	//搜索框
	$("#search-input").removeAttr("placeholder");
	if($("#search-input").val()!=""){
		$("#search-input").css("width","205px");
	}
	$("#search-input").on('click',function(){
		var tips = $(this).attr("data-searchtips");
		$(this).stop(false,true).animate({width:"205px"},"fast");
		$(this).attr("placeholder",tips);
	}).blur(function(){
		if($(this).val()==""){
			$(this).stop(false,true).animate({width:"107px"},"fast");
			$(this).removeAttr("placeholder");
		}
	});

	//侧边栏TAB效果
	$('#widget_tab').hover(function(){
		clearInterval(w_tab_auto);
		$('.tab-title span').on('click',function(){
			$(this).addClass("selected").siblings().removeClass("selected");
			if ($.browser.msie && ($.browser.version < 8)) {
				$(".tab-content > ul").eq($('.tab-title span').index(this)).show().siblings().hide();
			}else{
				$(".tab-content > ul").eq($('.tab-title span').index(this)).slideDown(300).siblings().slideUp(300);
			}
		});
	},function () {
		var w_tab_o = $('.tab-title span').index(this),
		w_tab_cont = $(".tab-content ul"),
		w_tab_title = $(".tab-title span");
		w_tab_auto = setInterval(function () {
			w_tab_o < w_tab_cont.length - 1 ? w_tab_o++ : w_tab_o = 0;
			if ($.browser.msie && ($.browser.version < 8)) {
				w_tab_cont.eq(w_tab_o).show().siblings().hide();
			}else{
				w_tab_cont.eq(w_tab_o).slideDown(800).siblings().slideUp(800);
			}
			w_tab_title.eq(w_tab_o).addClass("selected").siblings().removeClass("selected");
		},5000);
	}).trigger("mouseleave");

	//检测侧边栏
	if($.cookie('bymt_sidebar')=='close'){
		$('#sidebar').hide(800);
		$('#content-list,#content-main').animate({"width":"99.7%"},800);
		$('#f_c').hide(300);
		$('#f_o').show(500);
	}

	//关闭侧边栏
	$('#f_c').on('click',function(){
		$('#sidebar').hide(800);
		$('#content-main').animate({"width":"99.7%"},800);
		$('#f_c').hide(300);
		$('#f_o').show(500);
		$.cookie('bymt_sidebar', 'close', {path:"/"});
	});

	//打开侧边栏
	$('#f_o').on('click',function(){
		$('#sidebar').show(800);
		$('#content-main').animate({"width":"72%"},800);
		$('#f_o').hide(300);
		$('#f_c').show(500);
		$.cookie('bymt_sidebar', null, {path:"/"});
	});

	//返回顶部
	$(window).on("scroll",function(){
		if ($(this).scrollTop() > 100) {
			$('#backtop').css({bottom:"1px"}).attr("title", "返回顶部");
		} else {
			$('#backtop').css({bottom:"-100px"});
		}
	});
	$('#backtop').on('click',function(){
		$('html, body').animate({scrollTop: '0px'}, 500);
		return false;
	});

	//图片渐隐
	$('img').hover(function() {
		$(this).stop(false,true).fadeTo("fast", 0.8);
	},function() {
		$(this).stop(false,true).fadeTo("fast", 1);
	});

	//新窗口打开
	$("a[rel*='external']").live('click',function(){
		window.open(this.href);
		return false;
	});

	//焦点图上下按钮
	$(".slideBox ul").each(function() {
		if($(this).children("li").size()<2){
			$(this).parent().parent().children(".prev,.next").remove();
		}
	});
	$(function(){
		code_highlight = function(){
			if($("#wrapper-inner").attr("data-bymts").indexOf("highlight") >= 0 ){
				$('pre').each(function(i, e) {hljs.highlightBlock(e);});
			}
		}
		code_highlight();
		images_error = function(){	/* 图片加载失败 */
			$('img').error(function () {
				var src = $(this).attr("src"),
				url = $('#logo a').attr('href');
				$(this).unbind("error").attr({"data-original":src,"src":url+"wp-content/themes/BYMT/images/images_error.jpg"});
			});
		}
		images_error();
		check_thumb = function(){	/* 检查缩略图 */
			$('.post-thumbnail img').each(function() {
				var url = $('#logo a').attr('href');
				if($(this).attr('src')==''){
					$(this).attr('src',url+'wp-content/themes/BYMT/images/random/BYMT'+Math.floor(1+Math.random()*(21-1))+'.jpg');
				}
			});
		}
		check_thumb();
		auto_sidebar = function(){	/* 侧边栏高度自适应 */
			$('#sidebar').each(function(){
			  var conH = $('#content-wrap > div')[0].offsetHeight,
			  widS = $('#sidebar > .widget').size(),
			  widH = [],widHs = 0;
			  for(var i = 0; i < widS; i++){
				  widH[i] = $('.widget')[i].offsetHeight;
				  widHs += widH[i];
				  $('#sidebar > .widget').show();
				  if(widHs > conH){
					  $('#sidebar > .widget').eq(i-1).nextAll('.widget').hide();
					  break;
				  }
			  }
			});
		}
		auto_sidebar();
		mouse_title = function() {	/* 鼠标title样式 */
			if($("#wrapper-inner").attr("data-bymts").indexOf("mouse-title") >= 0 ){
			  $("#wrapper-inner *").each(function(b) {
				  if (this.title) {
					  var c = this.title, a = 30, z = 15;
					  $(this).hover(function(d) {
						  this.title = "";
						  $("body").append('<div class="tooltip">' + c + "</div>");
						  $(".tooltip").css({left:(d.pageX - z) + "px",top: (d.pageY + a) + "px",opacity: "0.8"}).fadeIn(300);
					  },function() {
						  this.title = c;
						  $(".tooltip").remove();
					  }).mousemove(function(d) {
						  $(".tooltip").css({left:(d.pageX - z) + "px",top: (d.pageY + a) + "px"});
					  });
				  }
			  });
			}
		}
		mouse_title();
	});
	//广告后加载
	function speed_ads(loader, ad) {
		var ad = document.getElementById(ad),
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

	//边栏跟随滚动
	$.fn.smartFloat = function() {
		var position = function(element) {
			var top = element.position().top, pos = element.css("position"),
			sidebar = document.getElementById("sidebar").offsetHeight;
			$(window).scroll(function() {
				var scrolls = $(this).scrollTop();
				if (scrolls > sidebar) {
					if (window.XMLHttpRequest) {
						if($("body").attr("class").indexOf("admin-bar") >= 0 ){
							element.css({position: "fixed",top: 35});
						}else{
							element.css({position: "fixed",top: 5});
						}
					} else {
						element.css({top: scrolls});
					}
				}else {
					element.css({position: pos,top: top});
				}
			});
		};
		return $(this).each(function() {
			position($(this));
		});
	};
	var fixedid = $("#sidebar div.fixed").attr("id");
	$("#"+fixedid).smartFloat();

	//ajax文章列表翻页
	if($("#wrapper-inner").attr("data-bymts").indexOf("ajax-posts")>=0){
    var n = null, H = false, i = document.title, t, h = window.opera ? document.compatMode == "CSS1Compat" ? $("html") :$("body") :$("html,body");
    if (window.history && window.history.pushState) {
        $(document).on("click", "#content-list .pagination a", function(b) {
            b.preventDefault();
            if (n == null) {
                t = {
                    url:document.location.href,
                    title:document.title,
                    html:$("#content-list").html(),
                    top:h.scrollTop()
                };
            } else {
                n.abort();
            }
            t.top = h.scrollTop();
            var q = $(this).attr("href").replace("?action=ajax_posts", "");
			$("#tooltip").remove();
            $("#content-list").html('<div id="ajax_loading"></div>');
			$('html, body').animate({scrollTop: '0px'}, 500 );
            n = $.ajax({
                url:q + "?action=ajax_posts",
				beforeSend: function(){
					$('.tooltip').remove();
				},
                success:function(v) {
                    H = true;
                    var state = {
                        url:q,
                        title:i,
                        html:v
                    };
                    history.pushState(state, i, q);
                    document.title = i;
                    h.animate({scrollTop: 0},0);
                    $("#content-list").html(v);
                },
				complete: function(){
					images_error();
					check_thumb();
					auto_sidebar();
					mouse_title();
				}
            });
            return false;
        });
        window.addEventListener("popstate", function(i) {
            if (n == null) {
                return;
            } else {
                if (i && i.state) {
                    H = true;
                    document.title = i.state.title;
                    $("#content-list").html(i.state.html);
                } else {
                    H = false;
                    document.title = t.title;
                    $("#content-list").html(t.html);
                    h.animate({
                        scrollTop: t.top
                    },
                    0);
                }
            }
        });
   	 }
	}

	//ajax搜索
	if($("#wrapper-inner").attr("data-bymts").indexOf("ajax-search") >= 0){
		var last,ajaxurl = $('#logo a').attr('href');
		$("#search-input").on('input', function (e){
			last = e.timeStamp;
			var keys = $(this).val().replace(/\s+/g, ' ');
			if(keys == ' ') return false;
			if(keys != ''){
				setTimeout(function(){
					if(last-e.timeStamp==0){
						$.ajax({
							type: "GET",
							url: ajaxurl,
							data: "s=" + keys,
							dataType: 'json',
							beforeSend:function(){
								$("#search-cloud").empty().show().addClass("loading");
								$("#search-input").css('border-radius','3px 0 0 0');
							},
							success: function (r) {
								var rlength = r.length,
								cloudnum = $("#search-cloud").data("cloudnum");
								if(cloudnum=="all") cloudnum = r.length;
								if(rlength <= cloudnum){
									num = rlength;
								}else{
									num = cloudnum;
								}
								if(r.length == 0){
									$("#search-cloud").empty().show().removeClass("loading").append('<li><a href="javascript:;">没有找到你要搜索的内容</a></li>');
								}else{
									$("#search-cloud").empty().show().removeClass("loading");
									for (var i = 0; i < num; i++) $("#search-cloud").append('<li><a href="' + r[i]["url"] + '">' + r[i]["title"] + '</a></li>');
								}
							}
						});
					}
				},500);
			}else{
			$("#search-cloud").empty().hide();
			$("#search-input").css('border-radius','3px 0 0 3px');
			}
		}).blur(function(){
			var keys = $(this).val().replace(/\s+/g, ' ');
			if(keys=='' || keys== ' '){
				$("#search-cloud").empty().hide();
				$("#search-input").css('border-radius','3px 0 0 3px');
			}
		});
	}
});
