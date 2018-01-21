<?php
session_start();
if /*(isset($_COOKIE['username']))*/
    (isset($_SESSION['login']))
    {
echo <<< _PAGE
    <!DOCTYPE HTML>
    <HTML>
        <HEAD>
            <TITLE>Загрузка файла</TITLE>
        </HEAD>
        <BODY>
            <FORM ENCTYPE="MULTIPART/FORM-DATA" ACTION="upload.php" METHOD="POST">
                <INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="30000" />
                <LABEL>Выберите файл:</LABEL>
                <INPUT TYPE="FILE" NAME="myfile" />
                <BR />
                <INPUT TYPE="SUBMIT" VALUE="Загрузить" />
            </FORM>
        </BODY>
    </HTML>		
_PAGE;
    }
    else header("Location:index.php");
    
?>