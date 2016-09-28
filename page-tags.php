<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */

/****************
Template Name: Tags(标签云集)
****************/

get_header();
?>
    <div id="content_wrap">
    <div id="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
            <div class="excerpt">
             <div class="context">
			 	<h2><?php the_title(); ?></h2>
				<p style="text-align:center;">目前共有<?php echo $count_tags = wp_count_terms('post_tag'); ?>个标签</p>
				<ul class="tag-clouds">
				<?php
				$tags = get_tags ();
				if($tags) {
				foreach ( $tags as $tag )
					echo '<li><a title="标签 '.$tag->name.' 下共有'.$tag->count.'篇文章" class="tag-link tag-link-'.$tag->term_id.'" href="' . get_tag_link($tag) . '">' . $tag->name .'</a><strong style="color:#67A611;"> x '.$tag->count.'</strong></li>';
				} ?>
				</ul>
            </div>
            </div>
			<div class="comments">
			<?php comments_template(); ?>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
