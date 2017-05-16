<?php !defined( 'WPINC' ) && exit();
/**
 * bymtComments.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

// 评论列表
function bymt_comments_list( $comment, $args, $depth, $lazy = false ) {
    $GLOBALS['comment'] = $comment;
    global $comment_floor;
    static $comment_cd_floor = 0;
    if ( !$comment_floor ) {
        $page = ( !empty($in_comment_loop) ) ? get_query_var( 'cpage' ) - 1 : get_page_of_comment( $comment->comment_ID, $args ) - 1;
        $cpp = get_option( 'comments_per_page' );
        $comment_floor = $cpp * $page;
    }
?>
    <li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?> itemprop="reviews" itemscope itemtype="http://schema.org/Review">
        <article id="div-comment-<?php comment_ID() ?>" class="comment-body clearfix">
            <div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Restaurant" style="display:none">
                <span itemprop="name"><?php the_title(); ?></span>
            </div>
            <div class="comment-author">
                <?php echo ( isset( $args['is_new'] ) && $args['is_new'] ) ? bymt_gravatar( $comment->comment_author_email, '50', 'avatar', false ) : bymt_gravatar( $comment->comment_author_email ); ?>
            </div>
            <div class="comment-content transition3">
                <footer class="comment-metadata">
                    <span class="name author" itemprop="author" itemscope itemtype="http://schema.org/Person"><?php comment_author_link(); ?></span>
                    <?php echo bymt_comment_level( $comment ); ?>
                    <span class="date">
                        <time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished"><?php echo esc_html( bymt_time_ago( 'comment' ) ); ?></time>
                    </span>
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                        <span class="status"><?php _e( '( 待审 )' ); ?></span>
                    <?php endif; ?>
                    <?php if ( !isset( $args['is_new'] ) ): ?>
                    <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
                    <?php if ( bymt_option( 'comment_like' ) ) : ?>
                        <span class="like"><?php echo bymt_like_count( 'comment' ); ?></span>
                    <?php endif; ?>
                    <span class="psr">
                        <?php comment_reply_link( array_merge( $args, array(
                            'add_below' => 'div-comment',
                            'reply_text' => '<i class="iconfont icon-reply" title="' . sprintf( __( 'Reply to %s' ), $comment->comment_author ) . '"></i>',
                            'reply_to_text' => '<i class="iconfont icon-reply" title="' . sprintf( __( 'Reply to %s' ), $comment->comment_author ) . '"></i>',
                            'login_text'    => '<i class="iconfont icon-reply" title="' . __( 'Log in to Reply' ) . '"></i>',
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<span class="reply">',
                            'after'     => '</span>'
                        ) ) );
                        ?>
                        <?php if( !$parent_id = $comment->comment_parent ): $comment_cd_floor = 0;?>
                        <span class="floor"><?php ++$comment_floor; printf(__('%s楼'), $comment_floor); ?></span>
                        <?php else: ?>
                        <span class="floor"><?php ++$comment_cd_floor; printf(__('%s楼-%s'), $comment_floor, $comment_cd_floor); ?></span>
                        <?php endif; ?>
                    </span>
                    <?php endif; ?>
                </footer>
                <div class="comment-detail" itemprop="reviewBody">
                    <?php comment_text() ?>
                </div>
            </div>
        </article>
    </li>
<?php
}

// pingback 列表
function bymt_pingback_list( $comment, $args, $depth ) {
    $tag = ( 'div' == $args['style'] ) ? 'div' : 'li';
?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
        <div class="comment-body clearfix">
        <span class="name"><?php _e( 'Pingback:' ); ?></span> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
        </div>
<?php
}

// 评论框增强
function bymt_comment_tools() {
    if ( !bymt_option( 'comment_tools' ) ) {
        return;
    }
    global $wpsmiliestrans, $allowedtags;
    $tools_list = array(
        'smile' => array( __( '表情' ), 'custom|smile', '', array() ),
        'font_bold' => array( __( '粗体' ), 'bold', 'b', array() ),
        'font_italic' => array( __( '斜体' ), 'italic', 'i', array() ),
        'font_underline' => array( __( '下划线' ), 'underline', 'u', array() ),
        'font_strikethrough' => array( __( '删除线' ), 'strikethrough', 'strike', array() ),
        'list_numbered' => array( __( '有序列表' ), 'insertOrderedList', 'ol', array() ),
        'list_bulleted' => array( __( '无序列表' ), 'insertUnorderedList', 'ul', array() ),
        'quote' => array( __( '引用' ), 'formatBlock|blockquote', 'blockquote', array() ),
        'code' => array( __( '代码' ), 'formatBlock|pre', 'pre', array( 'class' => array(), 'lang' => array() ) ),
        'image' => array( __( '图片' ), 'custom|image', 'img', array( 'src' => array() ) ),
        'audio' => array( __( '音频' ), 'custom|audio', 'audio', array( 'preload' => 'metadata', 'src' => array() ) ),
        'video' => array( __( '视频' ), 'custom|video', 'video', array( 'preload' => 'metadata', 'src' => array() ) ),
        'undo' => array( __( '撤销' ), 'undo', '' ),
        'redo' => array( __( '恢复' ), 'redo', '' )
    );
    if ( empty( $wpsmiliestrans ) ) {
        unset( $tools_list['smile'] );
    }
    $html = '<div id="comment-tools" class="comment-tools"><ul id="comment-tools-bar" class="clearfix">';
    foreach ($tools_list as $key => $val) {
        $name = str_replace( '_', '-', $key );
        if ( bymt_option( 'comment_tools_' . $key ) ) {
            if ( !empty( $val[2] ) ) {
               $allowedtags[$val[2]] = $val[3];
            }
            $html .= "<li class=\"edit-{$name}\"><a class=\"not-select\" data-command=\"{$val[1]}\" title=\"{$val[0]}\"><i class=\"iconfont icon-{$name}\"></i></a></li>";
        }
    }
    $html .= '</ul>';
    if ( $tools_list['smile'] ) {
        $html .= '<div id="smilies" class="smilies transition3 clearfix">';
        $smile_png = array( 'simple-smile', 'frownie', 'rolleyes', 'mrgreen' );
        $wpsmiliestrans = array_unique( $wpsmiliestrans );
        foreach ($wpsmiliestrans as $key => $val) {
            if ( preg_match( '/\.png$/', $val ) ) {
                continue;
            }
            $html .= "<li class=\"transition3 not-select\">{$val}</li>";
        }
        $html .= '</div>';
    }
    $html .= '<div id="comment-tools-editor" class="comment-tools-editor" contenteditable="true" tabindex="4" role="application"></div>';
    $html .= '</div>';
    return $html;
}

// 评论等级
function _bymt_level_log( $val ) {
    return ( $val <= 1 ) ? 0 : 1 + _bymt_level_log( $val >> 1 );
}
function bymt_comment_level( $comment ) {
    $output = '';
    if ( bymt_option( 'comment_level' ) ) {
        if ( empty( $comment ) ) {
            return;
        }
        global $wpdb;
        $author = get_userdata( get_post( $comment->comment_post_ID )->post_author );
        $admin_email = get_bloginfo( 'admin_email' );
        $author_email = ( $author ) ? $author->user_email : '';
        $comment_email = ( $comment->comment_author_email ) ? $comment->comment_author_email : '';
        $comment_url = ( $comment->comment_author_url ) ? $comment->comment_author_url : '';
        $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_author_email = '%s'", $comment_email ) );
        $is_link = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->links WHERE link_url = '%s'", $comment_url ) );
        if ( $comment_email && $comment_email === $admin_email ) {
            $output .= '<span class="level admin">' . __( '博主' ) . '</span>';
        } elseif ( $comment_email && $author_email && $comment_email === $author_email ) {
            $output .= '<span class="level author">' . __( '作者' ) . '</span>';
        } elseif ( $is_link ) {
            $output .= '<span class="level frind">' . __( '友链' ) . '</span>';
        } else {
            if ( $count < 640 ) {
                $level = _bymt_level_log( $count / 10 ) + 1;
                $output .= "<span class=\"level lv{$level}\">Lv.{$level}</span>";
            } else {
                $output .= '<span class="level lv7">Lv.7</span>';
            }
        }
    }
    return $output;
}

// 更改回复评论链接onclick
function bymt_comment_reply_link( $link ){
    $pattern = '/onclick=\'return addComment\.moveForm\( "([^"]+?)", "([^"]+?)", "([^"]+?)", "([^"]+?)" \)\'/i';
    $replace = 'data-comment-id="$2"';
    return preg_replace( $pattern, $replace, $link );
}
add_filter( 'comment_reply_link', 'bymt_comment_reply_link' );

// 评论HTML过滤
function bymt_comment_html_filter( $comment ) {
    if ( bymt_option( 'comment_html_filter' ) ) {
        global $allowedtags;
        $opt_allow = preg_replace( '/[^a-z\,]+?/i', '', bymt_option( 'comment_html_filter_allow' ) );
        $opt_allow = array_filter( explode( ',', $opt_allow ) );
        $glb_allow = array_keys( $allowedtags );
        $allow_tags = array_unique( array_merge( $opt_allow, $glb_allow ) );
        $allow_tags = '<' . implode( '><', $allow_tags ) . '>';
        if ( is_array( $comment ) && isset( $comment['comment_content'] ) ) {
            $comment['comment_content'] = strip_tags( $comment['comment_content'], $allow_tags );
            if ( bymt_option( 'comment_html_filter_not_resolve' ) ) {
                $comment['comment_content'] = esc_html( $comment['comment_content'] );
            }
        } else {
            $comment = strip_tags( $comment, $allow_tags );
            if ( bymt_option( 'comment_html_filter_not_resolve' ) ) {
                $comment = esc_html( $comment );
            }
        }
    }
    return $comment;
}
add_filter( 'preprocess_comment', 'bymt_comment_html_filter', 10 );
add_filter( 'comment_text', 'bymt_comment_html_filter', 10 );
add_filter( 'comment_text_rss', 'bymt_comment_html_filter', 10 );

// 评论语言过滤
function bymt_comment_lang_filter( $comment ) {
    $content = $comment['comment_content'];
    $lang_list = array(
        'cn' => '/\p{Han}+/u',
        'en' => '/[a-zA-Z]+/u',
        'ja' => '/\p{Katakana}|\p{Hiragana}+/u',
        'ru' => '/\p{Cyrillic}+/u',
        'kr' => '/\p{Hangul}+/u',
        'th' => '/\p{Thai}|\p{New_Tai_Lue}+/u',
        'ar' => '/\p{Arabic}+/u',
        'zy' => '/\p{Bopomofo}+/u'
    );
    $lang_tips = __( '抱歉，您的回复内容含有不规范词汇' );
    $enble_tips = bymt_option( 'comment_lang_filter_enable_tips' );
    $enble_regular = bymt_option( 'comment_lang_filter_enable_regular' );
    $filter_regular = bymt_option( 'comment_lang_filter_regular' );
    foreach ( $lang_list as $key => $val ) {
        if ( bymt_option( "comment_lang_filter_{$key}" ) ) {
            if ( preg_match( $val, $content ) ){
                $err = $enble_tips ? bymt_define( "comment_lang_filter_tips_{$key}", $lang_tips ) : $lang_tips;
                wp_die( $err );
            }
        }
    }
    if ( $enble_regular && $filter_regular ) {
        $reg_split = preg_split( '/' . PHP_EOL . '/', $filter_regular );
        foreach ($reg_split as $key => $val) {
            if ( !$val ) continue;
            $reg_exp = explode( '&&', $val );
            $pattern = $reg_exp[0];
            $tips = isset( $reg_exp[1] ) ? $reg_exp[1] : $lang_tips;
            if ( @preg_match( $pattern, $content ) ){
                wp_die( $tips );
            }
        }
    }
    return $comment;
}
add_filter( 'preprocess_comment', 'bymt_comment_lang_filter', 11 );

// 评论字数限制
function bymt_comment_word_limit( $comment ) {
    if ( bymt_option( 'comment_word_limit' ) ) {
        $content = $comment['comment_content'];
        $min = bymt_define( 'comment_word_limit_min_number', '2' );
        $max = bymt_define( 'comment_word_limit_max_number', '10000' );
        $length = mb_strlen( $content, 'UTF-8' );
        if ( $length < $min || $length > $max ) {
            wp_die( sprintf( __( '抱歉，评论字数请保持在 %1$d 到 %2$d 之间' ), $min, $max ) );
        }
    }
    return $comment;
}
add_filter( 'preprocess_comment', 'bymt_comment_word_limit', 12 );

// 评论链接限制
function bymt_comment_link( $comment ) {
    if ( bymt_option( 'comment_link_limit' ) ) {
        if ( is_array( $comment ) && isset( $comment['comment_content'] ) ) {
            $limit_number = bymt_define( 'comment_link_limit_number', get_option( 'comment_max_links' ) );
            $limit_length = bymt_define( 'comment_link_limit_length', '50' );
            $link_number = preg_match_all( '/<a[^>]+?>|(https?|ftp):\/\//i', $comment['comment_content'], $matches_number );
            $link_length = preg_match_all( '/(https?|ftp):\/\/([^\s\<]+)\s?/i', $comment['comment_content'], $matchs_length );
            if ( $link_number > $limit_number ) {
                wp_die( sprintf( __( '抱歉，评论链接不能超过 %d 条' ), $limit_number ) );
            }
            if ( $link_length ) {
                foreach ($matchs_length[2] as $key => $val) {
                    if ( !$val ) continue;
                    if ( mb_strlen( $val, 'UTF-8' ) > $limit_length ) {
                        wp_die( sprintf( __( '抱歉，评论链接长度不能超过 %d 个字符' ), $limit_length ) );
                    }
                }
            }
        } else {
            if ( bymt_option( 'comment_link_newtab' ) ) {
                $comment = preg_replace( '/<a(.+?)href=(("|\')(?!#).+?\\3)\s?/i', '<a$1href=$2 target="_blank" ', $comment );
                $comment = str_replace( 'rel="nofollow"', 'rel="external nofollow"', $comment );
            }
        }
    }
    return $comment;
}
add_filter( 'preprocess_comment', 'bymt_comment_link', 13 );
add_filter( 'comment_text', 'bymt_comment_link', 13 );
add_filter( 'comment_text_rss', 'bymt_comment_link', 13 );

// 禁止使用注册用户信息提交
function bymt_ban_admininfo( $comment ) {
    if ( bymt_option( 'ban_admininfo' ) && !is_user_logged_in() ) {
        global $wpdb;
        $author = $comment['comment_author'];
        $email = $comment['comment_author_email'];
        $admin_email = get_bloginfo( 'admin_email' );
        $user_search = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->users WHERE display_name = '%s' OR user_nicename = '%s' OR user_email = '%s'", $author, $author, $email ) );
        if ( $user_search || $email === $admin_email ) {
            wp_die( __( '抱歉，您不能使用这个昵称或邮箱' ) );
        }
    }
    return $comment;
}
add_action( 'preprocess_comment', 'bymt_ban_admininfo', 14 );

// 禁止垃圾评论提交
function bymt_ban_blacklist( $comment ) {
    if ( bymt_option( 'ban_blacklist' ) ) {
        $comment['comment_author_IP'] = preg_replace( '/[^0-9a-fA-F:., ]/', '', bymt_args_server( 'REMOTE_ADDR' ) );
        $user_agent = bymt_args_server( 'HTTP_USER_AGENT');
        $comment['comment_agent'] = !empty( $user_agent ) ? substr( $user_agent, 0, 254 ) : '';
        if ( wp_blacklist_check( $comment['comment_author'], $comment['comment_author_email'], $comment['comment_author_url'], $comment['comment_content'], $comment['comment_author_IP'], $comment['comment_agent'] ) ) {
            wp_die( __( '抱歉，垃圾评论请您圆润的离开' ) );
        }

    }
    return $comment;
}
add_action( 'preprocess_comment', 'bymt_ban_blacklist', 15 );

// Meta 评论链接添加 nofollow
function bymt_comment_popup_nofollow() {
    return ' rel="nofollow"';
}
add_filter( 'comments_popup_link_attributes', 'bymt_comment_popup_nofollow' );

// 评论用户链接 - 新窗口打开
function bymt_comment_author_link_newtab( $return ) {
    if ( bymt_option( 'comment_author_link_newtab' ) ) {
        $return = str_replace( 'rel', 'target=\'_blank\' rel', $return );
    }
    return $return;
}
add_filter( 'get_comment_author_link', 'bymt_comment_author_link_newtab', 10 );

// 评论用户链接 - 加密显示和跳转
function bymt_comment_author_link_encrypt( $url ) {
    if (  bymt_contrast( 'comment_author_link_type', 'internal' ) ) {
        if ( !is_admin() && !empty( $url ) && trailingslashit( $url ) !== home_url( '/' )  && 'http://' !== $url && 'https://' !== $url ) {
            $url = esc_url( home_url( '/link?url=' ) . ( bymt_option( 'comment_author_link_encrypt' ) ? bymt_base64( $url ) : urlencode( $url ) ) );
        }
    }
    if ( bymt_contrast( 'comment_author_link_type', 'disable' ) ) {
        $url = '';
    }
    return $url;
}
add_filter( 'get_comment_author_url', 'bymt_comment_author_link_encrypt', 10 );

// 评论邮件通知
function bymt_comment_mail_notify( $comment_id ) {
    if ( bymt_option( 'comment_mail_notify' ) ) {
        $comment = get_comment( $comment_id );
        $admin_email = trim( get_bloginfo( 'admin_email' ) );
        $user_email = trim( $comment->comment_author_email );
        $approved = $comment->comment_approved;
        $parent = absint( $comment->comment_parent );
        $parent_approved = wp_get_comment_status( $parent );
        if ( $parent && $user_email !== $admin_email && 'spam' !== $approved && 'spam' !== $parent_approved ) {
            $blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
            $wp_email = 'wordpress@' . preg_replace( '#^www\.#', '', strtolower( bymt_args_server( 'SERVER_NAME' ) ) );
            if ( '' == $comment->comment_author ) {
                $from = "From: \"{$blogname}\" <{$wp_email}>";
                if ( '' != $comment->comment_author_email ) {
                    $reply_to = "Reply-To: {$comment->comment_author_email}";
                }
            } else {
                $from = "From: \"{$comment->comment_author}\" <{$wp_email}>";
                if ( '' != $comment->comment_author_email ) {
                    $reply_to = "Reply-To: \"{$comment->comment_author_email}\" <{$comment->comment_author_email}>";
                }
            }
            $headers = "{$from}\nContent-Type: text/html; charset=\"" . get_bloginfo( 'blog_charset' ) . "\"\n";
            if ( isset( $reply_to ) ) {
                $headers .= $reply_to . "\n";
            }
            $blog_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
            $subject = __( '您的评论有了新的回复' ) . ' - ' . $blog_name;
            $message = '<style>body{color:#333;background-color:#f3f3f3}.mail_notify{position:relative;width:80%;padding:20px;margin:2em auto;background-color:#FFF;box-shadow:0 1px 3px 0 rgba(0,0,0,0.2),inset 0 -1px 0 0 rgba(0,0,0,0.2);border-radius:3px}.notify-title{line-height:1.3;padding:0 10px 10px;margin-top:0;margin-bottom:25px;font-size:17px;font-weight:400;color:#555;border-bottom:1px #ddd solid;text-shadow:0 1px #efefef;box-shadow:0 10px 5px -2px #eee}.notify-author{position:relative;float:left;border:1px solid #fcfcfc;box-shadow:1px 2px 3px 0 #ddd;border-radius:3px}.notify-content{position:relative;min-height:52px;padding:15px;margin-left:70px;background:#f8f8f8;box-shadow:inset 0 -1px 0 0 rgba(0,0,0,0.1);border-radius:3px}.notify-content:before,.notify-content:after{position:absolute;content:"";width:0;height:0;border-width:10px 10px 10px 0;border-style:solid}.notify-content:before{top:17px;left:-9px;border-color:transparent #e8e8e8}.notify-content:after{top:16px;left:-8px;border-color:transparent #f8f8f8}.notify-mata{height:24px;line-height:24px;margin-bottom:10px;font-size:13px}.notify-mata span{margin-right:5px;color:#aaa}.notify-mata .author{color:#009688}.notify-detail{margin:5px 0;font-size:14px}.notify-children{margin-top:20px;margin-left:70px}.notify-foot{padding-top:20px;margin-top:35px;font-size:13px;text-align:center;color:#555;border-top:1px solid #ddd;white-space:pre-wrap;word-break:break-all}.notify-foot a{color:#08D;text-decoration:none}.notify-foot a:hover{color:#009688}.notify-foot span{color:#888}</style><div class="mail_notify"><h3 class="notify-title">' . __( 'Reply: ' ) . esc_html( get_the_title( $comment->comment_post_ID ) ) . '</h3><div class="notify-main"><div class="notify-author">' . bymt_gravatar( get_comment( $parent )->comment_author_email, '50', 'avatar', false ) . '</div><div class="notify-content"><div class="notify-mata"><span class="author">' . esc_html( get_comment( $parent )->comment_author ) . '</span><span class="date">' . esc_html( bymt_time_ago( 'comment', get_comment( $parent )->comment_date ) ) . '</span></div><div class="notify-detail">' . get_comment( $parent )->comment_content . '</div></div></div><div class="notify-children"><div class="notify-author">' . bymt_gravatar( $user_email, '40', 'avatar', false ) . '</div><div class="notify-content"><div class="notify-mata"><span class="author">' . esc_html( $comment->comment_author ) . '</span><span class="date">' . esc_html( bymt_time_ago( 'comment', $comment->comment_date ) ) . '</span></div><div class="notify-detail">' . $comment->comment_content . '</div></div></div><div class="notify-foot"><p>' . __( '文章链接：' ) . '<a href="' . esc_url( get_permalink( $comment->comment_post_ID ) ) . '">' . esc_html( get_permalink( $comment->comment_post_ID ) ) . '</a></p><p><span>[' . __( '系统邮件自动发送，请勿回复' ) . ' ' . date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ) . ' ' . get_bloginfo( 'name' ) . ']</span></p></div></div>';
           @wp_mail( $user_email, wp_specialchars_decode( $subject ), $message, $headers );
        }
    }
}
add_action( 'comment_post', 'bymt_comment_mail_notify' );

// 禁止所有Pingback
if ( bymt_option( 'ban_pingback' ) ) {
    add_filter( 'pings_open', function( $open ) {
        return 'closed';
    });
    add_filter( 'xmlrpc_methods', function( $methods ) {
        unset( $methods['pingback.ping'] );
        unset( $methods['pingback.extensions.getPingbacks'] );
        return $methods;
    });
    add_filter( 'wp_headers', function( $headers ) {
        unset( $headers['X-Pingback'] );
        return $headers;
    });
    add_action( 'xmlrpc_call', function( $method ) {
        if( $method !== 'pingback.ping' ) return;
        wp_die( __( '网站已禁止 Pingback !' ) );
    });
    add_action( 'pre_ping', function( &$links ) {
        foreach ( $links as $i => $link ) {
            if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
                unset($links[$i]);
            }
        }
    });
}

// 评论数前增加图标
function bymt_comments_number( $output ) {
    return $output = '<i class="iconfont icon-comment"></i>' . $output;
}
add_filter( 'comments_number', 'bymt_comments_number' );

// 移除 WP 近期评论样式
function bymt_remove_recentcomments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'bymt_remove_recentcomments_style');
