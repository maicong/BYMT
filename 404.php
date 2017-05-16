<?php !defined( 'WPINC' ) && exit();
/**
 * 404.php
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
get_header();
?>
<section class="bymt-main" role="main">
    <?php echo bymt_breadcrumbs( 'container' ); ?>
    <?php echo bymt_advert( 'ad_singular_header' ); ?>
    <div class="container clearfix">
        <section id="main-section" class="error-page">
            <header class="post-header">
                <h2 class="post-title"><?php _e( '404 Not Found' ); ?></h2>
            </header>
            <section class="post-content">
                <p>抱歉，您访问的资源不存在或者已失效！</p>
                <p>&nbsp;</p>
                <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">&laquo; 返回首页</a></p>
            </section>
        </section>
    </div>
    <?php echo bymt_advert( 'ad_singular_footer' ); ?>
</section>
<?php get_footer(); ?>