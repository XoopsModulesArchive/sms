<?php

require_once 'admin_header.php';
xoops_cp_header();

function config()
{
    global $_POST;

    OpenTable();

    if ($_POST['myaddress']) {
        $myaddress = $_POST['myaddress'];

        $content = "<?php\n";

        $content .= "\$SMSConfig['myaddress'] = \"$myaddress\" \n";

        $content .= '?>';

        $filename = '../cache/config.php';

        if ($file = fopen($filename, 'wb')) {
            fwrite($file, $content);

            fclose($file);
        } else {
            redirect_header('index.php', 1, _NOTUPDATED);

            exit();
        }

        // reload index.php with a ‘write successful’ message

        redirect_header('index.php', 1, _UPDATED);

        exit();
    }  

    include '../cache/config.php';

    echo "<form method='post' action='" . _PHP_SELF . "?op=config'>" . _MA_SMS_MYADDRESS . "<br>
			<input type='text' name='myaddress' value='" . $SMSConfig['myaddress'] . "' size='32'><br>
			<input type='submit' value='" . _SUBMIT . "'></form>";

    CloseTable();
}

/**
 * Create search box for service
 */
function serviceSearch()
{
    echo "<form method='post' action='index.php?op=serviceSearch'>
		<b>" . _MA_SMS_SEARCH . "</b><br>
		<input type='text' name='query'><br>
		<input type='submit' value='" . _SUBMIT . "'>
		</form>";
}

/**
 * Delete a service
 */
function serviceDel()
{
    global $id, $_POST, $service_array;

    $newcount = $service_array['count'] - 1;

    echo $newcount;

    $content = "<?php\n";

    $content .= "//service count \n";

    $content .= "\$service_array['count'] = " . (int)$newcount . ";\n";

    $content .= "//service \n";

    $i = 0;

    foreach ($service_array as $number => $temp_array) {
        if ('count' != $number) {
            if ($number != $id) {
                $i++;

                $content .= '$service_array[' . $i . "]['name'] = '" . $temp_array['name'] . "';\n";

                $content .= '$service_array[' . $i . "]['email'] = '" . $temp_array['email'] . "';\n";
            }
        }
    }

    $content .= '?>';

    $filename = '../cache/service.php';

    if ($file = fopen($filename, 'wb')) {
        fwrite($file, $content);

        fclose($file);
    } else {
        redirect_header('index.php', 1, _NOTUPDATED);

        exit();
    }

    redirect_header('index.php', '2', _UPDATED);

    exit();
}

/**
 * Edit service
 * @param mixed $array
 */
function serviceEdit($array)
{
    global $id, $op, $myts, $_POST, $service_array;

    if (($_POST['name']) && ('' != trim($_POST['name']))
        && ($_POST['email'])
        && ('' != trim($_POST['email']))) {
        $name = trim($_POST['name']);

        $email = trim($_POST['email']);

        $content = "<?php\n";

        $content .= "//service count \n";

        $content .= "\$service_array['count'] = " . (int)$service_array['count'] . ";\n";

        $content .= '//service' . "\n";

        foreach ($service_array as $number => $temp_array) {
            if ('count' != $number) {
                if ($number != $id) {
                    $content .= '$service_array[' . $number . "]['email'] = '" . $temp_array['email'] . "';\n";

                    $content .= '$service_array[' . $number . "]['name'] = '" . $temp_array['name'] . "';\n";
                } else {
                    $content .= '$service_array[' . $number . "]['email'] = '" . $email . "';\n";

                    $content .= '$service_array[' . $number . "]['name'] = '" . $name . "';\n";
                }
            }
        }

        $content .= '?>';

        $filename = '../cache/service.php';

        if ($file = fopen($filename, 'wb')) {
            fwrite($file, $content);

            fclose($file);
        } else {
            redirect_header('index.php', 1, _NOTUPDATED);

            exit();
        }

        redirect_header('index.php', 1, _UPDATED);

        exit();
    }  

    echo "<form method='post' action='index.php?op=serviceEditit'>
			<b>" . _MA_SMS_EDIT . '</b><br>
			' . _MA_SMS_SERVICE_NAME . "
			<input type='text' value='" . $array[$id]['name'] . "' name='name'><br>
			" . _MA_SMS_EMAIL . "
			<input type='text' name='email' value ='" . $array[$id]['email'] . "'><br>
			<input type='submit' value='" . _UPDATE . "'>
			<input type='hidden' name='id' value='" . $id . "'></form>";
}

/**
 * Function to add a new service
 */
