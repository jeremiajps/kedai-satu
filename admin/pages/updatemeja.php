<?php
session_start();

if ($_SESSION['role'] != 'superadmin') {
    header('location: ../auth/login.php');
    exit();
}

include '../config/koneksi_database.php';

// Pastikan ada parameter id_meja yang dikirim
if (!isset($_GET['id_meja'])) {
    header('Location: daftarmeja.php');
    exit();
}

$id_meja = $_GET['id_meja'];

// Ambil data meja berdasarkan id_meja
$query = "SELECT * FROM meja WHERE id_meja = $1";
$result = pg_query_params($dbconn, $query, [$id_meja]);

if (pg_num_rows($result) == 0) {
    header('Location: daftarmeja.php');
    exit();
}

$meja = pg_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status_meja = $_POST['status_meja'];

    // Update status meja
    $update_query = "UPDATE meja SET status_meja = $1 WHERE id_meja = $2";
    $update_result = pg_query_params($dbconn, $update_query, [$status_meja, $id_meja]);

    if ($update_result) {
        echo "<script>alert('Status meja berhasil diperbarui!'); window.location='daftarmeja.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status meja');</script>";
    }
}

require_once '../components/headerberanda.php';

?>

<div class="container-update">
        <div class="body-update">
            <div class="judul">Update Meja</div>
            <form action="" method="post">
                <label>Nomor Meja: </label>
                <input type="text" class="input-field" value="<?= htmlspecialchars($meja['nomor_meja']) ?>" disabled>
                <input type="hidden" name="nomor_meja" value="<?= htmlspecialchars($meja['nomor_meja']) ?>">

                <label>Status Meja: </label>
                <select name="status_meja" class="input-field" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="Tersedia" <?= $meja['status_meja'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="Digunakan" <?= $meja['status_meja'] == 'digunakan' ? 'selected' : '' ?>>Digunakan</option>
                </select>
                <button type="submit" class="buttonUpdate">Simpan Perubahan</button>
                <button type="button" onclick="location.href='daftarmeja.php'" class="buttonUpdate">Kembali</button>
            </form>
        </div>
    </div>