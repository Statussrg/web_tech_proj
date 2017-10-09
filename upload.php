<?php	  
	$uploaddir = getcwd();
    $uploaddir .= $_GLOBALS['UPLOAD_DIR'];	
    // будем сохранять загружаемые 
    // файлы в эту директорию
	$destination = $uploaddir . $_FILES['myfile']['name'];
    // имя файла оставим неизменным

	print "<pre>";
	if (move_uploaded_file( $_FILES['myfile']['tmp_name'], $destination)) 
	{ 
		/* перемещаем файл из временной папки в выбранную директорию для хранения */
		print "Файл успешно загружен <br>";
	} 
	else 
	{
		echo "Произошла ошибка при загрузке файла. Некоторая отладочная информация:<br>";
		print_r($_FILES);
	}
	print "</pre>"; 
?>