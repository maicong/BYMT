<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.4
 */
?>
<?php if(bymt_option('custom_footerlink')): ?>
<div id="footerlink" class="container" <?php if (is_singular() ) : ?> style="margin-top:0px"<?php endif; ?>>
	<ul>
	<li><strong><?php if(stripslashes(bymt_option('footerlink_word'))) : ?><?php echo stripslashes(bymt_option('footerlink_word'));?><?php else : ?>友来友往<?php endif; ?>：</strong></li>
<?php wp_list_bookmarks('orderby=id&categorize=0&title_li=&limit=20');?>
	</ul>
</div>
<?php endif; ?>
<div id="footer" class="container">
        <div class="copyright"><?php if(stripslashes(bymt_option('footer'))) : ?><?php echo stripslashes(bymt_option('footer'));?><?php else : ?>&copy; 2012-2013 <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> All Rights Reserved<?php endif; ?> <?php if(bymt_option('icp_ck')): ?><a href="http://www.miitbeian.gov.cn" target="_blank"><?php echo stripslashes(bymt_option('icp')); ?></a><?php endif; ?></div>
		<div class="themeauthor">Powered by <a href="http://wordpress.org/" target="_blank"><strong>WordPress</strong></a> Theme by <a href="https://maicong.me/t/85" target="_blank" title="麦田一根葱"><strong>BYMT</strong></a></div>
		 <div style="display:none"><?php if(bymt_option('statistics')) : ?><?php echo bymt_option('statisticscode'); ?><?php endif; ?> </div>
</div>
<?php if(bymt_option('custom_circle')): ?>
<div id="circle"></div>
<div id="circletext"></div>
<div id="circle1"></div>
<?php endif; ?>
<?php if(bymt_option('custom_gotop')): ?>
<div id="backtop"></div>
<?php endif; ?>
</div>
</div>
<?php if(bymt_option('lazyload')): ?>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/lazyload.js"></script>
<script type="text/javascript">
	jQuery(function() {
    	jQuery(".thumbnail img,.context p img").lazyload({
        	placeholder:"<?php bloginfo('template_url'); ?>/images/image-pending.gif",
            effect:"fadeIn"
          });
    	});
</script>
<?php endif; ?>
<?php if (bymt_option('lightbox_ck')) : ?>
<script type="text/javascript">$(function() {$("#content a[href*='.jpg'],a[href*='.png'],a[href*='.gif'],a[href*='.bmp'],a[href*='.jpeg']").lightBox({fixedNavigation:true});});</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/lightbox.js"></script>
<?php endif; ?>
<?php if(bymt_option('wpshare')): ?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/wpshare.js"></script>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
