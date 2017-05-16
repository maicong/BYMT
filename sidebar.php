<?php !defined( 'WPINC' ) && exit();
/**
 * sidebar.php
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<?php if ( bymt_option( 'sidebar' ) ): ?>
<aside id="sidebar" class="sidebar<?php echo bymt_sidebar_class( true ); ?>" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
<?php if ( is_home() || is_front_page() ): ?>
    <?php if ( is_active_sidebar( 'bymt-sidebar-1' ) ) : ?>
        <?php dynamic_sidebar( 'bymt-sidebar-1' ); ?>
    <?php endif; ?> 
<?php else: ?>
    <?php if ( is_active_sidebar( 'bymt-sidebar-2' ) ) : ?>
        <?php dynamic_sidebar( 'bymt-sidebar-2' ); ?>
    <?php endif; ?>
<?php endif; ?>
</aside>
<?php endif; ?>