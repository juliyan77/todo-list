<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Pencarian
if (isset($_GET['cari']) && $_GET['cari'] != "") {
    $keyword = mysqli_real_escape_string($conn, $_GET['cari']);

    $data = mysqli_query($conn, "SELECT * FROM tugas
        WHERE judul LIKE '%$keyword%'
        OR deskripsi LIKE '%$keyword%'
        ORDER BY id DESC");
} else {
    $data = mysqli_query($conn, "SELECT * FROM tugas ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data To-Do List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">📋 Data To-Do List</h3>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Dashboard
                </a>

                <a href="tambah.php" class="btn btn-success">
                    + Tambah Tugas
                </a>
            </div>

            <!-- Form Pencarian -->
            <form method="GET" class="row mb-4">

                <div class="col-md-8">
                    <input
                        type="text"
                        name="cari"
                        class="form-control"
                        placeholder="Cari judul atau deskripsi..."
                        value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        Cari
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="tugas.php" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>

            </form>

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                <tr>
                    <th width="60">No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th width="170">Status</th>
                    <th width="180">Aksi</th>
                </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                if(mysqli_num_rows($data) > 0){

                    while($row = mysqli_fetch_assoc($data)){

                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= htmlspecialchars($row['judul']); ?></td>

                    <td><?= htmlspecialchars($row['deskripsi']); ?></td>

                    <td>

                        <?php
                        if($row['status']=="Selesai"){
                            echo '<span class="badge bg-success">Selesai</span>';
                        }else{
                            echo '<span class="badge bg-warning text-dark">Belum Selesai</span>';
                        }
                        ?>

                    </td>

                    <td>

                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="hapus.php?id=<?= $row['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

                <?php

                    }

                }else{

                ?>

                <tr>

                    <td colspan="5" class="text-center">
                        Tidak ada data.
                    </td>

                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>