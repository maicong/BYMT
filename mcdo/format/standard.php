<?php !defined( 'WPINC' ) && exit();
/**
 * 文章形式 - 标准
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */
?>
<?php $thumb_width = bymt_option( 'sidebar' ) ? 880 : 1200; $thumb_height = bymt_option( 'sidebar' ) ? 210 : 260; ?>
<?php if ( ! post_password_required() && bymt_thumbnail( $thumb_width, $thumb_height, false, true ) ) : ?>
<div class="post-thumb">
    <a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php echo bymt_thumbnail($thumb_width, $thumb_height, true, true ); ?></a>
</div>
<?php endif; ?>
<div class="post-entry">
    <h2 class="entry-title" itemprop="headline"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
    <div class="entry-meta">
        <?php
            if ( 'post' === get_post_type() ) :
                bymt_post_meta();
            endif;
        ?>
    </div>
    <div class="entry-summary" itemprop="description"><?php echo bymt_excerpt( 150 ); ?></div>
</div>
<div class="clear"></div>
