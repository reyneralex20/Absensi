<?php
$serv = "localhost";
// $unm = "id15024191_root";
$unm = "pmaroot";
// $pwd = "Ars!@#123database";
$pwd = "pmaroot";
$db_name = "id15024191_absensi";
$conn = new mysqli($serv, $unm, $pwd, $db_name);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  $table_absensi = "absensi";
  $table_user = "user";
  $jam_masuk = date("Y-m-d 06:45:00");
  $jam_pulang = date("Y-m-d 15:00:00");
}

?>