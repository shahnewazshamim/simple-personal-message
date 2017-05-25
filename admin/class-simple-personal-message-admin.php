<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://softyardbd.com/
 * @since      2.0.0
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/admin
 * @author     Md. Shamim Shahnewaz <shamimshahnewaz@outlook.com>
 */
class Simple_Personal_Message_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    2.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;


    /**
     * The version of this plugin.
     *
     * @since    2.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;


    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.0
     *
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    2.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Personal_Message_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Personal_Message_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('wp-color-picker');

        wp_enqueue_style(

            $this->plugin_name . '-bootstrap',

            plugin_dir_url(__FILE__) . 'css/bootstrap.min.css',

            array(),

            $this->version,

            'all'
        );

        wp_enqueue_style(

            $this->plugin_name . '-bootstrap-select',

            plugin_dir_url(__FILE__) . 'css/bootstrap-select.min.css',

            array(),

            $this->version,

            'all'
        );

        wp_enqueue_style(

            $this->plugin_name . '-font-awesome',

            plugin_dir_url(__FILE__) . 'fonts/font-awesome-4.7.0/css/font-awesome.min.css',

            array(),

            $this->version,

            'all'
        );

        wp_enqueue_style(

            $this->plugin_name,

            plugin_dir_url(__FILE__) . 'css/simple-personal-message-admin.css',

            array(),

            $this->version,

            'all'
        );

    }


    /**
     * Register the Admin for the dashboard area.
     *
     * @since 2.0.0
     */
    public function enqueue_dashboard_styles()
    {

        wp_enqueue_style(

            $this->plugin_name,

            plugin_dir_url(__FILE__) . 'css/simple-personal-message-admin.css',

            array(),

            $this->version,

            'all'
        );

    }


    /**
     * Register the Admin for the dashboard area.
     *
     * @since 2.0.0
     */
    public function enqueue_dashboard_scripts()
    {

        wp_enqueue_script(

            $this->plugin_name,

            plugin_dir_url(__FILE__) . 'js/simple-personal-message-user-admin.js',

            array('jquery'),

            $this->version,

            FALSE

        );

    }


    /**
     * Register the JavaScript for the admin area.
     *
     * @since 2.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Personal_Message_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Personal_Message_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script("jquery-ui-autocomplete");

        wp_enqueue_script(

            $this->plugin_name . '-bootstrap',

            plugin_dir_url(__FILE__) . 'js/bootstrap.min.js',

            array('jquery'),

            $this->version,

            FALSE

        );

        wp_enqueue_script(

            $this->plugin_name . '-bootstrap-select',

            plugin_dir_url(__FILE__) . 'js/bootstrap-select.min.js',

            array('jquery'),

            $this->version,

            FALSE

        );

        wp_enqueue_script(

            $this->plugin_name . '-color-picker',

            plugin_dir_url(__FILE__) . 'js/color-picker.js',

            array('wp-color-picker'),

            $this->version,

            FALSE

        );

        wp_enqueue_script(

            $this->plugin_name,

            plugin_dir_url(__FILE__) . 'js/simple-personal-message-admin.js',

            array('jquery'),

            $this->version,

            FALSE

        );

    }


    /**
     * Register the administration admin bar menu for this plugin into the WordPress New Content Dashboard menu.
     *
     * @since 2.0.0
     */
    public function add_plugin_admin_bar_node_under_new_content($wp_admin_bar)
    {

        $args = array(

            'parent' => 'new-content',

            'id' => 'new_message',

            'title' => 'Message',

            'href' => admin_url('admin.php?page=' . $this->plugin_name . '-compose'),

            'meta' => array('class' => ''),

        );

        $wp_admin_bar->add_node($args, 999);

        $wp_admin_bar->add_menu(

            array(

                'id' => $this->plugin_name,

                'title' => ($this->unread_count() > 0) ? $this->unread_count() . ' Unread Message' : 'No New Message',

                'href' => admin_url('admin.php?page=' . $this->plugin_name),
            )
        );

    }


    /**
     * Return number of unread message.
     *
     * @since 2.0.0
     *
     * @return int
     */
    public function unread_count()
    {

        $user_login = esc_sql(wp_get_current_user()->user_login);

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $wpdb->get_results("SELECT * FROM $table_name WHERE receiver = '" . $user_login . "' AND status = 0 AND receiver_deleted = 0", OBJECT);

        return $wpdb->num_rows;

    }


    /**
     * Register the plugin update notice.
     *
     * @since    2.0.0
     */
    public function add_plugin_update_notice()
    {

        echo "<div class='notice notice-info is-dismissible'>";

        echo "<h3>Simple Personal Message - Official notice</h3> ";

        echo "<p>";

        echo "Simple Personal Messageis now supports only for WP Admin panel. We are working on premium version and will be released very soon.

              Premium version can handle <strong>Front-end integration</strong> and compatible with any other <strong>custom frontend / member plugin</strong>.

              <br>Will be very easy to use using shortcode and developer friendly customization features.";

        echo "</p>";

        echo "<p>";

        echo "Thank you for being with us. Please visit - <strong><a href='http://softyardbd.com/simple-personal-message/' target='_blank'>Our Blog</a></strong>";

        echo "</p>";

        echo "</div>";

    }


    /**
     * Register the admin notice for unread message.
     *
     * @since    2.0.0
     */
    public function add_plugin_admin_notice()
    {

        if ($this->unread_count() > 0) {

            echo "<div class='notice notice-success is-dismissible'>";

            echo "<a href='" . admin_url('admin.php?page=' . $this->plugin_name) . "'><p class='message-notice'>{$this->unread_count()} Unread Message</p></a>";

            echo "</div>";

        }

    }


    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since 2.0.0
     */
    public function add_plugin_admin_menu()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */

        add_options_page(

            'Simple personal Message Options', // Page Title

            'SPM Options', // Top Level Menu

            'manage_options', // Capabilities

            $this->plugin_name . '-options', // Menu Slug

            array($this, 'display_plugin_setup_page') // Menu Callback function

        );

        add_menu_page(

            'Inbox',

            'SPM Message ' . '<span class="update-plugins"><span class="plugin-count">' . $this->unread_count() . '</span></span>',

            'read',

            $this->plugin_name,

            array($this, 'display_plugin_inbox_page'),

            'dashicons-email-alt',

            10

        );

        add_submenu_page(

            $this->plugin_name,

            'Inbox List',

            'SPM Inbox ' . '<span class="update-plugins"><span class="plugin-count">' . $this->unread_count() . '</span></span>',

            'read',

            $this->plugin_name,

            array($this, 'display_plugin_inbox_page')

        );

        add_submenu_page(

            'simple-personal-message',

            'Start Writing',

            'SPM Compose',

            'read',

            $this->plugin_name . '-compose',

            array($this, 'display_plugin_sent_page')

        );

        add_submenu_page(

            'simple-personal-message',

            'Outbox List',

            'SPM Outbox',

            'read',

            $this->plugin_name . '-outbox',

            array($this, 'display_plugin_outbox_page')

        );

        add_submenu_page(

            'simple-personal-message',

            'Trash List',

            'SPM Trash',

            'read',

            $this->plugin_name . '-trash',

            array($this, 'display_plugin_trash_page')

        );

        add_submenu_page(

            'simple-personal-message',

            'Personalize',

            'Personalize',

            'read',

            $this->plugin_name . '-settings',

            array($this, 'display_plugin_settings_page')

        );

    }


    /**
     * Add settings action link to the plugins page.
     *
     * @since 2.0.0
     */
    public function add_action_links($links)
    {

        $settings_link = array(

            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name . '-options') . '">' . __('Settings', $this->plugin_name) . '</a>',
        );

        return array_merge($settings_link, $links);

    }


    /**
     * Render the settings page for this plugin.
     *
     * @since 2.0.0
     */
    public function display_plugin_setup_page()
    {
        include_once('partials/simple-personal-message-admin-display.php');
    }


    /**
     * Render the Inbox page for this plugin.
     *
     * @since 2.0.0
     */
    public function display_plugin_inbox_page()
    {
        include_once('partials/simple-personal-message-admin-inbox.php');
    }


    /**
     * Render the Inbox page for this plugin.
     *
     * @since 2.0.0
     */
    public function display_plugin_outbox_page()
    {
        include_once('partials/simple-personal-message-admin-outbox.php');
    }


    /**
     * Render the Sent Items page for this plugin.
     *
     * @since 2.0.0
     */
    public function display_plugin_sent_page()
    {

        $limit = get_option('spm_message_send_limit');

        if ((int)$limit[wp_get_current_user()->roles[0]] == 0) {

            include_once('partials/simple-personal-message-admin-compose.php');

        } else {

            if ($this->total_send() < (int)$limit[wp_get_current_user()->roles[0]]) {

                include_once('partials/simple-personal-message-admin-compose.php');

            } else {

                include_once('partials/simple-personal-message-admin-denied.php');

            }

        }

    }


    /**
     * Return number of unread message.
     *
     * @since 2.0.0
     *
     * @return int
     */
    public function total_send()
    {

        $user_login = esc_sql(wp_get_current_user()->user_login);

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $wpdb->get_results("SELECT * FROM $table_name WHERE sender = '" . $user_login . "' AND sender_deleted <> 2",
            OBJECT);

        return $wpdb->num_rows;

    }


    /**
     * Render the Trash page for this plugin.
     *
     * @since    2.0.0
     */
    public function display_plugin_trash_page()
    {
        include_once('partials/simple-personal-message-admin-trash.php');
    }


    /**
     * Render the Personalize page for this plugin.
     *
     * @since    2.0.0
     */
    public function display_plugin_settings_page()
    {
        include_once('partials/simple-personal-message-admin-settings.php');
    }


    /**
     * Render the Sent Logs page for this plugin.
     *
     * @since 2.0.0
     */
    public function display_plugin_view_page()
    {

        include_once('partials/simple-personal-message-admin-view.php');

        if (isset($_REQUEST['message']) && intval($_REQUEST['message']) && $_REQUEST['page'] != 'simple-personal-message-outbox') {

            $this->mark_as_read(esc_html($_REQUEST['message']));

        }

    }


    /**
     * Mark as read a single message from inbox list.
     *
     * @since 2.0.0
     */
    public function mark_as_read($message_id)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $read = $wpdb->get_row("SELECT status FROM $table_name WHERE id = '" . esc_sql($message_id) . "' AND status = 0", OBJECT);

        if (!is_null($read) and $read->status != NULL) {

            $wpdb->update($table_name, array('status' => 1), array('id' => esc_sql($message_id)));

        }

    }


    /**
     * Register spm Dashboard widget.
     *
     * @since 2.0.0
     */
    public function spm_dashboard_widget()
    {

        wp_add_dashboard_widget(

            'spm_dashboard_widget',

            'Simple Personal Message Stats',

            function () {

                $this->spm_dashboard_widget_display();

            }

        );

    }


    /**
     * Render the Dashboard widget page for this plugin.
     *
     * @since 2.0.0
     */
    public function spm_dashboard_widget_display()
    {
        include_once('partials/simple-personal-message-admin-dashboard.php');
    }


    /**
     * Register user meta for SPM message.
     *
     * @since 2.0.0
     */
    public function register_user_meta()
    {

        $meta_keys = $this->spm_user_meta_fields();

        foreach ($meta_keys as $meta_key) {

            $user_meta = get_user_meta(get_current_user_id(), $meta_key, FALSE);

            if (empty($user_meta)) {

                add_user_meta(get_current_user_id(), $meta_key, '');

            }

        }

    }


    /**
     * SPM message user meta fields.
     *
     * @since 2.0.0
     *
     * @return array
     */
    public function spm_user_meta_fields()
    {

        return array(

            'spm_message_per_page',
            'spm_message_inbox_keep',
            'spm_message_outbox_keep',

            'spm_unread_row_font_style',
            'spm_unread_row_font_weight',
            'spm_unread_row_background',
            'spm_unread_row_text_decoration',
            'spm_unread_row_border',

            'spm_read_row_font_style',
            'spm_read_row_font_weight',
            'spm_read_row_background',
            'spm_read_row_text_decoration',
            'spm_read_row_border',

        );

    }


    /**
     * Register Settings.
     *
     * @since 2.0.0
     */
    public function register_option_settings()
    {

        register_setting('simple-personal-message-options', 'spm_message_send_limit');

        register_setting('simple-personal-message-options', 'spm_message_email_options');

    }


    /**
     * Register user group taxonomies.
     *
     * @since 2.0.0
     */
    public function register_user_group_taxonomies()
    {

        register_taxonomy(

            'spm-user-group',

            'user',

            array(

                'public' => FALSE,

                'show_ui' => TRUE,

                'labels' => array(

                    'name' => __('SPM User Groups', $this->plugin_name),

                    'singular_name' => __('SPM Group', $this->plugin_name),

                    'menu_name' => __('SPM User Groups', $this->plugin_name),

                    'search_items' => __('Search SPM Groups', $this->plugin_name),

                    'popular_items' => __('Popular SPM Groups', $this->plugin_name),

                    'all_items' => __('All SPM User Groups', $this->plugin_name),

                    'edit_item' => __('Edit SPM User Group', $this->plugin_name),

                    'update_item' => __('Update SPM User Group', $this->plugin_name),

                    'add_new_item' => __('Add SPM User Group', $this->plugin_name),

                    'new_item_name' => __('New User Group Name', $this->plugin_name),

                    'separate_items_with_commas' => __('Separate SPM user groups with commas', $this->plugin_name),

                    'add_or_remove_items' => __('Add or remove SPM user groups', $this->plugin_name),

                    'choose_from_most_used' => __('Choose from the most popular SPM user groups', $this->plugin_name),

                ),

                'rewrite' => FALSE,

                'capabilities' => array(

                    'manage_terms' => 'edit_users',

                    'edit_terms' => 'edit_users',

                    'delete_terms' => 'edit_users',

                    'assign_terms' => 'read',

                ),

            )

        );

    }


    /**
     * @param $username
     *
     * @since 2.0.0
     *
     * @return bool
     */
    public function restrict_username($username)
    {

        if ($username === 'spm-user-group') {

            return FALSE;

        }

        return $username;

    }


    /**
     * Add plugin user group to admin menu.
     *
     * @since 2.0.0
     */
    public function add_plugin_user_group_menu()
    {

        $tax = get_taxonomy('spm-user-group');

        add_users_page(

            esc_attr(esc_sql($tax->labels->menu_name)),

            esc_attr(esc_sql($tax->labels->menu_name)),

            $tax->cap->manage_terms,

            'edit-tags.php?taxonomy=' . esc_attr(esc_sql($tax->name))

        );

    }


    /**
     * Show spm user groups into user profile page.
     *
     * @param $user
     */
    public function add_user_group_into_profile($user)
    {

        $user_terms = wp_get_object_terms($user->ID, 'spm-user-group');

        $term_ids = array();

        foreach ($user_terms as $user_term) {

            $term_ids[] = $user_term->term_id;

        }

        $tax_args = array(

            'taxonomy' => 'spm-user-group',

            'hide_empty' => FALSE,

        );

        $user_groups = get_terms($tax_args);

        echo "<h3>SPM User Groups</h3>";

        echo "<table class='form-table'><tbody>";

        echo "<tr><th>Select User Groups</th>";

        echo "<td><select name='spm_user_groups[]'>";

        echo "<option value=''>-- NOT IN ANY GROUP --</option>";

        foreach ($user_groups as $user_group) {

            $selected = (is_object_in_term($user->ID, 'spm-user-group', $user_group->name) == TRUE) ? 'selected' : '';

            echo "<option value='" . $user_group->term_id . "' $selected>$user_group->name</option>";

        }

        echo "</select></td>";

        echo "</tr>";

        echo "</tbody></table>";

    }


    /**
     * Save user group from user profile.
     *
     * @param $user_id
     *
     * @since 2.0.0
     */
    public function save_user_group_from_profile($user_id)
    {

        $user_groups = esc_attr(esc_sql($_POST['spm_user_groups']));

        $groups = array_unique(array_map('intval', $user_groups));

        wp_set_object_terms($user_id, $groups, 'spm-user-group', FALSE);

        clean_object_term_cache($user_id, 'spm-user-group');

    }


    /**
     * Delete user group from user profile.
     *
     * @param $user_id
     *
     * @since 2.0.0
     */
    public function delete_user_group_from_user($user_id)
    {
        wp_delete_object_term_relationships($user_id, 'spm-user-group');
    }


    /**
     * SPM Group column showing on user list table.
     *
     * @param $column
     *
     * @since 2.0.0
     *
     * @return mixed
     */
    public function set_spm_group_user_column($column)
    {

        $column['spm-user-group'] = 'SPM Group';

        return $column;

    }


    /**
     * SPM Group column items showing on user list table.
     *
     * @since 2.0.0
     *
     * @param $display
     * @param $column
     * @param $term_id
     *
     * @return string
     */
    public function set_spm_group_user_column_values($display, $column, $term_id)
    {

        $groups = '';

        if ('spm-user-group' === $column) {

            $user_groups = wp_get_object_terms($term_id, 'spm-user-group', array('fields' => 'all_with_object_id'));

            foreach ($user_groups as $user_group) {

                $groups .= '<a href="' . admin_url('users.php?spm-user-group=' . $user_group->slug) . '">' . $user_group->name . '</a>, ';

            }

        }

        return rtrim($groups, ', ');

    }


    /**
     * Render Parent Menu.
     *
     * @param string $parent
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function spm_user_group_parent_menu($parent = '')
    {

        global $pagenow;

        if (!empty($_GET['taxonomy']) && $pagenow == 'edit-tags.php' && isset($_GET['taxonomy'])) {

            $parent = 'users.php';

        }

        return $parent;

    }


    /**
     * Add 'View Users' Row action.
     *
     * @param $actions
     * @param $term
     *
     * @since 2.0.0
     *
     * @return mixed
     */
    public function spm_user_group_row_actions($actions, $term)
    {

        $actions['view'] = sprintf(__('%sView users%s', 'spm-user-group'), '<a href="' . esc_url(add_query_arg(array('spm-user-group' => $term->slug), admin_url('users.php'))) . '">', '</a>');

        return $actions;

    }


    /**
     * Update SPM user group member.
     *
     * @param $terms
     * @param $taxonomy
     *
     * @since 2.0.0
     */
    public function update_spm_user_group_count($terms, $taxonomy)
    {

        global $wpdb;

        foreach ((array)$terms as $term) {

            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", esc_sql($term)));

            do_action('edit_term_taxonomy', $term, $taxonomy);

            $wpdb->update($wpdb->term_taxonomy, compact('count'), array('term_taxonomy_id' => esc_sql($term)));

            do_action('edited_term_taxonomy', $term, $taxonomy);

        }

    }


    /**
     * Render bulk group update drop down.
     *
     * @since 2.0.0
     */
    public function bulk_user_group_edit()
    {

        $groups = $this->load_user_groups();

        echo "<div id='divLoading'></div>";

        echo "<div class='tablenav top'>";

        echo "<form action='' method='post' id='frm-group-update'>";

        echo "<select id='spm-user-group'>";

        echo "<option value=''>Change Group to</option>";

        foreach ($groups as $group) {

            echo "<option value=$group->term_id>$group->name</option>";

        }

        echo "</select> ";

        echo "<input type='button' value='Change' id='btn_update' name='btn_update' class='button'>&nbsp; &nbsp;";

        if (!empty($_GET[get_taxonomy('spm-user-group')->name])) {

            echo "<a href='" . admin_url('users.php') . "'>All Users</a>";

        }

        echo "</form>";

        echo "</div>";

    }


    /**
     * Return all user groups.
     *
     * @since 2.0.0
     *
     * @return array|int|null|WP_Error
     */
    public function load_user_groups()
    {

        $tax_args = array(

            'taxonomy' => 'spm-user-group',

            'hide_empty' => FALSE,

        );

        $user_groups = get_terms($tax_args);

        if (!is_wp_error($user_groups)) {

            return $user_groups;

        }

        return NULL;

    }


    /**
     * Assign user to spm group from user list.
     *
     * @since 2.0.0
     */
    public function assign_user_to_group_ajax_request()
    {

        $user_ids = sanitize_text_field($_REQUEST['user_ids']);

        $user_ids = trim($user_ids, 'on,');

        $user_ids = explode(',', $user_ids);

        $user_groups[] = intval($_POST['spm_user_group']);

        $groups = array_unique(array_map('intval', $_POST['spm_user_group']));

        foreach ($user_ids as $user_id) {

            wp_set_object_terms($user_id, $groups, 'spm-user-group', FALSE);

            clean_object_term_cache($user_id, 'spm-user-group');

        }

        $message['success'] = TRUE;

        echo json_encode($message);

        exit;

    }


    /**
     * Modify user query to get users by group.
     *
     * @param string $query
     *
     * @since 2.0.0
     */
    public function modify_user_query($query = '')
    {

        global $wpdb, $pagenow;

        if ($pagenow === 'users.php') {

            if (!empty($_GET['spm-user-group'])) {

                $user_ids = array();

                $spm_user_group = esc_html($_GET['spm-user-group']);

	            $user_term = get_term_by('slug', esc_sql($spm_user_group), 'spm-user-group');

	            $all_users = get_objects_in_term($user_term->term_id, 'spm-user-group');

	            $user_ids = array_merge($all_users, $user_ids);

                if (!empty($all_users)) {

                    $in_user_ids = implode(',', wp_parse_id_list($all_users));

                    $query->query_where .= " AND $wpdb->users.ID IN ($in_user_ids)";

                } else {

                    $query->query_where .= " AND $wpdb->users.ID = ''";

                }

            }

        }

    }


    /**
     * Mark as unread a single message from inbox list.
     *
     * @since 2.0.0
     */
    public function mark_as_unread($message_id)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $unread = $wpdb->get_row("SELECT status FROM $table_name WHERE id = '" . esc_sql($message_id) . "' AND status = 1", OBJECT);

        if (!is_null($unread) and $unread->status != NULL) {

            $wpdb->update($table_name, array('status' => 0), array('id' => esc_sql($message_id)));

        }

    }


    /**
     * Message soft delete for sender and receiver.
     *
     * @since 2.0.0
     *
     * @param $id
     */
    public function message_soft_delete($id)
    {

        global $wpdb;

        $id = esc_sql($id);

        $table_name = $wpdb->prefix . 'spm_message';

        $result = $wpdb->get_results("SELECT sender, receiver FROM $table_name WHERE id = $id");

        if (wp_get_current_user()->user_login == $result[0]->sender) {

            $wpdb->update($table_name, array('sender_deleted' => 1), array('id' => $id));

        } elseif (wp_get_current_user()->user_login == $result[0]->receiver) {

            $wpdb->update($table_name, array('receiver_deleted' => 1), array('id' => $id));

        }

    }


    /**
     * Bulk message soft delete for sender and receiver .
     *
     * @since 2.0.0
     *
     * @param $ids
     */
    public function bulk_message_soft_delete($ids)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        foreach ($ids as $id) {

            $result = $wpdb->get_results("SELECT sender, receiver FROM $table_name WHERE id = $id");

            if (wp_get_current_user()->user_login == $result[0]->sender) {

                $wpdb->update($table_name, array('sender_deleted' => 1), array('id' => $id));

            } elseif (wp_get_current_user()->user_login == $result[0]->receiver) {

                $wpdb->update($table_name, array('receiver_deleted' => 1), array('id' => $id));

            }

        }

    }


    /**
     * Message restore for sender and receiver.
     *
     * @since 2.0.0
     *
     * @param $id
     */
    public function message_restore($id)
    {

        global $wpdb;

        $id = esc_sql($id);

        $table_name = $wpdb->prefix . 'spm_message';

        $result = $wpdb->get_results("SELECT sender, receiver FROM $table_name WHERE id = $id");

        if (wp_get_current_user()->user_login == $result[0]->sender) {

            $wpdb->update($table_name, array('sender_deleted' => 0), array('id' => $id));

        } elseif (wp_get_current_user()->user_login == $result[0]->receiver) {

            $wpdb->update($table_name, array('receiver_deleted' => 0), array('id' => $id));

        }

    }


    /**
     * Bulk message restore for sender and receiver .
     *
     * @since 2.0.0
     *
     * @param $ids
     */
    public function bulk_message_restore($ids)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        foreach ($ids as $id) {

            $result = $wpdb->get_results("SELECT sender, receiver FROM $table_name WHERE id = $id");

            if (wp_get_current_user()->user_login == $result[0]->sender) {

                $wpdb->update($table_name, array('sender_deleted' => 0), array('id' => $id));

            } elseif (wp_get_current_user()->user_login == $result[0]->receiver) {

                $wpdb->update($table_name, array('receiver_deleted' => 0), array('id' => $id));

            }

        }

    }


    /**
     * Message delete permanently for sender and receiver.
     *
     * @since 2.0.0
     *
     * @param $id
     */
    public function message_delete_permanently($id)
    {

        global $wpdb;

        $id = esc_attr(esc_sql(($id)));

        $table_name = $wpdb->prefix . 'spm_message';

        $result = $wpdb->get_results("SELECT sender, receiver FROM $table_name WHERE id = $id");

        if (wp_get_current_user()->user_login == $result[0]->sender) {

            $wpdb->update($table_name, array('sender_deleted' => 2), array('id' => $id));

        } elseif (wp_get_current_user()->user_login == $result[0]->receiver) {

            $wpdb->update($table_name, array('receiver_deleted' => 2), array('id' => $id));

        }

    }


    /**
     * Bulk message delete permanently for sender and receiver .
     *
     * @since 2.0.0
     *
     * @param $ids
     */
    public function bulk_message_delete_permanently($ids)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        foreach ($ids as $id) {

            $result = $wpdb->get_results("SELECT sender, receiver FROM $table_name WHERE id = $id");

            if (wp_get_current_user()->user_login == $result[0]->sender) {

                $wpdb->update($table_name, array('sender_deleted' => 2), array('id' => $id));

            } elseif (wp_get_current_user()->user_login == $result[0]->receiver) {

                $wpdb->update($table_name, array('receiver_deleted' => 2), array('id' => $id));

            }

        }

    }


    /**
     * Bulk message delete permanently of sender and receiver while reached the keep limit.
     *
     * @since 2.0.0
     */
    public function schedule_message_delete()
    {

        global $wpdb;

        $table = $wpdb->prefix . "usermeta";

        $spm_table = $wpdb->prefix . "spm_message";

        $inboxes = $wpdb->get_results("SELECT * FROM $table WHERE meta_key = 'spm_message_inbox_keep'", OBJECT);

        foreach ($inboxes as $inbox) {

            $user = get_user_by('ID', $inbox->user_id);

            $messages = $this->get_message_by_receiver($user->user_login);

            if ($inbox->meta_value != 'keep') {

                foreach ($messages as $message) {

                    $message_date = date_create(date('Y-m-d', strtotime($message->date)));

                    $current_date = date_create(date('Y-m-d'));

                    $diff = date_diff($message_date, $current_date)->format('%a');

                    if ($diff >= $inbox->meta_value) {

                        $wpdb->get_results("UPDATE $spm_table SET receiver_deleted = '2' WHERE id = '" . $message->id . "'");

                    }

                }

            }

        }

        $outboxes = $wpdb->get_results("SELECT * FROM $table WHERE meta_key = 'spm_message_outbox_keep'", OBJECT);

        foreach ($outboxes as $outbox) {

            $user = get_user_by('ID', $outbox->user_id);

            $messages = $this->get_message_by_sender($user->user_login);

            if ($outbox->meta_value != 'keep') {

                foreach ($messages as $message) {

                    $message_date = date_create(date('Y-m-d', strtotime($message->date)));

                    $current_date = date_create(date('Y-m-d'));

                    $diff = date_diff($message_date, $current_date)->format('%a');

                    if ($diff >= $outbox->meta_value) {

                        $wpdb->get_results("UPDATE $spm_table SET sender_deleted = '2' WHERE id = '" . $message->id . "'");

                    }

                }

            }

        }

    }


    /**
     * Get message details by receiver.
     *
     * @since 2.0.0
     *
     * @param $receiver
     *
     * @return array|null|object Message details.
     */
    public function get_message_by_receiver($receiver)
    {

        global $wpdb;

        $receiver = esc_sql($receiver);

        $table_name = $wpdb->prefix . 'spm_message';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE receiver = '$receiver'", OBJECT);

        return $result;

    }


    /**
     * Get message details by sender.
     *
     * @since 2.0.0
     *
     * @param $sender
     *
     * @return array|null|object Message details.
     */
    public function get_message_by_sender($sender)
    {

        global $wpdb;

        $sender = esc_sql($sender);

        $table_name = $wpdb->prefix . 'spm_message';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE sender = '$sender'", OBJECT);

        return $result;

    }


    /**
     * Bulk message mark as read .
     *
     * @since 2.0.0
     *
     * @param $ids
     */
    public function bulk_message_mark_as_read($ids)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        foreach ($ids as $id) {

            $read = $wpdb->get_row("SELECT status FROM $table_name WHERE id = '" . $id . "' AND status = 0", OBJECT);

            if (!is_null($read) and $read->status != NULL) {

                $wpdb->update($table_name, array('status' => 1), array('id' => $id));

            }

        }

    }


    /**
     * Bulk message mark as unread.
     *
     * @since 2.0.0
     *
     * @param $ids
     */
    public function bulk_message_mark_as_unread($ids)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        foreach ($ids as $id) {

            $unread = $wpdb->get_row("SELECT status FROM $table_name WHERE id = '" . $id . "' AND status = 1", OBJECT);

            if (!is_null($unread) and $unread->status != NULL) {

                $wpdb->update($table_name, array('status' => 0), array('id' => $id));

            }

        }

    }


    /**
     * Send Message Using Ajax.
     *
     * @since 2.0.0
     */
    public function send_message_ajax_request()
    {

        $message = array();

        $limit = get_option('spm_message_send_limit');

        if ($this->total_send() < (int)$limit[wp_get_current_user()->roles[0]] or (int)$limit[wp_get_current_user()->roles[0]] == 0) {

            if ($_POST) {

                $email = get_option('spm_message_email_options');

                $sender = sanitize_user($_POST['sender']);

                global $wpdb;

                $table_name = $wpdb->prefix . 'spm_message';

                $id = (isset($_POST['id']) && intval($_POST['id'])) ? intval($_POST['id']) : NULL;

                if ($id != NULL) {

                    $result = $this->get_message_by_id($id);

                    if ($result[0]->org_id != NULL) {

                        $wpdb->update($table_name, array('is_reply' => 1), array('id' => $result[0]->org_id));

                    }

                }

                $receivers = sanitize_user($_POST['receiver']);

                if($receivers != '') {

                	$usernames = explode(',', $receivers);

	                $receivers_array = array();

                	foreach ($usernames as $username) {

                		if(username_exists($username)) {

			                $receivers_array[] = $username;

		                }

	                }

	                $receivers = implode(',', $receivers_array);

                }

                $receiver_group = array();

                $email_group = array();

                if (esc_attr(esc_sql(($_POST['group']) === 'all'))) {

                    $users = get_users(array('fields' => array('user_login', 'user_email')));

                    foreach ($users as $user) {

                        array_push($receiver_group, $user->user_login);

                        array_push($email_group, $user->user_email);

                    }

                }

                $term = get_term_by('slug', esc_attr(esc_sql($_POST['group']), 'spm-user-group'));

                $user_ids = get_objects_in_term($term->term_id, 'spm-user-group');

                foreach ($user_ids as $user_id) {

                    array_push($receiver_group, get_userdata($user_id)->user_login);

                    array_push($email_group, get_userdata($user_id)->user_email);

                }

                $receivers = array_filter(explode(',', $receivers));

                $receivers = array_unique(array_merge($receiver_group, $receivers));

                foreach ($receivers as $receiver) {

                    array_push($email_group, get_user_by('login', $receiver)->user_email);

                }

                $email_group = array_unique($email_group);

                if (($key = array_search(wp_get_current_user()->user_login, $receivers)) !== false) {

                    unset($receivers[$key]);
                }

                if (($key = array_search(wp_get_current_user()->user_email, $email_group)) !== false) {

                    unset($email_group[$key]);
                }

                $subject = esc_html($_POST['subject']);

                $content = $_POST['content'];

                if (!empty($receivers)) {

                    $all_receivers = array_combine($receivers, $email_group);

                    foreach ($all_receivers as $receiver => $receiver_email) {

                        $data = array(

                            'org_id' => $id,

                            'subject' => esc_sql($subject),

                            'message' => esc_sql($content),

                            'sender' => esc_sql($sender),

                            'receiver' => esc_sql($receiver),

                            'date' => date("Y-m-d H:i:s"),

                            'status' => 0,

                            'is_reply' => 0,

                            'sender_deleted' => 0,

                            'receiver_deleted' => 0,

                        );

                        if ($wpdb->insert($table_name, $data)) {

                            $message['success'] = TRUE;

                            if ($email || $email == '1') {

                                $this->send_email_notification($receiver_email, $sender);

                            }

                        } else {

                            $message['success'] = FALSE;

                        }

                    }

                }

                $message['user'] = $sender;

            }

        } else {

            $message['limitcross'] = FALSE;

        }

        echo json_encode($message);

        exit;

    }


    /**
     *  Get message details by id.
     *
     * @since 2.0.0
     *
     * @param $id
     *
     * @return array|null|object Message details.
     */
    public function get_message_by_id($id)
    {

        global $wpdb;

        $id = esc_sql($id);

        $table_name = $wpdb->prefix . 'spm_message';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $id");

        return $result;

    }


    /**
     * Send email notification to receiver while enable email notification.
     *
     * @since 2.0.0
     *
     * @param $receiver
     * @param $sender
     */
    public function send_email_notification($receiver, $sender)
    {
        $url = admin_url('admin.php?page=' . $this->plugin_name);

        $site = get_bloginfo();

        $headers = array(

            '<' . get_bloginfo() . '> notification@' . site_url(),

        );

        $subject = "New Message From " . $sender;

        $message = <<<MESSAGE

Hi, <br>
You have got a new message from $receiver. <br>
<a href='$url'>View conversation on $site</a> <br><br>
<address>
Regards <br>
$site Teams
Powered by <a href="http://softyardbd.com" target="_blank"></a>
</address>
MESSAGE;

        wp_mail($receiver, $subject, $message, $headers);

    }


    /**
     * Load user list by user name wildcard.
     *
     * @since 2.0.0
     */
    public function load_user_list_ajax_request()
    {

        if ($_REQUEST) {

            $args = array(

                'order' => 'ASC',

                'orderby' => 'display_name',

                'search' => '*' . esc_attr(esc_sql($_REQUEST['term'])) . '*',

                'search_columns' => array('user_login', 'user_nicename', 'user_email',),
            );

            $query = new WP_User_Query($args);

            $users = $query->get_results();

            $user_list = array();

            foreach ($users as $user) {

                $user_list[] = $user->user_login;

            }

        }

        echo json_encode($user_list);

        exit;

    }


    /**
     * Get Inbox items by user login name.
     *
     * @since 2.0.0
     *
     * @return Inbox items.
     */
    public function load_inbox_by_user_login($user_login)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE receiver = '" . esc_sql($user_login) . "' AND is_reply = 0 AND receiver_deleted = 0 ORDER BY id DESC", OBJECT);

        return $results;

    }


    /**
     * Get Outbox items by user login name.
     *
     * @since 2.0.0
     *
     * @return Outbox items.
     */
    public function load_outbox_by_user_login($user_login)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE sender = '" . esc_sql($user_login) . "' AND sender_deleted = 0 ORDER BY id DESC", OBJECT);

        return $results;

    }


    /**
     * Get Trash items by user login name.
     *
     * @since 2.0.0
     *
     * @return Trash items.
     */
    public function load_delete_items_by_user_login($user_login)
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'spm_message';

        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE (receiver = '" . esc_sql($user_login) . "' AND receiver_deleted = 1) OR (sender = '" . esc_sql($user_login) . "' AND sender_deleted = 1) ORDER BY id DESC", OBJECT);

        return $results;

    }


    /**
     * Save user personalize settings.
     *
     * @since 2.0.0
     */
    public function save_personalize_ajax_request()
    {

        if ($_POST) {

            $message = array();

            $meta_keys = $this->spm_user_meta_fields();

            foreach ($meta_keys as $meta_key) {

                $meta_value = get_user_meta(get_current_user_id(), $meta_key, TRUE);

                if ($meta_value != esc_attr(esc_sql($_POST[$meta_key]))) {

                    update_user_meta(get_current_user_id(), $meta_key, esc_sql($_POST[$meta_key]));

                }

            }

            $message['success'] = TRUE;
        }

        echo json_encode($message);

        exit;

    }


    /**
     * Get Outbox items by user login name.
     *
     * @since 2.0.0
     *
     * @return mixed.
     */
    public function load_personalize_by_user()
    {

        $meta_values = array();

        $meta_keys = $this->spm_user_meta_fields();

        foreach ($meta_keys as $meta_key) {

            $meta_values[$meta_key] = get_user_meta(get_current_user_id(), $meta_key, TRUE);
        }

        return $meta_values;

    }


    /**
     * Set HTML Content type for WP MAIL.
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function wpdocs_set_html_mail_content_type()
    {
        return 'text/html';
    }

}