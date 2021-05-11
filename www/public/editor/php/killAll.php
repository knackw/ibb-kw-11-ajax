<?php

include_once("../../connection/connect.php");

$message = "";

function deleteDir($dirname) {
	global $message;
	$dateien = glob($dirname . '/*'); // Dateienamen holen
	foreach($dateien as $datei){ // Array durchlaufen mit foreach-Schleife
  		if(is_file($datei)) {
    		unlink($datei); // Alle Dateien löschen
		}
	}
	$message .= "verzeichen " . $dirname . " gelöscht\n";
}


$sql = "delete from bilder";
$result = $conn->query($sql);

if($result == true) {
	$message .= "Tabelle bilder löschen ok\n";
	//jetzt erst bilder löschen
	deleteDir("../../bilder/thumbs");
	deleteDir("../../bilder");
}

else {
	$message .= "Tabelle bilder löschen error\n";
}

echo json_encode($message);

?>