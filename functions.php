<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

define('TPLDIR', get_bloginfo('template_directory'));

define('THEMEVER', '2.1.2');

define('THEMEUPDATE', '2016-09-29');

//引入文件
require_once('aq_resizer.php');

get_template_part('functions/bymt-shortcode');
get_template_part('functions/bymt-vote');
get_template_part('functions/bymt-widget');
if( is_admin() ) {
	get_template_part('functions/bymt-setting');
}else{
	get_template_part('functions/bymt-head');
	get_template_part('functions/bymt-comment');
}

//加载js
function bymt_enqueue_scripts() {
	if( !is_admin() ) {
		if(wp_is_mobile()){
			wp_enqueue_script('mobile', TPLDIR . '/js/mobile.js', array(), THEMEVER, true);
			if (is_singular()){
				global $post; $postid = $post->ID; $ajaxurl = home_url("/");
				wp_localize_script( 'mobile', 'bymt', array( "postid" => $postid, "ajaxurl" => $ajaxurl ));
			}else{
				wp_localize_script( 'mobile', 'bymt', array( "postid" => '', "ajaxurl" => '' ));
			}
		}else{
			wp_enqueue_script( 'global', TPLDIR . '/js/global.js', array(), THEMEVER, true);
			if(bymt_c('lazyload')){
				wp_enqueue_script('lazyload', TPLDIR . '/js/lazyload.js', array(), THEMEVER, true);
			}
			if (is_singular()){
				wp_enqueue_script('comments', TPLDIR . '/js/comments.js', array(), THEMEVER, true);
			}
			if(bymt_c('ajax_ggdc')&&bymt_c('ggid')){
				wp_enqueue_script('commvote', TPLDIR . '/js/commvote.js', array(), THEMEVER, true);
			}
			if(bymt_c('lightbox_ck') && is_singular()){
				wp_enqueue_script('lightbox', TPLDIR . '/js/lightbox.js', array(), THEMEVER, true);
			}
			if(bymt_c('wpshare')){
				wp_enqueue_script('wpshare', TPLDIR . '/js/wpshare.js', array(), THEMEVER, true);
			}

		}
		if(bymt_c('highlight')){
			if (is_singular()){
				wp_enqueue_style('highlight', TPLDIR . '/css/highlight.css', array(), THEMEVER, 'all');
				wp_enqueue_script('highlight', TPLDIR . '/js/highlight.pack.js',array(), THEMEVER, true);
			}
		}
		if (bymt_c('sd_config_top_ck')||bymt_c('sd_config_nav_ck')||bymt_c('sd_config_bul_ck')||bymt_c('sd_config_lis_ck')||bymt_c('sd_config_sid_ck')){
			wp_enqueue_script( 'superslide', TPLDIR . '/js/superslide.min.js', array(), THEMEVER, true);
		}
		if (is_category('picturewall')){
			wp_enqueue_script( 'wookmark', TPLDIR . '/js/wookmark.js', array(), THEMEVER, true);
			wp_enqueue_script( 'imagesloaded', TPLDIR . '/js/imagesloaded.js', array(), THEMEVER, true);
			wp_enqueue_script( 'picturewall', TPLDIR . '/js/picturewall.js', array(), THEMEVER, true);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'bymt_enqueue_scripts' );

//核心函数
function bymt_c($name){
    $bymt_c = get_option('bymt_options_v2');
	if(!$name) return false;
	if(!isset($bymt_c[$name])) return false;
	return $bymt_c[$name];
}
function bymt($name,$e=''){
    $bymt = get_option('bymt_options_v2');
	if($e=='e'){
		esc_attr_e($bymt[$name]);
	}elseif($e=='u'){
		echo esc_url($bymt[$name]);
	}elseif($e=='s'){
		echo esc_attr(strip_tags($bymt[$name]));
	}else{
		echo $bymt[$name];
	}
}
function bymt_r($name,$val,$e=''){
    $bymt_r = get_option('bymt_options_v2');
    $result = empty($bymt_r[$name]) ? '' : $bymt_r[$name];
	if($e==='e'){
		if($result===''){
			esc_attr_e($val);
		}else{
			esc_attr_e($result);
		}
	}elseif($e==='u'){
		if($result===''){
			echo esc_url($val);
		}else{
			echo esc_url($result);
		}
	}elseif($e==='s'){
		if($result===''){
			echo esc_attr(strip_tags($val));
		}else{
			echo esc_attr(strip_tags($result));
		}
	}else{
		if($result===''){
			echo $val;
		}else{
			echo $result;
		}
	}
}

//头部加载
function bymt_jquery(){
	if(bymt_c('sysjq')){
		wp_enqueue_script('jquery');
	}else{
		echo '<script type="text/javascript" src="';
		if(bymt_c('jq')=="other") {
			bymt('other_jq', 'u');
		}else{
			bymt_r('jq', TPLDIR .'/js/jquery.min.js');
		}
		echo '"></script>'."\n";
		echo '<', 'script type="text\\/javascript">window.jQuery || document.write(\'<\\script type="text/javascript" src="'. TPLDIR .'/js/jquery.min.js">\x3C/script>\')</script>'."\n";
	}
	echo "<!--[if lt IE 9]>\n\t";
	echo "<script src=\"http://html5shiv.googlecode.com/svn/trunk/html5.js\"></script>\n\t";
	echo "<script src=\"". TPLDIR ."/js/respond.min.js\"></script>\n";
	echo "<![endif]-->\n";
}
add_action('wp_head','bymt_jquery',1);

//异域Welcome
function bymt_refurl(){
	$url=htmlspecialchars($_SERVER['HTTP_REFERER']);
	$site=htmlspecialchars($_SERVER['SERVER_NAME']);
	$temp=explode('/',$url);
	$refurl=$temp[2];
	if(empty($refurl) || $refurl == $site){
		return "有朋自远方来不亦乐乎！";
	}else{
		return '欢迎来自'.$refurl.'的盆友！';
	}
}

//焦点图
function bymt_slides_js($key){
	echo '$("#slide_'.$key.'").slide({mainCell:".bd ul"';
	if(bymt_c('sd_config_'.$key.'_effect')!="fade" && bymt_c('sd_config_'.$key.'_effect')!=""){
		echo ",effect:\"".bymt_c('sd_config_'.$key.'_effect')."\"";
	}
	if(bymt_c('sd_config_'.$key.'_trigger')!="mouseover" && bymt_c('sd_config_'.$key.'_trigger')!=""){
		echo ",trigger:\"".bymt_c('sd_config_'.$key.'_trigger')."\"";
	}
	if(bymt_c('sd_config_'.$key.'_delayTime')!="500" && bymt_c('sd_config_'.$key.'_delayTime')!=""){
		echo ",delayTime:\"".bymt_c('sd_config_'.$key.'_delayTime')."\"";
	}
	if(bymt_c('sd_config_'.$key.'_pnLoop')!="true" && bymt_c('sd_config_'.$key.'_pnLoop')!=""){
		echo ",pnLoop:\"".bymt_c('sd_config_'.$key.'_pnLoop')."\"";
	}
	if(bymt_c('sd_config_'.$key.'_easing')!="swing" && bymt_c('sd_config_'.$key.'_easing')!=""){
		echo ",easing:\"".bymt_c('sd_config_'.$key.'_easing')."\"";
	}
	if(bymt_c('sd_config_'.$key.'_autoPlay')!="true" && bymt_c('sd_config_'.$key.'_autoPlay')!=""){
		echo ",autoPlay:\"".bymt_c('sd_config_'.$key.'_autoPlay')."\"";
	}
	if(bymt_c('sd_config_'.$key.'_mouseOverStop')!="true" && bymt_c('sd_config_'.$key.'_mouseOverStop')!=""){
		echo ",mouseOverStop:\"".bymt_c('sd_config_'.$key.'_mouseOverStop')."\"";
	}
	echo '});';
}
function bymt_slides($key,$width,$height){
	if(bymt_c('sd_config_'.$key.'_ck')){
		if(bymt_c('sd_imgst_'.$key.'_tar')){ $tar = ' target="_blank"'; }else{ $tar = ''; }
		if(bymt_c('sd_imgst_'.$key.'_pave')){ $pave = true; }else{ $pave = false; }
		echo '<div id="slide_'.$key.'" class="slideBox"><div class="bd"><ul>';
		if(bymt_c('sd_imgst_'.$key)=='category'){
			$cat = bymt_c('sd_imgst_'.$key.'_sel');
			$num = bymt_c('sd_imgst_'.$key.'_selnum');
			$query = new WP_Query( array( 'cat' =>$cat,'posts_per_page' =>$num) );
			if($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			echo '<li><a href="'. get_permalink() .'" title="'. get_the_title() .'"'.$tar.' rel="bookmark">'.bymt_thumbnails($width,$height,false,$pave).'</a></li>';
			endwhile; endif;
		}elseif(bymt_c('sd_imgst_'.$key)=='posts'){
			if(bymt_c('sd_imgst_'.$key.'_pos')==""){
				$pos = "";
				echo '请在 "后台>外观>主题设置>焦点图设置>图片设置" 添加指定文章';
			}else{
				foreach (bymt_c('sd_imgst_'.$key.'_pos') as $val) {
					$pos .= $val.",";
				}
			}
			$query = new WP_Query( array( 'post__in' =>explode(",",rtrim($pos,',')),'post__not_in' => get_option( 'sticky_posts' ) ) );
			if($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			echo '<li><a href="'. get_permalink() .'" title="'. get_the_title() .'"'.$tar.' rel="bookmark">'.bymt_thumbnails($width,$height,false,$pave).'</a></li>';
			endwhile; endif;
		}elseif(bymt_c('sd_imgst_'.$key)=='hand'){
			for($i=1;$i<9;$i++){
				if(bymt_c('sd_imgst_'.$key.'_hand_'.$i.'_ck')){
					echo '<li><a href="'; bymt('sd_imgst_'.$key.'_hand_'.$i.'_href', 'u');
					echo '" title="'; bymt('sd_imgst_'.$key.'_hand_'.$i.'_alt', 's');
					if($pave){
						echo '"'.$tar.' rel="bookmark"><img src="'; bymt('sd_imgst_'.$key.'_hand_'.$i.'_src', 'u');
						echo '" width="'.$width.'" height="'.$height.'" alt="'; bymt('sd_imgst_'.$key.'_hand_'.$i.'_alt', 's');
					}else{
						echo '"'.$tar.' rel="bookmark"><img src="'; bymt('sd_imgst_'.$key.'_hand_'.$i.'_src', 'u');
						echo '" alt="'; bymt('sd_imgst_'.$key.'_hand_'.$i.'_alt', 's');
					}
					echo '" /></a></li>';
				}
			}
		}else{
			echo '请在 "后台>外观>主题设置>焦点图设置>图片设置" 选择获取类型';
		}
		echo '</ul></div><a class="prev" href="javascript:;"></a><a class="next" href="javascript:;"></a></div>';
	}else{
		echo '请在 "后台>外观>主题设置>焦点图设置>参数设置" 勾选当前位置';
	}
}

//焦点图配置
function bymt_script_slides() {
	if (bymt_c('sd_config_top_ck')||bymt_c('sd_config_nav_ck')||bymt_c('sd_config_bul_ck')||bymt_c('sd_config_lis_ck')||bymt_c('sd_config_sid_ck')){
	  echo '<', 'script type="text/javascript">jQuery(document).ready(function($) {';
	  if(bymt_c('sd_config_top_ck')&&bymt_c('custom_topblock')=='1'){
		  bymt_slides_js('top');
	  }
	  if(bymt_c('sd_config_nav_ck')){
		  echo "\n\t\t";
		  bymt_slides_js('nav');
	  }
	  if(bymt_c('sd_config_bul_ck')){
		  echo "\n\t\t";
		  bymt_slides_js('bul');
	  }
	  if(bymt_c('sd_config_lis_ck')){
		  echo "\n\t\t";
		  bymt_slides_js('lis');
	  }
	  if(bymt_c('sd_config_sid_ck')){
		  echo "\n\t\t";
		  bymt_slides_js('sid');
	  }
	  echo '})</script>';
	}
}
add_action('wp_footer', 'bymt_script_slides',99);

//面包屑导航
function bymt_breadcrunbs() {
	$home = '<i class="icon-home"></i> 当前位置 &raquo; <a href="'.esc_url(home_url('/')).'">首页</a>';
	$limit = ' &raquo; ';
	if (is_home()) {
		echo '<i class="icon-home"></i> 当前位置 &raquo; 首页';
	}else{
		echo $home;
		if (is_category()) {
			echo $limit.'分类'.$limit;
			echo single_cat_title();
		}elseif (is_tag()) {
			echo $limit.'标签'.$limit;
			echo single_tag_title();
		}elseif (is_search()) {
			echo $limit.'搜索'.$limit.wp_trim_words(get_search_query(),40);
		}elseif (is_404()) {
			echo $limit.'404 Not Found';
		}elseif (is_archive()) {
			echo $limit.'归档'.$limit;
			if ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo $userdata->display_name.'发表的文章';
			}else{
				echo wp_title('').' 的文章';
			}
		}elseif (is_single()||is_page()) {
			global $post;
			the_post();
			echo $limit;
			if($category=get_the_category($post->ID)) {
				echo get_category_parents($category[0]->term_id, TRUE, $limit);
			}
			echo wp_trim_words(the_title(),40);
			rewind_posts();
		}
	}
}

//公告栏
function bymt_bulletin(){
	echo '<i class="icon-sound"></i> ';
	if(bymt_c('ggid')){
		$page_ID = bymt_c('ggid');
		$announcement = '';
		$comments = get_comments("number=1&post_id=$page_ID");
		if(!empty($comments)) {
			foreach ($comments as $comment) {
				$id = $comment->comment_ID;
				if(current_user_can('level_10')){ echo '<a href="' . get_page_link($page_ID) . '#respond" class="anno" rel="nofollow">(发表)</a> ' ; }
				echo '<span class="comment_text">'. convert_smilies($comment->comment_content) . '</span><span class="datetime" id="comm-'. $id .'"> (' . get_comment_date('m-d H:i',$comment->comment_ID) . ')</span>';
				if(bymt_c('ajax_ggdc') && !wp_is_mobile()){ echo ' <span class="vote_up icon-up-1" id="up_'. $id .'" title="'; bymt_r('ajax_gg_d_t','把持不住','s'); echo '">'.get_comm_vote($id,'up').'</span> <span class="vote_down icon-down-1" id="down_'. $id .'" title="'; bymt_r('ajax_gg_c_t','智商拙计','s'); echo '">'.get_comm_vote($id,'down').'</span> <span class="vote_ok"></span>'; }
			}
		}else{
			echo '欢迎光临'.esc_attr(get_bloginfo('name')).'！';
		}
	}else{
		bymt_r('noticecontent','欢迎光临'.esc_attr(get_bloginfo('name')).'！');
	}
}

//判断
function bymt_innerbymts(){
	echo 'data-bymts="theme-bymt';
	if(bymt_c('mousett')){
		echo ' mouse-title';
	}
	if((is_home() || is_category()) && bymt_c('ajax_posts_list')){
		echo " ajax-posts";
	}
	if(is_singular() && bymt_c('ajax_comm_list')){
		echo " ajax-comment";
	}
	if(bymt_c('ajax_search')){
		echo " ajax-search";
	}
	if(bymt_c('highlight')){
		echo " highlight";
	}
	echo '"';
}

//自定义默认头像
function bymt_addgravatar( $avatar_defaults ) {
$myavatar = TPLDIR . '/images/avatar.jpg';
  $avatar_defaults[$myavatar] = 'BYMT头像';
  return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'bymt_addgravatar' );

//avatar目录不存在就创建
if ( @!is_dir( ABSPATH . 'avatar/' ) ) {
	@mkdir( ABSPATH . 'avatar/', 0777) ;
}

//判断是否为新文章(1天内)
function is_new_post() {
    global $post;
    $post_time = strtotime($post->post_date);
    $time = time();
    $diff = ($time - $post_time) / 86400;
    if ($diff < 1) {
        return true;
    } else {
        return false;
    }
}

//首页不显示图片墙文章
if(!bymt_c('cat_picwall') && get_category_by_slug('picturewall')){
function bymt_excludecat($query) {
	$picwall_cat = get_category_by_slug('picturewall');
	$picwall_id = $picwall_cat->term_id;
	if($query->is_home){
		$query->set('cat', '-'.$picwall_id);
	}
return $query;
}
add_filter('pre_get_posts', 'bymt_excludecat');
}

//日志与评论的相对时间显示
function bymt_time_diff( $time_type ) {
    switch( $time_type ){
        case 'comment':    //如果是评论的时间
            $time_diff = current_time('timestamp') - get_comment_time('U');
			 if( $time_diff <= 60 )
			 	echo ('刚刚');
            elseif( $time_diff > 60 && $time_diff <= 86400 )    //24小时之内
                echo human_time_diff(get_comment_time('U'), current_time('timestamp')).'前';    //显示格式 OOXX 之前
			elseif( $time_diff > 86400 && $time_diff <= 604800 )    //1周之内
                echo human_time_diff(get_comment_time('U'), current_time('timestamp')).'前';
            else
                printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time());
            break;
        case 'post';    //如果是日志的时间
            $time_diff = current_time('timestamp') - get_the_time('U');
             if( $time_diff <= 60 )
			 	echo ('刚刚');
            elseif( $time_diff > 60 && $time_diff <= 86400 )
                echo human_time_diff(get_the_time('U'), current_time('timestamp')).'前';
			elseif( $time_diff > 86400 && $time_diff <= 604800 )
                echo human_time_diff(get_the_time('U'), current_time('timestamp')).'前';
            else
                the_time('Y-m-d H:i');
            break;
    }
}

//获取或生成缩略图
add_theme_support('post-thumbnails');
function bymt_thumbnails($width, $height=null, $cut=true,$pave=false,$other=null) {
  global $post;
  $title = $post->post_title;
  if ( !$width ) return false;
  if( has_post_thumbnail() ){
	  $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
	  if($cut){
		  $src = aq_resize( $thumb[0], $width, $height, true );
	  }else{
		  $src = $thumb[0];
	  }
  }elseif( get_post_meta($post->ID, 'wailianimg', true) ){
	  $src = get_post_meta($post->ID, 'wailianimg', true);
  }else{
	  ob_start();
	  ob_end_clean();
	  $output = preg_match_all('/\<img.+?src="(.+?)".*?\/>/is', $post->post_content, $matches, PREG_SET_ORDER);
	  if( count($matches) > 0 ){
		  $src = $matches [0] [1];
	  }else{
		  $src = TPLDIR .'/images/random/BYMT'.mt_rand(1, 20).'.jpg';
	  }
  }
  if($pave){
	  return "<img src=\"$src\" width=\"$width\" height=\"$height\" alt=\"$title\" $other/>";
  }else{
	  return "<img src=\"$src\" alt=\"$title\" $other/>";
  }
}

//文章图片加载失败提示
function bymt_img_error($content) {
    $pattern = "/<img(.*?)src=\"(.*?)\"/i";
	$errimg = "'". TPLDIR ."/images/images_error.jpg'";
    $replacement = '<img$1src="$2" data-original="$2" onerror="this.onerror=null;this.src='.$errimg.'"';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
add_filter('the_content', 'bymt_img_error', 100);

//代码高亮 pre标签自动转义
function bymt_esc_pre($matches){
	return  '<pre lang="'.$matches[1].'" class="'.$matches[1].'">'.esc_attr($matches[2]).'</pre>';
}
function bymt_replace_pre($content) {
	$content = preg_replace_callback('/<pre.*?lang=\"(.*?)\".*?>([\s\S]*?)<\/pre>/is', "bymt_esc_pre", $content);
    return $content;
}
if(bymt_c('esc_pre_post')){
	add_filter('the_content', 'bymt_replace_pre',10);
}
if(bymt_c('esc_pre_comm')){
	add_filter('comment_text', 'bymt_replace_pre',10);
}

//密码保护提示
function bymt_password_protect($content) {
	global $post;
	if(post_password_required( $post )) {
	$post = get_post( $post );
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
	<p class="nocomments"><label for="' . $label . '">' . esc_attr__("文章已加密，请输入密码：") . '
	<input name="post_password" id="' . $label . '" type="password" size="20" /></label> <input type="submit" name="Submit" value="' . esc_attr__("打开") . '" /></p>
	</form>
	';
	return apply_filters('the_password_form', $output);
	}else{
	return $content;
	}
}
add_filter('the_content', 'bymt_password_protect');

//短代码[reply]，回复内容可见
function bymt_reply_to_read($atts, $content=null) {
        extract(shortcode_atts(array("notice" => '<p class="reply-to-read"><strong style="color:#f00;">温馨提示：</strong> 此处内容需要您 <a href="#respond" title="评论本文">评论本文</a> 后才能查看！</p>'), $atts));
        $email = null;
        $user_ID = (int) wp_get_current_user()->ID;
        if ($user_ID > 0) {
            $email = get_userdata($user_ID)->user_email;
            //对博主直接显示内容
            $admin_email = get_bloginfo ('admin_email');
            if ($email == $admin_email) {
                return $content;
            }
        } elseif (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
            $email = str_replace('%40', '@', $_COOKIE['comment_author_email_' . COOKIEHASH]);
        } else {
            return $notice;
        }
        if (empty($email)) {
            return $notice;
        }
        global $wpdb;
        $post_id = get_the_ID();
        $query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
        if ($wpdb->get_results($query)) {
            return do_shortcode($content);
        } else {
            return $notice;
        }
    }
add_shortcode('reply', 'bymt_reply_to_read');

//短代码[login]，登录可见内容
function bymt_login_to_read($atts, $content=null) {
    extract(shortcode_atts(array("notice" => '<p class="login-to-read"><strong style="color:#f00;">温馨提示：</strong> 此处内容需要您 <a href="' . wp_login_url(get_permalink()) . '" title="登录">登录</a> 后才能查看！</p>'), $atts));
    if (is_user_logged_in()) {
        return $content;
    } else {
        return $notice;
    }
}
add_shortcode('login', 'bymt_login_to_read');

//防偷看
function private_content($atts, $content = null) {
if (current_user_can('create_users'))
  	return $content;
	return '<span class="private">@鹳狸猿</span>';
}
add_shortcode('private', 'private_content');
add_filter('comment_text', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

//标签
function bymt_tags() {
    $posttags = get_the_tags();
    if (empty($posttags)){
		echo '<a class="tag-link">未添加标签</a>';
	}else{
    foreach($posttags as $tag)
    echo '<a class="tag-link tag-link-' . $tag->term_id . '" title="查看更多关于 '. $tag->name .' 的内容" href="'.get_tag_link($tag).'" rel="tag">'. $tag->name .'</a>';
    }
}
//标签替换
if(bymt_c('tag_links')){
	add_filter('the_content','tag_link',1);
}
//按长度排序
function tag_sort($a, $b){
	if ( $a->name == $b->name ) return 0;
	return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
}
//改变标签关键字
function tag_link($content) {
$tag_maxnum = bymt_c('tag_maxnum'); //一个标签最多替换
	 $posttags = get_the_tags();
	 if ($posttags) {
		 usort($posttags, "tag_sort");
		 foreach($posttags as $tag) {
			 $link = get_tag_link($tag->term_id);
			 $keyword = $tag->name;
			 //连接代码
			 $cleankeyword = stripslashes($keyword);
			 $url = "<a href=\"$link\" title=\"".str_replace('%s',addcslashes($cleankeyword, '$'),__('View all posts in %s'))."\"";
			 $url .= ' class="tag_link"';
			 $url .= ">".addcslashes($cleankeyword, '$')."</a>";

			//不连接的代码
			$ex_word= '';
			$case = '';
             $content = preg_replace( '|(<a[^>]+>)(.*)('.$ex_word.')(.*)(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
			 $content = preg_replace( '|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
				$cleankeyword = preg_quote($cleankeyword,'\'');
					$regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
				$content = preg_replace($regEx,$url,$content,$tag_maxnum);

	$content = str_replace( '%&&&&&%', stripslashes($ex_word), $content);
		 }
	 }
    return $content;
}

//获取头像及缓存
function bymt_avatar($email, $s='50', $t='1209600') { // 默认尺寸50px 有效期14天
	if ( !is_numeric($s) ) $s = '50';
	if ( !is_numeric($t) ) $t = '1209600';
	if(bymt_c('avatar_cache') ){
		$p = ABSPATH . 'avatar/';
		$f = md5(strtolower($email));
		$e = $p . $f . '-' . $s . '.jpg';
		$a = esc_url(home_url('/avatar/')) . $f . '-' . $s . '.jpg';
		if (!is_file($e)){
			$d = is_file( TPLDIR . '/images/avatar.jpg' );
			$r = get_option('avatar_rating');
			$g = file_get_contents('http://www.gravatar.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r);
			file_put_contents($e, $g);
			if ( filesize($e) == 0 || !is_file($e) || (time() - filemtime($e)) > $t ){
				copy($d, $e);
			}
		}
		return '<img src="'.$a.'" alt="avatar" class="avatar avatar-'.$s.' photo" height="'.$s.'" width="'.$s.'" />';
	}else{
		return get_avatar( $email, $s );
	}
}

//分页功能
function bymt_pagenav($onlynext='no', $p=3) {
	if(wp_is_mobile()) $p = 2;
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;
	if ( empty( $paged ) ) $paged = 1;
	if ( $max_page == 1 || is_singular() ) {
		return;
	}elseif ( $onlynext == 'yes' ) {
		if ( $paged < $max_page ) p_link( $paged + 1,'下页', '下页', 'page_next', 'next' );
	}else{
	  echo "<div class=\"pagination\">\n";
	  if ( $paged > 1 ) p_link( $paged - 1, '上页', '上页', 'page_previous', 'prev' );
	  if ( $paged > $p + 1 ) p_link( 1, '首页', '', '', 'first' );
	  if ( $paged > $p + 2 ) echo '<span class="page-numbers">···</span>';
	  for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
	  if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
	  }
	  if ( $paged < $max_page - $p - 1 ) echo '<span class="page-numbers">···</span>';
	  if ( $paged < $max_page - $p ) p_link( $max_page, '末页', '', '', 'last' );
	  if ( $paged < $max_page ) p_link( $paged + 1,'下页', '下页', 'page_next', 'next' );
	  echo "</div>\n";
	}
}
function p_link( $i, $title = '', $linktype = '', $class='page-numbers', $rel='') {
	if ( $title == '' ) { $title = "第 $i 页"; $rel = 'next" rev="prev'; }
	if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
	echo '<a class="'.$class.'" href="'.esc_html( get_pagenum_link( $i ) ).'" title="'.$title.'" rel="'.$rel.'">'.$linktext.'</a> ';
}

//读者墙
function bymt_mostactive($limit_num,$time) {
	if(!$mostactive = get_option('mostactive_'.$limit_num)){
		global $wpdb;
		$noneurl = esc_url(home_url('/'));
		$my_email = "'" . get_bloginfo ('admin_email') . "'"; //排除管理员评论
		$counts = $wpdb->get_results("
			SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email
			FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
			ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID)
			WHERE comment_date > date_sub( NOW(), INTERVAL $time )
			AND comment_author_email != $my_email
			AND post_password=''
			AND comment_approved='1'
			AND comment_type='') AS tempcmt GROUP BY comment_author_email
			ORDER BY cnt DESC LIMIT $limit_num
		");
		$mostactive = '';
		if(empty($counts)) {
			$mostactive = '<a style="text-align: center;">暂时还没有</a>';
		} else {
			foreach ($counts as $count) {
				$c_url = $count->comment_author_url;
				if ($c_url == '') $c_url = $noneurl;
				$title_alt = $count->comment_author . ' ('. $count->cnt. ' 条评论)';
				if($limit_num=='1'){
					$mostactive = '<a href="'. $c_url . '" rel="external nofollow" title="' .$title_alt
				. '">'.$count->comment_author.'</a>';
				}else{
					$mostactive .= '<li><a href="'. $c_url . '" rel="external nofollow" title="' .$title_alt
				. '">'.bymt_avatar($count->comment_author_email,36).'<em>'.$count->comment_author.'</em><strong>+'.$count->cnt.'</strong></a></li>';
				}
			}
		}
		update_option('mostactive_'.$limit_num, $mostactive);
	}
	if($limit_num!='1') $mostactive = "<ul class=\"readers-list\">".$mostactive."</ul>";
	echo $mostactive;
}
function clear_mostactive() {
  update_option('mostactive_1', '');
  update_option('mostactive_36', ''); // 清空 mostactive
  update_option('mostactive_40', '');
}
add_action('comment_post', 'clear_mostactive'); // 新评论发生时
add_action('edit_comment', 'clear_mostactive'); // 评论被编辑过

//文章归档
class bymt_archives {
	function GetPosts() {
		global  $wpdb;
		if ( $posts = wp_cache_get( 'posts', 'bymt-clean-archives' ) )
			return $posts;
		$query="SELECT DISTINCT ID,post_date,post_date_gmt,comment_count,comment_status,post_password FROM $wpdb->posts WHERE post_type='post' AND post_status = 'publish' AND comment_status = 'open'";
		$rawposts =$wpdb->get_results( $query, OBJECT );
		foreach( $rawposts as $key => $post ) {
			$posts[ mysql2date( 'Y.m', $post->post_date ) ][] = $post;
			$rawposts[$key] = null;
		}
		$rawposts = null;
		wp_cache_set( 'posts', $posts, 'bymt-clean-archives' );
		return $posts;
	}
	function PostList( $atts = array() ) {
		global $wp_locale;
		global $bymt_clean_archives_config;
		$atts = shortcode_atts(array(
			'usejs'        => $bymt_clean_archives_config['usejs'],
			'monthorder'   => $bymt_clean_archives_config['monthorder'],
			'postorder'    => $bymt_clean_archives_config['postorder'],
			'postcount'    => '1',
			'commentcount' => '1',
		), $atts);
		$atts=array_merge(array('usejs'=>1,'monthorder'   =>'new','postorder'    =>'new'),$atts);
		$posts = $this->GetPosts();
		( 'new' == $atts['monthorder'] ) ? krsort( $posts ) : ksort( $posts );
		foreach( $posts as $key => $month ) {
			$sorter = array();
			foreach ( $month as $post )
				$sorter[] = $post->post_date_gmt;
			$sortorder = ( 'new' == $atts['postorder'] ) ? SORT_DESC : SORT_ASC;
			array_multisort( $sorter, $sortorder, $month );
			$posts[$key] = $month;
			unset($month);
		}
		$html = '<div class="arc-container';
		if ( 1 == $atts['usejs'] ) $html .= ' arc-collapse';
		$html .= '">'. "\n";
		if ( 1 == $atts['usejs'] ) $html .= '<ul class="arc-list">' . "\n";
		$firstmonth = TRUE;
		foreach( $posts as $yearmonth => $posts ) {
			list( $year, $month ) = explode( '.', $yearmonth );
			$firstpost = TRUE;
			foreach( $posts as $post ) {
				if ( TRUE == $firstpost ) {
					$html .= '	<li><h4>'. sprintf( __('%2$d %1$s '), $wp_locale->get_month($month), $year );
					$html .= "</h4>\n		<ul class='arc-monthlisting'>\n";
					$firstpost = FALSE;
                     $firstmonth = FALSE;
				}
				$html .= '			<li><span class="arc-day">' .  mysql2date( 'd', $post->post_date ) . '日</span><a href="' . get_permalink( $post->ID ) . '" title="查看该文章">' . get_the_title( $post->ID ) . '</a>';
				if ( '0' != $atts['commentcount'] && ( 0 != $post->comment_count || 'closed' != $post->comment_status ) && empty($post->post_password) )
					$html .= ' <span class="arc-com"><i class="icon-comment-1"></i> <a class="pcomm" href="' . get_permalink( $post->ID ) . '#comments" title="' . $post->comment_count . '条评论">' . $post->comment_count . '</a></span>';
				$html .= "</li>\n";
			}
			$html .= "		</ul>\n	</li>\n";
		}
		$html .= "</ul>\n</div>\n";
		return $html;
	}
	function PostCount() {
		$num_posts = wp_count_posts( 'post' );
		return number_format_i18n( $num_posts->publish );
	}
}
if(!empty($post->post_content)){
	$all_config=explode(';',$post->post_content);
	foreach($all_config as $item){
		$temp=explode('=',$item);
		$bymt_clean_archives_config[trim($temp[0])]=htmlspecialchars(strip_tags(trim($temp[1])));
	}
}else{
	$bymt_clean_archives_config=array('usejs'=>1,'monthorder'   =>'new','postorder'    =>'new');
}
$bymt_archives=new bymt_archives();

//百度喜欢
function bymt_baidulike() {
	if(bymt_c('baidulike_code')!=""){
		bymt('baidulike_code');
	}else{
		echo'<div class="bdlikebutton"></div>
		<script id="bdlike_shell"></script>
		<script>
		var bdShare_config = {
			"type":"large",
			"color":"blue",
			"uid":"590440"
		};
		document.getElementById("bdlike_shell").src="http://bdimg.share.baidu.com/static/js/like_shell.js?t=" + Math.ceil(new Date()/3600000);
		</script>';
	}
}

//文章分享
function bymt_txt_share() {
	if(bymt_c('txtshare_code')!=""){
		bymt('txtshare_code');
	}else{
	echo'<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
	<a class="bds_tsina"></a>
	<a class="bds_qzone"></a>
	<a class="bds_tqq"></a>
	<a class="bds_sqq"></a>
	<a class="bds_tieba"></a>
	<a class="bds_hi"></a>
	<a class="bds_renren"></a>
	<a class="bds_taobao"></a>
	<a class="bds_more"></a>
	<a class="shareCount"></a>
	</div>
	<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=590440" ></script>
	<script type="text/javascript" id="bdshell_js"></script>
	<script type="text/javascript">
		document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
	</script>';
	}
}

//404地址
function bymt_error_url(){
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80"){
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	}else{
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

//Feed中添加版权信息
function bymt_feed_copyright($content) {
        if(is_feed()) {
                $content.= '<div>声明: 本文采用 <a rel="external" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" title="署名-非商业性使用-相同方式共享 3.0 Unported">CC BY-NC-SA 3.0</a> 协议进行授权</div>';
                $content.= '<div>转载请注明来源：<a rel="external" title="'.get_bloginfo('name').'" href="'.get_permalink().'">'.get_bloginfo('name').'</a></div>';
                $content.= '<div>本文链接地址：<a rel="external" title="'.get_the_title().'" href="'.get_permalink().'">'.get_permalink().'</a></div>';
        }
        return $content;
}
add_filter('the_content', 'bymt_feed_copyright');

//菜单
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
				array(
				  'main-menu' => '导航菜单',
				  'wap-menu' => '手机版菜单'
				)
		);
}
function bymt_menu($type) {
	if ( wp_is_mobile() ) { $menu = 'wap-menu'; }else{ $menu = 'main-menu'; }
	echo '<div id="' . $type . '"><ul>' . str_replace ( "</ul></div>", "", preg_replace ( "/<div[^>]*><ul[^>]*>/", "", wp_nav_menu ( array (
			'theme_location' => $menu,
			'echo' => false
	) ) ) ) . '</ul></div>';
}

//小工具
if ( function_exists('register_sidebar') ){
	register_sidebar(array(
		'id' => 'bymt-sidebar-1',
		'name'=>'侧边栏一(全局)',
		'before_widget' => '<div class="widget" id="widget_default">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'id' => 'bymt-sidebar-2',
		'name'=>'侧边栏二(内页)',
		'before_widget' => '<div class="widget" id="widget_default">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'id' => 'bymt-sidebar-3',
		'name'=>'侧边栏三(非内页)',
		'before_widget' => '<div class="widget" id="widget_default">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

//头像中转多说 解决被墙问题
if(bymt_c('avatar_ds')){
function bymt_get_avatar($avatar) {
$avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"gravatar.duoshuo.com",$avatar);
return $avatar;
}
add_filter( 'get_avatar', 'bymt_get_avatar', 10, 3 );
}

//获取ip及归属地
function bymt_getIP($str){
	$Ip = false;
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$Ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$Ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($Ip){
			array_unshift($Ips, $Ip);
			$Ip = false;
		}
		for ($i = 0; $i < count($Ips); $i++){
			if(!eregi ("^(10|172\.16|192\.168)\.", $Ips[$i])){
				$Ip = $Ips[$i];
				break;
			}
		}
	}
	$Ip = $Ip ? $Ip : $_SERVER['REMOTE_ADDR'];
	$Ip = $Ip == "::1" ? "127.0.0.1" : $Ip;

	$url = 'http://ip.chinaz.com/?IP='.$Ip;
	$ch = curl_init($url);
	curl_setopt($ch,CURLOPT_ENCODING ,'utf-8');
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
	$result = curl_exec($ch);
	curl_close($ch);
	preg_match("@<strong class=\"red\">查询结果\[1\]: (.*)</strong>@iU",$result,$matchArr);
	if(!empty($matchArr)){
		$IpArr = explode(" ==>> ", $matchArr[1]);
		$Isp = $IpArr[2];
	}else{
		$Isp = "未知";
	}
	if($str=='Ip'){
		return $Ip;
	}
	if($str=='Isp'){
		return $Isp;
	}
}

//后台登录成功提醒
if(bymt_c('login_success')){
function wp_login_notify(){
	date_default_timezone_set('PRC');
	$admin_email = get_bloginfo ('admin_email');
	$to = $admin_email;
	$subject = '帐号 ' . $_POST['log'] . ' 在 ' . date("Y-m-d H:i:s") . ' 成功登录 ' . get_option("blogname");
	$message = '<p>您好！你的博客(' . get_option("blogname") . ')有登录！' . '请确定是您自己的登录，以防别人攻击！登录信息如下：</p>' . '<p>登录名：' . $_POST['log'] . '</p><p>登录时间：' . date("Y-m-d H:i:s") . '</p><p>登录IP：'. bymt_getIP('Ip') .'（'. bymt_getIP('Isp') .'）</p><p>登录地址：'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $subject, $message, $headers );
}
add_action('wp_login', 'wp_login_notify');
}

//后台登录失败提醒
if(bymt_c('login_fail')){
function wp_login_failed_notify(){
	date_default_timezone_set('PRC');
	$admin_email = get_bloginfo ('admin_email');
	$to = $admin_email;
	$subject = '您的博客 '. get_option("blogname").' 出现异常登录！异常时间：' . date("Y-m-d H:i:s") ;
	$message = '<p>您好！你的博客(' . get_option("blogname") . ')有登录错误！' . '请确定是您自己的登录失误，以防别人攻击！登录信息如下：</p>' . '<p>登录名：' . $_POST['log'] . '</p><p>' .'登录密码：' . $_POST['pwd'] . '</p><p>' .'登录时间：' . date("Y-m-d H:i:s") . '</p><p>' .'登录IP：'. bymt_getIP('Ip') .'（'. bymt_getIP('Isp') .'）</p><p>登录地址：'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $subject, $message, $headers );
}
add_action('wp_login_failed', 'wp_login_failed_notify');
}

//定义登陆界面样式
if(bymt_c('custom_login')){
function custom_login() {
	echo '
<link rel="stylesheet" type="text/css" href="'. TPLDIR .'/css/login.css" />';
}
add_action('login_head', 'custom_login');
}

//文章url自动超链接
if(bymt_c('auto_href')){
add_filter('the_content', 'make_clickable');
}

//阻止站内文章pingback
if(bymt_c('self_ping')){
function bymt_no_self_ping( &$links ) {
$home = get_option( 'home' );
foreach ( $links as $l => $link )
if ( 0 === strpos( $link, $home ) )
unset($links[$l]);
}
add_action( 'pre_ping', 'bymt_no_self_ping' );
}

//移除头部多余信息
remove_action('wp_head','wp_generator'); //禁止在head泄露wordpress版本号
remove_action('wp_head','rsd_link'); //移除head中的rel="EditURI"
remove_action('wp_head','wlwmanifest_link'); //移除head中的rel="wlwmanifest"
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 ); //rel=shortlink
if(bymt_c('remove_pn')){
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//rel='prev' rel='next'
}
if(bymt_c('remove_cnc')){
	remove_action('wp_head', 'rel_canonical' );//rel='canonical'
}
//移除wp近期评论加载样式
function remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head' , array( $wp_widget_factory -> widgets['WP_Widget_Recent_Comments'] , 'recent_comments_style' ) );
}
add_action( 'widgets_init' , 'remove_recent_comments_style' );

//禁用半角符号自动转换为全角
remove_filter('the_content', 'wptexturize');

//后台编辑器添加前台样式
add_editor_style('css/editor.css');

// 添加 RSS feed links
add_theme_support( 'automatic-feed-links' );

//增加文章形式
add_theme_support( 'post-formats', array( 'image') );

//wordpress自带编辑器增强代码
add_filter("mce_buttons_3", "bymt_enable_more_buttons");
function bymt_enable_more_buttons($buttons) {
$buttons[] = 'hr';
$buttons[] = 'sub';
$buttons[] = 'sup';
$buttons[] = 'image';
$buttons[] = 'anchor';
$buttons[] = 'cleanup';
$buttons[] = 'wp_page';
$buttons[] = 'justfyfull';
$buttons[] = 'backcolor';
$buttons[] = 'styleselect';
$buttons[] = 'fontselect';
$buttons[] = 'fontsizeselect';
return $buttons;
}
?>
