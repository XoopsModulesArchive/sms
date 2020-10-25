<?php

$modversion['name'] = 'SMS';
$modversion['dirname'] = 'sms';
$modversion['hasMain'] = 1;

$modversion['description'] = _MI_SMS_DESC;
$modversion['version'] = '0.2';
$modversion['author'] = 'Matnet <matnet@kedahonline.net>';
$modversion['credits'] = 'Bob Janes <bob@bobjanes.com>';
$modversion['license'] = 'GPL';
$modversion['official'] = 'No';
$modversion['image'] = 'images/sms_logo.gif';

//Blocks
$modversion['blocks'][1]['file'] = 'block-sms.php';
$modversion['blocks'][1]['show_func'] = 'show_block';
$modversion['blocks'][1]['name'] = _MB_SMS_TITLE;
$modversion['blocks'][1]['description'] = _MB_SMS_DESC;
$modversion['blocks'][2]['file'] = 'block-sms.php';
$modversion['blocks'][2]['show_func'] = 'send_block';
$modversion['blocks'][2]['name'] = 'send me SMS';
$modversion['blocks'][2]['description'] = 'another sms block';

//Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';