function serviceAdd()
{
    global $op, $myts, $_POST, $service_array;

    if (($_POST['name']) && ('' != trim($_POST['name']))
        && ($_POST['email'])
        && ('' != trim($_POST['email']))) {
        $name = trim(htmlentities($_POST['name'], ENT_QUOTES | ENT_HTML5));

        $email = trim(htmlentities($_POST['email'], ENT_QUOTES | ENT_HTML5));

        $new_count = $service_array['count'] + 1;

        $content = "<?php\n";

        $content .= "//service count\n";

        $content .= "\$service_array['count'] = " . (int)$new_count . ";\n";

        $content .= "//service\n";

        if (is_array($service_array)) {
            foreach ($service_array as $number => $temp_array) {
                if ('count' != $number) {
                    $content .= '$service_array[' . $number . "]['email'] = '" . $temp_array['email'] . "';\n";

                    $content .= '$service_array[' . $number . "]['name'] = '" . $temp_array['name'] . "';\n";
                }
            }
        }

        $content .= '$service_array[' . $new_count . "]['email'] = '" . $email . "';\n";

        $content .= '$service_array[' . $new_count . "]['name'] = '" . $name . "';\n";

        $content .= '?>';

        $filename = '../cache/service.php';

        if ($file = fopen($filename, 'wb')) {
            fwrite($file, $content);

            fclose($file);
        } else {
            redirect_header('index.php', 1, _NOTUPDATED);

            exit();
        }

        redirect_header('index.php', 1, _UPDATED);

        exit();
    }  

    // echo "<table width='90%'>";

    echo "<form method='post' action='index.php?op=serviceAddit'><b>" . _MA_SMS_NEWSERVICE . '</b><br>' . _MA_SMS_SERVICE_NAME . "
			<input type='text' value='' name='name'><br>" . _MA_SMS_EMAIL . "
			<input type='text' value='' name='email'><br>
			<input type='submit' value='" . _ADD . "'></form>";
}

/**
 * Function to list services
 */
function serviceList()
{
    global $db, $op, $sortby, $query, $limit, $service_array, $startwith;

    if ('serviceSearch' == $op) {
        if ('' != trim($query)) {
            foreach ($service_array as $number => $temp_array) {
                if ('count' != $number) {
                    foreach ($temp_array as $key => $value) {
                        if (preg_match(mb_strtoupper(stripslashes($query)), mb_strtoupper(stripslashes($value)))) {
                            $service_result_array[$number] = $temp_array;
                        }
                    }
                }
            }
        }
    } else {
        if ($service_array['count'] > 0) {
            $service_result_array = $service_array;
        }
    }

    if (!$limit) {
        $limit = 10;
    }

    if (!$startwith) {
        $startwith = 0;
    }

    if (is_array($service_result_array)) {
        foreach ($service_result_array as $number => $temp_array) {
            if ('count' != $number && is_array($temp_array)) {
                $name_array[$number] = $temp_array['name'];

                $service_array[$number] = $temp_array['email'];
            }
        }

        unset($service_result_array);

        switch ($sortby) {
            case 'service':
                asort($service_array);
                foreach ($service_array as $number => $email) {
                    if ($name_array[$number]) {
                        $service_result_array[$number]['email'] = $email;

                        $service_result_array[$number]['name'] = $name_array[$number];
                    }
                }
                break;
            default:
                asort($name_array);
                foreach ($name_array as $number => $name) {
                    $service_result_array[$number]['name'] = $name;

                    $service_result_array[$number]['email'] = $service_array[$number];
                }
                break;
        }
    }

    OpenTable();

    echo '<h4>' . _MA_SMS_SERVICE . '</h4>';

    serviceSearch();

    echo '<hr>
		<table width="90%">
		<tr class="bg2">
			<td><a href="index.php?sortby=name&query=' . $query . '">
					<b>' . _MA_SMS_SERVICE_NAME . '</b></a></td>	
			<td><a href="index.php?sortby=service&query=' . $query . '">
					<b>' . _MA_SMS_EMAIL . '</b></a></td>
			<td align="right"><b>' . _FUNCTION . '</b></td></tr>';

    if (is_array($service_result_array)) {
        $i = 0;

        $limit += $startwith;

        foreach ($service_result_array as $number => $temp_array) {
            $i++;

            if (($i <= $limit) && $i >= $startwith) {
                echo '<tr>
					<td>' . $temp_array['name'] . '</td>
					<td>' . $temp_array['email'] . '</td>
					<td align="right">
						<a href="index.php?op=serviceEdit&id=' . $number . '&startwith=' . $startwith . '">' . _EDIT . '
						</a> | <a href="index.php?op=serviceDel&id=' . $number . '">' . _DELETE . '</a>
					</td></tr>';
            } // EndIf
        } // EndForEach
    } else {
        echo '<tr><td align="center" colspan="3">' . _MA_SMS_NOSERVICEFOUND . '</td></tr>';
    } // EndIf

    echo '<tr>';

    echo '<td>';

    if ($startwith > 0) {
        echo '<a href="index.php?sortby=' . $sortby . '&query=' . $query . '&startwith=' . ($startwith - 11) . '"><<</a>';
    } // EndIf

    echo '</td><td>&nbsp;</td>';

    echo '<td align="right">';

    if ($limit < $service_array['count']) {
        echo '<a href="index.php?sortby=' . $sortby . '&query=' . $query . '&startwith=' . ($limit + 1) . '">>></a>';
    } // EndIf

    echo '</td></tr></table>';

    echo '<hr>';

    if ('serviceEdit' != $op) {
        serviceAdd();
    } else {
        serviceEdit($service_result_array);
    } // EndIf

    CloseTable();

    xoops_cp_footer();
}

/**
 * Case statement
 */
if (!empty($_POST['op'])) {
    $op = $_POST['op'];
} elseif (!empty($_GET['op'])) {
    $op = $_GET['op'];
}

switch ($op) {
    case 'config':
        config();
        break;
    case 'serviceAddit':
        serviceAdd();
        break;
    case 'serviceEditit':
        serviceEdit(0);
        break;
    case 'serviceDel':
        serviceDel();
        break;
    default:
        serviceList();
        break;
}

xoops_cp_footer();
