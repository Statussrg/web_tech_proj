<?php

session_start();
require_once './page.php';
require_once './functions.php';

echo htmlGetHeader();
echo htmlGetContent(isset($_SESSION['login']));
echo htmlGetFooter();

?>

     