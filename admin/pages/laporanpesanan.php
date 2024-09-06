<?php
    session_start();
    if ($_SESSION['role'] != 'superadmin' && $_SESSION['role'] != 'orderadmin') {
        header('location: ./auth/login.php');
        exit();
    }

    include '../config/koneksi_database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['delete'])) {
            $id_order = $_POST['id_order'];
            $status_pesanan = $_POST['status_pesanan'];

            $query_delete_detail = "DELETE FROM detail_pesanan WHERE id_pesanan IN (SELECT id_pesanan FROM pesanan WHERE id_order = $1)";
            pg_query_params($dbconn, $query_delete_detail, array($id_order));

            $query_delete_laporan = "DELETE FROM laporan_pesanan WHERE id_pesanan IN (SELECT id_pesanan FROM pesanan WHERE id_order = $1)";
            pg_query_params($dbconn, $query_delete_laporan, array($id_order));

            $query_delete_pesanan = "DELETE FROM pesanan WHERE id_order = $1";
            pg_query_params($dbconn, $query_delete_pesanan, array($id_order));

            header('Location: laporanpesanan.php');
            exit();
        }
    }

    require_once '../components/headerberanda.php';

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
                    <option value="Pesanan Sudah Dibayar" <?= $row['status_pesanan'] == 'Pesanan Sudah Dibayar' ? 'selected' : '' ?> >Pesanan sudah dibayar</option>
                    <option value="Pesanan Masuk" <?= $row['status_pesanan'] == 'Pesanan Pending' ? 'selected' : '' ?> >Pesanan Masuk</option>
                    <option value="Pesanan Dikerjakan" <?= $row['status_pesanan'] == 'Pesanan Dikerjakan' ? 'selected' : '' ?> >Pesanan Dikerjakan</option>
                    <option value="Pesanan Siap" <?= $row['status_pesanan'] == 'Pesanan Siap' ? 'selected' : '' ?> >Pesanan Siap</option>
                </select>
            <button type="submit" class="update">Update</button>
            </form>
            <form action="" method="post">
                <input type="hidden" name="id_order" value="<?= $row['id_order']?>">
                <button type="submit" name="delete" class="update" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">Hapus</button>
            </form>
        </div>
        <?php
            }
                } else {
                    echo "Tidak ada pesanan";
                }
        ?>
</div>

<?php
    require_once '../components/footerberanda.php';
?>
