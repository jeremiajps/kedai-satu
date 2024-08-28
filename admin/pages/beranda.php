<?php
    session_start();

    if ($_SESSION['role'] != 'superadmin') {
        header('location: ./auth/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Login Admin </title>
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
            button{
                display: block;
                background-color: #206A5D;
                color: #FFFFFF;
                width: 100%;
                padding: 0.5rem 1rem;
                border-radius: 5px;
                cursor: pointer;
                margin: auto;
                border-style: none;
            }
            .container{
                width: 100%;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            img{
                display: flex;
                margin: auto;
                width: 30%;
                height: 30%; 
            }
            .judul{
                display: flex;
                margin: auto;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                font-size: 20px;
                color: #206A5D;
            }
        </style>
    </head>
    <body>
        <!--BERANDA-->
        <div class="container">
            <div class="body">
                <button type="button" onclick="location.href='/admin/pages/daftarmenu.php'" name="daftarmenu">DAFTAR MENU</button>
                </br>
                <button type="button" onclick="location.href='/admin/pages/laporanpesanan.php'" name="laporanpesanan">LAPORAN PESANAN</button>
                </br>
                <button type="button" onclick="location.href='/admin/auth/register.php'" name="laporanpesanan">REGISTER ADMIN BARU</button>
                </br>
                <button type="button" onclick="location.href='/admin/auth/logout.php'" name="logout">LOG OUT</button>
                </br>
            </div>
        </div>
    </body>
</html>