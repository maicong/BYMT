<?php !defined( 'WPINC' ) && exit();
/**
 * index.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
do_action( 'bymt_post_pjax' );
get_header();
?>
<section class="bymt-main" role="main">
    <?php echo bymt_breadcrumbs( 'container' ); ?>
    <?php echo bymt_advert( 'ad_home_header' ); ?>
    <div class="container article<?php echo bymt_sidebar_class(); ?> clearfix">
        <div id="main-section" class="post-list">
            <?php echo bymt_advert( 'ad_home_list_top' ); ?>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php $new_post = is_new_post(); post_class( $new_post. ' archive' ); ?> itemscope itemtype="http://schema.org/BlogPosting" role="article">
                    <?php bymt_include_post_format(); ?>
                </article>
            <?php endwhile; ?>
                <div id="post-pagenavi" class="pagination"><?php echo bymt_pagenavi(); ?></div>
            <?php else : ?>
                <p>您还没有发过文章呢</p>
            <?php endif; ?>
            <?php echo bymt_advert( 'ad_home_list_bottom' ); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php echo bymt_advert( 'ad_home_footer' ); ?>
</section>
<?php get_footer(); ?>
