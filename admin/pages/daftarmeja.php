<?php
    session_start();

    if ($_SESSION['role'] != 'superadmin') {
        header('location: ../auth/login.php');
        exit();
    }

    include '../config/koneksi_database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_meja'])) {
        $nomor_meja = htmlspecialchars($_POST['nomor_meja']);
        $status_meja = 'Tersedia'; // Default status saat meja baru ditambahkan
    
        if (!empty($nomor_meja)) {
            $query = "INSERT INTO meja (nomor_meja, status_meja) VALUES ($1, $2)";
            $result = pg_query_params($dbconn, $query, [$nomor_meja, $status_meja]);
    
            if ($result) {
                echo "<script>alert('Nomor Meja Berhasil Ditambahkan!'); window.location.href='daftarmeja.php';</script>";
            } else {
                echo "<script>alert('Gagal Menambahkan Nomor Meja!');</script>";
            }
        }
    }
    
    // Hapus Nomor Meja
    if (isset($_GET['hapus'])) {
        $id_meja = $_GET['hapus'];
        $query = "DELETE FROM meja WHERE id_meja = $1";
        $result = pg_query_params($dbconn, $query, [$id_meja]);
    
        if ($result) {
            echo "<script>alert('Nomor Meja Berhasil Dihapus!'); window.location.href='daftarmeja.php';</script>";
        } else {
            echo "<script>alert('Gagal Menghapus Nomor Meja!');</script>";
        }
    }
    
    // Ambil Data Meja
    $query = "SELECT * FROM meja ORDER BY id_meja ASC";
    $result = pg_query($dbconn, $query);  
    
    require_once '../components/headerberanda.php';
?>

<div class="body-table">
            <div class="content-table">
                &nbsp<h4>Daftar Meja</h4>&nbsp
                <div class="card">
                    <form action="" method="post">
                        <input type="number" id="nomor_meja" name="nomor_meja" required>
                        <button type="submit" class="buttonMeja" name="tambah_meja">Tambah Meja Baru</button>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50"></th>
                                <th>Nomor Meja</th>
                                <th>Status Meja</th>
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
                                <a href="updatemeja.php?id_meja=<?= $row['id_meja'] ?>" class="buttonicon"><i class="fa fa-edit"></i></a>
                                <a href="daftarmeja.php?hapus=<?= $row['id_meja'] ?>" class="buttonicon" onclick="return confirm('Apakah anda yakin ingin menghapus meja ini?')"><i class="fa fa-times"></i></a>
                                </td>
                                <td><?= $row['nomor_meja'] ?></td>
                                <td><?= $row['status_meja'] ?></td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="6">Anda Belum Memasukkan Meja</td>
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