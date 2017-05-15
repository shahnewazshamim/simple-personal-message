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
         * Group member assign.
         *
         * @since 2.0.0
         */

        jQuery('#btn_update').click(function () {

            var user_ids = "";

            var spm_user_group = $('#spm-user-group').val();

            $('.wp-list-table input:checked').each(function () {

                user_ids = user_ids + (this.checked ? $(this).val() : "") + ",";

            });

            jQuery.ajax({

                data: {
                    'action': 'assign_user_to_group_ajax_request',
                    'spm_user_group': spm_user_group,
                    'user_ids': user_ids,
                },

                dataType: 'json',

                type: 'post',

                url: ajaxurl,

                beforeSend: function () {

                    $("div#divLoading").addClass('show');

                },

                success: function (data) {

                    if (data.success == true) {

                        window.location.reload(true);

                    }
                }

            });

        });

    });

})(jQuery);