<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Table list of outbox.
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
$outbox = new Simple_Personal_Message_Admin('', '');
if (isset($_REQUEST['action']) and isset($_REQUEST['message']) and !is_array($_REQUEST['message'])) {
    if ($_REQUEST['action'] == 'view') {
        $outbox->display_plugin_view_page();
    }
    if ($_REQUEST['action'] == 'delete') {
        $outbox->message_soft_delete($_REQUEST['message']);
    }
}
if (isset($_REQUEST['action']) and isset($_REQUEST['message'])) {
    if ($_REQUEST['action'] == 'deletes') {
        $outbox->bulk_message_soft_delete($_REQUEST['message']);
    }
}
?>

<div class="container-fluid admin-wrap">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left">
                    <i class="fa fa-envelope-open" aria-hidden="true"></i>&nbsp;
                    <strong class="text-uppercase"><?php echo esc_html( get_admin_page_title() ); ?></strong>
                    <span class="label label-info"></span>
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
                    $outbox_list = new Simple_Personal_Message_Outbox_Items();
                    $outbox_list->prepare_items();
                    $outbox_list->display();
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