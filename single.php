<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version     1.0.5
 */

$options = get_option('bymt_options');
get_header();
?>
<div id="content_wrap">
	<div id="content">
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="excerpt">
			<h2><?php the_title(); ?></h2>
			<div class="meta_info">
				<ul id="resizer">
					<li id="f_s"><a href="javascript:void(0)">小</a></li>
					<li id="f_m"><a href="javascript:void(0)">中</a></li>
					<li id="f_l"><a href="javascript:void(0)">大</a></li>
				</ul>
				<?php if(bymt_option('postauthor')) : ?><span class="pauthor"><?php the_author() ?></span><?php endif; ?>
				<span class="ptime"><?php BYMT_time_diff( $time_type = 'post' ); ?></span>
				<span class="pcata"><?php the_category(', ') ?></span>
				<?php if(bymt_option('postinfoviews')): ?><span class="pview"><?php if (function_exists('the_views')): ?><?php the_views(); ?><?php endif; ?></span><?php endif; ?>
				<span class="pcomm"><?php comments_popup_link ('抢沙发','1条评论','%条评论'); ?></span>
				<?php edit_post_link('编辑', ' [ ', ' ] '); ?>
			</div>
			<div class="clear"></div>
			<div class="context">
				<?php if(bymt_option('txtad1')): ?>
				<div id="adsense3" style="display:none;margin-bottom:10px;">
					<div id="adsense-loader3" style="display:none; text-align:center">
						<?php echo stripslashes(bymt_option('txtadcode1')); ?>
					</div>
				</div>
				<?php endif; ?>
                    <?php the_content('Read more...'); ?>
				<?php wp_link_pages(array('before' => '<div class="fanye">翻页继续：', 'after' => '</div>', 'next_or_number' => 'number','link_before' =>'<span>', 'link_after'=>'</span>')); ?>
				<div class="cut_line"><span>正文部分到此结束</span></div>
				<?php if(bymt_option('txtad2')): ?>
				<div id="adsense4" style="display:none;margin:10px 0;">
					<div id="adsense-loader4" style="display:none; text-align:center">
						<?php echo stripslashes(bymt_option('txtadcode2')); ?>
					</div>
				</div>
				<?php endif; ?>
				<?php if(bymt_option('txtcopyright')||bymt_option('txttag')||bymt_option('txtshare')): ?>
					<div class="post_copyright">
					<?php if(bymt_option('txtcopyright')): ?>
                	<?php $custom = get_post_custom($post->ID); ?>
					<?php if (empty($custom['copyright'])) : ?>
						<strong>版权声明:</strong>除非注明，本文由(<a href="<?php bloginfo('url'); ?>"><?php the_author(); ?></a>)原创，转载请保留文章出处！<br>
						<strong>本文链接:</strong><a href="<?php the_permalink()?>" title=<?php the_title(); ?>><?php the_permalink()?></a>
					<?php else: ?>
					<strong>版权声明:</strong>本文参考自<a target="_blank" rel="external nofollow" href="<?php echo $custom['copyright'][0] ?>"><?php echo $custom['copyright'][0] ?></a>，由(<a href="<?php bloginfo('home'); ?>"><?php the_author(); ?></a>) 整编。<br>
					<strong>本文链接:</strong><a href="<?php the_permalink()?>" title=<?php the_title(); ?>><?php the_permalink()?></a>，尊重共享，欢迎转载！
					<?php endif; ?>
					<?php endif; ?>
					<?php if(bymt_option('txttag')): ?><p>继续浏览:<?php BYMT_tags(); ?></p><?php endif; ?>
					<?php if(bymt_option('txtshare')): ?><?php BYMT_txt_share(); ?><?php endif; ?>
					</div>
                <?php endif; ?>
				<?php if(bymt_option('txtrelated')): ?>
					<ul class="post-related">
					<?php
					$post_num = bymt_option('txtrelatednum');
					$exclude_id = $post->ID;
					$posttags = get_tags(); $i = 0;
					if ( $posttags ) { $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
					$args = array(
					'post_status' => 'publish',
					'tag_slug__in' => explode(',', $tags),
					'post__not_in' => explode(',', $exclude_id),
					'caller_get_posts' => 1,
					'orderby' => 'rand',
					'posts_per_page' => $post_num
					);
					query_posts($args);
					while( have_posts() ) { the_post(); ?>
					<li><span style="float:right;padding-right:15px;"><?php the_time('m-d') ?></span><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo BYMT_cut_str($post->post_title,60); ?></a> <small>(<?php if(function_exists(the_views)) { the_views();}?> <?php comments_popup_link ('抢沙发','1条评论','%条评论'); ?>)</small></li>
					<?php
					$exclude_id .= ',' . $post->ID; $i ++;
					} wp_reset_query();
					}
					if ( $i  == 0 )  echo '<li>暂无相关文章</li>';
					?>
					</ul>
				<?php endif; ?>
				<?php if(bymt_option('txtnext')): ?>
				<div class="post-navigation">
					<div class="post-previous">
						<?php previous_post_link( '%link', '<span>'. __( '上一篇:', 'tie' ).'</span> %title' ); ?>
					</div>
					<div class="post-next">
						<?php next_post_link( '%link', '<span>'. __( '下一篇:', 'tie' ).'</span> %title' ); ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="comments">
				<?php comments_template(); ?>
			</div>
		</div>
		<?php endwhile; else: ?>
		<?php endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
