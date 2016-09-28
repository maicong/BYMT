<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/119
 * @version     2.1.2
 */

// 评论列表
function bymt_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
	global $commentcount;
    if(!$commentcount) {
		   $page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;
		   $cpp = get_option('comments_per_page');
		   $commentcount = $cpp * $page;
	}
?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>" <?php if( $depth > get_option('thread_comments_depth') && !wp_is_mobile() ){ echo ' style="margin-left:0px;"';} ?>>
   <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
   	<?php $add_below = 'div-comment'; ?>
   	<div class="comment-author vcard gravatar"><?php echo bymt_avatar($comment->comment_author_email); ?></div>
	<div class="floor">
	<?php
	if ( !$parent_id = $comment->comment_parent ) {
		++$commentcount;
		switch($commentcount){
			case 1:
				print_r("沙发");
				break;
			case 2:
				print_r("板凳");
				break;
			case 3:
				print_r("地板");
				break;
			default:
				printf(__('%s楼'), $commentcount);
		}
	}
	?>
	</div>
	 <div class="commenttext">
		 <span class="commentid"><?php comment_author_link(); ?></span>
		 <?php get_author_class($comment->comment_author_email,$comment->comment_author_url); ?>
		 <span class="datetime"><?php bymt_time_diff( $time_type = 'comment' ); ?></span>
		 <?php if ( $comment->comment_approved != '0' ){ ?>
		 <span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => '回复', 'add_below' =>$add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
		 <?php } ?>
		 <span class="edit_comment"><?php edit_post_link('编辑'); ?></span>
		<div class="comment_text">
		<?php if ( $comment->comment_approved == '0' ){?>
			<span style="color:#f00;">您的评论正在等待审核中...</span>
			<?php comment_text(); ?>
			<?php }else{ ?>
			<?php comment_text(); ?>
			<?php } ?>
		</div>
	</div>
  </div>
<?php
}

//评论回复邮件通知（所有回复都邮件通知）
if(bymt_c('mail_notify')){
function comment_mail_notify($comment_id) {
    $admin_notify = '0';
    $admin_email = get_bloginfo ('admin_email');
    $comment = get_comment($comment_id);
    $comment_author_email = trim($comment->comment_author_email);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    global $wpdb;
    if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
        $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
    if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
        $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
    $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
    $spam_confirmed = $comment->comment_approved;
    if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = '大神，您的评论有了新的回复！-  '. get_option("blogname");
        $message = '<style>.comm_box{font-family:Microsoft YaHei,Verdana;font-size:14px;color:#333;margin:1em 40px;background-color:#FAFAFA;border:1px solid #3C9CB6;border-radius: 5px}.comm_box h2{text-align:center;color: #FFF;background-color:#1091B3;margin: -1px;padding:2px;border-radius: 5px 5px 0 0}.comm_author{color: #0088dd;text-shadow: 0 1px 1px #97CCEE}.comm_body{margin: 2em;padding: 0.5em 1em;background-color: #fff;border: 1px solid #E9E9E9;border-radius: 5px}.comm_body .avatar{width: 50px;height: 50px;float: left}.comm_body .avatar img{border-radius: 5px;box-shadow: 0 0 3px rgba(0, 0, 0, 0.6)}.comm_body .comm_text{min-height: 50px;margin-left: 60px}.comm_reply{margin:1em 6em;padding: 0.5em 1em;background-color: #fff;border: 1px solid #E9E9E9;border-radius: 5px}.comm_reply .avatar{width: 40px;height: 40px; float: left;position: relative;top: 1px}.comm_reply .avatar img{border-radius: 5px;box-shadow: 0 0 3px #888}.comm_reply .comm_text{min-height: 40px;margin-left: 48px}.comm_text blockquote, .comm_text pre{color: #555;background-color: #F9F9F9;margin: 5px 0px;padding: 5px;border: 1px solid rgba(0, 0, 0, 0.03);border-left: 3px solid #ddd}.comm_detail{text-align:center;margin-bottom: 12px;padding: 0 1em}.comm_detail a{color: #0D87D3;text-decoration: none !important}.comm_detail a:hover{text-decoration: underline !important}.comm_note{color: #ADADAD;font-size: 12px;margin-bottom: 10px;text-align: center}</style><div class="comm_box"><h2>回复：' . get_the_title($comment->comment_post_ID) . '</h2><div class="comm_body"><div class="avatar">' . bymt_avatar(get_comment($parent_id)->comment_author_email, 50) . ' </div><div class="comm_text"><span class="comm_author">' . trim(get_comment($parent_id)->comment_author) . bymt_time_diff( $time_type = 'comment' ) . '</span><br />' . trim(get_comment($parent_id)->comment_content) . '</div></div><div class="comm_reply"><div class="avatar">' . bymt_avatar($comment->comment_author_email, 40) .'</div><div class="comm_text"><span class="comm_author">' . trim($comment->comment_author) . bymt_time_diff( $time_type = 'comment' ) . '</span><br /> ' . trim($comment->comment_content) . '</div></div><div class="comm_detail">欲知详情请猛戳：<a href="' . get_permalink($comment->comment_post_ID . "#comment-" . $comment->comment_ID) . '">' . get_permalink($comment->comment_post_ID . "#comment-" . $comment->comment_ID) . '</div><div class="comm_note">[ 系统邮件，自动发送 '. date("Y-m-d",time()) .'  ' . get_option("blogname") . ']</div></div>';
        $message = convert_smilies($message);
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail($to, $subject, $message, $headers);
    }
}
	add_action('comment_post', 'comment_mail_notify');
}

