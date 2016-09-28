<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/119
 * @version     2.1.2
 */

function bymt_head() {
if(!isset($paged)) { $paged=1; }
echo "<title>";
if ( is_home() ) {
	if (bymt_c('title_content')) { bymt('title_content', 'e'); if($paged > 1) { bymt_r('title_split',' | ', 'e'); printf('第%s页',$paged); } }else{ esc_attr_e(bloginfo('name')); if($paged > 1) { bymt_r('title_split',' | ', 'e'); printf('第%s页',$paged); } bymt_r('title_split',' | ', 'e'); esc_attr_e(bloginfo('description')); }
}else{
	if ( is_search() ) {
		echo '"'; the_search_query(); echo '"的搜索结果';
	}elseif ( is_single() || is_page() ) {
		echo trim(wp_title('',0));
	}elseif ( is_category() ) {
		single_cat_title();
	}elseif ( is_year() ) {
		the_time('Y年的文章');
	}elseif ( is_month() ) {
		the_time('Y年m月的文章');
	}elseif ( is_day() ) {
		the_time('Y年m月d日的文章');
	}elseif ( is_404() ) {
		echo '404错误：'.trim(wp_title('',0));
	}elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo $userdata->display_name.'发表的文章';
	}elseif (function_exists('is_tag')) {
		if ( is_tag() ) { echo 'Tag：'; single_tag_title("", true); }
	}
	if (get_query_var('page')) { bymt_r('title_split',' | ', 'e'); echo '第'.get_query_var('page').'页'; }
	if($paged > 1) { bymt_r('title_split',' | ', 'e'); 	printf('第%s页',$paged); }
	bymt_r('title_split',' | ', 'e'); esc_attr_e(bloginfo('name'));
}
echo "</title>\n";
global $post;
if ( is_singular() ){
    if ($post->post_excerpt) {
        $post_excerpt = $post->post_excerpt;
    } else {
		$post_excerpt = trim( preg_replace( '/((\s)*(\n)+(\s)*)/i', '', strip_tags( $post->post_content ) ) );
    }
	if(!empty($post_excerpt)){
		$description = mb_substr( $post_excerpt, 0, 200, 'UTF-8' );
		$description .= ( mb_strlen( $post_excerpt, 'UTF-8' ) > 200 ) ? '...' : '';
	}else{
		$description = trim(wp_title('',0));
	}
  	$tags = wp_get_post_tags($post->ID);
	if(empty($tags)){
    	$keywords = trim(wp_title('',0));
	}else{
		$keywords = '';
	}
    foreach ($tags as $tag ) {
        $keywords = $keywords . $tag->name . ",";
    }
}elseif (is_home()){
	$keywords = bymt_c('keyword_content');
	$description = bymt_c('description_content');
}elseif (is_category()){
	$keywords = single_cat_title('', false);
	$description = category_description();
}elseif (is_tag()){
	$keywords = single_tag_title('', false);
	$description = tag_description();
}
if(!isset($keywords)) { $keywords=''; }
if(!isset($description)) { $description=''; }
$keywords = esc_attr(trim(strip_tags($keywords)));
$description = esc_attr(trim(strip_tags($description)));
?>
<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="<?php echo rtrim($keywords,','); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php if(bymt_c('favicon_ck')){ bymt('custom_favicon', 'u'); }else{ echo TPLDIR ."/images/favicon.png";} ?>" type="image/x-icon" />
<link rel="icon" href="<?php if(bymt_c('favicon_ck')){ bymt('custom_favicon', 'u'); }else{ echo TPLDIR ."/images/favicon.png";} ?>" type="image/x-icon" />
<?php if ( wp_is_mobile() ) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo TPLDIR . '/css/mobile.css'; ?>" media="all" />
<?php }else{ ?>
<link rel="stylesheet" type="text/css" href="<?php echo TPLDIR . '/style.css'; ?>" media="all" />
<!--[if IE 7]><link rel="stylesheet" href="<?php echo TPLDIR . '/css/ie7.css'; ?>" type="text/css" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="<?php echo TPLDIR . '/css/ie8.css'; ?>" type="text/css" /><![endif]-->
<?php } } ?>
