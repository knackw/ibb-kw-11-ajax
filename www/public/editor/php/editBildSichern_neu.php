<?php
include_once( "../../connection/connect.php" );
?>


<?php
$message = "";


$ueberschrift = $_POST[ 'ueberschrift' ];
$message .= "überschrift: " . $ueberschrift . "\n";
$fliesstext = $_POST[ 'fliesstext' ];
$message .= "fliesstext: " . $fliesstext . "\n";
$autor = $_POST[ 'autor' ];
$message .= "autor: " . $autor . "\n";
$kategorie = $_POST[ 'kategorie' ];
$message .= "kategorie: " . $kategorie . "\n";
$datum = $_POST[ 'datum' ];
$message .= "datum: " . $datum . "\n";
$ID = $_POST[ 'ID' ];
$nummer = $_POST[ 'nummer' ];

$oldquelle = $_POST[ 'oldquelle' ];
$message .= "oldquelle: " . $oldquelle . "\n";


if ( isset( $_FILES[ 'bild' ] ) == true && $oldquelle != $_FILES[ 'bild' ][ 'name' ] ) {

	$tmp = date( "U" );
	$zufname = md5( $tmp );
	$bildquelle = substr( $zufname, 0, 10 );
	$message .= "bild da.." . $zufname . "\n";
} else {
	$bildquelle = $oldquelle;
	$message .= "altes bild da.." . $oldquelle . "\n";
}


//bildhandling


$sql = "UPDATE bilder
SET bildUeberschrift='$ueberschrift', bildFliesstext='$fliesstext', bildAutor='$autor', bildKategorie='$kategorie', bildDatum='$datum' , bildNummer='$nummer', bildQuelle='$bildquelle'
WHERE bildID='$ID'";

$message .= $sql . "\n";

if ( $conn->query( $sql ) === TRUE ) {
	$message .= "Update record successfully\n";


	if ( isset( $_FILES[ 'bild' ] ) == true ) {
		if ( @unlink( "../../bilder/thumbs/" . $bildquelle . ".jpg" ) == true ) {
			$message .= "icon loeschen ok\n";
			if ( @unlink( "../../bilder/" . $bildquelle . ".jpg" ) == true ) {
				$message .= "bild loeschen ok\n";

				//neues bild kontrolle
				if ( $_FILES[ 'bild' ][ 'type' ] != "image/jpeg" ) {
					$message .= "falscher bildtyp \n";
				} else if ( $_FILES[ 'bild' ][ 'size' ] > 2 * 1024 * 1024 ) {
					$message .= "bild zu gross \n";
				}
			} else {
				move_uploaded_file( $_FILES[ 'bild' ][ 'tmp_name' ], "../../bilder/" . $bildquelle . ".jpg" );

				//icon erzeugen
				$bildpfad = "../../bilder/" . $bildquelle . ".jpg";
				$info = getimagesize( $bildpfad );
				$hoehe = 200;
				$faktor = $hoehe / $info[ 1 ];
				$breite = intval( $info[ 0 ] * $faktor );

				$image_p = imagecreatetruecolor( $breite, $hoehe );
				$image = imagecreatefromjpeg( $bildpfad );
				$imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $breite, $hoehe, $info[ 0 ], $info[ 1 ] );
				$smallfile = "../../bilder/thumbs/" . $bildquelle . ".jpg";

				if ( imagejpeg( $image_p, $smallfile, 100 ) == true ) {
					$message .= "icon speichern ok\n";
				} else {
					$message .= "icon speichern error\n";
				}
			}
		
		} else {
			$message .= "icon loeschen error\n";
		}
		
		
		
	} else {
		$message .= "kein neues bild vorhanden\n";
	}




} else {
	$message .= "Error: " . $sql . "\n" . $conn->error;
}
$conn->close();


echo json_encode( $message );