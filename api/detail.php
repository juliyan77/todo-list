<?php

header("Content-Type: application/json");

include "../config/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM tugas WHERE id='$id'");

$data = mysqli_fetch_assoc($query);

echo json_encode($data, JSON_PRETTY_PRINT);

?>