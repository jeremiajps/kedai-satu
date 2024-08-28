<?php
    session_start();
    if ($_SESSION['role'] != 'superadmin' && $_SESSION['role'] != 'menuadmin') {
        header('location: ./auth/login.php');
        exit();
    }

    require_once './components/headerberanda.php';

    include './config/koneksi_database.php';
    
    $qry="SELECT * from daftar_menu WHERE id_daftar='$_GET[id]' ";
    $result=pg_query($dbconn,$qry);
    $i=pg_fetch_object($result);

    if(isset($_POST['update'])){
        if($_FILES['gambarmenu']['error'] <> 4){
            //proses upload gambar
            $name=($_FILES['gambarmenu']['name']);
            $tmp_name=$_FILES['gambarmenu']['tmp_name'];
            move_uploaded_file($tmp_name, './assets/images/' . $name);
            
            //proses hapus data sebelumnya
            if(file_exists('./assets/images/' . $_POST['gambar_lama'])){
                unlink('./assets/images/' .$_POST['gambar_lama']);
            }
        }else{
            $name=$_POST['gambar_lama'];
        }
        //proses update data
        $nama=$_POST['namamenu'];
        $harga=$_POST['hargamenu'];
        $deskripsi=$_POST['deskripsimenu'];
        $kategori=$_POST['kategori'];
        $qryupdate="update daftar_menu set 
                    nama_menu='$nama', 
                    harga_menu='$harga',
                    deskripsi='$deskripsi',
                    gambar_menu='$name',
                    kategori_menu='$kategori' where id_daftar='$_GET[id]'";
        $result1=pg_query($dbconn, $qryupdate);
        if($result1){
            echo "<script>alert('Update Data Berhasil')</script>";
            echo "<script>window.location = 'daftarmenu.php'</script>";
        }else{
            echo "<script>alert('Update Data Tidak Berhasil')</script>";
        }
    }
?>
<div class="body-table">
    <div class="content-table">
        &nbsp<h4>Edit Menu</h4>&nbsp
        <div class="card">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input">
                    <label>Gambar</label>
                    <input type="hidden" name="gambar_lama" value="<?= $i->gambar_menu ?>">
                    <div>
                        <img src="./assets/images/<?= $i->gambar_menu ?>" width="200">
                    </div>
                    <input type="file" name="gambarmenu">
                </div>
                <div class="input"> 
                    <label>Nama Menu</label>
                    <input type="text" name="namamenu" placeholder="Nama Menu" class="input-field" value="<?= $i->nama_menu ?>"  required>
                </div>
                <div class="input">
                    <label>Harga Menu</label>
                    <input type="text" name="hargamenu" placeholder="Harga Menu" class="input-field" value="<?= $i->harga_menu ?>" required>
                </div>
                <div class="input">
                    <label>Deskripsi Menu</label>
                    <textarea class="input-field" name="deskripsimenu" placeholder="Deskripsi Menu"><?= $i->deskripsi ?></textarea>
                </div>
                <div class="input">
                    <select name="kategori" class="box" required>
                        <option value="" disabled selected>Pilih Kategori --</option>
                        <option value="Menu Makan">Menu Makan</option>
                        <option value="Menu Minum">Menu Minum</option>
                    </select>
                </div>
                <div class="input">
                    <button type="button" onclick="window.location.href='daftarmenu.php'" class="buttonback">Kembali</button>
                    <button type="submit" name="update" class="buttonsubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    require_once './components/footerberanda.php';
?>