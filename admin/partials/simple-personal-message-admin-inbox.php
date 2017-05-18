<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Table list of inbox.
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
$inbox = new Simple_Personal_Message_Admin('', '');

if (isset($_REQUEST['action']) and isset($_REQUEST['message']) and !is_array($_REQUEST['message'])) {
    switch ($_REQUEST['action']) {
        case 'view' :
            $inbox->display_plugin_view_page();
            break;

        case 'read' :
            $inbox->mark_as_read($_REQUEST['message']);
            break;

        case 'unread' :
            $inbox->mark_as_unread($_REQUEST['message']);
            break;

        case 'delete' :
            $inbox->message_soft_delete($_REQUEST['message']);
            break;
    }
}

if (isset($_REQUEST['action']) and isset($_REQUEST['message'])) {
    switch ($_REQUEST['action']) {
        case 'deletes' :
            $inbox->bulk_message_soft_delete($_REQUEST['message']);
            break;

        case 'reads' :
            $inbox->bulk_message_mark_as_read($_REQUEST['message']);
            break;

        case 'unreads' :
            $inbox->bulk_message_mark_as_unread($_REQUEST['message']);
            break;

        case 'delete' :
            $inbox->message_soft_delete($_REQUEST['message']);
            break;
    }
}
?>

<div class="container-fluid admin-wrap">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left">
                    <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                    <strong class="text-uppercase"><?php echo esc_html( get_admin_page_title() ); ?></strong>
                    <span class="label label-info"></span>
	                <?php echo ($inbox->unread_count() > 0) ? '<span class="label label-info">' . $inbox->unread_count() . '</span>' : ''; ?>
                </div>
                <div class="pull-right">
                    <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                    <a href="<?= wp_nonce_url("?page=simple-personal-message-compose")?>" class="btn btn-success btn-sm"><i class="fa fa-send"></i></a>
                    <a href="<?= wp_nonce_url("?page=simple-personal-message")?>" class="btn btn-primary btn-sm"><i class="fa fa-envelope"></i></a>
                    <a href="<?= wp_nonce_url("?page=simple-personal-message-outbox")?>" class="btn btn-info btn-sm"><i class="fa fa-envelope-open"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body viewport-height">
                <form action="" method="post">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                    <?php
                    $inbox_list = new Simple_Personal_Message_Inbox_Items();
                    $inbox_list->prepare_items();
                    $inbox_list->display();
                    ?>
                </form>
            </div>
            <div class="panel-footer">
                <div class="text-muted text-center text-smaller">
                    &copy; Copyright <?= date('Y')?> | Powered by <a href="http://softyardbd.com" target="_blank">SoftyardLAB</a>
                </div>
            </div>
        </div>
    </div>
</div>