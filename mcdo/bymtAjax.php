<?php !defined( 'WPINC' ) && exit();
/**
 * bymtAjax.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */


// 显示喜欢数
function bymt_like_count( $like_type = 'post', $like_id = 0, $count = false ) {
    $like_nonce = wp_create_nonce( 'bymt_like_nonce' );
    if ( $like_type === 'post' ) {
        $like_id = $like_id ? absint( $like_id ) : absint( get_the_ID() );
        $like_count = absint( get_post_meta( $like_id, 'bymt_like', true ) );
    } elseif ( $like_type === 'comment' ) {
        $like_id = $like_id ? absint( $like_id ) : absint( get_comment_ID() );
        $like_count = absint( get_comment_meta( $like_id, 'bymt_like', true ) );
    } else {
        return;
    }
    if ( $count ) {
        return (int)$like_count;
    } else {
        $liked = bymt_like_liked( $like_type, $like_id ) ? ' liked' : '';
        $like_icon = $liked ? 'liked' : 'like';
        $like_show = $like_count ? ' show' : '';
        return "<a class=\"bymt-like{$liked}{$like_show}\" href=\"javascript:;\" data-lid=\"{$like_id}\" data-nonce=\"{$like_nonce}\" data-type=\"{$like_type}\" title=\"" . __( '喜欢' ) . "\"><i class=\"iconfont icon-{$like_icon}\"></i>{$like_count}</a>";
    }
}

// 判断是否喜欢过
function bymt_like_liked( $like_type = 'post', $like_id = 0 ) {
    global $user_ID, $user_email;
    $like_type_allow = array( 'post', 'comment' );
    if ( !in_array( $like_type, $like_type_allow ) ) return false;
    $get_meta = 'get_' . $like_type . '_meta';
    $liked_users = $get_meta( $like_id, '_bymt_like_users' );
    if ( empty( $liked_users ) ) return false;
    if ( !$user_ID ) {
        $commenter = wp_get_current_commenter();
        $user_email = $commenter['comment_author_email'];
    }
    $user_IP = bymt_args_server( 'REMOTE_ADDR' );
    $liked = 0;
    foreach ($liked_users as $key => $val) {
        $_user_ID = isset( $val['user_ID'] ) ? $val['user_ID'] : '';
        $_user_IP = isset( $val['user_IP'] ) ? $val['user_IP'] : '';
        $_user_Email = isset( $val['user_Email'] ) ? $val['user_Email'] : '';
        $_like_type = isset( $val['like_type'] ) ? $val['like_type'] : '';
        if ( $_like_type !== 'like' ) continue;
        if ( ( !empty( $user_ID ) && $_user_ID === $user_ID ) || ( !empty( $user_IP ) && $_user_IP === $user_IP ) || ( !empty( $user_email ) && $_user_Email === $user_email ) ) {
            $liked++;
        }
    }
    return (bool) $liked;
}

// 更新喜欢数据
function bymt_like_update() {
    global $user_ID, $user_email;
    if ( !$user_ID ) {
        $commenter = wp_get_current_commenter();
        $user_email = $commenter['comment_author_email'];
    }
    $like_type = bymt_args_post( 'type' );
    $like_status = bymt_args_post( 'status' );
    $like_id = bymt_args_post( 'lid' );
    $like_nonce = bymt_args_post( 'nonce' );
    $like_type_allow = array( 'post' => '这篇文章', 'comment' => '这条评论' );
    $verify_nonce = wp_verify_nonce( $like_nonce, 'bymt_like_nonce' );
    if ( !$verify_nonce || empty( $like_type ) || empty( $like_status ) || empty( $like_id ) || !array_key_exists( $like_type, $like_type_allow ) ) {
        $result = array( 'status' => '405', 'msg' => '您的请求无效' );
    } else {
        $user_info = array(
            'user_ID' => $user_ID ? $user_ID : 0,
            'user_IP' => bymt_args_server( 'REMOTE_ADDR' ),
            'user_Email' => $user_email,
            'like_type' => 'like'
        );
        $get_meta = 'get_' . $like_type . '_meta';
        $add_meta = 'add_' . $like_type . '_meta';
        $update_meta = 'update_' . $like_type . '_meta';
        $delete_meta = 'delete_' . $like_type . '_meta';
        $like_count = absint( $get_meta( $like_id, 'bymt_like', true ) );
        $liked = bymt_like_liked( $like_type, $like_id );
        $do_count = $liked ? $like_count - 1 : $like_count + 1;
        $do_meta = $liked ? $delete_meta : $add_meta;
        $do_icon = $liked ? 'like' : 'liked';
        $update_meta( $like_id, 'bymt_like', $do_count );
        $do_meta( $like_id, '_bymt_like_users', $user_info );
        $result = array( 'status' => '200', 'type' => $do_icon, 'data' => '<i class="iconfont icon-' . $do_icon . '"></i>' . ( $do_count ) );
    }
    header( 'Content-type:text/json' );
    die( json_encode( $result ) );
}
add_action( 'wp_ajax_bymt_like', 'bymt_like_update');
add_action( 'wp_ajax_nopriv_bymt_like', 'bymt_like_update' );

