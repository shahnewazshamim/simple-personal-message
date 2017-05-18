(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * relevanton reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
	 *
	 * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
	 *
	 * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(function () {

        /**
         * Sending Message.
         *
         * @since 2.0.0
         */

        jQuery('#btn-send-message').click(function () {

            var sender = $("#txt-sender").val();

            var receiver = $("#txt-receiver").val();

            var group = $("#txt-group").val();

            var subject = $("#txt-subject").val();

            var id = $("#txt-id").val();

            var tinymce = 'txt-content';

            var content = '';

            var editor = tinyMCE.get(tinymce);

            content = (editor) ? editor.getContent() : $('#' + inputid).val();

            jQuery.ajax({

                data: {
                    'action': 'send_message_ajax_request',
                    'sender': sender,
                    'receiver': receiver,
                    'group': group,
                    'subject': subject,
                    'content': content,
                    'id': id,
                },

                dataType: 'json',

                type: 'post',

                url: ajaxurl,

                beforeSend: function () {

                    $("div#divLoading").addClass('show');

                },

                success: function (data) {

                    if (data.limitcross == false) {

                        $("div#divLoading").removeClass('show');

                        jQuery('#post-message').html("<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Sorry!</strong> You are not authorized to send message while you are crossed your limit or no permission.</div>");

                    } else {

                        if (data.success == true) {

                            $("div#divLoading").removeClass('show');

                            jQuery('#post-message').html("<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Success!</strong> Message send.</div>");

                        }
                        else {

                            $("div#divLoading").removeClass('show');

                            jQuery('#post-message').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Error!</strong> Message sending failed.</div>");
                        }

                    }

                }

            });

        });


        /**
         * Loading user list by typing keyword.
         *
         * @since 2.0.0
         */


        var split = function (val) {

            return val.split(/,\s*/);

        };

        var extractLast = function (term) {

            return split(term).pop();

        };

        jQuery("#txt-receiver")

            .bind("keydown", function (event) {

                if (event.keyCode === jQuery.ui.keyCode.TAB && jQuery(this).autocomplete("instance").menu.active) {

                    event.preventDefault();
                }
            })

            .autocomplete({

                minLength: 0,

                source: function (request, response) {

                    var data = {
                        action: 'load_user_list_ajax_request',
                        term: extractLast(request.term)
                    };

                    jQuery.post(ajaxurl, data, function (r) {

                        response(r);

                    }, 'json');

                    //response(jQuery.ui.autocomplete.filter(availableTags, extractLast(request.term)));
                },

                focus: function () {

                    return false;
                },

                select: function (event, ui) {

                    var terms = split(this.value);

                    terms.pop();

                    terms.push(ui.item.value);

                    terms.push("");

                    this.value = terms.join(",");

                    return false;
                }

            });


        /**
         * Save personalize settings.
         *
         * @since 2.0.0
         */

        jQuery('#btn-save-personalize').click(function () {

            var spm_message_per_page = $("#spm_message_per_page").val();
            var spm_message_inbox_keep = $("#spm_message_inbox_keep").val();
            var spm_message_outbox_keep = $("#spm_message_outbox_keep").val();

            var spm_unread_row_font_style = $("#spm_unread_row_font_style").val();
            var spm_unread_row_font_weight = $("#spm_unread_row_font_weight").val();
            var spm_unread_row_border_sides = $("#spm_unread_row_border_sides").val();
            var spm_unread_row_border_width = $("#spm_unread_row_border_width").val();
            var spm_unread_row_border_style = $("#spm_unread_row_border_style").val();
            var spm_unread_row_border_color = $("#spm_unread_row_border_color").val();
            var spm_unread_row_background = $("#spm_unread_row_background").val();
            var spm_unread_row_text_decoration = $("#spm_unread_row_text_decoration").val();
            var spm_unread_row_border = '';

            spm_unread_row_background = (spm_unread_row_background) ? 'background: ' + spm_unread_row_background : '';

            if (spm_unread_row_border_sides == 'none') {
                spm_unread_row_border = 'border: none';
            } else {
                if (spm_unread_row_border_width != '' && spm_unread_row_border_style != '' && spm_unread_row_border_color != '') {
                    switch (spm_unread_row_border_sides) {
                        case 'all' :
                            spm_unread_row_border = 'border: ' + spm_unread_row_border_width + 'px ' + spm_unread_row_border_style + ' ' + spm_unread_row_border_color;
                            break;
                        case 'left' :
                            spm_unread_row_border = 'border-left: ' + spm_unread_row_border_width + 'px ' + spm_unread_row_border_style + ' ' + spm_unread_row_border_color;
                            break;
                        case 'right' :
                            spm_unread_row_border = 'border-right: ' + spm_unread_row_border_width + 'px ' + spm_unread_row_border_style + ' ' + spm_unread_row_border_color;
                            break;
                        case 'top' :
                            spm_unread_row_border = 'border-top: ' + spm_unread_row_border_width + 'px ' + spm_unread_row_border_style + ' ' + spm_unread_row_border_color;
                            break;
                        case 'bottom' :
                            spm_unread_row_border = 'border-bottom: ' + spm_unread_row_border_width + 'px ' + spm_unread_row_border_style + ' ' + spm_unread_row_border_color;
                            break;
                        default:
                            break;
                    }
                }
            }


            var spm_read_row_font_style = $("#spm_read_row_font_style").val();
            var spm_read_row_font_weight = $("#spm_read_row_font_weight").val();
            var spm_read_row_border_sides = $("#spm_read_row_border_sides").val();
            var spm_read_row_border_width = $("#spm_read_row_border_width").val();
            var spm_read_row_border_style = $("#spm_read_row_border_style").val();
            var spm_read_row_border_color = $("#spm_read_row_border_color").val();
            var spm_read_row_background = $("#spm_read_row_background").val();
            var spm_read_row_text_decoration = $("#spm_read_row_text_decoration").val();
            var spm_read_row_border = '';

            spm_read_row_background = (spm_read_row_background) ? 'background: ' + spm_read_row_background : '';

            if (spm_read_row_border_sides == 'none') {
                spm_read_row_border = 'border: none';
            } else {
                if (spm_read_row_border_width != '' && spm_read_row_border_style != '' && spm_read_row_border_color != '') {
                    switch (spm_read_row_border_sides) {
                        case 'all' :
                            spm_read_row_border = 'border: ' + spm_read_row_border_width + 'px ' + spm_read_row_border_style + ' ' + spm_read_row_border_color;
                            break;
                        case 'left' :
                            spm_read_row_border = 'border-left: ' + spm_read_row_border_width + 'px ' + spm_read_row_border_style + ' ' + spm_read_row_border_color;
                            break;
                        case 'right' :
                            spm_read_row_border = 'border-right: ' + spm_read_row_border_width + 'px ' + spm_read_row_border_style + ' ' + spm_read_row_border_color;
                            break;
                        case 'top' :
                            spm_read_row_border = 'border-top: ' + spm_read_row_border_width + 'px ' + spm_read_row_border_style + ' ' + spm_read_row_border_color;
                            break;
                        case 'bottom' :
                            spm_read_row_border = 'border-bottom: ' + spm_read_row_border_width + 'px ' + spm_read_row_border_style + ' ' + spm_read_row_border_color;
                            break;
                        default:
                            break;
                    }
                }
            }


            jQuery.ajax({

                data: {
                    'action': 'save_personalize_ajax_request',
                    'spm_message_per_page': spm_message_per_page,
                    'spm_message_inbox_keep': spm_message_inbox_keep,
                    'spm_message_outbox_keep': spm_message_outbox_keep,

                    'spm_unread_row_font_style': spm_unread_row_font_style,
                    'spm_unread_row_font_weight': spm_unread_row_font_weight,
                    'spm_unread_row_background': spm_unread_row_background,
                    'spm_unread_row_text_decoration': spm_unread_row_text_decoration,
                    'spm_unread_row_border': spm_unread_row_border,

                    'spm_read_row_font_style': spm_read_row_font_style,
                    'spm_read_row_font_weight': spm_read_row_font_weight,
                    'spm_read_row_background': spm_read_row_background,
                    'spm_read_row_text_decoration': spm_read_row_text_decoration,
                    'spm_read_row_border': spm_read_row_border,
                },

                dataType: 'json',

                type: 'post',

                url: ajaxurl,

                beforeSend: function () {

                    $("div#divLoading").addClass('show');

                },

                success: function (data) {

                    if (data.success == true) {

                        $("div#divLoading").removeClass('show');

                        jQuery('#post-message').html("<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Success!</strong> Settings saved.</div>");

                    }
                    else {

                        $("div#divLoading").removeClass('show');

                        jQuery('#post-message').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Error!</strong> Save failed.</div>");
                    }
                }

            });

        });

    });

})(jQuery);