//评论VIP样式
function get_author_class($author_email,$author_url){
	global $wpdb;
	$adminEmail = get_bloginfo('admin_email');
	$count = count($wpdb->get_results("SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$author_email' "));
	$linkurls = $wpdb->get_results("SELECT link_url FROM $wpdb->links WHERE link_url = '$author_url'");
	if($author_email ==$adminEmail){
		echo '<span class="blogger" title="我是博主"></span>';
	}else{
		if($count>=1 && $count<5){
			echo '<span class="exp lv-1" title="酱油党"><i class="pro"></i><i class="level">Lv.1</i></span>';
		}elseif($count>=5 && $count<10){
			echo '<span class="exp lv-2" title="评论员"><i class="pro"></i><i class="level">Lv.2</i></span>';
		}elseif($count>=10 && $count<20){
			echo '<span class="exp lv-3" title="优秀评论员"><i class="pro"></i><i class="level">Lv.3</i></span>';
		}elseif($count>=20 && $count<4 ){
			echo '<span class="exp lv-4" title="资深评论员"><i class="pro"></i><i class="level">Lv.4</i></span>';
		}elseif($count>=40 && $count<80){
			echo '<span class="exp lv-5" title="专业评论员"><i class="pro"></i><i class="level">Lv.5</i></span>';
		}elseif($count>=80 &&$count<160){
			echo '<span class="exp lv-6" title="博客长老"><i class="pro"></i><i class="level">Lv.6</i></span>';
		}elseif($count>=160 && $count<320){
			echo '<span class="exp lv-7" title="博客元老"><i class="pro"></i><i class="level">Lv.7</i></span>';
		}elseif($count>=320){
			echo '<span class="exp lv-8" title="神一样存在的人物"><i class="pro"></i><i class="level">lv.8</i></span>';
		}
	}
	foreach ($linkurls as $linkurl) {
		if ($linkurl->link_url == $author_url )
			echo '<span class="link" title="友链认证"></span>';
	}
}

//评论表情路径
function bymt_custom_smilies_src ($img_src, $img, $siteurl) {
     return TPLDIR . '/images/smilies/' . $img;
}
add_filter('smilies_src','bymt_custom_smilies_src',1,10);

