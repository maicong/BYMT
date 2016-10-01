<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version     1.0.5
 */

/****************
Template Name: Guestbook(留言板)
****************/

get_header();
?>
    <div id="content_wrap">
    <div id="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
            <div class="excerpt">
                <div class="context">
				<h2><?php the_title(); ?></h2>
			  <?php the_content(); ?>
			  <?php if(bymt_option('guestwall')): ?>
			  <?php
			  $my_email = "'" . get_bloginfo ('admin_email') . "'";
			  $query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email != $my_email AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 36";
				$wall = $wpdb->get_results($query);
				$maxNum = $wall[0]->cnt;
				$output = "";
				foreach ($wall as $comment) {
					$width = round(40 / ( $maxNum / $comment->cnt),2);
					if( $comment->comment_author_url )
					$url = $comment->comment_author_url;
					else $url="#";
					if(bymt_option('avatar_cache') ){
					$p = 'avatar/';
					$f = md5(strtolower($comment->comment_author_email));
					$a = $p . $f .'.jpg';
					$e = ABSPATH . $a;
					if (!is_file($e)){ //当头像不存在就更新
					$d = is_file(get_bloginfo('template_directory'). '/avatar/avatar.jpg'); //当文件不存在就更新
					$s = '36'; //头像大小 自行根据自己模板设置
					$t = 1209600;  //设定14天过期, 单位:秒
					$r = get_option('avatar_rating');
					$g = 'http://www.gravatar.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r;
					$avatarContent = file_get_contents($g);
					file_put_contents($e, $avatarContent);
					if ( filesize($e) == 0 || !is_file($e) || (time() - filemtime($e)) > $t ){ copy($d, $e); }
					};
					$avatar = '<img src="'. get_option('home') .'/'. $a .'" alt="avatar" class="avatar" width="36px" height="36px"/>';
					} else {
					$avatar =get_avatar($comment->comment_author_email, 36);
					}
					$tmp = "<li><a href=\"".$comment->comment_author_url."\" rel=\"external nofollow\">".$avatar."<em>".$comment->comment_author."</em> <strong>+".$comment->cnt."</strong></a></li>";
					$output .= $tmp;
				}
				echo "<ul class=\"readers-list\">".$output."</ul>";
			  ?>
			  <?php endif; ?>
			  </div>
		</div>
		<div class="comments">
		<?php comments_template(); ?>
		</div>
		<?php endwhile; ?>
        <?php endif; ?>
    </div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
