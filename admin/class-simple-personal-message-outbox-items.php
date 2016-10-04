<?php

/**
 * The table view of outbox functionality of the plugin.
 *
 * @link       http://softyardbd.com/
 * @since      1.0.3
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/admin
 */

/**
 * The table view of outbox functionality of the plugin.
 *
 * Render the outbox table based on WP List Table class.
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/admin
 * @author     Md. Shamim Shahnewaz <shamimshahnewaz@outlook.com>
 */
class Simple_Personal_Message_Outbox_Items extends WP_List_Table
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
        parent::__construct($args);
    }


    /**
     * No message found alert.
     *
     * @since 1.0.3
     */
    public function no_items()
    {
        _e('<div class="text-center text-capitalize alert alert-danger">Sorry! There is No Message in your outbox.</div>');
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
     * @param object $item
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

            'view' => "<a href=" . wp_nonce_url("?page=" . $_REQUEST['page'] . "&action=view&message=" . $item['id'] . "", 'view-message_%s') . ">View</a>",

            'forward' => "<a href=" . wp_nonce_url("?page=simple-personal-message-compose&action=forward&message=" . $item['id'] . "", 'forward-message_%s') . ">Forward</a>",

            'delete' => "<a href=" . wp_nonce_url("?page=" . $_REQUEST['page'] . "&action=delete&message=" . $item['id'] . "", 'delete-message_%s') . ">Delete</a>",

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

            'deletes' => 'Delete',

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
     * Return outbox items into data array.
     *
     * @since 1.0.3
     *
     * @return array|mixed|object data array.
     */
    public function table_data()
    {

        $inbox_items = apply_filters('load_outbox_by_user_login', wp_get_current_user()->user_login);

        $inbox_items = json_decode(json_encode($inbox_items), TRUE);

        $this->data = $inbox_items;

        return $this->data;

    }
    

    /**
     * Process bulk action for 'deletes'.
     *
     * @since 1.0.3
     */
    public function process_bulk_action()
    {

        $action = $this->current_action();

        switch ($action) {

            case 'deletes' :

                //apply_filters('bulk_message_soft_delete', $_GET['message']);

                break;

            default :

                break;

        }

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