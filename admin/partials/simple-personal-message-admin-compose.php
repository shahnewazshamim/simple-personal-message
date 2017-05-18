<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Compose message form.
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
$message = new Simple_Personal_Message_Admin( '', '' );
$groups  = $message->load_user_groups();
if ( isset( $_GET['message'] ) and $_GET['action'] ) {
	$id = esc_attr( esc_sql( $_GET['message'] ) );
	$message->mark_as_read( $id );
	$result  = $message->get_message_by_id( $id );
	$subject = $result[0]->subject;
	if ( $_GET['action'] == 'reply' ) {
		$sender  = $result[0]->sender . ',';
		$subject = 'Re: ' . $result[0]->subject;
	} else {
		if ( $_GET['action'] == 'forward' ) {
			$sender  = '';
			$subject = 'Fwd: ' . $result[0]->subject;
		}
	}
	$receiver = $result[0]->receiver;
	$date     = $result[0]->date;
	$header   = <<<HTML
        <br>
        <hr>
        <em>In: $date | $sender wrote following message -</em>
        <em>Subject: $subject</em>
HTML;
	$content  = $result[0]->message;
}
?>

<div id="divLoading"></div>
<div class="container-fluid admin-wrap">
    <div id="post-message"></div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left">
                    <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;
                    <strong class="text-uppercase"><?php echo esc_html( get_admin_page_title() ); ?></strong>
                    <span class="label label-info"></span>
                </div>
                <div class="pull-right">
                    <a href="javascript:void(0)" id="btn-send-message" class="btn btn-success btn-sm"><i
                                class="fa fa-send"></i> Send</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body viewport-height">
                <form action="" id="frm-compose" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt-sender" id="txt-sender"
                           value="<?php echo wp_get_current_user()->user_login; ?>">
					<?php if ( isset( $id ) ): ?>
                        <input type="hidden" name="txt-id" id="txt-id" value="<?php echo $id; ?>">
					<?php endif; ?>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group text-muted">
                                <label for="txt-receiver">Enter Receiver Name</label>
                                <input type="text" class="form-control" name="txt-receiver" id="txt-receiver"
                                       value="<?php echo isset( $sender ) ? $sender : '' ?>"
                                       placeholder="Type to get user name suggestion (Multiple user allowed)">
                            </div>
                            <div class="form-group text-muted">
                                <label for="txt-group">Select User Groups (If Needed / Also can send to all
                                    users)</label>
                                <select id="txt-group" name="txt-group" class="form-control selectpicker">
                                    <option value="">None</option>
                                    <option value="all">All Users</option>
									<?php foreach ( $groups as $group ) : ?>
                                        <option value="<?= $group->slug ?>"><?= $group->name ?></option>
									<?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group text-muted">
                                <label for="txt-subject">Message Subject</label>
                                <input type="text" class="form-control" name="txt-subject" id="txt-subject"
                                       value="<?php echo isset( $subject ) ? $subject : '' ?>"
                                       placeholder="Type a relevant Subject line">
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="form-group text-muted">
                                <!--<label for="txt-content">Message Content</label>-->
								<?php wp_editor( isset( $content ) ? do_shortcode( stripslashes( stripslashes( $header . $content ) ) ) : '', 'txt-content', array(
									'textarea_name' => 'txt-content',
									'height'        => '100vh'
								) ); ?>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="panel-footer">
                <div class="text-muted text-center text-smaller">
                    &copy; Copyright <?= date( 'Y' ) ?> | Powered by <a href="http://softyardbd.com" target="_blank">SoftyardLAB</a>
                </div>
            </div>
        </div>
    </div>
</div>