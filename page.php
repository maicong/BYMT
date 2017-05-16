<?php !defined( 'WPINC' ) && exit();
/**
 * page.php
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
if ( bymt_is_pjax() && ( comments_open() || get_comments_number() ) ) {
    comments_template();
    exit();
}
get_header();
?>
<section class="bymt-main" role="main">
    <?php echo bymt_breadcrumbs( 'container' ); ?>
    <?php echo bymt_advert( 'ad_singular_header' ); ?>
    <div class="container article<?php echo bymt_sidebar_class(); ?> clearfix">
        <section id="main-section" class="single-page">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" role="article">
                <?php while ( have_posts() ) : the_post(); ?>
                    <header class="post-header">
                        <h2 class="post-title page-title" itemprop="headline"><?php the_title(); ?></h2>
                    </header>
                    <section class="post-content page-content" itemprop="about">
                        <?php echo bymt_advert( 'ad_singular_top' ); ?>
                        <?php the_content( 'Read more...' ); ?>
                        <?php wp_link_pages( array(
                            'before' => '<div class="pagination">',
                            'after' => '</div>',
                            'separator' => '',
                            'pagelink' => '<span>%</span>',
                        ) ); ?>
                        <?php echo bymt_advert( 'ad_singular_bottom' ); ?>
                    </section>
                <?php endwhile; ?>
            </article>
            <?php if ( comments_open() || get_comments_number() ) : ?>
            <div id="comments" class="comments" itemscope itemtype="http://schema.org/Comment">
                <?php comments_template(); ?>
            </div>
            <?php endif; ?>
        </section>
        <?php get_sidebar(); ?>
    </div>
    <?php echo bymt_advert( 'ad_singular_footer' ); ?>
</section>
<?php get_footer(); ?>