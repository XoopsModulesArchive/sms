<?php

function show_block()
{
    include '../sms/cache/service.php';

    $title = _MB_SMS_TITLE;

    $content = "<form method='post' action='" . XOOPS_URL . "/modules/sms/index.php'>";

    $content .= _MB_SMS_YOURNAME . ': <br>';

    $content .= "<input type='text' name='sender' value='' size='15'><br>";

    $content .= _MB_SMS_SERVICE . '<br>';

    $content .= "<select size='1' name='service' >";

    $i = 0;

    foreach ($service_array as $number => $temp_array) {
        if ('count' != $number) {
            if ($number != $id) {
                $i++;

                $content .= "<option value='" . $temp_array['email'] . "'>" . $temp_array['name'] . '</option>';
            }
        }
    }

    $content .= '</select><br>';

    $content .= _MB_SMS_SENDTO . ': <br>';

    $content .= "<input type='text' name='sendto' size='15'><br>";

    $content .= '<em>' . _MB_SMS_COMPLETENO . '</em><br>';

    $content .= _MB_SMS_MESSAGE . ': <br>';

    $content .= "<textarea name='message' cols='15' rows='5' ></textarea>";

    $content .= "<input type='hidden' name='op' value='ds'><br>";

    $content .= "<input type='submit' name='submit' value='" . _SEND . "'></form>";

    $block['title'] = $title;

    $block['content'] = $content;

    return $block;
}

function send_block()
{
    $title = _MB_SMS_SENDME;

    $content = <<<EOT
<script language=JavaScript>
<!--
function goB(){
	h=window.name.preg_split("_");
	h[0]=parseInt(h[0])-1;
	window.name=h.join("_");
	history.back();
}
function goF(){
	h=window.name.preg_split("_");
	h[0]=parseInt(h[0])+1;
	window.name=h.join("_");
	history.forward();
}
function goL(s){h=window.name.preg_split("_");
	if(parseInt(h[0])<parseInt(h[1])){
		h[1]=h[0];
	}
	h[0]=parseInt(h[0])+1;
	h[1]=parseInt(h[1])+1;
	window.name=h.join("_");
	location.href="/u/"+s;
}
function initcharsleft() {
	charsleft(document.forms["send"].text);
}
function charsleft(field) {
	var chars = field.value.length;
	if (chars > 87) {
		field.value = field.value.substring(0,160);
		free = 0;
	} else {
		free = 87 - chars;
	}
	document.forms["send"].num.value = free;
}
//-->
</script>
EOT;

    $content .= "
	<form name='send' onsubmit=\"return goL('')\" 
		method=post action='" . XOOPS_URL . "/modules/sms/index.php?op'
		style='borders:0; padding:0' >
		" . _MB_SMS_YOURNAME . ":<br>
		<input type='hidden' name='op' value='me' >
		<input type='text' name='sender' size='16' value=''><br>
		" . _MB_SMS_MESSAGE . ":<br>
		<textarea name='message' cols='16' rows='5' wrap='virtual' 
			onkeypress=charsleft(this); 
			onkeydown=charsleft(this); 
			onblur=charsleft(this); 
			onkeyup=charsleft(this); 
			onfocus=charsleft(this); 
			onchange=charsleft(this);>
		</textarea>
		<br>" . _MB_SMS_CHARSLEFT . "
		<input style='text-align:right;' name=num onfocus=this.blur size=1 value=87><br>
		<input class=button type=submit name=submit value=" . _SEND . '>
	</form>';

    $block['title'] = $title;

    $block['content'] = $content;

    return $block;
}
