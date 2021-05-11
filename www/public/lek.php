<?php
$myarray = array("vorname"=>"Jochen", "nachname"=>"berg");

$myarray = array();
$myarray["vorname"] = "Jochen";
$myarray['nachname'] = "Berg";


$indarray = array();
$indarray[0] = "jhgjhgj";
$indarray[1] = "jhasfsdfsdfgj";

$indarray = array(4,7,9,2,3, "hkjhk", $a);

$indarray = [4,7,9,2,3, "hkjhk", $a];
/*
$_GET['email']
	
$_POST['passwort']	
	
$_SESSION["id"]
	
$_FILES["bild"]
	
$_SERVER['PHP_SELF']	
*/

function asdf($vorname, $nachname) {
	//echo "machWas " . $vorname . " / " . $nachname;
	$name = $vorname . " " . $nachname;
	return $name;
}

$komplettname = asdf("jochen", "berg");
$komplettname = asdf($z1, $z2);
echo $komplettname;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Unbenanntes Dokument</title>
	
	<script>
	function asdf() {
		alert("machWas");
	}
		
	var myobj = new Object();
	myobj.vorname = "jochen";
	myobj.nachname = "berg";
		
	var myobj1 = {zahl1:345, zahl2:"igdfkshgkdsf"}	
	</script>
	
</head>

<body>
</body>
</html>