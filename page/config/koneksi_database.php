<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=rm_satu user=postgres password=195410002")
    or die('Could not connect: ' . pg_last_error());
?>