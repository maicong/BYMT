<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */

define('THEMEVER', '1.0.5');

define('THEMEUPDATE', '2016-09-29');

include_once 'includes/shortcode.php';
include_once 'includes/theme_options.php';
include_once 'includes/widget.php';


function bymt_option($key) {
    $options = get_option('bymt_options');
    return !empty($options[$key]) ? $options[$key] : '';
}

//添加nofollow在评论回复链接中
function add_nofollow_to_reply_link($link) {
    return str_replace('")\'>', '")\' rel=\'nofollow\'>', $link);
}

add_filter('comment_reply_link', 'add_nofollow_to_reply_link');

//增加文章形式
add_theme_support('post-formats', array('image'));

//防偷看
function private_content($atts, $content = null) {

    if (current_user_can('create_users')) {
        return '<div class="private-content">'.$content.'</div>';
    }

    return '<span style="background-color: #ffff00; color: #666699;">【写给管理员的情书】</span><br>';
}

add_shortcode('private', 'private_content');
add_filter('comment_text', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

//后台编辑器添加前台样式
add_editor_style('editor.css');

//后台登录成功提醒
if (bymt_option('login_success')) {
    function wp_login_notify() {
        date_default_timezone_set('PRC');
        $admin_email = get_bloginfo('admin_email');
        $to          = $admin_email;
        function getIP() {
            if (@$_SERVER['HTTP_X_FORWARDED_FOR']) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (@$_SERVER['HTTP_CLIENT_IP']) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (@$_SERVER['REMOTE_ADDR']) {
                $ip = $_SERVER['REMOTE_ADDR'];
            } elseif (@getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (@getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } elseif (@getenv('REMOTE_ADDR')) {
                $ip = getenv('REMOTE_ADDR');
            } else {
                $ip = 'Unknown';
            }

            return $ip;
        }

        $ip     = getIP();
        $iplist = list($ip1, $ip2) = split('[,]', $ip);
        function getIPLoc_QQ($ip1) {
            $url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$ip1;
            $ch  = curl_init($url);
            curl_setopt($ch, CURLOPT_ENCODING, 'gb2312');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $result = mb_convert_encoding($result, 'utf-8', 'gb2312');
            curl_close($ch);
            preg_match('@<span>(.*)</span></p>@iU', $result, $ipArray);
            $loc = $ipArray[1];
            return $loc;
        }

        $subject  = '帐号 '.$_POST['log'].' 在 '.date('Y-m-d H:i:s').' 成功登录 '.get_option('blogname');
        $message  = '<p>你好！你的博客('.get_option('blogname').')有登录！'.'请确定是您自己的登录，以防别人攻击！登录信息如下：</p>'.'<p>登录名：'.$_POST['log'].'</p><p>登录时间：'.date('Y-m-d H:i:s').'</p><p>登录IP：'.$ip1.'（'.getIPLoc_QQ($ip1).'）</p>';
        $wp_email = 'no-reply@'.preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $from     = 'From: "'.get_option('blogname')."\" <$wp_email>";
        $headers  = "$from\nContent-Type: text/html; charset=".get_option('blog_charset')."\n";
        wp_mail($to, $subject, $message, $headers);
    }

    add_action('wp_login', 'wp_login_notify');
}

//后台登录失败提醒
if (bymt_option('login_fail')) {
    function wp_login_failed_notify() {
        date_default_timezone_set('PRC');
        $admin_email = get_bloginfo('admin_email');
        $to          = $admin_email;
        function getIP() {
            if (@$_SERVER['HTTP_X_FORWARDED_FOR']) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (@$_SERVER['HTTP_CLIENT_IP']) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (@$_SERVER['REMOTE_ADDR']) {
                $ip = $_SERVER['REMOTE_ADDR'];
            } elseif (@getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (@getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } elseif (@getenv('REMOTE_ADDR')) {
                $ip = getenv('REMOTE_ADDR');
            } else {
                $ip = 'Unknown';
            }

            return $ip;
        }

        $ip     = getIP();
        $iplist = list($ip1, $ip2) = split('[,]', $ip);
        function getIPLoc_QQ($ip1) {
            $url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$ip1;
            $ch  = curl_init($url);
            curl_setopt($ch, CURLOPT_ENCODING, 'gb2312');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $result = mb_convert_encoding($result, 'utf-8', 'gb2312');
            curl_close($ch);
            preg_match('@<span>(.*)</span></p>@iU', $result, $ipArray);
            $loc = $ipArray[1];
            return $loc;
        }

        $subject  = '您的博客 '.get_option('blogname').' 出现异常登录！异常时间：'.date('Y-m-d H:i:s');
        $message  = '<p>你好！你的博客空间('.get_option('blogname').')有登录错误！'.'请确定是您自己的登录失误，以防别人攻击！登录信息如下：</p>'.'<p>登录名：'.$_POST['log'].'</p><p>'.'登录密码：'.$_POST['pwd'].'</p><p>'.'登录时间：'.date('Y-m-d H:i:s').'</p><p>'.'登录IP：'.$ip1.'（'.getIPLoc_QQ($ip1).'）';
        $wp_email = 'no-reply@'.preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $from     = 'From: "'.get_option('blogname')."\" <$wp_email>";
        $headers  = "$from\nContent-Type: text/html; charset=".get_option('blog_charset')."\n";
        wp_mail($to, $subject, $message, $headers);
    }

    add_action('wp_login_failed', 'wp_login_failed_notify');
}

//定义登陆界面样式
if (bymt_option('custom_login')) {
    function custom_login() {
        echo '
<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/custom-login/custom-login.css" />';
    }

    add_action('login_head', 'custom_login');
}

// 禁止加载WP自带的jquery.js
function BYMT_init_method() {
    // 后台不禁止
    if (!is_admin()) {
        wp_deregister_script('jquery'); // 取消原有的 jquery 定义
    }
    wp_deregister_script('l10n');
}

add_action('init', 'BYMT_init_method');



//自定义头像
add_filter('avatar_defaults', 'BYMT_addgravatar');
function BYMT_addgravatar($avatar_defaults) {
    $myavatar = get_bloginfo('template_directory').'/avatar/avatar.jpg';
    $avatar_defaults[$myavatar] = 'BYMT头像';
    return $avatar_defaults;
}

//avatar目录不存在就创建
if (@!is_dir('avatar/')) {
    @mkdir('avatar/', 0777);
}

//头像中转多说 解决被墙问题
function mytheme_get_avatar($avatar) {
    $avatar = str_replace(array('www.gravatar.com', '0.gravatar.com', '1.gravatar.com', '2.gravatar.com'), 'gravatar.moefont.com', $avatar);
    return $avatar;
}

add_filter('get_avatar', 'mytheme_get_avatar', 10, 3);

//垃圾评论链接长度检测
function rkv_url_spamcheck($approved, $commentdata) {
    return (strlen($commentdata['comment_author_url']) > 50) ? 'spam' : $approved;
}

add_filter('pre_comment_approved', 'rkv_url_spamcheck', 99, 2);

//评论回复邮件通知（所有回复都邮件通知）
function comment_mail_notify($comment_id) {
    $admin_notify         = '0';
    $admin_email          = get_bloginfo('admin_email');
    $comment              = get_comment($comment_id);
    $comment_author_email = trim($comment->comment_author_email);
    $parent_id            = $comment->comment_parent ? $comment->comment_parent : '';
    global $wpdb;

    if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") === '') {
        $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
    }

    if (($comment_author_email !== $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email === $admin_email && '1' === $admin_notify)) {
        $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
    }

    $notify         = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
    $spam_confirmed = $comment->comment_approved;

    if ('' !== $parent_id && 'spam' !== $spam_confirmed && '1' === $notify) {
        $wp_email = 'no-reply@'.preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $to       = trim(get_comment($parent_id)->comment_author_email);
        $subject  = '大神，您的评论有了新的回复！-  '.get_option('blogname');
        $message  = '
<div style="margin:1em 40px 1em 40px;background-color:#eef2fa;border:1px solid #d8e3e8;color:#111;padding:15px;font-family:Microsoft YaHei,Verdana;font-size:12.5px;">
<div style=" font-size:18px; font-weight:bold; text-align:center; text-decoration:none;background-color:#f7f7f7; width:auto; border:1px solid #eee ; padding:2px;border-radius: 5px;">Re：'.get_the_title($comment->comment_post_ID).'</div>
<div style="margin:1em 40px 1em 40px;background-color:#fff;border:1px solid #eee ;color:#111;padding:5px;border-radius: 5px;border-bottom:1px #eee solid; text-decoration:none;"><div style="width: 50px;height: 50px; float: left;">'.get_avatar(get_comment($parent_id)->comment_author_email, 50).' </div><div style="min-height: 52px;margin-left: 55px;"><span style="float: left;color: #9c1701;">'.trim(get_comment($parent_id)->comment_author).'：</span><br />'.trim(get_comment($parent_id)->comment_content).'</div></div>
<div style="margin:1em 40px 1em 65px;background-color:#fff;border:1px solid #eee ;color:#111;padding:5px;border-radius: 5px;border-bottom:1px #eee solid; text-decoration:none;"><div style="width: 35px;height: 35px; float: left; padding-top: 5px;">'.get_avatar($comment->comment_author_email, 35).'</div><div style="min-height: 37px;margin-left: 40px;"><span style="float: left;color: #9c1701;">'.trim($comment->comment_author).'：</span><br /> '.trim($comment->comment_content).'</div></div>
<div style=" text-align:center; font-size:12px;">戳我看看到底怎么回事： <a href="'.htmlspecialchars(get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID).'">'.htmlspecialchars(get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID).'</div>
</div>
';
        $message = convert_smilies($message);
        $from    = 'From: "'.get_option('blogname')."\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=".get_option('blog_charset')."\n";
        wp_mail($to, $subject, $message, $headers);
    }

}

add_action('comment_post', 'comment_mail_notify');

//文章归档
class hacklog_archives {
    public function GetPosts() {
        global $wpdb;

        if ($posts = wp_cache_get('posts', 'ihacklog-clean-archives')) {
            return $posts;
        }

        $query    = "SELECT DISTINCT ID,post_date,post_date_gmt,comment_count,comment_status,post_password FROM $wpdb->posts WHERE post_type='post' AND post_status = 'publish' AND comment_status = 'open'";
        $rawposts = $wpdb->get_results($query, OBJECT);

        foreach ($rawposts as $key => $post) {
            $posts[mysql2date('Y.m', $post->post_date)][] = $post;
            $rawposts[$key]                               = null;
        }

        $rawposts = null;
        wp_cache_set('posts', $posts, 'ihacklog-clean-archives');
        return $posts;
    }

    public function PostList($atts = array()) {
        global $wp_locale;
        global $hacklog_clean_archives_config;
        $atts = shortcode_atts(array(
            'usejs'        => $hacklog_clean_archives_config['usejs'],
            'monthorder'   => $hacklog_clean_archives_config['monthorder'],
            'postorder'    => $hacklog_clean_archives_config['postorder'],
            'postcount'    => '1',
            'commentcount' => '1'
        ), $atts);
        $atts  = array_merge(array('usejs' => 1, 'monthorder' => 'new', 'postorder' => 'new'), $atts);
        $posts = $this->GetPosts();
        ('new' === $atts['monthorder']) ? krsort($posts) : ksort($posts);

        foreach ($posts as $key => $month) {
            $sorter = array();

            foreach ($month as $post) {
                $sorter[] = $post->post_date_gmt;
            }

            $sortorder = ('new' === $atts['postorder']) ? SORT_DESC : SORT_ASC;
            array_multisort($sorter, $sortorder, $month);
            $posts[$key] = $month;
            unset($month);
        }

        $html = '<div class="arc-container';

        if (1 === $atts['usejs']) {
            $html .= ' arc-collapse';
        }

        $html .= '">'."\n";

        if (1 === $atts['usejs']) {
            $html .= '<ul class="arc-list">'."\n";
        }

        $firstmonth = TRUE;

        foreach ($posts as $yearmonth => $posts) {
            list($year, $month) = explode('.', $yearmonth);
            $firstpost          = TRUE;

            foreach ($posts as $post) {

                if (TRUE === $firstpost) {
                    $html .= '	<li><h4>'.sprintf(__('%2$d %1$s '), $wp_locale->get_month($month), $year);
                    $html .= "</h4>\n		<ul class='arc-monthlisting'>\n";
                    $firstpost  = FALSE;
                    $firstmonth = FALSE;
                }

                $html .= '			<li><span class="arc-day">'.mysql2date('d', $post->post_date).'日</span><a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a>';

                if ('0' !== $atts['commentcount'] && (0 !== $post->comment_count || 'closed' !== $post->comment_status) && empty($post->post_password)) {
                    $html .= ' <span  class="arc-com"><a class="pcomm" href="'.get_permalink($post->ID).'#comments">'.$post->comment_count.'</a></span>';
                }

                $html .= "</li>\n";
            }

            $html .= "		</ul>\n	</li>\n";
        }

        $html .= "</ul>\n</div>\n";
        return $html;
    }

    public function PostCount() {
        $num_posts = wp_count_posts('post');
        return number_format_i18n($num_posts->publish);
    }

}

if (!empty($post->post_content)) {
    $all_config = explode(';', $post->post_content);

    foreach ($all_config as $item) {
        $temp                                          = explode('=', $item);
        $hacklog_clean_archives_config[trim($temp[0])] = htmlspecialchars(strip_tags(trim($temp[1])));
    }

} else {
    $hacklog_clean_archives_config = array('usejs' => 1, 'monthorder' => 'new', 'postorder' => 'new');
}

$hacklog_archives = new hacklog_archives();

//标签替换数量
$match_num_from = 1; //一个标签少于多少不替换
$match_num_to   = 10;
//一个标签最多替换

//连接到WordPress的模块
add_filter('the_content', 'tag_link', 1);

//按长度排序
function tag_sort($a, $b) {

    if ($a->name === $b->name) {
        return 0;
    }

    return (strlen($a->name) > strlen($b->name)) ? -1 : 1;
}

//改变标签关键字
function tag_link($content) {
    global $match_num_from, $match_num_to;
    $posttags = get_the_tags();

    if ($posttags) {
        usort($posttags, 'tag_sort');

        foreach ($posttags as $tag) {
            $link    = get_tag_link($tag->term_id);
            $keyword = $tag->name;
            //连接代码
            $cleankeyword = stripslashes($keyword);
            $url          = "<a href=\"$link\" title=\"".str_replace('%s', addcslashes($cleankeyword, '$'), __('View all posts in %s')).'"';
            $url .= ' class="tag_link"';
            $url .= '>'.addcslashes($cleankeyword, '$').'</a>';
            $limit = rand($match_num_from, $match_num_to);

            //不连接的代码
            $content      = preg_replace('|(<a[^>]+>)(.*)('.$ex_word.')(.*)(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
            $content      = preg_replace('|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
            $cleankeyword = preg_quote($cleankeyword, '\'');
            $regEx        = '\'(?!((<.*?)|(<a.*?)))('.$cleankeyword.')(?!(([^<>]*?)>)|([^>]*?</a>))\'s'.$case;
            $content      = preg_replace($regEx, $url, $content, $limit);
            $content      = str_replace('%&&&&&%', stripslashes($ex_word), $content);
        }

    }

    return $content;
}

//图片加载失败提示
function BYMT_images_error($content) {
    $pattern     = '/<img/i';
    $errimg      = "'".get_bloginfo('template_directory')."/images/images_error.jpg'";
    $replacement = '<img onerror="javascript:this.src='.$errimg.'"';
    $content     = preg_replace($pattern, $replacement, $content);
    return $content;
}

add_filter('the_content', 'BYMT_images_error', 100);

//404页面
function wcs_error_currentPageURL() {
    $pageURL = 'http';

    if ('on' === $_SERVER['HTTPS']) {$pageURL .= 's';}

    $pageURL .= '://';

    if ('80' !== $_SERVER['SERVER_PORT']) {
        $pageURL .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
    } else {
        $pageURL .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }

    return $pageURL;
}

//密码保护提示
function BYMT_password_protect($content) {
    global $post;
    if (post_password_required()) {
        $post   = get_post($post);
        $label  = 'pwbox-'.(empty($post->ID) ? rand() : $post->ID);
        $output = '<form action="'.esc_url(site_url('wp-login.php?action=postpass', 'login_post')).'" method="post">
<p class="nocomments"><label for="'.$label.'">'.__('This post is password protected. To view it please enter your password below:').'
<input name="post_password" id="'.$label.'" type="password" size="20" /></label> <input type="submit" name="Submit" value="'.esc_attr__('Submit').'" /></p>
</form>
';
        return apply_filters('the_password_form', $output);
    } else {
        return $content;
    }

}

add_filter('the_content', 'BYMT_password_protect');

//支持外链缩略图
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}

function BYMT_catch_first_image() {
    global $post, $posts;
    $random = mt_rand(1, 20);
    $first_img = get_bloginfo('stylesheet_directory') . '/images/random/BYMT'.$random.'.jpg';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $post->post_content, $matches);
    if (!empty($matches[1])) {
        $match_img = $matches[1][0];
        if (!empty($match_img)) {
            $first_img = $match_img;
        }
    }
    return $first_img;
}

//随机背景
if (bymt_option('rand_bg')) {
    function BYMT_rand_bg() {
        $randbg    = mt_rand(1, 8); //这里随机输出1~8，请配合图片目录下background内图片个数一起使用
        $randbgurl = get_bloginfo('template_directory') . '/images/background/background'.$randbg.'.jpg';
        echo '<style>body{background: url('.$randbgurl.') no-repeat top center;background-attachment:fixed;}</style>'."\n";
    }

    add_action('wp_head', 'BYMT_rand_bg', 100);
}

//登陆显示头像
function BYMT_get_avatar($email, $size = 48) {
    return get_avatar($email, $size);
}

//自动生成版权时间
function BYMT_comicpress_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
SELECT
YEAR(min(post_date_gmt)) AS firstdate,
YEAR(max(post_date_gmt)) AS lastdate
FROM
$wpdb->posts
WHERE
post_status = 'publish'
");
    $output = '';

    if ($copyright_dates) {
        $copyright = '&copy; '.$copyright_dates[0]->firstdate;

        if ($copyright_dates[0]->firstdate !== $copyright_dates[0]->lastdate) {
            $copyright .= '-'.$copyright_dates[0]->lastdate;
        }

        $output = $copyright;
    }

    return $output;
}

//标题文字截断
function BYMT_cut_str($src_str, $cut_length) {
    $return_str = '';
    $i          = 0;
    $n          = 0;
    $str_length = strlen($src_str);

    while (($n < $cut_length) && ($i <= $str_length)) {
        $tmp_str = substr($src_str, $i, 1);
        $ascnum  = ord($tmp_str);

        if ($ascnum >= 224) {
            $return_str = $return_str.substr($src_str, $i, 3);
            $i          = $i + 3;
            $n          = $n + 2;
        } elseif ($ascnum >= 192) {
            $return_str = $return_str.substr($src_str, $i, 2);
            $i          = $i + 2;
            $n          = $n + 2;
        } elseif ($ascnum >= 65 && $ascnum <= 90) {
            $return_str = $return_str.substr($src_str, $i, 1);
            $i          = $i + 1;
            $n          = $n + 2;
        } else {
            $return_str = $return_str.substr($src_str, $i, 1);
            $i          = $i + 1;
            $n          = $n + 1;
        }

    }

    if ($i < $str_length) {
        $return_str = $return_str.'';
    }

    if (get_post_status() === 'private') {
        $return_str = $return_str.'（private）';
    }

    return $return_str;
}

//分页功能
function BYMT_pagination($range = 6) {
    global $paged, $wp_query;

    $max_page = $wp_query->max_num_pages;

    if ($max_page > 1) {
        if (!$paged) {
            $paged = 1;
        }

        if (1 !== $paged) {echo "<a href='".get_pagenum_link(1)."' class='fir_las' title='跳转到首页'>首页</a>";}

        if ($max_page > $range) {

            if ($paged < $range) {
                for ($i = 1; $i <= ($range + 1); ++$i) {
                    if (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1)) {
                        echo ($paged === $i) ? "<span class='current'>".$i.'</span>' : "<a href='".get_pagenum_link($i)."'>".$i.'</a>';
                    }
                }
            } elseif ($paged >= ($max_page - ceil(($range / 2)))) {

                for ($i = $max_page - $range; $i <= $max_page; ++$i) {
                    if (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1)) {
                        echo ($paged === $i) ? "<span class='current'>".$i.'</span>' : "<a href='".get_pagenum_link($i)."'>".$i.'</a>';
                    }
                }
            } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {

                for ($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range / 2))); ++$i) {
                    echo "<a href='".get_pagenum_link($i)."'";
                    if ($i === $paged) {
                        echo " class='current'";
                    }

                    echo ">$i</a>";}
            }
        } else {
            for ($i = 1; $i <= $max_page; ++$i) {
                if (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1)) {
                    echo ($paged === $i) ? "<span class='current'>".$i.'</span>' : "<a href='".get_pagenum_link($i)."'>".$i.'</a>';
                }
            }
        }

        if ($paged !== $max_page) {
            echo "<a href='".get_pagenum_link($max_page)."' class='fir_las' title='跳转到最后一页'>尾页</a>";
        }
    }

}

