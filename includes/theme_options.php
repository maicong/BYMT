<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version 	1.0.5
 */

add_action('admin_menu', 'bymt_admin_menu');
function bymt_admin_menu() {
	add_theme_page(__( '主题设置', 'bymt' ), __( '主题设置', 'bymt' ), 'edit_themes', basename(__FILE__), 'bymt_settings_page');
	add_action( 'admin_init', 'register_bymt_settings' );
}
function register_bymt_settings() {
	register_setting( 'bymt-settings-group', 'bymt_options' );
}
function bymt_settings_page() {
if ( isset($_REQUEST['settings-updated']) ) echo '<div id="message" class="updated fade"><p><strong>主题设置保存成功！</strong></p></div>';
if( 'reset' == isset($_REQUEST['reset']) ) {
	delete_option('bymt_options');
	echo '<div id="message" class="updated fade"><p><strong>主题设置重置成功！</strong></p></div>';
}
?>
<style type="text/css">
.clearfix{clear:both}
.bymt_nodisplay{display:none}
.wrap{margin:0 0 50px 10px; overflow:hidden}
.bymt_option_wrap{margin:0; width:850px; font-size:13px; font-family: "Century Gothic", "Lucida Grande", Helvetica, Arial, 微软雅黑; border:1px solid #ccc;background:#fff; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;overflow:hidden}
.bymt_option_section h2{margin-left:30px; font-size:15px;font-weight: 400; font-family:"Century Gothic", "Lucida Grande", Helvetica, Arial, 微软雅黑; color:#777; font-style:normal}
.bymt_option{width:850px; display:block; border-top:1px solid #eee}
.bymt_option_l{float:left; width:150px}
.bymt_option_l label{margin:20px 0 20px 20px; width:150px; display:block; font-size:13px}
.bymt_option_m{float:left; width:450px; margin:20px 0 20px 0}
.bymt_option_m input{font-size:13px; font-family: "Century Gothic", "Lucida Grande", Helvetica, Arial, 微软雅黑; color:#777}
.bymt_option_m .radio_options{margin:0 20px 0 5px; position:relative}
.bymt_option_m input[type="text"], .bymt_option_m select{width:430px; font-size:13px; font-family: "Century Gothic", "Lucida Grande", Helvetica, Arial, 微软雅黑; padding:4px; color:#333; line-height:1em; background:#f3f3f3}
.bymt_option_m input:focus, .bymt_option_m textarea:focus{background:#fff}
.bymt_option_m textarea{width:430px; height:60px; font-size:12px; padding:4px; color:#333; line-height:1.5em; background:#f3f3f3}
.bymt_option_r{float:left; width:220px}
.bymt_option_r small{margin:20px 0 20px 20px; width:200px; display:block; font-size:12px; color:#777}
#bymt_nav_list{margin:30px 0 0 0;}
#bymt_nav_list ul.bymt_tabs_js{margin:0 0 0 10px; padding:0; width:850px; list-style:none}
#bymt_nav_list ul.bymt_tabs_js li{float:left; margin:0 4px 0 20px; padding:5px 15px; border-left:1px solid #ccc; border-top:1px solid #ccc; border-right:1px solid #ccc; cursor:pointer;border-top-left-radius:5px 5px;border-top-right-radius:5px 5px;}
#bymt_nav_list ul.bymt_tabs_js li.selected{background:#fff; border-left:1px solid #888; border-top:1px solid #888; border-right:1px solid #888;border-top-left-radius:5px 5px;border-top-right-radius:5px 5px;}
#bymt_nav_list .bymt_inside{margin:0}
#bymt_nav_list .bymt_inside ul{padding:0; list-style:none}
.bymt_helppage{padding:20px 25px 20px 25px; width:800px; display:block; border-top:1px solid #eee}
.bymt_helppage p{font-size:13px}
.bymt_submit_form{float:left; margin:20px 0 0 0; display:block}
.bymt_reset_form{float:left; margin:20px 0 0 20px; display:block}
#bymt_admin_ie_warning_disable{float:right; color:#777; cursor:pointer}
#bymt_admin_ie_warning_disable:hover{color:#333}
.none{display:none}
fieldset{width:80%; margin:15px 0 10px 74px; padding:10px 0 20px 20px; border:1px solid #EEE}
fieldset legend{ cursor:pointer;  font-size:13px;  color:#FFF; background:#2683AE; border-color:#EEE; -moz-box-shadow:0 0 5px #EEE; -webkit-box-shadow:0 0 5px #EEE; box-shadow:0 0 5px #EEE; padding:2px 15px 4px 15px; -webkit-border-radius:30px; -moz-border-radius:30px; border-radius:30px; -webkit-box-shadow:1px 1px 1px rgba(0,0,0,.29),inset 1px 1px 1px rgba(255,255,255,.44); -moz-box-shadow:1px 1px 1px rgba(0,0,0,.29),inset 1px 1px 1px rgba(255,255,255,.44); box-shadow:1px 1px 1px rgba(0,0,0,.29),inset 1px 1px 1px rgba(255,255,255,.44)}
.ads a{text-decoration: none;color:#268bb8;}
.ads a:hover{color:#d62d00;}
.ads {color:#9a9a9a}
</style>
<script type="text/javascript">
jQuery(document).ready(function($){
	jQuery.cookie=function(b,j,m){if(typeof j!="undefined"){m=m||{};if(j===null){j="";m.expires=-1}var e="";if(m.expires&&(typeof m.expires=="number"||m.expires.toUTCString)){var f;if(typeof m.expires=="number"){f=new Date();f.setTime(f.getTime()+(m.expires*24*60*60*1000))}else{f=m.expires}e="; expires="+f.toUTCString()}var l=m.path?"; path="+(m.path):"";var g=m.domain?"; domain="+(m.domain):"";var a=m.secure?"; secure":"";document.cookie=[b,"=",encodeURIComponent(j),e,l,g,a].join("")}else{var d=null;if(document.cookie&&document.cookie!=""){var k=document.cookie.split(";");for(var h=0;h<k.length;h++){var c=jQuery.trim(k[h]);if(c.substring(0,b.length+1)==(b+"=")){d=decodeURIComponent(c.substring(b.length+1));break}}}return d}};
	jQuery("input.bymt_cbbox:checked").each(function() {jQuery(this).parents().children(".cbbox_checked").show();}); jQuery("input.bymt_cbbox").click(function () {if (jQuery(this).is(":checked")){jQuery(this).parents().children(".cbbox_checked").show();} else {jQuery(this).parents().children(".cbbox_checked").hide();}});
	jQuery("input.bymt_cbradio_op:checked").each(function() {jQuery(this).parents().children(".cbradio_checked").show();}); jQuery("input.bymt_cbradio_op").click(function () {if (jQuery(this).is(":checked")){jQuery(this).parents().children(".cbradio_checked").show();} else {jQuery(this).parents().children(".cbradio_checked").hide();}});jQuery("input.bymt_cbradio_cl").click(function () {if (jQuery(this).is(":checked")){jQuery(this).parents().children(".cbradio_checked").hide();} else {jQuery(this).parents().children(".cbradio_checked").show();}});
	jQuery('.bymt_inside ul li:last-child').css('border-bottom','0px');jQuery('.bymt_tabs_js').each(function(){jQuery(this).children('li:first').addClass('selected');});jQuery('.bymt_inside > *').hide();jQuery('.bymt_inside > *:first-child').show();jQuery('.bymt_tabs_js li').click(function(evt){var clicked_tab_ref = jQuery(this).attr('id');jQuery(this).parent().children('li').removeClass('selected');jQuery(this).addClass('selected');jQuery(this).parent().parent().children('.bymt_inside').children('*').hide();jQuery('.bymt_inside ' + clicked_tab_ref).show();evt.preventDefault();});
	function bymt_upgradeie(){if(jQuery.browser.msie && parseInt(jQuery.browser.version) <= 8){ return true;}return false;};var bymt_upiew = jQuery.cookie('bymt_upgradeiewarning');if(bymt_upgradeie() && bymt_upiew != 'seen' ){jQuery(function(){jQuery("#bymt_admin_ie_warning").fadeIn(500);jQuery('#bymt_admin_ie_warning_disable').click(function(){jQuery.cookie('bymt_upgradeiewarning', 'seen');jQuery("#bymt_admin_ie_warning").fadeOut(500);return false;});});};
	$(".toggle").click(function(){$(this).next().slideToggle('slow')});
});
</script>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div><h2>主题设置</h2><br>
	<div id="bymt_admin_ie_warning" class="bymt_nodisplay updated fade"><p><strong> <?php _e('建议: 为了获得更好的体验，请不要使用IE浏览器.','bymt') ?><span id="bymt_admin_ie_warning_disable">Close [X]</span></strong></p></div>
	<div class="ads">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当前主题：<a href="https://github.com/maicong/BYMT/tree/v1" target="_blank">BYMT v1</a> | 当前版本：<a href="https://github.com/maicong/BYMT/releases/tag/v<?php echo THEMEVER; ?>" target="_blank"><?php echo THEMEVER; ?></a> | 最后更新：<a><?php echo THEMEUPDATE; ?></a> | 主题作者：<a href="https://maicong.me/" target="_blank">麦田一根葱</a></div>
		<form method="post" action="options.php">
		<?php settings_fields( 'bymt-settings-group' ); ?>
		<div id="bymt_nav_list">
			<ul class="bymt_tabs_js">
				<li class="tabs_general" id="#lu-tab-general"><?php _e('网站设置','bymt') ?></li>
				<li class="tabs_appearance" id="#lu-tab-header"><?php _e('外观设置','bymt') ?></li>
				<li class="tabs_functions" id="#lu-tab-functions"><?php _e('功能设置','bymt') ?></li>
				<li class="tabs_sns" id="#lu-tab-sns"><?php _e('SNS设置','bymt') ?></li>
                <li class="tabs_themead" id="#lu-tab-ads"><?php _e('广告设置','bymt') ?></li>
				<li class="tabs_themead" id="#lu-tab-system"><?php _e('登录相关','bymt') ?></li>
			</ul>
			<div class="bymt_inside">
				<ul id="lu-tab-general" class="list lu-tab-list">
					<div class="bymt_option_wrap">
						<div class="bymt_option_section">
							<h2><?php _e('网站基本信息设置','bymt') ?></h2>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[description_content]"><?php _e('网站描述','bymt') ?></label></div>
							<div class="bymt_option_m">
								<textarea type="textarea" name="bymt_options[description_content]" placeholder="请输入网站描述"><?php echo bymt_option('description_content'); ?></textarea>
							</div>
							<div class="bymt_option_r"><small><?php _e('用简洁凝练的话对你的网站进行描述','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[keyword_content]"><?php _e('网站关键词','bymt') ?></label></div>
							<div class="bymt_option_m">
								<textarea type="textarea" name="bymt_options[keyword_content]" placeholder="关键词1,关键词2,关键词3"><?php echo bymt_option('keyword_content'); ?></textarea>
							</div>
							<div class="bymt_option_r"><small><?php _e('多个关键词请用英文逗号隔开','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[statistics]"><?php _e('网站统计','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[statistics]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('statistics')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[statistics]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('statistics')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('网站统计代码设置','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[statisticscode]"><?php _e('统计代码','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea  type="textarea" name="bymt_options[statisticscode]"><?php echo bymt_option('statisticscode'); ?></textarea></div>
								<div class="bymt_option_r"><small><?php _e('输入统计代码。<br />统计代码不会在页面中显示，但统计功能是正常的','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[icp_ck]"><?php _e('网站备案号','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[icp_ck]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('icp_ck')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[icp_ck]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('icp_ck')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('网站备案号设置','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[icp]"><?php _e('备案号','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[icp]" value="<?php echo stripslashes(bymt_option('icp')); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('填写您在工信部的备案号','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[footer]"><?php _e('底部左侧文字','bymt') ?></label></div>
							<div class="bymt_option_m">
								<textarea type="textarea" name="bymt_options[footer]"><?php if(stripslashes(bymt_option('footer'))){echo stripslashes(bymt_option('footer'));}else{echo '&copy; 2012-2013&nbsp;<a href="/">'.get_bloginfo('name').'</a>&nbsp;All Rights Reserved';}?></textarea>

							</div>
							<div class="bymt_option_r"><small><?php _e('填写的文字将显示在网站底部左侧，支持HTML。<br />如果不填写，则显示为默认的内容。','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div style="padding:0 0 20px 20px">底部左侧内容预览：&nbsp;&nbsp;&nbsp;&nbsp;<?php if(stripslashes(bymt_option('footer'))) : ?><?php echo stripslashes(bymt_option('footer'));?><?php else : ?>&copy; 2012-2013&nbsp;<a href="/"><?php bloginfo( 'name' ); ?></a>&nbsp;All Rights Reserved<?php endif; ?></div>
						</div>

					</div>
				</ul><!-- #lu-tab-general -->

				<ul id="lu-tab-header" class="list lu-tab-list">
					<div class="bymt_option_wrap">
						<div class="bymt_option_section">
							<h2><?php _e('这里进行一些基本的外观设置，其中logo的大小为280*60，顶部右侧内容为670*80','bymt') ?></h2>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[favicon_ck]"><?php _e('favicon图标','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[favicon_ck]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('favicon_ck')); ?>/> <?php _e('使用默认','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[favicon_ck]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('favicon_ck')); ?>/> <?php _e('自定义','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('设置网站favicon图标','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[custom_favicon]"><?php _e('自定义favicon图标','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[custom_favicon]" value="<?php echo bymt_option('custom_favicon'); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('输入你的favicon图标地址','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[check_logo]"><?php _e('网站logo','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[check_logo]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('check_logo')); ?>/> <?php _e('使用logo图片','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[check_logo]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('check_logo')); ?>/> <?php _e('使用网站标题','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('设置网站logo显示样式，默认为使用logo图片','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[custom_sitetitle]"><?php _e('自定义网站标题','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[custom_sitetitle]" value="<?php echo bymt_option('custom_sitetitle'); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('自定义您的网站标题，留空则使用默认标题','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[check_logodesc]"><?php _e('标题下显示描述','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[check_logodesc]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('check_logodesc')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[check_logodesc]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('check_logodesc')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('开关网站logo标题下的描述信息','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[custom_logodesc]"><?php _e('自定义标题下描述信息','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[custom_logodesc]" value="<?php echo bymt_option('custom_logodesc'); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('自定义您的网站标题下的描述信息，留空则使用默认描述','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[custom_logo]"><?php _e('logo设置','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_logo]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('custom_logo')); ?>/> <?php _e('使用默认','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_logo]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('custom_logo')); ?>/> <?php _e('自定义','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('设置网站logo','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[logo_url]"><?php _e('自定义logo','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[logo_url]" value="<?php echo bymt_option('logo_url'); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('输入你的logo图片地址','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[custom_topblock]"><?php _e('顶部右侧内容','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_topblock]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('custom_topblock')); ?>/> <?php _e('使用默认','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_topblock]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('custom_topblock')); ?>/> <?php _e('自定义','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('设置顶部右侧内容，默认为欢迎回来','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[topblock_content]"><?php _e('自定义内容','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea type="textarea" name="bymt_options[topblock_content]"><?php echo bymt_option('topblock_content'); ?></textarea></div>
								<div class="bymt_option_r"><small><?php _e('输入顶部右侧自定义内容，支持html','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[notice]"><?php _e('公告栏','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[notice]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('notice')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[notice]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('notice')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('开启公告栏.','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[ggid]"><?php _e('文章id','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="number" name="bymt_options[ggid]" value="<?php echo bymt_option('ggid'); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('用来作为公告栏的文章id，只能为数字，不使用请留空','bymt') ?></small></div>
								<div class="clearfix"></div>
								<div class="bymt_option_l"><label for="bymt_options[noticecontent]"><?php _e('公告内容','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[noticecontent]" value="<?php echo bymt_option('noticecontent'); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('如果不想使用文章评论作为公告内容，可以在这里输入公告内容，并将上面文章id留空，支持html','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

							<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[custom_search]"><?php _e('搜索框文字','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_search]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('custom_search')); ?>/> <?php _e('使用默认','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_search]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('custom_search')); ?>/> <?php _e('自定义','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('设置搜索框默认文字','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[search_word]"><?php _e('自定义搜索框文字','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[search_word]" value="<?php if(stripslashes(bymt_option('search_word'))){echo stripslashes(bymt_option('search_word'));}else{echo '我是搜索酱...';}?>"/></div>
								<div class="bymt_option_r"><small><?php _e('输入你要设置的搜索框文字','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

							<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[custom_footerlink]"><?php _e('底部友情链接','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_footerlink]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('custom_footerlink')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_footerlink]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('custom_footerlink')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能显示友情链接，请配合<a href="http://wordpress.org/plugins/link-manager/"  target="_blank">Link Manager</a>插件使用','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[footerlink_word]"><?php _e('自定义友情链接标题','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[footerlink_word]" value="<?php if(stripslashes(bymt_option('footerlink_word'))){echo stripslashes(bymt_option('footerlink_word'));}else{echo '友来友往';}?>"/></div>
								<div class="bymt_option_r"><small><?php _e('输入你要设置的自定义友情链接标题','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[custom_circle]"><?php _e('圆圈加载特效','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_circle]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('custom_circle')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_circle]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('custom_circle')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('是否显示左下角圆圈加载特效','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

                       <div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[custom_gotop]"><?php _e('返回顶部','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_gotop]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('custom_gotop')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[custom_gotop]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('custom_gotop')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('是否显示右下角返回顶部','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

                        <div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[rand_bg]"><?php _e('随机背景','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[rand_bg]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('rand_bg')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[rand_bg]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('rand_bg')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('是否显示随机背景，背景图片存放在主题<span style="color:red">images/background</span>目录里','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

					</div>
				</ul><!-- #lu-tab-header -->

				<ul id="lu-tab-functions" class="list lu-tab-list">
					<div class="bymt_option_wrap">
						<div class="bymt_option_section">
							<h2><?php _e('主题常用功能开关都在这里','bymt') ?></h2>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[avatar_cache]"><?php _e('Gravatar头像缓存','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[avatar_cache]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('avatar_cache')); ?>/> <?php _e('关闭','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[avatar_cache]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('avatar_cache')); ?>/> <?php _e('开启','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('开启头像缓存前，请确保根目录存在<span style="color:red">avatar</span>文件夹，并且里面存在<span style="color:red">avatar.jpg</span>这个默认头像文件','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

							<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[wpshare]"><?php _e('选中内容分享到微博','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[wpshare]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('wpshare')); ?>/> <?php _e('关闭','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[wpshare]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('wpshare')); ?>/> <?php _e('开启','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('是否开启选中内容分享到微博','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

							<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[txtshare]"><?php _e('是否显示文章分享','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtshare]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('txtshare')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtshare]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('txtshare')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能显示文章内页“分享到”功能','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

							<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[txtcopyright]"><?php _e('是否显示文章版权','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtcopyright]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('txtcopyright')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtcopyright]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('txtcopyright')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能显示文章结束后的版权信息，新建文章时请添加一个名称为“<span style="color:red">copyright</span>”的自定义栏目，值为网址，留空则为原创','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

							<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[txtnext]"><?php _e('是否显示上下篇链接','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtnext]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('txtnext')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtnext]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('txtnext')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能用于在文章页显示上一篇和下一篇链接','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[postauthor]"><?php _e('是否显示文章作者','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[postauthor]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('postauthor')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[postauthor]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('postauthor')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能显示文章作者','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[postinfoviews]"><?php _e('是否显示文章浏览量','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[postinfoviews]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('postinfoviews')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[postinfoviews]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('postinfoviews')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能显示文章浏览量，需配合<a href="http://wordpress.org/extend/plugins/wp-postviews/" target="_blank">WP-PostViews</a>插件使用','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[txttag]"><?php _e('是否显示文章关键词','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[txttag]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('txttag')); ?>/> <?php _e('不显示','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[txttag]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('txttag')); ?>/> <?php _e('显示','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能显示文章关键词，注意控制关键词个数，太多将被截断','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[thumbnail]"><?php _e('是否为每篇文章<br/>自动匹配一张缩略图','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[thumbnail]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('thumbnail')); ?>/> <?php _e('否','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[thumbnail]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('thumbnail')); ?>/> <?php _e('是','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('该功能为每篇普通样式的文章自动匹配一张缩略图。缩略图显示原理：如果你为文章设置缩略图则显示你设置的缩略图；若没有，则获取文章第一张图片作为缩略图；否则则显示主题内置的缩略图','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>


						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[txtrelated]"><?php _e('相关文章','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtrelated]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('txtrelated')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtrelated]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('txtrelated')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('使用主题自带相关文章功能','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[txtrelatednum]"><?php _e('文章数量','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="number" name="bymt_options[txtrelatednum]" value="<?php echo bymt_option('txtrelatednum'); ?>"/></div>
								<div class="bymt_option_r"><small><?php _e('输入需要显示的文章数量，推荐使用偶数','bymt') ?></small></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[guestwall]"><?php _e('留言板读者墙','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[guestwall]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('guestwall')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[guestwall]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('guestwall')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('仅在使用留言板模板情况下有效','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[lightbox_ck]"><?php _e('Lightbox查看图片','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[lightbox_ck]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('lightbox_ck')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[lightbox_ck]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('lightbox_ck')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('若想要使用其他图片放大插件，请选择不使用','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[lazyload]"><?php _e('图片延时加载','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[lazyload]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('lazyload')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[lazyload]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('lazyload')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('图片延时加载是指在浏览器可视区域外的图片不会被载入，当页面滚动到它们所在的位置时才可见。该功能可加快页面载入速度，降低服务器负担','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[jQuery]"><?php _e('jQuery库选择','bymt') ?></label></div>
							<div class="bymt_option_m">
								调用新浪在线jQuery库
								<span class="radio_options"><label><input type="radio" name="bymt_options[sinajq]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('sinajq')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[sinajq]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('sinajq')); ?>/> <?php _e('使用','bymt') ?></label></span>
								<div class="clearfix"></div><br/>
								调用谷歌在线jQuery库
								<span class="radio_options"><label><input type="radio" name="bymt_options[googlejq]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('googlejq')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[googlejq]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('googlejq')); ?>/> <?php _e('使用','bymt') ?></label></span>
								<div class="clearfix"></div><br/>
								调用百度在线jQuery库
								<span class="radio_options"><label><input type="radio" name="bymt_options[baidujq]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('baidujq')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[baidujq]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('baidujq')); ?>/> <?php _e('使用','bymt') ?></label></span>
								<div class="clearfix"></div><br/>
								调用微软在线jQuery库
								<span class="radio_options"><label><input type="radio" name="bymt_options[microsoftjq]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('microsoftjq')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[microsoftjq]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('microsoftjq')); ?>/> <?php _e('使用','bymt') ?></label></span>
								<div class="clearfix"></div><br/>
								调用又拍云在线jQuery库
								<span class="radio_options"><label><label><input type="radio" name="bymt_options[upaiyunjq]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('upaiyunjq')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[upaiyunjq]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('upaiyunjq')); ?>/> <?php _e('使用','bymt') ?></label></span>
								<div class="clearfix"></div><br/>
								调用主题自带jQuery库
								<span class="radio_options"><label><input type="radio" name="bymt_options[selfjq]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('selfjq')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[selfjq]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('selfjq')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
							<div class="bymt_option_r"><small><?php _e('jQuery库必须且<span style="color:red">只能选一个</span>，不要多选，如果多选则取最上面那个，因为众所周知的原因，谷歌的服务不稳定；为了稳妥和减轻主机负担，建议调用新浪或百度的在线jQuery库','bymt') ?></small></div>
							<div class="clearfix"></div>

						</div>
					</div>
				</ul><!-- #lu-tab-functions -->

				<ul id="lu-tab-sns" class="list lu-tab-list">
					<div class="bymt_option_wrap">
						<div class="bymt_option_section"><h2><?php _e('SNS社交网站，微信图片尺寸270*270','bymt') ?></h2></div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[rss]"><?php _e('<b>RSS</b>','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[rss]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('rss')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[rss]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('rss')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('RSS订阅','bymt') ?></small></div>
							<div class="clearfix"></div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[twitter]"><?php _e('<b>Twitter</b>','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[twitter]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('twitter')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[twitter]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('twitter')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('Twitter地址','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[twitterlink]"><?php _e('链接地址','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[twitterlink]" value="<?php echo bymt_option('twitterlink'); ?>"/></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[facebook]"><?php _e('<b>facebook</b>','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[facebook]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('facebook')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[facebook]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('facebook')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('facebook地址','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[facebooklink]"><?php _e('链接地址','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[facebooklink]" value="<?php echo bymt_option('facebooklink'); ?>"/></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[weibo]"><?php _e('<b>新浪微博</b>','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[weibo]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('weibo')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[weibo]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('weibo')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('新浪微博地址','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[weibolink]"><?php _e('链接地址','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[weibolink]" value="<?php echo bymt_option('weibolink'); ?>"/></div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[qqweibo]"><?php _e('<b>腾讯微博</b>','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[qqweibo]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('qqweibo')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[qqweibo]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('qqweibo')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('腾讯微博地址','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[qqweibolink]"><?php _e('链接地址','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[qqweibolink]" value="<?php echo bymt_option('qqweibolink'); ?>"/></div>
								<div class="clearfix"></div>
							</div>
						</div>

							<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[weixin]"><?php _e('<b>微信公众</b>','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[weixin]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('weixin')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[weixin]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('weixin')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('微信二维码图片地址','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[weixinimg]"><?php _e('图片地址','bymt') ?></label></div>
								<div class="bymt_option_m"><input type="text" name="bymt_options[weixinimg]" value="<?php echo bymt_option('weixinimg'); ?>"/></div>
								<div class="clearfix"></div>
							</div>
						</div>

					</div>
				</ul><!-- #lu-tab-sns -->

                <ul id="lu-tab-ads" class="list lu-tab-list">
					<div class="bymt_option_wrap">
						<div class="bymt_option_section"><h2><?php _e('这里包含了本主题所有的广告位，根据需要可自行添加','bymt') ?></h2></div>
						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[indexad1]"><?php _e('首页广告位1','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[indexad1]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('indexad1')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[indexad1]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('indexad1')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('有边栏：760*90 无边栏：最大宽度1086px','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[indexadcode1]"><?php _e('广告代码','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea type="textarea" name="bymt_options[indexadcode1]"><?php echo bymt_option('indexadcode1'); ?></textarea></div>
							<div class="clearfix"></div>
                            </div>
						</div>
						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[indexad2]"><?php _e('首页广告位2','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[indexad2]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('indexad2')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[indexad2]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('indexad2')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('有边栏：760*90 无边栏：最大宽度1086px','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[indexadcode2]"><?php _e('广告代码','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea type="textarea" name="bymt_options[indexadcode2]"><?php echo bymt_option('indexadcode2'); ?></textarea></div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[sidebarad250]"><?php _e('侧边栏广告位1','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[sidebarad250]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('sidebarad250')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[sidebarad250]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('sidebarad250')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('250*250 默认随边栏滚动跟随','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[sidebarad250code]"><?php _e('广告代码','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea type="textarea" name="bymt_options[sidebarad250code]"><?php echo bymt_option('sidebarad250code'); ?></textarea></div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[sidebarad120]"><?php _e('侧边栏广告位2','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[sidebarad120]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('sidebarad120')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[sidebarad120]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('sidebarad120')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('两个120*90','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[sidebarad120code1]"><?php _e('广告代码 *两个','bymt') ?></label></div>
								<div class="bymt_option_m">
								<textarea type="textarea" name="bymt_options[sidebarad120code1]"><?php echo bymt_option('sidebarad120code1'); ?></textarea><br />
								<textarea type="textarea" name="bymt_options[sidebarad120code2]"><?php echo bymt_option('sidebarad120code2'); ?></textarea></div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[sidebarad25060]"><?php _e('侧边栏广告位3','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[sidebarad25060]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('sidebarad25060')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[sidebarad25060]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('sidebarad25060')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('250*60','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[sidebarad25060code]"><?php _e('广告代码','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea type="textarea" name="bymt_options[sidebarad25060code]"><?php echo bymt_option('sidebarad25060code'); ?></textarea></div>
								<div class="clearfix"></div>
							</div>
						</div>
                        <div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[txtad1]"><?php _e('文章页广告位1','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtad1]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('txtad1')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtad1]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('txtad1')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('有边栏：760*90 无边栏：最大宽度1086px','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[txtadcode1]"><?php _e('广告代码','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea type="textarea" name="bymt_options[txtadcode1]"><?php echo bymt_option('txtadcode1'); ?></textarea></div>
								<div class="clearfix"></div>
							</div>
						</div>
                        <div class="bymt_option">
							<div class="bymt_option_l"><label for="bymt_options[txtad2]"><?php _e('文章页广告位2','bymt') ?></label></div>
							<div class="bymt_option_m">
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtad2]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('txtad2')); ?>/> <?php _e('不使用','bymt') ?></label></span>
								<span class="radio_options"><label><input type="radio" name="bymt_options[txtad2]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('txtad2')); ?>/> <?php _e('使用','bymt') ?></label></span>
							</div>
                            <div class="bymt_option_r"><small><?php _e('有边栏：760*90 无边栏：最大宽度1086px','bymt') ?></small></div>
							<div class="clearfix"></div>
							<div class="cbradio_checked bymt_nodisplay">
								<div class="bymt_option_l"><label for="bymt_options[txtadcode2]"><?php _e('广告代码','bymt') ?></label></div>
								<div class="bymt_option_m"><textarea type="textarea" name="bymt_options[txtadcode2]"><?php echo bymt_option('txtadcode2'); ?></textarea></div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</ul><!-- #lu-tab-ads -->

				<ul id="lu-tab-system" class="list lu-tab-list">
					<div class="bymt_option_wrap">
						<div class="bymt_option_section">
							<h2><?php _e('这里设置后台登录的一些功能','bymt') ?></h2>
						</div>

					<div class="bymt_option">
						<div class="bymt_option_l"><label for="bymt_options[login_success]"><?php _e('后台登录成功提醒','bymt') ?></label></div>
						<div class="bymt_option_m">
							<span class="radio_options"><label><input type="radio" name="bymt_options[login_success]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('login_success')); ?>/> <?php _e('关闭','bymt') ?></label></span>
							<span class="radio_options"><label><input type="radio" name="bymt_options[login_success]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('login_success')); ?>/> <?php _e('开启','bymt') ?></label></span>
						</div>
						<div class="bymt_option_r"><small><?php _e('后台有帐号登录成功，发送Email到管理员邮箱','bymt') ?></small></div>
						<div class="clearfix"></div>
					</div>

					<div class="bymt_option">
						<div class="bymt_option_l"><label for="bymt_options[login_fail]"><?php _e('后台登录失败提醒','bymt') ?></label></div>
						<div class="bymt_option_m">
							<span class="radio_options"><label><input type="radio" name="bymt_options[login_fail]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('login_fail')); ?>/> <?php _e('关闭','bymt') ?></label></span>
							<span class="radio_options"><label><input type="radio" name="bymt_options[login_fail]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('login_fail')); ?>/> <?php _e('开启','bymt') ?></label></span>
						</div>
						<div class="bymt_option_r"><small><?php _e('后台有帐号登录失败，发送Email到管理员邮箱','bymt') ?></small></div>
						<div class="clearfix"></div>
					</div>

					<div class="bymt_option">
						<div class="bymt_option_l"><label for="bymt_options[custom_login]"><?php _e('定义登陆界面样式','bymt') ?></label></div>
						<div class="bymt_option_m">
							<span class="radio_options"><label><input type="radio" name="bymt_options[custom_login]" class="bymt_cbradio_cl" value="" <?php checked('', bymt_option('custom_login')); ?>/> <?php _e('关闭','bymt') ?></label></span>
							<span class="radio_options"><label><input type="radio" name="bymt_options[custom_login]" class="bymt_cbradio_op" value="1" <?php checked('1', bymt_option('custom_login')); ?>/> <?php _e('开启','bymt') ?></label></span>
						</div>
						<div class="bymt_option_r"><small><?php _e('定义后台登陆界面的样式，样式文件在主题目录<span style="color:red">custom-login</span>里','bymt') ?></small></div>
						<div class="clearfix"></div>
					</div>

					</div>
				</ul><!-- #lu-tab-system -->

			</div><!-- .bymt_inside -->
		</div><!-- #bymt_nav_list -->
		<div class="bymt_submit_form">
			<input type="submit" class="button-primary bymt_submit_form_btn" name="save" value="<?php _e('Save Changes') ?>"/>
		</div>
	</form>
	<form method="post">
		<div class="bymt_reset_form">
			<input type="submit" name="reset" value="<?php _e('Reset') ?>" class="button-secondary bymt_reset_form_btn"/> 注意！点击重置将清空全部的主题设置，请谨慎操作
			<input type="hidden" name="reset" value="reset" />
		</div>
	</form>
<div class="clearfix"></div>
</div><!-- .wrap -->
<?php } ?>
