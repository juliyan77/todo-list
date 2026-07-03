<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// SEARCH + FILTER STATUS
$keyword = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : "";
$status  = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : "";

$sql = "SELECT * FROM tugas WHERE 1=1";

if ($keyword != "") {
    $sql .= " AND (judul LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%')";
}

if ($status != "") {
    $sql .= " AND status='$status'";
}

$sql .= " ORDER BY id DESC";

$data = mysqli_query($conn, $sql);
$total = mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data To-Do List</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f5f5;
}
.card{
    border-radius:15px;
}
.table tbody tr:hover{
    background:#f0f8ff;
}
</style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3 class="mb-0">📋 Data To-Do List</h3>
</div>

<div class="card-body">

<!-- BUTTON -->
<div class="d-flex justify-content-between mb-3">

<div>
<a href="dashboard.php" class="btn btn-secondary">🏠 Dashboard</a>
<a href="tambah.php" class="btn btn-success">➕ Tambah Tugas</a>
</div>

<div>
<span class="badge bg-primary fs-6">
Total : <?= $total ?> Tugas
</span>
</div>

</div>

<!-- SEARCH + FILTER -->
<form method="GET" class="row mb-4">

<div class="col-md-5">
<input type="text" name="cari" class="form-control"
placeholder="🔍 Cari judul atau deskripsi..."
value="<?= htmlspecialchars($keyword) ?>">
</div>

<div class="col-md-3">
<select name="status" class="form-select">
<option value="">Semua Status</option>
<option value="Selesai" <?= $status=="Selesai"?"selected":"" ?>>Selesai</option>
<option value="Belum Selesai" <?= $status=="Belum Selesai"?"selected":"" ?>>Belum Selesai</option>
</select>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">Cari</button>
</div>

<div class="col-md-2">
<a href="tugas.php" class="btn btn-outline-secondary w-100">Reset</a>
</div>

</form>

<!-- TABLE -->
<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">
<tr>
<th>No</th>
<th>Judul</th>
<th>Deskripsi</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;

if (mysqli_num_rows($data) > 0) {

while ($row = mysqli_fetch_assoc($data)) {
?>

<tr>
<td><?= $no++; ?></td>

<td><strong><?= htmlspecialchars($row['judul']); ?></strong></td>

<td><?= htmlspecialchars($row['deskripsi']); ?></td>

<td>
<?php if ($row['status'] == "Selesai") { ?>
<span class="badge bg-success">✔ Selesai</span>
<?php } else { ?>
<span class="badge bg-danger">✘ Belum Selesai</span>
<?php } ?>
</td>

<td>
<a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">✏ Edit</a>
<a href="hapus.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin hapus?')">
🗑 Hapus
</a>
</td>

</tr>

<?php } } else { ?>

<tr>
<td colspan="5" class="text-center">Tidak ada data</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>
</div>

<footer class="text-center mt-4 text-muted">
<hr>
<small>© 2026 | To-Do List - UAS Software Development</small>
</footer>

</div>

</body>
</html>