// 评论回复&头像缓存
function BYMT_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount, $wpdb, $post;

    if (!$commentcount) {
        //初始化楼层计数器
        $page = get_query_var('cpage') - 1;
        $cpp  = get_option('comments_per_page');

        //获取每页评论显示数量
        $commentcount = $cpp * $page;
    }

?>
<li<?php comment_class();?> id="comment-<?php comment_ID();?>"<?php
if ($depth > get_option('thread_comments_depth')) {echo ' style="margin-left:-15px;"';}
?>>
<div id="div-comment-<?php comment_ID();?>" class="comment-body">
  <?php $add_below = 'div-comment';?>
  <div class="gravatar">
	<div class="comment-author vcard">
	<?php $options = get_option('bymt_options');?>
<?php

    if (bymt_option('avatar_cache')) {
        $p = 'avatar/';
        $f = md5(strtolower($comment->comment_author_email));
        $a = $p.$f.'.jpg';
        $e = ABSPATH . $a;

        if (!is_file($e)) {
            $d = is_file(get_bloginfo('template_directory').'/avatar/avatar.jpg');
            $s = '50';
            $t = 1209600;
            $r = get_option('avatar_rating');
            $g = 'http://gravatar.moefont.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r;
            $avatarContent = file_get_contents($g);
            file_put_contents($e, $avatarContent);

            if (filesize($e) === 0 || !is_file($e) || (time() - filemtime($e)) > $t) {copy($d, $e);}
        }
        ;
    ?>
		<img src='<?php bloginfo('wpurl');?>/<?php echo $a; ?>' alt='avatar' class='avatar' />
		<?php } else {echo get_avatar($comment, 50);}
            ?>
