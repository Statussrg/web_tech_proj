<?php

/* @var $idx_page type */
$idx_page = <<<_PAGE
<!DOCTYPE HTML>
<HTML>
	<HEAD>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<TITLE>File Hosting</TITLE>
	</HEAD>
	<BODY>
		<H1>Hello, files</H1>
	</BODY>
</HTML>
_PAGE;
    
    if (isset($_COOKIE['username']))
    {
        echo $idx_page;
        require_once 'config.inc';
        include_once 'viewfiles.php';
        echo '<a href ="logout.php">Завершить работу</a>';
    }
    else echo '<a href ="login_frm.php">Залогиньтесь</a> '.
              'или <a href ="register_frm.php">зарегистрируйтесь</a>';

?>