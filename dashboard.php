<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tugas"));
$selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as selesai FROM tugas WHERE status='Selesai'"));
$belum = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as belum FROM tugas WHERE status='Belum Selesai'"));

$persen = 0;

if($total['total'] > 0){
    $persen = round(($selesai['selesai']/$total['total'])*100);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-2">
📋 Dashboard To-Do List
</h2>

<p class="text-muted">
Selamat datang,
<b><?= $_SESSION['username']; ?></b>
</p>

<div class="row">

<div class="col-md-3">

<div class="card shadow border-0 bg-primary text-white">

<div class="card-body">

<h6>Total Tugas</h6>

<h2><?= $total['total']; ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0 bg-success text-white">

<div class="card-body">

<h6>Selesai</h6>

<h2><?= $selesai['selesai']; ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0 bg-warning">

<div class="card-body">

<h6>Belum</h6>

<h2><?= $belum['belum']; ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0 bg-dark text-white">

<div class="card-body">

<h6>Progress</h6>

<h2><?= $persen ?>%</h2>

</div>

</div>

</div>

</div>

<div class="card shadow mt-4">

<div class="card-header">

Grafik Status Tugas

</div>

<div class="card-body">

<canvas id="grafik"></canvas>

</div>

</div>

<div class="mt-4">

<a href="tugas.php" class="btn btn-primary">

Kelola Tugas

</a>

<a href="logout.php" class="btn btn-danger">

Logout

</a>

</div>

</div>

<script>

const ctx = document.getElementById('grafik');

new Chart(ctx, {

type: 'doughnut',

data: {

labels: ['Selesai','Belum'],

datasets: [{

data: [
<?= $selesai['selesai']; ?>,
<?= $belum['belum']; ?>
]

}]

}

});

</script>

</body>

</html>