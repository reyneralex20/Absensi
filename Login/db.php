<?php
$serv = "localhost";
$unm = "root";
$pwd = "root1234";
$db_name = "absensi";
$conn = new mysqli($serv, $unm, $pwd, $db_name);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
