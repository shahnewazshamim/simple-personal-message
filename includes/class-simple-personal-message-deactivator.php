<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://softyardbd.com/
 * @since      2.0.0
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      2.0.0
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 * @author     Md. Shamim Shahnewaz <shamimshahnewaz@outlook.com>
 */
class Simple_Personal_Message_Deactivator
{

    /**
     * Plugin de-activator function.
     *
     * Plugin de-activate the function when register_deactivation_hook is enable.
     *
     * @since    2.0.0
     */
    public static function deactivate()
    {
        self::daily_schedule_message_delete();
    }


    /**
     * Schedule uninstall
     *
     * Remove 'daily_schedule_message_delete' schedule.
     *
     * @since    2.0.0
     */
    private static function daily_schedule_message_delete()
    {
        wp_clear_scheduled_hook('daily_schedule_message_delete');
    }

}
