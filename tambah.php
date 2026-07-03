<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    mysqli_query($conn, "INSERT INTO tugas (judul, deskripsi, status)
    VALUES ('$judul','$deskripsi','$status')");

    header("Location: tugas.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Tugas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card">

<div class="card-header">
<h3>Tambah Tugas</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Judul</label>
<input type="text" name="judul" class="form-control" required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="deskripsi" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Status</label>

<select name="status" class="form-control">

<option>Belum Selesai</option>
<option>Selesai</option>

</select>

</div>

<button class="btn btn-success" name="simpan">
Simpan
</button>

<a href="tugas.php" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

</div>

</body>
</html>