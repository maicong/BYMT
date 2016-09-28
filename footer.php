<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */
?>
<?php if ( wp_is_mobile() ): ?>
<div id="footersearch" class="container">
	<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
			<label class="screen-reader-text" for="s">搜索：</label>
			<input type="text" value="" name="s" id="s">
			<input type="submit" id="searchsubmit" value="搜索">
	</form>
</div>
<?php else: ?>
<?php if(bymt_c('custom_footerlink')): ?>
<div id="footerlink" class="container">
	<ul>
		<li><i class="icon-link-1"></i> <strong><?php bymt_r('footerlink_word','友情链接', 'e'); ?></strong></li>
		<?php wp_list_bookmarks('orderby=id&categorize=0&title_li=&limit=20');?>
	</ul>
</div>
<?php endif; endif; ?>
<div id="footer" class="container">
	<div class="copyright">
		<?php if(bymt_c('icp_ck')): ?><a href="http://www.miitbeian.gov.cn" target="_blank" rel="nofollow"><?php bymt('icp', 'e'); ?></a><?php endif; ?>
		<?php bymt_r('footer','&copy; 2012-2014 <a href="'.esc_url(home_url('/')).'" rel="index">'.esc_attr(get_bloginfo('name')).'</a> All Rights Reserved') ?>
	</div>
	<?php if ( !wp_is_mobile() ) { ?>
	<div class="themeauthor">Powered by <a href="http://wordpress.org" target="_blank" rel="license"><strong>WordPress</strong></a> Theme by <a href="https://github.com/maicong/BYMT/tree/v2" target="_blank" rel="license"><strong>BYMT v2</strong></a></div>
	<?php } ?>
	<div style="display:none">
	<?php if ( wp_is_mobile() ) { ?>
    	<?php if(bymt_c('wap_stat')){ bymt('wap_statcode'); } ?>
    <?php }else{ ?>
		<?php if(bymt_c('statistics')){ bymt('statisticscode'); } ?>
    <?php } ?>
	</div>
</div>
<?php if ( !wp_is_mobile() ) { ?>
<?php if(bymt_c('custom_circle')): ?>
<div id="circle"></div>
<div id="circletext">加载中</div>
<div id="circle1"></div>
<?php endif; ?>
<?php if(bymt_c('custom_gotop')): ?>
<div id="backtop"></div>
<?php endif; ?>
<?php } ?>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
