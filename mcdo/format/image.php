<?php !defined( 'WPINC' ) && exit();
/**
 * 文章形式 - 图像
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<?php $thumb_width = bymt_option( 'sidebar' ) ? 880 : 1200; ?>
<div class="post-entry" itemscope itemtype="http://schema.org/ImageObject">
    <h2 class="entry-title" itemprop="headline"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
    <div class="entry-meta"><?php echo bymt_post_meta(); ?></div>
    <?php if ( ! post_password_required() && bymt_thumbnail( $thumb_width, 0, false, true ) ) : ?>
    <div class="entry-full-thumb">
        <?php echo bymt_thumbnail( $thumb_width, 0, true, true ); ?>
    </div>
    <?php else: ?>
    <div class="entry-summary" itemprop="description"><?php echo bymt_excerpt( 150 ); ?></div>
    <?php endif; ?>
</div>
<div class="clear"></div>