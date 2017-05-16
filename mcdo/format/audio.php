<?php !defined( 'WPINC' ) && exit();
/**
 * 文章形式 - 音频
 *
 * @package     BYMT
 * @author      MaiCong <i@maicong.me>
 * @link        https://maicong.me/t/119
 * @version     3.0.0
 */
?>
<div class="post-entry" itemscope itemtype="http://schema.org/AudioObject">
    <h2 class="entry-title" itemprop="headline"><a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php the_title(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
    <div class="entry-meta"><?php echo bymt_post_meta(); ?></div>
    <?php if ( bymt_do_media_shortcode() ): ?>
    <div class="media-player clearfix">
        <?php if ( ! post_password_required() && bymt_thumbnail( 150, 150, false ) ) : ?>
        <div class="player-thumb"><?php echo bymt_thumbnail( 150, 150, true ); ?></div>
        <?php endif; ?>
        <div class="player-content" itemprop="audio">
            <?php echo bymt_do_media_shortcode(); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="entry-summary" itemprop="description"><?php echo bymt_excerpt( 150 ); ?></div>
    <?php endif; ?>
</div>
<div class="clear"></div>
