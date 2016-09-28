<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	$array_posts = array();
	 if (have_posts()) : while (have_posts()) : the_post();
	 array_push($array_posts,array("title"=>get_the_title(),"url"=>get_permalink()));
	 endwhile; endif;
	 echo json_encode($array_posts);
	 }else{
		 get_header();
?>
<div id="content-wrap">
	<div id="content-list">
		<?php if(bymt_c('indexad1')): ?>
		<div id="adsense1">
			<div id="adsense-loader1" style="display:none;">
				<?php bymt('indexadcode1'); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if(bymt_c('sd_config_lis_ck')){ bymt_slides('lis','760','210'); } ?>
		<?php get_template_part('loop'); ?>
		<?php if(bymt_c('indexad2')): ?>
		<div id="adsense2">
			<div id="adsense-loader2" style="display:none;">
				<?php bymt('indexadcode2'); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php bymt_pagenav(); ?>
	</div>
	<?php if ( !wp_is_mobile() ){ get_sidebar(); } ?>
</div>
<?php get_footer(); } ?>
