<?php
	include_once("../../connection/connect.php");
?>

<?php
$message = "";

$bilderArray = array();
$counter = 0;

$sql = "SELECT * FROM bilder";
$result = $conn->query($sql);

if (!empty($result) && $result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $message .= "bildId: " . $row["bildID"] . "\n";
	$message .= "bildUeberschrift: " . $row["bildUeberschrift"] . "\n";
	$message .= "bildquelle: " . $row["bildQuelle"]. "\n";
	$message .= "bildfliesstext: " . $row["bildFliesstext"]. "\n";
	$message .= "bildautor: " . $row["bildAutor"]. "\n";
	$message .= "bildkategorie: " . $row["bildKategorie"]. "\n";
	$message .= "bilddatum: " . $row["bildDatum"]. "\n";
	  $message .= "bildstamp: " . $row["bildStamp"]. "\n";
	   $message .= "bildnummer: " . $row["bildNummer"]. "\n";
	$message .= "=====================\n";
	//ein bild eigenschaften speichern in assoziation array  
	$einBild = array();
	$einBild['bildID'] =  $row["bildID"];
	$einBild['bildUeberschrift'] =  $row["bildUeberschrift"];  
	$einBild['bildQuelle'] =  $row["bildQuelle"]; 
	$einBild['bildFliesstext'] =  $row["bildFliesstext"];
	$einBild['bildAutor'] =  $row["bildAutor"]; 
	$einBild['bildKategorie'] =  $row["bildKategorie"];
	  $einBild['bildStamp'] =  $row["bildStamp"];
	  $einBild['bildDatum'] =  $row["bildDatum"];
	  $einBild['bildNummer'] =  $row["bildNummer"];
	//assoziation im indizierten array ablegen  
	array_push($bilderArray, $einBild);   
  }
} else {
  $message .= "0 results";
}
$conn->close();

$sendArray = array();
$sendArray['message'] = $message;
$sendArray['bilderArray'] = $bilderArray;

echo json_encode($sendArray);
?>