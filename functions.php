<?php

require_once './config.php';

// db
$db_conn = new mysqli($db_host, $db_usr, $db_pwd, $db_base, $db_port);
if ($db_conn->connect_error) {
    die('db Not connected /n' . $db_conn->connect_error);
}

function dbQuery($query) {
    global $db_conn;
    $result = $db_conn->query($query);
    if (!$result) {
        die($db_conn->connect_error);
    }
    return $result;
}

function getLastId() {
    global $db_conn;
    return $db_conn->insert_id;    
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

// список файлов
function filesGetList() {
    $fileList;

    $dir = getcwd();
    global $uplDir;
    $dir .= $uplDir;
    //$fileList = '<H2>Список файлов</H2><br/>'.$dir.'<br/><ul>';
    $fileList = '';
    if (is_dir($dir)) {
        $i = 0;
        if (($dh = opendir($dir)) !== false) {
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..')
                    continue;
               // ++$i;
                //$fileList .=  "<li>[".++$i ."] <a href = \"uploads/$file\">$file</a></li>";
                $fileList .=  "<li>[".++$i ."]$file</li>";
            }
        }
        closedir($dh);

        if ($i < 1) {
            $fileList .= '<li>no files</li>';
        }
    }
    $fileList .='<li><a href ="upload_frm.php">Загрузить ещё файл</a></li></ul>';
    return $fileList;
}

function filesUpload($fn, $fname) {

    $result = '';
    if(is_uploaded_file($fn))//Проверяем, загружен ли файл
    {

        global $uplDir;         // будем сохранять загружаемые файлы в эту директорию
        $uploaddir = getcwd() . $uplDir;        // имя файла оставим неизменным
        $destination = $uploaddir . $fname;

        // перемещаем файл из временной папки в выбранную директорию для хранения
        if (move_uploaded_file( $fn, $destination))
        {
            //print "Файл успешно загружен <br>";
            //$result = false;
        }
        else
        {
            $result = "Произошла ошибка при загрузке файла. Некоторая отладочная информация:<br>".
            print_r($_FILES);
        }

        header("Location:index.php");
    }

}

?>