<?php !defined( 'WPINC' ) && exit();
/**
 * bymtFunctions.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

// 核心定义
define( 'BYMT_VER', '3.0.0' );
define( 'BYMT_UPDATE', '2015.08.12' );
define( 'BYMT_AUTHORIZE', 'Release' );
define( 'BYMT_DIR', get_template_directory() );

get_template_part( 'mcdo/bymtPosts' );
get_template_part( 'mcdo/bymtComments' );
get_template_part( 'mcdo/bymtAjax' );
get_template_part( 'mcdo/bymtWidgets' );
get_template_part( 'mcdo/bymtShortcodes' );
if ( is_admin() ) {
    get_template_part( 'mcdo/bymtOptions' );
}

// 获取配置信息
function bymt_option( $key ) {
    $option = get_option( 'bymt_options_v3' );
    if ( isset( $option[$key] ) ) {
        return $option[$key];
    }
    return;
}

// 定义配置信息
function bymt_define( $key, $val ) {
    return bymt_option( $key ) ? bymt_option( $key ) : esc_attr( $val );
}

// 对比配置信息
function bymt_contrast( $old_val, $new_val ) {
    return bymt_option( $old_val ) === $new_val;
}

// 判断配置信息并输出对应值
function bymt_output( $key, $val ) {
    return bymt_option( $key ) ? $val : '';
}

// 获取 $_GET 参数
function bymt_args_get( $key ) {
    return isset( $_GET[$key] ) ? $_GET[$key] : null;
}

// 获取 $_POST 参数
function bymt_args_post( $key ) {
    return isset( $_POST[$key] ) ? $_POST[$key] : null;
}

// 获取 $_SERVER 参数
function bymt_args_server( $key ) {
    return isset( $_SERVER[$key] ) ? $_SERVER[$key] : null;
}

// 获取 $_COOKIE 参数
function bymt_args_cookie( $key ) {
    return isset( $_COOKIE[$key] ) ? $_COOKIE[$key] : null;
}

// 判断 PJAX
function bymt_is_pjax(){
    return bymt_args_get('pjax') && bymt_args_server('HTTP_X_PJAX') && bymt_args_server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
}

// 是否是登录页
function bymt_is_login_page(){
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

// 主题静态资源
function bymt_static( $uri = '', $ext = false ) {
    $static_dir = get_stylesheet_directory_uri() . '/static';
    if ( bymt_option( 'cdn_static_on' ) && bymt_option( 'cdn_static_url' ) && $ext ) {
        $static_dir = bymt_option( 'cdn_static_url' );
        return trailingslashit( $static_dir ) . $uri;
    }
    $static_url = trailingslashit( $static_dir ) . $uri;
    return apply_filters( 'bymt_static', $static_url );
}

// 远程内容获取
function bymt_remote_retrieve( $args = array() ) {
    $default = array(
        'method' => 'GET',
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        'url' => null,
        'headers' => null,
        'body' => null,
        'sslverify' => false
    );
    $args = wp_parse_args( $args, $default );
    if ( is_null($args['url']) ) return;
    $url = $args['url'];
    unset($args['url']);
    if ($args['method'] === 'GET' ) {
        if (! is_null($args['body']) ) {
            $url .= '?'.http_build_query($args['body']);
        }
        unset($args['body']);
    }
    $response = wp_remote_retrieve_body( wp_safe_remote_request($url, $args) );
    return $response;
}

// base64 安全编解码
function bymt_base64( $str, $do = 'encode' ) {
    if ( !$str ) return;
    $from = array( '+', '/', '==', '=' );
    $to = array( '-M-', '-C-', '-MC-', '_' );
    if ( $do === 'encode' ) {
        return str_replace( $from, $to, base64_encode( $str ) );
    }
    if ( $do === 'decode' ) {
        return base64_decode( str_replace( $to, $from, $str ) );
    }
    return;
}

// 引入不同的文章形式
function bymt_include_post_format( $icon = false ){
    $post_format = get_post_format();
    $supported = get_theme_support( 'post-formats' );
    $format = 'standard';
    if ( in_array($post_format, $supported[0]) ) {
        $format = $post_format;
    }
    if ( $icon ) {
        if ( post_password_required() ) {
            $format = 'lock';
        }
        if ( $icon === 'format' ) return $format;
        if ( $icon === 'icon' ) return '<i class="iconfont icon-' . $format . '"></i>';
    }
    return include( locate_template( 'mcdo/format/' . $format . '.php' ) );
}

// 获取侧栏 class
function bymt_sidebar_class( $display = false ) {
    if ( !bymt_option( 'sidebar' ) ) return;
    $float = bymt_define( 'sidebar_float', 'fr' );
    if ( $display ) {
        return ' ' . $float;
    }
    return bymt_output( 'sidebar', ' has-sidebar' ) . ' sldebar-' . $float;
}

// LOGO
function bymt_logo( $place = 'header' ) {
    if ( $place === 'header' ) {
        $logo_src = esc_url( bymt_define( 'logo_src', bymt_static( 'images/logo@3x.png' ) ) );
    } elseif ( $place === 'footer' ) {
        $logo_src = esc_url( bymt_define( 'footer_logo_src', bymt_static( 'images/foot-logo@3x.png' ) ) );
    } else {
        return;
    }
    $logo_id = '';
    $logo_href = esc_url( home_url( '/' ) );
    $logo_alt = esc_attr( get_bloginfo( 'name' ) );
    if ( $place === 'header' && bymt_option( 'header_logo_animation' ) ) {
        $logo_id = 'id="bymt-logo" ';
    }
    return "<a {$logo_id}href=\"{$logo_href}\" rel=\"home\"><img src=\"{$logo_src}\" alt=\"{$logo_alt}\" /></a>";
}

// Favicon
function bymt_favicon() {
    return esc_url( bymt_define( 'favicon_src', bymt_static( 'images/favicon.png' ) ) );
}

// 公告栏
function bymt_bulletin( $place = '' ) {
    if ( !bymt_option( 'bulletin' ) ) return;
    $bulletin_id = bymt_option( 'bulletin_id' );
    $bulletin_number = bymt_option( 'bulletin_number' );
    $bulletin_custom = bymt_option( 'bulletin_custom' );
    if ( !$bulletin_id || !$bulletin_number ) return;
    $output = '<div id="bymt-bulletin" class="bymt-bulletin container"><i class="iconfont icon-bulletin"></i>';
    if ( bymt_option( 'bulletin_custom_on' ) && $bulletin_custom ) {
        $output .= "<div class=\"blt-content blt-text\">{$bulletin_custom}</div>";
    } else {
        $comments = get_comments( array( 'post_id' => $bulletin_id, 'number' => $bulletin_number ) );
        if ( empty($comments) ) return;
        $output .= '<ul id="bulletin-list" class="blt-list clearfix">';
        foreach ($comments as $comment) {
            $content = strip_shortcodes( $comment->comment_content );
            $time = esc_html( bymt_time_ago( 'comment', $comment->comment_date ) );
            $output .= "<li class=\"blt-text\">{$content}<span class=\"time\">( {$time} )</span></li>";
        }
        $output .= '</ul>';
    }
    $output .= '<a class="iconfont icon-close"></a></div>';
    return $output;
}

// 焦点图 - 输入图片列表
function bymt_slider( $place = '' ) {
    if ( !$place ) return;
    $output = '';
    $img_list = array();
    switch ($place) {
        case 'header':
            $slider_bool = bymt_option( 'slider_header_in_singular' ) ? ( is_home() || is_front_page() || is_singular() ) : ( is_home() || is_front_page() );
            if ( !bymt_option( 'slider_header' ) || !$slider_bool ) return;
            $img_list = bymt_slider_imglist( 'header' );
            break;
        case 'widget':
            if ( !bymt_option( 'slider_widget' ) ) return;
            $img_list = bymt_slider_imglist( 'widget' );
            break;
    }
    if ( empty( $img_list ) ) return;
    $output .= '<div class="bymt-slider bymt-' . $place . '-slider">';
    $output .= '<ul class="slides clearfix">';
    foreach ($img_list as $img) {
        $output .= '<li><a href="' . esc_url( $img['href'] ) . '"><img class="transition3" src="' . esc_url( $img['src'] ) . '" alt="' . esc_attr( $img['alt'] ) . '"></a></li>';
    }
    $output .= '</ul>';
    $output .= "</div>\n";
    return $output;
}
// 焦点图 - 获取配置信息
function bymt_slider_config( $place ){
    $config = '';
    if ( bymt_option( 'slider_' . $place ) && count( bymt_slider_imglist( $place ) ) > 1 ) {
        $config = array(
            'slideshow' => bymt_option( 'slider_' . $place . '_auto' ) ? true : false,
            'animationLoop' => bymt_option( 'slider_' . $place . '_loop' ) ? true : false,
            'randomize' => bymt_option( 'slider_' . $place . '_rand' ) ? true : false,
            'mousewheel' => bymt_option( 'slider_' . $place . '_mouse' ) ? true : false,
            'keyboard' => bymt_option( 'slider_' . $place . '_keyboard' ) ? true : false,
            'animation' => bymt_option( 'slider_' . $place . '_slide' ) ? 'slide' : 'fade',
            'direction' => bymt_option( 'slider_' . $place . '_vertical' ) ? 'vertical' : 'horizontal',
            'animationSpeed' => bymt_define( 'slider_' . $place . '_speed_a', '600' ),
            'slideshowSpeed' => bymt_define( 'slider_' . $place . '_speed_s', '5000' )
        );
    }
    return $config;
}
// 焦点图 - 获取图片列表
function bymt_slider_imglist( $place = '' ){
    $count = array(
        'header' => 8,
        'widget' => 5,
    );
    if ( !$place || !array_key_exists( $place, $count ) ) return;
    $img_list = array();
    for ($i = 1; $i <= $count[$place]; $i++) {
        $src = bymt_option( 'slider_' . $place . '_img_src_' . $i );
        $alt = bymt_option( 'slider_' . $place . '_img_alt_' . $i );
        $href = bymt_option( 'slider_' . $place . '_img_href_' . $i );
        if ( empty( $src ) ) continue;
        $img_list[$i]['src'] = $src;
        $img_list[$i]['alt'] = $alt ? $alt : 'slider-' . $i;
        $img_list[$i]['href'] = $href ? $href : '#';
    }
    return $img_list;
}

// 输出Gravatar头像
function bymt_gravatar( $email, $size = '50', $alt = 'avatar', $lazy = true ) {
    $mail_hash = md5( strtolower( trim( $email ) ) );
    $gravatar_url = bymt_option( 'gravatar_proxy' ) ? trailingslashit( bymt_define( 'gravatar_proxy_url', 'http://gravatar.moefont.com/avatar' ) ) : '';
    if ( $gravatar_url ) {
        $avatar_url = esc_url( $gravatar_url . $mail_hash . '?s=' . $size . '&d=retro' );
        $avatar_url_x2 = esc_url( $gravatar_url . $mail_hash . '?s=' . $size * 2 . '&d=retro' );
        $avatar_url_x3 = esc_url( $gravatar_url . $mail_hash . '?s=' . $size * 3 . '&d=retro' );
    } else {
        $avatar_url = get_avatar_url( $email, array( 'size' => $size ) );
        $avatar_url_x2 = get_avatar_url( $email, array( 'size' => $size * 2 ) );
        $avatar_url_x3 = get_avatar_url( $email, array( 'size' => $size * 3 ) );
    }
    $image_attr = "class=\"avatar avatar-{$size}\" src=\"{$avatar_url}\"";
    if ( bymt_option( 'img_lazyload' ) && $lazy ) {
        $lazy_src = bymt_static( 'images/img_lazy.png' );
        $image_attr = "class=\"lazy avatar avatar-{$size}\" data-original=\"{$avatar_url}\" src=\"{$lazy_src}\"";
    }
    return "<img {$image_attr} srcset=\"{$avatar_url_x2} 2x, {$avatar_url_x3} 3x\" alt=\"{$alt}\" width=\"{$size}\" height=\"{$size}\">";
}

// 摘要
function bymt_description() {
    global $s, $post;
    $blog_name = get_bloginfo( 'name' );
    if ( is_singular() ) {
        $ID = $post->ID;
        $title = $post->post_title;
        $author = get_userdata( $post->post_author )->display_name;
        $categories = wp_strip_all_tags( get_the_category_list( ', ', '', $post->ID ) );
        $content = do_shortcode( $post->post_content );
        $content = preg_replace( '/<img[\s\S]*?>/isu', __('[图片]'), $content );
        $content = preg_replace( '/<(audio|video|embed)[\s\S]*?><\/\\1>/isu', __('[音视频]'), $content );
        $content = strip_shortcodes( $content );
        $description = "{$categories} - {$author} - {$content}";
    } elseif ( is_home () || is_front_page() ) {
        $description = bymt_define( 'home_description', get_bloginfo( 'description', 'display' ) );
    } elseif ( is_category () ) {
        $description = single_cat_title( 'Category: ', false );
        if ( category_description() ) $description .= ' - '. category_description();
    } elseif ( is_tag () ) {
        $description = single_tag_title( 'Tag: ', false );
        if ( tag_description() ) $description .= ' - '. tag_description();
    } elseif ( is_search () ) {
        $description = __('搜索关键词 ') . esc_html( '"' . get_search_query() . '"' ) . ' - ' . $blog_name;
    } else {
        $description = get_the_archive_title() . ' - ' . $blog_name;
    }
    $description = wp_html_excerpt( $description, 200, '...' );
    if ( !$description ) {
        $description = $title;
    }
    return esc_html( $description );
}

// 面包屑导航
function bymt_breadcrumbs( $class = '' ) {
    if ( !bymt_option( 'breadcrumb_show' ) ) {
        return;
    }
    global $post, $page, $paged;
    $delimiter  = '<span class="crumbs-span">/</span>';
    $home       = '<i class="iconfont icon-location"></i>' . __( '首页' );
    $before     = '<span class="current">';
    $after      = '</span>';
    $html = '<div class="bymt-breadcrumbs ' . $class . '" itemprop="breadcrumb"><div class="crumbs">';
    $html .= '<a href="' . esc_url( home_url( '/' ) ) . '">' . $home . '</a>' . $delimiter;
    if ( is_home() || is_front_page() ) {
        if ( bymt_option( 'breadcrumb_not_home' ) && !$paged ) {
            return;
        }
        $html .= __( '所有文章' );
    } elseif ( is_single() ) {
        $categories = get_the_category_list( ', ', '', $post->ID );
        $html .= $categories . $delimiter . $before . __( '正文' ) . $after;
    } elseif ( is_page() ) {
        $parent_id  = $post->post_parent;
        if ( $parent_id ) {
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . wp_trim_words( get_the_title($page->ID), 20 ) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                $html .= $crumb . $delimiter;
            }
        }
        $html .= $before . get_the_title() . $after;
    } elseif ( is_search() ) {
        $html .= $before . __('搜索关键词 ') . '"' . get_search_query() . '"' . $after;
    } elseif ( is_attachment() ) {
        $parent = get_post( $post->post_parent );
        $categories = get_the_category_list( ', ', '', $parent->ID );
        $html .= $categories . $delimiter . '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . wp_trim_words( esc_attr( $parent->post_title ), 20 ) . '</a>' . $delimiter;
        $html .= $before . __( '附件' ) . $after;
    } elseif ( is_404() ) {
        $html .= $before . __('错误页 404') . $after;
    } else {
        $html .= $before . get_the_archive_title() . $after;
    }
    if ( $paged > 1 || $page > 1 ) {
        $html .= $delimiter . $before . __('页码：') . '<em id="list-paged">' .( $page ? $page : $paged ) . '</em>' . $after;
    }
    $html .= '</div></div>';
    return $html;
}

// 个性化时间
function bymt_time_ago( $time_type = 'post', $time = '' ) {
    $day = absint( bymt_define( 'time_ago_day', 30 ) );
    $get_time = ( $time_type === 'post' ) ? 'get_the_time' : 'get_comment_time';
    $get_date = ( $time_type === 'post' ) ? 'get_the_date' : 'get_comment_date';
    $time_unix = ( $time ) ? mysql2date( 'U', $time, false ) : $get_time( 'U' );
    $time_diff = current_time( 'timestamp' ) - $time_unix;
    if ( bymt_option( 'time_ago' ) && $time_diff <= 60*60*24*$day ) {
        return human_time_diff( $time_unix, current_time( 'timestamp' ) ) . __( '前' );
    }
    if ( $time ) {
        return date( 'Y-m-d H:i:s', $time_unix );
    }
    return sprintf( _x( '%1$s at %2$s', '1: date, 2: time' ), $get_date(), $get_time() );
}

// 版权信息
function bymt_copyright() {
    $foot_copr = '<div class="copyright">';
    if ( bymt_option( 'foot_copr' ) ) {
        $foot_copr .= bymt_option( 'foot_copr' );
    } else {
        $date_year = date('Y', time());
        $blog_url = esc_url( home_url( '/' ) );
        $blog_name = esc_attr( get_bloginfo( 'name' ) );
        $foot_copr .= "&copy; {$date_year} <a href=\"{$blog_url}\">{$blog_name}</a> All Rights Reserved.";
    }
    $foot_copr .= '</div>';
    $foot_copr .= '<div class="powered"><a href="https://wordpress.org/" title="WordPress"><i class="iconsocial social-wordpress"></i></a> <a href="https://maicong.me/bymt/v3?ref=v' . BYMT_VER . '">BYMT ' . BYMT_VER . '</a> &nbsp; Theme by <a href="https://maicong.me">MaiCong</a></div>';
    if ( bymt_option( 'stat_code' ) ) {
        $foot_copr .= '<div class="sitestat">' . bymt_option( 'stat_code' ) . '</div>';
    }
    if ( bymt_option( 'footer_back_top' ) ) {
        $foot_copr .= '<a id="backtop" class="backtop" href="#"><i class="iconfont icon-backtop"></i></a>';
    }
    return $foot_copr;
}

// 广告位
function bymt_advert( $place = '' ) {
    if ( !$place ) return;
    $id = str_replace( '_', '-', $place );
    $advert = bymt_option( $place );
    $advert_on = bymt_option( $place . '_on' );
    $noby = ( $place !== 'ad_widget_grid' ) ? ( empty($advert) || !$advert_on ) : !$advert_on;
    if ( $noby ) return;
    $output = "<div class=\"bymt-advert {$id} clearfix\">";
    if ( $place === 'ad_widget_grid' ) {
        for ($i=1; $i<=8; $i++) {
            $i_advert = bymt_option( 'ad_widget_grid_n_' . $i );
            $i_advert_on = bymt_option( 'ad_widget_grid_on_' . $i );
            if ( empty($i_advert)|| !$i_advert_on ) continue;
            $output .= "<div class=\"bymt-ad-grid\">{$i_advert}</div>";
        }
    } else {
        $output .= $advert;
    }
    $output .= "</div>";
    return $output;
}

// 获取IP归属地
function bymt_get_isp( $ip = '', $rtb = false ){
    if ( !$ip ) return;
    $isp = __( '未知' );
    $args_ip = array(
        'url'   => 'http://ip.taobao.com/service/getIpInfo.php',
            'body' => array(
            'ip' => $ip
        )
    );
    $args_rtb = array(
        'url'   => 'http://ip.rtbasia.com/ipip',
            'body' => array(
            'ipstr' => $ip
        )
    );
    $response = bymt_remote_retrieve( $args_ip );
    if ( !$response ) return;
    $result = json_decode( $response, true );
    if ( $result['code'] === 0 ) {
        $isp = $result['data']['country'] . $result['data']['city'] . $result['data']['county'] . $result['data']['isp'];
    }
    if ( $rtb ) {
        $rtb_info = str_replace( "&nbsp;", "", wp_strip_all_tags( bymt_remote_retrieve( $args_rtb ) ) );
        $isp .= !empty( $rtb_info ) ? ' - ' . $rtb_info : '';
    }
    return $isp;
}

// 设置主题
function bymt_act_setup() {
    if ( !function_exists( 'bymt_base64' ) ) {
        exit( '<meta charset="utf-8"><h3>&#x4E3B;&#x9898;&#x6587;&#x4EF6;&#x9519;&#x8BEF;&#xFF01;</h3>' );
    }
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );
    add_theme_support( 'post-formats', array(
        'image', 'gallery', 'quote', 'link', 'audio', 'video'
    ) );
    add_theme_support( 'post-thumbnails' );
    add_editor_style( bymt_static( 'css/editor.css' ) );
    set_post_thumbnail_size( 300, 200, true );
    register_nav_menus( array(
        'header'   => __( '页头导航' ),
        'footer' => __( '页脚导航（只能是一级菜单）' )
    ) );
    add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'bymt_act_setup' );

// 加载主题脚本和样式
function bymt_scripts_styles() {
    if ( is_admin() ) return;
    wp_enqueue_style( 'bymt-core', bymt_static( 'css/bymt-core.css' ), array(), BYMT_VER );
    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'jquery-migrate' );
    $jq_ver = '1.11.3';
    $jq_src = bymt_static( "js/jquery-{$jq_ver}.min.js" );
    $jq_migrate_ver = '1.2.1';
    $jq_migrate_src = bymt_static( "js/jquery-migrate-{$jq_migrate_ver}.min.js") ;
    $jq_in_footer = bymt_option( 'jquery_src_in_footer' ) ? true : false;
    switch ( bymt_option( 'jquery_src' ) ) {
        case 'self':
            $wp_scripts = new WP_Scripts();
            $jq_src = $wp_scripts->registered['jquery-core']->src;
            $jq_ver = $wp_scripts->registered['jquery-core']->ver;
            $jq_migrate_src = $wp_scripts->registered['jquery-migrate']->src;
            $jq_migrate_ver = $wp_scripts->registered['jquery-migrate']->ver;
            break;
        case 'custom':
            $jq_src = bymt_define( 'jquery_src_custom_src', $jq_src );
            break;
        case 'google':
            $jq_src = "http://ajax.googleapis.com/ajax/libs/jquery/{$jq_ver}/jquery.min.js";
            break;
        case 'microsoft':
            $jq_src = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-{$jq_ver}.min.js";
            break;
        case 'bootcdn':
            $jq_src = "http://cdn.bootcss.com/jquery/{$jq_ver}/jquery.min.js";
            break;
        case 'cdnjs':
            $jq_src = "http://cdnjs.cloudflare.com/ajax/libs/jquery/{$jq_ver}/jquery.min.js";
            break;
        case 'jquery':
            $jq_src = "http://code.jquery.com/jquery-{$jq_ver}.min.js";
            break;
        case 'jsdelivr':
            $jq_src = "http://cdn.jsdelivr.net/jquery/{$jq_ver}/jquery.min.js";
            break;
            break;
        case 'theme':
        default:
            $jq_src = bymt_static( "js/jquery-{$jq_ver}.min.js" );
            break;
    }
    wp_enqueue_script( 'jquery', esc_url( $jq_src ), array(), $jq_ver, $jq_in_footer);
    if ( bymt_option( 'jquery_plugs_migrate' ) ) {
        wp_enqueue_script( 'jquery-migrate', esc_url( $jq_migrate_src ), array( 'jquery' ), $jq_migrate_ver, $jq_in_footer);
    }
    if ( bymt_option( 'code_highlight' ) && is_singular() ) {
        wp_enqueue_script( 'bymt-highlight', bymt_static( 'js/highlight.min.js' ), array( 'jquery' ), '8.7', true);
    }
    wp_register_script( 'bymt-flexslider', bymt_static( 'js/jquery.flexslider-min.js' ), array( 'jquery' ), '2.5.0', true);
    $bymt_config = array(
        'home_url' => esc_url( home_url( '/' ) ),
        'static_url' => bymt_static( '', true ),
        'ajax_url' => admin_url('admin-ajax.php'),
        'sidebar_auto_height' => bymt_option( 'sidebar_auto_height' ) ? 'on' : 'off',
        'img_lazyload' => bymt_option( 'img_lazyload' ) ? 'on' : 'off',
        'img_lightbox' => bymt_option( 'img_lightbox' ) ? 'on' : 'off',
        'tooltip' => bymt_option( 'tooltip_show' ) ? 'on' : 'off',
        'tooltip_layout' => bymt_define( 'tooltip_layout', 'auto bottom' ),
        'load_effect' => bymt_option( 'load_effect' ) ? 'on' : 'off',
        'code_highlight' => ( bymt_option( 'code_highlight' ) && is_singular() ) ? 'on' : 'off',
        'comment_tools' => ( bymt_option( 'comment_tools' ) && is_singular() ) ? 'on' : 'off',
        'ajax_search' => bymt_option( 'ajax_search' ) ? 'on' : 'off',
        'ajax_comment' => bymt_option( 'ajax_comment' ) ? 'on' : 'off',
        'pjax_page_post' => ( bymt_option( 'pjax_page_post' )  && !is_singular() ) ? 'on' : 'off',
        'pjax_page_comment' => ( bymt_option( 'pjax_page_comment' ) && is_singular() ) ? 'on' : 'off',
        'slider_header' => bymt_option( 'slider_header') ? 'on' : 'off',
        'slider_widget' => bymt_option( 'slider_widget' ) ? 'on' : 'off',
        'slider_header_opt' => bymt_slider_config( 'header' ),
        'slider_widget_opt' => bymt_slider_config( 'widget' ),
    );
    if ( !empty($bymt_config['slider_header_opt']) || !empty($bymt_config['slider_widget_opt']) ) {
        wp_enqueue_script( 'bymt-flexslider' );
    }
    wp_enqueue_script( 'bymt-core', bymt_static( 'js/bymt-core.js' ), array( 'jquery' ), BYMT_VER, true);
    wp_localize_script( 'bymt-core', 'BYMT', $bymt_config );
}
add_action( 'wp_enqueue_scripts', 'bymt_scripts_styles' );

// 结构化数据元信息
function bymt_structured_data() {
    if ( !bymt_option( 'header_str_data_on' ) || !is_single() ) return;
    global $post;
    $author = $post->post_author;
    $d_image = bymt_thumbnail( '800', 0, false, true );
    $d_title = wp_title( bymt_define('delimiter', '|'), false, 'right' );
    $d_desc = bymt_description();
    $d_author = get_the_author_meta( 'display_name', $post->post_author );
    $d_date = get_the_date( 'Y-m-d' );
    $output = "<meta property=\"og:type\" content=\"blog\" />\n";
    $output .= "<meta property=\"og:image\" content=\"{$d_image}\" />\n";
    $output .= "<meta property=\"og:title\" content=\"{$d_title}\" />\n";
    $output .= "<meta property=\"og:description\" content=\"{$d_desc}\" />\n";
    $output .= "<meta property=\"og:author\" content=\"{$d_author}\" />\n";
    $output .= "<meta property=\"og:release_date\" content=\"{$d_date}\" />\n";
    echo $output;
}
add_action( 'wp_head', 'bymt_structured_data', 1 );

// 自定义元信息
function bymt_head_meta(){
    if ( bymt_option( 'header_meta_on' ) ) {
        echo bymt_option( 'header_meta' );
    }
}
add_action( 'wp_head', 'bymt_head_meta', 1 );

// admin bar style
function bymt_admin_bar_style() {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
    $top = $top_m = 0;
    if ( is_admin_bar_showing() ) {
        $top = '32px';
        $top_m = '46px';
    }
    if ( bymt_option('header_nav_fixed' ) ) {
        $top = '65px';
        $top_m = '79px';
    }
    if ( is_admin_bar_showing() && bymt_option('header_nav_fixed' ) ) {
        $top = '97px';
        $top_m = '111px';
    }
    if ($top && $top_m) {
echo <<< BYMT
<style type="text/css" media="screen">
    html { margin-top: {$top} !important; }
    * html body { margin-top: {$top} !important; }
    @media screen and ( max-width: 782px ) {
        html { margin-top: {$top_m} !important; }
        * html body { margin-top: {$top_m} !important; }
    }
</style>\n
BYMT;
    }
}
add_action( 'wp_head', 'bymt_admin_bar_style', 9 );

// CDN 地址处理
function bymt_cdn( $url ){
    if ( ( is_admin() && !bymt_option( 'cdn_admin' ) ) || !bymt_option( 'cdn_ext' ) ) {
        return $url;
    }
    $static_dir = get_stylesheet_directory_uri() . '/static';
    $upload_dir = wp_upload_dir();
    $includes_url = includes_url();
    $plugins_url = plugins_url();
    $cdn_static_url = bymt_option( 'cdn_static_url' );
    $cdn_upload_url = bymt_option( 'cdn_upload_url' );
    $cdn_include_url = bymt_option( 'cdn_include_url' );
    $cdn_plugin_url = bymt_option( 'cdn_plugin_url' );
    $cdn_ext = rtrim( trim( bymt_option( 'cdn_ext' ) ), '|' );
    $match_url = $replace_url = array();
    $pattern_url = '';
    if ( bymt_option( 'cdn_static_on' ) && $cdn_static_url ) {
        $match_url[] = $static_dir;
        $replace_url[$static_dir] = $cdn_static_url;
    }
    if ( bymt_option( 'cdn_upload_on' ) && $cdn_upload_url ) {
        $match_url[] = $upload_dir['baseurl'];
        $replace_url[$upload_dir['baseurl']] = $cdn_upload_url;
    }
    if ( bymt_option( 'cdn_include_on' ) && $cdn_include_url ) {
        $match_url[] = $includes_url;
        $replace_url[$includes_url] = $cdn_include_url;
    }
    if ( bymt_option( 'cdn_plugin_on' ) && $cdn_upload_url ) {
        $match_url[] = $plugins_url;
        $replace_url[$plugins_url] = $cdn_plugin_url;
    }
    foreach ( $match_url as $val ) {
        $pattern_url .= preg_quote( $val ) . '|';
    }
    $pattern_url = rtrim( $pattern_url, '|' );
    $pattern = '@(' . $pattern_url . ')(.+?\.(?:' . $cdn_ext . ')+?)@i';
    preg_match_all( $pattern, $url, $matches, PREG_SET_ORDER );
    foreach ($matches as $key => $val) {
        if ( !$val[1] ) continue;
        $url = str_replace( $val[1], $replace_url[$val[1]], $url );
    }
    return $url;
}
add_filter( 'bymt_static', 'bymt_cdn', 30 );
add_filter( 'script_loader_src', 'bymt_cdn', 30 );
add_filter( 'style_loader_src', 'bymt_cdn', 30 );
add_filter( 'wp_get_attachment_url', 'bymt_cdn', 30 );
add_filter( 'wp_mime_type_icon', 'bymt_cdn', 30 );
add_filter( 'wp_audio_shortcode', 'bymt_cdn', 30 );
add_filter( 'wp_video_shortcode', 'bymt_cdn', 30 );
add_filter( 'the_content', 'bymt_cdn', 30 );

// 标题处理
function bymt_wp_title( $title = '' ) {
    global $paged, $page;
    if ( is_feed() ) return $title;
    if ( !$title ) {
        $title = get_bloginfo( 'name', 'display' );
    } else {
        $title .= get_bloginfo( 'name', 'display' );
    }
    $delimiter = bymt_define('delimiter', '|');
    $description = esc_html( get_bloginfo( 'description', 'display' ) );
    if ( $description && ( is_home() || is_front_page() ) ) {
        $title .= " {$delimiter} {$description}";
    }
    if ( bymt_option( 'home_title' ) && ( is_home() || is_front_page() ) ) {
        $title = esc_html( bymt_option( 'home_title' ) );
    }
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        $title .= " " . $delimiter . " " . sprintf( __( '第 %s 页'), max( $paged, $page ) );
    }
    return $title;
}
add_filter( 'wp_title', 'bymt_wp_title' );

// Emoji 表情地址
function bymt_emoji_url( $emoji_url ) {
    if ( bymt_contrast( 'emoji_url', 'custom' ) ) {
        $emoji_url = esc_url( bymt_define( 'emoji_url_custom_src', $emoji_url ) );
    }
    return $emoji_url;
}
add_filter( 'emoji_url', 'bymt_emoji_url' );

// 友情链接
function bymt_link_manager() {
    return bymt_option( 'link_manager' ) ? true : false;
}
add_filter( 'pre_option_link_manager_enabled', 'bymt_link_manager' );

// 自动时间戳重命名
function bymt_sanitize_file_name( $filename ) {
    if ( bymt_option( 'sanitize_file' ) ) {
        $info = pathinfo( $filename );
        $ext = !empty($info['extension']) ? '.' . $info['extension'] : '';
        $filename = str_replace( '.', '', microtime( true ) ) . $ext;
    }
    return $filename;
}
add_filter( 'sanitize_file_name', 'bymt_sanitize_file_name', 10 );

// 去掉 所有 generator
function bymt_remove_feed_generator() {
    if ( bymt_option( 'wp_generator' ) ) {
        $type = array( 'html', 'xhtml', 'atom', 'rss2', 'rdf', 'comment', 'export' );
        foreach ( $type as $key => $val ) {
            add_filter( 'get_the_generator_'.$val, function( $gen ) {
                return '';
            });
        }
    }
}
add_action( 'init', 'bymt_remove_feed_generator' );

// URL 跳转
function bymt_url_redirect(){
    $url = bymt_args_get( 'url' );
    if ( $url ) {
        $url = ( bymt_base64( bymt_base64( $url, 'decode' ) ) === $url ) ? bymt_base64( $url, 'decode' ) : $url;
        if ( strpos( bymt_args_server( 'HTTP_REFERER' ), esc_url( home_url( '/' ) ) ) !== false ) {
            header( 'Location: ' . $url );
            exit();
        } else {
            header( 'Location: ' . esc_url( home_url( '/' ) ) );
            exit();
        }
    }
}
add_action( 'init', 'bymt_url_redirect' );

// 安全登录 - 邮件提醒
function bymt_login_security_mail( $type = '', $username = '' ) {
    if ( !$type || !$username || defined( 'XMLRPC_REQUEST' ) ) {
        return;
    }
    $user = get_user_by( 'login', $username );
    $user_email = ( $user && $user->user_email ) ? esc_attr( $user->user_email ) : '';
    $admin_email = get_bloginfo( 'admin_email' );
    $send_user = ( $user_email && bymt_option( "login_security_mail_{$type}_user" ) ) ? true : false;
    $send_admin = bymt_option( "login_security_mail_{$type}_admin" ) ? true : false;
    $login_name = bymt_args_post( 'log' );
    $login_pwd = bymt_args_post( 'pwd' );
    $login_to = bymt_args_post( 'redirect_to' );
    $login_url = bymt_args_server( 'HTTP_REFERER' );
    $login_IP = bymt_args_server( 'REMOTE_ADDR' );
    $login_ISP = $login_IP ? bymt_get_isp( $login_IP, true ) : __( '未知' );
    $login_IP = $login_IP . ' ( ' . $login_ISP . ' )';
    $login_time = date( "Y-m-d H:i:s", current_time( 'timestamp' ) );
    $blog_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    $blog_url = esc_url( home_url( '/' ) );
    $wp_email = 'wordpress@' . preg_replace( '#^www\.#', '', strtolower( bymt_args_server( 'SERVER_NAME' ) ) );
    $from = "From: \"{$blog_name}\" <{$wp_email}>";
    $headers = "{$from}\nContent-Type: text/html; charset=\"" . get_option( 'blog_charset' ) . "\"\n";
    $info_cat = $type === 'success' ? __( '登录成功' ) : __( '登录异常' );
    $info_tip_user = $type === 'success' ? __( '请核实以上信息是否属实，如有疑问请联系网站管理员' ) : __( '请核实是否是本人操作，如有疑问请更改密码或联系网站管理员' );
    $info_tip_admin = $type === 'success' ? __( '请与用户核实以上信息是否属实，如有疑问请尽快处理。' ) : __( '请与用户核实是否是本人操作，如有疑问请尽快处理。' );
    $show_pwd = ( $type === 'success' ) ? '' : "<li><strong>登录密码：</strong>{$login_pwd}</li>";
    $show_analysis = ( $type === 'success' ) ? '' : "<li><strong>异常分析：</strong>帐号密码错误或登录字段错误</li>";
    $show_user = $user ? "{$username} ({$user_email})" : "{$username} (不存在)";
    $subject_user = "[{$info_cat}] 您的账户 {$username} 于 {$login_time} 在 {$blog_name} {$info_cat}！";
    $subject_admin = "[用户{$info_cat}] 管理员您好，您的博客用户 {$username} 于 {$login_time} {$info_cat}！";
    $message_user = "<h3>尊敬的用户 {$show_user}：</h3><p>系统检测到您的账户于 [ {$login_time} ] 在 <a href=\"{$blog_url}\">{$blog_name}</a> {$info_cat}。登录信息如下：</p><ul><li><strong>登录名：</strong>{$login_name}</li>{$show_pwd}<li><strong>登录时间：</strong>{$login_time}</li><li><strong>登录IP：</strong>{$login_IP}</li><li><strong>登录地址：</strong>{$login_url}</li>{$show_analysis}</ul><p>{$info_tip_user}<{$admin_email}>。</p><p><small>系统邮件自动发送，请勿回复！ [ {$blog_name} ]</small></p>";
    $message_admin = "<h3>管理员您好！</h3><p>用户 {$show_user} 于 [ {$login_time} ] 在 <a href=\"{$blog_url}\">{$blog_name}</a> {$info_cat}。登录信息如下：</p><ul><li><strong>登录名：</strong>{$login_name}</li>{$show_pwd}<li><strong>登录时间：</strong>{$login_time}</li><li><strong>登录IP：</strong>{$login_IP}</li><li><strong>登录地址：</strong>{$login_url}</li><li><strong>跳转地址：</strong>{$login_to}</li>{$show_analysis}</ul><p>{$info_tip_admin}</p><p><small>系统邮件自动发送，请勿回复！ [ {$blog_name} ]</small></p>";
    if ( $send_user && $user_email !== $admin_email ) {
        @wp_mail( $user_email, wp_specialchars_decode( $subject_user ), $message_user, $headers );
    }
    if ( $send_admin ) {
        @wp_mail( $admin_email, wp_specialchars_decode( $subject_admin ), $message_admin, $headers );
    }
}

// 安全登录 - 登录成功邮件提醒
function bymt_login_security_mail_success( $username ) {
    if ( bymt_option( 'login_security_mail_success' ) ) {
        return bymt_login_security_mail( 'success', $username );
    }
}
add_action( 'wp_login', 'bymt_login_security_mail_success' );

// 安全登录 - 登录失败邮件提醒
function bymt_login_security_mail_fail( $username ) {
    if ( bymt_option( 'login_security_mail_fail' ) ) {
        return bymt_login_security_mail( 'fail', $username );
    }
}
add_action( 'wp_login_failed', 'bymt_login_security_mail_fail' );

// 安全登录 - 自定义登录字段
function bymt_login_security_args( $type = '' ){
    if ( !$type || !bymt_option( 'login_security_args' ) || defined( 'XMLRPC_REQUEST' ) ) {
        return;
    }
    $args_list = bymt_option( 'login_security_args_list' );
    $args_split = array_unique( preg_split( '/\r\n/', $args_list ) );
    $output = '';
    $valid_args = array();
    foreach ($args_split as $key => $args) {
        if ( !$args || strpos( $args, '=' ) === false ) continue;
        list($label, $val) = explode( '=', $args );
        $label = esc_html( $label );
        $name = 'safe_field_' . ( $key + 1 );
        $id = str_replace( '_', '-', $name );
        $valid_args[$name] = array( $label, $val );
        $output .= "<p>\n\t\t<label for=\"{$id}\">{$label}<br />\n\t\t<input type=\"text\" name=\"{$name}\" id=\"{$id}\" aria-describedby=\"login_error\" class=\"input\" value=\"\" /></label>\n\t</p>\n\t";
    }
    if ( $type === 'output' ) return $output;
    if ( $type === 'valid_args' ) return $valid_args;
}

// 安全登录 - 自定义登录字段 - 输出表单
function bymt_login_security_form(){
    echo bymt_login_security_args( 'output' );
}
add_action( 'login_form', 'bymt_login_security_form' );

// 安全登录 - 自定义登录字段 - 验证表单
function bymt_login_security_valid( $user ){
    if ( !bymt_option( 'login_security_args' ) || is_wp_error( $user ) || defined( 'XMLRPC_REQUEST' ) ) {
        return $user;
    }
    $valid_args = bymt_login_security_args( 'valid_args' );
    $error = new WP_Error();
    foreach ($valid_args as $name => $args) {
        $post_valid = trim( bymt_args_post( $name ) );
        if ( empty( $post_valid ) || $args[1] !== $post_valid ) {
            if ( empty( $post_valid ) ) {
                $error->add( 'empty_security_valid', __( '<strong>ERROR</strong>: ' ) . $args[0] . __( '不能为空' ) );
            }
            if ( $args[1] !== $post_valid ) {
                $error->add( 'invalid_security_valid', __( '<strong>ERROR</strong>: ' ) . $args[0] . __( '输入不正确' ) );
            }
            return $error;
        }
    }
    return $user;
}
function bymt_login_security_shake( $error_codes ) {
    $error_codes[] = 'empty_security_valid';
    $error_codes[] = 'invalid_security_valid';
    return $error_codes;
}
add_filter( 'authenticate', 'bymt_login_security_valid', 50, 2 );
add_filter( 'shake_error_codes', 'bymt_login_security_shake' );

// 默认头像
function bymt_add_avatar( $avatar_defaults ) {
    $bymt_avatar = esc_url( bymt_define( 'avatar_src', bymt_static( 'images/avatar.jpg' ) ) );
    $avatar_defaults[$bymt_avatar] = 'BYMT 默认头像';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'bymt_add_avatar' );

// 替换Gravatar地址
function bymt_gravatar_proxy( $url ) {
    $proxy_url = bymt_option( 'gravatar_proxy' ) ? trailingslashit( bymt_define( 'gravatar_proxy_url', 'gravatar.duoshuo.com/avatar' ) ) : '';
    $url = $proxy_url ? preg_replace( '@(\d|secure)+\.gravatar\.com/avatar@', $proxy_url, $url ) : $url;
    return $url;
}
add_filter( 'get_avatar_url', 'bymt_gravatar_proxy' );

// Google Ajax代理地址
function bymt_google_ajax_proxy( $src ){
    $proxy_src = bymt_option( 'google_ajax_proxy' ) ? trailingslashit( bymt_define( 'google_ajax_proxy_url', 'cdn.moefont.com/ajax' ) ) : '';
    $src = esc_url( $proxy_src ? preg_replace( '@ajax\.googleapis\.com@', $proxy_src, $src ) : $src );
    return $src;
}
add_filter( 'script_loader_src', 'bymt_google_ajax_proxy' );

// Google Ajax代理地址
function bymt_google_fonts_proxy( $src ){
    $proxy_src = bymt_option( 'google_fonts_proxy' ) ? trailingslashit( bymt_define( 'google_fonts_proxy_url', 'cdn.moefont.com/fonts' ) ) : '';
    $src = esc_url( $proxy_src ? preg_replace( '@fonts\.googleapis\.com@', $proxy_src, $src ) : $src );
    return $src;
}
add_filter( 'style_loader_src', 'bymt_google_fonts_proxy' );

// 小工具支持
function bymt_widgets_register() {
    if ( !function_exists('register_sidebars') ) return;
    register_sidebar(array(
        'name' => '侧栏(非内页)',
        'id'   => 'bymt-sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => '侧栏(内页)',
        'id'   => 'bymt-sidebar-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => '页脚(非内页)',
        'id'   => 'bymt-footbar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => '页脚(内页)',
        'id'   => 'bymt-footbar-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
}
add_action( 'widgets_init', 'bymt_widgets_register' );

// 缩略图过滤器 ( https://github.com/gambitph/WP-OTF-Regenerate-Thumbnails )
if ( !function_exists( 'gambit_otf_regen_thumbs_media_downsize' ) ) {
    function gambit_otf_regen_thumbs_media_downsize( $out, $id, $size ) {
        global $_gambit_otf_regen_thumbs_all_image_sizes;
        if ( ! isset( $_gambit_otf_regen_thumbs_all_image_sizes ) ) {
            global $_wp_additional_image_sizes;
            $_gambit_otf_regen_thumbs_all_image_sizes = array();
            $interimSizes = get_intermediate_image_sizes();
            foreach ( $interimSizes as $sizeName ) {
                if ( in_array( $sizeName, array( 'thumbnail', 'medium', 'large' ) ) ) {
                    $_gambit_otf_regen_thumbs_all_image_sizes[ $sizeName ]['width'] = get_option( $sizeName . '_size_w' );
                    $_gambit_otf_regen_thumbs_all_image_sizes[ $sizeName ]['height'] = get_option( $sizeName . '_size_h' );
                    $_gambit_otf_regen_thumbs_all_image_sizes[ $sizeName ]['crop'] = (bool) get_option( $sizeName . '_crop' );
                } elseif ( isset( $_wp_additional_image_sizes[ $sizeName ] ) ) {
                    $_gambit_otf_regen_thumbs_all_image_sizes[ $sizeName ] = $_wp_additional_image_sizes[ $sizeName ];
                }
            }
        }
        $allSizes = $_gambit_otf_regen_thumbs_all_image_sizes;
        $imagedata = wp_get_attachment_metadata( $id );
        if ( ! is_array( $imagedata ) ) {
            return false;
        }
        if ( is_string( $size ) ) {
            if ( empty( $allSizes[ $size ] ) ) {
                return false;
            }
            if ( ! empty( $imagedata['sizes'][ $size ] ) && ! empty( $allSizes[ $size ] ) ) {
                if ( $allSizes[ $size ]['width'] == $imagedata['sizes'][ $size ]['width']
                && $allSizes[ $size ]['height'] == $imagedata['sizes'][ $size ]['height'] ) {
                    return false;
                }
                if ( ! empty( $imagedata['sizes'][ $size ][ 'width_query' ] )
                && ! empty( $imagedata['sizes'][ $size ]['height_query'] ) ) {
                    if ( $imagedata['sizes'][ $size ]['width_query'] == $allSizes[ $size ]['width']
                    && $imagedata['sizes'][ $size ]['height_query'] == $allSizes[ $size ]['height'] ) {
                        return false;
                    }
                }
            }
            $resized = image_make_intermediate_size(
                get_attached_file( $id ),
                $allSizes[ $size ]['width'],
                $allSizes[ $size ]['height'],
                $allSizes[ $size ]['crop']
            );
            if ( ! $resized ) {
                return false;
            }
            $imagedata['sizes'][ $size ] = $resized;
            $imagedata['sizes'][ $size ]['width_query'] = $allSizes[ $size ]['width'];
            $imagedata['sizes'][ $size ]['height_query'] = $allSizes[ $size ]['height'];
            wp_update_attachment_metadata( $id, $imagedata );
            $att_url = wp_get_attachment_url( $id );
            return array( dirname( $att_url ) . '/' . $resized['file'], $resized['width'], $resized['height'], true );
        } else if ( is_array( $size ) ) {
            $imagePath = get_attached_file( $id );
            $imageExt = pathinfo( $imagePath, PATHINFO_EXTENSION );
            $imagePath = preg_replace( '/^(.*)\.' . $imageExt . '$/', sprintf( '$1-%sx%s.%s', $size[0], $size[1], $imageExt ) , $imagePath );
            $att_url = wp_get_attachment_url( $id );
            if ( file_exists( $imagePath ) ) {
                return array( dirname( $att_url ) . '/' . basename( $imagePath ), $size[0], $size[1], true );
            }
            $resized = image_make_intermediate_size( get_attached_file( $id ), $size[0], $size[1], true );
            $imagedata = wp_get_attachment_metadata( $id );
            $imagedata['sizes'][ $size[0] . 'x' . $size[1] ] = $resized;
            wp_update_attachment_metadata( $id, $imagedata );
            if ( ! $resized ) {
                return false;
            }
            return array( dirname( $att_url ) . '/' . $resized['file'], $resized['width'], $resized['height'], true );
        }
        return false;
    }
    add_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
}

// 移除一些不要的 CSS 和钩子
function bymt_remove_needless() {
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    if ( !is_admin() ) {
        wp_deregister_style( 'mediaelement' );
        wp_deregister_style('wp-mediaelement');
    }
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
    remove_filter( 'the_content', 'wptexturize' );
    remove_filter( 'the_content', 'capital_P_dangit', 11 );
    remove_filter( 'the_title', 'capital_P_dangit', 11 );
    remove_filter( 'wp_title', 'capital_P_dangit', 11 );
    remove_filter( 'comment_text', 'capital_P_dangit', 31 );
}
add_action( 'init' , 'bymt_remove_needless');
