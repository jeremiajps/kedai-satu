<?php
    session_start();

    if ($_SESSION['role'] != 'superadmin') {
        header('location: ../auth/login.php');
        exit();
    }

    include '../config/koneksi_database.php';

    if (isset($_POST['register'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $role = htmlspecialchars($_POST['role']);

        if (!empty($username) && !empty($password) && !empty($role)) {
            $qry = "INSERT INTO admin_rm (username, pass, role) VALUES ($1, $2, $3)";
            $result = pg_query_params($dbconn, $qry, [$username, $password, $role]);
            
            if ($result) {
                echo "<script>alert('Berhasil Membuat Data Admin Baru'); window.location.href='../pages/beranda.php';</script>";
                exit();
            } else {
                echo "<script>alert('Gagal Membuat Data Admin Baru'); window.location.href='../pages/beranda.php';</script>";
            }
        } else {
            echo "<script>alert('Mohon Lengkapi Semua Data'); window.location.href='../pages/beranda.php';</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Admin Baru</title>
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
            color: #fff;
            background-color: #206A5D;
            border-style: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="body-login">
            <div class="judul">Registrasi Admin Baru</div>
            <form action="" method="post">
                <input type="text" name="username" class="input-field" placeholder="Username" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <select name="role" class="input-field" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="superadmin">Admin Utama</option>
                    <option value="menuadmin">Admin Menu</option>
                    <option value="orderadmin">Admin Dapur</option>
                </select>
                <button type="submit" name="register" class="button">Register</button>
                <button type="submit" onclick="location.href='../pages/beranda.php'" name="kembali" class="button">Kembali</button>
            </form>
            <?php if (!empty($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
