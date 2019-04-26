<?php
    if(!isset($_SESSION["role"]) || (isset($_SESSION["role"]) && $_SESSION["role"] != "College Manager")) {
        header("location: index.php");
        exit;
    }
?>