function global_wpsmiliestrans() {
	$wpsmiliestrans = array(
		':mrgreen:' => 'icon_mrgreen.gif',
		':neutral:' => 'icon_neutral.gif',
		':twisted:' => 'icon_twisted.gif',
		  ':arrow:' => 'icon_arrow.gif',
		  ':shock:' => 'icon_eek.gif',
		  ':smile:' => 'icon_smile.gif',
		    ':???:' => 'icon_confused.gif',
		   ':cool:' => 'icon_cool.gif',
		   ':evil:' => 'icon_evil.gif',
		   ':grin:' => 'icon_biggrin.gif',
		   ':idea:' => 'icon_idea.gif',
		   ':oops:' => 'icon_redface.gif',
		   ':razz:' => 'icon_razz.gif',
		   ':roll:' => 'icon_rolleyes.gif',
		   ':wink:' => 'icon_wink.gif',
		    ':cry:' => 'icon_cry.gif',
		    ':eek:' => 'icon_surprised.gif',
		    ':lol:' => 'icon_lol.gif',
		    ':mad:' => 'icon_mad.gif',
		    ':sad:' => 'icon_sad.gif',
		      '8-)' => 'icon_cool.gif',
		      '8-O' => 'icon_eek.gif',
		      ':-(' => 'icon_sad.gif',
		      ':-)' => 'icon_smile.gif',
		      ':-?' => 'icon_confused.gif',
		      ':-D' => 'icon_biggrin.gif',
		      ':-P' => 'icon_razz.gif',
		      ':-o' => 'icon_surprised.gif',
		      ':-x' => 'icon_mad.gif',
		      ':-|' => 'icon_neutral.gif',
		      ';-)' => 'icon_wink.gif',
		       '8O' => 'icon_eek.gif',
		       ':(' => 'icon_sad.gif',
		       ':)' => 'icon_smile.gif',
		       ':?' => 'icon_confused.gif',
		       ':D' => 'icon_biggrin.gif',
		       ':P' => 'icon_razz.gif',
		       ':o' => 'icon_surprised.gif',
		       ':x' => 'icon_mad.gif',
		       ':|' => 'icon_neutral.gif',
		       ';)' => 'icon_wink.gif',
		      ':!:' => 'icon_exclaim.gif',
		      ':?:' => 'icon_question.gif',
	);
	$GLOBALS['wpsmiliestrans'] = $wpsmiliestrans;
}
add_action('init', 'global_wpsmiliestrans');

//评论表情
function wp_smilies() {
	global $wpsmiliestrans;
	if ( !get_option('use_smilies') or (empty($wpsmiliestrans))) return;
	$smilies = array_unique($wpsmiliestrans);
	$link='';
	foreach ($smilies as $key => $smile) {
		$file = TPLDIR .'/images/smilies/'.$smile;
		$value = " ".$key." ";
		$title = str_replace(":","",$key);
		$img = "<img src=\"{$file}\" alt=\"{$smile}\" data-value=\"{$value}\" />";
		$imglink = htmlspecialchars($img);
		$link .= "<li>{$img}</li>";
	}
	return '<ul>'.$link.'</ul>';
}

//增强评论模块
function bymt_allow_tags($comment) {
  global $allowedtags;
  if(bymt_c('tools_code')){
 	$allowedtags['pre'] = array('class'=>array(),'lang'=>array());
  }
  if(bymt_c('tools_img')){
  	$allowedtags['img'] = array('src'=>array(),'alt'=>array());
  }
  return $comment;
}
add_filter('preprocess_comment', 'bymt_allow_tags');