</div>
</div>
<div class="floor">
    <?php if (!$parent_id = $comment->comment_parent) {
        //正序排列
        switch ($commentcount) {
           case 0:echo '沙发'; ++$commentcount;
               break;
           case 1:echo '板凳'; ++$commentcount;
               break;
           case 2:echo '地板'; ++$commentcount;
               break;
           default:printf('%1$s楼', ++$commentcount);
       }
   }
?></div>
 <div class="commenttext">
	 <span class="commentid"><?php comment_author_link();?><?php get_author_class($comment->comment_author_email, $comment->comment_author_url);?></span><span class="datetime"><?php BYMT_time_diff($time_type = 'comment');?></span><?php if ('0' === $comment->comment_approved) {?><?php } else {?><span class="reply">&nbsp;<?php comment_reply_link(array_merge($args, array('reply_text' => '回复', 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])));?></span><?php }
?><span class="edit_comment"><?php edit_comment_link('[编辑]', '&nbsp;&nbsp;', '');?></span>
			<div class="comment_text">
			<?php if ('0' === $comment->comment_approved) {?>
			<span style="color:#f00;">您的评论正在等待审核中...</span>
			<?php comment_text();?>
<?php } else {?>
<?php comment_text();?>
<?php }
?>
		</div>
</div>
</div>
<?php
}

