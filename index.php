<?php
/**
 *         PHP-NUKE: SMS (Malaysia)
 *
 * @author: Matnet <matnet@kedahonline.net>
 * @url   : http://www.kedahonline.net
 * @date  : July 28 2003
 */

/**
 * This program is free software. You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License.
 */
/**
 *  This version modified for E-Xoops
 *  by Bob Janes bob@bobjanes.com
 *  11 Sept 2003 & 29 Sep 2003
 *
 *  Edited for Xoops 2.X
 *  Matt Wells
 *  Matt@Wells.VG
 */
include '../../mainfile.php';
include '../../header.php';
include '../../footer.php';
require_once 'cache/service.php';
require_once 'cache/config.php';
global $xoopsTheme, $xoopsModule, $HTTP_COOKIE_VARS;

####Send to Me Block

if ('me' == $op) {
    $sendto = $SMSConfig['myaddress'];

    if ($HTTP_COOKIE_VARS['sentmessage'] >= 2) {
        $send = 'no';
    } else {
        $num = $HTTP_COOKIE_VARS['sentmessage'] + 1;

        cookie('sentmessage', $num, time() + 24 * 60 * 60); //set the cookie

        $private = true;
    }
}
##End Send to me block
####Send SMS block

$form_block = "
<table>
<form method='post' action='./index.php'>
        <tr>
                <td>" . _MI_SMS_YOURNAME . ": </td>
                <td><input type='text' name='sender' value='" . $sender . "' size='30' ></td>
        <tr>
        <tr>
                <td>" . _MI_SMS_REPLY . ": </td>
                <td><input type='text' name='reply' value='" . $reply . "' size='30' ></td>
        <tr>

                <td>" . _MI_SMS_SERVICE . ": </td>
                <td>
                        <select size='1' name='service' >";
$i = 0;
foreach ($service_array as $number => $temp_array) {
    if ('count' != $number) {
        if ($number != $id) {
            $i++;

            $form_block .= "<option value='" . $temp_array['email'] . "'>" . $temp_array['name'] . '</option>';
        }
    }
}

$form_block .= '</select>
                </td>
        </tr>
        <tr>
                <td>' . _MI_SMS_SENDTO . ": </td>
                <td><input type='text' name='sendto' size='30'></td>
        </tr>
</table>
<em>" . _MI_SMS_COMPLETENO . '</em><br>
' . _MI_SMS_MESSAGE . ":<br>
<textarea name='message' cols='50' rows='5'></textarea>
<input type='hidden' name='op' value='ds'><br>
<input type='submit' name='submit' value='" . _SEND . "'><br>
";

$title = _MI_SMS_TITLE;

$content = '';
if (('ds' != $op) && ('me' != $op)) {
    $content .= $form_block;
} else {
    if ('' == $sender) {
        $sender_err = _MI_SMS_NONAME . '<br>';

        $send = 'no';
    }

    if ('' == $sendto) {
        $sendto_err = _MI_SMS_NONUMBER . '<br>';

        $send = 'no';
    }

    if ('' == $message) {
        $message_err = _MI_SMS_NOMESSAGE . '<br>';

        $send = 'no';
    }

    if ('no' != $send) {
        $msg .= "$message \n";

        $to = "$sendto$service";

        $subject = 'SMS message';

        $from = "From: $sender@WWW.Wells.VG";

        mail($to, $subject, $msg, $from);

        if ($private) {
            $to = $sendto;
        }

        $title = _MI_SMS_SMSERROR;

        $content .= _MI_SMS_THANKS . '<hr>';

        $content .= _MI_SMS_SENTTO . ": $to <br>$msg";
    } else {
        $title = _MI_SMS_SMSERROR;

        $content .= $sender_err;

        $content .= $sendto_err;

        $content .= $message_err;

        if ('me' == $op) {
            $content .= _MI_SMS_TOOMANY;
        }
    }

    $content .= "<hr>$form_block";
}

themecenterbox_center($title, $content);
require XOOPS_ROOT_PATH . '/footer.php';

?>
?>
