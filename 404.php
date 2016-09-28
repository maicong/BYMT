<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version 	1.0.5
 */

get_header();
?>
<div id="content_wrap" class="container">
	<div id="errorBox">
		<h1><span>请允许我做一个悲伤的表情</span><img src="http://ww2.sinaimg.cn/mw690/67f51f75gw1e6gq5ifxh2g208004gk71.gif" alt="请允悲" width="288" height="160" style="display:block"/></h1>
		<div id="errorSummary">
			<p>您访问的页面不小心被系统酱玩(bù)丢(cún)了(zài)！<br />
				The requested URL was not found on the server.</p>
			<p>如果您是手动输入，请检查您的输入是否正确，然后再F5一次！<br />
				If you entered the URL manually please check your spelling and try again.</p>
		</div>
		<div id="errorDetails"><strong>错误 404</strong> (url::<?php echo strtoupper(wcs_error_currentPageURL()); ?>)：就是找不到鸟你来咬我啊</div>
	</div>
</div>
<div id="randBox" class="container">
	<?php include_once('includes/related.php'); ?>
</div>
<?php get_footer(); ?>
