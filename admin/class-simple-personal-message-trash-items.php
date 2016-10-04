<?php

/**
 * The table view of trash functionality of the plugin.
 *
 * @link       http://softyardbd.com/
 * @since      1.0.3
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/admin
 */

/**
 * The table view of trash functionality of the plugin.
 *
 * Render the trash table based on WP List Table class.
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/admin
 * @author     Md. Shamim Shahnewaz <shamimshahnewaz@outlook.com>
 */
class Simple_Personal_Message_Trash_Items extends WP_List_Table
{

    /**
     * The array data of table.
     *
     * @since  1.0.3
     *
     * @access public
     * @var array
     */
    public $data = array();


    /**
     * Show per page message.
     *
     * @since  1.0.3
     *
     * @access public
     * @var integer
     */
    public $per_page;


    /**
     * Simple_Personal_Message_Inbox_Items constructor.
     *
     * @since 1.0.3
     *
     * @param string $args
     */
    public function __construct($args = '')
    {

        $args = array(

            'singular' => 'message',

            'plural' => 'messages',

            'ajax' => FALSE,

        );

        parent::__construct($args);

    }


    /**
     * No message found alert.
     *
     * @since 1.0.3
     */
    public function no_items()
    {
        _e('<div class="text-center text-capitalize alert alert-info">Sorry! There is No Message in your trash.</div>');
    }

    
    /**
     * Render checkbox for all rows.
     *
     * @since 1.0.3
     *
     * @param object $item The current list item.
     *
     * @return string
     */
    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="message[]" value="%s" />', $item['id']);
    }

    
    /**
     * Default column behaviour.
     *
     * @since 1.0.3
     *
     * @param object $item The current item.
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default($item, $column_name)
    {

        switch ($column_name) {

            case 'subject':

            case 'sender':

            case 'receiver':

            case 'date':

                return $item[$column_name];

            default:

                return print_r($item, TRUE);

        }

    }

    
    /**
     * Action links add to subject column.
     *
     * @since 1.0.3
     *
     * @param $item The current item.
     *
     * @return string Action links for each row.
     */
    public function column_subject($item)
    {

        $actions = array(

            'restore' => "<a href=" . wp_nonce_url("?page=" . $_REQUEST['page'] . "&action=restore&message=" . $item['id'] . "", 'restore-message_%s') . ">Restore</a>",

            'delete' => "<a href=" . wp_nonce_url("?page=" . $_REQUEST['page'] . "&action=delete&message=" . $item['id'] . "", 'delete-message_%s') . ">Delete Permanently</a>",

        );

        return sprintf('%1$s %2$s', $item['subject'], $this->row_actions($actions));

    }
    

    /**
     * Render bulk option drop down list.
     *
     * @since 1.0.3
     *
     * @return array <option> list.
     */
    public function get_bulk_actions()
    {

        return array(

            'restores' => 'Restore',

            'deletes' => 'Delete Permanently',

        );

    }
    

    /**
     * Prepare items to display such as pagination sorting.
     *
     * @since 1.0.3
     */
    public function prepare_items()
    {

        $columns = $this->get_columns();

        $hidden = $this->get_hidden_columns();

        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();

        $this->process_bulk_action();

        if (!empty($data)) {

            usort($data, array(&$this, 'sort_data'));

            $this->per_page = (get_user_meta(get_current_user_id(), 'spm_message_per_page', TRUE) != '') ? get_user_meta(get_current_user_id(), 'spm_message_per_page', TRUE) : 10;

            $currentPage = $this->get_pagenum();

            $totalItems = count($data);

            $pagination_args = array(

                'total_items' => $totalItems,

                'per_page' => $this->per_page,

            );

            $this->set_pagination_args($pagination_args);

            $data = array_slice($data, (($currentPage - 1) * $this->per_page), $this->per_page);

        }

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->items = $data;

    }
    

    /**
     * Return necessary columns for list table.
     *
     * @since 1.0.3
     *
     * @return array
     */
    public function get_columns()
    {

        return array(

            'cb' => '<input type="checkbox" />',

            'subject' => 'Subject',

            'sender' => 'Sender',

            'receiver' => 'Receiver',

            'date' => 'Date',

        );

    }
    

    /**
     * Return hidden columns.
     *
     * @since 1.0.3
     *
     * @return array
     */
    public function get_hidden_columns()
    {
        return array();
    }
    

    /**
     * Return sortable columns for list table.
     *
     * @since 1.0.3
     *
     * @return array
     */
    public function get_sortable_columns()
    {

        return array(

            'id' => array('id', FALSE),

            'subject' => array('subject', FALSE),

            'sender' => array('sender', FALSE),

            'receiver' => array('receiver', FALSE),

            'date' => array('date', FALSE),

        );

    }
    

    /**
     * Return inbox items into data array.
     *
     * @since 1.0.3
     *
     * @return array|mixed|object data array.
     */
    public function table_data()
    {

        $inbox_items = apply_filters('load_delete_items_by_user_login', wp_get_current_user()->user_login);

        $inbox_items = json_decode(json_encode($inbox_items), TRUE);

        $this->data = $inbox_items;

        return $this->data;

    }
    

    /**
     * Process bulk action for 'deletes', 'unreads' and 'reads'.
     *
     * @since 1.0.3
     */
    public function process_bulk_action()
    {

        $action = $this->current_action();

        switch ($action) {

            case 'restores' :

                //apply_filters('bulk_message_soft_delete', $_GET['message']);

                break;

            case 'removes' :

                //apply_filters('bulk_message_mark_as_read', $_GET['message']);

                break;

            default :

                break;

        }

    }
    

    /**
     * Generates content for a single row of the table
     *
     * @since 1.0.3
     *
     * @param object $item The current item.
     */
    public function single_row($item)
    {

        $style = ($item['status'] == 0) ? $this->get_unread_style() : $this->get_read_style();

        echo "<tr style='$style'>";

        echo $this->single_row_columns($item);

        echo "</tr>";

    }
    

    /**
     * Unread message style.
     *
     * @since 1.0.3
     *
     * @return string
     */
    public function get_unread_style()
    {
        $unread_style = "";

        $meta_keys = array(

            'spm_unread_row_font_style',
            'spm_unread_row_font_weight',
            'spm_unread_row_background',
            'spm_unread_row_text_decoration',
            'spm_unread_row_border',

        );

        $meta_values = array();

        foreach ($meta_keys as $meta_key) {

            $meta_values[$meta_key] = get_user_meta(get_current_user_id(), $meta_key, TRUE);

            $unread_style .= "$meta_values[$meta_key]; ";

        }

        return $unread_style;

    }
    

    /**
     * Read message style.
     *
     * @since 1.0.3
     *
     * @return string
     */
    public function get_read_style()
    {

        $read_style = "";

        $meta_keys = array(

            'spm_read_row_font_style',
            'spm_read_row_font_weight',
            'spm_read_row_background',
            'spm_read_row_text_decoration',
            'spm_read_row_border',

        );

        $meta_values = array();

        foreach ($meta_keys as $meta_key) {

            $meta_values[$meta_key] = get_user_meta(get_current_user_id(), $meta_key, TRUE);

            $read_style .= "$meta_values[$meta_key]; ";

        }

        return $read_style;

    }
    

    /**
     * Sorting data of table and Return result.
     *
     * @since 1.0.3
     *
     * @param $a
     * @param $b
     *
     * @return int
     */
    private function sort_data($a, $b)
    {

        $orderby = 'id';

        $order = 'desc';

        if (!empty($_GET['orderby'])) {

            $orderby = $_GET['orderby'];

        }

        if (!empty($_GET['order'])) {

            $order = $_GET['order'];

        }

        $result = strnatcmp($a[$orderby], $b[$orderby]);

        if ($order === 'asc') {

            return $result;

        }

        return -$result;

    }

}