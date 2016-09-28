<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.4
 */

class bymt_widget0 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '本主题自带的最新文章、热评文章、随机文章小工具');
        parent::__construct('bymt-widget0', 'BYMT-新热随文章', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
		global $wpdb;
		$newtitle = strip_tags($instance['newtitle']);
		$hottitle = strip_tags($instance['hottitle']);
		$randtitle = strip_tags($instance['randtitle']);
		$num = strip_tags($instance['num']);
		$days = strip_tags($instance['days']);
		$sticky = get_option( 'sticky_posts' );
		echo '<div class="widget" id="widget_tab">';
?>
<h2 class="tab-title"><span class="selected"><?php echo $newtitle; ?></span><span><?php echo $hottitle; ?></span><span><?php echo $randtitle; ?></span></h2>
<div class="tab-content">
        <ul><?php $posts = query_posts(array('orderby' => 'date','showposts'=>$num,'post__not_in' =>$sticky)); while(have_posts()) : the_post(); ?>
            <li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo BYMT_cut_str(get_the_title(),37); ?></a></li><?php endwhile; ?>
        </ul>
        <ul class="hide">
		<?php
			$hotsql = "SELECT ID , post_title , comment_count FROM $wpdb->posts WHERE post_type = 'post' AND TO_DAYS(now()) - TO_DAYS(post_date) < $days AND ($wpdb->posts.`post_status` = 'publish' OR $wpdb->posts.`post_status` = 'inherit') ORDER BY comment_count DESC LIMIT 0 , $num ";
			$hotposts = $wpdb->get_results($hotsql);
			$hotoutput = "";
			foreach ($hotposts as $post){
			$hotoutput .= "\n<li><a href= \"".get_permalink($post->ID)."\" rel=\"bookmark\" title=\"".$post->post_title." (".$post->comment_count."条评论)\" >". mb_strimwidth($post->post_title,0,36,"...",'utf-8')."</a></li>";
			}
			echo $hotoutput;
		 ?>
	</ul>
		<ul class="hide"><?php $posts = query_posts(array('orderby' => 'rand','showposts'=>$num,'post__not_in' =>$sticky)); while(have_posts()) : the_post(); ?>
            <li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo BYMT_cut_str(get_the_title(),37); ?></a></li><?php endwhile; ?>
        </ul>
    </div>
<?php
		echo '</div>';
    }
    public function update($new_instance, $old_instance) {
         if (!isset($new_instance['submit'])) {
             return false;
         }
         $instance = $old_instance;
         $instance['newtitle'] = strip_tags($new_instance['newtitle']);
		 $instance['hottitle'] = strip_tags($new_instance['hottitle']);
		 $instance['randtitle'] = strip_tags($new_instance['randtitle']);
		 $instance['num'] = strip_tags($new_instance['num']);
		 $instance['days'] = strip_tags($new_instance['days']);
         return $instance;
     }
    public function form($instance) {
        global $wpdb;
		$instance = wp_parse_args((array) $instance, array('newtitle' => '最新文章','hottitle' => '热门文章','randtitle' => '手气不错','num' => '10','days' => '30'));
        $newtitle = strip_tags($instance['newtitle']);
		$hottitle = strip_tags($instance['hottitle']);
		$randtitle = strip_tags($instance['randtitle']);
		$num = strip_tags($instance['num']);
		$days = strip_tags($instance['days']);
?>
 <p><label for="<?php echo $this->get_field_id('newtitle'); ?>">最新文章标题：<input class="widefat" id="<?php echo $this->get_field_id('newtitle'); ?>" name="<?php echo $this->get_field_name('newtitle'); ?>" type="text" value="<?php echo $newtitle; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('hottitle'); ?>">热门文章标题：<input class="widefat" id="<?php echo $this->get_field_id('hottitle'); ?>" name="<?php echo $this->get_field_name('hottitle'); ?>" type="text" value="<?php echo $hottitle; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('randtitle'); ?>">随机文章标题：<input class="widefat" id="<?php echo $this->get_field_id('randtitle'); ?>" name="<?php echo $this->get_field_name('randtitle'); ?>" type="text" value="<?php echo $randtitle; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('num'); ?>">显示数量：<input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('days'); ?>">热门文章控制天数：<input class="widefat" id="<?php echo $this->get_field_id('days'); ?>" name="<?php echo $this->get_field_name('days'); ?>" type="text" value="<?php echo $days; ?>" /></label></p>
         <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'bymt_widget0_init');
