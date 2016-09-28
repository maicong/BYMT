<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version 	1.0.5
 */
?>
<div class="thumbnail_box">
	<div class="thumbnail">
		<?php if ( get_post_meta($post->ID, 'wailianimg', true) ) : ?>
		<?php $image = get_post_meta($post->ID, 'wailianimg', true); ?>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><img src="<?php echo $image; ?>" onerror="javascript:this.src='<?php bloginfo('template_directory');?>/images/images_error.jpg'" alt="<?php the_title(); ?>"/></a>
		<?php else: ?>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
		<?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail'); } else { ?>
		<img src="<?php echo BYMT_catch_first_image() ?>" onerror="javascript:this.src='<?php bloginfo('template_directory');?>/images/images_error.jpg'" width="140px" height="100px" alt="<?php the_title(); ?>"/>
		<?php } ?>
		</a>
		<?php endif; ?>
	</div>
</div>