//评论框功能按钮
function bymt_comm_tools() {
	echo '<div id="comment-tools"><ul>';
	if(bymt_c('tools_smile')) echo '<li id="smilies-box">'. wp_smilies() .'</li>';
	if(bymt_c('tools_smile')) echo '<li id="tools-smilies" title="表情"><i class="icon-smile"></i></li>';
	if(bymt_c('tools_b')) echo '<li id="tools-strong" title="粗体"><i class="icon-bold"></i></li>';
	if(bymt_c('tools_i')) echo '<li id="tools-em" title="斜体"><i class="icon-italic"></i></li>';
	if(bymt_c('tools_u')) echo '<li id="tools-underline" title="下划线"><i class="icon-underline"></i></li>';
	if(bymt_c('tools_s')) echo '<li id="tools-del" title="删除线"><i class="icon-strike"></i></li>';
	if(bymt_c('tools_q')) echo '<li id="tools-quote" title="引用"><i class="icon-quote-left"></i></li>';
	if(bymt_c('tools_code')) echo '<li id="tools-code" title="代码"><i class="icon-code"></i></li>';
	if(bymt_c('tools_img')) echo '<li id="tools-image" title="图片"><i class="icon-picture"></i></li>';
	if(bymt_c('tools_come')) echo '<li id="tools-come" title="签到"><i class="icon-pencil"></i></li>';
	if(bymt_c('tools_good')) echo '<li id="tools-good" title="赞美"><i class="icon-up"></i></li>';
	if(bymt_c('tools_bad')) echo '<li id="tools-bad" title="埋怨"><i class="icon-down"></i></li>';
	if(bymt_c('tools_admin')) echo '<li id="tools-admin" title="私信给管理员"><i class="icon-mail"></i></li>';
	echo '</ul>';
	if(bymt_c('tools_code')) echo '
	<div id="add-code">
		<p>选择代码语言：
			<select id="add-codelang-s">
				<option value="actionScript">ActionScript</option>
				<option value="appleScript">AppleScript</option>
				<option value="bash">Bash</option>
				<option value="c#">C#</option>
				<option value="c++">C++</option>
				<option value="css">CSS</option>
				<option value="delphi">Delphi</option>
				<option value="diff">Diff</option>
				<option value="haml">Haml</option>
				<option value="xml">HTML,XML</option>
				<option value="ini">Ini</option>
				<option value="json">JSON</option>
				<option value="java">Java</option>
				<option value="JavaScript">JavaScript</option>
				<option value="php">PHP</option>
				<option value="perl">Perl</option>
				<option value="python">Python</option>
				<option value="ruby">Ruby</option>
				<option value="scala">Scala</option>
				<option value="scss">SCSS</option>
				<option value="sql">SQL</option>
			</select>
			或者手动填写：<input type="text" id="add-codelang-i" class="input" placeholder="请输入代码语言" />
		</p>
		<p><textarea id="add-codetext" class="textarea" placeholder="请在这里贴入代码" /></textarea></p>
		<p id="add-code-ok"><small>无需对代码进行转义，程序会自动转义</small><a class="btn">插入</a></p>
	</div>';
	if(bymt_c('tools_img')) echo '
	<div id="add-image">
		<p>图片地址：<input type="text" id="add-imgurl" class="input" placeholder="请输入图片地址" /></p>
		<p>图片描述：<input type="text" id="add-imgalt" class="input" placeholder="请输入图片描述" /></p>
		<p id="add-image-ok"><small>仅支持 .jpg .png .gif 格式的图片</small><a class="btn">插入</a></p>
	</div>';
	echo '</div>';
}

//检测垃圾评论
function bymt_fuckspam($comment) {
    if(is_user_logged_in()){ return $comment;}
	if(!isset($comment['comment_author_IP'])) $comment['comment_author_IP'] = bymt_getIP('Ip');
	if(!isset($comment['comment_agent'])) $comment['comment_agent'] = $_SERVER['HTTP_USER_AGENT'];
    if(wp_blacklist_check($comment['comment_author'],$comment['comment_author_email'],$comment['comment_author_url'], $comment['comment_content'], $comment['comment_author_IP'], $comment['comment_agent'] )){
         _Err(__('草你麻痹垃圾评论滚粗！'));
    }else{
        return $comment;
    }
}
add_filter('preprocess_comment', 'bymt_fuckspam');

//管理员邮箱检测
function bymt_CheckEmailAndName(){
	global $wpdb;
	$comment_author = ( isset($_POST['author']) ) ? trim(strip_tags($_POST['author'])) : null;
	$comment_author_email = ( isset($_POST['email']) ) ? trim($_POST['email']) : null;
	if(!$comment_author || !$comment_author_email){
		return;
	}
	$result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '" . $comment_author . "' OR user_email = '" . $comment_author_email . "'");
	if ($result_set) {
		if ($result_set[0]->display_name == $comment_author){
			_Err(__('警告: 您不能用这个昵称，因为这是博主的昵称！'));
		}else{
			_Err(__('警告: 您不能使用该邮箱，因为这是博主的邮箱！'));
		}
	}
}
add_action('pre_comment_on_post', 'bymt_CheckEmailAndName');

//评论字数限制
if(bymt_c('com_length')){
function bymt_comment_length( $comment ) {
	$min_length = bymt_c('com_length_min') =="" ? 2 : bymt_c('com_length_min');
	$max_length = bymt_c('com_length_max') =="" ? 10000 : bymt_c('com_length_max');
	$point_length = mb_strlen($comment['comment_content'],'UTF8');
	if ( $point_length < $min_length )
        {
			_Err( __('抱歉,您的评论太短了,请至少输入' . $min_length .'个字(已输入'. $point_length .'个字)') );
        }
	if ( $point_length > $max_length )
        {
			_Err( __('抱歉,您的评论太长了,请不要超过' . $max_length .'个字(已输入'. $point_length .'个字)') );
        }
	return $comment;
}
add_filter( 'preprocess_comment', 'bymt_comment_length' );
}

