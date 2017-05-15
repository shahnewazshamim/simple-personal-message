<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://softyardbd.com/
 * @since             2.0.0
 * @package           Simple_Personal_Message
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Personal Message
 * Plugin URI:        http://softyardbd.com/
 * Description:       Simple Personal Message is a Private Messaging system and a secure messaging form to your WordPress site. This is full functioning messaging system from front end and back end. User can send message with each others.
 * Version:           2.0.0
 * Author:            Md. Shamim Shahnewaz
 * Author URI:        http://softyardbd.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-personal-message
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-personal-message-activator.php
 */
function activate_simple_personal_message()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-simple-personal-message-activator.php';
    Simple_Personal_Message_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-personal-message-deactivator.php
 */
function deactivate_simple_personal_message()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-simple-personal-message-deactivator.php';
    Simple_Personal_Message_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_simple_personal_message');
register_deactivation_hook(__FILE__, 'deactivate_simple_personal_message');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-simple-personal-message.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_simple_personal_message()
{
    $plugin = new Simple_Personal_Message();
    $plugin->run();
}

run_simple_personal_message();