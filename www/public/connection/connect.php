 <?php
$servername = "database";
$username = "root";
$password = "root";
$dbname = "app_db";

define("SERVER", $servername);
define("USERNAME", $username);
define("PASSWORD", $password);
define("DB", $dbname);

// Create connection
$conn = null;
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>