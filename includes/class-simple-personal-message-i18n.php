<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://softyardbd.com/
 * @since      2.0.0
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.0.0
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 * @author     Md. Shamim Shahnewaz <shamimshahnewaz@outlook.com>
 */
class Simple_Personal_Message_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    2.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            
            'simple-personal-message',
        
            FALSE,
        
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        
        );

    }


}
