<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Trash list view.
 *
 * @link       http://softyardbd.com/
 * @since      2.0.0
 *
 * @package    Simple_Personal_Message
 * @subpackage Simple_Personal_Message/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

$trash = new Simple_Personal_Message_Admin('', '');

if (isset($_REQUEST['action']) and isset($_REQUEST['message']) and !is_array($_REQUEST['message'])) {

    if ($_REQUEST['action'] == 'restore') {

        $trash->message_restore($_REQUEST['message']);

    }

    if ($_REQUEST['action'] == 'delete') {

        $trash->message_delete_permanently($_REQUEST['message']);

    }

}

if (isset($_REQUEST['action']) and isset($_REQUEST['message'])) {

    if ($_REQUEST['action'] == 'restores') {

        $trash->bulk_message_restore($_REQUEST['message']);

    }

    if ($_REQUEST['action'] == 'deletes') {

        $trash->bulk_message_delete_permanently($_REQUEST['message']);

    }

}

?>

<div class="container-fluid admin-wrap">

    <div class="row">

        <div class="panel panel-default">

            <div class="panel-heading">

                <strong><?php echo esc_html(get_admin_page_title()); ?></strong>

            </div>

            <div class="panel-body">

                <form action="" method="post">

                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>

                    <?php

                    $trash_list = new Simple_Personal_Message_Trash_Items();

                    $trash_list->prepare_items();

                    $trash_list->display();
                    
                    ?>

                </form>

            </div>

            <div class="panel-footer"></div>

        </div>

    </div>

</div>