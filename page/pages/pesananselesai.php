<?php
session_start();

unset($_SESSION['nomor_meja']);

header("Location: /index.php");
exit();
?>
