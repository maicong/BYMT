<?php !defined( 'WPINC' ) && exit();
/**
 * comments.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' === basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load this page directly. Thanks!');
}

if ( post_password_required() ) { ?>
	<p class="nocomments alert alert-info mt0"><?php _e('This post is password protected. Enter the password to view comments.'); ?></p>
<?php
	return;
}

do_action( 'bymt_comment_pjax' );

if ( have_comments() ) : ?>
	<h3><?php echo str_replace( 'icon-comment', 'icon-comment2', get_comments_number_text() ); ?></h3>
	<div id="commentshow" class="commentshow">
		<?php echo bymt_advert( 'ad_singular_comment_top' ); ?>
		<ol id="commentlist" class="commentlist">
			<?php wp_list_comments( array( 'type' => 'comment', 'callback' => 'bymt_comments_list' ) ); ?>
		</ol>
		<ol class="pingbacklist"><?php wp_list_comments( array( 'type' => 'pingback', 'callback' => 'bymt_pingback_list' ) ); ?></ol>
		<div id="comment-pagenavi" class="pagination"><?php paginate_comments_links( array( 'prev_text' => '上页', 'next_text' => '下页' ) );?></div>
		<?php echo bymt_advert( 'ad_singular_comment_bottom' ); ?>
	</div>
<?php else : ?>
	<?php if ( comments_open() ) : ?>
		<p id="comments" class="nocomments alert alert-info">还没有评论，快来抢沙发！</p>
	<?php else : ?>
		<p class="nocomments alert alert-warning"><?php _e('Comments are closed.'); ?></p>
	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<div id="respond" class="respond">
		<h3 data-title="<?php _e( 'Leave a Reply' ); ?>"><?php comment_form_title( __('Leave a Reply'), __('Leave a Reply to %s' ) ); ?></h3>
		<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
		<div class="nologin alert alert-info"><?php printf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( get_permalink() ) ); ?></div>
		<?php else : ?>
		<div class="respond-user">
			<?php if ( is_user_logged_in() ) : ?>
			<?php global $user_email; printf( __( '%1$s欢迎回来, <a href="%2$s">%3$s</a>.' ), bymt_gravatar( $user_email, '28', 'avatar', false ), get_edit_user_link(), $user_identity ); ?> <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php esc_attr_e( 'Log out of this account' ); ?>"><?php _e( 'Log out &raquo;' ); ?></a>
			<?php elseif ( $comment_author !== "" ): ?>
			<?php printf( __( '%1$s欢迎回来, %2$s.' ), bymt_gravatar( $comment_author_email, '28', 'avatar', false ), $comment_author); ?> <a href="javascript:;" id="edit-info">[<?php _e( 'Edit' ); ?>]</a>
			<?php endif; ?>
			<?php cancel_comment_reply_link( '<i class="iconfont icon-close2"></i>' . __( '取消回复' ) ) ?>
		</div>
		<form action="<?php echo site_url(); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form">
			<?php
				if ( ! is_user_logged_in() ) :
					$info_class = ( $comment_author !== "" ) ? ' hidden' : '';
			?>
			<div id="comment-form-info" class="comment-form-info<?php echo $info_class; ?> transition3 clearfix">
				<div class="comment-form-value">
					<label for="author"><?php _e( '昵称' ); ?></label>
					<input type="text" name="author" id="author" value="<?php echo esc_attr( $comment_author ); ?>" size="22" tabindex="1" <?php if ($req) echo "required"; ?> />
				</div>
				<div class="comment-form-value">
					<label for="email"><?php _e( '邮箱' ); ?></label>
					<input type="email" name="email" id="email" value="<?php echo esc_attr( $comment_author_email ); ?>" size="22" tabindex="2" <?php if ($req) echo "required"; ?> />
				</div>
				<div class="comment-form-value">
					<label for="url"><?php _e( '网址' ); ?></label>
					<input type="url" name="url" id="url" value="<?php echo  esc_attr( $comment_author_url ); ?>" size="22" tabindex="3" />
				</div>
			</div>
			<?php endif; ?>
			<div class="comment-form-comment">
				<?php echo bymt_comment_tools(); ?>
				<textarea<?php echo bymt_output( 'comment_tools', ' class="has_tools"' ) ?> data-nonce="<?php echo bymt_ajax( 'comment' ); ?>" data-ajax-load="<?php echo bymt_define( 'ajax_comment_load', __( '正在提交，请稍候 ...' ) ); ?>" data-ajax-empty="<?php echo bymt_define( 'ajax_comment_empty', __( '评论内容不能为空' ) ); ?>" name="comment" id="comment" cols="58" rows="10" tabindex="4" placeholder="任何广告行为都会被封杀的哦~" autocomplete="off"<?php if ( !bymt_option( 'comment_tools' ) ) echo ' required'; ?>></textarea>
			</div>
			<div class="comment-form-submit">
				<input name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_attr_e( '提交评论' ); ?>" />
				<input name="comment_mail_notify" type="checkbox" value="1" checked="checked" hidden />
				<?php comment_id_fields(); ?>
				<?php do_action( 'comment_form', $post->ID ); ?>
			</div>
			<?php echo bymt_advert( 'ad_singular_submit' ); ?>
		</form>
		<?php endif; // If registration required and not logged in ?>
	</div>
<?php else : ?>
	<div class="nocomments alert alert-warning"><?php _e( 'Comments are closed.' ); ?></div>
<?php endif; // if you delete this the sky will fall on your head ?>
