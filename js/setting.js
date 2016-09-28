/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

$(function() {
	if ($.browser.msie &&($.browser.version <= 8)) {
		$(".bymt_setwrap").html("<h2>检测到您的浏览器版本过低！！！！！！</h2>");
		setTimeout(function(){$(".bymt_setwrap").append("<h2>ERROR110 程序已经崩溃，正在重启...</h2>")},2000);
		setTimeout(function(){$(".bymt_setwrap").append("<h2>ERROR120 重启失败，正在重新重启...</h2>")},4000);
		setTimeout(function(){$(".bymt_setwrap").append("<h2>ERROR119 无法重启，3秒后自动摧毁...</h2>")},6000);
		setTimeout(function(){$(".bymt_setwrap").append('<h2>程序已经摧毁，请联系 <a href="http://www.yuxiaoxi.com/">麦田一根葱</a> 重新获取！</h2>')},9000);
		setTimeout(function(){$(".bymt_setwrap").append('<h2>哥/姐，你已经在这里停留了半分钟了，难道还不知道换个浏览器吗？</h2>')},30000);
	}
	$("ul.nav").each(function() {
		$(this).children("li:first").addClass("active");
	});
	$("#bymt_config > *").removeClass("bymt_nodisplay").hide();
	$("#bymt_config > *:first-child").show();
	$("#bymt_config").removeClass("loading");
	$("#loadtext").hide();
	$("ul.nav li a").click(function(evt) {
		This =  $(this).parent("li");
		var clicked_id = This.attr("id");
		This.parent().children("li").removeClass("active");
		This.addClass("active");
		This.parent().parent().children("#bymt_config").children("*").hide();
		$("#bymt_config " + clicked_id).fadeIn(300);
		evt.preventDefault();
	});

	$("#go_slides").click(function(){
		$("ul.nav li").eq(1).removeClass("active");
    	$("ul.nav li").eq(6).addClass("active");
		$("#bymt_config #li_show").hide();
		$("#bymt_config #li_slides").fadeIn(300);
 	});

	$("input[type='number']").on('input',function(){
		var re = /^[1-9]+[0-9]*]*$/;
		if (!re.test($(this).val())){
			$(this).val("");
		}
	});

	$("input.cktype_r:checked").each(function() {
		$(this).parents().children(".bymt_children").show();
	});
	$("input.cktype_r").click(function() {
		if ($(this).is(":checked")) {
			$(this).parents().children(".bymt_children").slideDown("fast");
		} else {
			$(this).parents().children(".bymt_children").slideUp("fast");
		}
	});
	$("input.cktype_l").click(function() {
		if ($(this).is(":checked")) {
			$(this).parents().children(".bymt_children").slideUp("fast");
		} else {
			$(this).parents().children(".bymt_children").slideDown("fast");
		}
	});
	$("input#cklogotxt:checked").each(function() {
		$("div.logotitle,div.logodesc").show();
		$("div.logoimg").hide();
	});
	$("input#logoimg2:checked").each(function() {
		$("div.logoimg .bymt_children").show();
	});
	$("input#logodesc2:checked").each(function() {
		$("div.logodesc .bymt_children").show();
	});
	$("input#cklogoimg").click(function() {
		$("div.logoimg").slideDown("fast");
		$("div.logotitle,div.logodesc").hide();
	});
	$("input#cklogotxt").click(function() {
		$("div.logotitle,div.logodesc").slideDown("fast");
		$("div.logoimg").hide();
	});
		$("input#logoimg2").click(function() {
		if ($(this).is(":checked")) {
			$("div.logoimg .bymt_children").slideDown("fast");
			$("div.logotitle,div.logodesc").hide();
		} else {
			$("div.logoimg .bymt_children").slideUp("fast");
		}
	});
	$("input#logoimg1").click(function() {
		if ($(this).is(":checked")) {
			$("div.logoimg .bymt_children").slideUp("fast");
			$("div.logotitle,div.logodesc").hide();
		} else {
			$("div.logoimg .bymt_children").slideDown("fast");
		}
	});
	$("input#logodesc2").click(function() {
		if ($(this).is(":checked")) {
			$("div.logodesc .bymt_children").slideDown("fast");
			$("div.logoimg").hide();
		} else {
			$("div.logodesc .bymt_children").slideUp("fast");
		}
	});
	$("input#logodesc1").click(function() {
		if ($(this).is(":checked")) {
			$("div.logodesc .bymt_children").slideUp("fast");
			$("div.logoimg").hide();
		} else {
			$("div.logodesc .bymt_children").slideDown("fast");
		}
	});
	$(".msg_s,.msg_r").hover(setTimeout(function(){
		$(".msg_s,.msg_r").animate({marginLeft:'850px'},function(){$(this).removeAttr("style").hide()});
		},3000));
	$("input[name='reset']").click(function(){
		$(".overlay").fadeIn();
		return false;
	});
	$("#reset-submit").click(function(){
		$("#form2").submit();
		$(".overlay").fadeOut();
	});
	$("#reset-cancel").click(function(){
		$(".overlay").fadeOut();
	});
	$(".overlay").click(function(e){
		if(e.target.className!="overlay"){
			return false;
		}
		$(".overlay").fadeOut();
	});
    $(".field > #upload_ck").click(function() {
		upid = $(this).prev().attr("id");
        targetfield = $(this).prev("#"+upid);
        tb_show("", "media-upload.php?width=626&type=image&amp;TB_iframe=true");
        return false;
    });
    window.send_to_editor = function(html) {
        imgurl = $("img",html).attr("src");
        $(targetfield).val(imgurl);
        tb_remove();
    };
	$("input[name='bymt_options[ggid]']").on("input",function() {
		if($("input[name='bymt_options[ggid]']").val()!=""){
			$("textarea[name='bymt_options[noticecontent]']").attr("disabled",true);
		}else{
			$("textarea[name='bymt_options[noticecontent]']").attr("disabled",false);
		}
	});
	$("textarea[name='bymt_options[noticecontent]']").on("input",function() {
		if($("textarea[name='bymt_options[noticecontent]']").val()!=""){
			$("input[name='bymt_options[ggid]']").attr("disabled",true);
		}else{
			$("input[name='bymt_options[ggid]']").attr("disabled",false);
		}
	});
	$("input[name='sd_imgst']:checked").each(function() {
		var thisid = $(this).attr("id");
		$("."+thisid).show();
	});
	$("input[name='sd_imgst']").click(function() {
		var thisid = $(this).attr("id");
		$("."+thisid).parents().children(".bymt_children").slideUp("fast");
		$("."+thisid).slideDown("fast");
	});
	$("input.type:checked").each(function() {
		var thisid = $(this).attr("id");
		$("."+thisid).show();
	});
	$("input.type").click(function() {
		var thisid = $(this).attr("id");
		$("."+thisid).siblings(".bymt_children").slideUp("fast");
		$("."+thisid).slideDown("fast");
	});
	$("input.handck_r:checked").each(function() {
		$(this).parent().parent().parent().children(".bymt_children").show();
	});
	$("input.handck_r").click(function() {
		if ($(this).is(":checked")) {
			$(this).parent().parent().parent().children(".bymt_children").slideDown("fast");
		} else {
			$(this).parent().parent().parent().children(".bymt_children").slideUp("fast");
		}
	});
	$("input.handck_l").click(function() {
		if ($(this).is(":checked")) {
			$(this).parent().parent().parent().children(".bymt_children").slideUp("fast");
		} else {
			$(this).parent().parent().parent().children(".bymt_children").slideDown("fast");
		}
	});
	$("input[type='checkbox']:checked").each(function() {
		var checkid = $(this).attr("id").substr(0,13);
		$("#"+checkid).show();
	});
	$("input[type='checkbox']").click(function() {
		var checkid = $(this).attr("id").substr(0,13);
		if ($(this).is(":checked")) {
			$("#"+checkid).slideDown("fast");
		} else {
			$("#"+checkid).slideUp("fast");
		}
	});
	$.fn.pagination = function(maxentries, opts) {
		opts = $.extend({
			items_per_page: 10,
			num_display_entries: 10,
			current_page: 0,
			num_edge_entries: 0,
			link_to: "#",
			prev_text: "&laquo; 上一页",
			next_text: "下一页 &raquo;",
			ellipse_text: "...",
			prev_show_always: true,
			next_show_always: true,
			callback: function() {
				return false;
			}
		},
		opts || {});
		return this.each(function() {
			function numPages() {
				return Math.ceil(maxentries / opts.items_per_page);
			}
			function getInterval() {
				var ne_half = Math.ceil(opts.num_display_entries / 2);
				var np = numPages();
				var upper_limit = np - opts.num_display_entries;
				var start = current_page > ne_half ? Math.max(Math.min(current_page - ne_half, upper_limit), 0) : 0;
				var end = current_page > ne_half ? Math.min(current_page + ne_half, np) : Math.min(opts.num_display_entries, np);
				return [start, end];
			}
			function pageSelected(page_id, evt) {
				current_page = page_id;
				drawLinks();
				var continuePropagation = opts.callback(page_id, panel);
				if (!continuePropagation) {
					if (evt.stopPropagation) {
						evt.stopPropagation();
					}
					 else {
						evt.cancelBubble = true;
					}
				}
				return continuePropagation;
			}
			function drawLinks() {
				panel.empty();
				var interval = getInterval();
				var np = numPages();
				var getClickHandler = function(page_id) {
					return function(evt) {
						return pageSelected(page_id, evt);
					};
				};
				var appendItem = function(page_id, appendopts) {
					page_id = page_id < 0 ? 0: (page_id < np ? page_id: np - 1);
					appendopts = $.extend({
						text: page_id + 1,
						classes: ""
					},
					appendopts || {});
					if (page_id == current_page) {
						var lnk = $("<span class='current'>" + (appendopts.text) + "</span>");
					} else {
						var lnk = $("<a>" + (appendopts.text) + "</a>").bind("click", getClickHandler(page_id)).attr('href', opts.link_to.replace(/__id__/, page_id));
					}
					if (appendopts.classes) {
						lnk.addClass(appendopts.classes);
					}
					panel.append(lnk);
				};
				if (opts.prev_text && (current_page > 0 || opts.prev_show_always)) {
					appendItem(current_page - 1, {
						text: opts.prev_text,
						classes: "prev"
					});
				}
				if (interval[0] > 0 && opts.num_edge_entries > 0)
				 {
					var end = Math.min(opts.num_edge_entries, interval[0]);
					for (var i = 0; i < end; i++) {
						appendItem(i);
					}
					if (opts.num_edge_entries < interval[0] && opts.ellipse_text)
					 {
						$("<span>" + opts.ellipse_text + "</span>").appendTo(panel);
					}
				}
				for (var i = interval[0]; i < interval[1]; i++) {
					appendItem(i);
				}
				if (interval[1] < np && opts.num_edge_entries > 0)
				 {
					if (np - opts.num_edge_entries > interval[1] && opts.ellipse_text)
					 {
						$("<span>" + opts.ellipse_text + "</span>").appendTo(panel);
					}
					var begin = Math.max(np - opts.num_edge_entries, interval[1]);
					for (var i = begin; i < np; i++) {
						appendItem(i);
					}
				}
				if (opts.next_text && (current_page < np - 1 || opts.next_show_always)) {
					appendItem(current_page + 1, {
						text: opts.next_text,
						classes: "next"
					});
				}
			}
			var current_page = opts.current_page;
			maxentries = (!maxentries || maxentries < 0) ? 1: maxentries;
			opts.items_per_page = (!opts.items_per_page || opts.items_per_page < 0) ? 1: opts.items_per_page;
			var panel = $(this);
			this.selectPage = function(page_id) {
				pageSelected(page_id);
			};
			this.prevPage = function() {
				if (current_page > 0) {
					pageSelected(current_page - 1);
					return true;
				}
				 else {
					return false;
				}
			};
			this.nextPage = function() {
				if (current_page < numPages() - 1) {
					pageSelected(current_page + 1);
					return true;
				}
				 else {
					return false;
				}
			};
			drawLinks();
			opts.callback(current_page, this);
		});
	};
	$(function(){
		var length = $("tr#vote_list").length;
		if($("tr#vote_list").length>20){
			$("#vote_paged").show();
		}
		var initPagination = function(){
			$("#vote_paged").pagination(length, {
				num_edge_entries: 3,
				num_display_entries: 3,
				callback: pageselectCallback,
				items_per_page:20
			});
		 }();
		function pageselectCallback(page_index, jq){
			var max_elem = Math.min((page_index+1) * 20, length);
			$("tr#vote_list").hide();
			for(var i=page_index*20;i<max_elem;i++){
				$("tr#vote_list").eq(i).fadeIn();
			}
			return false;
		}
	});
});
