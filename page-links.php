<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version     1.0.5
 */

/****************
Template Name: Links(友情链接)
****************/

get_header();
?>
<div id="content_wrap">
	<div id="content">
	<?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>
	<div class="excerpt">
			<div class="context">
				<div class="Mylinks">
					<ul>
						<?php wp_list_bookmarks('orderby=id&category_orderby=id'); ?>
					</ul>
				</div>
				<div class="clear"></div>
				<div class="linkstandard">
					<ul>
						<li>欢迎贵站申请友情链接，本站不要求贵站PV多少、IP多少、PR多少、BR多少，只要诚信友链，哈哈，一并通过；</li>
						<li>前提是：贵站没有违反China各项法律、法规的内容，没有违背社会道德之内容，并且贵站属于博客性质;</li>
						<li>本博名称：
							<?php bloginfo('name'); ?>
						</li>
						<li>本博地址：
							<?php bloginfo('url'); ?>
						</li>
						<li>一句话介绍：
							<?php bloginfo('description'); ?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="comments">
			<?php comments_template(); ?>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
	<script type="text/javascript">
jQuery(document).ready(function($){
$(".Mylinks ul ul li a").each(function(e){
	$(this).prepend("<img src=http://g.etfv.co/"+this.href.replace(/^(http:\/\/[^\/]+).*$/, '$1').replace( '$1', 'http://$1' )+" onerror=javascript:this.src='../wp-content/themes/BYMT/images/link-default.png' style=float:left;margin:3px;width:16px;height:16px;>");
});
});
</script>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