function bymt_widget0_init() {
    register_widget('bymt_widget0');
}

//////////////////////////////////////////////////////////

	class bymt_widget1 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '本主题自带的最新评论小工具');
        parent::__construct('bymt-widget1', 'BYMT-最新评论', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
		global $wpdb;
        $rcnum = strip_tags($instance['rcnum']);
		$rctitle = strip_tags($instance['rctitle']);
        echo '<div class="widget" id="widget_rcomments">';
?>
	<h2><?php echo $rctitle; ?></h2>
	<div class="rcomments-content">
	<ul>
	<?php
	$limit_num = $rcnum; //这里定义显示的评论数量
	$my_email = "'" . get_bloginfo ('admin_email') . "'"; //这里是自动检测博主的邮件，实现博主的评论不显示
	$rc_comms = $wpdb->get_results("
	 SELECT ID, post_title, comment_ID, comment_author, comment_author_email, comment_content
	 FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
	 ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
	 WHERE comment_approved = '1'
	 AND comment_type = ''
	 AND post_password = ''
	 AND comment_author_email != $my_email
	 ORDER BY comment_date_gmt
	 DESC LIMIT $limit_num
	 ");
	$rc_comments = '';
	foreach ($rc_comms as $rc_comm) {
	if(bymt_option('avatar_cache') ){
	$p = 'avatar/';
	  $f = md5(strtolower($rc_comm->comment_author_email));
	  $a = $p . $f .'.jpg';
	  $e = ABSPATH . $a;
	  if (!is_file($e)){ //当头像不存在就更新
	  $d = is_file(get_bloginfo('template_directory'). '/avatar/avatar.jpg'); //当文件不存在就更新
	  $s = '36'; //头像大小 自行根据自己模板设置
	  $t = 1209600;  //设定14天过期, 单位:秒
	  $r = get_option('avatar_rating');
	  $g = 'http://www.gravatar.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r;
	  $avatarContent = file_get_contents($g);
	  file_put_contents($e, $avatarContent);
	  if ( filesize($e) == 0 || !is_file($e) || (time() - filemtime($e)) > $t ){ copy($d, $e); }
	  };
	$rcavatar = '<img src="'. get_option('home') .'/'. $a .'" alt="avatar" class="avatar" width="16px" height="16px"/>';
	} else {
	$rcavatar =get_avatar($rc_comm->comment_author_email, 16);
	}
	$rc_comments .= "<li>". $rcavatar . "<span>" . $rc_comm->comment_author . ": </span><a href='". get_permalink($rc_comm->ID) . "#comment-" . $rc_comm->comment_ID
	. "' title='查看《" . $rc_comm->post_title . "》上的评论'>" . preg_replace( "/\[private\].+\[\/private\]/", "(ÒܫÓױ)",strip_tags($rc_comm->comment_content))
	. "</a></li>\n";
	}
	$rc_comments = convert_smilies($rc_comments);
	echo '<ul id="rcslider">';
	echo $rc_comments;
	echo '</ul>';
	?>
	</ul>
	</div>
<?php
        echo '</div>';
    }

    public function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['rcnum'] = strip_tags($new_instance['rcnum']);
		$instance['rctitle'] = strip_tags($new_instance['rctitle']);
        return $instance;
    }
    public function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('rcnum' => '10','rctitle' => '最新评论'));
        $rcnum = strip_tags($instance['rcnum']);
		$rctitle = strip_tags($instance['rctitle']);
