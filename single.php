<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */
?>
<?php get_header(); ?>
<div id="content-wrap">
	<div id="content-main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post-single">
			<?php if(is_new_post()){ echo '<span class="post-new"></span>'; }elseif(is_sticky()){ echo '<span class="post-sticky"></span>'; } ?>
			<div class="post-header">
				<h2 class="post-title"><?php the_title(); ?></h2>
			</div>
			<div class="post-meta">
			<?php if ( !wp_is_mobile() ) { ?>
				<ul class="resizer">
					<li id="f_s"><a href="javascript:;" title="缩小字体">小</a></li>
					<li id="f_m"><a href="javascript:;" title="默认字体">中</a></li>
					<li id="f_l"><a href="javascript:;" title="加大字体">大</a></li>
					<?php if(bymt_c('close_sidebar')): ?><li id="f_c"><a href="javascript:;" title="关闭侧边栏"><i class="icon-stop"></i></a></li><?php endif; ?>
					<?php if(bymt_c('open_sidebar')): ?><li id="f_o"><a href="javascript:;" title="打开侧边栏"><i class="icon-pause"></i></a></li><?php endif; ?>
				</ul>
				<?php } ?>
				<span class="pauthor"><i class="icon-user-add"></i><?php the_author_posts_link(); ?></span>
				<span class="ptime"><i class="icon-calendar"></i><?php bymt_time_diff( $time_type = 'post' ); ?></span>
				<span class="pcate"><i class="icon-category"></i><?php the_category(', ') ?></span>
				<?php if(bymt_c('postinfoviews')): ?><span class="pview"><i class="icon-pass"></i><?php if (function_exists('the_views')){ the_views(); } ?></span><?php endif; ?>
				<span class="pcomm"><i class="icon-chat"></i><?php comments_popup_link('抢沙发','1条评论','%条评论'); ?></span>
				<?php edit_post_link('编辑', '<span class="pedit"><i class="icon-edit"></i>', '</span>'); ?>
			</div>
				<?php if(bymt_c('txtad1')): ?>
				<div id="adsense5">
					<div id="adsense-loader5" style="display:none;">
						<?php bymt('txtadcode1'); ?>
					</div>
				</div>
				<?php endif; ?>
				<div class="post-content">
					<?php the_content('Read more...'); ?>
					<?php wp_link_pages(array('before' => '<div class="fanye">翻页继续：', 'after' => '</div>', 'next_or_number' => 'number','link_before' =>'<span>', 'link_after'=>'</span>')); ?>
				</div>
                <?php if(bymt_c('txtad2')): ?>
				<div id="adsense6">
					<div id="adsense-loader6" style="display:none;">
						<?php bymt('txtadcode2'); ?>
					</div>
				</div>
				<?php endif; ?>
                <div class="post-footer">
                <?php if(bymt_c('txttag') || bymt_c('txtshare')): ?>
				<div class="post-tagsshare">
                	<?php if(bymt_c('txttag')): ?>
					<div class="post-tags">
						<i class="icon-tags"></i> <?php bymt_tags(); ?>
					</div>
                    <?php endif; ?>
                    <?php if(bymt_c('txtshare') && !wp_is_mobile()): ?>
					<div class="post-share">
						<i class="icon-share"></i> <?php bymt_txt_share(); ?>
					</div>
                    <?php endif; ?>
				</div>
                <?php endif; ?>
				<?php if(bymt_c('txtcopyright') && !wp_is_mobile()): ?>
				<div class="post-copyright">
					<div id="author-avatar"><?php echo bymt_avatar( get_the_author_meta('email'), '42' ); ?></div>
					<div id="copy-info">
					<span id="copy-arrow"><span></span></span>
					<?php if(bymt_c('txtcopyright')): $custom = get_post_custom(get_the_ID()); if(isset($custom['copyright'])) { $custom_value = $custom['copyright']; } ?>
					<?php if(empty($custom_value)): ?>
						<p><strong>版权声明：</strong>本文由( <?php the_author_posts_link(); ?> )原创，转载请保留文章出处！</p>
						<p><strong>本文链接：</strong><a class="copy-link-1" href="<?php the_permalink(); ?>" title=<?php the_permalink(); ?>><?php the_permalink(); ?></a></p>
					<?php else: ?>
						<p><strong>版权声明：</strong>本文参考自 <a class="copy-link-2" href="<?php echo $custom_value[0]; ?>" title="<?php echo $custom_value[0]; ?>" target="_blank" rel="external nofollow"><?php echo $custom_value[0]; ?></a>，由 <?php the_author_posts_link(); ?> 整编。</p>
						<p><strong>本文链接：</strong><a class="copy-link-3"href="<?php the_permalink(); ?>" title=<?php the_permalink(); ?>><?php the_permalink(); ?></a>，尊重共享，欢迎转载！ </p>
					<?php endif; ?>
					<?php endif; ?>
					</div>
					<?php if(bymt_c('baidulike')): ?>
					<div class="post-like"><?php bymt_baidulike(); ?></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
                <?php if(bymt_c('txtrelated') && !wp_is_mobile()): ?>
					<?php get_template_part('functions/bymt-related'); ?>
				<?php endif; ?>
				<?php if(bymt_c('txtnext')): ?>
				<div class="post-navigation">
					<div class="post-previous">
						<?php previous_post_link( '%link', '<span>'. __( '上一篇' ).'</span> %title' ); ?>
					</div>
					<div class="post-next">
						<?php next_post_link( '%link', '<span>'. __( '下一篇' ).'</span> %title' ); ?>
					</div>
				</div>
				<?php endif; ?>
                </div>
			<?php comments_template(); ?>
		</div>
		<?php endwhile; endif; ?>
	</div>
	<?php if ( !wp_is_mobile() ){ get_sidebar(); } ?>
</div>
<?php get_footer(); ?>