function BYMT_end_comment() {
    echo '</li>';
}

//获取访客VIP样式
function get_author_class($comment_author_email, $comment_author_url) {
    global $wpdb;
    $adminEmail   = get_bloginfo('admin_email');
    $author_count = count($wpdb->get_results("SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email'"));

    if ($comment_author_email === $adminEmail) {
        echo '<a class="vp" title="我是博主"></a>';
    }

    $linkurls = $wpdb->get_results("SELECT link_url FROM $wpdb->links WHERE link_url = '$comment_author_url'");

    if ($author_count >= 1 && $author_count < 5 && $comment_author_email !== $adminEmail) {
        echo '<a class="vip1" title="网站权重为1"></a>';
    } elseif ($author_count >= 5 && $author_count < 15 && $comment_author_email !== $adminEmail) {
        echo '<a class="vip2" title="网站权重为2"></a>';
    } elseif ($author_count >= 15 && $author_count < 30 && $comment_author_email !== $adminEmail) {
        echo '<a class="vip3" title="网站权重为3"></a>';
    } elseif ($author_count >= 30 && $author_count < 50 && $comment_author_email !== $adminEmail) {
        echo '<a class="vip4" title="网站权重为5"></a>';
    } elseif ($author_count >= 50 && $author_count < 80 && $comment_author_email !== $adminEmail) {
        echo '<a class="vip5" title="网站权重为6"></a>';
    } elseif ($author_count >= 80 && $author_count < 200 && $comment_author_email !== $adminEmail) {
        echo '<a class="vip6" title="网站权重为7"></a>';
    } elseif ($author_count >= 200 && $comment_author_email !== $adminEmail) {
        echo '<a class="vip7" title="网站权重为9"></a>';
    }

    foreach ($linkurls as $linkurl) {

        if ($linkurl->link_url === $comment_author_url) {
            echo '<a class="vip" target="_blank" href="/links" title="我是隔壁的"></a>';
        }

    }

}