?>

        <p><label for="<?php echo $this->get_field_id('rcnum'); ?>">显示数量：<input id="<?php echo $this->get_field_id('rcnum'); ?>" name="<?php echo $this->get_field_name('rcnum'); ?>" type="text" value="<?php echo $rcnum; ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('rctitle'); ?>">自定义标题：<input id="<?php echo $this->get_field_id('rctitle'); ?>" name="<?php echo $this->get_field_name('rctitle'); ?>" type="text" value="<?php echo $rctitle; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'bymt_widget1_init');
function bymt_widget1_init() {
    register_widget('bymt_widget1');
}

//////////////////////////////////////////////////////////
class bymt_widget2 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '本主题自带的评论排行榜小工具');
        parent::__construct('bymt-widget2', 'BYMT-评论排行榜', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
		global $wpdb;
        $tcnum = strip_tags($instance['tcnum']);
		$tctitle = strip_tags($instance['tctitle']);
        echo '<div class="widget" id="widget_tcomments">';
?>
<h2><?php echo $tctitle; ?></h2>
<ul>
<?php
$my_email = "'" . get_bloginfo ('admin_email') . "'"; //获取管理员邮箱
$counts = $wpdb->get_results("SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 12 MONTH ) AND user_id='0' AND comment_author_email != $my_email AND comment_author != 'admin' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email
ORDER BY cnt DESC LIMIT $tcnum");
$mostactive = '';
foreach ($counts as $count) {
    if (bymt_option('avatar_cache')){
        $p = 'avatar/';
        $f = md5(strtolower($count->comment_author_email));
        $a = $p . $f .'.jpg';
        $e = ABSPATH . $a;
        if (!is_file($e)){ //当头像不存在就更新
            $d = is_file(get_bloginfo('template_directory'). '/avatar/avatar.jpg'); //当文件不存在就更新
            $s = '38'; //头像大小 自行根据自己模板设置
            $t = 1209600;  //设定14天过期, 单位:秒
            $r = get_option('avatar_rating');
            $g = 'http://www.gravatar.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r;
            $avatarContent = file_get_contents($g);
            file_put_contents($e, $avatarContent);
            if ( filesize($e) == 0 || !is_file($e) || (time() - filemtime($e)) > $t ){
                copy($d, $e);
            }
        };
        $tavatar = '<img src="'. get_option('home') .'/'. $a .'" alt="avatar" class="avatar" width="38px" height="38px"/>';
    } else {
        $tavatar =get_avatar($count->comment_author_email, 38);
    }
    $c_url = $count->comment_author_url;
    $mostactive .= '<li>' . '<a href="'. $c_url . '" title="' . $count->comment_author . ' (赐教'. $count->cnt . '次)" rel="external nofollow">' . $tavatar . '</a></li>';
}
echo $mostactive;
?>
</ul>
<?php
        echo '</div>';
    }

    public function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['tcnum'] = strip_tags($new_instance['tcnum']);
		$instance['tctitle'] = strip_tags($new_instance['tctitle']);
        return $instance;
    }
    public function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('tcnum' => '15','tctitle' => '大神排行榜'));
        $tcnum = strip_tags($instance['tcnum']);
		$tctitle = strip_tags($instance['tctitle']);
?>

        <p><label for="<?php echo $this->get_field_id('tcnum'); ?>">显示数量：<input id="<?php echo $this->get_field_id('tcnum'); ?>" name="<?php echo $this->get_field_name('tcnum'); ?>" type="text" value="<?php echo $tcnum; ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('tctitle'); ?>">自定义标题：<input id="<?php echo $this->get_field_id('tctitle'); ?>" name="<?php echo $this->get_field_name('tctitle'); ?>" type="text" value="<?php echo $tctitle; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'bymt_widget2_init');
function bymt_widget2_init() {
    register_widget('bymt_widget2');
}

