<?php
    session_start();

    include '../config/koneksi_database.php';  

    if (!isset($_SESSION['nomor_meja'])) {
        header("Location: /index.php");
        exit();
    }

    require_once '../components/headermenu.php';

    $nomor_meja = $_SESSION['nomor_meja'];

    $qry_get_order = "SELECT * FROM pesanan WHERE nomor_meja = $nomor_meja ORDER BY waktu_order DESC LIMIT 1";
    $result_get_order = pg_query($dbconn, $qry_get_order);

    if ($result_get_order) {
    $order = pg_fetch_assoc($result_get_order);
    $id_order = $order['id_pesanan'];

    $qry = "SELECT dp.id_pesanan, dm.nama_menu, dp.jumlah_item, dm.harga_menu, dp.total_harga_item, p.waktu_order
            FROM detail_pesanan dp
            JOIN daftar_menu dm ON dp.id_daftar = dm.id_daftar
            JOIN pesanan p ON dp.id_pesanan = p.id_pesanan
            WHERE dp.id_pesanan = {$order['id_pesanan']}";     
    $result = pg_query($dbconn, $qry);
    $total_price = 0;
?>
<div class="container">
    <div class="body">
        <div class="row">
            <div class="col-6">
                <div class="judul">Order Confirmation</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Jumlah Item</th>
                            <th>Harga per Item</th>
                            <th>Total Harga per Item</th>
                            <th>Waktu Pemesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while ($row = pg_fetch_assoc($result)) { 
                            $total_item_price = $row['total_harga_item'];
                            $total_price += $total_item_price;
                        ?>
                        <tr>
                            <td><?= $row['nama_menu'] ?></td>
                            <td><?= $row['jumlah_item'] ?></td>
                            <td>Rp<?= number_format($row['harga_menu'], 0, ',', '.') ?></td>
                            <td>Rp<?= number_format($total_item_price, 0, ',', '.') ?></td>
                            <td><?=$row['waktu_order'] ?></td>
                        </tr>
                        <?php
                        } 
                        ?>
                    </tbody>
                </table>
                <div class="total-harga">
                    <strong>Total Harga: Rp<?= number_format($total_price, 0, ',', '.') ?></strong>
                </div>
                <div>
                    <button type="submit" onclick="window.location.href='statuspesanan.php'" class="buttonCheckout"><script>alert('Silakan ke kasir untuk melakukan pembayaran!!!')</script>Status Pesanan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    } else {
        echo "No orders found.";
    }
    
    require_once '../components/footermenu.php';
?>

