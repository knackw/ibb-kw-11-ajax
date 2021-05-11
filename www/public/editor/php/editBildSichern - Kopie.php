<?php
	include_once("../../connection/connect.php");
?>


<?php
$message = "";


$ueberschrift = $_POST['ueberschrift'];
$message .= "überschrift: " . $ueberschrift . "\n";
$fliesstext = $_POST['fliesstext'];
$message .= "fliesstext: " . $fliesstext . "\n";
$autor = $_POST['autor'];
$message .= "autor: " . $autor . "\n";
$kategorie = $_POST['kategorie'];
$message .= "kategorie: " . $kategorie . "\n";
$datum = $_POST['datum'];
$message .= "datum: " . $datum . "\n";
$ID = $_POST['ID'];
$nummer = $_POST['nummer'];

$sql = "UPDATE bilder
SET bildUeberschrift='$ueberschrift', bildFliesstext='$fliesstext', bildAutor='$autor', bildKategorie='$kategorie', bildDatum='$datum' , bildNummer='$nummer'
WHERE bildID='$ID'";

$message .= $sql . "\n";

if ($conn->query($sql) === TRUE) {
	$message .= "Update record successfully\n";
} else {
  	$message .= "Error: " . $sql . "\n" . $conn->error;
}
$conn->close();	
	

echo json_encode($message);