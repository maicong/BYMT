<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/119
 * @version     2.1.2
 */

if(isset($_GET["action"]) && $_GET["action"] == "ajax_posts"){
	nocache_headers();
	get_template_part('loop');
	bymt_pagenav();
}else{
	get_header(); ?>
<div id="content-wrap">
	<div id="content-list">
		<?php if(bymt_c('categoryad1')): ?>
		<div id="adsense3">
			<div id="adsense-loader3" style="display:none;">
				<?php bymt('categoryadcode1'); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if(bymt_c('sd_config_lis_ck')){ bymt_slides('lis','760','210'); } ?>
		<?php get_template_part('loop'); ?>
		<?php if(bymt_c('categoryad2')): ?>
		<div id="adsense4">
			<div id="adsense-loader4" style="display:none;">
				<?php bymt('categoryadcode2'); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php bymt_pagenav(); ?>
	</div>
	<?php if ( !wp_is_mobile() ){ get_sidebar(); } ?>
</div>
<?php get_footer(); } ?>
