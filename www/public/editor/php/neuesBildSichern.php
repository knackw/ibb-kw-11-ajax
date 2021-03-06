<?php

include_once("../../connection/connect.php");

$message = "";

$ueberschrift = isset($_POST['ueberschrift']) ?: "";
$oldueberschrift = $ueberschrift;
$message .= "überschrift: " . $ueberschrift . "\n";
$fliesstext = isset($_POST['fliesstext']) ?: "";
$message .= "fliesstext: " . $fliesstext . "\n";
$autor = isset($_POST['autor']) ?: "";
$message .= "autor: " . $autor . "\n";
$kategorie = isset($_POST['kategorie']) ?: "";
$message .= "kategorie: " . $kategorie . "\n";
$datum = isset($_POST['datum']) ?: "";
$message .= "datum: " . $datum . "\n";
$nummer = isset($_POST['nummer']) ?: "";
$message .= "nummer: " . $nummer . "\n";

$anzahl = 0;
if (isset($_FILES['bild']['name'])) {
    $anzahl = count($_FILES['bild']['name']);
}
$message .= "anzahl bilder: " . $anzahl . "\n";


for ($a = 0; $a < $anzahl; $a++) {
    $bild = $_FILES['bild'];
    $bildname = $bild['name'][$a];
    $message .= "bildname: " . $bildname . "\n";
    $bilddata = $bild['tmp_name'][$a];
    $message .= "tmpname: " . $bilddata . "\n";

    //test auf fehler
    $fehlerstatus = false;
    //jpg testen
    $bildtype = $bild['type'][$a];
    $message .= "bildtyp: " . $bildtype . "\n";
    if ($bildtype == "image/jpeg") {
        $message .= "bildtype ok \n";
    } else {
        $message .= "bildtype error \n";
        $fehlerstatus = true;
    }
    //bildgroesse testen
    $bildsize = $bild['size'][$a];
    $message .= "bildgroesse: " . $bildsize . "\n";
    if ($bildsize > 2 * 1024 * 1024) {
        $message .= "bildgroesse error \n";
        $fehlerstatus = true;
    } else {
        $message .= "bildgroesse ok \n";
    }

    //wenn keine fehler dann....
    if ($fehlerstatus == false) {

        //neuern dateinamen erzeugen
        $zufname = md5($bildname . $a);
        $zufname = substr($zufname, 0, 10);

        //temporäre datei verschieben
        if (@move_uploaded_file($bilddata, "../../bilder/" . $zufname . ".jpg") == true) {
            $message .= "UPLOAD original OK\n";

            //icon erzeugen
            $bildpfad = "../../bilder/" . $zufname . ".jpg";
            $info = getimagesize($bildpfad);
            $message .= "breite bild: " . $info[0] . "\n";
            $message .= "höhe bild: " . $info[1] . "\n";
            $message .= "bildtype: " . $info[2] . "\n";
            $message .= "string: " . $info[3] . "\n";

            $hoehe = 200;
            $faktor = $hoehe / $info[1];
            $breite = $info[0] * $faktor;
            $message .= "breite: " . $breite . "\n";

            $image_p = imagecreatetruecolor($breite, $hoehe);
            $image = imagecreatefromjpeg($bildpfad);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $breite, $hoehe, $info[0], $info[1]);

            $smallFile = "../../bilder/thumbs/" . $zufname . ".jpg";
            if (imagejpeg($image_p, $smallFile, 100) == true) {
                $message .= "icon erzeugen ok\n";

                $sql = "INSERT INTO bilder (bildUeberschrift, bildQuelle, bildFliesstext, bildAutor, bildKategorie, bildDatum, bildNummer)
VALUES ('$ueberschrift', '$zufname', '$fliesstext', '$autor', '$kategorie', '$datum', '$nummer')";
                //unterschiede in serie
                $nummer += 5;
                $ueberschrift = $oldueberschrift . $nummer;

                $message .= $sql . "\n";

                if ($conn->query($sql) === TRUE) {
                    $message .= "New record created successfully\n";
                } else {
                    $message .= "Error: " . $sql . "\n" . $conn->error;
                }


            } else {
                $message .= "icon erzeugen ERROR\n";
            }
        } else {
            $message .= "ERROR bildupload original\n";
        }
    } else {
        $message .= "ERROR bildupload\n";
    }


}
$conn->close();


echo json_encode($message);

?>