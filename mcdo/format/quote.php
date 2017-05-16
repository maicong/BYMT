<?php !defined( 'WPINC' ) && exit();
/**
 * 文章形式 - 引语
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<div class="post-entry" itemscope itemtype="http://schema.org/ItemPage">
    <?php if ( ! post_password_required() && bymt_thumbnail( 880, 0, false ) ) : ?>
    <div class="entry-big-thumb transition6" style="background-image: url(<?php echo bymt_thumbnail( 880, 0, false ); ?>)"><span class="mask transition6"></span></div>
    <?php endif; ?>
    <div class="entry-hold-icon special-icon" itemprop="headline"></div>
    <div class="entry-content special-content" itemprop="description">
        <blockquote><?php echo bymt_excerpt( 140 ); ?></blockquote>
        <p><a href="<?php echo esc_url( get_permalink() ); ?>" class="special-link" title="<?php the_title(); ?>" rel="bookmark" itemprop="url">— <?php the_title(); ?></a></p>
    </div>
    <div class="entry-meta special-meta text-right"><?php echo bymt_post_meta(); ?></div>
</div>
<div class="clear"></div>