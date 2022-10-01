(function ($) {
    'use strict';

    $(document).ready(function () {
        let ajaxurl = cbxwpbookmark.ajaxurl;

        //delete a bookmark from grid shortcode (core has delete bookmark feature but it doesn;t work with grid shortcode)
        $('.cbxbookmark_card_wrap').on('click', '.cbxbookmark-post-delete', function (event) {
            event.preventDefault();

            if (!confirm(cbxwpbookmark.areyousuretodeletebookmark)) {
                return false;
            }

            let $this    = $(this);
            let $wrapper = $this.closest('div.cbxbookmark_card_wrap');

            let $bookmark_id = $this.data('bookmark_id');
            let $object_id   = $this.data('object_id');
            let $object_type = $this.data('object_type');
            let $busy        = parseInt($this.data('busy'));

            let data = {
                'action'     : 'cbx_delete_bookmark_post',
                'security'   : cbxwpbookmark.nonce,
                'object_id'  : $object_id,
                'object_type': $object_type,
                'bookmark_id': $bookmark_id
            };

            // We can also pass the url value separately from ajaxurl for front end AJAX implementations

            if ($busy === 0) {
                $this.data('busy', 1);

                $wrapper.find('.cbxbookmark-alert').remove();

                $this.find('span').css({
                    'display': 'inline-block'
                });

                $.post(ajaxurl, data, function (response) {
                    response = $.parseJSON(response);

                    if (response.msg === 0) {
                        // Remove the li tag if the bookmark is deleted
                        //let $target = $this.closest("div.cbxbookmark_card");
                        //$this.closest("div.cbxbookmark_card").remove();
                        //$this.closest("div.cbxbookmark_card").hide('slow', function(){ $(this).remove(); });
                        $this.closest('div.cbxbookmark_card_col').hide('slow', function () {
                            $(this).remove();
                        });

                        let $success_html = $(
                            '<div class="cbxbookmark-alert cbxbookmark-alert-success">' +
                            cbxwpbookmark.bookmark_removed + '</div>');

                        if ($wrapper.find('div.cbxbookmark_card').length === 0) {
                            $wrapper.append(
                                '<div class="cbxbookmark-alert cbxbookmark-alert-error">' +
                                cbxwpbookmark.bookmark_removed_empty + '</div>');
                        } else {
                            $wrapper.prepend($success_html);
                        }
                    } else if (response.msg == 1) {
                        let $error_html = $(
                            '<div class="cbxbookmark-alert cbxbookmark-alert-error">' +
                            cbxwpbookmark.bookmark_removed_failed + '</div>');
                        $wrapper.prepend($error_html);
                    }

                    $this.find('span').css({
                        'display': 'none',
                    });
                });

            }
        });

        //implementing the bookmark load more feature for bookmark grid
        $('.cbxbookmark_cards_wrapper_postgrid').on('click', '.cbxbookmark-more', function (e) {
            e.preventDefault();

            let _this    = $(this);
            let $wrapper = _this.closest('div.cbxbookmark_cards_wrapper').find('.cbxbookmark_card_wrap');

            $wrapper.find('.cbxwpbm_ajax_icon').show();

            let limit  = _this.data('limit');
            let offset = _this.data('offset');
            let catid  = _this.data('catid');
            let type   = _this.data('type');

            let order   = _this.data('order');
            let orderby = _this.data('orderby');
            let userid  = _this.data('userid');

            let totalpage   = _this.data('totalpage');
            let currpage    = _this.data('currpage');
            let allowdelete = _this.data('allowdelete');
            let show_thumb  = _this.data('show_thumb');

            if (currpage + 1 >= totalpage) {
                _this.hide();
            } else {
                _this.show();
            }

            let addcat = {
                'action'     : 'cbx_bookmark_postgrid_loadmore',
                'security'   : cbxwpbookmark.nonce,
                'limit'      : limit,
                'offset'     : offset,
                'catid'      : catid,
                'type'       : type,
                'order'      : order,
                'orderby'    : orderby,
                'userid'     : userid,
                'allowdelete': allowdelete,
                'show_thumb' : show_thumb,
            };

            $.post(ajaxurl, addcat, function (response) {

                response = $.parseJSON(response);

                if (response.code) {
                    _this.data('offset', limit + offset);
                    _this.data('currpage', currpage + 1);

                    $wrapper.append(response.data);
                    $wrapper.find('.cbxwpbm_ajax_icon').hide();

                } else {
                    //console.log('Error loading data. Response code=' + response.code);
                    let $error_html = $('<div class="cbxbookmark-alert cbxbookmark-alert-error">' + cbxwpbookmark.error_msg + response.code + '</div>');
                    $wrapper.append($error_html);
                }
            });
        });

        //implementing the bookmark load more feature for bookmark most grid
        $('.cbxbookmark_cards_wrapper_mostgrid').on('click', '.cbxbookmark-more', function (e) {
            e.preventDefault();

            let _this    = $(this);
            let $wrapper = _this.closest('div.cbxbookmark_cards_wrapper').find('.cbxbookmark_card_wrap');

            $wrapper.find('.cbxwpbm_ajax_icon').show();

            let limit      = _this.data('limit');
            let offset     = _this.data('offset');
            let type       = _this.data('type');
            let order      = _this.data('order');
            let orderby    = _this.data('orderby');
            let totalpage  = _this.data('totalpage');
            let currpage   = _this.data('currpage');
            let show_thumb = _this.data('show_thumb');


            if (currpage + 1 >= totalpage) {
                _this.hide();
            } else {
                _this.show();
            }

            let addcat = {
                'action'    : 'cbx_bookmark_mostgrid_loadmore',
                'security'  : cbxwpbookmark.nonce,
                'limit'     : limit,
                'offset'    : offset,
                'type'      : type,
                'order'     : order,
                'orderby'   : orderby,
                'show_thumb': show_thumb,
            };

            $.post(ajaxurl, addcat, function (response) {

                response = $.parseJSON(response);

                if (response.code) {
                    _this.data('offset', limit + offset);
                    _this.data('currpage', currpage + 1);

                    $wrapper.append(response.data);
                    $wrapper.find('.cbxwpbm_ajax_icon').hide();

                } else {
                    //console.log('Error loading data. Response code=' + response.code);
                    let $error_html = $(
                        '<div class="cbxbookmark-alert cbxbookmark-alert-error">' +
                        cbxwpbookmark.error_msg + response.code + '</div>');
                    $wrapper.append($error_html);
                }
            });
        });
    });
})(jQuery);

