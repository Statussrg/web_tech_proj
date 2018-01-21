<?php

require_once './functions.php';
$uplresult = filesUpload($_FILES['myfile']['tmp_name'], $_FILES['myfile']['name']);
if ($uplresult) {
    echo $uplresult;
} else {
    header("Location:index.php");
}
?>