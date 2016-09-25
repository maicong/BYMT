<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/85
 * @version     1.0.4
 */

$options = get_option('bymt_options');
?>
<div id="sidebar">
<div id="closesidebar" title="关闭侧边栏"></div>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('侧边栏') ) : ?><?php endif; ?>
</div>
