/**
 * setting.js
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

jQuery(document).ready(function($) {
    'use strict';

    if (location.hash) {
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 1);
        $(location.hash).addClass('active').siblings('table').removeClass('active');
        $('#setting-menu li a[href="' + location.hash + '"]').addClass('current').parent('li').siblings('li').find('a').removeClass('current');
    }

    $('#setting-menu li a').on('click', function(e) {
        e.preventDefault();
        var optID = $(this).attr('href');
        $(this).addClass('current').parent('li').siblings('li').find('a').removeClass('current');
        $(optID).addClass('active').siblings('table').removeClass('active');
    });

    $('#button-backup-export').on('click', function() {
        window.open($('#wp-admin-canonical').attr('href') + '&export=true');
    });

    $('#button-restore-import').on('click', function() {
        var url = $('#wp-admin-canonical').attr('href') + '&import=true',
            data = $('#restore-data').val(),
            sure = confirm('警告！操作不可逆，建议先对数据进行备份操作。\n\n您确定要导入数据吗？');
        if (sure === true) {
            if (data.replace(/\s+/g, '') !== '') {
                $.post(url, { data: data }, function(r) {
                    if (r) {
                        window.location.href = $('#wp-admin-canonical').attr('href');
                    } else {
                        alert('无效的数据，导入失败');
                    }
                });
            }
        }
    });

    $('.tb-upload').on('click', function(e) {
        e.preventDefault();
        if (!window.wp) {
            return;
        }
        var ID = $(this).attr('id').replace('upload-', '');
        var wpMedia = window.wp.media({
            title: $(this).val(),
            library: { type: 'image' },
            multiple: false
        }).open().on('select', function() {
            var imgJSON = wpMedia.state().get('selection').first().toJSON();
            var imgAltID = ID.replace('-src', '-alt');
            var imgDesc = imgJSON.alt ? imgJSON.alt : imgJSON.title;
            $('#' + ID).val(imgJSON.url);
            if ($('#' + imgAltID).length) {
                $('#' + imgAltID).val(imgDesc);
            }
        });
    });

    $('.tb-link').on('click', function(e) {
        e.preventDefault();
        if (!window.wpLink) {
            return;
        }
        var ID = $(this).attr('id').replace('link-', '');
        window.wpLink.open(ID);
        $('#wp-link-submit').unbind('click');
        $('#wp-link-submit').on('click', function(e) {
            e.preventDefault();
            var linkAtts = window.wpLink.getAttrs();
            window.wpLink.close();
            $('#' + ID).val(linkAtts.href);
        });
    });
});
