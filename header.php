<?php !defined('WPINC') && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */
?><!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type');?>; charset=<?php bloginfo('charset');?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<?php $options = get_option('bymt_options');?>
<?php include 'includes/title.php';?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory');?>/style.css" media="all"/>
<!--[if IE 7]><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/ie7.css" type="text/css" media="screen" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/ie8.css" type="text/css" media="screen" /><![endif]-->
<?php
if (bymt_option('favicon_ck')): ?>
<link rel="shortcut icon" href="<?php echo bymt_option('custom_favicon'); ?>" type="image/x-icon" />
<?php else: ?>
<link rel="Shortcut Icon" href="<?php bloginfo('template_directory');?>/images/favicon.png" type="image/x-icon" />
<?php endif;?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name');?> RSS Feed" href="<?php bloginfo('rss2_url');?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name');?> Atom Feed" href="<?php bloginfo('atom_url');?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
<?php
if (bymt_option('sinajq')): ?>
<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.8.3/jquery.min.js"></script>
<?php elseif (bymt_option('googlejq')): ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<?php elseif (bymt_option('baidujq')): ?>
<script type="text/javascript" src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<?php elseif (bymt_option('microsoftjq')): ?>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
<?php elseif (bymt_option('upaiyunjq')): ?>
<script type="text/javascript" src="http://upcdn.b0.upaiyun.com/libs/jquery/jquery-1.8.3.min.js"></script>
<?php elseif (bymt_option('selfjq')): ?>
<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/jquery.min.js"></script>
<?php else: ?>
<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/jquery.min.js"></script>
<?php endif;?>
<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/jquery.min.js">\x3C/script>')</script>
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<?php
if (is_singular()) {?>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/comments-ajax.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/comments.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/realgravatar.js"></script>
<?php }
?>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/BYMT.js"></script>
<?php wp_head();?>
</head>
<body>
<div id="wrapper-innerIE6"></div>
<div id="wrapper">
<div id="wrapper-inner">
<div id="header" class="container">
	<div id="header_inner">
		<span id="logo">
		<?php
        if (bymt_option('check_logo')): ?>
		<h1><a title="<?php bloginfo('name');?>" href="<?php echo home_url(); ?>" rel="home"><?php
if (empty(bymt_option('custom_sitetitle'))): echo get_bloginfo('name');else:echo bymt_option('custom_sitetitle');endif;?></a></h1>
		<?php
        if (bymt_option('check_logodesc')): ?>
		<p class="logodesc"><?php
if (empty(bymt_option('custom_logodesc'))): echo get_bloginfo('description');else:echo bymt_option('custom_logodesc');endif;?></p>
		<?php endif;?>
<?php else: ?>
		<a title="<?php bloginfo('name');?>" href="<?php echo home_url(); ?>"><img src="<?php
if (bymt_option('custom_logo')): ?><?php echo bymt_option('logo_url'); ?><?php else: ?><?php bloginfo('template_url');?>/images/logo.png<?php endif;?>" alt="<?php bloginfo('name');?>" /></a>
		<?php endif;?>
		</span>
		<span id="topblock">
		<?php
        if (bymt_option('custom_topblock')): ?>
<?php echo bymt_option('topblock_content'); ?>
<?php else: ?>
<?php
if ($user_ID): ?>
			<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php" class="welcome">
			<?php global $current_user;
                wp_get_current_user();
                echo get_avatar($current_user->user_email, 42);
                echo ' 欢迎回来，';
                echo $current_user->display_name;
            echo '！';?>
			</a>
			<?php else: ?>
<?php

    if (isset($_COOKIE['comment_author_'.COOKIEHASH]) || isset($_COOKIE['comment_author_email_'.COOKIEHASH]) || isset($_COOKIE['comment_author_url_'.COOKIEHASH])) {
        $lastCommenter = $_COOKIE['comment_author_'.COOKIEHASH];
        $lastavatar    = get_avatar($_COOKIE['comment_author_email_'.COOKIEHASH], 42);
        $lasturl       = $_COOKIE['comment_author_url_'.COOKIEHASH];
        echo '<a href="'.$lasturl.'" rel="nofollow" class="welcome" >'.$lastavatar.' 欢迎回来，'.$lastCommenter.'</a>！';
    } else {
        echo "<span style='font-size:24px'>如果感觉喜欢你就关注我！&lt;(*￣▽￣*)↘</span>";
    }
