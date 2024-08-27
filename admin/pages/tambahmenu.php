<?php
    session_start();
    if ($_SESSION['role'] != 'superadmin' && $_SESSION['role'] != 'menuadmin') {
        header('location: ../auth/login.php');
        exit();
    }

    include '../config/koneksi_database.php';

    require_once '../components/headerberanda.php';

    if(isset($_POST['submit'])){
        //proses upload gambar
        $name=($_FILES['gambarmenu']['name']);
        $tmp_name=$_FILES['gambarmenu']['tmp_name'];
        move_uploaded_file($tmp_name, '../assets/images/' . $name);

        //proses insert data
        $gambar=$name;
        $nama=$_POST['namamenu'];
        $harga=$_POST['hargamenu'];
        $deskripsi=$_POST['deskripsimenu'];
        $kategori=$_POST['kategori'];
        $qry="insert into daftar_menu (gambar_menu,nama_menu,harga_menu,deskripsi,kategori_menu) values ('$gambar','$nama',$harga,'$deskripsi','$kategori')";
        $result=pg_query($dbconn,$qry);
        if($result){
            echo "<script>alert('Input Data Berhasil')</script>";
            echo "<script>window.location = 'daftarmenu.php'</script>";
        } else {
            echo "<script>alert('Input Data Tidak Berhasil')</script>";
        }
    }
?>

<div class="body-table">
    <div class="content-table">
        &nbsp<h4>Tambah Menu</h4>&nbsp
        <div class="card">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input">
                    <label>Gambar</label>
                    <input type="file" name="gambarmenu" required>
                </div>
                <div class="input">
                    <label>Nama Menu</label>
                    <input type="text" name="namamenu" placeholder="Nama Menu" class="input-field" required>
                </div>
                <div class="input">
                    <label>Harga Menu</label>
                    <input type="text" name="hargamenu" placeholder="Harga Menu" class="input-field" required>
                </div>
                <div class="input">
                    <label>Deskripsi Menu</label>
                    <textarea class="input-field" name="deskripsimenu" placeholder="Deskripsi Menu"></textarea>
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
                    <button type="submit" name="submit" class="buttonsubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    require_once '../components/footerberanda.php';
?>