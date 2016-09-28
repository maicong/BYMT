<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

// 每页显示20条
$posts = query_posts($query_string.'&orderby=date&showposts=20');
?>
<?php if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	get_template_part('loop-pic');
?>
	<div class="next_page"><?php bymt_pagenav('yes'); ?></div>
<?php }else{ get_header(); ?>
<div id="content-wrap" class="container">
	<div id="picturewall">
		<div id="pic-loading" class="loading"></div>
		<?php get_template_part('loop-pic'); ?>
	</div>
	<div class="imgover"></div>
	<div class="next_page"><?php bymt_pagenav('yes'); ?></div>
</div>
<?php get_footer(); } ?>
