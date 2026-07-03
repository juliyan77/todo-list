<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM tugas WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE tugas SET
        judul='$judul',
        deskripsi='$deskripsi',
        status='$status'
        WHERE id='$id'");

    header("Location: tugas.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card">

<div class="card-header">
<h3>Edit Tugas</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Judul</label>
<input type="text" name="judul" class="form-control"
value="<?= $row['judul']; ?>" required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="deskripsi" class="form-control"><?= $row['deskripsi']; ?></textarea>
</div>

<div class="mb-3">
<label>Status</label>

<select name="status" class="form-control">

<option value="Belum Selesai"
<?= ($row['status']=="Belum Selesai") ? "selected" : ""; ?>>
Belum Selesai
</option>

<option value="Selesai"
<?= ($row['status']=="Selesai") ? "selected" : ""; ?>>
Selesai
</option>

</select>

</div>

<button class="btn btn-warning" name="update">
Update
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