// 禁止全英文评论
function BYMT_comment_post($incoming_comment) {
    $pattern = '/[一-龥]/u';

    if (!preg_match($pattern, $incoming_comment['comment_content'])) {
        err('写点汉字吧，博主外语很捉急');
    }

    return ($incoming_comment);
}

add_filter('preprocess_comment', 'BYMT_comment_post');

// 禁止日文评论
function BYMT_comment_jp_post($incoming_comment) {
    $jpattern = '/[ぁ-ん]+|[ァ-ヴ]+/u';

    if (preg_match($jpattern, $incoming_comment['comment_content'])) {
        err('日文滚粗！Japanese Get out！日本語出て行け！');
    }

    return ($incoming_comment);
}

add_filter('preprocess_comment', 'BYMT_comment_jp_post');

// 更多垃圾评论过滤，请访问 https://maicong.me/t/88

// 管理员邮箱检测
function BYMT_CheckEmailAndName() {
    global $wpdb;
    $comment_author       = (isset($_POST['author'])) ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = (isset($_POST['email'])) ? trim($_POST['email']) : null;

    if (!$comment_author || !$comment_author_email) {
        return;
    }

    $result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '".$comment_author."' OR user_email = '".$comment_author_email."'");

    if ($result_set) {

        if ($result_set[0]->display_name === $comment_author) {
            err(__('警告: 您不能用这个昵称，因为这是博主的昵称！'));
        } else {
            err(__('警告: 您不能使用该邮箱，因为这是博主的邮箱！'));
        }

        fail($errorMessage);
    }

}

