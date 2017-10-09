<?php
require_once 'config.inc';
    $dir = getcwd();
    $dir .= $_GLOBALS['UPLOAD_DIR'];
	echo '<HR>';
    echo '<H2>Список файлов</H2>';
    if(is_dir($dir))
	{
		$i = 0;
        if(($dh = opendir($dir)) !== false)
		{
            while(($file = readdir($dh)) !== false)
			{
                if($file == '.' || $file == '..') continue;				
                echo ++$i.". <A HREF = \"uploads/$file\">$file</A></BR>";
            }
        }
        closedir($dh);
		
		if ($i < 1) 
		{
			echo 'no files';
		}			
    }
?>