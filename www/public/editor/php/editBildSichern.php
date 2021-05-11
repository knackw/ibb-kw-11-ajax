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

$quelle = $_POST[ 'quelle' ];
$message .= "quelle: " . $quelle . "\n";


if ( isset( $_FILES[ 'bild' ] ) == true) {
	$message .= "neues bild da..\n";
} else {
	$message .= "neues bild nicht  da..\n";
}


$sql = "UPDATE bilder
SET bildUeberschrift='$ueberschrift', bildFliesstext='$fliesstext', bildAutor='$autor', bildKategorie='$kategorie', bildDatum='$datum' , bildNummer='$nummer', bildQuelle='$quelle'
WHERE bildID='$ID'";

$message .= $sql . "\n";

if ( $conn->query( $sql ) === TRUE ) {
	$message .= "Update record successfully\n";


	if ( isset( $_FILES[ 'bild' ]['size'] ) == true ) {
		
				//neues bild kontrolle
				if ( $_FILES[ 'bild' ][ 'type' ] != "image/jpeg" ) {
					$message .= "falscher bildtyp \n";
				} else if ( $_FILES[ 'bild' ][ 'size' ] > 2 * 1024 * 1024 ) {
					$message .= "bild zu gross \n";
				}
				else {
					if(move_uploaded_file( $_FILES[ 'bild' ][ 'tmp_name' ], "../../bilder/" . $quelle . ".jpg" ) == true) {
						$message .= " bild original ablegen ok\n";
						//icon erzeugen
						$bildpfad = "../../bilder/" . $quelle . ".jpg";
						$info = getimagesize( $bildpfad );
						$hoehe = 200;
						$faktor = $hoehe / $info[ 1 ];
						$breite = intval( $info[ 0 ] * $faktor );

						$image_p = imagecreatetruecolor( $breite, $hoehe );
						$image = imagecreatefromjpeg( $bildpfad );
						imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $breite, $hoehe, $info[ 0 ], $info[ 1 ] );
						$smallfile = "../../bilder/thumbs/" . $quelle . ".jpg";

						if ( imagejpeg( $image_p, $smallfile, 100 ) == true ) {
							$message .= "icon speichern ok\n";
						} else {
							$message .= "icon speichern error\n";
						}
					}
					else {
						$message .= " bild original ablegen error\n";
					}
				}

	} else {
		$message .= "kein neues bild\n";
	}
} else {
	$message .= "Error: " . $sql . "\n" . $conn->error;
}
$conn->close();


echo json_encode( $message );