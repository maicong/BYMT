<?php !defined( 'WPINC' ) && exit();
/**
 * bymtOptions.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

// 添加到菜单
function bymt_create_admin_menu () {
    add_theme_page( __( 'BYMT设置' ), __( 'BYMT设置' ), 'edit_theme_options', 'bymt_options', 'bymt_options_page' );
    add_menu_page( __( 'BYMT设置' ), __( 'BYMT设置' ), 'edit_theme_options', 'bymt_options', 'bymt_options_page', bymt_static( 'images/icon_setting.png' ), 50 );
    add_submenu_page( 'bymt_options',  __( '使用帮助' ), __( '使用帮助' ), 'edit_theme_options', 'bymt_help', 'bymt_help_page' );

}
add_action( 'admin_menu', 'bymt_create_admin_menu' );

// 注册寄存器
function bymt_register_setting() {
    $defaults = array(
        'sidebar_float' => 'fr',
        'tooltip_layout' => 'auto top',
        'post_tag_aotolink_number' => '10',
        'post_relate_number' => '6',
        'comment_word_limit_min_number' => '2',
        'comment_word_limit_max_number' => '5000',
        'comment_link_limit_number' => '3',
        'comment_link_limit_length' => '255',
        'comment_author_link_type' => 'self',
        'slider_header_speed_a' => '600',
        'slider_header_speed_s' => '5000',
        'slider_widget_speed_a' => '600',
        'slider_widget_speed_s' => '5000',
        'jquery_src' => 'theme',
        'ajax_search_number' => '10',
        'emoji_url' => 'self',
        'time_ago_day' => '30',
        'auto_translate_type' => 'baidu',
        'cdn_ext' => 'png|jpg|jpeg|bmp|gif|css|js'
    );
    $bymt_options = get_option( 'bymt_options_v3' );
    if ( empty( $bymt_options ) || bymt_args_post( 'reset' ) ) {
        update_option( 'bymt_options_v3', $defaults );
        bymt_args_post( 'reset' ) && add_settings_error('general', 'settings_updated', __( '设置已恢复默认' ), 'updated');
    }
    if ( bymt_args_get( 'import' ) && bymt_args_post( 'data' ) ) {
        $data = @unserialize( bymt_base64( bymt_args_post( 'data' ), 'decode' ) );
        if ( !empty( $data ) ) {
            update_option( 'bymt_options_v3', $data );
            exit('1');
        }
        exit();
    }
    if ( bymt_args_get( 'settings-updated' ) === 'true' ) {
        update_option( 'bymt_options_v3_backup', bymt_base64( serialize( get_option( 'bymt_options_v3' ) ) ) );
    }
    if ( bymt_args_get( 'export' ) ) {
        $time = date( 'YmdHis', current_time( 'timestamp' ) );
        header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        header( "Pragma: no-cache ");
        header( "Content-Description: File Transfer" );
        header( 'Content-Disposition: attachment; filename="bymt-options-v3-backup-' . $time . '.txt"');
        header( "Content-Type: application/octet-stream");
        header( "Content-Transfer-Encoding: binary" );
        echo get_option( 'bymt_options_v3_backup' );
        exit();
    }
    register_setting( 'bymt_options_group_v3', 'bymt_options_v3' );
}
add_action( 'admin_init', 'bymt_register_setting' );

// 加载样式
function bymt_options_style() {
    if ( bymt_args_get( 'page' ) === 'bymt_options' ) {
        wp_enqueue_media();
        wp_enqueue_style( 'editor-buttons' );
        wp_enqueue_script( 'wplink' );
        wp_enqueue_style( 'bymt-setting', bymt_static( 'css/bymt-setting.css' ), array(), BYMT_VER );
        wp_enqueue_script( 'bymt-setting', bymt_static( 'js/bymt-setting.js' ), array( 'jquery' ), BYMT_VER, true);
    }
}
add_action( 'admin_print_styles', 'bymt_options_style' );

// 输入框
function bymt_opt_input($type, $name, $value = '', $current = false){
    $_name = 'bymt_options_v3[' . esc_attr( $name ) . ']';
    $_id = str_replace('_', '-', $name);
    switch ($type) {
        case 'text':
            $value = !empty($value) ? ' value="' . esc_attr($value) . '"' : '';
            $html = "<input id=\"{$_id}\" name=\"{$_name}\" type=\"text\"{$value}/>";
            break;
        case 'upload':
            $html = bymt_opt_input('text', $name, $value);
            $value = __( 'Select Files' );
            $html .= "<input id=\"upload-{$_id}\" class=\"button tb-upload\" type=\"button\" value=\"{$value}\"/>";
            break;
        case 'link':
            $html = bymt_opt_input('text', $name, $value);
            $value = __( '选择链接' );
            $html .= "<input id=\"link-{$_id}\" class=\"button tb-link\" type=\"button\" value=\"{$value}\"/>";
            break;
        case 'number':
            $value = !empty($value) ? ' value="' . esc_attr($value) . '"' : '';
            $html = "<input id=\"{$_id}\" name=\"{$_name}\" type=\"number\" min=\"0\" step=\"1\"{$value}/>";
            break;
        case 'checkbox':
            $is_checked = checked( $value, $current, false );
            $value = !empty($value) ? ' value="' . esc_attr($value) . '"' : '';
            $html = "<input id=\"{$_id}\" name=\"{$_name}\" type=\"checkbox\"{$value} {$is_checked}/>";
            break;
        case 'radio':
            $is_checked = checked( $value, $current, false );
            $value = !empty($value) ? 'value="' . esc_attr($value) . '"' : '';
            $html = "<input name=\"{$_name}\" type=\"radio\"{$value} {$is_checked}/>";
            break;
        case 'textarea':
            $value = !empty($value) ? esc_html($value) : '';
            $html = "<textarea id=\"{$_id}\" name=\"{$_name}\" rows=\"5\">{$value}</textarea>";
            if ( in_array($_name, array( 'bymt_options_v3[backup_data]', 'bymt_options_v3[restore_data]') ) ) {
                $html = str_replace( "name=\"{$_name}\"", "", $html);
            }
            break;
        case 'select':
            if ( !is_array($value) || empty($value) ) return;
            $html = "<select id=\"{$_id}\" name=\"{$_name}\">";
            foreach ($value as $key => $val) {
                $key = esc_attr($key);
                $val = esc_attr($val);
                $is_selected = selected( $val, $current, false );
                $html .= "<option value=\"{$key}\" {$is_selected}>{$val}</option>";
            }
            $html .= "</select>";
            break;
        default:
            return;
    }
    return $html;
}

// BYMT 设置
function bymt_options_page() {
    $nav_title = __( 'BYMT 设置' );
    $upload_dir = wp_upload_dir();
    $opts_basic = array(
        'delimiter' => array(
            'type' => 'text',
            'label' => __( '标题分隔符' ),
            'desc' => __( '例如： | - _' )
        ),
        'home_title' => array(
            'type' => 'text',
            'label' => __( '首页标题' ),
            'desc' => __( '留空则使用默认，一般不超过 80 个字符' )
        ),
        'home_description' => array(
            'type' => 'textarea',
            'label' => __( '首页描述' ),
            'desc' => __( '用简洁凝练的话对您的网站进行描述，一般不超过 200 个字符' )
        ),
        'stat_code' => array(
            'type' => 'textarea',
            'label' => __( '统计代码' ),
            'desc' => __( '统计代码图标不会在页面中显示' )
        ),
        'foot_copr' => array(
            'type' => 'textarea',
            'label' => __( '页脚版权' ),
            'desc' => __( '自定义页脚版权信息，支持 HTML 代码' )
        ),
        'logo_src' => array(
            'type' => 'upload',
            'label' => __( 'LOGO' ),
            'desc' => __( '默认 LOGO：<code>' . bymt_static( 'images/logo@3x.png' ) . '</code>' )
        ),
        'footer_logo_src' => array(
            'type' => 'upload',
            'label' => __( 'LOGO（页脚）' ),
            'desc' => __( '默认 LOGO：<code>' . bymt_static( 'images/foot-logo@3x.png' ) . '</code>' )
        ),
        'favicon_src' => array(
            'type' => 'upload',
            'label' => __( 'Favicon' ),
            'desc' => __( '默认 Favicon：<code>' . bymt_static( 'images/favicon.png' ) . '</code>' )
        ),
        'avatar_src' => array(
            'type' => 'upload',
            'label' => __( '默认头像' ),
            'desc' => __( '默认头像：<code>' . bymt_static( 'images/avatar.jpg' ) . '</code>' )
        ),
        'search_text' => array(
            'type' => 'text',
            'label' => __( '搜索提示文字' ),
            'desc' => __( '搜索框默认提示文字，请注意控制长度' )
        ),
        'header' => array(
            'type' => 'checkbox',
            'label' => __( '页头' ),
            'subitem' => array(
                'nav_fixed' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用导航跟随' )
                ),
                'logo_animation' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用 LOGO 动画' )
                ),
                'str_data_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用结构化数据元信息' )
                ),
                'meta_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用自定义元信息' ),
                    'wrap' => true
                ),
                'meta' => array(
                    'type' => 'textarea',
                    'label' => __( '自定义元信息' ),
                    'desc' => '输入自定义的 HTML 元信息，结尾请换行，<code><a href="http://www.w3schools.com/tags/tag_meta.asp" target="_blank">说明文档</a></code>。如果您需要自定义各种图标，可以到 <code><a href="http://realfavicongenerator.net/" target="_blank">Favicon Generator</a></code> 在线制作。'
                ),
            )
        ),
        'footer' => array(
            'type' => 'checkbox',
            'label' => __( '页脚' ),
            'subitem' => array(
                'nav' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用导航' ),
                ),
                'widget' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用小工具' ),
                ),
                'back_top' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用返回顶部' ),
                ),
            )
        ),
        'sidebar' => array(
            'type' => 'checkbox',
            'label' => __( '侧栏' ),
            'subitem' => array(
                'auto_height' => array(
                    'type' => 'checkbox',
                    'label' => __( '高度自动适配' )
                ),
                'fl' => array(
                    'type' => 'radio',
                    'label' => __( '靠左' ),
                    'parent' => 'float'
                ),
                'fr' => array(
                    'type' => 'radio',
                    'label' => __( '靠右' ),
                    'parent' => 'float'
                ),
            ),
            'desc' => __( '显示侧栏（请到 <a href="' . admin_url( 'widgets.php'). '">小工具</a> 进行配置）' )
        ),
        'bulletin' => array(
            'type' => 'checkbox',
            'label' => __( '公告栏' ),
            'subitem' => array(
                'id' => array(
                    'type' => 'number',
                    'label' => __( '作为公告栏的文章 ID：' ),
                ),
                'number' => array(
                    'type' => 'number',
                    'label' => __( '显示数量：' ),
                    'wrap' => true
                ),
                'custom_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用自定义公告内容' ),
                ),
                'custom' => array(
                    'type' => 'textarea',
                    'label' => __( '自定义公告内容：' ),
                    'desc' => __( '输入自定义公告内容，支持 HTML 代码' )
                ),
            ),
            'desc' => __( '显示公告栏' )
        ),
        'tooltip' => array(
            'type' => 'checkbox',
            'label' => __( '工具提示' ),
            'subitem' => array(
                'show' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用工具提示' ),
                ),
                'auto top' => array(
                    'type' => 'radio',
                    'label' => __( '靠上' ),
                    'parent' => 'layout'
                ),
                'auto bottom' => array(
                    'type' => 'radio',
                    'label' => __( '靠下' ),
                    'parent' => 'layout'
                ),
                'auto left' => array(
                    'type' => 'radio',
                    'label' => __( '靠左' ),
                    'parent' => 'layout'
                ),
                'auto right' => array(
                    'type' => 'radio',
                    'label' => __( '靠右' ),
                    'parent' => 'layout'
                ),
            )
        ),
        'breadcrumb' => array(
            'type' => 'checkbox',
            'label' => __( '面包屑导航' ),
            'subitem' => array(
                'show' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用面包屑' ),
                ),
                'not_home' => array(
                    'type' => 'checkbox',
                    'label' => __( '首页不显示' ),
                )
            )
        ),
        'img_lazyload' => array(
            'type' => 'checkbox',
            'label' => __( '图片延迟加载' ),
            'desc' => __( '当图片在可见区域内才载入' )
        ),
        'img_lightbox' => array(
            'type' => 'checkbox',
            'label' => __( '图片灯箱' ),
            'desc' => __( '启用图片灯箱查看大图' )
        ),
        'load_effect' => array(
            'type' => 'checkbox',
            'label' => __( '载入特效' ),
            'desc' => __( '启用载入特效' )
        )
    );
    $opts_post = array(
        'post_tag' => array(
            'type' => 'checkbox',
            'label' => __( '文章标签' ),
            'desc' => __( '显示文章标签' ),
            'subitem' => array(
                'aotolink' => array(
                    'type' => 'checkbox',
                    'label' => __( '自动链接文章标签' ),
                    'desc' => __( '自动对文章中的标签添加超链接' )
                ),
                'aotolink_number' => array(
                    'type' => 'number',
                    'label' => __( '最多链接次数（留空或 0 不限制）：' )
                ),
            )
        ),
        'post_relate' => array(
            'type' => 'checkbox',
            'label' => __( '相关文章' ),
            'desc' => __( '显示相关文章' ),
            'subitem' => array(
                'match_tag' => array(
                    'type' => 'checkbox',
                    'label' => __( '匹配同标签文章' ),
                ),
                'match_category' => array(
                    'type' => 'checkbox',
                    'label' => __( '匹配同栏目文章' ),
                ),
                'number' => array(
                    'type' => 'number',
                    'label' => __( '显示数量：' ),
                ),
            )
        ),
        'post_share' => array(
            'type' => 'checkbox',
            'label' => __( '文章分享' ),
            'desc' => __( '启用主题提供的文章分享功能' ),
            'subitem' => array(
                'weibo_appkey' => array(
                    'type' => 'text',
                    'label' => __( '微博 Appkey：' )
                ),
                'tweet_name' => array(
                    'type' => 'text',
                    'label' => __( '推特 用户名：' )
                ),
            )
        ),
        'post_copyright' => array(
            'type' => 'checkbox',
            'label' => __( '文章版权' ),
            'subitem' => array(
                'show_desc' => array(
                    'type' => 'checkbox',
                    'label' => __( '显示作者个人说明' )
                ),
                'desc' => array(
                    'type' => 'text',
                    'label' => __( '默认个人说明：' )
                )
            ),
            'desc' => __( '显示文章作者和版权信息' )
        ),
        'post_view' => array(
            'type' => 'checkbox',
            'label' => __( '文章浏览量' ),
            'desc' => __( '启用文章浏览量功能（需安装插件 <code><a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-postviews' ) . '">wp-postviews</a></code> ）' )
        ),
        'post_like' => array(
            'type' => 'checkbox',
            'label' => __( '文章喜欢' ),
            'desc' => __( '启用主题提供的文章喜欢功能' )
        ),
        'post_nav' => array(
            'type' => 'checkbox',
            'label' => __( '上下文' ),
            'desc' => __( '显示上一篇和下一篇链接' )
        ),
        'code_highlight' => array(
            'type' => 'checkbox',
            'label' => __( '代码高亮' ),
            'desc' => __( '启用主题提供的代码高亮功能（请不要与其他代码高亮插件同时使用）' )
        ),
        'code_escape' => array(
            'type' => 'checkbox',
            'label' => __( '代码转义' ),
            'desc' => __( '对 &lt;pre&gt; 里的代码进行 <code>esc_html()</code> 处理' )
        ),
        'post_img_alt' => array(
            'type' => 'checkbox',
            'label' => __( '图片 Alt' ),
            'desc' => __( '文章图片自动添加 Alt' )
        ),
        'post_feed_copr' => array(
            'type' => 'checkbox',
            'label' => __( 'Feed 版权' ),
            'desc' => __( '添加版权信息' )
        ),
        'post_excerpt' => array(
            'type' => 'checkbox',
            'label' => __( '列表摘要' ),
            'subitem' => array(
                'length' => array(
                    'type' => 'number',
                    'label' => __( '摘要最大字数（留空则使用默认）：' ),
                ),
            )
        ),
    );
    $opts_comment = array(
        'comment_tools' => array(
            'type' => 'checkbox',
            'label' => __( '评论框增强' ),
            'desc' => __( '启用评论框增强' ),
            'wrap' => true,
            'subitem' => array(
                'smile' => array(
                    'type' => 'checkbox',
                    'label' => __( '表情' ),
                ),
                'font_bold' => array(
                    'type' => 'checkbox',
                    'label' => __( '粗体' )
                ),
                'font_italic' => array(
                    'type' => 'checkbox',
                    'label' => __( '斜体' )
                ),
                'font_underline' => array(
                    'type' => 'checkbox',
                    'label' => __( '下划线' )
                ),
                'font_strikethrough' => array(
                    'type' => 'checkbox',
                    'label' => __( '删除线' )
                ),
                'list_numbered' => array(
                    'type' => 'checkbox',
                    'label' => __( '有序列表' )
                ),
                'list_bulleted' => array(
                    'type' => 'checkbox',
                    'label' => __( '无序列表' ),
                    'wrap' => true
                ),
                'quote' => array(
                    'type' => 'checkbox',
                    'label' => __( '引用' )
                ),
                'code' => array(
                    'type' => 'checkbox',
                    'label' => __( '代码' )
                ),
                'image' => array(
                    'type' => 'checkbox',
                    'label' => __( '图片' )
                ),
                'audio' => array(
                    'type' => 'checkbox',
                    'label' => __( '音频' )
                ),
                'video' => array(
                    'type' => 'checkbox',
                    'label' => __( '视频' )
                ),
                'undo' => array(
                    'type' => 'checkbox',
                    'label' => __( '撤销' )
                ),
                'redo' => array(
                    'type' => 'checkbox',
                    'label' => __( '恢复' )
                ),
            )
        ),
        'comment_html_filter' => array(
            'type' => 'checkbox',
            'label' => __( '评论 HTML 过滤' ),
            'desc' => __( '启用过滤（所有标签都将过滤，过滤后不显示）' ),
            'subitem' => array(
                'not_resolve' => array(
                    'type' => 'checkbox',
                    'label' => __( '不解析评论代码' ),
                ),
                'allow' => array(
                    'type' => 'textarea',
                    'label' => __( '例外：' ),
                    'desc' => __( '不过滤的 HTML 标签，多个请用英文逗号隔开，例如：<code>a,pre,code,blockquote</code>' )
                )
            )
        ),
        'comment_lang_filter' => array(
            'type' => 'checkbox',
            'label' => __( '评论语言过滤' ),
            'subitem' => array(
                'cn' => array(
                    'type' => 'checkbox',
                    'label' => __( '中文' )
                ),
                'en' => array(
                    'type' => 'checkbox',
                    'label' => __( '英文' )
                ),
                'ja' => array(
                    'type' => 'checkbox',
                    'label' => __( '日文' )
                ),
                'ru' => array(
                    'type' => 'checkbox',
                    'label' => __( '俄文' )
                ),
                'kr' => array(
                    'type' => 'checkbox',
                    'label' => __( '韩文' )
                ),
                'th' => array(
                    'type' => 'checkbox',
                    'label' => __( '泰文' )
                ),
                'ar' => array(
                    'type' => 'checkbox',
                    'label' => __( '阿拉伯文' )
                ),
                'zy' => array(
                    'type' => 'checkbox',
                    'label' => __( '注音' ),
                    'wrap' => true
                ),
                'enable_tips' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用自定义提示文字' )
                ),
                'enable_regular' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用自定义正则' )
                ),
                'tips_cn' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[中]：' )
                ),
                'tips_en' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[英]：' )
                ),
                'tips_ja' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[日]：' )
                ),
                'tips_ru' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[俄]：' )
                ),
                'tips_kr' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[韩]：' )
                ),
                'tips_th' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[泰]：' )
                ),
                'tips_ar' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[阿]：' )
                ),
                'tips_zy' => array(
                    'type' => 'text',
                    'label' => __( '提示文字[注]：' )
                ),
                'regular' => array(
                    'type' => 'textarea',
                    'label' => __( '自定义正则：' ),
                    'desc' => __( '每行一条，使用 <code>&&</code> 分隔正则和提示， 例如：<code>/\p{Han}+/u&&禁止输入中文</code>，更多请见： <code><a href="http://php.net/manual/zh/regexp.reference.unicode.php" target="_blank">Unicode字符属性</a></code>' )
                )
            )
        ),
        'comment_word_limit' => array(
            'type' => 'checkbox',
            'label' => __( '评论字数限制' ),
            'desc' => __( '启用限制' ),
            'subitem' => array(
                'min_number' => array(
                    'type' => 'number',
                    'label' => __( '最少字数：' ),
                ),
                'max_number' => array(
                    'type' => 'number',
                    'label' => __( '最多字数：' ),
                )
            )
        ),
        'comment_link' => array(
            'type' => 'checkbox',
            'label' => __( '评论链接限制' ),
            'subitem' => array(
                'limit' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用限制' )
                ),
                'newtab' => array(
                    'type' => 'checkbox',
                    'label' => __( '新窗口打开' )
                ),
                'limit_number' => array(
                    'type' => 'number',
                    'label' => __( '超过多少条时拒绝：' ),
                ),
                'limit_length' => array(
                    'type' => 'number',
                    'label' => __( '超过多少字符时拒绝：' ),
                ),
            )
        ),
        'comment_author_link' => array(
            'type' => 'checkbox',
            'label' => __( '评论用户链接' ),
            'subitem' => array(
                'self' => array(
                    'type' => 'radio',
                    'label' => __( '默认' ),
                    'parent' => 'type'
                ),
                'disable' => array(
                    'type' => 'radio',
                    'label' => __( '不显示链接' ),
                    'parent' => 'type'
                ),
                'internal' => array(
                    'type' => 'radio',
                    'label' => __( '转换为内部链接' ),
                    'parent' => 'type'
                ),
                'newtab' => array(
                    'type' => 'checkbox',
                    'label' => __( '新窗口打开' )
                ),
                'encrypt' => array(
                    'type' => 'checkbox',
                    'label' => __( '加密内部链接' )
                ),
            )
        ),
        'comment_like' => array(
            'type' => 'checkbox',
            'label' => __( '评论喜欢' ),
            'desc' => __( '启用主题提供的评论喜欢功能' )
        ),
        'comment_level' => array(
            'type' => 'checkbox',
            'label' => __( '评论等级' ),
            'desc' => __( '启用用户评论等级' )
        ),
        'comment_mail_notify' => array(
            'type' => 'checkbox',
            'label' => __( '评论邮件通知' ),
            'desc' => __( '启用回复邮件通知' )
        ),
        'ban_admininfo' => array(
            'type' => 'checkbox',
            'label' => __( '注册用户信息' ),
            'desc' => __( '禁止使用注册用户信息提交' )
        ),
        'ban_blacklist' => array(
            'type' => 'checkbox',
            'label' => __( '黑名单' ),
            'desc' => __( '禁止 <a href="' . admin_url( 'options-discussion.php#blacklist_keys' ) . '" target="_blank">黑名单列表</a> 匹配项提交' )
        ),
        'ban_pingback' => array(
            'type' => 'checkbox',
            'label' => __( 'Pingback' ),
            'desc' => __( '禁止所有Pingback' )
        )
    );
    $opts_advert = array(
        'ad_home' => array(
            'type' => 'checkbox',
            'label' => __( '首页广告位' ),
            'subitem' => array(
                'header_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'header' => array(
                    'type' => 'textarea',
                    'label' => __( '页头' ),
                    'desc' => __( '推荐尺寸 1200*160' ),
                    'wrap' => true
                ),
                'footer_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'footer' => array(
                    'type' => 'textarea',
                    'label' => __( '页脚' ),
                    'desc' => __( '推荐尺寸 1200*160' ),
                    'wrap' => true
                ),
                'list_top_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'list_top' => array(
                    'type' => 'textarea',
                    'label' => __( '列表（上）' ),
                    'desc' => __( '推荐尺寸 880*180（有侧栏）1200*160（无侧栏）' ),
                    'wrap' => true
                ),
                'list_bottom_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'list_bottom' => array(
                    'type' => 'textarea',
                    'label' => __( '列表（下）' ),
                    'desc' => __( '推荐尺寸 880*180（有侧栏）1200*160（无侧栏）' ),
                    'wrap' => true
                ),
            )
        ),
        'ad_singular' => array(
            'type' => 'checkbox',
            'label' => __( '内页广告位' ),
            'subitem' => array(
                'header_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'header' => array(
                    'type' => 'textarea',
                    'label' => __( '页头' ),
                    'desc' => __( '推荐尺寸 1200*160' ),
                    'wrap' => true
                ),
                'footer_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'footer' => array(
                    'type' => 'textarea',
                    'label' => __( '页脚' ),
                    'desc' => __( '推荐尺寸 1200*160' ),
                    'wrap' => true
                ),
                'top_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'top' => array(
                    'type' => 'textarea',
                    'label' => __( '内容区（上）' ),
                    'desc' => __( '推荐尺寸 840*120（有侧栏）1160*120（无侧栏）' ),
                    'wrap' => true
                ),
                'bottom_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'bottom' => array(
                    'type' => 'textarea',
                    'label' => __( '内容区（下）：' ),
                    'desc' => __( '推荐尺寸 840*120（有侧栏）1160*120（无侧栏）' ),
                    'wrap' => true
                ),
                'nav_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'nav' => array(
                    'type' => 'textarea',
                    'label' => __( '上下文（下）：' ),
                    'desc' => __( '推荐尺寸 840*120（有侧栏）1160*120（无侧栏）' ),
                    'wrap' => true
                ),
                'comment_top_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'comment_top' => array(
                    'type' => 'textarea',
                    'label' => __( '评论列表（上）：' ),
                    'desc' => __( '推荐尺寸 840*120（有侧栏）1160*120（无侧栏）' ),
                    'wrap' => true
                ),
                'comment_bottom_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'comment_bottom' => array(
                    'type' => 'textarea',
                    'label' => __( '评论列表（下）：' ),
                    'desc' => __( '推荐尺寸 840*120（有侧栏）1160*120（无侧栏）' ),
                    'wrap' => true
                ),
                'submit_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'submit' => array(
                    'type' => 'textarea',
                    'label' => __( '发表评论（下）：' ),
                    'desc' => __( '推荐尺寸 840*120（有侧栏）1160*120（无侧栏）' ),
                    'wrap' => true
                ),
            )
        ),
        'ad_widget' => array(
            'type' => 'checkbox',
            'label' => __( '侧栏广告位' ),
            'subitem' => array(
                'large_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'large' => array(
                    'type' => 'textarea',
                    'label' => __( '广告位（大）：' ),
                    'desc' => __( '推荐尺寸 270*270' ),
                    'wrap' => true
                ),
                'middle_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'middle' => array(
                    'type' => 'textarea',
                    'label' => __( '广告位（中）' ),
                    'desc' => __( '推荐尺寸 270*180' ),
                    'wrap' => true
                ),
                'small_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'small' => array(
                    'type' => 'textarea',
                    'label' => __( '广告位（小）' ),
                    'desc' => __( '推荐尺寸 270*120' ),
                    'wrap' => true
                ),
                'grid_on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用广告位（多格）' )
                ),
            )
        ),
        'ad_widget_grid' => array(
            'type' => 'checkbox',
            'label' => __( '侧栏广告位（多格）' ),
            'subitem' => array(
                'on' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用' )
                ),
                'n' => array(
                    'type' => 'textarea',
                    'label' => __( '格子$$：' ),
                    'desc' => __( '推荐尺寸 125*125' ),
                    'wrap' => true
                )
            ),
            'loop' => '8',
        ),
    );
    $opts_slider = array(
        'slider_header' => array(
            'type' => 'checkbox',
            'label' => __( '参数设置（页头）' ),
            'subitem' => array(
                'in_singular' => array(
                    'type' => 'checkbox',
                    'label' => __( '同时显示在内页' ),
                    'wrap' => true
                ),
                'auto' => array(
                    'type' => 'checkbox',
                    'label' => __( '自动播放' ),
                ),
                'loop' => array(
                    'type' => 'checkbox',
                    'label' => __( '循环播放' ),
                ),
                'rand' => array(
                    'type' => 'checkbox',
                    'label' => __( '随机播放' ),
                ),
                'mouse' => array(
                    'type' => 'checkbox',
                    'label' => __( '滚轮控制' )
                ),
                'keyboard' => array(
                    'type' => 'checkbox',
                    'label' => __( '键盘控制' )
                ),
                'slide' => array(
                    'type' => 'checkbox',
                    'label' => __( '滑动效果' )
                ),
                'vertical' => array(
                    'type' => 'checkbox',
                    'label' => __( '垂直滚动' ),
                    'wrap' => true
                ),
                'speed_a' => array(
                    'type' => 'number',
                    'label' => __( '动画滚动速度（毫秒）：' )
                ),
                'speed_s' => array(
                    'type' => 'number',
                    'label' => __( '滚动间隔时间（毫秒）：' ),
                )
            ),
            'desc' => __( '启用焦点图' )
        ),
        'slider_header_img' => array(
            'type' => 'checkbox',
            'label' => __( '图片设置（页头）' ),
            'subitem' => array(
                'alt' => array(
                    'type' => 'text',
                    'label' => __( '图片文本$$：' )
                ),
                'src' => array(
                    'type' => 'upload',
                    'label' => __( '图片地址$$：' )
                ),
                'href' => array(
                    'type' => 'link',
                    'label' => __( '图片链接$$：' ),
                    'wrap' => true
                ),
            ),
            'loop' => '8'
        ),
        'slider_widget' => array(
            'type' => 'checkbox',
            'label' => __( '参数设置（侧栏）' ),
            'subitem' => array(
                'auto' => array(
                    'type' => 'checkbox',
                    'label' => __( '自动播放' ),
                ),
                'loop' => array(
                    'type' => 'checkbox',
                    'label' => __( '循环播放' ),
                ),
                'rand' => array(
                    'type' => 'checkbox',
                    'label' => __( '随机播放' ),
                ),
                'mouse' => array(
                    'type' => 'checkbox',
                    'label' => __( '滚轮控制' )
                ),
                'keyboard' => array(
                    'type' => 'checkbox',
                    'label' => __( '键盘控制' )
                ),
                'slide' => array(
                    'type' => 'checkbox',
                    'label' => __( '滑动效果' )
                ),
                'vertical' => array(
                    'type' => 'checkbox',
                    'label' => __( '垂直滚动' ),
                    'wrap' => true
                ),
                'speed_a' => array(
                    'type' => 'number',
                    'label' => __( '动画滚动速度（毫秒）：' )
                ),
                'speed_s' => array(
                    'type' => 'number',
                    'label' => __( '滚动间隔时间（毫秒）：' ),
                )
            ),
            'desc' => __( '启用焦点图' )
        ),
        'slider_widget_img' => array(
            'type' => 'checkbox',
            'label' => __( '图片设置（侧栏）' ),
            'subitem' => array(
                'alt' => array(
                    'type' => 'text',
                    'label' => __( '图片文本$$：' )
                ),
                'src' => array(
                    'type' => 'upload',
                    'label' => __( '图片地址$$：' )
                ),
                'href' => array(
                    'type' => 'link',
                    'label' => __( '图片链接$$：' ),
                    'wrap' => true
                ),
            ),
            'loop' => '5',
        )
    );
    $opts_advanced = array(
        'jquery_src' => array(
            'type' => 'radio',
            'label' => __( 'jQuery 库' ),
            'subitem' => array(
                'in_footer' => array(
                    'type' => 'checkbox',
                    'label' => __( '加载在页脚（放在页脚可提高载入速度，如果需要执行页内 jQuery 代码，请取消勾选）' ),
                    'wrap' => true
                ),
                'self' => array(
                    'type' => 'radio',
                    'label' => __( 'WordPress 默认' )
                ),
                'theme' => array(
                    'type' => 'radio',
                    'label' => __( '主题自带' )
                ),
                'google' => array(
                    'type' => 'radio',
                    'label' => __( '谷歌' )
                ),
                'microsoft' => array(
                    'type' => 'radio',
                    'label' => __( '微软' ),
                ),
                'bootcdn' => array(
                    'type' => 'radio',
                    'label' => __( 'BootCDN' ),
                ),
                'cdnjs' => array(
                    'type' => 'radio',
                    'label' => __( 'CdnJS' ),
                ),
                'jquery' => array(
                    'type' => 'radio',
                    'label' => __( 'jQuery' )
                ),
                'jsdelivr' => array(
                    'type' => 'radio',
                    'label' => __( 'JSDelivr' )
                ),
                'custom' => array(
                    'type' => 'radio',
                    'label' => __( '自定义' ),
                    'wrap' => true
                ),
                'custom_src' => array(
                    'type' => 'text',
                    'label' => __( '自定义地址：' )
                )
            )
        ),
        'jquery_plugs' => array(
            'type' => 'checkbox',
            'label' => __( 'jQuery 插件' ),
            'subitem' => array(
                'migrate' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用迁移辅助插件（jQuery Migrate）' )
                )
            )
        ),
        'ajax' => array(
            'type' => 'checkbox',
            'label' => __( 'AJAX' ),
            'subitem' => array(
                'search' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用 AJAX 搜索' ),
                    'desc' => __( '异步请求并显示相关搜索结果' )
                ),
                'search_number' => array(
                    'type' => 'number',
                    'label' => __( '最多显示条数：' ),
                    'wrap' => true
                ),
                'search_load' => array(
                    'type' => 'text',
                    'label' => __( '搜索中提示文字：' ),
                ),
                'search_null' => array(
                    'type' => 'text',
                    'label' => __( '未找到提示文字：' ),
                    'wrap' => true
                ),
                'comment' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用 AJAX 评论' ),
                    'desc' => __( '对评论使用 AJAX 提交' ),
                    'wrap' => true
                ),
                'comment_load' => array(
                    'type' => 'text',
                    'label' => __( '提交中提示文字：' ),
                ),
                'comment_empty' => array(
                    'type' => 'text',
                    'label' => __( '空内容提示文字：' ),
                    'wrap' => true
                )
            )
        ),
        'pjax' => array(
            'type' => 'radio',
            'label' => __( 'PJAX' ),
            'subitem' => array(
                'page_post' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用 PJAX 文章列表翻页' )
                ),
                'page_comment' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用 PJAX 评论列表翻页' ),
                )
            )
        ),
        'emoji_url' => array(
            'type' => 'radio',
            'label' => __( 'Emoji 表情地址' ),
            'subitem' => array(
                'self' => array(
                    'type' => 'radio',
                    'label' => __( 'WordPress 方案地址' ),
                ),
                'custom' => array(
                    'type' => 'radio',
                    'label' => __( '自定义' ),
                    'wrap' => true
                ),
                'custom_src' => array(
                    'type' => 'text',
                    'label' => __( '自定义地址：' ),
                    'desc' => __( '例如：<code>http://twemoji.maxcdn.com/72x72/</code>，表情可到<code>https://github.com/twitter/twemoji</code> 下载' )
                )
            )
        ),
        'all_https' => array(
            'type' => 'checkbox',
            'label' => __( '全站 HTTPS' ),
            'desc' => __( '启用全站 HTTPS（需要域名启用 HTTPS ）' )
        ),
        'link_manager' => array(
            'type' => 'checkbox',
            'label' => __( '友情链接' ),
            'desc' => __( '启用友情链接' )
        ),
        'wp_generator' => array(
            'type' => 'checkbox',
            'label' => __( 'Generator 信息' ),
            'desc' => __( '去掉所有 Generator 信息' )
        ),
        'time_ago' => array(
            'type' => 'checkbox',
            'label' => __( '个性化时间' ),
            'desc' => __( '个性化显示发布时间' ),
            'subitem' => array(
                'day' => array(
                    'type' => 'number',
                    'label' => __( '有效天数：' ),
                ),
            )
        ),
        'sanitize_file' => array(
            'type' => 'checkbox',
            'label' => __( '自动时间戳重命名' ),
            'desc' => __( '对新上传文件使用时间戳重命名' )
        ),
        'auto_translate' => array(
            'type' => 'checkbox',
            'label' => __( '自动生成英文别名' ),
            'subitem' => array(
                'baidu' => array(
                    'type' => 'radio',
                    'label' => __( '使用百度翻译' ),
                    'parent' => 'type'
                ),
                'google' => array(
                    'type' => 'radio',
                    'label' => __( '使用谷歌翻译' ),
                    'parent' => 'type'
                ),
                'microsoft' => array(
                    'type' => 'radio',
                    'label' => __( '使用必应翻译' ),
                    'parent' => 'type'
                ),
                'mymemory' => array(
                    'type' => 'radio',
                    'label' => __( '使用 MyMemory 翻译' ),
                    'parent' => 'type'
                ),
                'youdao' => array(
                    'type' => 'radio',
                    'label' => __( '使用有道翻译' ),
                    'parent' => 'type'
                ),
                'pinyin' => array(
                    'type' => 'radio',
                    'label' => __( '转换为拼音' ),
                    'parent' => 'type'
                ),
                'key_baidu' => array(
                    'type' => 'text',
                    'label' => __( '百度 APIKey：' )
                ),
                'key_google' => array(
                    'type' => 'text',
                    'label' => __( '谷歌 APIKey：' )
                ),
                'key_bing' => array(
                    'type' => 'text',
                    'label' => __( '必应 AppId：' )
                ),
                'key_mymemory' => array(
                    'type' => 'text',
                    'label' => __( 'MyMemory 邮箱：' )
                ),
                'key_youdao' => array(
                    'type' => 'text',
                    'label' => __( '有道 Key：' )
                ),
            ),
            'desc' => __( '启用' )
        ),
        'login_security' => array(
            'type' => 'checkbox',
            'label' => __( '安全登录' ),
            'subitem' => array(
                'mail_success' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用登录成功邮件提醒' )
                ),
                'mail_success_user' => array(
                    'type' => 'checkbox',
                    'label' => __( '发送给对应用户' )
                ),
                'mail_success_admin' => array(
                    'type' => 'checkbox',
                    'label' => __( '发送给管理员' ),
                    'wrap' => true
                ),
                'mail_fail' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用登录失败邮件提醒' ),
                ),
                'mail_fail_user' => array(
                    'type' => 'checkbox',
                    'label' => __( '发送给对应用户' )
                ),
                'mail_fail_admin' => array(
                    'type' => 'checkbox',
                    'label' => __( '发送给管理员' ),
                    'wrap' => true
                ),
                'args' => array(
                    'type' => 'checkbox',
                    'label' => __( '启用自定义登录字段' ),
                ),
                'args_list' => array(
                    'type' => 'textarea',
                    'label' => __( '自定义登录字段：' ),
                    'desc' => __( '输入字段名和字段值，使用 <code>=</code> 分开，每行一条，不要重复（会被自动过滤），例如：<code>口令=adc123</code>' )
                ),
            )
        ),
        'cdn' => array(
            'type' => 'checkbox',
            'label' => __( 'CDN 地址' ),
            'subitem' => array(
                'admin' => array(
                    'type' => 'checkbox',
                    'label' => '管理后台启用下列 CDN',
                    'wrap' => true
                ),
                'static_on' => array(
                    'type' => 'checkbox',
                    'label' => '启用静态资源 CDN',
                ),
                'static_url' => array(
                    'type' => 'text',
                    'label' => '静态资源 CDN 地址：',
                    'desc'=> __( '此地址用于主题的 static 目录，默认：<code>' . get_stylesheet_directory_uri() . '/static' . '</code>' ),
                    'wrap' => true
                ),
                'upload_on' => array(
                    'type' => 'checkbox',
                    'label' => '启用上传目录 CDN',
                ),
                'upload_url' => array(
                    'type' => 'text',
                    'label' => '上传目录 CDN 地址：',
                    'desc'=> __( '此地址用于 WordPress 的上传目录，默认：<code>' . $upload_dir['baseurl'] . '</code>' ),
                    'wrap' => true
                ),
                'include_on' => array(
                    'type' => 'checkbox',
                    'label' => '启用核心目录 CDN',
                ),
                'include_url' => array(
                    'type' => 'text',
                    'label' => '核心目录 CDN 地址：',
                    'desc'=> __( '此地址用于 WordPress 的上传目录，默认：<code>' . includes_url() . '</code>' ),
                    'wrap' => true
                ),
                'plugin_on' => array(
                    'type' => 'checkbox',
                    'label' => '启用插件目录 CDN',
                ),
                'plugin_url' => array(
                    'type' => 'text',
                    'label' => '插件目录 CDN 地址：',
                    'desc'=> __( '此地址用于 WordPress 的上传目录，默认：<code>' . plugins_url() . '</code>' ),
                    'wrap' => true
                ),
                'ext' => array(
                    'type' => 'textarea',
                    'label' => 'CDN 文件后缀',
                    'desc'=> __( '输入需要使用 CDN 的文件后缀，多个用 <code>|</code> 隔开，例如：<code>png|jpg|jpeg|bmp|gif|zip|rar|mp3|mp4|m4a|wav|ogg|css|js</code>' ),
                ),
            )
        ),
        'gravatar_proxy' => array(
            'type' => 'checkbox',
            'label' => __( 'Gravatar 代理' ),
            'subitem' => array(
                'url' => array(
                    'type' => 'text',
                    'label' => '代理地址：',
                    'desc'=> __( '填入自定义的 Gravatar 代理地址，解决被墙问题，例如：<code>gravatar.moefont.com/avatar</code>' ),
                )
            ),
            'desc' => __( '启用' )
        ),
        'google_ajax_proxy' => array(
            'type' => 'checkbox',
            'label' => __( 'Google Ajax 代理' ),
            'subitem' => array(
                'url' => array(
                    'type' => 'text',
                    'label' => '代理地址：',
                    'desc'=> __( '填入自定义的 Google Ajax 代理地址，解决被墙问题，例如：<code>cdn.moefont.com/ajax</code>' ),
                )
            ),
            'desc' => __( '启用' )
        ),
        'google_fonts_proxy' => array(
            'type' => 'checkbox',
            'label' => __( 'Google Fonts 代理' ),
            'subitem' => array(
                'url' => array(
                    'type' => 'text',
                    'label' => '代理地址：',
                    'desc'=> __( '填入自定义的 Google Fonts 代理地址，解决被墙问题，例如：<code>cdn.moefont.com/fonts</code>' ),
                )
            ),
            'desc' => __( '启用' )
        ),
    );
    $opts_backup_restore = array(
        'backup' => array(
            'type' => 'checkbox',
            'label' => __( '备份' ),
            'subitem' => array(
                'data' => array(
                    'type' => 'textarea',
                    'label' => '文本数据',
                    'desc'=> __( '这里是加密后的备份数据，您可以拷贝到其他地方' ),
                ),
                'export' => array(
                    'type' => 'button',
                    'label' => '导出数据'
                )
            )
        ),
        'restore' => array(
            'type' => 'checkbox',
            'label' => __( '恢复' ),
            'subitem' => array(
                'data' => array(
                    'type' => 'textarea',
                    'label' => '文本数据',
                    'desc'=> __( '在这里粘贴您的备份数据，然后选择导入数据即可' ),
                ),
                'import' => array(
                    'type' => 'button',
                    'label' => '导入数据'
                )
            )
        ),
    );
    $bymt_opts = array(
        'basic' => array( __( '基本设置' ), $opts_basic),
        'post' => array( __( '文章设置' ), $opts_post),
        'comment' => array( __( '评论设置' ), $opts_comment),
        'advert' => array( __( '广告设置' ), $opts_advert),
        'slider' => array( __( '焦点图设置' ), $opts_slider),
        'advanced' => array( __( '高级设置' ), $opts_advanced),
        'backup_restore' => array( __( '备份/恢复' ), $opts_backup_restore)
    );
    $nav_tabs = '<li class="version">BYMT ' . BYMT_VER . '</li>';
    foreach ($bymt_opts as $key => $val) {
        $is_active = ($key === 'basic') ? 'class="current"' : '';
        $nav_tabs .= "<li><a {$is_active} title=\"{$val[0]}\" href=\"#option-{$key}\">{$val[0]}</a></li>";
    }
    $opt_html = '';
    foreach ($bymt_opts as $key => $opts) {
        $is_active = ($key === 'basic') ? 'active' : '';
        $opt_html .= "<table id=\"option-{$key}\" class=\"form-table postbox {$is_active}\"><tbody>";
        foreach ($opts[1] as $name => $opt) {
            if ( empty( $opt ) ) continue;
            $id = str_replace('_', '-', $name);
            $opt_html .= "<tr>";
            if ( $opt['type'] === 'radio' || $opt['type'] === 'checkbox' ) {
                $opt_html .= "<th scope=\"row\">{$opt['label']}</th>";
            } else {
                $opt_html .= "<th scope=\"row\"><label for=\"{$id}\">{$opt['label']}</label></th>";
            }
            $opt_html .= "<td>";
            if ( isset($opt['loop']) && $opt['loop'] && !empty( $opt['subitem'] ) ) {
                $new_subitem = array();
                for ($i=1; $i <= $opt['loop']; $i++) {
                    foreach ($opt['subitem'] as $l_key => $l_val) {
                        $l_val['label'] = str_replace( "$$", "（{$i}）", $l_val['label'] );
                        $new_subitem[$l_key.'_'.$i] = $l_val;
                    }
                }
                $opt['subitem'] = $new_subitem;
            }
            switch ( $opt['type'] ) {
                case 'select':
                    $opt_html .= bymt_opt_input( 'select', $name, $opt['option'], bymt_option( $name ) );
                    break;
                case 'textarea':
                    $opt_html .= bymt_opt_input( 'textarea', $name, bymt_option( $name ) );
                    $opt_html .= "<p class=\"description\" id=\"{$id}-description\">{$opt['desc']}</p>";
                    break;
                case 'radio':
                    $opt_html .= "<fieldset>";
                    $opt_html .= "<legend class=\"screen-reader-text\"><span>{$opt['label']}</span></legend>";
                    if ( !empty( $opt['subitem'] ) ) {
                        foreach ($opt['subitem'] as $sub_name => $sub_val) {
                            $_sub_name = $name . '_' . $sub_name;
                            $_sub_id = str_replace('_', '-', $_sub_name);
                            switch ($sub_val['type']) {
                                case 'radio':
                                    $opt_html .= "<label>" . bymt_opt_input( 'radio', $name, $sub_name, bymt_option( $name ) ) . "{$sub_val['label']}</label>";
                                    break;
                                case 'checkbox':
                                    $opt_html .= "<label for=\"{$_sub_id}\">" . bymt_opt_input( 'checkbox', $_sub_name, bymt_option( $_sub_name ), 'on' ) . "{$sub_val['label']}</label>";
                                    break;
                                case 'text':
                                    $opt_html .= "<p><label for=\"{$_sub_id}\">{$sub_val['label']}</label>" . bymt_opt_input( 'text', $_sub_name, bymt_option( $_sub_name ) ) . "</p>";
                                    if ( !empty( $sub_val['desc'] ) ) {
                                        $opt_html .= "<p class=\"description\" id=\"{$_sub_id}-description\">{$sub_val['desc']}</p>";
                                    }
                                    break;
                                case 'number':
                                    $opt_html .= "<label for=\"{$_sub_id}\">{$sub_val['label']}" . bymt_opt_input( 'number', $_sub_name, bymt_option( $_sub_name ) ) . "</label>";
                                    break;
                            }
                            if ( isset($sub_val['wrap']) && $sub_val['wrap'] ) $opt_html .= "<br>";
                        }
                    } else {
                        $opt_html .= "<label>" . bymt_opt_input( 'radio', $name, $name, bymt_option( $name ) ) . "{$opt['label']}</label>";
                    }
                    $opt_html .= "</fieldset>";
                    break;
                case 'checkbox':
                    $opt_html .= "<fieldset>";
                    $opt_html .= "<legend class=\"screen-reader-text\"><span>{$opt['label']}</span></legend>";
                    if ( !empty( $opt['desc'] ) ) {
                        $opt_html .= "<label for=\"{$id}\">";
                        $opt_html .= bymt_opt_input( 'checkbox', $name, bymt_option( $name ), 'on' );
                        $opt_html .= "<span class=\"description\">{$opt['desc']}</span></label>";
                        if ( isset($opt['wrap']) && $opt['wrap'] ) $opt_html .= "<br>";
                    }
                    if ( !empty( $opt['subitem'] ) ) {
                        foreach ($opt['subitem'] as $sub_name => $sub_val) {
                            $_sub_name = $sub_name;
                            $sub_name = $name . '_' . $_sub_name;
                            $sub_id = str_replace('_', '-', $sub_name);
                            switch ($sub_val['type']) {
                                case 'text':
                                    $opt_html .= "<p><label for=\"{$sub_id}\">{$sub_val['label']}</label>" . bymt_opt_input( 'text', $sub_name, bymt_option( $sub_name ) ) . "</p>";
                                    if ( !empty( $sub_val['desc'] ) ) {
                                        $opt_html .= "<p id=\"{$sub_id}-description\" class=\"description\">{$sub_val['desc']}</p>";
                                    }
                                    break;
                                case 'textarea':
                                    if ( !empty( $opt['desc'] ) ) {
                                        $opt_html .= "<br>";
                                    }
                                    $opt_html .= "<label for=\"{$sub_id}\">{$sub_val['label']}</label><br>" . bymt_opt_input( 'textarea', $sub_name, bymt_option( $sub_name ) );
                                    if ( !empty( $sub_val['desc'] ) ) {
                                        $opt_html .= "<p id=\"{$sub_id}-description\" class=\"description\">{$sub_val['desc']}</p>";
                                    }
                                    break;
                                case 'number':
                                    $opt_html .= "<label for=\"{$sub_id}\">{$sub_val['label']}" . bymt_opt_input( 'number', $sub_name, bymt_option( $sub_name ) ) . "</label>";
                                    break;
                                case 'checkbox':
                                    $opt_html .= "<label for=\"{$sub_id}\">" . bymt_opt_input( 'checkbox', $sub_name, bymt_option( $sub_name ), 'on' ) . "{$sub_val['label']}</label>";
                                    break;
                                case 'radio':
                                    $parent_name = $name . '_' . $sub_val['parent'];
                                    $opt_html .= "<label>" . bymt_opt_input( 'radio', $parent_name, $_sub_name, bymt_option( $parent_name ) ) . "{$sub_val['label']}</label>";
                                    break;
                                case 'upload':
                                    $opt_html .= "<p><label for=\"{$sub_id}\">{$sub_val['label']}</label>" . bymt_opt_input( 'upload', $sub_name, bymt_option( $sub_name ) ) . "</p>";
                                    if ( !empty( $sub_val['desc'] ) ) {
                                        $opt_html .= "<p class=\"description\" id=\"{$sub_id}-description\">{$sub_val['desc']}</p>";
                                    }
                                    break;
                                case 'button':
                                    $opt_html .= "<p><input id=\"button-{$sub_id}\" class=\"button tb-button\" type=\"button\" value=\"{$sub_val['label']}\"/></p>";
                                    if ( !empty( $sub_val['desc'] ) ) {
                                        $opt_html .= "<p class=\"description\" id=\"{$sub_id}-description\">{$sub_val['desc']}</p>";
                                    }
                                    break;
                                case 'link':
                                    $opt_html .= "<p><label for=\"{$sub_id}\">{$sub_val['label']}</label>" . bymt_opt_input( 'link', $sub_name, bymt_option( $sub_name ) ) . "</p>";
                                    if ( !empty( $sub_val['desc'] ) ) {
                                        $opt_html .= "<p class=\"description\" id=\"{$sub_id}-description\">{$sub_val['desc']}</p>";
                                    }
                                    break;
                            }
                            if ( isset($sub_val['wrap']) && $sub_val['wrap'] ) $opt_html .= "<br>";
                        }
                    }
                    $opt_html .= "</fieldset>";
                    break;
                case 'number':
                    $opt_html .= "<fieldset>";
                    $opt_html .= "<legend class=\"screen-reader-text\"><span>{$opt['label']}</span></legend>";
                    if ( !empty( $opt['subitem'] ) ) {
                        foreach ($opt['subitem'] as $sub_name => $sub_val) {
                            $sub_name = $name . '_' . $sub_name;
                            $sub_id = str_replace('_', '-', $name);
                            $opt_html .= "<label for=\"{$sub_id}\">{$sub_val['label']}</label>";
                            $opt_html .= bymt_opt_input( 'number', $sub_name, bymt_option( $sub_name ) );
                        }
                    } else {
                        $opt_html .= "<label>" . sprintf($opt['desc'], bymt_opt_input('number', $name, bymt_option($name) ) ) . "</label>";
                    }
                    $opt_html .= "</fieldset>";
                    break;
                case 'upload':
                    $opt_html .= bymt_opt_input( 'upload', $name, bymt_option( $name ) );
                    if ( !empty( $opt['desc'] ) ) {
                        $opt_html .= "<p class=\"description\" id=\"{$id}-description\">{$opt['desc']}</p>";
                    }
                    break;
                case 'text':
                default:
                    $opt_html .= bymt_opt_input( 'text', $name, bymt_option( $name ) );
                    if ( !empty( $opt['desc'] ) ) {
                        $opt_html .= "<p class=\"description\" id=\"{$id}-description\">{$opt['desc']}</p>";
                    }
                    break;
            }
            $opt_html .= "</td>";
            $opt_html .= "</tr>";
        }
        $opt_html .= "</tbody></table>";
    }
?>
    <div id="bymt-setting-wrap" class="wrap">
        <h2><?php echo esc_html( $nav_title ); ?></h2>
        <ul class="subsubsub">
            <li>主题名称：<a href="https://maicong.me/bymt/v3?version" target="_blank">BYMT <?php echo BYMT_VER; ?></a> | </li>
            <li>当前版本：<a href="https://maicong.me/bymt/v3?release" target="_blank"><?php echo BYMT_AUTHORIZE; ?></a> | </li>
            <li>最后更新：<a href="https://maicong.me/bymt/v3?update" target="_blank"><?php echo BYMT_UPDATE; ?></a> |</li>
            <li>作者网站：<a href="https://maicong.me" target="_blank">MaiCong</a></li>
        </ul>
        <div id="menu-clear" class="clear"></div>
        <?php settings_errors(); ?>
        <div id="setting-menu" class="wp-filter"><ul class="filter-links"><?php echo $nav_tabs; ?></ul></div>
        <div id="setting-main" class="metabox-holder">
            <form method="post" action="options.php">
                <?php settings_fields( 'bymt_options_group_v3' ); ?>
                <?php echo $opt_html; ?>
                <div class="submit">
                    <?php $confirm = __( '警告！操作不可逆，建议先对数据进行备份操作。\n\n您确定要恢复默认吗？' ); ?>
                    <?php submit_button( __( '保存更改' ), 'primary', 'save', false ); ?>
                    <div class="clear"></div>
                </div>
            </form>
            <form method="post" class="resetform">
                <?php submit_button( __( '恢复默认' ), 'secondary', 'reset', false, array('onclick'=>'return confirm(\'' . $confirm . '\')') ); ?>
            </form>
        </div>
    </div>
<?php
    require(ABSPATH . WPINC . '/class-wp-editor.php');
    $link = _WP_Editors::wp_link_dialog();
    echo $link;
}

// BYMT 帮助
function bymt_help_page() {
?>
    <div id="bymt-help-wrap" class="wrap">
        <h2>BYMT 使用帮助</h2>
        <ul class="subsubsub">
            <li>主题名称：<a href="https://maicong.me/bymt/v3?version" target="_blank">BYMT <?php echo BYMT_VER; ?></a> | </li>
            <li>当前版本：<a href="https://maicong.me/bymt/v3?release" target="_blank"><?php echo BYMT_AUTHORIZE; ?></a> | </li>
            <li>最后更新：<a href="https://maicong.me/bymt/v3?update" target="_blank"><?php echo BYMT_UPDATE; ?></a> |</li>
            <li>作者网站：<a href="https://maicong.me" target="_blank">MaiCong</a></li>
        </ul>
        <div id="menu-clear" class="clear"></div>
        <div id="help-main" class="metabox-holder">
            <p class="popular-tags">注意！使用前请检查您的主题授权是否合法，非麦葱直接授权的一律按盗版处理，严重者将取消您的购买权益和售后。如果您使用的是未授权版本，请联系 麦葱 (i@maicong.me) 购买正版！</p>
            <p class="popular-tags">查看帮助文档请前往：<a href="https://maicong.me/bymt/v3?token=<?php echo bymt_base64(BYMT_VER . '|' . BYMT_UPDATE . '|' . BYMT_AUTHORIZE . '|' . home_url( '/' )); ?>" target="_blank">https://maicong.me/bymt/v3</a></p>
        </div>
    </div>
<?php
}
