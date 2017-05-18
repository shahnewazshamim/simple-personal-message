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
$trash = new Simple_Personal_Message_Admin( '', '' );

if ( isset( $_REQUEST['action'] ) and isset( $_REQUEST['message'] ) and ! is_array( $_REQUEST['message'] ) ) {
	if ( $_REQUEST['action'] == 'restore' ) {
		$trash->message_restore( $_REQUEST['message'] );
	}
	if ( $_REQUEST['action'] == 'delete' ) {
		$trash->message_delete_permanently( $_REQUEST['message'] );
	}
}

if ( isset( $_REQUEST['action'] ) and isset( $_REQUEST['message'] ) ) {
	if ( $_REQUEST['action'] == 'restores' ) {
		$trash->bulk_message_restore( $_REQUEST['message'] );
	}
	if ( $_REQUEST['action'] == 'deletes' ) {
		$trash->bulk_message_delete_permanently( $_REQUEST['message'] );
	}
}
?>

<div class="container-fluid admin-wrap">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left">
                    <i class="fa fa-trash" aria-hidden="true"></i>&nbsp;
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
					$trash_list = new Simple_Personal_Message_Trash_Items();
					$trash_list->prepare_items();
					$trash_list->display();
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