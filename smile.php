<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package 	BYMT
 * @author 		MaiCong (i@maicong.me)
 * @link 		https://maicong.me/t/85
 * @version     1.0.4
 */

function wp_smilies() {
	global $wpsmiliestrans;
	if ( !get_option('use_smilies') or (empty($wpsmiliestrans))) return;
	$smilies = array_unique($wpsmiliestrans);
	$link = '';
	foreach ($smilies as $key => $smile) {
		if (in_array($key, array(':roll:', ':mrgreen:'))) {
			continue;
		}
		$link .= "<a href=\"###\" title=\"{$smile}\" onclick=\"document.getElementById('comment').value += '{$smile}'\">{$smile}</a>&nbsp;";
	}
	echo $link;
}
?>
<?php wp_smilies();?>
