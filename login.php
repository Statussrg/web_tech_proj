<?php
    require_once 'functions.php';
    
    $UserLog = '';
    $UserPas = '';
    if(isset($_POST['ulog'])) $UserLog = ($_POST['ulog']);
    if(isset($_POST['upas'])) $UserPas = strip_tags($_POST['upas']);    
    
    //echo 'UL='.$UserLog;
    
    if ($UserLog)
    { 
        require_once ('config.inc');
        $conn = new mysqli($db_host, $db_usr, $db_pwd, $db_base, $db_port);
        if ($conn->connect_error) die($conn->connect_error);
        
        if($UserLog) $UserLog = mysql_entities_fix_string($conn, $UserLog);
        if($UserPas) $UserPas = sha1(mysql_entities_fix_string($conn,$UserPas));    

        $query = "SELECT * FROM t_users WHERE log = '$UserLog' and pass = '$UserPas';";

        $result = $conn->query($query);
        if (!$result) die ($conn-> error);

        $rows = $result->num_rows;
        //echo $rows;
        $result->close;
        $conn->close;        
        
        session_start();
        
        if ($rows)
        {
            setcookie('username', $UserLog, time() + 60 * 60 * 24 * 7, '/');
            setcookie('password', $UserPas, time() + 60 * 60 * 24 * 7, '/');
            $_SESSION['login'] = $UserLog;
            $_SESSION['password'] = $UserPas;         
            header ('Location: index.php');
        }
        else
        {
            header ('Location: login_frm.php');
        }        
    }    
?>