//////////////////////////////////////////////////////////
class bymt_widget3 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '本主题自带的站点统计小工具');
        parent::__construct('bymt-widget3', 'BYMT-站点统计', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
		global $wpdb;
        $builddate = strip_tags($instance['builddate']);
		$sttitle = strip_tags($instance['sttitle']);
        echo '<div class="widget" id="widget_statistics">';
?>
<h2><?php echo $sttitle; ?></h2>
    <ul>
    <li>文章总数：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?> 篇</li>
    <li>评论总数：<?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments where comment_author!='".(get_option('MT_user'))."'");?> 篇</li>
    <li>标签数量：<?php echo $count_tags = wp_count_terms('post_tag'); ?> 个</li>
    <li>链接总数：<?php $link = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'"); echo $link; ?> 个</li>
    <li>建站日期：<?php echo $builddate; ?></li>
    <li>运行天数：<?php echo floor((time()-strtotime($builddate))/86400); ?> 天</li>
    <li>最后更新：<?php $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-m-d', strtotime($last[0]->MAX_m));echo $last; ?></li>
    </ul>
<?php
        echo '</div>';
    }

    public function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['builddate'] = strip_tags($new_instance['builddate']);
		$instance['sttitle'] = strip_tags($new_instance['sttitle']);
        return $instance;
    }
    public function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('builddate' => '2013-01-01','sttitle' => '站点统计'));
        $builddate = strip_tags($instance['builddate']);
		$sttitle = strip_tags($instance['sttitle']);
?>

        <p><label for="<?php echo $this->get_field_id('builddate'); ?>">建站日期：<input id="<?php echo $this->get_field_id('builddate'); ?>" name="<?php echo $this->get_field_name('builddate'); ?>" type="date" value="<?php echo $builddate; ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('sttitle'); ?>">自定义标题：<input id="<?php echo $this->get_field_id('sttitle'); ?>" name="<?php echo $this->get_field_name('sttitle'); ?>" type="text" value="<?php echo $sttitle; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'bymt_widget3_init');
function bymt_widget3_init() {
    register_widget('bymt_widget3');
}

//////////////////////////////////////////////////////////
class bymt_widget4 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '主题自带的用户登录小工具');
        parent::__construct('bymt-widget4', 'BYMT-用户登录', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
?>
<div class="widget" id="widget_user">
<?php
    global $user_ID, $user_identity, $user_email, $user_login;
    wp_get_current_user();
    if (!$user_ID) {
?>
<h2>用户登录</h2>
<form id="loginform" action="<?php echo get_settings('siteurl'); ?>/wp-login.php" method="post">
<p><label>用户名：<input class="login" type="text" name="log" id="log" value="" size="12" /></label></p>
<p><label>密　码：<input class="login" type="password" name="pwd" id="pwd" value="" size="12" /></label></p>
<p><input class="denglu" type="submit" name="submit" value="登陆" /> <label>记住我 <input id="comment_mail_notify" type="checkbox" name="rememberme" value="forever" /></label></p>
<p><input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/></p>
</form>
<?php } else { ?>
<h2>用户管理</h2>
<p>
<div class="v_avatar">
<?php
if(bymt_option('avatar_cache') ){
$p = 'avatar/';
$f = md5(strtolower($user_email));
$a = $p . $f .'.jpg';
$e = ABSPATH . $a;
if (!is_file($e)){ //当头像不存在就更新
$d = is_file(get_bloginfo('template_directory'). '/avatar/avatar.jpg'); //当文件不存在就更新
$s = '64'; //头像大小 自行根据自己模板设置
$t = 1209600;  //设定14天过期, 单位:秒
$r = get_option('avatar_rating');
$g = 'http://www.gravatar.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r;
$avatarContent = file_get_contents($g);
file_put_contents($e, $avatarContent);
if ( filesize($e) == 0 || !is_file($e) || (time() - filemtime($e)) > $t ){
    copy($d, $e);
}
};
echo '<img src="'. get_option('home') .'/'. $a .'" alt="avatar" class="avatar" width="64px" height="64px"/>';
} else {
echo get_avatar($user_email, 64);
} ?>
</div>
<div class="v_li">
    <li><a href="<?php bloginfo('url') ?>/wp-admin/post-new.php">撰写文章</a></li>
    <li><a href="<?php bloginfo('url') ?>/wp-admin/edit-comments.php">评论管理</a></li>
    <li><a href="<?php bloginfo('url') ?>/wp-admin/">控制面板</a></li>
    <li><a href="<?php bloginfo('url') ?>/wp-login.php?action=logout&amp;redirect_to=<?php echo urlencode($_SERVER['REQUEST_URI']) ?>">注销登陆</a></li>
</div>
</p>
<?php } ?>
</div>
<?php
    }
    public function form($instance) {
        global $wpdb;
?>
    <p>此工具无需设置</p>
<?php
    }
}
add_action('widgets_init', 'bymt_widget4_init');
function bymt_widget4_init() {
    register_widget('bymt_widget4');
}

