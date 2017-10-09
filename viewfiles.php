<?php
    $dir = getcwd();
    $dir .= "\\uploads\\";
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
				
				//echo '<br/>'.$i;
            }
        }
        closedir($dh);
		
		if ($i < 1) 
		{
			echo 'no files';
		}			
    }
?>