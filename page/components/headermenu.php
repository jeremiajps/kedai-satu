<?php
    include '../config/koneksi_database.php';   
?>
<?php
    $qry="SELECT * from daftar_menu";
    $result=pg_query($dbconn,$qry);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Kedai Makan Satu-Satu </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;600&display=swap');
            *{
                padding: 0;
                margin: 0;
            }
            body{
                font-family: 'Poppins', sans-serif;
                background-color: #c0dcac;
            }
            h2, h4{
                color: #206A5D;
            }
            a{
                color: inherit;
                text-decoration: none;
            }
            .navbar{
                padding: 0.5rem 1rem;
                background-color: #206A5D;
                color: #c0dcac;
                position: fixed;
                width: 100%;
                top: 0;
                left: 0;
                z-index: 99;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .sidebar{
                position: fixed;
                width: 200px;
                top: 0;
                bottom: 0;
                background-color: #FFFFFF;
                padding-top: 40px;
                transition: all .5s;
            }
            .sidebar-hide{
                left: -250px;
            }
            .sidebar-show{
                left: 0;
            }
            .sidebar-body{
                padding: 15px;
            }
            .sidebar-body h4{
                margin-bottom: 8px;
                color: #206A5D;
            }
            .sidebar-body ul{
                list-style: none;
                color: #206A5D;
                font-size: small;
            }
            .sidebar-body ul li a{
                width: 100%;
                display: inline-block;
                padding: 7px 15px;
                box-sizing: border-box;
            }
            .sidebar-body ul li a:hover{
                background-color: #206A5D;
                color: #c0dcac;
            }
            .sidebar-body ul li:not(:last-child){
                border-bottom: 1px solid #206A5D;
            }
            .container{
                width: 100%;
                max-width: 960px;
                padding: 20px;
                box-sizing: border-box;
                margin: 0 auto;
            }
            .body{
                padding: 100px 0; 
            }
            .container-input{
                width: 100%;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .body-input{
                background-color: #fff;
                width: 300px;
                padding: 25px 15px;
                box-sizing: border-box;
                border-radius: 5px;
            }
            .nomormeja{
                display: block;
                width: 100%;
                padding: 0.5rem 1rem;
                color: #c0dcac;
                background-color: #206A5D;
                border-style: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .field-nomor{
                width: 100%;
                display: block;
                padding: 0.5rem 1rem;
                box-sizing: border-box;
                margin-bottom: 8px;
            }
            .row{
                margin-left: auto;
                margin-right: auto;
                display: grid;
                flex-wrap: wrap;
            }
            .col-6{
                flex: 0 0 50%;
                box-sizing: border-box;
                margin-bottom: 15px;
                padding-left: 15px;
                padding-right: 15px;
            }
            .list-menu{
                border-radius: 5px;
                background-color: #FFFFFF;
                display: flex;
                text-indent: 10px;
                color: #206A5D;
                margin-bottom: 15px;
                padding: 3px;
            }
            .list-menu img{
                width: 25%;
                height: auto;
                padding-left: 10px;
                margin-top: 10px;
                margin-bottom: 10px;
                border-radius: 3px;
                display: flex;
                margin: auto;
            }
            .name-makan{
                font-weight: 600;
                margin-top: 5px;
            }
            .deskripsi-makan{
                font-weight: 200;
                font-size: 9px;
                font-family: 'Poppins', sans-serif;
                margin-left: 10px;
                margin-right: 10px;
                text-align: justify;
                text-indent: 0;
            }
            .harga{
                font-weight: 600;
                margin-bottom: 5px;
            }
            .jumlah{
                display: block;
                margin-left: 10px;
                margin-right: 10px;
                margin-bottom: 5px;
                color: #206A5D;
            }
            img{
                display: flex;
                width: 30%;
                height: 30%; 
            }
            .list-body{
                flex: auto;
            }
            .buttonKeranjang{
                display: block;
                background-color: #206A5D;
                color: #FFFFFF;
                font-weight: 200;
                font-size: x-small;
                font-family: 'Poppins', sans-serif;
                border-style: none;
                border-radius: 3px;
                width: 130px;
                height: 25px;
                cursor: pointer;
                margin-left: 10px;
                margin-bottom: 10px;
            }
            .judul{
                color: #206A5D;
                font-weight: 600;
                margin-bottom: 5px;
            }
            .sub-judul{
                color: #206A5D;
                font-weight:normal;
                font-size: 10px;
                margin-bottom: 5px;
            }
            .container .buttonBawah{
                display:block;
                align-items: center;
                justify-content: center;
                gap: 20px;
                flex: auto;
            }
            .form-detail1{
                border-radius: 5px;
                background-color: #FFFFFF;
                display: flex;
                text-indent: 10px;
                color: #206A5D;  
                margin-top: 15px;
                margin-bottom: 10px;   
            }
            .body-table{
                width: 960px;
                margin-left: auto;
                margin-right: auto;
            }
            .content-table{
                padding: 60px 10px;
            }
            .table{
                font-size: smaller;
                color: #206A5D;
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }
            .table th, .table td {
                padding: 10px;
                border: 1px solid #206A5D;
                text-align: left;
            }
            .table th {
                background-color: #f5f5f5;
            }
            .total-harga {
                margin-top: 20px;
                font-weight: 600;
                color: #206A5D;
            }
            .card{
                background-color: #FFFFFF;
                padding: 15px;
                border-radius: 5px;
            }
            .input{
                margin-bottom: 8px;
                font-size: small;
                color: #206A5D;
            }
            .input label{
                display: block; 
                margin-bottom: 5px;
                font-weight: 600;
            }
            .input-label{
                width: 100%;
                box-sizing: border-box;
                padding: 0.5rem;
                font-size: small;
            }
            .input-field{
                width: 100%;
                box-sizing: border-box;
                padding: 2px;
                font-size: small;
            }
            .button{
                display: inline-block;
                background-color: #206A5D;
                color: #FFFFFF;
                font-weight: 600;
                font-size: small;
                font-family: 'Poppins', sans-serif;
                border-style: none;
                border-radius: 3px;
                width: 100px;
                height: 30px;
                cursor: pointer;
                margin-top: 10px;
            }
            .buttonAction{
                background-color: #206A5D;
                color: #FFFFFF;
                font-weight: 600;
                font-size: small;
                font-family: 'Poppins', sans-serif;
                border-style: none;
                border-radius: 3px;
                width: 70px;
                height: 25px;
                cursor: pointer;
                margin-right: 5px;
                margin-bottom: 5px;
            }
            .buttonCheckout{
                background-color: #206A5D;
                color: #FFFFFF;
                font-weight: 600;
                font-size: small;
                font-family: 'Poppins', sans-serif;
                border-style: none;
                border-radius: 3px;
                width: 35%;
                height: 25px;
                cursor: pointer;
                margin-right: 5%;
            }
            .buttonProses{
                background-color: #206A5D;
                color: #FFFFFF;
                font-weight: 600;
                font-size: small;
                font-family: 'Poppins', sans-serif;
                border-style: none;
                border-radius: 3px;
                width: 50%;
                padding: 5px 10px;
                cursor: pointer;
                margin-right: 5%;
            }
            @media (max-width: 768px) {
                .container{
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <a href="#" id="btnBars">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="sidebar sidebar-hide">
            <div class="sidebar-body">
                <h4>Kategori Menu</h4>
                <ul>
                    <?php
                    $row=pg_fetch_array($result);
                    ?>
                    <li><a href="../pages/nomormeja.php">Beranda</a></li>
                    <li><a href="../pages/daftarmenu.php">Semua Menu</a></li>
                    <li><a href="../pages/kategorimakan.php?makan<?=$row['kategori_menu'];?>">Menu Makanan</a></li>
                    <li><a href="../pages/kategoriminum.php?minum<?=$row['kategori_menu'];?>">Menu Minuman</a></li>
                    <li><a href="../pages/keranjang.php">Keranjang Menu</a></li>
                </ul>
            </div>
        </div>
    
