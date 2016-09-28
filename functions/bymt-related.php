<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/119
 * @version     2.1.2
 */
?>
<div class="post-related">
	<ul>
		<?php
		$post_num = bymt_c('txtrelatednum')=="" ? 6 : bymt_c('txtrelatednum');
		$exclude_id = $post->ID;
		$posttags = get_tags(); $i = 0;
		if ( $posttags ) { $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
		$args = array(
		'post_status' => 'publish',
		'tag_slug__in' => explode(',', $tags),
		'post__not_in' => explode(',', $exclude_id),
		'ignore_sticky_posts' => 1,
		'orderby' => 'rand',
		'posts_per_page' => $post_num
		);
		query_posts($args);
		while( have_posts() ) { the_post(); ?>
		<li>
			<span class="time"><?php the_time('m-d') ?></span>
			<span class="title"><i class="icon-doc-text"></i> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $post->post_title; ?></a></span>
			<small  class="pcomm"><i class="icon-comment-1"></i> <?php comments_popup_link ('0','1','%'); ?></small>
		</li>
		<?php
		$exclude_id .= ',' . $post->ID; $i ++;
		} wp_reset_query();
		}
		if ( $i  == 0 )  echo '<li>暂无相关文章</li>';
		?>
	</ul>
</div>
