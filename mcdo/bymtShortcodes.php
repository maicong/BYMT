<?php !defined( 'WPINC' ) && exit();
/**
 * bymtShortcodes.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

// 文章归档
function bymt_shortcode_archives( $attr ) {
    return bymt_archives();
}
add_shortcode( 'bymt_archives' , 'bymt_shortcode_archives' );

// 友情链接
function bymt_shortcode_links( $atts ) {
    $defaults = array(
        'orderby' => 'id',
        'category_orderby' => 'id',
        'title_before' => '<h4>',
        'title_after' => '</h4>',
        'class' => 'link-tags',
        'echo' => false
    );
    $atts = wp_parse_args( $atts, $defaults );
    return wp_list_bookmarks( $atts );
}
add_shortcode( 'bymt_links' , 'bymt_shortcode_links' );

// 评论可见
function bymt_shortcode_need_reply( $atts, $content = '' ) {
    global $user_email;
    $content = wpautop( $content );
    $notice = '<p class="noreply alert alert-info">' . sprintf( __( '此处内容需要您 %s 后才能查看！' ), '<a href="#respond" title="' . __( '点击前往评论' ) . '">' . __( '评论本文并通过审核' ) . '</a>' ) . '</p>';
    $admin_email = get_bloginfo ( 'admin_email' );
    if ( $user_email && $user_email === $admin_email ) return $content;
    if ( !$user_email ) {
        global $wpdb;
        $post_id = get_the_ID();
        $commenter = wp_get_current_commenter();
        $comment_author = $commenter['comment_author'];
        $comment_author_email = $commenter['comment_author_email'];
        $comment_author_url = $commenter['comment_author_url'];
        $replied = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_author = %s AND comment_author_email = %s AND comment_author_url = %s AND comment_approved = 1", $post_id, $comment_author, $comment_author_email, $comment_author_url ) );
        if ( (int) $replied ) return $content;
    }
    return $notice;
}
add_shortcode( 'reply', 'bymt_shortcode_need_reply' );

// 登录可见
function bymt_shortcode_need_login( $atts, $content = '' ) {
    $content = wpautop( $content );
    $notice = '<p class="noreply alert alert-info">' . sprintf( __( '此处内容需要您 %s 后才能查看！' ), '<a href="' . wp_login_url(get_permalink()) . '" title="' . __( '点击前往登录' ) . '">' . __( '登录' ) . '</a>' ) . '</p>';
    if ( is_user_logged_in() ) return $content;
    return $notice;
}
add_shortcode( 'login', 'bymt_shortcode_need_login' );

// 喜欢可见
function bymt_shortcode_need_like( $atts, $content = '' ) {
    $content = wpautop( $content );
    $notice = '<p class="noreply alert alert-info">' . sprintf( __( '此处内容需要您 %s 后才能查看！' ), '<a href="javascript:;">' . __( '喜欢本文' ) . '</a>' ) . '</p>';
    $like_id = absint( get_the_ID() );
    if ( bymt_like_liked( 'post', $like_id, true ) ) return $content;
    return $notice;
}
add_shortcode( 'like', 'bymt_shortcode_need_like' );

// 项目面板
function bymt_shortcode_panel_task( $atts, $content = '' ) {
    return '<div class="bymt-panel p-task clearfix"><i class="iconfont icon-task"></i>' . $content . '</div>';
}
add_shortcode( 'task' , 'bymt_shortcode_panel_task' );

// 禁止面板
function bymt_shortcode_panel_noway( $atts, $content = '' ) {
    return '<div class="bymt-panel p-noway clearfix"><i class="iconfont icon-noway"></i>' . $content . '</div>';
}
add_shortcode( 'noway' , 'bymt_shortcode_panel_noway' );

// 警告面板
function bymt_shortcode_panel_warning( $atts, $content = '' ) {
    return '<div class="bymt-panel p-warning clearfix"><i class="iconfont icon-warning"></i>' . $content . '</div>';
}
add_shortcode( 'warning' , 'bymt_shortcode_panel_warning' );

// 购买面板
function bymt_shortcode_panel_buy( $atts, $content = '' ) {
    return '<div class="bymt-panel p-buy clearfix"><i class="iconfont icon-buy"></i>' . $content . '</div>';
}
add_shortcode( 'buy' , 'bymt_shortcode_panel_buy' );

// 下载面板
function bymt_shortcode_panel_down( $atts, $content = '' ) {
    return '<div class="bymt-panel p-down clearfix"><i class="iconfont icon-down"></i>' . $content . '</div>';
}
add_shortcode( 'down' , 'bymt_shortcode_panel_down' );

// 文本按钮
function bymt_shortcode_button_text( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-text" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-text"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'buttext' , 'bymt_shortcode_button_text' );

// 文档按钮
function bymt_shortcode_button_document( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-document" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-document"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butdocument' , 'bymt_shortcode_button_document' );

// 爱心按钮
function bymt_shortcode_button_heart( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-heart" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-liked"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butheart' , 'bymt_shortcode_button_heart' );

// 盒子按钮
function bymt_shortcode_button_box( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-box" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-box"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butbox' , 'bymt_shortcode_button_box' );

// 搜索按钮
function bymt_shortcode_button_search( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-search" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-search"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butsearch' , 'bymt_shortcode_button_search' );

// 链接按钮
function bymt_shortcode_button_link( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-link" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-link"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butlink' , 'bymt_shortcode_button_link' );

// 下载按钮
function bymt_shortcode_button_down( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-down" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-down"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butdown' , 'bymt_shortcode_button_down' );

// 箭头按钮
function bymt_shortcode_button_next( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-next" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-forward"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butnext' , 'bymt_shortcode_button_next' );

// 音频按钮
function bymt_shortcode_button_audio( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-audio" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-audio"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butaudio' , 'bymt_shortcode_button_audio' );
add_shortcode( 'butmusic' , 'bymt_shortcode_button_audio' );

// 视频按钮
function bymt_shortcode_button_video( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'href' => 'http://',
        'target' => '_blank'
    ), $atts );
    return '<a class="bymt-button b-video" href="' . esc_url( $args['href'] ) . '" target="' . $args['target'] . '"><i class="iconfont icon-video"></i><span>' . $content . '</span></a>';
}
add_shortcode( 'butvideo' , 'bymt_shortcode_button_video' );

// 收缩栏
function bymt_shortcode_toggle( $atts, $content = '' ){
    $args = shortcode_atts( array(
        'title' => '',
    ), $atts );
    return '<div class="bymt-toggle"><div class="toggle-title not-select">' . $args['title'] . '</div><div class="toggle-content transition3">' . $content . '</div></div>';
}
add_shortcode( 'toggle', 'bymt_shortcode_toggle' );

// 选项卡
function bymt_shortcode_tabs( $atts, $content = '' ) {
    if ( !preg_match_all( "/(.?)\[(item)\b(.*?)(?:(\/))?\](?:(.+?)\[\/item\])?(.?)/s", $content, $matches ) ) {
        return do_shortcode( $content );
    } else {
        for ($i = 0; $i < count($matches[0]); $i++) {
            $matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
        }
        $out = '<div class="bymt-tabs">';
        $out .= '<ul class="tabs-title">';
        for ($i = 0; $i < count($matches[0]); $i++) {
            $out .= '<li';
            if ( $i === 0 ) {
                $out .= ' class="active"';
            }
            $out .= '><a href="#bymt-tab-' . $i . '">'. $matches[3][$i]['title'] . '</a></li>';
        }
        $out .= '</ul>';
        $out .= '<div class="tabs-container">';
        for ($i = 0; $i < count($matches[0]); $i++) {
            $out .= '<div id="bymt-tab-' . $i . '"';
            $active = ( $i === 0 ) ? ' active' : '';
            $out .= ' class="tabs-content' . $active . '">' . wpautop( do_shortcode( trim( $matches[5][$i] ) ) ) . '</div>';
        }
        $out .= '</div>';
        $out .= '</div>';
        return $out;
    }
}
add_shortcode( 'tabs', 'bymt_shortcode_tabs' );

// 音乐播放器
function bymt_shortcode_music( $atts, $content = '' ) {
    $attr = array(
        'src'      => $content,
        'preload' => 'metadata'
    );
    return wp_audio_shortcode( $attr );
}
add_shortcode( 'mp3', 'bymt_shortcode_music' );
add_shortcode( 'music', 'bymt_shortcode_music' );

// SWF播放器
function bymt_shortcode_swf( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'width' => '500',
        'height' => '300',
    ), $atts );
    return "<embed src=\"{$content}\" width=\"{$args['width']}\" height=\"{$args['height']}\" type=\"application/x-shockwave-flash\" allowScriptAccess=\"sameDomain\" allowfullscreen=\"true\" wmode=\"opaque\" quality=\"high\" />";
}
add_shortcode( 'swf', 'bymt_shortcode_swf' );

// FLV播放器
function bymt_shortcode_flv( $atts, $content = '' ) {
    $args = shortcode_atts( array(
        'width' => '500',
        'height' => '300',
    ), $atts );
    $player_src = bymt_static( 'swf/flvPlayer.swf' );
    return "<embed src=\"{$player_src}?file={$content}\" width=\"{$args['width']}\" height=\"{$args['height']}\" type=\"application/x-shockwave-flash\" allowScriptAccess=\"sameDomain\" allowfullscreen=\"true\" wmode=\"opaque\" quality=\"high\" />";
}
add_shortcode( 'flv', 'bymt_shortcode_flv' );

// 视频解析 - 腾讯视频
function wp_embed_handler_qq_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_qq', '<embed src="http://static.video.qq.com/TPout.swf?vid=' . esc_attr($matches[2]) . '&auto=0" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque" />', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'qq', '#http://v.qq.com/(.*?)vid=(\w+)#i', 'wp_embed_handler_qq_1' );

// 视频解析 - BILIBILI
function wp_embed_handler_bilibili_1( $matches, $attr, $url, $rawattr ) {
    $mp4_data = bymt_remote_retrieve( array(
        'url' => 'http://www.bilibili.com/m/html5?aid=' . $matches[3] . '&page=1',
    ) );
    if ( $mp4_data ) {
        $mp4_json = json_decode( $mp4_data, true );
        $embed = '<video id="video-' . $matches[3] . '" class="wp-video-shortcode" width="100%" height="450" src="' . $mp4_json['src'] . '" poster="' . $mp4_json['img'] . '" preload="metadata"></video>';
    } else {
        $embed = '<embed src="http://static.hdslb.com/miniloader.swf?aid=' . esc_attr($matches[3]) . '&page=1" width="100%" height="100%" type="application/x-shockwave-flash" allowScriptAccess="sameDomain" allowfullscreen="true" wmode="opaque" quality="high" />';
    }
    return apply_filters( 'embed_bilibili', $embed, $matches, $attr, $url, $rawattr );
}
wp_embed_register_handler( 'bilibili', '#http://(www.bilibili.(tv|com)|bilibili.kankanews.com)/video/av(\d+)#i', 'wp_embed_handler_bilibili_1' );

// 视频解析 - ACFUN
function wp_embed_handler_acfun_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_acfun', '<embed src="http://static.acfun.tv/player/ACFlashPlayer.out.swf?type=page&url=' . esc_attr($url) . '" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque" />', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'acfun', '#http://www.acfun.(tv|com)/v/ac(\d+)#i', 'wp_embed_handler_acfun_1' );

// 视频解析 - 酷六
function wp_embed_handler_ku6_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_ku6', '<embed src="http://player.ku6.com/refer/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque" />', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'ku6', '#http://v.ku6.com/show/([\w\.]+).html#i', 'wp_embed_handler_ku6_1' );

// 视频解析 - 56
function wp_embed_handler_56com_1($matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_56com', '<embed src="http://player.56.com/v_' . esc_attr($matches[3]) . '.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque" />', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( '56com', '#http://www.56.com/(\w+)/(v_|play_album\-aid\-[0-9]+_vid\-)(\w+)#i', 'wp_embed_handler_56com_1' );

// 视频解析 - 乐视
function wp_embed_handler_letv_1( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_letv', '<embed src="http://i7.imgs.letv.com/player/swfPlayer.swf?id=' . esc_attr($matches[1]) . '&autoplay=0" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque" />', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'letv', '#http://www.letv.com/ptv/vplay/(\d+).html#i', 'wp_embed_handler_letv_1' );

// 视频解析 - 音乐台
function wp_embed_handler_yinyuetai_1( $matches, $attr, $url, $rawattr ) { print_r($matches); return apply_filters( 'embed_yinyuetai', '<embed src="http://player.yinyuetai.com/' . esc_attr($matches[1]) . '/player/' . esc_attr($matches[2]) . '/v_0.swf" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque" />', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'yinyuetai', '#http://v.yinyuetai.com/(video|playlist)/(\d+)#i', 'wp_embed_handler_yinyuetai_1' );

// 编辑器按钮
function bymt_quicktags() {
echo <<< BYMT
<script type="text/javascript">
    window.QTags.addButton( 'bymt_archives', '文章归档', '[bymt_archives /]' );
    window.QTags.addButton( 'bymt_links', '友情链接', '[bymt_links /]' );
    window.QTags.addButton( 'bymt_reply', '评论可见', '[reply]', '[/reply]' );
    window.QTags.addButton( 'bymt_login', '登录可见', '[login]', '[/login]' );
    window.QTags.addButton( 'bymt_like', '喜欢可见', '[like]', '[/like]' );
    window.QTags.addButton( 'task', '项目面板', '[task]', '[/task]' );
    window.QTags.addButton( 'noway', '禁止面板', '[noway]', '[/noway]' );
    window.QTags.addButton( 'warning', '警告面板', '[warning]', '[/warning]' );
    window.QTags.addButton( 'buy', '购买面板', '[buy]', '[/buy]' );
    window.QTags.addButton( 'down', '下载面板', '[down]', '[/down]' );
    window.QTags.addButton( 'buttext', '文本按钮', '[buttext href="#链接" target="_blank"]', '[/buttext]' );
    window.QTags.addButton( 'butdocument', '文档按钮', '[butdocument href="#链接" target="_blank"]', '[/butdocument]' );
    window.QTags.addButton( 'butheart', '爱心按钮', '[butheart href="#链接" target="_blank"]', '[/butheart]' );
    window.QTags.addButton( 'butbox', '盒子按钮', '[butbox href="#链接" target="_blank"]', '[/butbox]' );
    window.QTags.addButton( 'butsearch', '搜索按钮', '[butsearch href="#链接" target="_blank"]', '[/butsearch]' );
    window.QTags.addButton( 'butlink', '链接按钮', '[butlink href="#链接" target="_blank"]', '[/butlink]' );
    window.QTags.addButton( 'butdown', '下载按钮', '[butdown href="#链接" target="_blank"]', '[/butdown]' );
    window.QTags.addButton( 'butnext', '箭头按钮', '[butnext href="#链接" target="_blank"]', '[/butnext]' );
    window.QTags.addButton( 'butaudio', '音频按钮', '[butaudio href="#链接" target="_blank"]', '[/butaudio]' );
    window.QTags.addButton( 'butvideo', '视频按钮', '[butvideo href="#链接" target="_blank"]', '[/butvideo]' );
    window.QTags.addButton( 'toggle', '收缩栏', '[toggle title="标题"]', '[/toggle]' );
    window.QTags.addButton( 'tabs', '选项卡', '[tabs][item title="标题"]内容[/item][item title="标题"]内容[/item][/tabs]' );
    window.QTags.addButton( 'swf', 'SWF播放器', '[swf width="500" height="300"]', '[/swf]' );
    window.QTags.addButton( 'flv', 'FLV播放器', '[flv width="500" height="300"]', '[/flv]' );
    window.QTags.addButton( 'bymt_php', '插入PHP代码', '<pre lang="php">','</pre>');
    window.QTags.addButton( 'bymt_html', '插入HTML代码', '<pre lang="html">','</pre>');
    window.QTags.addButton( 'bymt_css', '插入CSS代码', '<pre lang="css">','</pre>');
    window.QTags.addButton( 'bymt_js', '插入JS代码', '<pre lang="js">','</pre>');
</script>
BYMT;
}
add_action( 'after_wp_tiny_mce', 'bymt_quicktags', 50 );
