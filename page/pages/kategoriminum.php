<?php
    session_start();
    
    include './config/koneksi_database.php';    

    require_once './components/headermenu.php';
    
    if (!isset($_SESSION['nomor_meja'])) {
        header('Location: nomormeja.php');
        exit;
    }
    $nomor_meja = $_SESSION['nomor_meja'];
    
    $qry="SELECT * FROM daftar_menu WHERE kategori_menu = 'Menu Minum'";
    $result=pg_query($dbconn,$qry);
?>
        <div class="container">
            <div class="body">
                <div class="row">
                    <div class="col-6">  
                        <div class="judul">Menu Makan dan Minum</div>
                            <div class="sub-judul"> Kedai Makan Satu-Satu</div>

                                <?php
                                    if(pg_num_rows($result) > 0){
                                        $qry="SELECT * FROM daftar_menu WHERE kategori_menu = 'Menu Minum'";
                                        $result=pg_query($dbconn,$qry);
                                        while($row=pg_fetch_array($result)){
                                ?>
                                <form action="tambahkeranjang.php" method="post">
                                <div class="list-menu">
                                    <img src="/kedaisatu/admin/assets/images/<?=$row['gambar_menu']?>" input type="hidden" name="gambarmenu">
                                    <div class="list-body">
                                        <div class="name-makan"><?= $row['nama_menu']?></div>
                                        <div class="deskripsi-makan"><?= $row['deskripsi'] ?></div>
                                        </br>
                                        <div class="harga">Rp<?= number_format($row['harga_menu'], 0, ',', '.') ?></div>
                                        <input type="hidden" name="id_daftar" value="<?= $row['id_daftar'] ?>">
                                        <input type="number" name="jumlah" class="jumlah" min="1" max="99" value="1" required>
                                        <button type="submit" class="buttonKeranjang" name="tambah_keranjang">Tambah ke Keranjang</button>
                                    </div>    
                                </div>
                                </form>
                                <?php   
                                    }} else {
                                ?>  
                                    <div>
                                        Menu Tidak Tersedia
                                    </div>
                                <?php  
                                    }   
                                ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    require_once './components/footermenu.php';
?>