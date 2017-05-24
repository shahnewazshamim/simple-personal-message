<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Message detail view.
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

global $wpdb;

$table = $wpdb->prefix . 'spm_message';

$id = esc_html( esc_sql( $_GET['message'] ) );

$message = $wpdb->get_results( "SELECT * FROM $table WHERE id = $id" );

$user = get_user_by( 'login', $message[0]->sender );

?>

<div class="container-fluid admin-wrap">

    <div class="row">

        <div class="panel panel-default">

            <div class="panel-body">

                <div class="media">

                    <div class="media-left">

                        <img width="95" height="95" class="media-object img-rounded"
                             src="<?php echo plugin_dir_url( __DIR__ ) . 'img/default.jpg' ?>"
                             alt="<?php echo $user->first_name . ' ' . $user->last_name; ?>">

                    </div>

                    <div class="media-body">

                        <h4 class="media-heading page-header"><?php echo $message[0]->subject; ?></h4>

                        <div class="btn-group btn-group-sm pull-right">

							<?php if ( $_REQUEST['page'] != 'simple-personal-message-outbox' ): ?>

                                <a class="btn btn-default" title="Reply"
                                   href="<?= wp_nonce_url( "?page=simple-personal-message-compose&action=reply&message=" . $id . "", 'reply-message_%s' ) ?>"><i
                                            class="fa fa-reply" aria-hidden="true"></i></a>

							<?php endif; ?>

                            <a class="btn btn-default" title="Forward"
                               href="<?= wp_nonce_url( "?page=simple-personal-message-compose&action=forward&message=" . $id . "", 'forward-message_%s' ) ?>"><i
                                        class="fa fa-share" aria-hidden="true"></i></a>

                            <a class="btn btn-danger" title="Delete"
                               href="<?= wp_nonce_url( "?page=" . $_REQUEST['page'] . "&action=delete&message=" . $id . "", 'delete-message_%s' ) ?>"><i
                                        class="fa fa-trash" aria-hidden="true"></i></a>

                        </div>

                        <em class="text-muted text-smaller">

							<?php echo $user->first_name . ' ' . $user->last_name . " &lt" . $message[0]->sender . "&gt <br>"; ?>

							<?php echo $message[0]->date; ?>

                        </em>

                        <hr>

                        <div class="">

							<?php echo do_shortcode( stripslashes( stripslashes( $message[0]->message ) ) ); ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>