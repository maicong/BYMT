<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

/****************
Template Name: Link(友情链接)
****************/
?>
<?php get_header(); ?>
<div id="content-wrap">
	<div id="content-main">
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="post-single">
			<div class="post-content">
				<h2><?php the_title(); ?></h2>
				<?php the_content('Read more...'); ?>
				<div class="Mylinks">
					<ul>
						<?php wp_list_bookmarks('orderby=id&category_orderby=id&title_before=<h3>&title_after=</h3>'); ?>
					</ul>
				</div>
			</div>
		<?php comments_template(); ?>
        </div>
		<?php endwhile; endif; ?>
	</div>
	<script type="text/javascript">
	/* <![CDATA[ */
		jQuery(document).ready(function($){
			$(".Mylinks ul ul li a").each(function(e){
				var self = this,
					host = /htt(p|ps):\/\/([^\/\?\#]+)/ig.exec(this.href),
					fav = 'htt' + host[1] + '://"' + host[2] + '/favicon.ico',
					img = new Image();
				img.src = fav;
				img.onload = function () {
					$(self).prepend('<img src="' + fav + '"');
				};
				img.onerror = function () {
					$(self).prepend('<img src="' + '<?php echo TPLDIR . "/images/link-default.png"; ?>' + '"');
				};
			});
		});
	/* ]]> */
	</script>
	<?php if ( !wp_is_mobile() ){ get_sidebar(); } ?>
</div>
<?php get_footer(); ?>
