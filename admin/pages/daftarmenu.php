<?php
    session_start();
    if ($_SESSION['role'] != 'superadmin' && $_SESSION['role'] != 'menuadmin') {
        header('location: ../auth/login.php');
        exit();
    }

    require_once '../components/headerberanda.php';

    include '../config/koneksi_database.php';

    $qry="SELECT * from daftar_menu";
    $result=pg_query($dbconn,$qry);

    if(isset($_GET['delete'])){
        //proses hapus foto
        $qry_delete_foto="SELECT gambar_menu FROM daftar_menu WHERE nama_menu='$_GET[delete]'";
        $result_delete_foto=pg_query($dbconn, $qry_delete_foto);
        $d=pg_fetch_object($result_delete_foto);

        if(file_exists('../assets/images/' . $d->gambar_menu)){
            unlink('../assets/images/' .$d->gambar_menu);
        }
        
        //proses hapus data
        $qry1="DELETE from daftar_menu WHERE nama_menu='$_GET[delete]'";
        $result1=pg_query($dbconn,$qry1);
        if($result1){
            echo "<script>window.location = 'daftarmenu.php'</script>";
        } else {
            echo "<script>alert('Data gagal dihapus')</script>";
        }
    }
?>
<div class="body-table">
            <div class="content-table">
                &nbsp<h4>Edit Menu</h4>&nbsp
                <div class="card">
                    <a href="tambahmenu.php" class="buttonTambah" title="Tambah Menu"><i class="fa fa-plus"></i></a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50"></th>
                                <th>Gambar</th>
                                <th>Nama Menu</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(pg_num_rows($result) > 0){
                            ?>

                            <?php  
                                while($row=pg_fetch_array($result)){
                            ?>
                            <tr>
                                <td align="center">
                                    <a href="menuupdate.php?id=<?= $row['id_daftar'] ?>" class="buttonicon" title="Edit Menu"><i class="fa fa-edit"></i></a>
                                    <a href="?delete=<?= $row['nama_menu'] ?>" class="buttonicon" name="delete" onclick="return confirm('Anda Yakin?')" title="Hapus Menu"><i class="fa fa-times"></i></a>
                                </td>
                                <td><img src="../assets/images/<?=$row['gambar_menu']?>" class="image"></td>
                                <td><?=$row['nama_menu']?></td>
                                <td><?=$row['harga_menu']?></td>
                                <td><?=$row['deskripsi']?></td>
                                <td><a href="kategori.php?kategori=<?=$row['kategori_menu']; ?>"><?=$row['kategori_menu']; ?></a></td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="6">Anda Belum Memasukkan Menu</td>
                                </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
    require_once '../components/footerberanda.php';
?>