?>
<?php endif;?>
<?php endif;?>
			</span>
	</div>
	<div class="line"></div>
	<div id="menu">
		<?php MT_menu('menu');?>
		<form action="<?php echo home_url('/'); ?>" method="get">
			<div id="search" class="input">
				<input type="text" name="s" class="field" value="<?php
                                                                 if (bymt_option('custom_search')): ?><?php echo bymt_option('search_word'); ?><?php else: ?>我是搜索酱...<?php endif;?>" onFocus="if (this.value == '<?php
if (bymt_option('custom_search')): ?><?php echo bymt_option('search_word'); ?><?php else: ?>我是搜索酱...<?php endif;?>') {this.value = '';}" onBlur="if (this.value == '') {this.value = '<?php
if (bymt_option('custom_search')): ?><?php echo bymt_option('search_word'); ?><?php else: ?>我是搜索酱...<?php endif;?>';}" />
				<input type="submit" value="" />
			</div>
		</form>
	</div>
</div>
<div id="topbar" class="container">
 <span id="bulletin">
	<?php
    if (is_category() || is_search() || is_404() || is_archive()) {?>
<?php BYMT_breadcrunbs();?>
<?php } else {
    ?>
<?php
if (bymt_option('notice') && bymt_option('ggid')): ?>
<?php
    $page_ID      = bymt_option('ggid');
        $announcement = '';
        $comments     = get_comments("number=1&post_id=$page_ID");

        if (!empty($comments)) {

            foreach ($comments as $comment) {
                $announcement .= ''.convert_smilies($comment->comment_content).' <span style="color:#999;font-size: xx-small">('.get_comment_date('m-d H:i', $comment->comment_ID).')</span>';

                if ($user_ID) {
                    echo '<a href="'.get_page_link($page_ID).'#respond" rel="nofollow" class="anno">[发表]</a>';
                }

            }

        }

        if (empty($announcement)) {
            $announcement = '欢迎光临本博！';
        }

        echo $announcement;
    ?>
<?php elseif (bymt_option('noticecontent')): ?>
<?php echo bymt_option('noticecontent'); ?>
<?php else: ?>
<?php echo '欢迎光临本博！'; ?>
<?php endif;?>
<?php }
?>
 </span>
 <span id="rss">
	<ul>
		<?php
        if (bymt_option('facebook')): ?>
		<li><a href="<?php echo bymt_option('facebooklink'); ?>" target="_blank" class="icon5" title="My Facebook"></a></li>
		<?php endif;?>
<?php
if (bymt_option('twitter')): ?>
		<li><a href="<?php echo bymt_option('twitterlink'); ?>" target="_blank" class="icon4" title="Follow me"></a></li>
		<?php endif;?>
<?php
if (bymt_option('qqweibo')): ?>
		<li><a href="<?php echo bymt_option('qqweibolink'); ?>" target="_blank" class="icon3" title="我的腾讯微博"></a></li>
		<?php endif;?>
<?php
if (bymt_option('weibo')): ?>
		<li><a href="<?php echo bymt_option('weibolink'); ?>" target="_blank" class="icon2" title="我的新浪微博"></a></li>
		<?php endif;?>
<?php
if (bymt_option('rss')): ?>
		<li><a href="<?php bloginfo('rss2_url');?>" target="_blank" class="icon1" title="订阅RSS"></a></li>
        <?php endif;?>
<?php
if (bymt_option('weixin')): ?>
		<li class="weixin"><a href="#" title="关注我的微信"><img src="<?php bloginfo('template_url');?>/images/weixin-28.png" alt="微信" /><b><span></span><i><img src="<?php echo bymt_option('weixinimg'); ?>" alt="微信" /></i></b></a></li>
        <?php endif;?>
	</ul>
 </span>
</div>