//评论链接长度检测
if(bymt_c('spam_url')){
function bymt_spam_url_length( $approved , $commentdata ) {
	$spam_length = bymt_c('spam_url_length') =="" ? 50 : bymt_c('spam_url_length');
    return ( strlen( $commentdata['comment_author_url'] ) > $spam_length ) ? 'spam' : $approved;
  }
add_filter( 'pre_comment_approved', 'bymt_spam_url_length', 99, 2 );
}

//评论外链数检测
if(bymt_c('spam_links')){
function bymt_spamlinks($comment) {
	$spamlinks = preg_match_all( '/<a [^>]*href/i', $comment['comment_content'], $out );
	$spamlinks2 = preg_match_all( '/http:\/\//i', $comment['comment_content'], $out );
	$max_links = bymt_c('spam_links_num') =="" ? 3 : bymt_c('spam_links_num');
	if ($spamlinks>$max_links||$spamlinks2>$max_links){
		_Err(__('抱歉,检测到评论外链过多,请重写'));
	} else {
        return $comment;
    }
}
add_filter('preprocess_comment', 'bymt_spamlinks');
}

//评论语言检测
if(bymt_c('com_lang')){
function bymt_comment_post( $comment ) {
	$content = $comment['comment_content'];
	$pattern_en = '/[一-龥]/u';
	$pattern_ja = '/[ぁ-ん]+|[ァ-ヴ]+/u';
	$pattern_ru ='/[А-я]+/u';
	$pattern_kr ='/[갂-줎]+|[줐-쥯]+|[쥱-짛]+|[짞-쪧]+|[쪨-쬊]+|[쬋-쭬]+|[쵡-힝]+/u';
	$pattern_th ='/[ก-๛]+/u';
	$pattern_ar ='/[؟-ض]+|[ط-ل]+|[م-م]+/u';
	if(bymt_c('lang_en')){
		if(!preg_match($pattern_en, $content)) {
			_Err(__('请写点汉字吧！ Please write some Chinese！'));
		}
	}
	if(bymt_c('lang_ja')){
		if(preg_match($pattern_ja, $content)) {
			_Err(__('日文滚粗！Japanese Get out！日本語出て行け！'));
		}
	}
	if(bymt_c('lang_ru')){
		if(preg_match($pattern_ru, $content)) {
			_Err(__('战斗民族伤不起！Russians, get away！Savage выйти из Русского Севера!'));
		}
	}
	if(bymt_c('lang_kr')){
		if(preg_match($pattern_kr, $content)) {
			_Err(__('不要用韩语思密达！Please do not use Korean！하시기 바랍니다 한국 / 한국어 사용하지 마십시오！'));
		}
	}
	if(bymt_c('lang_th')){
		if(preg_match($pattern_th, $content)) {
			_Err(__('人妖你好，人妖再见！Please do not use Thai！กรุณาอย่าใช้ภาษาไทย！'));
		}
	}
	if(bymt_c('lang_ar')){
		if(preg_match($pattern_ar, $content)) {
			_Err(__('不要用阿拉伯语！Please do not use Arabic！！من فضلك لا تستخدم اللغة العربية'));
		}
	}
	return $comment;
}
add_filter('preprocess_comment', 'bymt_comment_post');
}

//不解析评论html代码
if(bymt_c('code_filter')){
function bymt_comment_code_filter($comment) {
    $comment = htmlspecialchars($comment,ENT_QUOTES);
    return $comment;
}
add_filter( 'comment_text','bymt_comment_code_filter');
add_filter( 'comment_text_rss','bymt_comment_code_filter');
}

//去除评论url超链接
if(bymt_c('com_href')){
function remove_comment_links() {
	global $comment;
	$url = get_comment_author_url();
	$author = get_comment_author();
	if ( empty( $url ) || 'http://' == $url )
		$return = $author;
	else
		$return = $author;
return $return;
}
add_filter('get_comment_author_link', 'remove_comment_links');
remove_filter('comment_text', 'make_clickable', 9);
}

