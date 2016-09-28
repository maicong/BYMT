<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

function bymt_load_theme() {
    global $pagenow;
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        bymt_vote_install();
}
add_action( 'load-themes.php', 'bymt_load_theme' );

function bymt_vote_install(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'comm_vote';
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) :
    $sql = " CREATE TABLE `".$wpdb->prefix."comm_vote` (
      `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	  `comm` INT NOT NULL ,
      `user` varchar(50) ,
	  `email` varchar(100) ,
	  `url` varchar(100) ,
      `rating` varchar(10) ,
      `ip` varchar(40) ,
	  `time` datetime
     ) ENGINE = MYISAM DEFAULT CHARSET=utf8;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    endif;
}

function add_vote($commid,$user,$email='',$url='',$rating='up',$ip,$time){
    global $wpdb;
    $commid = (int)$commid;
    if($user==''||$ip==''){
        return "e";
    }
    if($user!=''){
        $check= "select * from ".$wpdb->prefix."comm_vote where comm='$commid' and user='$user'";
    }else{
        if($ip!=''){
            $check= "select * from ".$wpdb->prefix."comm_vote where comm='$commid' and ip='$ip'";
        }
    }
    $coo = $wpdb->get_results($check);
    if($rating !='up'){
        $rating == 'down';
    }
	if($time==''){
		date_default_timezone_set('PRC');
		$time=date("Y-m-d H:i:s ",time());
	}
    if(count($coo) < 4){
        $s = "insert into ".$wpdb->prefix."comm_vote (comm,user,email,url,rating,ip,time) values('$commid','$user','$email','$url','$rating','$ip','$time')";
        $wpdb->query($s);
        return "y";
    }else{
        return "h";
    }
    return "e";
}

function get_comm_vote($comm_id,$vote='up'){
    global $wpdb;
    $comm_id = (int)$comm_id;
    if($vote != 'up'){
        $vote == 'down';
    }
    $sql = "select count(*) from ".$wpdb->prefix."comm_vote where comm='$comm_id' and rating='$vote'";
    $coo = $wpdb->get_var($sql);
    if($coo)
    return $coo;
    else
    return 0;
}

function add_votes_options() {
if( isset($_POST['action']) && ($_POST['action'] == 'vote_comm') ){
    $comm_id = (int)$_POST['commid'];
    if( !$comm_id ){
        echo 'e';
        die(0);
    }
	if(isset($_COOKIE["bymt_voted_".$comm_id])){
		echo 'h';
        die(0);
	}
	$c_rating = $_POST['rating'];
    if($c_rating != 'up'){
        $c_rating == 'down';
    }
	if (is_user_logged_in()) {
		global $current_user;
		wp_get_current_user();
		$cc_user = $current_user->user_login;
		$c_user = $cc_user."[注册用户]";
		$c_email = $current_user->user_email;
		$cc_url = $current_user->user_url;
		$c_url = empty($cc_url) ? "#注册用户" : $cc_url;
	}else{
		$COOKIEHASH = md5("http://".$_SERVER['HTTP_HOST']);
		if(isset($_COOKIE['comment_author_'.$COOKIEHASH]) && isset($_COOKIE['comment_author_email_'.$COOKIEHASH])) {
		$c_user = $_COOKIE['comment_author_'.$COOKIEHASH];
		$c_email = $_COOKIE['comment_author_email_'.$COOKIEHASH];
			if(isset($_COOKIE['comment_author_url_'.$COOKIEHASH])){
				$c_url = $_COOKIE['comment_author_url_'.$COOKIEHASH];
			}else{
				$c_url ="nourl";
			}
		}else{
			$c_user ="noname";
			$c_email ="noemail";
			$c_url ="#nourl";
		}
	}
	$c_ip = bymt_getIP('Ip');
	date_default_timezone_set('PRC');
	$c_time=date("Y-m-d H:i:s ",time());
    $add_vote = add_vote($comm_id,$c_user,$c_email,$c_url,$c_rating,$c_ip,$c_time);
    if($add_vote=='y'){
        setcookie("bymt_voted_" . $comm_id,$c_rating, time() + 86400, '/');
        echo 'y';
        die(0);
    }
    if($add_vote=='h'){
        setcookie("bymt_voted_" . $comm_id,$c_rating, time() + 86400, '/');
        echo 'h';
        die(0);
    }
    if($add_vote=='e'){
        echo 'n';
        die(0);
    }
}else{
    echo 'e';
}
die(0);
}
add_action("wp_ajax_vote_comm", "add_votes_options");
add_action("wp_ajax_nopriv_vote_comm", "add_votes_options");
?>
