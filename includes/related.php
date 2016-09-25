<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version 	1.0.4
 */
?>
<h1>你或许会对这些文章感兴趣</h1>
<ul class="post-related">
<?php
	$post_num = 12;
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
