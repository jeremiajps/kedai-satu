<?php
session_start();

unset($_SESSION['nomor_meja']);

header("Location: /kedaisatu/index.php");
exit();
?>