// Ajax操作
function bymt_ajax( $type = '' ) {
    if ( $type ) {
        return wp_create_nonce( 'bymt_ajax_nonce_' . $type );
    }
    $ajax_type = bymt_args_post( 'type' );
    $ajax_value = bymt_args_post( 'value' );
    $ajax_nonce = bymt_args_post( 'nonce' );
    $ajax_type_allow = array( 'search', 'comment', 'page_post', 'page_comment' );
    $verify_nonce = wp_verify_nonce( $ajax_nonce, 'bymt_ajax_nonce_' . $ajax_type );
    if ( !$verify_nonce || empty( $ajax_type ) || empty( $ajax_value ) || !in_array( $ajax_type, $ajax_type_allow ) ) {
        $result = array( 'status' => '405', 'msg' => '您的请求无效' );
    } else {
        switch ( $ajax_type ) {
            case 'search':
                $args = array(
                    's' => $ajax_value,
                    'posts_per_page' => bymt_define( 'ajax_search_number', '10' ),
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'post_type' => 'any'
                );
                $result = array();
                $search = new WP_Query( $args );
                while ( $search->have_posts() ) {
                    $search->the_post();
                    array_push( $result, array( 
                        'title' => get_the_title(),
                        'url' => get_permalink(),
                        'time' => get_the_date( 'Y-m-d' ),
                    ) );
                }
                wp_reset_postdata();
                break;
            case 'comment':
                $comment_post_ID = absint( bymt_args_post( 'comment_post_ID' ) );
                $post = get_post($comment_post_ID);
                if ( empty( $post->comment_status ) ) {
                    do_action( 'comment_id_not_found', $comment_post_ID );
                    exit;
                }
                $status = get_post_status($post);
                $status_obj = get_post_status_object($status);
                if ( ! comments_open( $comment_post_ID ) ) {
                    do_action( 'comment_closed', $comment_post_ID );
                    wp_die( __( 'Sorry, comments are closed for this item.' ), 403 );
                } elseif ( 'trash' == $status ) {
                    do_action( 'comment_on_trash', $comment_post_ID );
                    exit;
                } elseif ( ! $status_obj->public && ! $status_obj->private ) {
                    do_action( 'comment_on_draft', $comment_post_ID );
                    exit;
                } elseif ( post_password_required( $comment_post_ID ) ) {
                    do_action( 'comment_on_password_protected', $comment_post_ID );
                    exit;
                } else {
                    do_action( 'pre_comment_on_post', $comment_post_ID );
                }
                $comment_author       = trim( strip_tags( bymt_args_post( 'author' ) ) );
                $comment_author_email = trim( bymt_args_post( 'email' ) );
                $comment_author_url   = trim( bymt_args_post( 'url' ) );
                $comment_content      = trim( bymt_args_post( 'comment' ) );
                $user = wp_get_current_user();
                if ( $user->exists() ) {
                    if ( empty( $user->display_name ) ) $user->display_name=$user->user_login;
                    $comment_author       = wp_slash( $user->display_name );
                    $comment_author_email = wp_slash( $user->user_email );
                    $comment_author_url   = wp_slash( $user->user_url );
                    if ( current_user_can( 'unfiltered_html' ) ) {
                        if ( ! wp_verify_nonce( bymt_args_post( '_wp_unfiltered_html_comment' ), 'unfiltered-html-comment_' . $comment_post_ID ) ) {
                            kses_remove_filters();
                            kses_init_filters();
                        }
                    }
                } else {
                    if ( get_option( 'comment_registration' ) || 'private' == $status ) {
                        wp_die( __( 'Sorry, you must be logged in to post a comment.' ), 403 );
                    }
                }
                $comment_type = '';
                if ( get_option('require_name_email') && !$user->exists() ) {
                    if ( 6 > strlen( $comment_author_email ) || '' == $comment_author ) {
                        wp_die( __( '<strong>ERROR</strong>: please fill the required fields (name, email).' ), 200 );
                    } elseif ( ! is_email( $comment_author_email ) ) {
                        wp_die( __( '<strong>ERROR</strong>: please enter a valid email address.' ), 200 );
                    }
                }
                if ( '' == $comment_content || '' == str_replace( array( '&nbsp;', ' ' ), '', strip_tags( $comment_content ) ) ) {
                    wp_die( __( '<strong>ERROR</strong>: please type a comment.' ), 200 );
                }
                $comment_parent = absint( bymt_args_post( 'comment_parent' ) );
                $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
                $comment_id = wp_new_comment( $commentdata );
                if ( ! $comment_id ) {
                    wp_die( __( "<strong>ERROR</strong>: The comment could not be saved. Please try again later." ) );
                }
                $comment = get_comment( $comment_id );
                do_action( 'set_comment_cookies', $comment, $user );
                $msg = wp_list_comments( array(
                    'type' => 'comment',
                    'echo' => false,
                    'is_new' => true,
                    'callback' => 'bymt_comments_list'
                ), array( $comment ) );
                $result = array( 'status' => '200', 'msg' => $msg, 'scroll' => '#comment-' . $comment_id );
                break;
        }
    }
    nocache_headers();
    header( 'Content-type:text/json' );
    die( json_encode( $result ) );
}
add_action( 'wp_ajax_bymt_ajax', 'bymt_ajax');
add_action( 'wp_ajax_nopriv_bymt_ajax', 'bymt_ajax' );

