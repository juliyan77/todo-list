<?php

session_start();
include "config/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM tugas WHERE id='$id'");

header("Location: tugas.php");

?>