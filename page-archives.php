<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

/****************
Template Name: Archives(文章归档)
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
				<?php echo $bymt_archives->PostList();?>
                </div>
            </div>
		<?php comments_template(); ?>
        <?php endwhile; endif; ?>
		<script type="text/javascript">
		/* <![CDATA[ */
			jQuery(document).ready(function($) {
				$('.arc-collapse').find('h4').click(function() {
					$(this).next('ul').slideToggle('fast');
				});
			});
		/* ]]> */
		</script>
    </div>
<?php if ( !wp_is_mobile() ){ get_sidebar(); } ?>
</div>
<?php get_footer(); ?>
