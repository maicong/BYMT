<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

/****************
Template Name: Tags(标签页)
****************/
?>
<?php get_header(); ?>
    <div id="content-wrap">
    <div id="content-main">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="post-single">
             <div class="post-content">
			 	<h2><?php the_title(); ?></h2>
				<?php the_content('Read more...'); ?>
				<p style="text-align:center;">目前共有<?php echo $count_tags = wp_count_terms('post_tag'); ?>个标签</p>
				<ul class="tag-clouds">
				<?php
				$tags = get_tags ();
				if($tags) {
				foreach ( $tags as $tag )
					echo '<li><i class="icon-tags"></i> <a title="标签 '.$tag->name.' 下共有'.$tag->count.'篇文章" class="tag-link tag-link-'.$tag->term_id.'" href="' . get_tag_link($tag) . '">' . $tag->name .'</a><strong style="color:#67A611;"> x '.$tag->count.'</strong></li>';
				} ?>
				</ul>
            </div>
            </div>
			<?php comments_template(); ?>
            <?php endwhile; endif; ?>
    </div>
<?php if ( !wp_is_mobile() ){ get_sidebar(); } ?>
</div>
<?php get_footer(); ?>
