<?php

session_start();
require_once 'functions.php';

$UserLog = '';
$UserPas = '';
if (isset($_POST['ulog']))
    $UserLog = strip_tags($_POST['ulog']);
if (isset($_POST['upas']))
    $UserPas = strip_tags($_POST['upas']);

if ($UserLog && $UserPas) {

    $UserLog = mysql_entities_fix_string(/* $db_conn, */ $UserLog);
    $UserPas = sha1(mysql_entities_fix_string(/* $db_conn, */ $UserPas));

    $query = "SELECT * FROM t_users WHERE log = '$UserLog' and pass = '$UserPas';";

    $result = dbQuery($query);
    $rows = $result->num_rows;

    if ($rows) {
        //setcookie('username', $UserLog, time() + 60 * 60 * 24 * 7, '/');
        //setcookie('username', $UserLog, time() + 600, '/');
        //setcookie('password', $UserPas, time() + 600, '/');
        $_SESSION['login'] = $UserLog;
        $_SESSION['password'] = $UserPas;
        //header('Location: index.php');
        //} else {
        //    header('Location: login_frm.php');
        //}
    } //else {
    //header('Location: login_frm.php');
}
header('Location: index.php');
?>