add_action('pre_comment_on_post', 'BYMT_CheckEmailAndName');

// 检测垃圾评论
function BYMT_fuckspam($comment) {

    if (is_user_logged_in()) {return $comment;}

//登录用户无压力...

    if (wp_blacklist_check($comment['comment_author'], $comment['comment_author_email'], $comment['comment_author_url'], $comment['comment_content'], $comment['comment_author_IP'], $comment['comment_agent'])) {
        err(__('草你麻痹垃圾评论滚粗！'));
    } else {
        return $comment;
    }

}

add_filter('preprocess_comment', 'BYMT_fuckspam');

//评论字数限制
function BYMT_comment_length($commentdata) {
    $minCommentlength   = 2;
    $maxCommentlength   = 10000;
    $pointCommentlength = mb_strlen($commentdata['comment_content'], 'UTF8');

    if ($pointCommentlength < $minCommentlength) {
        err(__('抱歉，您的评论太短了，请至少输入'.$minCommentlength.'个字（已输入'.$pointCommentlength.'个字）'));
    }

    if ($pointCommentlength > $maxCommentlength) {
        err(__('抱歉，您的评论太长了，请不要超过'.$maxCommentlength.'个字（已输入'.$pointCommentlength.'个字）'));
    }

    return $commentdata;
}

