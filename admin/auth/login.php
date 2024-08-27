<?php
    session_start();

    include '../config/koneksi_database.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Login </title>
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
            .judul{
                color: #206A5D;
                font-weight: 600;
                margin-bottom: 5px;
            }
            .container{
                width: 100%;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .body-login{
                background-color: #fff;
                width: 300px;
                padding: 25px 15px;
                box-sizing: border-box;
                border-radius: 5px;
            }
            .input-field{
                width: 100%;
                display: block;
                padding: 0.5rem 1rem;
                box-sizing: border-box;
                margin-bottom: 8px;
            }
            .button{
                display: block;
                width: 100%;
                padding: 0.5rem 1rem;
                color: #c0dcac;
                background-color: #206A5D;
                border-style: none;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="body-login">
                <div class="judul">Login</div>
                <form action="" method="post">
                    <input type="text" name="user" id="user" class="input-field" placeholder="Username">
                    <input type="password" name="passlogin" id="passlogin" class="input-field" placeholder="Password">
                    <button type="submit" name="login" class="button">LOGIN</button>
                </form>
                <?php
                    if(isset($_POST['login'])){
                        $username=$_POST['user'];
                        $password=$_POST['passlogin'];
                        $qry= "SELECT username, pass, role FROM admin_rm WHERE username='$username' AND pass='$password'";
                        $result=pg_query($dbconn, $qry);
                        if (pg_num_rows($result)){
                            $row = pg_fetch_assoc($result);
                            $_SESSION['id_admin'] = $row['id_admin'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['role'] = $row['role'];
                            if ($row['role'] == 'superadmin') {
                                header('location: ../pages/beranda.php');
                            } elseif ($row['role'] == 'menuadmin') {
                                header('location: ../pages/daftarmenu.php');
                            } elseif ($row['role'] == 'orderadmin') {
                                header('location: ../pages/laporanpesanan.php');
                            }
                            } else {
                                echo 'Username atau Password Salah';
                            }
                    }
                ?>
            </div>
        </div>
    </body>
</html>