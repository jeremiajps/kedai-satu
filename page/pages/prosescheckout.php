<?php
    include './config/koneksi_database.php';  
    session_start();

    if(isset($_POST['checkout'])){
        if (!isset($_SESSION['nomor_meja'])) {
            header("Location: keranjang.php");
            exit();
        }

        $nomor_meja = $_SESSION['nomor_meja'];

        $qry = "SELECT km.*, k.id_keranjang, dm.harga_menu 
                FROM keranjang_menu km
                JOIN keranjang k ON km.id_keranjang = k.id_keranjang
                JOIN daftar_menu dm ON km.id_daftar = dm.id_daftar
                WHERE k.nomor_meja = $nomor_meja";
        $result = pg_query($dbconn, $qry);

        if (pg_num_rows($result) > 0) {
            $order_id = rand(1000, 9999);
            $total_harga = 0;

            $qry_order = "INSERT INTO pesanan (nomor_meja, waktu_order, id_order) VALUES ($nomor_meja, NOW(), $order_id) RETURNING id_pesanan";
            $result_order = pg_query($dbconn, $qry_order);

            if ($result_order) {
                $row_order = pg_fetch_assoc($result_order);
                $id_pesanan = $row_order['id_pesanan']; 
            while ($row = pg_fetch_assoc($result)) {
                $id_daftar = $row['id_daftar'];
                $jumlah_item = $row['jumlah_item'];
                $harga_menu = $row['harga_menu'];
                $total_harga_item = $harga_menu * $jumlah_item;
                $total_harga += $total_harga_item;
    
                $qry_insert_detail = "INSERT INTO detail_pesanan (id_pesanan, id_daftar, jumlah_item, total_harga_item) 
                                       VALUES ($id_pesanan, $id_daftar, $jumlah_item, $total_harga_item)";
                pg_query($dbconn, $qry_insert_detail);
            }

            $qry_order_report = "INSERT INTO laporan_pesanan (id_pesanan) VALUES ($id_pesanan)";
            pg_query($dbconn, $qry_order_report);

            $qry = "DELETE FROM keranjang_menu WHERE id_keranjang IN (SELECT id_keranjang FROM keranjang WHERE nomor_meja = $nomor_meja)";
            pg_query($dbconn, $qry);

            $qry_delete_keranjang = "DELETE FROM keranjang WHERE nomor_meja = $nomor_meja";
            pg_query($dbconn, $qry_delete_keranjang);

            header("Location: konfirmasi_pesanan.php");
            exit();
        } else {
            echo "Error: Tidak Dapat Membuat Pesanan";
            exit();
        }
        } else {
            header("Location: keranjang.php");
            exit();
        }
    }
?>