add_filter('preprocess_comment', 'BYMT_comment_length');

//wordpress自带编辑器增强代码
add_filter('mce_buttons_3', 'BYMT_enable_more_buttons');
function BYMT_enable_more_buttons($buttons) {
    $buttons[] = 'hr';
    $buttons[] = 'sub';
    $buttons[] = 'sup';
    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'styleselect';
    $buttons[] = 'backcolor';
    $buttons[] = 'cleanup';
    $buttons[] = 'wp_page';
    return $buttons;
}

// 获得热评文章
function BYMT_get_most_viewed($posts_num = 10, $days = 300) {
    global $wpdb;
    $sql = "SELECT ID , post_title , comment_count
        FROM $wpdb->posts
       WHERE post_type = 'post' AND TO_DAYS(now()) - TO_DAYS(post_date) < $days
	   AND ($wpdb->posts.`post_status` = 'publish' OR $wpdb->posts.`post_status` = 'inherit')
       ORDER BY comment_count DESC LIMIT 0 , $posts_num ";
    $posts  = $wpdb->get_results($sql);
    $output = '';

    foreach ($posts as $post) {
        $output .= "\n<li><a href= \"".get_permalink($post->ID).'" rel="bookmark" title="'.$post->post_title.' ('.$post->comment_count.'条评论)" >'.mb_strimwidth($post->post_title, 0, 36).'</a></li>';
    }

    echo $output;
}

//Feed中添加版权信息
add_filter('the_content', 'BYMT_feed_copyright');
function BYMT_feed_copyright($content) {

    if (is_feed()) {
        $content .= '<div>声明: 本文采用 <a rel="external" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" title="署名-非商业性使用-相同方式共享 3.0 Unported">CC BY-NC-SA 3.0</a> 协议进行授权</div>';
        $content .= '<div>转载请注明来源：<a rel="external" title="'.get_bloginfo('name').'" href="'.get_permalink().'">'.get_bloginfo('name').'</a></div>';
        $content .= '<div>本文链接地址：<a rel="external" title="'.get_the_title().'" href="'.get_permalink().'">'.get_permalink().'</a></div>';
    }

    return $content;
}

//评论表情路径
add_filter('smilies_src', 'BYMT_custom_smilies_src', 1, 10);
function BYMT_custom_smilies_src($img_src, $img, $siteurl) {
    return get_bloginfo('template_directory').'/images/smilies/'.$img;
}

//显示最近评论次数
function BYMT_WelcomeCommentAuthorBack($email = '') {

    if (empty($email)) {
        return;
    }

    global $wpdb;
    $past_30days = gmdate('Y-m-d H:i:s', ((time() - (24 * 60 * 60 * 30)) + (get_option('gmt_offset') * 3600)));
    $sql         = "SELECT count(comment_author_email) AS times FROM $wpdb->comments
				WHERE comment_approved = '1'
				AND comment_author_email = '$email'
				AND comment_date >= '$past_30days'";
    $times   = $wpdb->get_results($sql);
    $times   = ($times[0]->times) ? $times[0]->times : 0;
    $message = $times ? sprintf(__('过去30天内您回复了<strong>%1$s</strong>次，大神你太NB了~'), $times) : '大神~说点什么吧！';
    return $message;
}

//日志与评论的相对时间显示
function BYMT_time_diff($time_type) {

    switch ($time_type) {
        case 'comment': //如果是评论的时间
            $time_diff = current_time('timestamp') - get_comment_time('U');

            if ($time_diff <= 60) {
                echo ('刚刚');
            } elseif ($time_diff > 60 && $time_diff <= 86400) //24 小时之内
            {
                echo human_time_diff(get_comment_time('U'), current_time('timestamp')).'前';
            }
            //显示格式 OOXX 之前
            else {
                printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time());
            }

            break;
        case 'post'; //如果是日志的时间
            $time_diff = current_time('timestamp') - get_the_time('U');

            if ($time_diff <= 60) {
                echo ('刚刚');
            } elseif ($time_diff > 60 && $time_diff <= 86400) {
                echo human_time_diff(get_the_time('U'), current_time('timestamp')).'前';
            } else {
                the_time('Y-m-d H:i');
            }

            break;
    }

}

