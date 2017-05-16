<?php !defined( 'WPINC' ) && exit();
/**
 * bymtPosts.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

// 判断是否为新文章(1天内)
function is_new_post() {
    global $post;
    $post_time = get_the_time( 'U' );
    $time = current_time( 'timestamp' );
    $diff = ($time - $post_time) / 86400;
    return ( $diff < 1 ) ? 'new-post' : '';
}

// 获取缩略图
function bymt_thumbnail( $width = null, $height = null, $html = false, $match = false, $match_num = 0, $lazy = true ) {
    global $post;
    $image_src = '';
    if ( ! $post ) return;
    if ( ! $width && ! $height ) {
        $size = 'full';
    } else {
        $size = array( $width, $height, true );
    }
    if ( has_post_thumbnail( $post->ID ) ) {
        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
        $thumbnail_full = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $image_check = wp_check_filetype( $thumbnail[0] );
        $image_ext_allow = array( 'jpg', 'jpeg', 'jpe', 'gif', 'png' );
        if ( in_array( $image_check['ext'], $image_ext_allow ) ) {
            $image_src = $thumbnail[0];
            $width = $thumbnail[1];
            $height = $thumbnail[2];
        } else {
            $image_src = $thumbnail_full[0];
            $width = $thumbnail_full[1];
            $height = $thumbnail_full[2];
        }
    } else {
        if ( $match ) {
            preg_match_all( '/<img.+?src="([^"]+?)"/i', $post->post_content, $matches );
            $match_num = absint( $match_num );
            if ( !empty( $matches[1][$match_num] ) ) {
                $image_src = $matches[1][$match_num];
                $width = 'auto';
                $height = 'auto';
            }
        }
    }
    if ( $html ) {
        $image_attr = "class=\"thumbnail transition3\" src=\"{$image_src}\"";
        if ( bymt_option( 'img_lazyload' ) && $lazy && !is_robots() ) {
            $lazy_src = bymt_static('images/img_lazy.png');
            $image_attr = "class=\"lazy thumbnail transition3\" data-original=\"{$image_src}\" src=\"{$lazy_src}\"";
        }
        return $image_src ? "<img {$image_attr} width=\"{$width}\" height=\"{$height}\" alt=\"{$post->post_title}\"  itemprop=\"image\">" : '';
    } else {
        return $image_src;
    }
}

// 获取文章链接
function bymt_get_link_url() {
    $has_url = get_url_in_content( get_the_content() );
    return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

// 获取文章媒体信息
function bymt_do_media_shortcode() {
    if ( preg_match_all( '/' . get_shortcode_regex() . '/s', get_the_content(), $matches, PREG_SET_ORDER ) ){
        if ( 'audio' === $matches[0][2] || 'video' === $matches[0][2] ) {
            return do_shortcode_tag( $matches[0] );
        } elseif ( 'embed' === $matches[0][2] ) {
            global $wp_embed;
            $parsed = $wp_embed->run_shortcode( '[embed]' . $matches[0][5] . '[/embed]' );
            if ($parsed) {
                return do_shortcode( $parsed );
            }
        } elseif ( 'playlist' === $matches[0][2] ) {
            return do_shortcode_tag( $matches[0] );
        }
    }
    return;
}

// 获取文章相册图片
function bymt_get_gallery_src( $width = null, $height = null ) {
    $galleries = get_post_galleries( 0, false );
    $thumbnail = array();
    if ( !empty( $galleries[0]['ids'] ) ) {
        $ids = explode( ',', $galleries[0]['ids'] );
        if ( ! $width && ! $height ) {
            $size = 'full';
        } else {
            $size = array($width, $height, true);
        }
        foreach ($ids as $id) {
            $image = wp_get_attachment_image_src( $id , $size );
            $thumbnail[$id] = $image[0];
        }
    } else {
        $thumbnail[] = bymt_thumbnail( $width, $height, true, true );
    }
    $html = '';
    foreach ($thumbnail as $key => $val) {
        $image_attr = " class=\"gallery-thumb transition3\" src=\"{$val}\"";
        if ( bymt_option( 'img_lazyload' ) && !is_robots() ) {
            $lazy_src = bymt_static( 'images/img_lazy.png' );
            $image_attr = " class=\"lazy gallery-thumb transition3\" data-original=\"{$val}\" src=\"{$lazy_src}\"";
        }
        $html .= "<img {$image_attr} alt=\"gallery-{$key}\" itemprop=\"image\">";
    }
    return $html;
}

// 文章摘要
function bymt_excerpt( $length = 200, $more = ' &hellip;' ) {
    $new_length = bymt_define( 'post_excerpt_length', $length );
    $excerpt = has_excerpt() ? get_the_excerpt() : get_the_content();
    $excerpt = strip_shortcodes( $excerpt );
    $excerpt = preg_replace('/<img[^>+]>/i', __('[图片]'), $excerpt );
    $excerpt = wp_html_excerpt( $excerpt, $new_length, $more );
    if ( post_password_required() ) {
        $excerpt = '这是一篇受密码保护的文章，您需要提供访问密码';
    }
    return $excerpt;
}

// 文章 meta 信息
function bymt_post_meta() {
    if ( post_password_required() ) {
        return;
    }
    if ( get_the_category_list( ',' ) ) {
        echo '<span class="meta-category transition3">' . bymt_include_post_format( 'icon' ) . get_the_category_list( ',' ) . '</span>';
    }
    echo '<span class="meta-author" itemprop="author"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . bymt_gravatar( get_the_author_meta( 'email' ), '24', get_the_author() ) . get_the_author() . '</a></span>';
    echo '<span class="meta-date"><i class="iconfont icon-time"></i><time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" itemprop="datePublished">' . esc_html( bymt_time_ago( 'post' ) ) . '</time></span>';
    echo '<span class="meta-float">';
        if ( function_exists( 'the_views' ) && bymt_option( 'post_view' ) ) {
            echo '<span class="meta-view"><i class="iconfont icon-view"></i>' . the_views( false ) . '</span>';
        }
        if ( bymt_option( 'post_like' ) ) {
            echo '<span class="meta-like">' . bymt_like_count( 'post' ) . '</span>';
        }
        echo '<span class="meta-comment-count" title="' . __( '评论' ) . '" itemprop="interactionCount" content="UserComments:' . number_format_i18n( get_comments_number() ) . '">';
            comments_popup_link( '0', '1', '%', '', __( '评论关闭' ) );
        echo '</span>';
    echo '</span>';
    edit_post_link( '编辑', '<span class="meta-edit"><i class="iconfont icon-edit"></i>', '</span>' );
}

// 文章版权信息
function bymt_post_copyright( $url = false ) {
    $copy_links = get_post_custom_values( 'copyright' );
    $author = get_the_author();
    if ( $url ) {
        global $authordata;
        $author = '';
        if ( is_object( $authordata ) ) {
            $author = sprintf( '<a href="%1$s" rel="author">%2$s</a>', esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ), get_the_author() );
            $author = apply_filters( 'the_author_posts_link', $author );
        }
    }
    if ( $copy_links && is_array( $copy_links ) ) {
        $copy_link = '';
        foreach ($copy_links as $key => $val) {
            if ( !$val ) continue;
            $parse = parse_url($val);
            $host = !empty($parse['host']) ? $parse['host'] : $val;
            $copy_link .= '<a href="' . esc_url($val) . '" rel="external nofollow" target="_blank">' . esc_html($host) . '</a> &#x3001;';
        }
        return '本文由 <u>' . $author . '</u> 整编，转载请注明来自 <u>' . esc_attr( get_bloginfo( 'name' ) ) . '</u>！<br>参考来源：' . rtrim( $copy_link, '&#x3001;' );
    }
    return '本文由 <u>' . $author . '</u> 原创，未经作者许可禁止转载！转载若许可请注明来自 <u>' . esc_attr( get_bloginfo( 'name' ) ) . '</u>！';
}

// 文章作者简介
function bymt_author_description(){
    if ( get_the_author_meta( 'description' ) ) {
        return wp_trim_words( get_the_author_meta( 'description' ), 30 );
    }
    return bymt_define( 'post_copyright_desc', '特邀作者' );
}

// 文章分享
function bymt_post_social() {
    $output = '';
    if ( bymt_option( 'post_share' ) ) {
        $title = wp_title( bymt_define('delimiter', '|'), false, 'right' );
        $social = array(
            'weibo' => array( __( '微博' ), 'http://service.weibo.com/share/share.php?url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( $title ) . '&appkey=' . bymt_option( 'post_share_weibo_appkey' ) . '&searchPic=true' ),
            'weixin' => array( __( '微信' ), 'http://s.jiathis.com/qrcode.php?url=' . urlencode( get_the_permalink() ) ),
            'qq' => array( __( 'QQ' ), 'http://connect.qq.com/widget/shareqq/index.html?url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( $title ) . '&summary=' . bymt_description() ),
            'facebook' => array( __( '脸书' ), 'https://www.facebook.com/share.php?u=' . urlencode( get_the_permalink() ) . '&t=' . urlencode( $title ) . '&pic=' . bymt_thumbnail( 300, 200, false, true ) ),
            'twitter' => array( __( '推特' ), 'https://twitter.com/intent/tweet?url=' . urlencode( get_the_permalink() ) . '&text=' . urlencode( $title ) . '&related=' . bymt_option( 'post_share_tweet_name' ) . '&hashtags=' . wp_strip_all_tags( get_the_tag_list('', ',' ) ) ),
        );
        foreach ($social as $key => $val) {
            $output .= '<a class="share-' . $key . '" href="jacascript:;" data-href="' . esc_url( $val[1] ) . '" title="' . __( '分享到' ) . $val[0] . '" rel="nofollow"><i class="iconsocial social-' . $key . '"></i></a>';
        }
    }
    return $output;
}

// 相关文章
function bymt_post_relate() {
    $output = '';
    if ( bymt_option( 'post_relate' ) ) {
        $number = bymt_define( 'post_relate_number', '10' );
        $IDs = array( get_the_ID() );
        $tags = get_the_tags();
        $tags_slug = array();
        $categories = get_the_category();
        $category_ids = array();
        if ( bymt_option( 'post_relate_match_tag' ) ) {
            if ( !empty( $tags ) ) {
                foreach ($tags as $tag) {
                    $tags_slug[] = $tag->slug;
                }
            }
        }
        if ( bymt_option( 'post_relate_match_category' ) ) {
            if ( !empty( $categories ) ) {
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }
            }
        }
        $args = array(
            'orderby' => 'rand',
            'posts_per_page' => $number,
            'no_found_rows'  => true,
            'ignore_sticky_posts' => true,
            'post_status'    => 'publish',
            'post__not_in' => $IDs,
            'tag_slug__in' => $tags_slug,
            'category__in' => $category_ids
        );
        $relate = new WP_Query( $args );
        $output .= '<div class="post-relate clearfix">';
        $output .= '<h3 class="title"><i class="iconfont icon-smile"></i>' . __( '猜您感兴趣' ) . '</h3>';
        $output .= '<ul class="clearfix">';
        while ( $relate->have_posts() ) {
            $relate->the_post();
            $output .= '<li>';
            $img_src = bymt_thumbnail( 200, 144, false, true ) ? bymt_thumbnail( 200, 144, false, true ) : bymt_static( 'images/no_pic.jpg' );
            $img_attr = "class=\"thumbnail transition3\" src=\"{$img_src}\"";
            if ( bymt_option( 'img_lazyload' ) && !is_robots() ) {
                $lazy_src = bymt_static( 'images/img_lazy.png' );
                $img_attr = "class=\"lazy thumbnail transition5\" data-original=\"{$img_src}\" src=\"{$lazy_src}\"";
            }
            $out_id = absint( get_the_ID() );
            $out_title = esc_attr( get_the_title() );
            $out_href = esc_url( get_the_permalink() ) ;
            $out_alt = esc_attr( the_title_attribute( array( 'echo' => false ) ) );
            $output .= "<div class=\"pic\"><a href=\"{$out_href}\" rel=\"bookmark\"><img {$img_attr} alt=\"{$out_alt}\"><p class=\"name\">{$out_title}</p></a></div>";
            $output .= '</li>';
        }
        $IDs[] = get_the_ID();
        wp_reset_postdata();
        if ( !$relate->have_posts() ) {
            $output = str_replace( array( 'icon-smile', __( '猜您感兴趣' ) ), array( 'icon-sad', __( '猜不到您的兴趣' ) ), $output );
        }
        $output .= '</ul></div>';
    }
    return $output;
}

// 分页功能
function p_link( $i, $title = '' ) {
  if ( $title == '' ) $title = sprintf( __( '第 %s 页' ), $i );
  $link = esc_html( get_pagenum_link( $i ) );
  return "<a class=\"page-numbers\" href=\"{$link}\" title=\"{$title}\">{$i}</a>";
}
function bymt_pagenavi( $p = 2 ) {
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    $pagenavi = '';
    if ( $max_page == 1 ) return;
    if ( empty( $paged ) ) $paged = 1;
    if ( $paged > $p + 1 ) {
        $pagenavi .= p_link( 1, __( '首页' ) );
    }
    if ( $paged > $p + 2 ) {
        $pagenavi .= '<span class="dots">...</span>';
    }
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
        if ( $i > 0 && $i <= $max_page ) {
            $title = sprintf( __( '第 %s 页' ), $i );
            $pagenavi .= $i == $paged ? "<a class=\"page-numbers current\" title=\"{$title}\">{$i}</a>" : p_link( $i );
        }
    }
    if ( $paged < $max_page - $p - 1 ) {
        $pagenavi .= '<span class="dots">...</span>';
    }
    if ( $paged < $max_page - $p ) {
        $pagenavi .= p_link( $max_page, __( '末页' ) );
    }
    return $pagenavi;
}

// 文章 pre 转义
function bymt_pre_replace( $content ) {
    if ( bymt_option( 'code_escape' ) ){
        $content = preg_replace_callback( '/<pre.+?lang=\"(.+?)\".*?>([\s\S]*?)<\/pre>/i', function($matches) {
            return '<pre lang="' . $matches[1] . '" class="' . $matches[1] . '">' . esc_html($matches[2]) . '</pre>';
        }, $content );
    }
    return $content;
}
add_filter( 'the_content', 'bymt_pre_replace', 10 );
add_filter( 'comment_text', 'bymt_pre_replace', 10 );

// 文章标签自动超链接
function bymt_post_tag_aotolink( $content ) {
    if ( bymt_option( 'post_tag_aotolink' ) ) {
        $tags = get_the_tags();
        if ( empty( $tags ) ) {
            return $content;
        }
        $links = array();
        $count = bymt_define( 'post_tag_aotolink_number', '-1' );
        $keep_pattern = '/<(a|script)[^>]*?>([\s\S]+?)<\/\\1>|<(img|audio|video)[^>]*?>/i';
        preg_match_all($keep_pattern, $content, $keep_match);
        $content = preg_replace_callback($keep_pattern, function($match){
            return '&&&' . md5($match[0]) . '&&&';
        }, $content);
        foreach ( $tags as $tag ) {
            $link = '<a class="inner-tag" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" title="' . sprintf( __( '查看更多关于 %s 的内容' ), esc_attr( $tag->name ) ) . '" rel="tag">' . $tag->name . '</a>';
            $content = preg_replace( "/([^\w\-\.\?\"\']+?){$tag->name}([^\w\-\.\?\"\']+?)/", "$1$link$2", $content, $count );
        }
        preg_match_all( '/&&&\w{32}?&&&/', $content, $content_match );
        $content = str_replace( $content_match[0], $keep_match[0], $content );
    }
    return $content;
}
add_filter( 'the_content', 'bymt_post_tag_aotolink', 11 );

// 文章图片延迟加载
function bymt_post_img_lazy( $content ) {
    if ( bymt_option( 'img_lazyload' ) && !is_robots() ) {
        $content = preg_replace_callback( '/<img(.+?)src="([^"]+?)"/i', function( $matchs ) {
            $lazy_src = bymt_static( 'images/img_lazy.png' );
            return '<img' . $matchs[1] . 'data-original="' . $matchs[2] . '" src="' . $lazy_src . '"';
        }, $content);
        $content = preg_replace( '/<img(.+?)class="/i', '<img\\1class="lazy ', $content, -1, $count );
        if ( !$count ) {
            $content = preg_replace( '/<img(.+?)/i', '<img\\1class="lazy" ', $content );
        }
    }
    return $content;
}
add_filter( 'the_content', 'bymt_post_img_lazy', 12 );

// 文章图片Alt替换
function bymt_post_img_alt( $content ) {
    if ( bymt_option( 'post_img_alt' ) ) {
        global $post;
        $alt = esc_attr( $post->post_title );
        $content = preg_replace('/<img(.+?)alt="([^"]+?)"/i', "<img\\1alt=\"{$alt} \\2\" itemprop=\"image\"", $content, -1, $count);
        if ( !$count ) {
            $content = preg_replace('/<img(.+?)/i', "<img\\1alt=\"{$alt}\" itemprop=\"image\"", $content);
        }
    }
    return $content;
}
add_filter( 'the_content', 'bymt_post_img_alt', 13 );

// Feed 添加版权信息
function bymt_post_feed_copr( $content ) {
    if ( bymt_option( 'post_feed_copr' ) ) {
        $copr = bymt_post_copyright( true );
        return "{$content} <blockquote>{$copr}</blockquote>";
    }
    return $content;
}
add_filter( 'the_content_feed', 'bymt_post_feed_copr' );
add_filter( 'the_excerpt_rss', 'bymt_post_feed_copr' );

// 归档
function bymt_archives() {
    $output = get_option( 'bymt_archives_cache' );
    if ( !$output ) {
        $output = '';
        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'no_found_rows'  => true,
            'ignore_sticky_posts' => true
        );
        $archives = new WP_Query( $args );
        if ( !$archives->have_posts() ) {
            wp_reset_postdata();
            return '<p class="noposts alert alert-info">' . __( '暂时还没有文章' ) . '</p>';
        }
        $output = '<div id="bymt-archives" class="bymt-archives"><ul class="clearfix">';
        $_year = null;
        $_format = null;
        $_info_class = $_time_class = '';
        while ( $archives->have_posts() ) {
            $archives->the_post();
            $post_title = esc_attr( get_the_title() );
            $post_href = esc_url( get_the_permalink() );
            $post_date = esc_attr( get_the_date( 'c' ) );
            $post_year = esc_attr( get_the_date( 'Y' ) );
            $post_time = esc_attr( get_the_date( 'Y-m-d' ) );
            $post_format = bymt_include_post_format( 'format' );
            $post_icon = bymt_include_post_format( 'icon' );
            $post_comment = number_format_i18n( get_comments_number() );
            if ( $post_year !== $_year ) {
                $output .= "<li id=\"art-{$post_year}\" class=\"year not-select\"><div class=\"hold transition3\">{$post_year}</div></li>";
                $_year = $post_year;
            }
            if ( $_format && $post_format !== $_format ) {
                $_info_class = !$_info_class ? ' info-fl' : '';
                $_time_class = !$_time_class ? ' time-fr' : '';
                $_format = $post_format;
            }
            !$_format && $_format = $post_format;
            $output .= "<li class=\"art-{$post_year} day clearfix\"><div class=\"format f-{$post_format} transition3\">{$post_icon}</div><div class=\"info{$_info_class}\"><a href=\"{$post_href}\">{$post_title}<span class=\"meta\">({$post_comment})</span></a></div><time class=\"time{$_time_class}\" datetime=\"{$post_date}\">{$post_time}</time></li>";
        }
        wp_reset_postdata();
        $output .= '</ul></div>';
        update_option( 'bymt_archives_cache', $output );
    }
    return $output;
}
function clear_bymt_archives_cache() {
    update_option( 'bymt_archives_cache', '' );
}
add_action( 'save_post', 'clear_bymt_archives_cache' );
add_action( 'delete_post', 'clear_bymt_archives_cache' );
