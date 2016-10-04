<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://softyardbd.com/
 * @since      1.0.3
 *
 * @package    Simple_Personal_Message
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {

    exit;

}

/**
 * The class responsible for defining all actions that occur in the admin area.
 */
require_once plugin_dir_path(__FILE__) . 'admin/class-simple-personal-message-admin.php';

/**
 * Uninstall user meta keys and option fileds.
 *
 * @since 1.0.3
 */
function uninstall()
{

    $meta_type = 'user';

    $user_id = 0; // This will be ignored, since we are deleting for all users.

    $meta_value = ''; // Also ignored. The meta will be deleted regardless of value.

    $delete_all = TRUE;

    $uninstall = new Simple_Personal_Message_Admin('', '');

    $meta_keys = $uninstall->spm_user_meta_fields();

    foreach ($meta_keys as $meta_key) {

        delete_metadata($meta_type, $user_id, $meta_key, $meta_value, $delete_all);

    }

    $option_fileds = array(

        'spm_message_send_limit',

        'spm_message_email_options',
    );

    foreach ($option_fileds as $option_filed) {

        delete_option($option_filed);

        delete_site_option($option_filed);

    }

    global $wpdb;

    $table_name = $wpdb->prefix . 'spm_message';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");

}

uninstall();