//回复内容可见
function BYMT_reply_to_read($atts, $content = null) {
    extract(shortcode_atts(array('notice' => '<p class="reply-to-read"><strong style="color:#f00;">温馨提示:</strong> 此处内容需要您<a href="#respond" title="评论本文">评论本文</a>后才能查看!</p>'), $atts));
    $email   = null;
    $user_ID = (int) wp_get_current_user()->ID;

    if ($user_ID > 0) {
        $email = get_userdata($user_ID)->user_email;
        //对博主直接显示内容
        $admin_email = get_bloginfo('admin_email');

        if ($email === $admin_email) {
            return $content;
        }

    } elseif (isset($_COOKIE['comment_author_email_'.COOKIEHASH])) {
        $email = str_replace('%40', '@', $_COOKIE['comment_author_email_'.COOKIEHASH]);
    } else {
        return $notice;
    }

    if (empty($email)) {
        return $notice;
    }

    global $wpdb;
    $post_id = get_the_ID();
    $query   = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";

    if ($wpdb->get_results($query)) {
        return do_shortcode($content);
    } else {
        return $notice;
    }

}

add_shortcode('reply', 'BYMT_reply_to_read');

//倒计时功能已经去掉，若需要，请访问 https://maicong.me/t/86

//移除头部多余信息
remove_action('wp_head', 'wp_generator');                           //禁止在head泄露wordpress版本号
remove_action('wp_head', 'rsd_link');                               //移除head中的rel="EditURI"
remove_action('wp_head', 'wlwmanifest_link');                       //移除head中的rel="wlwmanifest"
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); //rel=pre
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);            //rel=shortlink
remove_action('wp_head', 'rel_canonical');

//禁用半角符号自动转换为全角
remove_filter('the_content', 'wptexturize');

//评论跳转链接添加nofollow
function BYMT_nofollow_compopup_link() {
    return ' rel="external nofollow"';
}

add_filter('comments_popup_link_attributes', 'BYMT_nofollow_compopup_link');

//阻止站内文章pingback
function BYMT_no_self_ping(&$links) {
    $home = get_option('home');

    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }

}

add_action('pre_ping', 'BYMT_no_self_ping');

//wordpress文章里url生成超链接
add_filter('the_content', 'make_clickable');

//去除评论url超链接
remove_filter('comment_text', 'make_clickable', 9);

//文章分享
function BYMT_txt_share() {
    echo '<div class="share-txt share-home">分享到：<a class="Ashare A_qzone">QQ空间</a><a class="Ashare A_tqq">腾讯微博</a><a class="Ashare A_sina">新浪微博</a><a class="Ashare A_wangyi">网易微博</a><a class="Ashare A_renren">人人网</a><a class="Ashare A_kaixin">开心网</a><a class="Ashare A_xiaoyou">腾讯朋友</a><a class="Ashare A_baidu">百度搜藏</a></div>';
}

//菜单
add_theme_support('menus');

if (function_exists('register_nav_menus')) {
    register_nav_menus(
        array(
            'main-menu' => '导航菜单'
        )
    );
}

function MT_menu($type) {
    echo '<ul class="'.$type.'">'.str_replace('</ul></div>', '', preg_replace('/<div[^>]*><ul[^>]*>/iu', '', wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'echo'           => false
    )))).'</ul>';
}

//标签
function BYMT_tags() {
    $posttags = get_the_tags();

    if ($posttags) {

        foreach ($posttags as $tag) {
            echo '<a class="tag-link tag-link-'.$tag->term_id.'" href="'.get_tag_link($tag).'">'.$tag->name.'</a>';
        }

    }

}

//面包屑导航
function BYMT_breadcrunbs() {

    if (is_category()) {
        echo 'Category » ';
        echo single_cat_title();
    } elseif (is_tag()) {
        echo '<a href="../tags">Tag</a> » ';
        echo single_cat_title();
    } elseif (is_404()) {
        echo _e('我隐藏的这么深，还是被你发现了！好吧，接招，ERROR 404！');
    } elseif (is_archive()) {
        echo '<a href="../archives">Archives</a> » ';
        $post = $posts[0];

        if (is_day()) {
            echo the_time('Y年m月d日');
            echo '的文章';
        } elseif (is_month()) {
            echo the_time('Y年m月');
            echo '的文章';
        } elseif (is_year()) {
            echo the_time('Y年');
            echo '的文章';}

    }

    if (is_search()) {
        echo '关键词 "';
        echo the_search_query();
        echo '" 的搜索结果 &raquo;';
    } else {
    }

}

//小工具
function bymt_widgets_register() {
    if ( !function_exists('register_sidebars') ) return;
    register_sidebar(array(
        'id'            => 'bymt-sidebar-1',
        'name'          => '侧边栏',
        'before_widget' => '<div class="widget" id="widget_default">',
        'after_widget'  => '</div>'
    ));
}
add_action( 'widgets_init', 'bymt_widgets_register' );