// PJAX 文章列表翻页
function bymt_pjax_page_post() {
    if ( !bymt_is_pjax() ) return;
    if ( have_posts() ) {
        echo '<title>' . wp_title( bymt_define( 'delimiter', '|' ), false, 'right' ) . '</title>';
        while ( have_posts() ) {
            the_post();
?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" role="article">
                <?php bymt_include_post_format(); ?>
            </article>
<?php
        }
        echo '<div id="post-pagenavi" class="pagination">' . str_replace( array( '?pjax=true', '&amp;pjax=true' ), '', bymt_pagenavi() ) . '</div>';
        exit();
    }
}
add_action( 'bymt_post_pjax', 'bymt_pjax_page_post' );

// PJAX 评论列表翻页
function bymt_pjax_page_comment() {
    if ( !bymt_is_pjax() ) return;
    if ( have_comments() ) {
        echo '<title>' . wp_title( bymt_define( 'delimiter', '|' ), false, 'right' ) . '</title>';
        $commentlist = wp_list_comments( array( 'type' => 'comment', 'callback' => 'bymt_comments_list', 'echo' => false ) );
        $pingbacklist = wp_list_comments( array( 'type' => 'pingback', 'callback' => 'bymt_pingback_list', 'echo' => false ) );
        echo '<ol id="commentlist" class="commentlist">' . $commentlist . '</ol>';
        echo '<ol class="pingbacklist">' . $pingbacklist . '</ol>';
        echo '<div id="comment-pagenavi" class="pagination">' . str_replace( array( '?pjax=true', '&amp;pjax=true' ), '', paginate_comments_links( array( 'prev_text' => '上页', 'next_text' => '下页', 'echo' => false ) ) ) . '</div>';
        exit();
    }
}
add_action( 'bymt_comment_pjax', 'bymt_pjax_page_comment' );
