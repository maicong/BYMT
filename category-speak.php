<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version 	1.0.5
 */

get_header();
?>
    <div id="content_wrap">
    <div id="saybox">
	<?php
	$page_ID=bymt_option('ggid');
	$num=max;
	?>
	<div class="excerpt">
	<h2>博主的吐糟录<?php if ($user_ID) echo '<a href="' . get_page_link($page_ID) . '#respond" rel="nofollow" class="anno">[发表]</a>'; ?></h2>
	<ul>
	<?php
	$announcement = '';
	$avatar= get_avatar($current_user->user_email, 20);
	$comments = get_comments("number=$num&post_id=$page_ID");
	if ( !empty($comments) ) {
		foreach ($comments as $comment) {

			$announcement .= '<li><span class="saytext">'. $avatar .'：'. convert_smilies($comment->comment_content) . '</span><span class="saytime">(' . get_comment_date('m-d H:i',$comment->comment_ID) . ')</span></li>';
		}
	}
	if ( empty($announcement) ) $announcement = '<li>欢迎光临本博！</li>';
	echo $announcement;
	?>
</ul>
</div>
<div class="navigation">
	<div class="pagination"><?php BYMT_pagination(6); ?></div>
</div>
</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
