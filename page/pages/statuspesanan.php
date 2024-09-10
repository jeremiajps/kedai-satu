<?php
    session_start();

    include '../config/koneksi_database.php';  

    if (!isset($_SESSION['nomor_meja'])) {
        header("Location: /index.php");
        exit();
    }

    require_once '../components/headermenu.php';

    $nomor_meja = $_SESSION['nomor_meja'];

    $qry_get_order = "SELECT p.id_pesanan, p.nomor_meja, p.id_order, p.waktu_order, lp.status_pesanan, 
                      STRING_AGG(dm.nama_menu || ' (' || dp.jumlah_item || ')', ', ') AS daftar_menu, 
                      SUM(dp.total_harga_item) AS total_harga  
                      FROM pesanan p
                      JOIN laporan_pesanan lp ON p.id_pesanan = lp.id_pesanan
                      JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
                      JOIN daftar_menu dm ON dp.id_daftar = dm.id_daftar
                      WHERE p.nomor_meja = $1
                      GROUP BY p.id_pesanan, p.nomor_meja, p.id_order, p.waktu_order, lp.status_pesanan
                      ORDER BY p.waktu_order DESC LIMIT 1";
    $result = pg_query_params($dbconn, $qry_get_order, array($nomor_meja));
?>
<div class="container">
    <div class="body">
        <div class="row">
            <div class="col-6">
                <div class="judul">Status Pesanan Anda</div>
                <?php
                if (pg_num_rows($result) > 0) {
                    $order = pg_fetch_assoc($result);
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Nomor Pesanan</th>
                            <th>Total Harga</th>
                            <th>Waktu Pemesanan</th>
                            <th>Status Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $order['daftar_menu'] ?></td>
                            <td><?= $order['id_order'] ?></td>
                            <td>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                            <td><?= $order['waktu_order'] ?></td>
                            <td><?= $order['status_pesanan'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </br>
                <div>
                    <button onclick="window.location.reload()" class="buttonCheckout">Refresh</button>
                    <button onclick="selesaikanPesanan()" class="buttonCheckout">Selesai</button>
                </div>
                <?php
                    } else {
                        echo "Tidak ada pesanan";
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
function selesaikanPesanan() {
    if (confirm('Apakah Anda yakin ingin menyelesaikan pesanan? (Tekan "Cancel" jika tidak!!!)')) {
        // Kirim request ke server untuk menandai pesanan selesai
        window.location.href = 'pesananselesai.php';
    }
}
</script>

<?php
    require_once '../components/footermenu.php';
?>
