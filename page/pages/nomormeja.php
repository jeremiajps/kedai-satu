<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['nomor_meja'] = $_POST['nomor_meja'];
        header('Location: daftarmenu.php');
        exit;
    }

    require_once '../components/headermenu.php';
?>
<div class="container-input">
    <div class="body-input">
    <form action="" method="post">
        <label for="nomor_meja">Masukkan Nomor Meja:</label>
        <input type="number" id="nomor_meja" name="nomor_meja" class="field-nomor" required>
        <button type="submit" class="nomormeja">Pesan Sekarang</button>
    </form>
    </div>
</div>

<?php
    require_once '../components/footermenu.php';
?>
