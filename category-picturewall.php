<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version 	1.0.5
 */

get_header();
?>
<div class="margin10">
	<div id="content_wrap" class="container">
		<div id="imgbox_content">
			<?php $posts = query_posts($query_string . '&orderby=date&showposts=20'); ?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php if ( has_post_format( 'image' )){ ?>
			<div class="imgbox">
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>" >
				<?php if ( get_post_meta($post->ID, 'wailianimg', true) ) : ?>
				<?php $image = get_post_meta($post->ID, 'wailianimg', true); ?>
				<img class="pic-img" src="<?php echo $image; ?>" alt="<?php the_title(); ?>"/>
				<?php elseif( has_post_thumbnail() ): ?>
				<?php the_post_thumbnail(array( 257, 170 ),array('class'=>'pic-img'));?>
				<?php elseif(BYMT_catch_first_image()) : ?>
				<img class="pic-img" src="<?php echo BYMT_catch_first_image()?>" alt="<?php the_title(); ?>"/>
				<?php else : ?>
				<img class="pic-img" src="<?php bloginfo('template_url'); ?>/images/random/BYMT<?php echo rand(1,20)?>.jpg" alt="<?php the_title(); ?>" />
				<?php endif;?>
				<span class="imgtitle"><?php the_title(); ?></span>
				</a>
				<div class="imgbox-section">
				<span class="ptime"><?php BYMT_time_diff( $time_type = 'post' ); ?></span>
				<?php if(bymt_option('postinfoviews')): ?><span class="pview"><?php if (function_exists('the_views')): ?><?php the_views(); ?><?php endif; ?></span><?php endif; ?>
				<span class="pcomm"><?php comments_popup_link ('沙发','1条','%条'); ?></span>
				</div>
			</div>
			<?php } ?>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<div class="line"></div>
		<div class="navigation">
			<div class="pagination">
				<?php BYMT_pagination(6); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
