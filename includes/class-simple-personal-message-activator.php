<?php

/**
 * Fired during plugin activation
 *
 * @link       http://softyardbd.com/
 * @since      1.0.3
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.3
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 * @author     Md. Shamim Shahnewaz <shamimshahnewaz@outlook.com>
 */
class Simple_Personal_Message_Activator
{

    /**
     * Plugin activator function.
     *
     * Plugin activate the function when register_activation_hook is enable.
     *
     * @since    1.0.3
     */
    public static function activate()
    {

        self::spm_table_install();

        self::daily_schedule_message_delete();
        
    }


    /**
     * Table install.
     *
     * Install 'spm_message' table to store message data.
     *
     * @since    1.0.3
     */
    private static function spm_table_install()
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                  id bigint(20) NOT NULL AUTO_INCREMENT,
                  org_id bigint(20) DEFAULT NULL,
                  subject VARCHAR(200) DEFAULT NULL,
                  message TEXT,
                  sender VARCHAR(100) DEFAULT NULL,
                  receiver VARCHAR(100) DEFAULT NULL,
                  date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  status TINYINT(1) DEFAULT NULL,
                  is_reply TINYINT(1) DEFAULT NULL,
                  sender_deleted TINYINT(1) DEFAULT NULL,
                  receiver_deleted TINYINT(1) DEFAULT NULL,
                  PRIMARY KEY (id)
        )";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);

    }


    /**
     * Schedule install.
     *
     * Install 'daily_schedule_message_delete' schedule.
     *
     * @since    1.0.3
     */
    private static function daily_schedule_message_delete()
    {

        if (!wp_next_scheduled('daily_schedule_message_delete')) {

            wp_schedule_event(time(), 'hourly', 'daily_schedule_message_delete');

        }

    }

}
