<?php    
    require_once 'functions.php';
    
    $UserLog = '';
    $UserPas = '';
    $UserMail = '';
    $UserName = '';
    /*if(eregi("^$SERVER_ROOT", $_SERVER['HTTP_REFERER'])){*/
    if(isset($_POST['rulog'])) $UserLog = $_POST['rulog'];
    if(isset($_POST['rupas'])) $UserPas = $_POST['rupas'];    
    if(isset($_POST['runame'])) $UserMail = $_POST['runame']; 
    if(isset($_POST['rumail'])) $UserName = $_POST['rumail']; 
    
    //echo 'UL='.$UserLog;
    
    if ($UserLog)
    { 
        require_once ('config.inc');
        $db_conn = new mysqli($db_host, $db_usr, $db_pwd, $db_base, $db_port);
        if ($db_conn->connect_error) die($db_conn->connect_error);        

        if($UserLog) $UserLog = mysql_entities_fix_string($db_conn, $UserLog);
        if($UserPas) $UserPas = sha1(mysql_entities_fix_string($db_conn,$UserPas));    
        if($UserMail) $UserMail = mysql_entities_fix_string($db_conn,$UserMail); 
        if($UserName) $UserName = mysql_entities_fix_string($db_conn,$UserName);         
        
        $query_chk = "SELECT * FROM t_users WHERE log = '$UserLog';";
        $result_chk = $db_conn->query($query_chk);
        if (!$result_chk) die ($db_conn-> error);
        $rows_chk = $result_chk->num_rows;
        
        if ($rows_chk)
        {
            //echo 'Такой логин уже есть';            
        }
        else
        {
            $query = "INSERT INTO t_users(log,pass,email,name) VALUES('$UserLog', '$UserPas', '$UserMail', '$UserName');";

            $result = $db_conn->query($query);
            if (!$result) die ($db_conn-> error);
            $rows = $result->num_rows;
            //echo $rows;
            $result->close;
        }       
        
        $db_conn->close;
        
        if ($rows_chk)
        {
            header ('Location: register_frm.html');
        }
        else
        {
            header ('Location: login_frm.php');
        }
    }    
        
?>