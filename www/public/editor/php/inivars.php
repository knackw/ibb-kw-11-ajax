	<?php

	//echo phpinfo();
	$inivars = array();
	$inivars["maxanzahl"] = ini_get('max_file_uploads');
	//echo "maxanzahl files: " . $maxanzahl . "<br>";

	$inivars["post_max_size"] = ini_get('post_max_size');
	//echo "post max size: " . $post_max_size . "<br>";

	$inivars["upload_max_filesize"] = ini_get('upload_max_filesize');
	//echo "upload_max_filesize: " . $upload_max_filesize . "<br>";

	echo json_encode($inivars);
	?>
