<?php !defined( 'WPINC' ) && exit();
/**
 * single.php
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
                        <h2 class="post-title" itemprop="headline"><?php the_title(); ?></h2>
                        <p class="post-meta"><?php echo bymt_post_meta(); ?></p>
                    </header>
                    <section class="post-content" itemprop="about">
                        <?php echo bymt_advert( 'ad_singular_top' ); ?>
                        <?php if (get_post_format() === 'quote' ): ?>
                            <div class="post-quote-icon"><i class="iconfont icon-quote"></i></div>
                            <div class="post-quote-content">
                                <blockquote><?php the_content('Read more...'); ?></blockquote>
                            </div>
                            <div class="post-full-thumb"><?php echo bymt_thumbnail( 840, 0, true, true ); ?></div>
                        <?php else: ?>
                            <?php the_content( 'Read more...' ); ?>
                        <?php endif; ?>
                        <?php wp_link_pages( array(
                            'before' => '<div class="pagination">',
                            'after' => '</div>',
                            'separator' => '',
                            'pagelink' => '<span>%</span>',
                        ) ); ?>
                        <?php echo bymt_advert( 'ad_singular_bottom' ); ?>
                    </section>
                    <footer class="post-footer">
                        <?php if ( bymt_option( 'post_tag' ) && get_the_tag_list() ): ?>
                            <div class="post-tags"><?php echo get_the_tag_list(); ?></div>
                        <?php endif; ?>
                        <?php if ( bymt_option( 'post_copyright' ) ): ?>
                        <div class="post-copr clearfix">
                            <div class="copr-avatar"><?php echo bymt_gravatar( get_the_author_meta('email'), '65', get_the_author() ); ?></div>
                            <div class="copr-author">
                                <h3 class="copr-head clearfix">
                                    <i class="iconfont icon-author"></i><?php the_author_posts_link(); ?>
                                    <?php if ( bymt_option( 'post_share' ) ): ?>
                                    <span class="copr-social"><?php echo bymt_post_social(); ?></span>
                                    <?php endif; ?>
                                </h3>
                                <?php if ( bymt_option( 'post_copyright_show_desc' ) ): ?>
                                <p class="copr-desc"><?php echo bymt_author_description(); ?></p>
                                <?php endif; ?>
                                <p><?php echo bymt_post_copyright(); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php echo bymt_post_relate(); ?>
                        <?php if ( bymt_option( 'post_nav' ) ): ?>
                        <div class="post-nav clearfix">
                            <div class="nav-prev">
                            <?php if ( get_previous_post_link() ): ?>
                            <?php previous_post_link( '%link', '<span class="nav-hold">'. __( '上一篇' ).'</span> %title' ); ?>
                            <?php else: ?>
                            <span class="nav-hold"><?php _e( '上一篇' ); ?></span><?php _e( '没有了' ); ?>
                            <?php endif; ?>
                            </div>
                            <div class="nav-next">
                            <?php if ( get_next_post_link() ): ?>
                            <?php next_post_link( '%link', '<span class="nav-hold">'. __( '下一篇' ).'</span> %title' ); ?>
                            <?php else: ?>
                            <span class="nav-hold"><?php _e( '下一篇' ); ?></span><?php _e( '没有了' ); ?>
                            <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php echo bymt_advert( 'ad_singular_nav' ); ?>
                    </footer>
                <?php endwhile; ?>
            </article>
            <div id="comments" class="comments" itemscope itemtype="http://schema.org/Comment">
                <?php if ( comments_open() || get_comments_number() ) : ?>
                    <?php comments_template(); ?>
                <?php else: ?>
                    <div class="comments-close"><?php  __( '评论已关闭' ); ?></div>
                <?php endif; ?>
            </div>
        </section>
        <?php get_sidebar(); ?>
    </div>
    <?php echo bymt_advert( 'ad_singular_footer' ); ?>
</section>
<?php get_footer(); ?>
