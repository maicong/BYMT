<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version 	1.0.4
 */

 // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
			die ( __('Please do not load this page directly. Thanks!') );

	if ( post_password_required() ) { ?>
			<p class="nocomments">必须输入密码，才能查看评论！</p>
	<?php
			return;
	}
/* This variable is for alternating comment background */
$oddcomment = '';
?>
<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number('暂无评论，快抢沙发！', '目前有1条大神的评论', '%条大神的评论' );?></h3>
	<div id="loading-comments"><img src="<?php bloginfo('template_directory');?>/images/loading_com.gif" alt="loading"></div>
	<ol class="commentlist">
	<?php wp_list_comments('type=comment&callback=BYMT_comment&end-callback=BYMT_end_comment&max_depth=100'); ?>
	</ol>
	<div class="navigation">
		<div class="pagination"><?php paginate_comments_links('prev_text=上翻&next_text=下滚');?></div>
	</div>

 <?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
        <h3 id="comments" style="margin-bottom:10px">还没有评论，快来抢沙发！</h3>
	 <?php else : // comments are closed ?>
		<p class="nocomments"><a href="<?php bloginfo('wpurl'); ?>/guestboolk">抱歉，评论已关闭，请移步留言板！</a></p>
	<?php endif; ?>
	<?php endif; ?>
	<?php if ('open' == $post->comment_status) : ?>
	<div id="respond_box">
	<div id="respond">
		<h3>发表评论</h3>
		<div class="cancel-comment-reply">
		<div id="real-avatar">
	<?php if(isset($_COOKIE['comment_author_email_'.COOKIEHASH])) : ?>
		<?php echo get_avatar($comment_author_email, 40);?>
	<?php else :?>
		<?php global $user_email;?><?php echo get_avatar($user_email, 40); ?>
	<?php endif;?>
</div>
		</div>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><?php print '您必须'; ?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"> [ 登录 ] </a>才能发表留言！</p>
    <?php else : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
      <p><?php print '登录者：'; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>&nbsp;&nbsp;<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出账户"><?php print '[ 退出账户 ]'; ?></a> <?php cancel_comment_reply_link('[ 取消回复 ]'); ?>

	<?php elseif ( '' != $comment_author ): ?>
	<div class="author"><?php printf(__('欢迎回来 <strong>%s</strong> 大神'), $comment_author); ?>
			<a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info">[ 更换战袍 ]</a> <?php cancel_comment_reply_link('[ 取消回复 ]'); ?></div>
			<script type="text/javascript" charset="utf-8">
				//<![CDATA[
				var changeMsg = "[ 更换战袍 ]";
				var closeMsg = "[ 隐藏战袍 ]";
				function toggleCommentAuthorInfo() {
					jQuery('#comment-author-info').slideToggle('slow', function(){
						if ( jQuery('#comment-author-info').css('display') == 'none' ) {
						jQuery('#toggle-comment-author-info').text(changeMsg);
						} else {
						jQuery('#toggle-comment-author-info').text(closeMsg);
				}
			});
		}
				jQuery(document).ready(function(){
					jQuery('#comment-author-info').hide();
				});
				//]]>
			</script>
		</p>
	 <?php endif; ?>
         <?php echo BYMT_WelcomeCommentAuthorBack($comment_author_email); ?>
	<?php if ( ! $user_ID ): ?>
	<div id="comment-author-info">
		<p>
            <label for="author">昵称:</label>
			<input type="text" name="author" id="author" class="respondtext" value="<?php echo $comment_author; ?>" size="22" tabindex="1" placeholder="nickname" required />
			<label for="email">邮箱:</label>
			<input type="email" name="email" id="email" class="respondtext" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" placeholder="name@example.com" required /><span id="Get_Gravatar"></span>
			<label for="url">网址:</label>
			<input type="text" name="url" id="url" class="respondtext" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" placeholder="maicong.me" pattern="((http|https)://|)+([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?"/>
		</p>
	</div>
      <?php endif; ?>
    <div class="clear"></div>
<div id="smiley">
	    <?php include_once(TEMPLATEPATH . '/smile.php'); ?>
</div>
    <textarea name="comment" id="comment" tabindex="4" cols="45" rows="5" placeholder="任何广告行为都会被封杀的哦~" required></textarea>
	<div id="editor_tools">
<div id="editor">
<a href="javascript:SIMPALED.Editor.daka()" onClick="this.style.display='none';"><b>签到</b></a>
<a href="javascript:SIMPALED.Editor.good()" onClick="this.style.display='none';"><b>赞美</b></a>
<a href="javascript:SIMPALED.Editor.bad()" onClick="this.style.display='none';"><b>埋怨</b></a>
<a href="javascript:SIMPALED.Editor.strong()"><b>粗体</b></a>
<a href="javascript:SIMPALED.Editor.em()"><b>斜体</b></a>
<a href="javascript:SIMPALED.Editor.quote()"><b>引用</b></a>
<a href="javascript:SIMPALED.Editor.del()"><b>删除线</b></a>
<a href="javascript:SIMPALED.Editor.private()"><b>防偷看</b></a>
</div>
</div>
	<div>
	<input class="submit" name="submit" type="submit" id="submit" tabindex="5" value="戳我提交" />
	<input class="reset" name="reset" type="reset" id="reset" tabindex="6" value="<?php esc_attr_e( '清除' ); ?>" />
	<label for="comment_mail_notify" style="display:none"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知偶</label><!--邮件回复 默认勾选并隐藏-->
		<?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>
	</div>
		<script type="text/javascript">	//快捷回复 Ctrl+Enter
		//<![CDATA[
			jQuery(document).keypress(function(e){
				if(e.ctrlKey && e.which == 13 || e.which == 10) {
					jQuery(".submit").click();
					document.body.focus();
				} else if (e.shiftKey && e.which==13 || e.which == 10) {
					jQuery(".submit").click();
				}
			})
		// ]]>
		</script>
    </form>

	<div class="clear"></div>
    <?php endif; // If registration required and not logged in ?>
  </div>
  </div>
  <?php endif; // if you delete this the sky will fall on your head ?>
