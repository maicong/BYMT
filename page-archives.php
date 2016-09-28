<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.5
 */

/****************
Template Name: Archives(文章归档)
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
<?php echo $hacklog_archives->PostList();?>
                    </div>
            </div>
            <div class="comments">
			<?php comments_template(); ?>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
		<script type="text/javascript">
		/* <![CDATA[ */
			jQuery(document).ready(function() {
				jQuery('.arc-collapse').find('h4').click(function() {
					jQuery(this).next('ul').slideToggle('fast');
				});
			});
		/* ]]> */
</script>
    </div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
