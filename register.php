<?php
session_start();

require_once './functions.php';

$userLogin = '';
$userName = '';
$userPasw = '';
$userPaswC = '';
$userMail = '';

if (!(isset($_POST['regFrm']) && $_POST['regFrm'] = 'y')) {
    header('Location:index.php');
    //exit();
}

if (isset($_POST['userLogin']))
    $userLogin = mysql_entities_fix_string($_POST['userLogin']);
if (isset($_POST['userName']))
    $userName = mysql_entities_fix_string($_POST['userName']);
if (isset($_POST['userPasw']))
    $userPasw = (mysql_entities_fix_string($_POST['userPasw']));
if (isset($_POST['userPaswС']))
    $userPaswC = (mysql_entities_fix_string($_POST['userPaswС']));
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
    $result_chk = dbQuery($query_chk);
    $userNotUniq = $result_chk->num_rows;

    if ($userNotUniq) {
        //echo 'Такой логин уже есть';            
    } else {
        $pasIns = sha1($userPasw);
        $query = "INSERT INTO t_users(log,pass,email,name) VALUES('$userLogin', '$pasIns', '$userMail', '$userName');";
        $result = dbQuery($query);
        $rows = $result->num_rows;
        $userInserted = getLastId();
    }
}

function checkLogin($log) {
    $val = trim($log);

    if ($val == '') {
        return 'Не введен логин.';
    } elseif (strlen($val) < 5) {
        return 'В логине должно быть не менее 5 символов.';
    } elseif (preg_match('/[^a-zA-Z0-9_-]/', $val)) {
        return 'В логине разрешены только a-z, A-Z, 0-9, - и _.';
    } else {
        return '';
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
    echo '<p style="background:red;">Такой пользователь уже есть!</p><br/>';
} else {
    echo 'Проверка уникальности прошла успешно!<br/>';
}
if ($userInserted) {
    echo 'Пользователь добавлен в БД!<br/>ID = ' . $userInserted;
    $_SESSION['login'] = $userLogin;
    $_SESSION['password'] = $userPasw;
} else {
    echo 'Пользователь <b>НЕ</b> добавлен в БД!<br/>';
}

echo '<a href="index.php">На главную</a>';
?>
    </body>
</html>
