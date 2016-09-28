<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */
?>
<?php get_header(); ?>
<div id="content-wrap">
  <div id="content-main">
    <?php if(bymt_c('pagead1')): ?>
    <div id="adsense7">
      <div id="adsense-loader7" style="display:none;">
        <?php bymt('pageadcode1'); ?>
      </div>
    </div>
    <?php endif; ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post-single">
      <div class="post-content">
        <h2><?php the_title(); ?></h2>
        <?php the_content('Read more...'); ?>
      </div>
    <?php comments_template(); ?>
    </div>
    <?php endwhile; endif; ?>
    <?php if(bymt_c('pagead2')): ?>
    <div id="adsense8">
      <div id="adsense-loader8" style="display:none;">
        <?php bymt('pageadcode2'); ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
  <?php if ( !wp_is_mobile() ){ get_sidebar(); } ?>
</div>
<?php get_footer(); ?>
