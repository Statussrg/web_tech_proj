<?php

session_start();
require_once './page.php';
//require_once './functions.php';

if (isset($_GET['getfile'])) {
    if (!filesDownload($_GET['getfile']))
        ; /* {echo 'No file'} */
}
elseif (isset($_GET['delfile'])) {
    if (!filesRemove($_GET['delfile']))
        ; /* {echo 'No file'} */
}

echo htmlGetHeader();
echo htmlGetPersonal(isset($_SESSION['login']));
echo htmlGetContent(isset($_SESSION['login']));
echo htmlGetFooter();
?>