//评论内容链接添加 target="_blank"
function find_stripos($matches){
	$num = stripos($matches[2],'#');
	if(!is_numeric($num)||$num>0){
		return "<a$matches[1]href=\"$matches[2]\"$matches[3] target=\"_blank\">$matches[4]</a>";
	}else{
		return "<a$matches[1]href=\"$matches[2]\"$matches[3] class=\"iatu\">$matches[4]</a>";
	}
}
function bymt_popuplinks($text) {
	$text = preg_replace_callback('/<a(.*?)href=\"(.*?)\"(.*?)>(.*?)<\/a>/i', "find_stripos", $text);
	return $text;
}
add_filter( 'comment_text', 'bymt_popuplinks' );

//评论回复链接添加 external nofollow
function add_nofollow_to_reply_link( $link ) {
    return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'add_nofollow_to_reply_link' );

//评论跳转链接添加nofollow
function bymt_nofollow_compopup_link() {
  return' rel="nofollow"';
}
add_filter('comments_popup_link_attributes','bymt_nofollow_compopup_link');

//获取邮箱头像
function bymt_ajax_avatar(){
	if( isset( $_POST['action'] ) && $_POST['action']== 'bymt_ajax_avatar' ){
		$user_email = ( isset($_POST['email']) )  ? trim(strip_tags($_POST['email'])) : null;
		echo bymt_avatar(sanitize_email($user_email), 42);
		die;
	}else{return;}
}
add_action('init', 'bymt_ajax_avatar');

//ajax评论
function bymt_ajax_comment(){
	if( isset( $_POST['action'] ) && $_POST['action'] == 'bymt_ajax_comment' && 'POST' == $_SERVER['REQUEST_METHOD']){
		global $wpdb;
		nocache_headers();
		$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
		$post = get_post($comment_post_ID);
		if ( empty($post->comment_status) ) {
			do_action('comment_id_not_found', $comment_post_ID);
			_Err(__('无效的评论状态')); // 將 exit 改為錯誤提示
		}
		// get_post_status() will get the parent status for attachments.
		$status = get_post_status($post);
		$status_obj = get_post_status_object($status);
		if ( !comments_open($comment_post_ID) ) {
			do_action('comment_closed', $comment_post_ID);
			_Err(__('评论已关闭!')); // 將 wp_die 改為錯誤提示
		} elseif ( 'trash' == $status ) {
			do_action('comment_on_trash', $comment_post_ID);
			_Err(__('无效的评论状态')); // 將 exit 改為錯誤提示
		} elseif ( !$status_obj->public && !$status_obj->private ) {
			do_action('comment_on_draft', $comment_post_ID);
			_Err(__('无效的评论状态')); // 將 exit 改為錯誤提示
		} elseif ( post_password_required($comment_post_ID) ) {
			do_action('comment_on_password_protected', $comment_post_ID);
			_Err(__('受密码保护请先输入密码')); // 將 exit 改為錯誤提示
		} else {
			do_action('pre_comment_on_post', $comment_post_ID);
		}
		$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
		$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
		$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
		$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
		$edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id
		// If the user is logged in
		$user = wp_get_current_user();
		if ( $user->exists() ) {
			if ( empty( $user->display_name ) )
				$user->display_name=$user->user_login;
			$comment_author       = esc_sql($user->display_name);
			$comment_author_email = esc_sql($user->user_email);
			$comment_author_url   = esc_sql($user->user_url);
			if ( current_user_can('unfiltered_html') ) {
				if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
					kses_remove_filters(); // start with a clean slate
					kses_init_filters(); // set up the filters
				}
			}
		} else {
			if ( get_option('comment_registration') || 'private' == $status )
				_Err(__('您必须先登陆才可以发表评论')); // 將 wp_die 改為錯誤提示
		}
		$comment_type = '';
		if ( get_option('require_name_email') && !$user->exists() ) {
			if ( 6 > strlen($comment_author_email) || '' == $comment_author )
				_Err( __('请填写昵称和邮箱')); // 將 wp_die 改為錯誤提示
			elseif ( !is_email($comment_author_email))
				_Err(__('请填写一个有效的邮箱')); // 將 wp_die 改為錯誤提示
		}
		if ( '' == $comment_content )
			_Err(__('请输入评论内容')); // 將 wp_die 改為錯誤提示
		// 增加: 檢查重覆評論功能
		$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
		if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
		$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
		if ( $wpdb->get_var($dupe) ) {
			_Err(__('您已经发布过一条相同的评论！'));
		}
		// 增加: 檢查評論太快功能
		if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) {
		$time_lastcomment = mysql2date('U', $lasttime, false);
		$time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
		$flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
		if ( $flood_die ) {
			_Err(__('请过一会再发表评论'));
			}
		}
		$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
		$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
		// 增加: 檢查評論是否正被編輯, 更新或新建評論
		if ( $edit_id ){
			// 判断当前用户是否具有编辑该评论权限
			if(current_user_can("edit_comment",$edit_id)){
				// 判断当前用户的邮箱是否与评论邮箱相同
				if($current_user->user_email==$comment_author_email){
					$comment_id = $commentdata['comment_ID'] = $edit_id;
					wp_update_comment( $commentdata );
				}else{
					_Err(__('您不能修改为他人评论！'));
				}
			}else{
				_Err(__('您没有权限编辑该评论！'));
			}
		} else {
			$comment_id = wp_new_comment( $commentdata );
		}
		$comment = get_comment($comment_id);
		do_action('set_comment_cookies', $comment, $user);
		$comment_depth = 1;   //为评论的 class 属性准备的
		$tmp_c = $comment;
		while($tmp_c->comment_parent != 0){
			$comment_depth++;
			$tmp_c = get_comment($tmp_c->comment_parent);
		}
		//此处非常必要，无此处下面的评论无法输出 by mufeng
		$GLOBALS['comment'] = $comment;
		global $depth;
		//以下是評論式樣, 不含 "回覆". 要用你模板的式樣 copy 覆蓋.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>" <?php if( $depth > get_option('thread_comments_depth') && !wp_is_mobile() ){ echo ' style="margin-left:0px;"';} ?>>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<?php $add_below = 'div-comment'; ?>
			<div class="comment-author vcard gravatar"><?php echo bymt_avatar($comment->comment_author_email); ?></div>
			<div class="floor">新楼</div>
			<div class="commenttext">
				<span class="commentid"><?php comment_author_link(); ?></span>
				<?php get_author_class($comment->comment_author_email,$comment->comment_author_url); ?>
		 		<span class="datetime"><?php bymt_time_diff( $time_type = 'comment' ); ?></span>
		 		<span class="edit_comment"><?php edit_comment_link('[编辑]'); ?></span>
			<div class="comment_text">
			<?php if ( $comment->comment_approved == '0' ){?>
				<span style="color:#f00;">您的评论正在等待审核中...</span>
				<?php comment_text(); ?>
			<?php }else{ ?>
				<?php comment_text(); ?>
			<?php } ?>
			</div>
			</div>
			</div>
		<?php
		die(); //以上是評論式樣, 不含 "回覆". 要用你模板的式樣 copy 覆蓋.
	}else{return;}
}
add_action('init', 'bymt_ajax_comment');

