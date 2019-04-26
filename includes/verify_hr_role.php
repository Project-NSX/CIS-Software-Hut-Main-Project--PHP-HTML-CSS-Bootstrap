<?php
    if(!isset($_SESSION["role"]) || (isset($_SESSION["role"]) && $_SESSION["role"] == "Human Resources")) {
        header("location: index.php");
        exit;
    }
?>