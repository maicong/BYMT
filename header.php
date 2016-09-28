<!DOCTYPE html>
<!--
                                   ,343
                               .69##962
  .,355666541     ,4554441.     3#@73.15444531   15444541.5555555444455553,
 ,8##@66458@#@63.  18###76     ,@962  .5###861    5###@72 6#@876###877@##83
  2##74    19##63    3##@63   3#95,    1###95,    8###74   451  7##62  364
  2##74    3##@72     ,9##85,5#84.     2@7##85.  6#8##84    .   7##72   .
268##@8778@##84,        6##9@@72       2#69##64 3#68##84        7##72
136##8544458##841        5##961        2#629#@54#843##84        7##72
  2##75     4###71       2##86         2#6,1##8@96.3##84        7##72
  1##74     5##961       2##86         3#71 5##@62 3##74        6##62
 ,7##9844569#@863       28###94.     .4@#@6, 9#74 28##@81     .3@##@6.
 26555566666431,       155555565     4655556..54  36555573    .5555566,

-->
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<?php bymt_head(); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper-innerIE6"></div>
<div id="wrapper">
<div id="wrapper-inner" <?php bymt_innerbymts(); ?>>
<div id="header" class="container">
	<div id="header-inner">
	<div id="logo">
	<?php if(bymt_c('check_logo')): ?>
		<h1><a title="<?php esc_attr_e(get_bloginfo('name')); ?>" href="<?php echo esc_url(home_url('/')); ?>" rel="index"><?php bymt_r('custom_sitetitle', esc_attr(get_bloginfo('name')), 'e'); ?></a></h1>
		<?php if(bymt_c('check_logodesc')): ?>
		<p class="logodesc">
			<?php bymt_r('custom_logodesc', esc_attr(get_bloginfo('description')), 'e'); ?>
		</p>
		<?php endif; ?>
	<?php else: ?>
		<a title="<?php esc_attr_e(get_bloginfo('name')); ?>" href="<?php echo esc_url(home_url('/')); ?>" rel="index"><img src="<?php if(bymt_c('custom_logo')){ bymt('logo_url', 'u'); }else{ echo TPLDIR . '/images/logo.png'; } ?>" alt="<?php esc_attr_e(get_bloginfo('name')); ?>" /></a>
	<?php endif; ?>
	</div>
	<div id="topblock"<?php if (bymt_c('custom_topblock_border')){ echo ' class="border"'; } ?>>
		<?php if(bymt_c('custom_topblock')=="2" ){ bymt('topblock_content'); }elseif(bymt_c('custom_topblock')=="1" ){ bymt_slides('top','600','80'); }else{ ?>
		<i>
		<?php if (is_user_logged_in()){ ?>
		<a href="<?php echo esc_url(get_option('siteurl')) . '/wp-admin/profile.php'; ?>" class="welcome">
		<?php global $current_user; wp_get_current_user(); echo bymt_avatar($current_user->user_email, 45)." 欢迎回来，".$current_user->display_name."！";  ?>
		</a>
		<?php }else{
				if(isset($_COOKIE['comment_author_'.COOKIEHASH])||isset($_COOKIE['comment_author_email_'.COOKIEHASH])||isset($_COOKIE['comment_author_url_'.COOKIEHASH])) {
					$lastuser = esc_attr($_COOKIE['comment_author_'.COOKIEHASH]);
					$lastava = bymt_avatar($_COOKIE['comment_author_email_'.COOKIEHASH], 45);
					$lasturl = esc_url($_COOKIE['comment_author_url_'.COOKIEHASH]);
					echo "<a href=\"".$lasturl."\" rel=\"nofollow\" class=\"welcome\" >".$lastava." 欢迎回来，". $lastuser."</a>！";
				}else{
					echo bymt_refurl();
				} } ?>
		</i>
		<?php } ?>
	</div>
	</div>
	<div class="line"></div>
    <div id="mobile-nav">
    <a href="#main-nav"><i class="icon-menu"></i> Menu</a>
    </div>
	<div id="main-nav">
		<?php bymt_menu('nav-menu'); ?>
		<?php if ( !wp_is_mobile() ) { ?>
		<div id="nav-search">
			<form action="<?php echo esc_url(home_url('/')); ?>" method="get">
				<input type="text" name="s" id="search-input" data-searchtips="<?php if(bymt_c('custom_search')){ ?><?php bymt('search_word', 'e'); }else{ echo '搜点什么呢...'; } ?>" value="<?php the_search_query(); ?>" autocomplete="off"<?php if(bymt_c('custom_search_voice')){ echo ' x-webkit-speech x-webkit-grammar="builtin:translate"'; } ?> />
				<ul id="search-cloud"<?php if(bymt_c('ajax_search')){ echo ' data-cloudnum="'; bymt_r('ajax_search_num','all'); echo '"'; } ?>>
				</ul>
				<input type="submit" value="搜索" />
			</form>
		</div>
		<?php } ?>
	</div>
</div>
<?php if(bymt_c('sd_config_nav_ck')){ bymt_slides('nav','1060','120'); } ?>
<div id="topbar" class="container">
<div id="bulletin">
	<?php if(bymt_c('notice')){ bymt_bulletin(); }else{ bymt_breadcrunbs(); } ?>
</div>
<?php if ( !wp_is_mobile() ) { ?>
<div id="rss">
	<ul>
		<?php if(bymt_c('googleplus')): ?>
		<li><a href="<?php bymt('googlepluslink', 'u'); ?>?rel=author" rel="external" target="_blank" class="icons-gp" title="My Google+"></a></li>
		<?php endif; ?>
		<?php if(bymt_c('facebook')): ?>
		<li><a href="<?php bymt('facebooklink', 'u'); ?>" rel="external" target="_blank" class="icons-fb" title="My Facebook"></a></li>
		<?php endif; ?>
		<?php if(bymt_c('twitter')): ?>
		<li><a href="<?php bymt('twitterlink', 'u'); ?>" rel="external" target="_blank" class="icons-tt" title="Follow me"></a></li>
		<?php endif; ?>
		<?php if(bymt_c('qqweibo')): ?>
		<li><a href="<?php bymt('qqweibolink', 'u'); ?>" rel="external" target="_blank" class="icons-qw" title="我的腾讯微博"></a></li>
		<?php endif; ?>
		<?php if(bymt_c('weibo')): ?>
		<li><a href="<?php bymt('weibolink', 'u'); ?>" rel="external" target="_blank" class="icons-wb" title="我的新浪微博"></a></li>
		<?php endif; ?>
		<?php if(bymt_c('rss')): ?>
		<li><a href="<?php bloginfo('rss2_url'); ?>" rel="external" target="_blank" class="icons-rss" title="RSS订阅"></a></li>
		<?php endif; ?>
        <?php if(bymt_c('emailrss')): ?>
		<li><a href="<?php bymt('emailrsslink', 'u'); ?>" rel="external" target="_blank" class="icons-em" title="邮件订阅"></a></li>
		<?php endif; ?>
		<?php if(bymt_c('weixin')): ?>
		<li class="weixin"><a href="javascript:;" title="关注我的微信" class="icons-wx"><b><span></span><i><img src="<?php bymt('weixinimg', 'u'); ?>" alt="微信" /></i></b></a></li>
		<?php endif; ?>
	</ul>
</div>
<?php } ?>
</div>
<?php if(bymt_c('sd_config_bul_ck')){ bymt_slides('bul','1060','120'); } ?>