//ajax评论翻页
function bymt_ajax_pagenavi(){ // pagenavi
	if( isset( $_GET['action'] ) && $_GET['action']== 'bymt_ajax_pagenavi' ){
		global $post,$wp_query, $wp_rewrite;
		$postid = isset($_GET['post']) ? $_GET['post'] : null;
		$pageid = isset($_GET['page']) ? $_GET['page'] : null;
		if(!$postid || !$pageid){
			_Err(__('Error post id or comment page id.'));
		}
		// get comments
		$comments = get_comments('post_id='.$postid);
		$post = get_post($postid);
		if(!$comments){
			_Err(__('Error! can\'t find the comments'));
		}
		if( 'desc' != get_option('comment_order') ){
			$comments = array_reverse($comments);
		}
		// set as singular (is_single || is_page || is_attachment)
		$wp_query->is_singular = true;
		// base url of page links
		$baseLink = '';
		if ($wp_rewrite->using_permalinks()) {
			$baseLink = '&base=' . user_trailingslashit(get_permalink($postid) . 'comment-page-%#%', 'commentpaged');
		}
		echo '<ol class="commentlist">';
		wp_list_comments('type=comment&callback=bymt_comment&page=' . $pageid . '&per_page=' . get_option('comments_per_page'), $comments);
		echo '</ol><div class="pagination">';
		paginate_comments_links('prev_text=上页&next_text=下页&current=' . $pageid);
		echo '</div>';
		die;
	}else{return;}
}
add_action('init', 'bymt_ajax_pagenavi');

// 增加: 错误提示功能
function _Err($a) {
    echo 'Error!!!' . $a;
    exit;
}
