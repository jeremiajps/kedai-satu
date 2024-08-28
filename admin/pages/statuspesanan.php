<?php
    include './config/koneksi_database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_order = $_POST['id_order'];
    $status_pesanan = $_POST['status_pesanan'];

    // Mendapatkan id_pesanan berdasarkan id_order
    $qry_get_id_pesanan = "SELECT id_pesanan FROM pesanan WHERE id_order = $1";
    $result = pg_query_params($dbconn, $qry_get_id_pesanan, array($id_order));
    $row = pg_fetch_assoc($result);
    $id_pesanan = $row['id_pesanan'];

    if ($id_pesanan) {
        $sql = "UPDATE laporan_pesanan SET status_pesanan = $1 WHERE id_pesanan = $2";
        $result = pg_query_params($dbconn, $sql, array($status_pesanan, $id_pesanan));

        if ($result) {
            echo "Status pesanan berhasil diperbarui.";
        } else {
            echo "Error updating record: " . pg_last_error($dbconn);
        }
    } else {
        echo "Pesanan tidak ditemukan.";
    }

    pg_close($dbconn);

    header("Location: laporanpesanan.php");
    exit();
}
?>
