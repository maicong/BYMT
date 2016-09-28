<?php !defined( 'WPINC' ) && exit();
/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

///////////////////////////短代码///////////////////////////
//警示
function warningbox($atts, $content=null, $code="") {
	$return = '<div class="warning shortcodestyle icon-attention">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('warning' , 'warningbox' );

//禁止
function nowaybox($atts, $content=null, $code="") {
	$return = '<div class="noway shortcodestyle icon-error">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('noway' , 'nowaybox' );

//购买
function buybox($atts, $content=null, $code="") {
	$return = '<div class="buy shortcodestyle icon-basket">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('buy' , 'buybox' );

//项目
function taskbox($atts, $content=null, $code="") {
	$return = '<div class="task shortcodestyle icon-tasks">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('task' , 'taskbox' );

//下载链接
function downlink($atts,$content=null){
	extract(shortcode_atts(array("href"=>'http://'),$atts));
	$return = '<div class="down shortcodestyle icon-download">';
	$return .= '<a href="'.$href.'" target="_blank">'.$content.'</a>';
	$return .= '</div>';
	return $return;
	}
	add_shortcode('down','downlink');

//下载按钮
function button_download($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-down"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butdown', 'button_download');

//爱心按钮
function button_heart($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-heart"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butheart', 'button_heart');

//文本按钮
function button_text($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-text"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('buttext', 'button_text');

//盒子按钮
function button_box($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-box"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butbox', 'button_box');

//搜索按钮
function button_search($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-search"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butsearch', 'button_search');

//文档按钮
function button_document($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-document"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butdocument', 'button_document');

//链接按钮
function button_link($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-link"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butlink', 'button_link');

//箭头按钮
function button_next($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-next"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butnext', 'button_next');

//音乐按钮
function button_music($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));
	return '<span class="but-music"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a></span>';
}
add_shortcode('butmusic', 'button_music');

//收缩栏
function post_toggle($atts, $content=null){
	extract(shortcode_atts(array("title"=>''),$atts));
	return '<div class="toggle_title">'.$title.'</div><div class="toggle_content">'.$content.'</div>';
}
add_shortcode('toggle','post_toggle');

//Tab选项卡
function bymt_do_shortcode($content, $autop = FALSE){
    $content = do_shortcode( $content );
    if ( $autop ) {
        $content = wpautop($content);
    }
    return $content;
}
function post_tabs($atts, $content=null){
		if (!preg_match_all("/(.?)\[(item)\b(.*?)(?:(\/))?\](?:(.+?)\[\/item\])?(.?)/s", $content, $matches)) {
        return do_shortcode($content);
    }else{
		for ($i = 0; $i < count($matches[0]); $i++) {
            $matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
        }
		$out = '<div class="bymt-tabs">';
        $out.= '<ul class="tabs-title">';
		for ($i = 0; $i < count($matches[0]); $i++) {
            $out.= '<li';
            if($i == 0 ){$out.=' class="tabon"';}
            $out.= '><a href="#tab-'. $i .'">'. $matches[3][$i]['title'] .'</a></li>';
        }
		$out.= '</ul>';
        $out.= '<div class="tabs-container">';
		 for ($i = 0; $i < count($matches[0]); $i++) {
            $out.= '<div id="tab-'. $i .'" ';
            if($i == 0 ){$out.= ' style="display:block"';}
            $out.='class="tabs-content">'. bymt_do_shortcode(trim($matches[5][$i]), TRUE) .'</div>';
        }
		$out.= '</div>';
        $out.= '</div>';
        return $out;
	}
}
add_shortcode('tabs','post_tabs');

//豆瓣音乐播放器
function doubanplayer($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));
	return '<embed src="'.TPLDIR.'/images/shortcode/doubanplayer.swf?url='.$content.'&amp;autoplay='.$auto.'" type="application/x-shockwave-flash" wmode="opaque" allowscriptaccess="sameDomain" width="400" height="30">';
	}
add_shortcode('music','doubanplayer');

//MP3播放器
function mp3link($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0',"replay"=>'0',),$atts));
	return '<embed src="'.TPLDIR.'/images/shortcode/dewplayer.swf?mp3='.$content.'&amp;autostart='.$auto.'&amp;autoreplay='.$replay.'" wmode="opaque" height="20" width="240" type="application/x-shockwave-flash" />';
	}
add_shortcode('mp3','mp3link');

//FLV播放器
function flvlink($atts,$content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));
	return'<embed src="'.TPLDIR.'/images/shortcode/flvideo.swf?auto='.$auto.'&flv='.$content.'" quality="high"  width="100%" height="100%" bgcolor="#ffffff" align="middle" allowScriptAccess="sameDomain" allowFullScreen="true" wmode="opaque" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />';
	}
add_shortcode('flv','flvlink');

//SWF播放器
function swflink($atts,$content=null){
	return'<embed src="'.$content.'" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>';
	}
add_shortcode('swf','swflink');

//html5音乐
function audiolink($atts,$content=null){
	extract(shortcode_atts(array("autoplay"=>'',"loop"=>'',),$atts));
	return'<audio src="'.$content.'" controls '.$autoplay.' '.$loop.'></audio>';
	}
add_shortcode('audio','audiolink');

//html5视频
function videolink($atts,$content=null){
	extract(shortcode_atts(array("autoplay"=>'',"loop"=>'',),$atts));
	return'<video src="'.$content.'" controls '.$autoplay.' '.$loop.' width="100%" height="100%"></video>';
	}
add_shortcode('video','videolink');

//视频解析
function wp_embed_handler_youku_1( $matches, $attr, $url, $rawattr ) {  return apply_filters( 'embed_youku', '<embed src="http://player.youku.com/player.php/sid/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'youku', '#http://v.youku.com/v_show/id_(\w+)#i', 'wp_embed_handler_youku_1' );

function wp_embed_handler_tudou_1( $matches, $attr, $url, $rawattr ) {
switch ($matches[2]){ case '': $src='v/'.$matches[4]; break; case 'listplay': $src='l/'.$matches[3]; break; case 'albumplay': $src='a/'.$matches[3]; break; }
return apply_filters( 'embed_tudou', '<embed src="http://www.tudou.com/'.$src.'/v.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'tudou', '#http://www.tudou.com/(programs/view|(listplay|albumplay)/(\w+))/(\w+)#i','wp_embed_handler_tudou_1' );

function wp_embed_handler_qq_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_qq', '<embed src="http://static.video.qq.com/TPout.swf?vid=' . esc_attr($matches[2]) . '&auto=0" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'qq', '#http://v.qq.com/(.*?)vid=(\w+)#i', 'wp_embed_handler_qq_1' );

function wp_embed_handler_bilibili_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_bilibili', '<embed src="http://static.hdslb.com/miniloader.swf?aid=' . esc_attr($matches[1]) . '" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'bilibili', '#http://(www.bilibili.tv|bilibili.kankanews.com)/video/av(\d+)#i', 'wp_embed_handler_bilibili_1' );

function wp_embed_handler_acfun_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_acfun', '<embed src="http://static.acfun.tv/player/ACFlashPlayer.out.swf?type=page&url=' . esc_attr($url) . '" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'acfun', '#http://www.acfun.tv/v/ac(\d+)#i', 'wp_embed_handler_acfun_1' );

function wp_embed_handler_ku6_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_ku6', '<embed src="http://player.ku6.com/refer/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'ku6', '#http://v.ku6.com/show/([\w\.]+).html#i', 'wp_embed_handler_ku6_1' );

function wp_embed_handler_56com_1($matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_56com', '<embed src="http://player.56.com/v_' . esc_attr($matches[3]) . '.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( '56com', '#http://www.56.com/(\w+)/(v_|play_album\-aid\-[0-9]+_vid\-)(\w+)#i', 'wp_embed_handler_56com_1' );

function wp_embed_handler_letv_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_letv', '<embed src="http://i7.imgs.letv.com/player/swfPlayer.swf?id=' . esc_attr($matches[1]) . '&autoplay=0" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'letv', '#http://www.letv.com/ptv/vplay/(\d+).html#i', 'wp_embed_handler_letv_1' );

function wp_embed_handler_yinyuetai_1( $matches, $attr, $url, $rawattr ) { print_r($matches); return apply_filters( 'embed_yinyuetai', '<embed src="http://player.yinyuetai.com/' . esc_attr($matches[1]) . '/player/' . esc_attr($matches[2]) . '/v_0.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'yinyuetai', '#http://v.yinyuetai.com/(video|playlist)/(\d+)#i', 'wp_embed_handler_yinyuetai_1' );

function wp_embed_handler_youtube_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_youtube', '<embed src="http://www.youtube.com/v/' . esc_attr($matches[1]) . '?&amp;hl=zh_CN&amp;rel=0" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'youtube', '#http://youtu.be/(\w+)#i', 'wp_embed_handler_youtube_1' );

//swf解析
function wp_embed_handler_swf_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_swf', '<embed src="' . esc_attr($url) . '" width="100%" height="100%" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'swf', '#(.*?).swf(.*?)#i', 'wp_embed_handler_swf_1' );

/////////////////////////////////////////////////////////////

function Shortpage(){?>
<style type="text/css">
.wrap{font-size:12px; line-height:24px;color:#383838;}
.devetable td{vertical-align:top;text-align: left; }
.top td{vertical-align: middle;text-align: left; }
pre{white-space: pre;overflow: auto;padding:0px;line-height:19px;font-size:12px;color:#898989;}
strong{ color:#666}
.none{display:none;}
fieldset{ border:1px solid #ddd;margin:5px 0 10px;padding:10px 10px 20px 10px;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;}
fieldset:hover{border-color:#bbb;}
fieldset legend{padding:0 5px;color:#777;font-size:14px;font-weight:700;cursor:pointer}
fieldset .line{border-bottom:1px solid #e5e5e5;padding-bottom:15px;}
</style>
<div class="wrap">
<div id="icon-themes" class="icon32"><br></div>
<h2>主题短代码</h2>
    <div style="padding-left:20px;">
	<p>写文章时如果需要可以加入下列短代码，请在“文本”模式中点击按钮加入</p>
<fieldset>
<legend>短代码面板</legend>
	<div>
      <table width="600" border="0" class="devetable">
      	<tr><td width="120">灰色项目面板：</td><td width="464"><code>[task]文字内容[/task]</code></td></tr>
  		<tr><td width="120">红色禁止面板：</td><td width="464"><code>[noway]文字内容[/noway]</code></td></tr>
        <tr><td width="120">黄色警告面板：</td><td width="464"><code>[warning]文字内容[/warning]</code></td></tr>
        <tr><td width="120">绿色购买面板：</td><td width="464"><code>[buy]文字内容[/buy]</code></td></tr>
       </table>
      </div>
</fieldset>
<fieldset>
<legend>下载样式</legend>
	<div>
      <table width="700" border="0" class="devetable">
      	<tr><td width="100"><strong>下载样式</strong></td><td width="464"><code>[down href="http://www.xxx.com/xxx.zip"]download xxx.zip[/down]</code></td></tr>
  </table>
  </div>
</fieldset>
<fieldset>
<legend>按钮样式</legend>
	<div>
     <table width="600" border="0" class="devetable">
      	<tr><td width="120">下载按钮：</td><td width="464"><code>[butdown href="链接"]下载[/butdown]</code></td></tr>
  		<tr><td width="120">爱心按钮：</td><td width="464"><code>[butheart href="链接"]爱心[/butheart]</code></td></tr>
        <tr><td width="120">文本按钮：</td><td width="464"><code>[buttext href="链接"]文本[/buttext]</code></td></tr>
        <tr><td width="120">盒子按钮：</td><td width="464"><code>[butbox href="链接"]盒子[/butbox]</code></td></tr>
		<tr><td width="120">搜索按钮：</td><td width="464"><code>[butsearch href="链接"]搜索[/butsearch]</code></td></tr>
  		<tr><td width="120">文档按钮：</td><td width="464"><code>[butdocument href="链接"]文档[/butdocument]</code></td></tr>
        <tr><td width="120">链接按钮：</td><td width="464"><code>[butlink href="链接"]链接[/butlink]</code></td></tr>
        <tr><td width="120">箭头按钮：</td><td width="464"><code>[butnext href="链接"]箭头[/butnext]</code></td></tr>
		<tr><td width="120">音乐按钮：</td><td width="464"><code>[butmusic href="链接"]音乐[/butmusic]</code></td></tr>
		<tr><td width="120">收缩栏：</td><td width="464"><code>[toggle title="标题"]内容[/toggle]</code></td></tr>
       </table>
  </div>
</fieldset>
<fieldset>
<legend>音乐播放器</legend>
	<div>
      <table width="800" border="0" class="devetable">
	  	<tr><td width="140"><strong>豆瓣音乐播放器</strong></td><td>&nbsp;</td></tr>
      	<tr><td width="140">默认不自动播放：</td><td><code>[music]http://www.xxx.com/xxx.mp3[/music]</code></td></tr>
        <tr><td width="140">自动播放:</td><td><code>[music auto=1]http://www.xxx.com/xxx.mp3[/music]</code></td></tr>

		<tr><td width="140"><strong>MP3专用播放器</strong></td><td>&nbsp;</td></tr>
        <tr><td width="140">默认不循环不自动播放：</td><td><code>[mp3]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
         <tr><td width="140">自动播放：　</td><td><code>[mp3 auto="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
         <tr><td width="140">循环播放：	</td><td><code>[mp3 replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
         <tr><td width="140">自动及循环播放：</td><td><code>[mp3 auto="1" replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>

		 <tr><td width="140"><strong>html5音乐播放器</strong></td><td><span style="color: #808000;">注意：如果要使用这个播放器，浏览器一定要支持html5</span></td></tr>
        <tr><td width="140">默认不循环不自动播放：</td><td><code>[audio]http://www.xxx.com/xxx.mp3[/audio]</code></td></tr>
         <tr><td width="140">自动播放：　</td><td><code>[audio autoplay="autoplay"]http://www.xxx.com/xxx.mp3[/audio]</code></td></tr>
         <tr><td width="140">循环播放：	</td><td><code>[audio loop="loop"]http://www.xxx.com/xxx.mp3[/audio]</code></td></tr>
         <tr><td width="140">自动及循环播放：</td><td><code>[audio autoplay="autoplay" loop="loop"]http://www.xxx.com/xxx.mp3[/audio]</code></td></tr>
       </table>
      </div>
</fieldset>
<fieldset>
<legend>视频播放器</legend>
	<div>
		<table width="800" border="0" class="devetable">
		<tr><td width="140"><strong>FLV专用播放器</strong></td><td><span style="color: #808000;">注意：如果要使用这个播放器，一定要添加flv格式的视频文件</span></td></tr>
         <tr><td width="140">默认不自动播放：</td><td><code>[flv]http://www.xxx.com/xxx.flv[/flv]</code></td></tr>
         <tr><td width="140">自动播放：</td><td><code>[flv auto="1"]http://www.xxx.com/xxx.flv[/flv]</code></td></tr>

		<tr><td width="140"><strong>SWF专用播放器</strong></td><td><span style="color: #808000;">注意：如果要使用这个播放器，一定要添加swf格式的视频文件</span></td></tr>
         <tr><td width="140"></td><td><code>[swf]http://www.xxx.com/xxx.swf[/swf]</code></td></tr>

		 <tr><td width="140"><strong>html5视频播放器</strong></td><td><span style="color: #808000;">注意：如果要使用这个播放器，浏览器一定要支持html5</span></td></tr>
         <tr><td width="140">默认不循环不自动播放：</td><td><code>[video]http://www.xxx.com/xxx.mp4[/video]</code></td></tr>
         <tr><td width="140">自动播放：</td><td><code>[video autoplay="autoplay"]http://www.xxx.com/xxx.mp4[/video]</code></td></tr>
		 <tr><td width="140">循环播放：	</td><td><code>[video loop="loop"]http://www.xxx.com/xxx.mp4[/video]</code></td></tr>
         <tr><td width="140">自动及循环播放：</td><td><code>[video autoplay="autoplay" loop="loop"]http://www.xxx.com/xxx.mp4[/video]</code></td></tr>
		</table>

  </div>
</fieldset>
<fieldset>
<legend>视频网站Flash嵌入</legend>
	<div>
    <br>
      <table width="600" border="0" class="devetable">
      	<tr><td width="120"><span style="color: #993300;"> 通用代码：</span></td><td width="504"><code>[embed]视频播放页面网址或Flash地址[/embed]</code></td></tr>
      </table>
       <br>
        <fieldset>
        <legend>使用视频播放页面网址的网站</legend>
            <p><span style="color: #808000;">以下网站中的视频，直接复制浏览器中的地址，粘贴到短代码中即可 </span></p>
              <table width="810" border="0" class="devetable">
               <tr><td width="110">优酷网：</td><td width="714"><code>[embed]http://v.youku.com/v_show/id_XMjgyNDk1NTYw.html[/embed]</code></td></tr>
               <tr><td width="110">土豆网：</td><td width="714"><code>[embed]http://www.tudou.com/programs/view/tFny-0UbTEM/[/embed]</code></td></tr>
               <tr><td width="110">腾讯视频：</td><td width="714"><code>[embed]http://v.qq.com/cover/t/t2uzugw2z1koti5.html?vid=b0121tez4qi[/embed]</code></td></tr>
			   <tr><td width="110">bilibili弹幕网：</td><td width="714"><code>[embed]http://www.bilibili.tv/video/av843149/[/embed]</code></td></tr>
			   <tr><td width="110">AcFun弹幕网：</td><td width="714"><code>[embed]http://www.acfun.tv/v/ac916512[/embed]</code></td></tr>
			   <tr><td width="110">酷6网：</td><td width="714"><code>[embed]http://v.ku6.com/show/YdAyU1sLzfXufJAbzrguXg...html[/embed]</code></td></tr>
			   <tr><td width="110">56网：</td><td width="714"><code>[embed]http://www.56.com/u92/v_MTAwOTg0ODE3.html[/embed]</code></td></tr>
			   <tr><td width="110">乐视网：</td><td width="714"><code>[embed]http://www.letv.com/ptv/vplay/725792.html[/embed]</code></td></tr>
			   <tr><td width="110">音悦台：</td><td width="714"><code>[embed]http://v.yinyuetai.com/video/788607[/embed]</code></td></tr>
               <tr><td width="110">Youtube：</td><td width="714"><code>[embed]http://youtu.be/vtjJe4elifI/[/embed]</code></td></tr>
              </table>
        </fieldset>
           <br>
       <fieldset>
        <legend>使用Flash地址的网站</legend>
            <p><span style="color: #808000;">除了上面提到能直接贴地址的网站外，其余网址请复制视频给出的分享中的flash地址，粘贴到短代码中即可，例如： </span></p>
              <table width="810" border="0" class="devetable">
               <tr><td width="110">爱奇艺：</td><td width="714"><code>[embed]http://player.video.qiyi.com/XXX/XXX/XXX/XXX.swf-XXX[/embed]</code></td></tr>
               <tr><td width="110">6间房：</td><td width="714"><code>[embed]http://v.6.cn/apple/player/videoplayer/xiu_vp.swf?vid=XXX[/embed]</code></td></tr>
			   <tr><td width="110">搜狐视频：</td><td width="714"><code>[embed]http://share.vrs.sohu.com/XXX/v.swf&autoplay=false[/embed]</code> </td></tr>
               <tr><td width="110">凤凰视频：</td><td width="714"><code>[embed]http://v.ifeng.com/include/exterior.swf?guid=XXX&AutoPlay=false[/embed]</code></td></tr>
               <tr><td width="110">新浪视频：</td><td width="714"><code>[embed]http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=XXX/s.swf[/embed]</code></td></tr>
           </table>
        </fieldset></div>
</fieldset>
    </div>
</div>
<?php }
function shortcode_page(){
  add_theme_page("主题短代码","主题短代码",'edit_themes','shortcode_page','Shortpage');
}
add_action('admin_menu','shortcode_page');
if(strpos($_SERVER['PHP_SELF'],"post")==true){
add_action( 'admin_print_footer_scripts', 'Deve_shortcode_buttons', 100 );
}
function Deve_shortcode_buttons() {
?>
<script type="text/javascript">
QTags.addButton( 'task', '项目', '[task]','[/task]');
QTags.addButton( 'noway', '禁止', '[noway]','[/noway]' );
QTags.addButton( 'warning', '警告', '[warning]','[/warning]' );
QTags.addButton( 'buy', '购买', '[buy]','[/buy]' );
QTags.addButton( 'down', '下载', '[down href="链接"]','[/down]' );
QTags.addButton( 'mp3', 'MP3', '[mp3]','[/mp3]' );
QTags.addButton( 'swf', 'SWF', '[swf]','[/swf]' );
QTags.addButton( 'flv', 'FLV', '[flv]','[/flv]' );
QTags.addButton( 'dbmusic', '豆瓣音乐', '[music]','[/music]');
QTags.addButton( 'audio', 'html5音乐', '[audio]','[/audio]' );
QTags.addButton( 'embed', '网络视频', '[embed]','[/embed]' );
QTags.addButton( 'video', 'html5视频', '[video]','[/video]' );
QTags.addButton( 'wp_page', '分页按钮', '<!--nextpage-->' );
QTags.addButton( 'reply', '回复可见', '[reply]','[/reply]' );
QTags.addButton( 'login', '登录可见', '[login]','[/login]' );
QTags.addButton( 'toggle', '收缩栏', '[toggle title="标题"]','[/toggle]');
QTags.addButton( 'tabs', 'Tab选项卡', '[tabs]\n[item title="标题"]内容[/item]\n[item title="标题"]内容[/item]\n[/tabs]');
QTags.addButton( 'butdown', '下载按钮', '[butdown href="链接"]','[/butdown]');
QTags.addButton( 'butheart', '爱心按钮', '[butheart href="链接"]','[/butheart]');
QTags.addButton( 'buttext', '文本按钮', '[buttext href="链接"]','[/buttext]');
QTags.addButton( 'butbox', '盒子按钮', '[butbox href="链接"]','[/butbox]');
QTags.addButton( 'butsearch', '搜索按钮', '[butsearch href="链接"]','[/butsearch]');
QTags.addButton( 'butdocument', '文档按钮', '[butdocument href="链接"]','[/butdocument]');
QTags.addButton( 'butlink', '链接按钮', '[butlink href="链接"]','[/butlink]');
QTags.addButton( 'butnext', '箭头按钮', '[butnext href="链接"]','[/butnext]');
QTags.addButton( 'butmusic', '音乐按钮', '[butmusic href="链接"]','[/butmusic]');
QTags.addButton( 'm11', 'pre_php', '<pre lang="php">','</pre>');
QTags.addButton( 'm12', 'pre_asp', '<pre lang="asp">','</pre>');
QTags.addButton( 'm13', 'pre_html', '<pre lang="html">','</pre>');
QTags.addButton( 'm14', 'pre_css', '<pre lang="css">','</pre>');
QTags.addButton( 'm15', 'pre_js', '<pre lang="js">','</pre>');
QTags.addButton( 'm16', 'pre_xml', '<pre lang="xml">','</pre>');
QTags.addButton( 'm17', 'pre_sql', '<pre lang="sql">','</pre>');
</script>
<?php } ?>
