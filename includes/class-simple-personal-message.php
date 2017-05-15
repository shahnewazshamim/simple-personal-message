<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://softyardbd.com/
 * @since      2.0.0
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/includes
 * @author     Md. Shamim Shahnewaz <shamimshahnewaz@outlook.com>
 */
class Simple_Personal_Message
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    2.0.0
     * @access   protected
     * @var      Simple_Personal_Message_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;


    /**
     * The unique identifier of this plugin.
     *
     * @since    2.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;


    /**
     * The current version of the plugin.
     *
     * @since    2.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;


    /**
     * The base name of this plugin.
     *
     * @since    2.0.0
     * @access   protected
     * @var      string $plugin_basename The string used to identify this plugin base name.
     */
    protected $plugin_basename;


    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    2.0.0
     */
    public function __construct()
    {

        $this->plugin_name = 'simple-personal-message';

        $this->version = '2.0.0';

        $this->plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_name . '.php');


        $this->load_dependencies();

        $this->set_locale();

        $this->define_admin_hooks();

        $this->define_public_hooks();

    }


    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Simple_Personal_Message_Loader. Orchestrates the hooks of the plugin.
     * - Simple_Personal_Message_i18n. Defines internationalization functionality.
     * - Simple_Personal_Message_Admin. Defines all hooks for the admin area.
     * - Simple_Personal_Message_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    2.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-personal-message-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-personal-message-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-personal-message-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-simple-personal-message-public.php';

        /**
         * WP List Table class loaded.
         */
        require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

        /**
         * The class responsible for rendering inbox list with WP styled table.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-personal-message-inbox-items.php';

        /**
         * The class responsible for rendering outbox list with WP styled table.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-personal-message-outbox-items.php';

        /**
         * The class responsible for rendering trash list with WP styled table.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-personal-message-trash-items.php';

        $this->loader = new Simple_Personal_Message_Loader();

    }


    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Simple_Personal_Message_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    2.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Simple_Personal_Message_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }


    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    2.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Simple_Personal_Message_Admin($this->get_plugin_name(), $this->get_version());

        if (isset($_REQUEST['page']) && ($_REQUEST['page'] == $this->plugin_name . '-compose' || $_REQUEST['page'] == $this->plugin_name . '-outbox' || $_REQUEST['page'] == $this->plugin_name . '-trash' || $_REQUEST['page'] == $this->plugin_name . '-settings' || $_REQUEST['page'] == $this->plugin_name . '-options' || $_REQUEST['page'] == $this->plugin_name)) {

            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');

            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        }

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_dashboard_styles');

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_dashboard_scripts');

        $this->loader->add_action('init', $plugin_admin, 'register_user_group_taxonomies', 0);

        $this->loader->add_action('admin_init', $plugin_admin, 'register_user_meta');

        $this->loader->add_action('admin_init', $plugin_admin, 'register_option_settings');

        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_user_group_menu');

        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');

        $this->loader->add_action('admin_bar_menu', $plugin_admin, 'add_plugin_admin_bar_node_under_new_content', 1000);

        $this->loader->add_action('admin_notices', $plugin_admin, 'add_plugin_admin_notice');

        //$this->loader->add_action('admin_notices', $plugin_admin, 'add_plugin_update_notice');

        $this->loader->add_action('wp_dashboard_setup', $plugin_admin, 'spm_dashboard_widget');

        $this->loader->add_action('daily_schedule_message_delete', $plugin_admin, 'schedule_message_delete');

        $this->loader->add_action('show_user_profile', $plugin_admin, 'add_user_group_into_profile');

        $this->loader->add_action('edit_user_profile', $plugin_admin, 'add_user_group_into_profile');

        $this->loader->add_action('personal_options_update', $plugin_admin, 'save_user_group_from_profile');

        $this->loader->add_action('edit_user_profile_update', $plugin_admin, 'save_user_group_from_profile');

        $this->loader->add_action('delete_user', $plugin_admin, 'delete_user_group_from_user');

        $this->loader->add_action('pre_user_query', $plugin_admin, 'modify_user_query');


        $this->loader->add_action('wp_ajax_send_message_ajax_request', $plugin_admin, 'send_message_ajax_request');

        $this->loader->add_action('wp_ajax_nopriv_send_message_ajax_request', $plugin_admin, 'send_message_ajax_request');

        $this->loader->add_action('wp_ajax_load_user_list_ajax_request', $plugin_admin, 'load_user_list_ajax_request');

        $this->loader->add_action('wp_ajax_nopriv_load_user_list_ajax_request', $plugin_admin, 'load_user_list_ajax_request');

        $this->loader->add_action('wp_ajax_save_personalize_ajax_request', $plugin_admin, 'save_personalize_ajax_request');

        $this->loader->add_action('wp_ajax_nopriv_save_personalize_ajax_request', $plugin_admin, 'save_personalize_ajax_request');

        $this->loader->add_action('wp_ajax_assign_user_to_group_ajax_request', $plugin_admin, 'assign_user_to_group_ajax_request');

        $this->loader->add_action('wp_ajax_nopriv_assign_user_to_group_ajax_request', $plugin_admin, 'assign_user_to_group_ajax_request');


        $this->loader->add_filter('parent_file', $plugin_admin, 'spm_user_group_parent_menu');

        $this->loader->add_filter('spm-user-group_row_actions', $plugin_admin, 'spm_user_group_row_actions', 1, 2);

        $this->loader->add_filter('manage_users_columns', $plugin_admin, 'set_spm_group_user_column');

        $this->loader->add_filter('manage_users_custom_column', $plugin_admin, 'set_spm_group_user_column_values', 10, 3);

        $this->loader->add_filter('load_inbox_by_user_login', $plugin_admin, 'load_inbox_by_user_login', '');

        $this->loader->add_filter('load_outbox_by_user_login', $plugin_admin, 'load_outbox_by_user_login', '');

        $this->loader->add_filter('bulk_message_soft_delete', $plugin_admin, 'bulk_message_soft_delete', '');

        $this->loader->add_filter('bulk_message_mark_as_read', $plugin_admin, 'bulk_message_mark_as_read', '');

        $this->loader->add_filter('bulk_message_mark_as_unread', $plugin_admin, 'bulk_message_mark_as_unread', '');

        $this->loader->add_filter('load_delete_items_by_user_login', $plugin_admin, 'load_delete_items_by_user_login', '');

        $this->loader->add_filter('plugin_action_links_' . $this->plugin_basename, $plugin_admin, 'add_action_links');

        $this->loader->add_filter('sanitize_user', $plugin_admin, 'restrict_username');

        $this->loader->add_filter('views_users', $plugin_admin, 'bulk_user_group_edit');

        $this->loader->add_filter('wp_mail_content_type', $plugin_admin, 'wpdocs_set_html_mail_content_type');

    }


    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     2.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }


    /**
     * Retrieve the version number of the plugin.
     *
     * @since     2.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }


    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    2.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Simple_Personal_Message_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }


    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    2.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     2.0.0
     * @return    Simple_Personal_Message_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

}
