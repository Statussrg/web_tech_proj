<?php

session_start();
require_once './page.php';
require_once './functions.php';

$loggedIn = isset($_SESSION['login']);

if ($loggedIn) {
    if (isset($_GET['getfile'])) {
        if (!filesDownload($_GET['getfile']))
            ; /* {echo 'No file'} */
        unset($_GET['getfile']);
        header('Location:index.php');
    }
    elseif (isset($_GET['delfile'])) {
        if (!filesRemove($_GET['delfile']))
            {; /* echo 'No file' */}
        unset($_GET['delfile']);
        header('Location:index.php');
    }
}

echo htmlGetPage($loggedIn);
?>

