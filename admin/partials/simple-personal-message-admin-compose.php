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
$groups = $message->load_user_groups();
if ( isset( $_GET['message'] ) and $_GET['action'] ) {
	$id = esc_attr( $_GET['message'] );
	$message->mark_as_read( $id );
	$result = $message->get_message_by_id( $id );
	$subject = $result[0]->subject;
	if ( $_GET['action'] == 'reply' ) {
		$sender = $result[0]->sender . ',';
		$subject = 'Re: ' . $result[0]->subject;
	} else {
		if ( $_GET['action'] == 'forward' ) {
			$sender = '';
			$subject = 'Fwd: ' . $result[0]->subject;
		}
	}
	$receiver = $result[0]->receiver;
	$date = $result[0]->date;
	$header = <<<HTML
        <br>
        <hr>
        <em>In: $date | $sender wrote following message -</em>
        <em>Subject: $subject</em>
HTML;
	$content = $result[0]->message;
}
?>

<div id="divLoading"></div>
<div class="container-fluid admin-wrap">
    <div id="post-message"></div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?php echo esc_html( get_admin_page_title() ); ?></strong>
            </div>
            <div class="panel-body">
                <form action="" id="frm-compose" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt-sender" id="txt-sender"
                           value="<?php echo wp_get_current_user()->user_login; ?>">
					<?php if ( isset( $id ) ): ?>
                        <input type="hidden" name="txt-id" id="txt-id" value="<?php echo $id; ?>">
					<?php endif; ?>
                    <div class="form-group">
                        <label for="txt-receiver">Enter Receiver Name</label>
                        <input type="text" class="form-control" name="txt-receiver" id="txt-receiver"
                               value="<?php echo isset( $sender ) ? $sender : '' ?>"
                               placeholder="Type to get user name suggestion (Multiple user allowed)">
                    </div>
                    <div class="form-group">
                        <label for="txt-group">Select User Groups (If Needed / Also can send to all users)</label>
                        <select id="txt-group" name="txt-group" class="form-control">
                            <option value="">None</option>
                            <option value="all">All Users</option>
							<?php foreach ( $groups as $group ) : ?>
                                <option value="<?= $group->slug ?>"><?= $group->name ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txt-subject">Message Subject</label>
                        <input type="text" class="form-control" name="txt-subject" id="txt-subject"
                               value="<?php echo isset( $subject ) ? $subject : '' ?>"
                               placeholder="Type a relevant Subject line">
                    </div>
                    <div class="form-group">
                        <label for="txt-content">Message Content</label>
						<?php wp_editor( isset( $content ) ? do_shortcode( stripslashes( stripslashes( $header . $content ) ) ) : '', 'txt-content', array( 'textarea_name' => 'txt-content' ) ); ?>
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <a href="javascript:void(0)" id="btn-send-message" class="btn btn-success btn-block">Send Message</a>
            </div>
        </div>
    </div>
</div>