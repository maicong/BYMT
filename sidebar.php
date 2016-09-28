<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */
?>
<div id="sidebar">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('侧边栏一(全局)') ) : ?>
	<?php endif; ?>
	<?php if ( is_singular() ): ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('侧边栏二(内页)') ) : ?>
	<?php endif; ?>
	<?php else: ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('侧边栏三(非内页)') ) : ?>
	<?php endif; ?>
	<?php endif; ?>
</div>
