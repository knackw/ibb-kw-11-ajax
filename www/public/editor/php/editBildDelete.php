<?php
include_once("../../connection/connect.php");

?>


<?php
$message = "";


$ID = isset($_POST['ID'])?:"";
$quelle = isset($_POST['quelle'])?:"";
$message .= "id: " . $ID . "\nquelle: " . $quelle . "\n";
//////////////////////
//eintrag db löschen
/////////////////////
$sql = "delete from bilder where bildID='$ID'";
if ($conn->query($sql) === TRUE) {
	$message .= "delete record successfully\n";
	//wenn db eintrag gelöscht dann bilder löschen
	if(unlink("../../bilder/thumbs/" . $quelle . ".jpg") == true) {
		$message .= "bildicon gelöscht\n";
		if(unlink("../../bilder/" . $quelle . ".jpg") == true) {
			$message .= "bild gelöscht\n";
		}
		else {
			$message .= "bild löschen error\n";
		}
	} 
	else {
		$message .= "bildicon löschen error\n";
	}
	
	
} else {
  	$message .= "Error: " . $sql . "\n" . $conn->error;
}
$conn->close();	


echo json_encode($message);


?>