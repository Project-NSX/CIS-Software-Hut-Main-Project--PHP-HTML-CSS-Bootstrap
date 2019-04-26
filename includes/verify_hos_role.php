<?php
    if(!isset($_SESSION["role"]) || (isset($_SESSION["role"]) && $_SESSION["role"] != "Head Of School")) {
        header("location: index.php");
        exit;
    }
?>