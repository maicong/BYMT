<?php !defined( 'WPINC' ) && exit();
/**
 * bymtWidgets.php
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

// 小工具 - 新热随选项卡
class BYMT_Widget_Tabs extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_tabs', 'description' => __( "主题侧栏工具: 最热文章、最新文章、随机文章") );
        parent::__construct('widget-bymt-tabs', __('BYMT - 选项卡'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_tabs';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    public function widget( $args, $instance ) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'widget_bymt_tabs', 'widget' );
        }
        if ( ! is_array( $cache ) ) {
            $cache = array();
        }
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }
        ob_start();
        $popular_title = apply_filters( 'widget_title', empty( $instance['popular_title'] ) ? __( '最热' ) : $instance['popular_title'], $instance, $this->id_base );
        $recent_title = apply_filters( 'widget_title', empty( $instance['recent_title'] ) ? __( '最新' ) : $instance['recent_title'], $instance, $this->id_base );
        $random_title = apply_filters( 'widget_title', empty( $instance['random_title'] ) ? __( '随机' ) : $instance['random_title'], $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number ) $number = 5;
        $pop_days = ( ! empty( $instance['pop_days'] ) ) ? absint( $instance['pop_days'] ) : 30;
        if ( ! $pop_days ) $pop_days = 30;
        $ran_days = ( ! empty( $instance['ran_days'] ) ) ? absint( $instance['ran_days'] ) : 30;
        if ( ! $ran_days ) $ran_days = 30;
        $show_image = isset( $instance['show_image'] ) ? $instance['show_image'] : false;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
?>
        <div id="widget-bymt-tabs" class="widget widget_bymt_tabs">
            <ul id="widget-bymt-tab-nav" class="tabs-nav clearfix">
                <li class="active"><a href="###"><?php _e($popular_title); ?></a></li>
                <li><a href="###"><?php _e($recent_title); ?></a></li>
                <li><a href="###"><?php _e($random_title); ?></a></li>
            </ul>
            <div class="tabs-container">
                <div class="tab-content">
                    <ul class="tab-list">
                        <?php
                            $r_popular = new WP_Query( apply_filters( 'widget_posts_args', array(
                                'date_query' => array(
                                    'after' => array(
                                        'year'  => date('Y', strtotime( '-' . $pop_days . 'day' )),
                                        'month'  => date('m', strtotime( '-' . $pop_days . 'day' )),
                                        'day'  => date('d', strtotime( '-' . $pop_days . 'day' ))
                                    ),
                                    'before' => array(
                                        'year'  => date('Y', time()),
                                        'month'  => date('m', time()),
                                        'day'  => date('d', time())
                                    )
                                ),
                                'posts_per_page'      => $number,
                                'post_status'         => 'publish',
                                'orderby'             => 'comment_count',
                                'order'               => 'DESC',
                                'no_found_rows'       => true,
                                'ignore_sticky_posts' => true
                            ) ) );
                            if ($r_popular->have_posts()) : while ( $r_popular->have_posts() ) : $r_popular->the_post();
                        ?>
                        <li class="clearfix">
                        <?php if ( $show_image && bymt_thumbnail( 80, 60, false, true ) ) : ?>
                            <div class="pic"><a href="<?php the_permalink(); ?>"><?php echo bymt_thumbnail( 80, 60, true, true, 0, false ); ?></a></div>
                        <?php endif; ?>
                            <div class="content">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" itemprop="name"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                            <?php if ( $show_date ) : ?>
                                <span class="date" itemprop="datePublished"><?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                            </div>
                        </li>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </ul>
                </div>
                <div class="tab-content" style="display: none;">
                    <ul class="tab-list">
                        <?php
                            $r_recent = new WP_Query( apply_filters( 'widget_posts_args', array(
                                'posts_per_page'      => $number,
                                'post_status'         => 'publish',
                                'no_found_rows'       => true,
                                'ignore_sticky_posts' => true
                            ) ) );
                            if ($r_recent->have_posts()) : while ( $r_recent->have_posts() ) : $r_recent->the_post();
                        ?>
                        <li class="clearfix">
                        <?php if ( $show_image && bymt_thumbnail( 80, 60, false, true ) ) : ?>
                            <div class="pic"><a href="<?php the_permalink(); ?>"><?php echo bymt_thumbnail( 80, 60, true, true, 0, false ); ?></a></div>
                        <?php endif; ?>
                            <div class="content">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" itemprop="name"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                            <?php if ( $show_date ) : ?>
                                <span class="date" itemprop="datePublished"><?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                            </div>
                        </li>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </ul>
                </div>
                <div class="tab-content" style="display: none;">
                    <ul class="tab-list">
                        <?php
                            $r_random = new WP_Query( apply_filters( 'widget_posts_args', array(
                                'date_query' => array(
                                    'after' => array(
                                        'year'  => date('Y', strtotime( '-' . $ran_days . 'day' )),
                                        'month'  => date('m', strtotime( '-' . $ran_days . 'day' )),
                                        'day'  => date('d', strtotime( '-' . $ran_days . 'day' ))
                                    ),
                                    'before' => array(
                                        'year'  => date('Y', time()),
                                        'month'  => date('m', time()),
                                        'day'  => date('d', time())
                                    )
                                ),
                                'posts_per_page'      => $number,
                                'post_status'         => 'publish',
                                'orderby'             => 'rand',
                                'no_found_rows'       => true,
                                'ignore_sticky_posts' => true
                            ) ) );
                            if ($r_random->have_posts()) : while ( $r_random->have_posts() ) : $r_random->the_post();
                        ?>
                        <li class="clearfix">
                        <?php if ( $show_image && bymt_thumbnail( 80, 60, false, true ) ) : ?>
                            <div class="pic"><a href="<?php the_permalink(); ?>"><?php echo bymt_thumbnail( 80, 60, true, true, 0, false ); ?></a></div>
                        <?php endif; ?>
                            <div class="content">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" itemprop="name"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                            <?php if ( $show_date ) : ?>
                                <span class="date" itemprop="datePublished"><?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                            </div>
                        </li>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </ul>
                </div>
            </div>
        </div>
<?php
        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_bymt_tabs', $cache, 'widget' );
        } else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['popular_title'] = strip_tags($new_instance['popular_title']);
        $instance['recent_title'] = strip_tags($new_instance['recent_title']);
        $instance['random_title'] = strip_tags($new_instance['random_title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['pop_days'] = (int) $new_instance['pop_days'];
        $instance['ran_days'] = (int) $new_instance['ran_days'];
        $instance['show_image'] = isset( $new_instance['show_image'] ) ? (bool) $new_instance['show_image'] : false;
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $this->flush_widget_cache();
        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_bymt_tabs']) ) {
            delete_option('widget_bymt_tabs');
        }
        return $instance;
    }

    public function flush_widget_cache() {
        wp_cache_delete('widget_bymt_tabs', 'widget');
    }

    public function form( $instance ) {
        $popular_title    = isset( $instance['popular_title'] ) ? esc_attr( $instance['popular_title'] ) : __( '最热' );
        $recent_title     = isset( $instance['recent_title'] ) ? esc_attr( $instance['recent_title'] ) : __( '最新' );
        $random_title     = isset( $instance['random_title'] ) ? esc_attr( $instance['random_title'] ) : __( '随机' );
        $number  = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $pop_days    = isset( $instance['pop_days'] ) ? absint( $instance['pop_days'] ) : 30;
        $ran_days    = isset( $instance['ran_days'] ) ? absint( $instance['ran_days'] ) : 30;
        $show_image = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : false;
        $show_date  = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo $this->get_field_id( 'popular_title' ); ?>"><?php _e( '最热文章标题：' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'popular_title' ); ?>" name="<?php echo $this->get_field_name( 'popular_title' ); ?>" type="text" value="<?php echo $popular_title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id( 'recent_title' ); ?>"><?php _e( '最新文章标题：' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'recent_title' ); ?>" name="<?php echo $this->get_field_name( 'recent_title' ); ?>" type="text" value="<?php echo $recent_title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id( 'random_title' ); ?>"><?php _e( '随机文章标题：' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'random_title' ); ?>" name="<?php echo $this->get_field_name( 'random_title' ); ?>" type="text" value="<?php echo $random_title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
        <p><label for="<?php echo $this->get_field_id( 'pop_days' ); ?>"><?php _e( '最热文章索引天数：' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'pop_days' ); ?>" name="<?php echo $this->get_field_name( 'pop_days' ); ?>" type="text" value="<?php echo $pop_days; ?>" size="3" /></p>
        <p><label for="<?php echo $this->get_field_id( 'ran_days' ); ?>"><?php _e( '随机文章索引天数：' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'ran_days' ); ?>" name="<?php echo $this->get_field_name( 'ran_days' ); ?>" type="text" value="<?php echo $ran_days; ?>" size="3" /></p>
        <p><input class="checkbox" type="checkbox" <?php checked( $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( '显示缩略图？' ); ?></label></p>
        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( '显示发布日期？' ); ?></label></p>
<?php
    }
}

// 小工具 - 最新评论
class BYMT_Widget_RComments extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_rcomments', 'description' => __( "主题侧栏工具: 最新评论") );
        parent::__construct('widget-bymt-rcomments', __('BYMT - 最新评论'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_rcomments';

        add_action( 'comment_post', array($this, 'flush_widget_cache') );
        add_action( 'edit_comment', array($this, 'flush_widget_cache') );
        add_action( 'transition_comment_status', array($this, 'flush_widget_cache') );
    }

    public function flush_widget_cache() {
        wp_cache_delete('widget_bymt_rcomments', 'widget');
    }

    public function widget( $args, $instance ) {
        global $comments, $comment;
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get('widget_bymt_rcomments', 'widget');
        }
        if ( ! is_array( $cache ) ) {
            $cache = array();
        }
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }
        $output = '';
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '最新评论' ) : $instance['title'], $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number ) $number = 10;
        $comments = get_comments( apply_filters( 'widget_comments_args', array(
            'number'      => $number,
            'author__not_in' => array('1'),
            'status'      => 'approve',
            'post_status' => 'publish',
            'type' => 'comments'
        ) ) );
        $output .= $args['before_widget'];
        if ( $title ) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }
        $output .= '<ul class="rcomments-list">';
        if ( $comments ) {
            foreach ( (array) $comments as $comment) {
                $content = wp_trim_words( strip_shortcodes( $comment->comment_content ), 26 );
                $output .= '<li class="clearfix">';
                $output .= bymt_gravatar( $comment->comment_author_email, 24, 'avatar', false );
                $output .= '<span class="author" title="' . esc_attr( get_comment_author() ) . '">' . wp_trim_words( get_comment_author(), 10 ) . ': </span>';
                $output .= '<a class="link" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '" title="' . sprintf( __('查看 Ta 在《%1$s》上的评论'), $comment->post_title ) . '">' . $content . '</a>';
                $output .= '</li>';
            }
        }
        $output .= '</ul>';
        $output .= $args['after_widget'];

        echo $output;

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = $output;
            wp_cache_set( 'widget_bymt_rcomments', $cache, 'widget' );
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = absint( $new_instance['number'] );
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_bymt_rcomments']) )
            delete_option('widget_bymt_rcomments');

        return $instance;
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( '最新评论' );
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of comments to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
}

// 小工具 - 社交图标
class BYMT_Widget_Socials extends WP_Widget {

    protected $socials_array = array(
        'rss' => array( 'RSS', '#e57d22', '' ),
        'email' => array( 'Email', '#289dde', '' ),
        'qq' => array( 'QQ', '#4d8fd5', '' ),
        'weibo' => array( 'Weibo', '#d52b2a', '' ),
        'weixin' => array( 'Weixin', '#459904', '' ),
        'v2ex' => array( 'V2EX', '#232324', '' ),
        'zhihu' => array( 'Zhihu', '#0e7fda', '' ),
        'acfun' => array( 'Acfun', '#fea23d', '' ),
        'bilibili' => array( 'Bilibili', '#2cbdf0', '' ),
        'baidu' => array( 'Baidu', '#2625e5', '' ),
        'taobao' => array( 'Taobao', '#ff4800', '' ),
        'btc' => array( 'BTC', '#f1971d', '' ),
        'coding' => array( 'Coding', '#373737', '' ),
        'delicious' => array( 'Delicious', '#3399ff', '' ),
        'dribbble' => array( 'Dribbble', '#ea528c', '' ),
        'facebook' => array( 'Facebook', '#4463b1', '' ),
        'flickr' => array( 'Flickr', '#0769cc', '' ),
        'github' => array( 'Github', '#2d2d31', '' ),
        'gplus' => array( 'Google +', '#c03c32', '' ),
        'instagram' => array( 'Instagram', '#634d44', '' ),
        'linkedin' => array( 'Linkedin', '#1882bb', '' ),
        'pinterest' => array( 'Pinterest', '#bf2227', '' ),
        'skype' => array( 'Skype', '#00aff0', '' ),
        'stackoverflow' => array( 'Stackoverflow', '#f47920', '' ),
        'soundcloud' => array( 'Soundcloud', '#ff722d', '' ),
        'telegram' => array( 'Telegram', '#29a4d7', '' ),
        'tumblr' => array( 'Tumblr', '#3d5e7d', '' ),
        'twitter' => array( 'Twitter', '#00aeee', '' ),
        'vimeo' => array( 'Vimeo', '#5eb5e6', '' ),
        'youtube' => array( 'Youtube', '#d32322', '' )
    );

    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_socials', 'description' => __('主题侧栏工具: 社交账号'));
        parent::__construct('widget-bymt-socials', __('BYMT - 社交账号'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_socials';
    }

    public function widget( $args, $instance ) {
        if ( empty( $instance['socials_url'] ) || !is_array( $instance['socials_url'] ) ) {
            return;
        }
        $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        $socials_url = array();
        foreach ($instance['socials_url'] as $key => $val) {
            $val[2] = esc_url_raw( strip_tags( $val[2] ) );
            if ( !$val[2] ) continue;
            $socials_url[$key] = $val;
        }
        if ( empty( $socials_url) ) return;
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '关注我' ) : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $text ) ) {
            echo '<div class="textwidget">' . !empty( $instance['filter'] ) ? wpautop( $text ) : $text . '</div>';
        }
?>
            <ul id="widget-socials-list" class="socials-list clearfix">
            <?php
                foreach ($socials_url as $key => $social) {
                    echo '<li><a data-color="' . $social[1] . '" href="' . $social[2] . '" class="sc-' . $key . '" title="' . $social[0] . '" target="_blank"><i class="iconsocial social-' . $key . '"></i></a></li>';
                }
            ?>
            </ul>
<?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['filter'] = ! empty( $new_instance['filter'] );
        if ( current_user_can('unfiltered_html') ) {
            $instance['text'] =  $new_instance['text'];
        } else {
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
        }
        foreach ($this->socials_array as $key => $val) {
            $instance['socials_url'][$key][0] = strip_tags( $val[0] );
            $instance['socials_url'][$key][1] = strip_tags( $val[1] );
            $instance['socials_url'][$key][2] = esc_url( strip_tags( $new_instance[$key] ) );
        }
        return $instance;
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( '关注我' );
        $text = isset( $instance['text'] ) ? esc_textarea( $instance['text'] ) : '';
        if ( !isset( $instance['socials_url'] ) ) {
            $instance['socials_url'] = $this->socials_array;
        } else {
            $instance['socials_url'] = wp_parse_args( $instance['socials_url'], $this->socials_array );
        }
        $socials_url = $instance['socials_url'];
        if ( !isset( $socials_url['rss'][2] ) ) {
            $socials_url['rss'][2] = esc_url( get_feed_link() );
        }
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
        <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
<?php
        foreach ($socials_url as $key => $val) {
?>
        <p><label for="<?php echo $this->get_field_id($key); ?>"><?php _e( $val[0] . ':' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo esc_url( strip_tags( $val[2] ) ); ?>" /></p>
<?php
        }
    }
}

// 小工具 - 站点状态
class BYMT_Widget_SiteStatus extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_sitestatus', 'description' => __('主题侧栏工具: 站点状态'));
        parent::__construct('widget-bymt-sitestatus', __('BYMT - 站点状态'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_sitestatus';
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '站点状态' ) : $instance['title'], $instance, $this->id_base );
        $date = esc_html( strip_tags( empty( $instance['date'] ) ? date('Y-m-d', time() ) : $instance['date'] ) );
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
?>
        <ul class="sitestatus-list">
        <li>文章<span><?php echo wp_count_posts( 'post' )->publish; ?> 篇</span></li>
            <li>评论<span><?php echo wp_count_comments()->approved; ?> 条</span></li>
            <li>栏目<span><?php echo wp_count_terms( 'category' ); ?> 个</span></li>
            <li>页面<span><?php echo wp_count_posts( 'page' )->publish; ?> 个</span></li>
            <li>标签<span><?php echo wp_count_terms( 'post_tag' ); ?> 个</span></li>
            <li>存活<span><?php echo sprintf("%.1f", ( time() - strtotime( $date ) ) / 86400 ) ?> 天</span></li>
            <li>建站<span><?php echo $date; ?></span></li>
            <li>更新<span><?php echo mysql2date('Y-m-d', get_lastpostmodified('GMT')); ?></span></li>
        </ul>
<?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['date'] = strip_tags($new_instance['date']);
        return $instance;
    }

    public function form( $instance ) {
        $instance = wp_parse_args((array) $instance, array( 'title' => __( '站点状态' ), 'date' => date('Y-m-d', time() ) ) );
        $title = strip_tags($instance['title']);
        $date = strip_tags($instance['date']);
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php _e( 'Build date time:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="text" value="<?php echo $date; ?>" /></p>
<?php
    }
}

// 小工具 - 焦点图
class BYMT_Widget_Slider extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_slider', 'description' => __('主题侧栏工具: 焦点图'));
        parent::__construct('widget-bymt-slider', __('BYMT - 焦点图'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_slider';
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'BYMT 焦点图' ) : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
?>
        <?php echo bymt_slider( 'widget' ); ?>
<?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'BYMT 焦点图' );
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
        echo '<p>' . __('请到这里进行配置：') . '</p><p><a href="' . admin_url('themes.php?page=bymt_options#option-slider') . '">' . __('BYMT设置->焦点图设置->图片设置（侧栏）') . '</a></p>';
    }
}

// 小工具 - 广告栏（大）
class BYMT_Widget_Advert_Large extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_advert_large', 'description' => __('主题侧栏工具: 广告栏（270*270）'));
        parent::__construct('widget-bymt-advert_large', __('BYMT - 广告栏（大）'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_advert_large';
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'BYMT 广告栏' ) : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
?>
        <?php echo bymt_advert( 'ad_widget_large' ); ?>
<?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'BYMT 广告栏' );
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
        echo '<p>' . __('请到这里进行配置：') . '</p><p><a href="' . admin_url('themes.php?page=bymt_options#option-advert') . '">' . __('BYMT设置->广告设置->侧栏广告位（大）') . '</a></p>';
    }
}

// 小工具 - 广告栏（中）
class BYMT_Widget_Advert_Middle extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_advert_middle', 'description' => __('主题侧栏工具: 广告栏（270*180）'));
        parent::__construct('widget-bymt-advert_middle', __('BYMT - 广告栏（中）'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_advert_middle';
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'BYMT 广告栏' ) : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
?>
        <?php echo bymt_advert( 'ad_widget_middle' ); ?>
<?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'BYMT 广告栏' );
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
        echo '<p>' . __('请到这里进行配置：') . '</p><p><a href="' . admin_url('themes.php?page=bymt_options#option-advert') . '">' . __('BYMT设置->广告设置->侧栏广告位（中）') . '</a></p>';
    }
}

// 小工具 - 广告栏（小）
class BYMT_Widget_Advert_Small extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_advert_small', 'description' => __('主题侧栏工具: 广告栏（270*120）'));
        parent::__construct('widget-bymt-advert_small', __('BYMT - 广告栏（小）'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_advert_small';
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'BYMT 广告栏' ) : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
?>
        <?php echo bymt_advert( 'ad_widget_small' ); ?>
<?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'BYMT 广告栏' );
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
        echo '<p>' . __('请到这里进行配置：') . '</p><p><a href="' . admin_url('themes.php?page=bymt_options#option-advert') . '">' . __('BYMT设置->广告设置->侧栏广告位（小）') . '</a></p>';
    }
}

// 小工具 - 广告栏（多格）
class BYMT_Widget_Advert_Grid extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'widget_bymt_advert_grid', 'description' => __('主题侧栏工具: 广告栏（125*125*8）'));
        parent::__construct('widget-bymt-advert_grid', __('BYMT - 广告栏（多格）'), $widget_ops);
        $this->alt_option_name = 'widget_bymt_advert_grid';
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'BYMT 广告栏' ) : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
?>
        <?php echo bymt_advert( 'ad_widget_grid' ); ?>
<?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'BYMT 广告栏' );
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
        echo '<p>' . __('请到这里进行配置：') . '</p><p><a href="' . admin_url('themes.php?page=bymt_options#option-advert') . '">' . __('BYMT设置->广告设置->侧栏广告位（多格）') . '</a></p>';
    }
}

function bymt_widgets_init() {
    if ( !is_blog_installed() ) return;
    register_widget( 'BYMT_Widget_Tabs' );
    register_widget( 'BYMT_Widget_RComments' );
    register_widget( 'BYMT_Widget_Socials' );
    register_widget( 'BYMT_Widget_SiteStatus' );
    register_widget( 'BYMT_Widget_Slider' );
    register_widget( 'BYMT_Widget_Advert_Large' );
    register_widget( 'BYMT_Widget_Advert_Middle' );
    register_widget( 'BYMT_Widget_Advert_Small' );
    register_widget( 'BYMT_Widget_Advert_Grid' );
}
add_action( 'widgets_init', 'bymt_widgets_init' );

// 禁用标签云自动字体
function bymt_widget_tag_cloud_args( $args ) {
    $args = array( 'smallest' => 12, 'largest' => 12, 'unit' => 'px', 'separator' => '' );
    return $args;
}
add_filter( 'widget_tag_cloud_args', 'bymt_widget_tag_cloud_args' );
