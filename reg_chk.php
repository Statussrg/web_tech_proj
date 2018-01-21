<?php
$db_host = 'localhost';
$db_port = '3306';
$db_base = 'webtech';
$db_usr = 'root';
$db_pwd = '';

$db_conn = new mysqli($db_host, $db_usr, $db_pwd, $db_base, $db_port);
if ($db_conn->connect_error) {
    die('db Not connected /n' . $db_conn->connect_error);
}

$userLogin = '';
$userName = '';
$userPasw = '';
$userPaswC = '';
$userMail = '';

if (!(isset($_POST['regFrm']) && $_POST['regFrm'] = 'y')) {    
    header('Location:register_frm.html');
    exit();
}


if (isset($_POST['userLogin']))
    $userLogin = mysql_entities_fix_string($_POST['userLogin']);
if (isset($_POST['userName']))
    $userName = mysql_entities_fix_string($_POST['userName']);
if (isset($_POST['userPasw']))
    $userPasw = mysql_entities_fix_string($_POST['userPasw']);
if (isset($_POST['userPaswС']))
    $userPaswC = mysql_entities_fix_string($_POST['userPaswС']);
if (isset($_POST['userMail']))
    $userMail = mysql_entities_fix_string($_POST['userMail']);


$err = checkLogin($userLogin) .
        checkName($userName) .
        checkPasw($userPasw) .
        checkPaswEq($userPasw, $userPaswC) .
        checkEmail($userMail);




$userNotUniq = 0;
$userInserted = 0;
if ($err == '') {
    $query_chk = "SELECT * FROM t_users WHERE log = '$userLogin';";
    $result_chk = $db_conn->query($query_chk);
    if (!$result_chk)
        die($db_conn->error);
    $userNotUniq = $result_chk->num_rows;

    if /* ($rows_chk) */ ($userNotUniq) {
        //echo 'Такой логин уже есть';            
    } else {
        $query = "INSERT INTO t_users(log,pass,email,name) VALUES('$userLogin', '$userPasw', '$userMail', '$userName');";

        $result = $db_conn->query($query);
        if (!$result)
            die($db_conn->error);
        $rows = $result->num_rows;

        $userInserted = $db_conn->insert_id;
        //echo $rows;
        $result->close;
    }

    $db_conn->close;
}

function checkLogin($log) {
    $val = trim($log);

    if ($val == '') {
        return 'Не введен логин.';
    } elseif (strlen($val) < 5) {
        return 'В логине должно быть не менее 5 символов.';
    } elseif (preg_match('/[^a-zA-Z0-9_-]/', $val)) {
        return 'В логине разрешены только a-z, A-Z, 0-9, - и _.';
    } elseif (!checkLoginFree($val)) {
        return 'Логин занят.';
    } else {
        return '';
    }
}

function checkLoginFree($log) {
    if (trim($log)) {
        return TRUE;
    } /* здесь будем проверять уникальность в БД */ else {
        return FALSE;
    }
}

function checkName($nam) {
    return (trim($nam) == '') ? 'Не введено имя.' : '';
}

function checkPasw($pas) {
    $val = trim($pas);
    if ($val == '') {
        return 'Не введен пароль.';
    } elseif (strlen($val) < 6) {
        return 'В пароле должно быть не менее 6 символов.';
    } elseif (!preg_match('/[a-z]/', val) || !preg_match('/[A-Z]/', $val) || !preg_match('/[0-9]/', $val)) {
        return 'Пароль требует 1 символа из каждого набора a-z, A-Z и 0-9.';
    } else {
        return '';
    }
}

//db
function checkPaswEq($pas1, $pas2) {
    if ($pas1 != $pas2) {
        return 'Пароли не совпадают.';
    } else {
        return '';
    }
}

function checkEmail($email) {
    $val = trim($email);
    if ($val == '') {
        return 'Не введен адрес электронной почты.';
    } elseif (!((strpos($val, '.') > 0) && (strpos($val, '@') > 0)) || preg_match('/[^a-zA-Z0-9.@_-]/', $val)) {
        return 'Электронный адрес имеет неверный формат.';
    } else {
        return '';
    }
}

function dbQuery($query) {
    global $db_conn;
    $result = $db_conn->query($query);
    if (!$result) {
        die($db_conn->connect_error);
    }
    return $result;
}

function mysql_entities_fix_string(/* $connection, */ $string) {
    return htmlentities(mysql_fix_string(/* $db_conn, */ $string));
}

function mysql_fix_string(/* $connection, */ $string) {
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
    global $db_conn;
    return $db_conn->real_escape_string($string);
}
?>

<html>
    <head>
        <title>Проверка ввода</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        global $userLogin;
        global $userName;
        global $userPasw;
        global $userPaswC;
        global $userMail;
        global $err;
        if ($err != '') {
            echo '<p style="background: red; color: white;">';
            echo 'Проверка выявила ошибки:<br/>' . $err;
            echo 'Необходимо откорректировать ввод!<br/>';
        } else {
            echo '<p style="background: green; color: white;">';
            echo 'Проверено. Ввод коректный. Регистрируем польователя:<br/>';
        }

        echo 'login = ' . $userLogin . '<br/>' .
        'name = ' . $userName . '<br/>' .
        'pass = ' . $userPasw . '<br/>' .
        'pass2 = ' . $userPaswC . '<br/>' .
        'email = ' . $userMail;
        echo '</p>';

        global $userNotUniq;
        global $userInserted;

        if ($userNotUniq) {
            echo 'Такой пользователь уже есть!<br/>';
        } else {
            echo 'Проверка уникальности прошла успешно!<br/>';
        }
        if ($userInserted) {
            echo 'Ползователь добавлен в БД!<br/>ID = ' . $userInserted;
        } else {
            echo 'Ползователь <b>НЕ</b> добавлен в БД!<br/>';
        }
        ?>
    </body>
</html>
