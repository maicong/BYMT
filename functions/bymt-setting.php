<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/119
 * @version     2.1.2
 */

if (function_exists('get_custom_header')){
	add_theme_support('custom-background');
}
add_action('admin_menu', 'bymt_menu_page');
function bymt_menu_page(){
    add_menu_page('BYMT设置', 'BYMT设置', 'administrator', 'bymt_setting', 'bymt_settings_page', get_stylesheet_directory_uri().'/images/icon_setting.png', 50);
	add_submenu_page('bymt_setting', '主题短代码', '主题短代码', 'administrator', 'shortcode_page', 'bymt_setting');
	add_submenu_page('bymt_setting', '背景设置', '背景设置', 'administrator', 'custom-background', 'bymt_setting');
}
add_action('admin_menu', 'bymt_theme_page');
function bymt_theme_page() {
	add_theme_page(__( '主题设置', 'bymt' ), __( '主题设置', 'bymt' ), 'edit_themes', 'bymt_setting', 'bymt_settings_page');
	add_action( 'admin_init', 'register_bymt_settings' );
}
function register_bymt_settings() {
	register_setting( 'bymt-settings-group', 'bymt_options' );
}
function bymt_settings_page() {
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');

$options_categories_obj = get_categories();
foreach ($options_categories_obj as $category) {
		$options_categories[]=array($category->cat_ID,$category->cat_name);
}

$options_posts_obj = get_posts("numberposts=50&orderby=post_date"); //取最新50条
foreach ($options_posts_obj as $posts) {
	$options_posts[] = array($posts->ID,$posts->post_title);
}

$basic_opts = array (
	array( "tit" => "标题分隔符","type" => "text","name" => "title_split","std" => "请输入标题分隔符","desc" => "据说有用的标题分隔符是：- _ | , ( ) 和空格"),
	array( "tit" => "网站标题","type" => "text","name" => "title_content","std" => "请输入网站标题","desc" => "自定义网站标题，留空则使用默认，一般不超过80个字符"),
	array( "tit" => "网站关键词","type" => "textarea","name" => "keyword_content","std" => "关键词1,关键词2,关键词3","desc" => "多个关键词请用英文逗号隔开，一般不超过200个字符"),
	array( "tit" => "网站描述","type" => "textarea","name" => "description_content","std" => "请输入网站描述","desc" => "用简洁凝练的话对您的网站进行描述，一般不超过200个字符"),
	array( "tit" => "PC端网站统计","type" => "radio","name" => "statistics","desc" => "用于PC端页面统计，可以放多个","child_tit" => "统计代码","child_type" => "textarea","child_name" => "statisticscode","child_std" => "请输入统计代码","child_desc" => "统计代码不会在页面中显示，但统计功能是正常的"),
	array( "tit" => "移动端网站统计","type" => "radio","name" => "wap_stat","desc" => '用于移动端页面统计，如果使用后页面出现空白，请查看 <a href="http://wiki.yuxiaoxi.com/editor#%E6%89%8B%E6%9C%BA%E7%89%88%E6%98%BE%E7%A4%BA%E7%A9%BA%E7%99%BD" target="_blank">解决办法</a> ',"child_tit" => "统计代码","child_type" => "textarea","child_name" => "wap_statcode","child_std" => "请输入统计代码","child_desc" => "统计代码不会在页面中显示，但统计功能是正常的"),
	array( "tit" => "备案号","type" => "radio","name" => "icp_ck","desc" => "设置网站备案号，如果您想显示它的话","child_tit" => "备案号","child_type" => "text","child_name" => "icp","child_std" => "请输入备案号","child_desc" => "填写您在工信部的备案号")
);

$show_opts = array (
	array( "tit" => "favicon图标","name" => "favicon_ck","desc" => "设置网站favicon图标，.icon或.png格式皆可","child_num" => "1","child_tit_1" => "自定义favicon图标","child_type_1" => "text","upload_1" => "1","child_name_1" => "custom_favicon","child_std_1" => "请输入favicon图标地址","child_desc_1" => "输入您的favicon图标地址，上传后请点击 <u>插入到文章</u> "),
	array( "tit" => "顶部右侧内容","name" => "custom_topblock","check_name"=>"custom_topblock_border","check_std"=>"边框","desc" => '默认为欢迎回来，选择焦点图请前往 <a href="javascript:;" id="go_slides">焦点图设置</a> ',"child_num" => "1","child_tit_1" => "自定义内容","child_type_1" => "textarea","child_name_1" => "topblock_content","child_std_1" => "请输入自定义内容","child_desc_1" => "输入顶部右侧自定义内容，支持html"),
	array( "tit" => "搜索框文字","name" => "custom_search","check_name"=>"custom_search_voice","check_std"=>"语音识别","desc" => "设置搜索框默认文字，请注意控制长度","child_num" => "1","child_tit_1" => "自定义搜索框文字","child_type_1" => "text","child_name_1" => "search_word","child_std_1" => "搜点什么呢...","child_desc_1" => "输入您要设置的搜索框文字"),
	array( "tit" => "ajax搜索提示","name" => "ajax_search","desc" => "在用户输入文字的同时，实时显示相关的搜索内容","child_num" => "1","child_tit_1" => "最多显示数量","child_type_1" => "number","child_name_1" => "ajax_search_num","child_desc_1" => "最大值限于设置&raquo;阅读&raquo;博客页面至多显示"),
	array( "tit" => "公告栏","name" => "notice","desc" => "是否开启公告栏，不开启将显示面包屑导航","child_num" => "2","child_tit_1" => "文章id","child_tit_2" => "公告内容","child_type_1" => "number","child_type_2" => "textarea","child_name_1" => "ggid","child_name_2" => "noticecontent","child_std2" => "请在此输入公告内容","child_desc_1" => '用此文章最新一条评论作为公告内容，请填写 <a href="http://wiki.yuxiaoxi.com/other#%E8%8E%B7%E5%8F%96%E6%96%87%E7%AB%A0id" target="_blank">文章id</a> ',"child_desc_2" => "如果不想使用文章评论作为公告内容，可以在这里输入公告内容，并将上面文章id留空，支持html"),
	array( "tit" => "ajax公告顶踩","name" => "ajax_ggdc","desc" => "是否对公告内容开启ajax顶踩功能","child_num" => "2","child_tit_1" => "顶 提示文字","child_tit_2" => "踩 提示文字","child_std_1" => "把持不住","child_std_2" => "智商拙计","child_type_1" => "text","child_type_2" => "text","child_name_1" => "ajax_gg_d_t","child_name_2" => "ajax_gg_c_t","child_desc_1" => '鼠标移到"顶"图标上显示的文字',"child_desc_2" => '鼠标移到"踩"图标上显示的文字'),
	array( "tit" => "底部友情链接","name" => "custom_footerlink","desc" => '该功能显示友情链接，请配合 <a href="http://wordpress.org/plugins/link-manager"  target="_blank">Link Manager</a> 插件使用',"child_num" => "1","child_tit_1" => "自定义友情链接标题","child_type_1" => "text","child_name_1" => "footerlink_word","child_std_1" => "友情链接","child_desc_1" => "输入您要设置的自定义友情链接标题"),
	array( "tit" => "首页图片墙文章","name" => "cat_picwall","desc" => "是否在首页显示图片墙文章，默认不显示"),
	array( "tit" => "载入特效","name" => "custom_circle","desc" => "是否显示左下角圆圈加载特效"),
	array( "tit" => "选中分享","name" => "wpshare","desc" => "是否开启选中内容分享到微博"),
	array( "tit" => "悬停title","name" => "mousett","desc" => "是否开启主题的鼠标悬停titile样式"),
	array( "tit" => "返回顶部","name" => "custom_gotop","desc" => "是否显示右下角返回顶部"),
	array( "tit" => "图片延迟加载","name" => "lazyload","desc" => "当图片在可见区域内才载入，该功能可加快页面载入速度")
);

$post_opts = array (
	array( "tit" => "关闭边栏","name" => "close_sidebar","desc" => "是否显示关闭侧边栏按钮(cookie记忆开关状态)"),
	array( "tit" => "开启边栏","name" => "open_sidebar","desc" => "是否显示开启侧边栏按钮(cookie记忆开关状态)"),
	array( "tit" => "代码高亮","name" => "highlight","desc" => "开启后将使用主题的代码高亮功能，请停用其他代码高亮插件"),
	array( "tit" => "ajax翻页","name" => "ajax_posts_list","desc" => "对文章列表使用ajax翻页，可以提高用户体验度"),
	array( "tit" => "文章pre转义","name" => "esc_pre_post","desc" => '将文章pre标签里的 <u>< > & " \'</u>（小于号，大于号，&，双引号，单引号）编码，转成HTML实体，已经是实体的并不转换'),
	array( "tit" => "文章浏览量","name" => "postinfoviews","desc" => '是否显示文章浏览量，需配合 <a href="http://wordpress.org/extend/plugins/wp-postviews/" target="_blank">WP-PostViews</a> 插件使用'),
	array( "tit" => "文章缩略图","name" => "thumbnail","desc" => "是否在列表页为每篇文章自动匹配一张缩略图"),
	array( "tit" => "文章标签","name" => "txttag","desc" => "是否显示文章标签"),
	array( "tit" => "标签加链接","name" => "tag_links","desc" => "是否对文章中的标签添加超链接","child_tit" => "最多替换数量","child_type" => "number","child_name" => "tag_maxnum","child_desc" => "文章中标签最多替换数量"),
	array( "tit" => "文章url自动超链接","name" => "auto_href","desc" => "是否让文章里的url自动生成超链接"),
	array( "tit" => "文章版权","name" => "txtcopyright","desc" => '是否显示文章结束后的版权信息，<a href="http://wiki.yuxiaoxi.com/other#%E8%AE%BE%E7%BD%AE%E6%96%87%E7%AB%A0%E7%89%88%E6%9D%83" target="_blank">查看使用教程</a>'),
	array( "tit" => "百度喜欢","type" => "radio","name" => "baidulike","desc" => "是否在文章页显示“百度喜欢”，需要先开启<u>文章版权</u>","child_tit" => "喜欢代码","child_type" => "textarea","child_name" => "baidulike_code","child_std" => "请输入喜欢代码","child_desc" => '输入喜欢代码，留空则使用默认的 <a href="http://share.baidu.com/code/like"  target="_blank">百度喜欢</a>'),
	array( "tit" => "百度分享","type" => "radio","name" => "txtshare","desc" => "是否在文章页显示“百度分享”","child_tit" => "分享代码","child_type" => "textarea","child_name" => "txtshare_code","child_std" => "请输入分享代码","child_desc" => '输入分享代码，留空则使用默认的 <a href="http://share.baidu.com/code"  target="_blank">百度分享</a>'),
	array( "tit" => "相关文章","type" => "radio","name" => "txtrelated","desc" => "是否在文章正文结束后显示相关文章功能","child_tit" => "文章数量","child_type" => "number","child_name" => "txtrelatednum","child_desc" => "输入需要显示的文章数量，推荐使用偶数"),
	array( "tit" => "上下文链接","name" => "txtnext","desc" => "是否在文章页显示上一篇和下一篇链接"),
	array( "tit" => "Lightbox看图","name" => "lightbox_ck","desc" => "若想要使用其他图片放大插件，请选择不使用"),
	array( "tit" => "留言板读者墙","name" => "guestwall","desc" => "仅在使用留言板模板情况下有效"),
	array( "tit" => "阻止站内pingback","name" => "self_ping","desc" => "阻止站内文章pingback")
);

$comm_opts = array (
	array( "tit" => "ajax翻页","name" => "ajax_comm_list","desc" => "对评论列表使用ajax翻页，可以提高用户体验度"),
	array( "tit" => "评论pre转义","name" => "esc_pre_comm","desc" => '将评论pre标签里的 <u>< > & " \'</u>（小于号，大于号，&，双引号，单引号）编码，转成HTML实体，已经是实体的并不转换'),
	array( "tit" => "评论框功能","name" => "comm-tools","desc" => "是否需要显示评论框编辑器的功能按钮","child_tit" => "功能选择","child_name" => array("tools_smile" => "表情","tools_b" => "粗体","tools_i" => "斜体","tools_u" => "下划线","tools_s" => "删除线","tools_q" => "引用","tools_code" => "代码","tools_img" => "图片","tools_come" => "签到","tools_good" => "赞美","tools_bad" => "埋怨","tools_admin" => "私信"),"child_desc" => "勾选你要显示的功能按钮","child_type" => "checkbox"),
	array( "tit" => "评论语言限制","name" => "com_lang","desc" => "禁掉这些常用spam语言的评论，可以有效减少垃圾评论","child_tit" => "语种选择","child_name" => array("lang_en" => "全英语","lang_ja" => "日语","lang_ru" => "俄语","lang_kr" => "韩语","lang_th" => "泰语","lang_ar" => "阿拉伯语"),"child_desc" => "勾选你要禁止的语种","child_type" => "checkbox"),
	array( "tit" => "评论字数限制","name" => "com_length","desc" => "限制评论最少、最多字数，超过拒绝提交","child_tit" => "最少字数","child_name" => "com_length_min","child_type" => "number","child_desc" => "评论最少输入字数，默认为2","child_tit2" => "最多字数","child_name2" => "com_length_max","child_type2" => "number","child_desc2" => "评论最多输入字数，默认为10000"),
	array( "tit" => "评论链接数限制","name" => "spam_links","desc" => "限制评论所含链接数量，超过拒绝提交","child_tit" => "限制数量","child_name" => "spam_links_num","child_type" => "number","child_desc" => "超过多少条时拒绝提交，默认为3条"),
	array( "tit" => "评论链接长度限制","name" => "spam_url","desc" => "限制评论所含链接长度，超过自动加入spam","child_tit" => "限制长度","child_name" => "spam_url_length","child_type" => "number","child_desc" => "超过多少字符时自动加入spam，默认为50字符"),
	array( "tit" => "评论回复邮件通知","name" => "mail_notify","desc" => "评论回复邮件通知，所有回复都会发送邮件通知"),
	array( "tit" => "不解析评论中代码","name" => "code_filter","desc" => "开启后，包括wp允许在评论出现的标签都将不会解析"),
	array( "tit" => "去除评论url超链接","name" => "com_href","desc" => "是否去除评论里的超链接")
);

$sns_opts = array (
	array( "tit" => "RSS","name" => "rss","desc" => "是否显示RSS订阅图标"),
	array( "tit" => "Twitter","name" => "twitter","desc" => "是否显示Twitter图标","child_tit" => "链接地址","child_name" => "twitterlink","child_std" => "请输入链接地址","child_desc" => "Twitter地址"),
	array( "tit" => "Facebook","name" => "facebook","desc" => "是否显示Facebook图标","child_tit" => "链接地址","child_name" => "facebooklink","child_std" => "请输入链接地址","child_desc" => "Facebook地址"),
	array( "tit" => "Google+","name" => "googleplus","desc" => "是否显示Google+图标","child_tit" => "链接地址","child_name" => "googlepluslink","child_std" => "请输入链接地址","child_desc" => "Google+地址"),
	array( "tit" => "新浪微博","name" => "weibo","desc" => "是否显示新浪微博图标","child_tit" => "链接地址","child_name" => "weibolink","child_std" => "请输入链接地址","child_desc" => "新浪微博地址"),
	array( "tit" => "腾讯微博","name" => "qqweibo","desc" => "是否显示腾讯微博图标","child_tit" => "链接地址","child_name" => "qqweibolink","child_std" => "请输入链接地址","child_desc" => "腾讯微博地址"),
	array( "tit" => "邮件订阅","name" => "emailrss","desc" => "是否显示邮件订阅图标","child_tit" => "订阅地址","child_name" => "emailrsslink","upload" => "1","child_std" => "请输入订阅地址","child_desc" => "邮件订阅地址"),
	array( "tit" => "微信公众","name" => "weixin","desc" => "是否显示微信图标","child_tit" => "图片地址","child_name" => "weixinimg","upload" => "1","child_std" => "请输入图片地址","child_desc" => "微信二维码图片地址")
);

$ads_opts = array (
	array( "tit" => "首页广告位-上","name" => "indexad1","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "indexadcode1"),
	array( "tit" => "首页广告位-下","name" => "indexad2","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "indexadcode2"),
	array( "tit" => "栏目广告位-上","name" => "categoryad1","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "categoryadcode1"),
	array( "tit" => "栏目广告位-下","name" => "categoryad2","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "categoryadcode2"),
	array( "tit" => "文章广告位-上","name" => "txtad1","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "txtadcode1"),
	array( "tit" => "文章广告位-下","name" => "txtad2","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "txtadcode2"),
	array( "tit" => "页面广告位-上","name" => "pagead1","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "pageadcode1"),
	array( "tit" => "页面广告位-下","name" => "pagead2","desc" => "有侧边栏：760px*90px；无侧边栏：最大宽度1060px","child_tit" => "广告代码","child_name" => "pageadcode2"),
	array( "tit" => "侧边栏广告位-大","name" => "sidebarad250","desc" => "一个250px*250px","child_tit" => "广告代码","child_name" => "sidebarad250code","fixed"=>"1","fixedid"=>"s_fixed_1"),
	array( "tit" => "侧边栏广告位-中","name" => "sidebarad25060","desc" => "两个250px*60px","child_tit" => "广告代码","child_name" => "sidebarad25060code","child_name2" => "sidebarad25060code2","fixed"=>"1","fixedid"=>"s_fixed_3"),
	array( "tit" => "侧边栏广告位-小","name" => "sidebarad120","desc" => "四个120px*90px","child_tit" => "广告代码","child_name" => "sidebarad120code1","child_name2" => "sidebarad120code2","child_name3" => "sidebarad120code3","child_name4" => "sidebarad120code4","fixed"=>"1","fixedid"=>"s_fixed_2")
);

$slides_arr = array ( "top" => "顶部右侧","nav" => "导航栏下","bul" => "公告栏下","lis" => "列表页上","sid" => "侧边栏");
$slides_size_arr = array ( "top" => "最大宽度：600px，最大高度：80px","nav" => "最大宽度：1060px，最大高度：120px","bul" => "最大宽度：1060px，最大高度：120px","lis" => "最大宽度：760px，最大高度：210px","sid" => "最大宽度：260px，最大高度：110px");
$string_arr = array(
	array("effect","trigger","delayTime","pnLoop","easing","autoPlay","mouseOverStop"),
	array("effect_tit"=>"效果[effect]","effect_tip"=>"图片切换效果","effect"=>array("fade","fold","left","top","leftLoop","topLoop"),
			"trigger_tit"=>"触发方式[trigger]","trigger_tip"=>"切换触发方式","trigger"=>array("mouseover","click"),
			"delayTime_tit"=>"效果速度[delayTime]","delayTime_tip"=>"单位毫秒","delayTime"=>array("500","700","1000","1500","2000","3000","5000","0"),
			"pnLoop_tit"=>"前后按钮循环[pnLoop]","pnLoop_tip"=>"为false时最前/后的按钮不可点","pnLoop"=>array("true","false"),
			"easing_tit"=>"缓动效果[easing]","easing_tip"=>"图片缓动效果","easing"=>array("swing","easeOutCirc","easeInQuint","easeInBack","easeOutBounce","easeOutElastic"),
			"autoPlay_tit"=>"自动运行[autoPlay]","autoPlay_tip"=>"是否自动运行","autoPlay"=>array("true","false"),
			"mouseOverStop_tit"=>"停止播放[mouseOverStop]","mouseOverStop_tip"=>"鼠标移上去停止","mouseOverStop"=>array("true","false"))
);

$jq_arr = array (
	array( "tit" => "新浪","name" => "sina","url" => "http://lib.sinaapp.com/js/jquery/1.8.3/jquery.min.js"),
	array( "tit" => "百度","name" => "baidu","url" => "http://libs.baidu.com/jquery/1.8.3/jquery.min.js"),
	array( "tit" => "七牛","name" => "qiniu","url" => "http://cdn.staticfile.org/jquery/1.8.3/jquery.min.js"),
	array( "tit" => "又拍","name" => "upai","url" => "http://upcdn.b0.upaiyun.com/libs/jquery/jquery-1.8.3.min.js"),
	array( "tit" => "谷歌","name" => "google","url" => "http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"),
	array( "tit" => "微软","name" => "microsoft","url" => "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"),
	array( "tit" => "主题","name" => "self","url" => TPLDIR ."/js/jquery.min.js"),
	array( "tit" => "其他","name" => "other","url" => "other")
);

$other_opts = array (
	array( "tit" => "WP自带的jQuery库","name" => "sysjq","desc" => "如果您发现某些插件不能使用，请开启这个选项试试"),
	array( "tit" => "头像缓存","name" => "avatar_cache","desc" => '请先确保根目录已自动生成 <span style="color:#C30">avatar</span> 文件夹，没有请手动添加'),
	array( "tit" => "头像中转多说","name" => "avatar_ds","desc" => "使用多说服务器获取头像，解决Gravatar被墙问题"),
	array( "tit" => "去除头部rel='prev/next'","name" => "remove_pn","desc" => '用于指明网址之间的关系，详细解释请看： <a href="https://support.google.com/webmasters/answer/1663744?hl=zh-Hans" target="_blank">谷歌站长工具</a> '),
	array( "tit" => "去除头部rel='canonical' ","name" => "remove_cnc","desc" => '用于规范文档，详细解释请看： <a href="https://support.google.com/webmasters/answer/139394?hl=zh-Hans" target="_blank">谷歌站长工具</a> '),
	array( "tit" => "后台登录成功提醒","name" => "login_success","desc" => "后台有帐号登录成功，发送Email到管理员邮箱"),
	array( "tit" => "后台登录失败提醒","name" => "login_fail","desc" => "后台有帐号登录失败，发送Email到管理员邮箱"),
	array( "tit" => "定义登陆界面样式","name" => "custom_login","desc" => '样式文件所在位置： <span style="color:#C30">BYMT/css/login.css</span>')
);
error_reporting(0);
?>
<link rel="stylesheet" type="text/css" href="<?php echo TPLDIR . '/css/setting.css'; ?>" />
<div class="bymt_setwrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2>BYMT主题设置</h2>
	<?php
	if(isset($_REQUEST['settings-updated']) && !isset($_REQUEST['reset'])) { echo '<div class="bymt_msg msg_s"><i></i>主题设置保存成功</div>'; }
	if(isset($_REQUEST['reset']) == 'reset' ) { delete_option('bymt_options'); echo '<div class="bymt_msg msg_r"><i></i>主题设置重置成功</div>'; }
	?>
	<div class="bymt_setver">当前主题：<a href="https://github.com/maicong/BYMT/tree/v2" target="_blank">BYMT v2</a> | 当前版本：<a href="https://github.com/maicong/BYMT/releases/tag/v<?php echo THEMEVER; ?>" target="_blank"><?php echo THEMEVER; ?></a> | 最后更新：<a><?php echo THEMEUPDATE; ?></a> | 主题作者：<a href="https://maicong.me/" target="_blank">麦田一根葱</a></div>
	<form method="post"  id="form1" action="options.php">
		<?php settings_fields( 'bymt-settings-group' ); ?>
		<?php $options = get_option('bymt_options'); ?>
		<div class="bymt_setbox">
			<ul class="nav">
				<li id="#li_basic"><a>基本设置</a></li>
				<li id="#li_show"><a>外观设置</a></li>
				<li id="#li_post"><a>文章设置</a></li>
				<li id="#li_comm"><a>评论设置</a></li>
				<li id="#li_sns"><a>SNS设置</a></li>
				<li id="#li_ads"><a>广告设置</a></li>
				<li id="#li_slides"><a>焦点图设置</a></li>
				<li id="#li_prog"><a>程序相关</a></li>
				<li id="#li_vote"><a>顶踩数据</a></li>
				<li id="#li_help"><a>帮助文档</a></li>
				<li class="version">BYMT <?php echo THEMEVER; ?></li>
			</ul>
			<ul id="bymt_config" data-warpversion="<?php echo THEMEVER; ?>" class="content loading">
				<li id="li_basic" class="bymt_nodisplay">
					<ul class="properties">
					<?php foreach ($basic_opts as $val) { ?>
						<li>
							<div class="wlabel"><?php echo $val['tit']; ?></div>
							<div class="field">
							<?php if($val['type']=="text") { ?>
								<input type="text" name="bymt_options[<?php echo $val['name']; ?>]" placeholder="<?php echo $val['std']; ?>" value="<?php esc_attr_e($options[$val['name']]); ?>" />
							<?php }elseif($val['type']=="textarea") { ?>
								<textarea type="textarea" name="bymt_options[<?php echo $val['name']; ?>]" placeholder="<?php echo $val['std']; ?>"><?php esc_attr_e($options[$val['name']]); ?></textarea>
							<?php }elseif($val['type']=="radio") { ?>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_1" class="bymt_radio cktype_l" value="" <?php checked('', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_1"></label> 不使用 </label>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_2" class="bymt_radio cktype_r" value="1" <?php checked('1', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_2"></label> 使用 </label>
							<?php } ?>
							</div>
							<div class="description"><?php echo $val['desc']; ?></div>
							<?php if(!empty($val['child_name'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit']; ?></div>
								<div class="field"><textarea type="textarea" name="bymt_options[<?php echo $val['child_name']; ?>]" placeholder="<?php echo $val['child_std']; ?>"><?php esc_attr_e($options[$val['child_name']]); ?></textarea></div>
								<div class="description"><?php echo $val['child_desc']; ?></div>
							</div>
							<?php } ?>
						</li>
					<?php } ?>
						<li>
							<div class="wlabel">底部左侧内容</div>
							<div class="field">
								<textarea type="textarea" name="bymt_options[footer]"><?php if(!empty($options['footer'])){esc_attr_e($options['footer']); }else{ esc_attr_e('&copy; 2012-2014&nbsp;<a href="/">'.get_bloginfo('name').'</a>&nbsp;All Rights Reserved'); }?>
</textarea>
								<div class="foot_preview">底部左侧内容预览：<?php if(!empty($options['footer'])) : ?><?php echo $options['footer']; ?><?php else : ?>&copy; 2012-2014&nbsp;<a href="/"><?php bloginfo( 'name' ); ?></a>&nbsp;All Rights Reserved<?php endif; ?>
								</div>
							</div>
							<div class="description">填写的文字将显示在网站底部左侧，支持HTML<br />如果不填写，则显示为默认的内容</div>
						</li>
					</ul>
				</li>

				<li id="li_show" class="bymt_nodisplay">
					<ul class="properties">
					<li>
							<div class="wlabel">logo类型</div>
							<div class="field">
								<label><input type="radio" name="bymt_options[check_logo]" id="cklogoimg" class="bymt_radio" value="" <?php checked('', $options['check_logo']); ?>/><label for="cklogoimg"></label> 图片 </label>
								<label><input type="radio" name="bymt_options[check_logo]" id="cklogotxt" class="bymt_radio" value="1" <?php checked('1', $options['check_logo']); ?>/><label for="cklogotxt"></label> 标题 </label>
							</div>
							<div class="description">设置网站logo显示类型，默认为使用logo图片</div>
							<div class="bymt_children logoimg">
								<div class="wlabel">图片logo设置</div>
								<div class="field">
									<label><input type="radio" name="bymt_options[custom_logo]" id="logoimg1" class="bymt_radio" value="" <?php checked('', $options['custom_logo']); ?>/><label for="logoimg1"></label> 默认 </label>
									<label><input type="radio" name="bymt_options[custom_logo]" id="logoimg2" class="bymt_radio" value="1" <?php checked('1', $options['custom_logo']); ?>/><label for="logoimg2"></label> 自定义 </label>
								</div>
								<div class="description">设置网站logo，尺寸建议：280px*60px</div>
									<div class="bymt_children bymt_nodisplay">
									<div class="wlabel">图片地址</div>
									<div class="field"><input type="text" name="bymt_options[logo_url]" id="logo_url" placeholder="请输入图片地址" value="<?php echo esc_url($options['logo_url']); ?>"/><input type="button" id="upload_ck" class="bymt_btn btn-upload" name="upload_button" value="上传" /></div>
									<div class="description">请输入图片地址，上传后请点击<u>插入到文章</u></div>
								</div>
							</div>
							<div class="bymt_children bymt_nodisplay logotitle">
								<div class="wlabel">标题设置</div>
								<div class="field"><input type="text" name="bymt_options[custom_sitetitle]" placeholder="请输入自定义标题" value="<?php esc_attr_e($options['custom_sitetitle']); ?>"/></div>
								<div class="description">自定义您的网站标题，留空则使用默认标题</div>
							</div>
							<div class="bymt_children bymt_nodisplay logodesc">
								<div class="wlabel">一句话描述</div>
								<div class="field">
									<label><input type="radio" name="bymt_options[check_logodesc]" id="logodesc1" class="bymt_radio" value="" <?php checked('', $options['check_logodesc']); ?>/><label for="logodesc1"></label> 不显示 </label>
									<label><input type="radio" name="bymt_options[check_logodesc]" id="logodesc2" class="bymt_radio" value="1" <?php checked('1', $options['check_logodesc']); ?>/><label for="logodesc2"></label> 显示 </label>
								</div>
								<div class="description">显示网站logo标题下的描述信息</div>
									<div class="bymt_children bymt_nodisplay">
									<div class="wlabel">自定义描述</div>
									<div class="field"><input type="text" name="bymt_options[custom_logodesc]" placeholder="请输入自定义描述" value="<?php esc_attr_e($options['custom_logodesc']); ?>"/></div>
									<div class="description">自定义描述信息，留空则使用默认</div>
								</div>
							</div>
						</li>
					<?php foreach ($show_opts as $val) { ?>
						<li>
							<div class="wlabel"><?php echo $val['tit']; ?></div>
							<div class="field">
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_1" class="bymt_radio cktype_l" value="" <?php checked('', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_1"></label> <?php if($val['name']=="favicon_ck" || $val['name']=="custom_topblock" || $val['name']=="custom_search") { echo "默认"; }else{ echo "不显示"; } ?> </label>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_2" class="bymt_radio <?php if($val['name']=="custom_topblock"){ echo 'cktype_l'; }else{ echo 'cktype_r'; } ?>" value="1"<?php checked('1', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_2"></label> <?php if($val['name']=="favicon_ck" || $val['name']=="custom_search") { echo "自定义"; }elseif($val['name']=="custom_topblock"){ echo "焦点图"; }else{ echo "显示"; } ?> </label>
							 <?php if($val['name']=="custom_topblock"){ ?>
							 	<label><input type="radio" name="bymt_options[custom_topblock]" id="custom_topblock_3" class="bymt_radio cktype_r" value="2" <?php checked('2', $options['custom_topblock']); ?>/><label for="custom_topblock_3"></label> 自定义 </label>
							<?php } ?>
							<?php if(!empty($val['check_name'])) { ?>
								<label><input type="checkbox" name="bymt_options[<?php echo $val['check_name']; ?>]" class="bymt_checkbox" id="<?php echo $val['check_name']; ?>"<?php checked('on', $options[$val['check_name']]); ?>/><label for="<?php echo $val['check_name']; ?>"></label> <?php echo $val['check_std']; ?> </label>
							<?php } ?>
							</div>
							<div class="description"><?php echo $val['desc']; ?></div>
							<?php if(!empty($val['child_num'])){
							for($i=1; $i<=$val['child_num']; $i++){ ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit_'.$i]; ?></div>
								<div class="field">
								<?php if($val['child_type_'.$i]=="text") { ?>
								<input type="text" name="bymt_options[<?php echo $val['child_name_'.$i]; ?>]" id="<?php echo $val['child_name_'.$i]; ?>" placeholder="<?php echo $val['child_std_'.$i]; ?>" value="<?php esc_attr_e($options[$val['child_name_'.$i]]); ?>" /><?php if($val['upload_'.$i]=="1") { ?><input type="button" name="upload_button" id="upload_ck" class="bymt_btn btn-upload" value="上传" /><?php } ?>
								<?php }elseif($val['child_type_'.$i]=="textarea") { ?>
								<textarea type="textarea" name="bymt_options[<?php echo $val['child_name_'.$i]; ?>]" placeholder="<?php echo $val['child_std_'.$i]; ?>"><?php esc_attr_e($options[$val['child_name_'.$i]]); ?></textarea>
								<?php }elseif($val['child_type_'.$i]=="number") { ?>
								<input type="number" class="short" name="bymt_options[<?php echo $val['child_name_'.$i]; ?>]" value="<?php echo $options[$val['child_name_'.$i]]; ?>"/>
								<?php } ?></div>
								<div class="description"><?php echo $val['child_desc_'.$i]; ?></div>
							</div>
							<?php } } ?>
						</li>
					<?php } ?>
					</ul>
				</li>

				<li id="li_post" class="bymt_nodisplay">
					<ul class="properties">
					<?php foreach ($post_opts as $val) { ?>
						<li>
							<div class="wlabel"><?php echo $val['tit']; ?></div>
							<div class="field">
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_1" class="bymt_radio cktype_l" value="" <?php checked('', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_1"></label> 不使用 </label>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_2" class="bymt_radio cktype_r" value="1" <?php checked('1', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_2"></label> 使用 </label>
							</div>
							<div class="description"><?php echo $val['desc']; ?></div>
							<?php if(!empty($val['child_name'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit']; ?></div>
								<div class="field">
								<?php if($val['child_type']=="textarea") { ?>
									<textarea type="textarea" name="bymt_options[<?php echo $val['child_name']; ?>]" placeholder="<?php echo $val['child_std']; ?>"><?php esc_attr_e($options[$val['child_name']]); ?></textarea>
								<?php }elseif($val['child_type']=="number") { ?>
									<input type="number" class="short" name="bymt_options[<?php echo $val['child_name']; ?>]" value="<?php echo $options[$val['child_name']]; ?>"/>
									<?php } ?>
								</div>
								<div class="description"><?php echo $val['child_desc']; ?></div>
							</div>
							<?php } ?>
						</li>
					<?php } ?>
					</ul>
				</li>

				<li id="li_comm" class="bymt_nodisplay">
					<ul class="properties">
					<?php foreach ($comm_opts as $val) { ?>
						<li>
							<div class="wlabel"><?php echo $val['tit']; ?></div>
							<div class="field">
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_1" class="bymt_radio cktype_l" value="" <?php checked('', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_1"></label>  不使用  </label>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_2" class="bymt_radio cktype_r" value="1" <?php checked('1', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_2"></label> 使用 </label>
							</div>
							<div class="description"><?php echo $val['desc']; ?></div>
							<?php if(!empty($val['child_tit'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit']; ?></div>
								<div class="field">
								<?php if($val['child_type']=="text") { ?>
								<input type="text" name="bymt_options[<?php echo $val['child_name']; ?>]" placeholder="<?php echo $val['child_std']; ?>" value="<?php echo esc_attr_e($options[$val['child_name']]); ?>"/>
								<?php }elseif($val['child_type']=="number") { ?>
								<input type="number" class="short" name="bymt_options[<?php echo $val['child_name']; ?>]" value="<?php echo $options[$val['child_name']]; ?>"/>
								<?php }elseif($val['child_type']=="checkbox") { foreach ($val['child_name'] as $name => $value) { ?>
								<label><input type="checkbox" name="bymt_options[<?php echo $name; ?>]" class="bymt_inodisplay bymt_checkbox" id="<?php echo $name; ?>" <?php checked('on', $options[$name]); ?>/><label for="<?php echo $name; ?>"></label> <?php echo $value; ?> </label>
								<?php if($name=="tools_q"){ echo "<br />"; } ?>
								<?php } } ?>
								</div>
								<div class="description"><?php echo $val['child_desc']; ?></div>
							</div>
							<?php } ?>
							<?php if(!empty($val['child_tit2'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit2']; ?></div>
								<div class="field"><input type="number" class="short" name="bymt_options[<?php echo $val['child_name2']; ?>]" value="<?php echo esc_attr_e($options[$val['child_name2']]); ?>"/></div>
								<div class="description"><?php echo $val['child_desc2']; ?></div>
							</div>
							<?php } ?>
						</li>
					<?php } ?>
					</ul>
				</li>

				<li id="li_sns" class="bymt_nodisplay">
					<ul class="properties">
					<?php foreach ($sns_opts as $val) { ?>
						<li>
							<div class="wlabel"><?php echo $val['tit']; ?></div>
							<div class="field">
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_1" class="bymt_radio cktype_l" value="" <?php checked('', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_1"></label> 不显示 </label>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_2" class="bymt_radio cktype_r" value="1" <?php checked('1', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_2"></label> 显示 </label>
							</div>
							<div class="description"><?php echo $val['desc']; ?></div>
							<?php if(!empty($val['child_name'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit']; ?></div>
								<div class="field"><input type="text" name="bymt_options[<?php echo $val['child_name']; ?>]" placeholder="<?php echo $val['child_std']; ?>" value="<?php esc_attr_e($options[$val['child_name']]); ?>"/><?php if($val['upload']=="1") { ?><input type="button" name="upload_button" id="upload_ck" class="bymt_btn btn-upload" value="上传" /><?php } ?></div>
								<div class="description"><?php echo $val['child_desc']; ?></div>
							</div>
							<?php } ?>
						</li>
					<?php } ?>
					</ul>
				</li>

				<li id="li_ads" class="bymt_nodisplay">
					<ul class="properties">
					<?php foreach ($ads_opts as $val) { ?>
						<li>
							<div class="wlabel"><?php echo $val['tit']; ?></div>
							<div class="field">
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_1" class="bymt_radio cktype_l" value="" <?php checked('', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_1"></label> 不使用 </label>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_2" class="bymt_radio cktype_r" value="1"<?php checked('1', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_2"></label> 使用 </label>
								<?php if($val['fixed']=="1"){ ?><label><input type="radio" name="bymt_options[s_fixed]" class="bymt_radio" id="<?php echo $val['fixedid']; ?>" value="<?php echo $val['fixedid']; ?>" <?php checked($val['fixedid'], $options["s_fixed"]); ?>/><label for="<?php echo $val['fixedid']; ?>"></label> 跟随滚动 </label><?php } ?>
								<?php if($val['fixed']=="1"&&$options["s_fixed"]==$val['fixedid']){ ?><label><input type="radio" name="bymt_options[s_fixed]" class="bymt_radio" id="s_fixed_4" value="" <?php checked('s_fixed_4', $options["s_fixed"]); ?>/><label for="s_fixed_4"></label> 不跟随 </label><?php } ?>
							</div>
							<div class="description"><?php echo $val['desc']; ?></div>
							<?php if(!empty($val['child_name'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit']; ?></div>
								<div class="field">
								<textarea type="textarea" name="bymt_options[<?php echo $val['child_name']; ?>]"><?php esc_attr_e($options[$val['child_name']]); ?></textarea>
								<?php if(!empty($val['child_name2'])) { ?>
								<br />
								<textarea type="textarea" name="bymt_options[<?php echo $val['child_name2']; ?>]"><?php esc_attr_e($options[$val['child_name2']]); ?></textarea>
								<?php }if(!empty($val['child_name3'])) { ?>
								<br />
								<textarea type="textarea" name="bymt_options[<?php echo $val['child_name3']; ?>]"><?php esc_attr_e($options[$val['child_name3']]); ?></textarea>
								<?php }if(!empty($val['child_name4'])) { ?>
								<br />
								<textarea type="textarea" name="bymt_options[<?php echo $val['child_name4']; ?>]"><?php esc_attr_e($options[$val['child_name4']]); ?></textarea>
								<?php } ?>
								</div>
								<div class="description">支持html代码</div>
							</div>
							<?php } ?>
						</li>
					<?php } ?>
					</ul>
				</li>

				<li id="li_slides" class="bymt_nodisplay">
				<ul class="properties">
				<li>
							<div class="wlabel">图片设置</div>
							<div class="field">
							<?php foreach ($slides_arr as $key => $val) { ?>
							<label><input type="radio" name="sd_imgst" id="sd_imgst_<?php echo $key ; ?>" class="bymt_radio"<?php checked('top', $key); ?>/><label for="sd_imgst_<?php echo $key ; ?>"></label> <?php echo $val; ?> </label>
							<?php } ?>
							</div>
							<div class="description">对焦点图所在位置图片进行设置</div>
							<?php foreach ($slides_arr as $key => $val) { ?>
							<div class="bymt_children bymt_nodisplay sd_imgst_<?php echo $key ; ?>">
							<div class="wlabel"><?php echo $val ; ?>焦点图获取类型</div>
							<div class="field">
								<label><input type="radio" name="bymt_options[sd_imgst_<?php echo $key ; ?>]" id="sd_imgst_<?php echo $key ; ?>_1" class="bymt_radio type" value="category" <?php checked('category', $options["sd_imgst_".$key]); ?>/><label for="sd_imgst_<?php echo $key ; ?>_1"></label> 指定栏目 </label>
								<label><input type="radio" name="bymt_options[sd_imgst_<?php echo $key ; ?>]" id="sd_imgst_<?php echo $key ; ?>_2" class="bymt_radio type" value="posts" <?php checked('posts', $options["sd_imgst_".$key]); ?>/><label for="sd_imgst_<?php echo $key ; ?>_2"></label> 指定文章 </label>
								<label><input type="radio" name="bymt_options[sd_imgst_<?php echo $key ; ?>]" id="sd_imgst_<?php echo $key ; ?>_3" class="bymt_radio type" value="hand" <?php checked('hand', $options["sd_imgst_".$key]); ?>/><label for="sd_imgst_<?php echo $key ; ?>_3"></label> 手动添加 </label>
								<label><input type="checkbox" name="bymt_options[sd_imgst_<?php echo $key ; ?>_tar]" class="bymt_checkbox" id="sd_imgst_<?php echo $key ; ?>_tar"<?php checked('on', $options["sd_imgst_".$key."_tar"]); ?>/><label for="sd_imgst_<?php echo $key ; ?>_tar"></label> 新窗口打开 </label>
								<label><input type="checkbox" name="bymt_options[sd_imgst_<?php echo $key ; ?>_pave]" class="bymt_checkbox" id="sd_imgst_<?php echo $key ; ?>_pave"<?php checked('on', $options["sd_imgst_".$key."_pave"]); ?>/><label for="sd_imgst_<?php echo $key ; ?>_pave"></label> 自动铺平 </label>
							</div>
							<div class="description">图片尺寸：<u><?php echo $slides_size_arr[$key] ; ?></u></div>
							<div class="bymt_children bymt_nodisplay sd_imgst_<?php echo $key ; ?>_1">
								<div class="wlabel">栏目设置</div>
								<div class="field">
								<label><i>选择栏目</i><select name="bymt_options[sd_imgst_<?php echo $key ; ?>_sel]" class="ckselect">
								<?php foreach ($options_categories as $categories) { 	?>
								<option value="<?php echo $categories[0]; ?>"<?php selected($categories[0], $options["sd_imgst_".$key."_sel"]); ?>><?php echo $categories[1]; ?></option>
								<?php } ?>
								</select></label>
								<label><i class="mleft10">显示数量</i><input type="number" name="bymt_options[sd_imgst_<?php echo $key ; ?>_selnum]" class="short" value="<?php echo $options["sd_imgst_".$key."_selnum"]; ?>" /></label>
								</div>
								<div class="description">选择一个栏目并设置显示数量</div>
							</div>
							<div class="bymt_children bymt_nodisplay sd_imgst_<?php echo $key ; ?>_2">
								<div class="wlabel">文章设置</div>
								<div class="field">
								<label><select name="bymt_options[sd_imgst_<?php echo $key ; ?>_pos][]" class="select" multiple>
								<?php foreach ($options_posts as $posts) { 	?>
								<option value="<?php echo $posts[0]; ?>"<?php if(!empty($options["sd_imgst_".$key."_pos"])){ if (in_array($posts[0],$options["sd_imgst_".$key."_pos"])) {  echo 'selected="selected"'; } }; ?>><?php echo $posts[1]; ?></option>
								<?php } ?>
								</select></label>
								</div>
								<div class="description">这里显示最新的50篇文章，选择您需要显示的文章，<span style="color:#C30">按住ctrl可以复选</span></div>
							</div>
							<div class="bymt_children bymt_nodisplay sd_imgst_<?php echo $key ; ?>_3">
							<?php for($i=1;$i<=8;$i++){?>
								<div class="bymt_children" id="sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>">
									<div class="wlabel">焦点图<?php echo $i ; ?></div>
									<div class="field">
									<label><input type="radio" name="bymt_options[sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_ck]" id="sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_ck_1" class="bymt_radio handck_l" value="" <?php checked('', $options["sd_imgst_".$key."_hand_".$i."_ck"]); ?>/><label for="sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_ck_1"></label> 不使用 </label>
									<label><input type="radio" name="bymt_options[sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_ck]" id="sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_ck_2" class="bymt_radio handck_r" value="1" <?php checked('1', $options["sd_imgst_".$key."_hand_".$i."_ck"]); ?>/><label for="sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_ck_2"></label> 使用 </label>
									</div>
									<div class="description">是否启用？</div>
										<div class="bymt_children bymt_nodisplay">
										<div class="bymt_children">
											<div class="wlabel">链接地址(href)</div>
											<div class="field"><input type="text" name="bymt_options[sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_href]" value="<?php echo esc_url($options["sd_imgst_".$key."_hand_".$i."_href"]); ?>" /></div>
											<div class="description">链接地址</div>
										</div>
										<div class="bymt_children">
											<div class="wlabel">图片地址(src)</div>
											<div class="field"><input type="text" name="bymt_options[sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_src]" id="sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_src" value="<?php echo esc_url($options["sd_imgst_".$key."_hand_".$i."_src"]); ?>" /><input type="button" name="upload_button" id="upload_ck" class="bymt_btn btn-upload" value="上传" /></div>
											<div class="description">图片地址</div>
										</div>
										<div class="bymt_children">
											<div class="wlabel">图片描述(alt)</div>
											<div class="field"><input type="text" name="bymt_options[sd_imgst_<?php echo $key ; ?>_hand_<?php echo $i ; ?>_alt]" value="<?php esc_attr_e($options["sd_imgst_".$key."_hand_".$i."_alt"]); ?>" /></div>
											<div class="description">图片描述</div>
										</div>
										</div>
									</div>
								<?php } ?>
								</div>
							</div>
						<?php } ?>
						</li>
				<li>
				<div class="wlabel">参数设置</div>
				<div class="field">
				<?php foreach ($slides_arr as $key => $value) { ?><label><input type="checkbox" name="bymt_options[sd_config_<?php echo $key; ?>_ck]" class="bymt_checkbox" id="sd_config_<?php echo $key; ?>_ck"<?php checked('on', $options["sd_config_".$key."_ck"]); ?>/><label for="sd_config_<?php echo $key; ?>_ck"></label> <?php echo $value; ?> </label>
				<?php } ?></div>
				<div class="description">勾选则启用当前位置焦点图，不建议全部开启</div>
				<?php foreach ($slides_arr as $key => $value) { ?><div class="bymt_children bymt_nodisplay" id="sd_config_<?php echo $key; ?>">
				<div class="wlabel"><?php echo $value; ?>参数配置</div>
				<div class="field">
				<?php foreach ($string_arr[0] as $titval) { ?>
				<label><?php echo $string_arr[1][$titval."_tit"]; ?>:
				<select rel="string" name="bymt_options[sd_config_<?php echo $key; ?>_<?php echo $titval; ?>]" id="<?php echo $titval; ?>" class="slide_select">
				<?php foreach ($string_arr[1][$titval] as $selval) { ?>
					<option value="<?php echo $selval; ?>"<?php selected($selval, $options["sd_config_".$key."_".$titval]); ?>><?php echo $selval; ?></option>
				<?php  } ?>
				</select>
				<small><?php echo $string_arr[1][$titval."_tip"]; ?></small>
				</label><br>
				<?php } ?>
				</div>
				<div class="description">对焦点图参数进行配置，不同的配置有不同的效果</div>
				</div>
                <?php } ?>
				</li>
				</ul>
				</li>

				<li id="li_prog" class="bymt_nodisplay">
					<ul class="properties">
						<li>
							<div class="wlabel">jQuery库选择</div>
							<div class="field">
							<?php foreach ($jq_arr as $val) { ?>
								<label><input type="radio" name="bymt_options[jq]" id="jq_<?php echo $val['name']; ?>" class="bymt_radio <?php if($val['name']=="other"){ echo "cktype_r"; }else{ echo "cktype_l"; } ?>" value="<?php echo $val['url']; ?>"<?php if($options['jq']=="") { checked('self', $val['name']); }else{ checked($val['url'], $options['jq']); } ?>/><label for="jq_<?php echo $val['name']; ?>"></label> <?php echo $val['tit']; ?> </label>
								<?php if($val['name']=="upai"){ echo "<br />"; } ?>
							<?php } ?>
							</div>
							<div class="description">选择您认为速度最快的jQuery库，谷歌的服务会被墙，建议国内用户不要勾选谷歌。jQuery库文件比较大，使用cdn可以加快载入速度</div>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel">自定义JQuery库</div>
								<div class="field"><input type="text" name="bymt_options[other_jq]" placeholder="http://cdn.myblog.com/jquery/1.8.3/jquery-min.js" value="<?php echo esc_url($options['other_jq']); ?>"/></div>
								<div class="description">输入您自定义的JQuery库地址(最好是压缩的)，例如：http://cdn.myblog.com/jquery/1.8.3/jquery-min.js</div>
							</div>
						</li>
					<?php foreach ($other_opts as $val) { ?>
						<li>
							<div class="wlabel"><?php echo $val['tit']; ?></div>
							<div class="field">
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_1" class="bymt_radio cktype_l" value="" <?php checked('', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_1"></label> 关闭 </label>
								<label><input type="radio" name="bymt_options[<?php echo $val['name']; ?>]" id="<?php echo $val['name']; ?>_2" class="bymt_radio cktype_r" value="1" <?php checked('1', $options[$val['name']]); ?>/><label for="<?php echo $val['name']; ?>_2"></label> 开启 </label>
							</div>
                            <?php if(!empty($val['child_name'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit']; ?></div>
								<div class="field">
								<?php if($val['child_type']=="number") { ?>
								<input type="number" class="short" name="bymt_options[<?php echo $val['child_name']; ?>]" value="<?php echo stripslashes($options[$val['child_name']]); ?>"/>
                                <?php }elseif($val['child_type']=="checkbox") { foreach ($val['child_name'] as $name => $value) { ?>
								<label><input type="checkbox" name="bymt_options[<?php echo $name; ?>]" class="bymt_inodisplay bymt_checkbox" id="<?php echo $name; ?>" <?php checked('on', $options[$name]); ?>/><label for="<?php echo $name; ?>"></label> <?php echo $value; ?> </label>
								<?php } } ?>
								</div>
								<div class="description"><?php echo $val['child_desc']; ?></div>
							</div>
							<?php } ?>
							<?php if(!empty($val['child_name2'])) { ?>
							<div class="bymt_children bymt_nodisplay">
								<div class="wlabel"><?php echo $val['child_tit2']; ?></div>
								<div class="field">
								<?php if($val['child_type2']=="number") { ?>
								<input type="number" class="short" name="bymt_options[<?php echo $val['child_name2']; ?>]" value="<?php echo stripslashes($options[$val['child_name2']]); ?>"/>
								<?php } ?>
								</div>
								<div class="description"><?php echo $val['child_desc2']; ?></div>
							</div>
							<?php } ?>
                            <div class="description"><?php echo $val['desc']; ?></div>
						</li>
					<?php } ?>
					</ul>
				</li>
				<li id="li_vote" class="bymt_nodisplay">
				<div class="properties">
				<table width="100%" id="vote_show">
				<?php
					global $wpdb;
					$vote = $wpdb->get_results("select * from ".$wpdb->prefix."comm_vote");
					echo '<tr id="vote_title"><th scope="col">编号</th><th scope="col">原文</th><th scope="col">用户</th><th scope="col">邮箱</th><th scope="col">网址</th><th scope="col">操作</th><th scope="col">ip</th><th scope="col">时间</th></tr>';
					foreach ($vote as $val) {
						$id = $val -> id; $comm_id = $val -> comm; $comment = get_comment($comm_id); $text = $comment -> comment_content;
						$user = $val -> user; $email = $val -> email; $url = $val -> url; $rating = $val -> rating; $ip = $val -> ip; $time = $val -> time;
						if($rating=='up'){ $up = '顶'; }else{ $up = '踩'; }
						echo '<tr id="vote_list"><td>'.$id.'</td><td><abbr title="'.strip_tags($text).'">'.wp_trim_words(strip_tags($text),10).'</abbr></td><td><abbr title="'.$user.'">'.wp_trim_words($user,8).'</abbr></td><td><abbr title="'.$email.'"><a href="mailto:'.$email.'">'.wp_trim_words($email,16).'</a></abbr></td><td><abbr title="'.$url.'"><a href="'.$url.'">'.wp_trim_words($url,20).'</a></abbr></td><td>'.$up.'</td><td>'.$ip.'</td><td>'.$time.'</td></tr>';
					}
				?>
				</table>
				<div id="vote_paged"></div>
				</div>
				</li>
				<li id="li_help" class="bymt_nodisplay">
				<div class="properties">
				<iframe src="http://wiki.yuxiaoxi.com/welcome?ver=<?php echo THEMEVER; ?>" width="100%" height="500px" scrolling="yes"></iframe>
				</div>
				</li>
				<li id="loadtext">正在加载设置项，请稍候…</li>
			</ul>
		</div>

		<div class="bymt_submit_form">
			<input type="submit" class="bymt_btn btn-submit" name="save" value="保存设置" />
		</div>
	</form>

	<form method="post" id="form2">
		<div class="bymt_reset_form">
			<input type="submit" name="reset" value="重置" class="bymt_btn btn-reset"/>
			<input type="hidden" name="reset" value="reset" />
		</div>
	</form>
	<div class="overlay">
	<div id="reset-dialog">
		<h2>温馨提示</h2>
		<p>主题设置将被清空，是否继续？</p>
		<input type="button" id="reset-submit" class="bymt_btn btn-submit" value="确定" /> <input type="button" id="reset-cancel" class="bymt_btn btn-cancel" value="取消" />
	</div>
</div>
</div>
<script src="<?php echo TPLDIR . '/js/jquery.min.js'; ?>"></script>
<script src="<?php echo TPLDIR . '/js/setting.js'; ?>"></script>
<?php } ?>
