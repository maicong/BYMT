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
<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php
	$title = get_the_title();
	$post_excerpt = trim( preg_replace( '/((\s)*(\n)+(\s)*)/i', '', strip_tags( $post->post_content ) ) );
	$post_excerpt = preg_replace('/\[reply\](.*?)\[\/reply\]/i',' *温馨提示：此处内容需要您评论本文后才能查看！',$post_excerpt);
	$post_excerpt = preg_replace('/\[login\](.*?)\[\/login\]/i',' *温馨提示：此处内容需要您登录后才能查看！ ',$post_excerpt);
	$post_excerpt = preg_replace('/\[[\/\w\s\="链接标题]*\]/i','',$post_excerpt);
	$content = wp_trim_words($post_excerpt, 200);
?>
	<div class="post-list">
		<?php if(is_new_post()){ echo '<span class="post-new"></span>'; }elseif(is_sticky()){ echo '<span class="post-sticky"></span>'; } ?>
		<div class="post-header">
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php echo $title; ?></a></h2>
		</div>
		<div class="post-meta">
			<span class="pauthor"><i class="icon-user-add"></i><?php the_author_posts_link(); ?></span>
			<span class="ptime"><i class="icon-calendar"></i><?php bymt_time_diff( $time_type = 'post' ); ?></span>
			<span class="pcate"><i class="icon-category"></i><?php the_category(', '); ?></span>
			<?php if(bymt_c('postinfoviews')): ?><span class="pview"><i class="icon-pass"></i><?php if (function_exists('the_views')){ the_views(); } ?></span><?php endif; ?>
			<span class="pcomm"><i class="icon-chat"></i><?php comments_popup_link('抢沙发','1条评论','%条评论'); ?></span>
			<?php edit_post_link('编辑', '<span class="pedit"><i class="icon-edit"></i>', '</span>'); ?>
		</div>
		<div class="post-body">
			<?php if(bymt_c('thumbnail')): ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
					<?php echo bymt_thumbnails(140,100,true,true); ?>
				</a>
			</div>
			<?php endif; ?>
			<div class="post-excerpt">
				<?php echo $content; ?>
			</div>
		</div>
		<div class="post-footer">
			<div class="tags" >
				<?php if(bymt_c('txttag')): ?><i class="icon-tags"></i> 	<?php bymt_tags(); ?><?php endif; ?>
			</div>
			<div class="readmore">
				<a href="<?php the_permalink() ?>" rel="bookmark">阅读全文 &raquo;</a>
			</div>
		</div>
	</div>
</div>
<?php endwhile; else: ?>
<div class="post-error">
	<div class="post-header">
		<?php if (is_search()): ?>
		<h2 class="post-title">抱歉，没有找到你要搜索的内容！</h2>
		<?php else: ?>
		<h2 class="post-title">抱歉，这里还木有文章！</h2>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
