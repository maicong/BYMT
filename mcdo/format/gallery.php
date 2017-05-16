<?php !defined( 'WPINC' ) && exit();
/**
 * 文章形式 - 相册
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<?php $thumb_width = bymt_option( 'sidebar' ) ? 200 : 300; $thumb_height = bymt_option( 'sidebar' ) ? 200 : 300; ?>
<div class="post-entry" itemtype="http://schema.org/ImageObject">
    <h2 class="entry-title" itemprop="headline"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
    <div class="entry-meta"><?php echo bymt_post_meta(); ?></div>
    <?php if ( ! post_password_required() && bymt_get_gallery_src() ) : ?>
    <div class="entry-gallery clearfix">
        <?php echo bymt_get_gallery_src( $thumb_width, $thumb_height ); ?>
    </div>
    <?php else: ?>
    <div class="entry-summary" itemprop="description"><?php echo bymt_excerpt( 150 ); ?></div>
    <?php endif; ?>
</div>
<div class="clear"></div>