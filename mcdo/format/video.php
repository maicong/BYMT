<?php !defined( 'WPINC' ) && exit();
/**
 * 文章形式 - 视频
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<div class="post-entry" itemscope itemtype="http://schema.org/VideoObject">
    <h2 class="entry-title" itemprop="headline"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
    <div class="entry-meta"><?php echo bymt_post_meta(); ?></div>
    <?php if ( ! post_password_required() && bymt_do_media_shortcode() ) : ?>
    <div class="media-player" itemprop="video">
        <?php echo bymt_do_media_shortcode(); ?>
    </div>
    <?php else: ?>
    <div class="entry-summary"><?php echo bymt_excerpt( 150 ); ?></div>
    <?php endif; ?>
</div>
<div class="clear"></div>