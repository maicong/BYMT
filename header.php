<?php !defined( 'WPINC' ) && exit();
/**
 * header.php
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/Blog">
<head prefix="og: http://ogp.me/ns#">
<meta charset="UTF-8">
<meta http-equiv="cleartype" content="on">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<title><?php wp_title( bymt_define( 'delimiter', '|' ), true, 'right' ); ?></title>
<meta name="author" content="MaiCong (maicong.me)">
<meta name="renderer" content="webkit">
<meta name="applicable-device" content="pc, mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
<meta name="description" content="<?php echo bymt_description(); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php echo bymt_favicon(); ?>">
<?php wp_head(); ?>
<!--[if lt IE 9]>
    <script src="<?php echo bymt_static('js/html5shiv.min.js'); ?>"></script>
    <script src="<?php echo bymt_static('js/respond.min.js'); ?>"></script>
<![endif]-->
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<!--[if lt IE 9]>
<div id="fuck-ie" class="fuck-ie">
    <h2>您的浏览器太LOW，请升级！</h2>
    <h2>您的浏览器太LOW，请升级！</h2>
    <h2>您的浏览器太LOW，请升级！</h2>
    <p>重要的话说三遍，您的浏览器版本真的真的真的LOW！请升级！！</p>
</div>
<![endif]-->
<header id="bymt-header" class="bymt-header<?php echo bymt_output( 'header_nav_fixed', ' fixed' ); ?>" role="banner">
    <div class="container">
        <h1 class="head-logo"><?php echo bymt_logo( 'header' ); ?></h1>
        <a href="#" id="head-menu-toggle" class="head-menu-toggle not-select" aria-hidden="false"><i class="iconfont icon-menu"></i></a>
        <nav id="head-menu" class="head-menu" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <?php echo str_replace( 'sub-menu', 'sub-menu transition3', wp_nav_menu( array( 'echo' => false, 'theme_location' => 'header', 'menu_id' => 'head-nav-menu', 'menu_class' => 'nav-menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ) ); ?>
        </nav>
        <form id="head-search" class="head-search transition3" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
            <a class="iconfont icon-search"></a>
            <input id="search-input" class="keywords" data-nonce="<?php echo bymt_ajax( 'search' ); ?>" data-ajax-load="<?php echo bymt_define( 'ajax_search_load', __( '正在搜索，请稍候 ...' ) ); ?>" data-ajax-null="<?php echo bymt_define( 'ajax_search_null', __( '抱歉，没有找到您要搜索的内容。' ) ); ?>" maxlength="50" type="text" name="s" placeholder="<?php echo bymt_define( 'search_text', __( 'Search...' ) ); ?>">
        </form>
    </div>
</header>
<?php echo bymt_bulletin( 'header' ); ?>
<?php echo bymt_slider( 'header' ); ?>
