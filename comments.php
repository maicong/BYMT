<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */
?>
<div class="comments">
	<?php
		if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
			die ('请不要直接加载该页面，谢谢！');
		if ( post_password_required() ) { ?>
			<p class="nocomments">必须输入密码，才能查看评论！</p>
		</div>
		<?php
			return;
		}
	?>
	<?php if ( have_comments() ) : ?>
		<h3 id="comments"><?php comments_number('暂无评论，快抢沙发！', '目前有1条大神的评论', '%条大神的评论' );?></h3>
		<div class="commentshow">
			<ol class="commentlist">
				<?php wp_list_comments('type=comment&callback=bymt_comment&max_depth=1000'); ?>
			</ol>
				<div class="pagination"><?php paginate_comments_links('prev_text=上页&next_text=下页');?></div>
		</div>
	<?php else : ?>
		<?php if ('open' == $post->comment_status) : ?>
        	<h3 id="comments">还没有评论，快来抢沙发！</h3>
	 	<?php else : ?>
			<p class="nocomments">抱歉，评论已关闭！</p>
	 	<?php endif; ?>
	<?php endif; ?>
	<?php if ( comments_open() ) : ?>
	<div id="respond" class="respond">
		<h3>发表评论</h3>
			<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
				<div class="login-to-reply"><?php printf(__('您需要 <a href="%s">登录</a> 才可以评论！'), wp_login_url( get_permalink() )); ?></div>
			<?php else : ?>
			<form method="post" id="comment_form">
				<div id="input-box">
					<div id="real-avatar">
					<?php if (is_user_logged_in()) : ?>
						<?php global $user_email;?><?php echo bymt_avatar($user_email, 42); ?>
					<?php elseif(isset($_COOKIE['comment_author_email_'.COOKIEHASH])) : ?>
						<?php echo bymt_avatar($comment_author_email, 42); ?>
					<?php else : ?>
						<?php echo ''; ?>
					<?php endif;?>
					</div>
					<div id="author-input">
						<p id="welcome">
						<?php if (  is_user_logged_in() ) : ?>
							<?php printf(__('<span class="user-avatar"><i id="avatar-img"></i><i id="avatar-arrow"></i></span><i class="icon-emo-coffee"></i> 欢迎 <strong><a href="%1$s">%2$s</a></strong> 大神回来！'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity );  ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('[退出]'); ?></a>
						<?php elseif ( $comment_author != "" ): ?>
							<?php printf(__('<span class="user-avatar"><i id="avatar-img"></i><i id="avatar-arrow"></i></span><i class="icon-emo-coffee"></i></i> 欢迎 <strong>%s</strong> 大神回来！'), $comment_author); ?> <a href="javascript:;" id="edit-author">[编辑]</a>
						<?php endif; ?>
						<?php cancel_comment_reply_link('[取消回复]'); ?>
						</p>
						<?php if ( !is_user_logged_in() ): ?>
						<p id="author-info">
							<label for="author">昵称</label>
							<input type="text" name="author" id="author" class="replytext" value="<?php echo $comment_author; ?>" size="22" tabindex="1" placeholder="nickname" required />
							<label for="email">邮箱</label>
							<input type="email" name="email" id="email" class="replytext" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" placeholder="name@example.com" required /><span id="Get_Gravatar"></span>
							<label for="url">网址</label>
							<input type="text" name="url" id="url" class="replytext" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" placeholder="<?php echo $_SERVER['HTTP_HOST']; ?>" pattern="((http|https)://|)+([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?"/>
						</p>
						<?php endif; ?>
						</div>
					</div>
					<div class="comment-box">
						<?php if ( !wp_is_mobile() ) { bymt_comm_tools(); } ?>
						<textarea name="comment" class="textarea" id="comment" tabindex="4" cols="45" rows="5" placeholder="任何广告行为都会被封杀的哦~" required></textarea>
					</div>
					<div class="comment-btns">
						<input name="submit" type="submit" id="submit" tabindex="5" value="发表评论" />
						<input name="reset" type="reset" id="reset" tabindex="6" value="<?php esc_attr_e( '清除' ); ?>" />
						<input type="hidden" id="comment_home_url" value="<?php echo esc_url(home_url('/')); ?>">
						<input type="checkbox" name="comment_mail_notify" value="comment_mail_notify" checked  hidden />
						<?php comment_id_fields(); ?>
						<?php do_action('comment_form', $post->ID); ?>
					</div>
			</form>
			<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
