<?php
    include '../config/koneksi_database.php';  
    session_start(); 
    
    if(isset($_POST['tambah_keranjang'])){
        $id_daftar = $_POST['id_daftar'];
        $jumlah_item = $_POST['jumlah'];
        $nomor_meja = $_SESSION['nomor_meja'];

        $qry_check_keranjang = "SELECT id_keranjang FROM keranjang WHERE nomor_meja = $nomor_meja";
        $result_check_keranjang = pg_query($dbconn, $qry_check_keranjang);

        if (pg_num_rows($result_check_keranjang) > 0) {
            $row_cart = pg_fetch_assoc($result_check_keranjang);
            $id_keranjang = $row_cart['id_keranjang'];
        } else {
            $qry_insert_cart = "INSERT INTO keranjang (nomor_meja) VALUES ($nomor_meja) RETURNING id_keranjang";
            $result_insert_cart = pg_query($dbconn, $qry_insert_cart);
            $row_cart = pg_fetch_assoc($result_insert_cart);
            $id_keranjang = $row_cart['id_keranjang'];
        }

        $qry_check = "SELECT * FROM keranjang_menu WHERE id_keranjang = $id_keranjang AND id_daftar = $id_daftar";
        $result_check = pg_query($dbconn, $qry_check);

        if (pg_num_rows($result_check) > 0) {
            $message[] = 'already added to cart!';
        } else {
            $qry_insert = "INSERT INTO keranjang_menu (id_keranjang, id_daftar, jumlah_item) VALUES ($id_keranjang, $id_daftar, $jumlah_item)";
            $result_insert = pg_query($dbconn, $qry_insert);
        }
    
        if ($result_update || $result_insert) {
            header("Location: keranjang.php");
        } else {
            echo "Error: " . pg_last_error($dbconn);
        }
    }
    ?>
