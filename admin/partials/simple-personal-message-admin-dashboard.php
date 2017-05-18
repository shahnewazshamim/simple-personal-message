<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Dashboard widget block.
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

$dashboard = new Simple_Personal_Message_Admin( '', '' );

$messagelimit = get_option( 'spm_message_send_limit' );

$total_sent = $dashboard->total_send();

$total_limit = ( (int) $messagelimit[ wp_get_current_user()->roles[0] ] == 0 ) ? '&infin;' : (int) $messagelimit[ wp_get_current_user()->roles[0] ];
$total_remain = '';
$margin = '';
if ( is_int( $total_limit ) ) {
	$total_remain = ( $total_limit - $total_sent );
	$margin       = floor( $total_limit * 85 / 100 );
} else {

}

$status = '';

if ( $total_sent >= $margin && $total_remain != 0 ) {

	$status = 'warning';

} else if ( $total_remain == 0 ) {

	$status = 'error';

} else {

	$status = 'success';

}

?>

<div class="spm-dashboard-message">

    <div class="spm-badge spm-badge-success">

        <p class="counter"><?= ( $total_sent < 10 ) ? '0' . $total_sent : $total_sent ?></p>

        <p class="block">Sent Message</p>

    </div>

    <div class="spm-badge spm-badge-<?= $status ?>">

        <p class="counter"><?= ( $total_limit == '&infin;' ) ? $total_limit : $total_remain ?></p>

        <p class="block">Now Remaining</p>

    </div>

    <div class="spm-badge spm-badge-success">

        <p class="counter"><?= ( $total_limit < 10 && $total_limit != '&infin;' ) ? '0' . $total_limit : $total_limit ?></p>

        <p class="block">Sending Limit</p>

    </div>

</div>