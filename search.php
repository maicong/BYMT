<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */

get_header();
?>
    <div id="content_wrap">
    <div id="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
            <?php
                $title = get_the_title();
                $content = mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 400,"...",'utf-8');
				$s = str_replace("+","",$s);
				$s = str_replace("/","",$s);
				$s = str_replace("\\","",$s);
                $keys = explode(" ",$s);
                $title = preg_replace('/('.implode('|', $keys) .')/iu','<span style="color:#f03;text-decoration:underline;">\0</span>',$title);
                $content = preg_replace('/('.implode('|', $keys) .')/iu','<span style="color:#f03;text-decoration:underline;">\0</span>',$content);
			?>
            <ul <?php post_class(); ?> id="post-<?php the_ID(); ?>"><li>
            <div class="excerpt">
					<?php $t1=$post->post_date;$t2=date("Y-m-d H:i:s");$diff=(strtotime($t2)-strtotime($t1))/3600;if($diff<24){echo '<span class="new"></span>';} ?><h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php if(is_sticky()) : ?><?php echo '<img src="'.get_bloginfo('template_directory').'/images/sticky.gif" alt="" /> <span style="color:red;">[置顶]</span> '; ?><?php endif; ?><?php the_title(); ?></a></h2>
				<div class="info">
					<?php if(bymt_option('postauthor')) : ?><span class="pauthor"><?php the_author() ?></span><?php endif; ?>
					<span class="ptime"><?php BYMT_time_diff( $time_type = 'post' ); ?></span>
					<span class="pcata"><?php the_category(', ') ?></span>
					<?php if(bymt_option('postinfoviews')): ?><span class="pview"><?php if (function_exists('the_views')): ?><?php the_views(); ?><?php endif; ?></span><?php endif; ?>
					<span class="pcomm"><?php comments_popup_link ('抢沙发','1条评论','%条评论'); ?></span>
					<span><?php edit_post_link('编辑'); ?></span>
				</div>
					<?php if(bymt_option('thumbnail')) : ?><?php include('includes/thumbnail.php'); ?><?php endif; ?>
				<div class="entry">
					<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 400,"...",'utf-8'); ?>
				</div>
				<div class="clear"></div>
				<div class="tagandmore">
					<?php if(bymt_option('txttag')): ?><?php BYMT_tags(); ?><?php endif; ?>
					<span class="readmore"><a href="<?php the_permalink() ?>" rel="nofollow">阅读全文</a></span>
				</div>
				</div>
            </li></ul>
            <?php endwhile; ?>
            <?php else: ?>
			 <div class="excerpt">
                <h2 style="text-align:center;">抱歉，没有找到你要搜索的内容！</h2>
			 </div>
        <?php endif; ?>
	<div class="navigation">
		<div class="pagination"><?php BYMT_pagination(6); ?></div>
	</div>
    </div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
