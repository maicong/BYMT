<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="imgbox">
	<p class="ptitle"><?php the_title(); ?></p>
	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>" >
		<?php echo bymt_thumbnails('257','',false); ?>
	</a>
	<p class="imgbox-info">
		<span class="ptime"><i class="icon-calendar"></i> <?php bymt_time_diff( $time_type = 'post' ); ?></span>
		<?php if(bymt_c('postinfoviews')): ?><span class="pview"><i class="icon-pass"></i><?php if (function_exists('the_views')){ the_views(); } ?></span><?php endif; ?>
		<span class="pcomm"><i class="icon-comment"></i> <?php comments_popup_link ('抢沙发','1评论','%评论'); ?></span>
	</p>
</div>
<?php endwhile; endif; ?>
