<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Personalize form.
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

$roles = array_keys(get_editable_roles());

$option = get_option('spm_message_send_limit');

$email = get_option('spm_message_email_options');

settings_fields('simple-personal-message-options');

do_settings_sections('simple-personal-message-options');

?>

<div class="container-fluid admin-wrap">

    <div class="row">

        <form action="options.php" class="form-horizontal" method="post">

            <div class="panel panel-info">

                <div class="panel-heading">

                    <strong><?php echo esc_html(get_admin_page_title()); ?></strong>

                </div>

                <div class="panel-body">

                    <?php settings_fields('simple-personal-message-options'); ?>

                    <?php do_settings_sections('simple-personal-message-options'); ?>

                    <?php foreach ($roles as $role) : ?>

                        <div class="form-group">

                            <label for="spm_message_send_limit<?= $role ?>" class="col-sm-2 control-label text-capitalize"><?= $role ?></label>

                            <div class="col-sm-9">

                                <input type="number" class="form-control text-capitalize" id="spm_message_send_limit<?= $role ?>" name="spm_message_send_limit[<?= $role ?>]" placeholder="<?= $role ?> message sending limit" value="<?= $option[$role] ?>">

                            </div>

                        </div>

                    <?php endforeach; ?>

                    <hr>

                    <div class="form-group">

                        <label for="spm_message_email_options" class="col-sm-2 control-label text-capitalize">Email Notification</label>

                        <div class="col-sm-9">

                            <label>

                                <input type="radio" class="form-control" id="spm_message_email_options" name="spm_message_email_options[enable]" value="enable" <?php checked($email['enable'], "enable"); ?>> Enable

                            </label>

                            <label>

                                <input type="radio" class="form-control" id="spm_message_email_options" name="spm_message_email_options[enable]" value="disable" <?php checked($email['enable'], "disable"); ?>> Disable

                            </label>

                        </div>

                    </div>

                </div>

                <div class="panel-footer">

                    <button type="submit" class="btn btn-info btn-block" id="btn-save-settings">

                        <i class="fa fa-wrench"></i> Save Options

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>