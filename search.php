<?php !defined( 'WPINC' ) && exit();
/**
 * search.php
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
        <div id="main-section" class="post-list" itemscope itemtype="http://schema.org/SearchResultsPage">
            <?php echo bymt_advert( 'ad_home_list_top' ); ?>
            <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" role="article">
                    <?php bymt_include_post_format(); ?>
                </article>
            <?php endwhile; ?>
                <div id="post-pagenavi" class="pagination"><?php echo bymt_pagenavi(); ?></div>
            <?php else : ?>
                <div class="hentry">
                    <div class="post-entry">
                        <h2 class="entry-title"><?php _e( '找不到和您的查询相符的内容' ); ?></h2>
                        <h3 class="entry-content"><?php _e( '建议：' ); ?></h3>
                        <ul class="entry-li">
                            <li>请检查输入字词有无错误。</li>
                            <li>请尝试其他的查询词。</li>
                            <li>请改用较常见的字词。</li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>  
            <?php echo bymt_advert( 'ad_home_list_bottom' ); ?> 
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php echo bymt_advert( 'ad_home_footer' ); ?>
</section>
<?php get_footer(); ?>