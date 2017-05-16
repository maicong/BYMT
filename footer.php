<?php !defined( 'WPINC' ) && exit();
/**
 * footer.php
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<footer id="bymt-footer" class="bymt-footer" role="contentinfo">
    <?php if ( bymt_option( 'footer_nav' ) ): ?>
    <div class="foot-nav">
        <div class="container clearfix">
            <div class="foot-logo"><?php echo bymt_logo('footer'); ?></div>
            <nav class="foot-menu" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    <?php if ( bymt_option( 'footer_widget' ) ): ?>
    <div id="foot-widget" class="foot-widget">
        <div class="container clearfix">
        <?php if ( is_singular() ): ?>
            <?php if ( is_active_sidebar( 'bymt-footbar-2' ) ) : ?>
                <?php dynamic_sidebar( 'bymt-footbar-2' ); ?>
            <?php endif; ?> 
        <?php else: ?>
            <?php if ( is_active_sidebar( 'bymt-footbar-1' ) ) : ?>
                <?php dynamic_sidebar( 'bymt-footbar-1' ); ?>
            <?php endif; ?>
        <?php endif; ?>      
        </div>
    </div>
    <?php endif; ?>
    <div id="foot-copr" class="foot-copr">
        <div class="container clearfix"><?php echo bymt_copyright(); ?></div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>