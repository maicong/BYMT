<?php !defined( 'WPINC' ) && exit();
/**
 * 文章形式 - 链接
 * 
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<?php $thumb_width = bymt_option( 'sidebar' ) ? 880 : 1200; ?>
<div class="post-entry" itemscope itemtype="http://schema.org/ItemPage">
    <?php if ( ! post_password_required() && bymt_thumbnail( $thumb_width, 0, false ) ) : ?>
    <div class="entry-big-thumb transition6" style="background-image: url(<?php echo bymt_thumbnail( $thumb_width, 0, false ); ?>)"><span class="mask transition6"></span></div>
    <?php endif; ?>
    <h2 class="entry-title special-title" itemprop="headline"><a href="<?php echo esc_url( bymt_get_link_url() ); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></h2>
    <div class="entry-content special-content" itemprop="description">
        <p><?php echo esc_url( bymt_get_link_url() ); ?></p>
    </div>
    <div class="entry-meta special-meta text-right"><?php echo bymt_post_meta(); ?></div>
</div>
<div class="clear"></div>