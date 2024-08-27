<?php
    session_start();

    include '../config/koneksi_database.php';    

    require_once '../components/headermenu.php';

    if (!isset($_SESSION['nomor_meja'])) {
        header('Location: nomormeja.php');
        exit;
    }
    
    $nomor_meja = $_SESSION['nomor_meja'];

    $qry =  "SELECT km.id_keranjang_menu, dm.nama_menu, dm.harga_menu, km.jumlah_item, dm.gambar_menu 
            FROM keranjang_menu km
            JOIN keranjang k ON km.id_keranjang = k.id_keranjang
            JOIN daftar_menu dm ON km.id_daftar = dm.id_daftar
            WHERE k.nomor_meja = $nomor_meja";

    $result = pg_query($dbconn, $qry);
    $total_price = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['update'])) {
            $id_keranjang_menu = $_POST['id_keranjang_menu'];
            $jumlah_item = $_POST['jumlah_item'];
            $update_qry = "UPDATE keranjang_menu SET jumlah_item=$jumlah_item WHERE id_keranjang_menu=$id_keranjang_menu";
            pg_query($dbconn, $update_qry);
            echo "<script>window.location = 'keranjang.php'</script>";
        } elseif (isset($_POST['delete'])) {
            $id_keranjang_menu = $_POST['id_keranjang_menu'];
            $delete_qry = "DELETE FROM keranjang_menu WHERE id_keranjang_menu=$id_keranjang_menu";
            pg_query($dbconn, $delete_qry);
            echo "<script>window.location = 'keranjang.php'</script>";
        }
    }

?>
<div class="container">
    <div class="body">
        <div class="row">
            <div class="col-6">
            <div class="judul">Keranjang Menu</div>
            <?php
                if(pg_num_rows($result) > 0) {
            ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Jumlah Item</th>
                            <th>Harga per Item</th>
                            <th>Total Harga</th>
                            <th>    </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while ($row = pg_fetch_array($result)) { 
                        ?>
                        <?php
                            $total_item_price = $row['harga_menu'] * $row['jumlah_item'];
                            $total_price += $total_item_price;
                        ?>
                        <tr>
                            <form method="post">
                            <td><?= $row['nama_menu'] ?></td>
                            <td><input type="number" name="jumlah_item" value="<?= $row['jumlah_item'] ?>" min="1"></td>
                            <td>Rp<?= number_format($row['harga_menu'], 0, ',', '.') ?></td>
                            <td>Rp<?= number_format($total_item_price, 0, ',', '.') ?></td>
                            <td>
                                <input type="hidden" name="id_keranjang_menu" value="<?= $row['id_keranjang_menu'] ?>">
                                <button type="submit" name="update" class="buttonAction">Update</button>
                                <button type="submit" name="delete" class="buttonAction">Delete</button>
                            </td>
                            </form>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <div class="total-harga">
                <strong>Total Harga: Rp<?= number_format($total_price, 0, ',', '.') ?></strong>
            </div>

            <button type="submit" onclick="window.location.href='checkout.php'" class="buttonCheckout">Checkout</a>
            <button type="submit" onclick="window.location.href='daftarmenu.php'" class="buttonCheckout">Tambah Menu</a>
            <?php
                } else {
            ?>
            <div>
                Anda belum memesan menu
            </div>
            <button type="submit" onclick="window.location.href='daftarmenu.php'" class="buttonAction">Kembali</a>

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