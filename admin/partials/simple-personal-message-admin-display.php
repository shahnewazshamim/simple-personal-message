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
        <form action="options.php" class="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">
                        <i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;
                        <strong class="text-uppercase"><?php echo esc_html( get_admin_page_title() ); ?></strong>
                        <span class="label label-info"></span>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success btn-sm" id="btn-save-settings">
                            <i class="fa fa-check-circle"></i> Save Options
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body viewport-height">
                    <?php settings_fields('simple-personal-message-options'); ?>
                    <?php do_settings_sections('simple-personal-message-options'); ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <fieldset>
                                <legend>Message Limit</legend>
                                <div class="panel panel-default">
                                    <div class="panel-body text-muted">
                                        <?php foreach ($roles as $role) : ?>
                                            <div class="form-group">
                                                <label for="spm_message_send_limit<?= $role ?>" class="text-capitalize"><?= $role ?></label>
                                                <input type="number" class="form-control text-capitalize" id="spm_message_send_limit<?= $role ?>" name="spm_message_send_limit[<?= $role ?>]" placeholder="<?= $role ?> message sending limit" value="<?= $option[$role] ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <fieldset>
                                <legend>Notification Settings</legend>
                                <div class="panel panel-default">
                                    <div class="panel-body text-muted">
                                        <label for="spm_message_email_options" class="text-capitalize">Notify via Email</label>
                                        <select class="form-control selectpicker" name="spm_message_email_options" id="spm_message_email_options">
                                            <option value="1" <?= selected($email, 1)?>>Yes</option>
                                            <option value="0" <?= selected($email, 0)?>>No</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="text-muted text-center text-smaller">
                        &copy; Copyright <?= date('Y')?> | Powered by <a href="http://softyardbd.com" target="_blank">SoftyardLAB</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>