<?php
    session_start();

    include '../config/koneksi_database.php';

    $error = ""; 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomor_meja = $_POST['nomor_meja'];

        $query = "SELECT * FROM meja WHERE nomor_meja = $1 AND status_meja = 'Tersedia'";
        $result = pg_query_params($dbconn, $query, [$nomor_meja]);

        if (pg_num_rows($result) > 0) {
        $_SESSION['nomor_meja'] = $_POST['nomor_meja'];

        $update_query = "UPDATE meja SET status_meja = 'Digunakan' WHERE nomor_meja = $1";
        pg_query_params($dbconn, $update_query, [$nomor_meja]);

        header('Location: daftarmenu.php');
        exit;
    } else {
        $error = "Nomor meja tidak tersedia atau sedang digunakan!";
    }
    }

    require_once '../components/headermenu.php';
?>
<div class="container-input">
    <div class="body-input">
    <form action="" method="post">
        <label for="nomor_meja">Masukkan Nomor Meja:</label>
        <input type="number" id="nomor_meja" name="nomor_meja" class="field-nomor" required>
        <button type="submit" class="nomormeja">Pesan Sekarang</button>
    </form>
    </div>
</div>

<?php
    require_once '../components/footermenu.php';
?>
