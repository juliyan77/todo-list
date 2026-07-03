<?php

header("Content-Type: application/json");

include "../config/koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM tugas ORDER BY id DESC");

$data = [];

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode([
    "status" => true,
    "message" => "Data berhasil diambil",
    "data" => $data
], JSON_PRETTY_PRINT);

?>