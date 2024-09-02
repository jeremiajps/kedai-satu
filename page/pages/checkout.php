<?php    
    session_start();

    include '../config/koneksi_database.php';    

    if (!isset($_SESSION['nomor_meja'])) {
        header("Location: nomormeja.php");
        exit;
    }

    require_once '../components/headermenu.php';

    $nomor_meja = $_SESSION['nomor_meja'];

    $qry =  "SELECT km.id_keranjang_menu, dm.nama_menu, dm.harga_menu, km.jumlah_item, dm.gambar_menu 
            FROM keranjang_menu km
            JOIN keranjang k ON km.id_keranjang = k.id_keranjang
            JOIN daftar_menu dm ON km.id_daftar = dm.id_daftar
            WHERE k.nomor_meja = $nomor_meja";
    $result = pg_query($dbconn, $qry);
    $total_price = 0;
?>

<div class="container">
    <div class="body">
        <div class="row">
            <div class="col-6">
                <div class="judul">Checkout</div>
                <?php 
                    if (pg_num_rows($result) > 0){ 
                ?>
                    <form action="prosescheckout.php" method="post">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Menu</th>
                                    <th>Jumlah Item</th>
                                    <th>Harga per Item</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = pg_fetch_array($result)){ ?>
                                    <?php
                                        $total_item_price = $row['harga_menu'] * $row['jumlah_item'];
                                        $total_price += $total_item_price;
                                    ?>
                                    <tr>
                                        <td><?= $row['nama_menu'] ?></td>
                                        <td><?= $row['jumlah_item'] ?></td>
                                        <td>Rp<?= number_format($row['harga_menu'], 0, ',', '.') ?></td>
                                        <td>Rp<?= number_format($total_item_price, 0, ',', '.') ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="total-harga">
                            <strong>Total Harga: Rp<?= number_format($total_price, 0, ',', '.') ?></strong>
                        </div>
                        <button type="submit" name="checkout" class="buttonProses">Proses Checkout</button>
                    </form>
                <?php 
                    } else { 
                ?>
                    <div>Keranjang Anda Kosong</div>
                <?php 
                    } 
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    require_once '../components/footermenu.php';
?>
