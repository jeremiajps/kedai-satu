<?php
    session_start();
    if ($_SESSION['role'] != 'superadmin' && $_SESSION['role'] != 'orderadmin') {
        header('location: ./auth/login.php');
        exit();
    }

    require_once '../components/headerberanda.php';

    include '../config/koneksi_database.php';

    $query_order = "SELECT p.id_pesanan, p.nomor_meja, p.waktu_order, p.id_order, lp.status_pesanan, 
                    STRING_AGG(dm.nama_menu || ' (' || dp.jumlah_item || ')', ', ') AS daftar_menu, 
                    SUM(dp.total_harga_item) AS total_harga  
                    FROM pesanan p
                    JOIN laporan_pesanan lp ON p.id_pesanan = lp.id_pesanan
                    JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
                    JOIN daftar_menu dm ON dp.id_daftar = dm.id_daftar
                    GROUP BY p.id_pesanan, p.nomor_meja, p.waktu_order, p.id_order, lp.status_pesanan
                    ORDER BY p.waktu_order DESC";
    $result = pg_query($dbconn,$query_order);
?>

<div class="container-input">
        <?php
            if (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_assoc($result)) {
        ?>
        <div class="body-input">
            <div class="body-field">ID Pesanan: <?= $row['id_order'] ?></div>
            <div class="body-field">Nomor Pesanan: <?= $row['id_pesanan'] ?></div>
            <div class="body-field">Nomor Meja: <?= $row['nomor_meja'] ?></div>
            <div class="body-field">Waktu Order: <?= $row['waktu_order'] ?></div>
            <div class="body-field">Daftar Menu: <?= $row['daftar_menu'] ?></div>
            <div class="body-field">Status Pesanan: <?= $row['status_pesanan'] ?></div>
            <div class="body-field">Total Harga: <?= $row['total_harga'] ?></div>
            <form action="statuspesanan.php" method="post">
            <input type="hidden" name="id_order" value="<?= $row['id_order']?>">
                <select name='status_pesanan'>
                    <option value="PENDING" <?= $row['status_pesanan'] == 'PENDING' ? 'selected' : '' ?> >Pending</option>
                    <option value="DIKERJAKAN" <?= $row['status_pesanan'] == 'DIKERJAKAN' ? 'selected' : '' ?> >Dikerjakan</option>
                    <option value="SIAP" <?= $row['status_pesanan'] == 'SIAP' ? 'selected' : '' ?> >Siap</option>
                </select>
            <button type="submit" class="update">Update</button>
            </form>
        </div>
        <?php
            }
                } else {
                    echo "Tidak ada pesanan.";
                }
        ?>
</div>

<?php
    require_once '../components/footerberanda.php';
?>