//////////////////////////////////////////////////////////
class bymt_widget5 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '主题自带的侧边栏广告小工具 尺寸250*250');
        parent::__construct('bymt-widget5', 'BYMT-侧边栏广告一', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
?>
<?php if(bymt_option('sidebarad250')): ?>
<div class="widget" id="widget_ada">
<div id="adsense5"><div id="adsense-loader5">
<div class="loadad">
<span style="position:absolute"><?php echo bymt_option('sidebarad250code'); ?></span>
<span><img src="<?php bloginfo('template_directory');?>/images/mengmengdeguanggao.jpg" width="250" height="250" alt="广告很萌的" /></span>
</div>
</div></div>
</div>
<?php endif; ?>
<?php
    }

    public function form($instance) {
        global $wpdb;
?>
     <p>请在主题设置 &raquo; 广告设置 中进行设置</p>
<?php
    }
}
add_action('widgets_init', 'bymt_widget5_init');
function bymt_widget5_init() {
    register_widget('bymt_widget5');
}

//////////////////////////////////////////////////////////
class bymt_widget6 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '主题自带的侧边栏广告小工具 尺寸120*90*2');
        parent::__construct('bymt-widget6', 'BYMT-侧边栏广告二', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
?>
<?php if(bymt_option('sidebarad120')): ?>
<div class="widget" id="loadad_12090ad">
<div id="adsense6"><div id="adsense-loader6">
<div class="loadad_12090ad">
<ul>
<li style="float:left;">
<?php echo bymt_option('sidebarad120code1'); ?>
</li>
<li style="float:right;">
<?php echo bymt_option('sidebarad120code2'); ?>
</li>
</ul>
</div>
</div></div>
</div>
<?php endif; ?>
<?php
    }

    public function form($instance) {
        global $wpdb;
?>
     <p>请在主题设置 &raquo; 广告设置 中进行设置</p>
<?php
    }
}
add_action('widgets_init', 'bymt_widget6_init');
function bymt_widget6_init() {
    register_widget('bymt_widget6');
}

//////////////////////////////////////////////////////////
class bymt_widget7 extends WP_Widget {
    public function __construct() {
        $widget_ops = array('description' => '主题自带的侧边栏广告小工具 尺寸250*60');
        parent::__construct('bymt-widget7', 'BYMT-侧边栏广告三', $widget_ops);
    }
    public function widget($args, $instance) {
        extract($args);
?>
<?php if(bymt_option('sidebarad25060')): ?>
<div class="widget" id="widget_25060ad">
<div id="adsense7"><div id="adsense-loader7">
<div class="loadad">
<?php echo bymt_option('sidebarad25060code'); ?>
</div>
</div></div>
</div>
<?php endif; ?>
<?php
    }

    public function form($instance) {
        global $wpdb;
?>
     <p>请在主题设置 &raquo; 广告设置 中进行设置</p>
<?php
    }
}
add_action('widgets_init', 'bymt_widget7_init');
function bymt_widget7_init() {
    register_widget('bymt_widget7');
}
?>
