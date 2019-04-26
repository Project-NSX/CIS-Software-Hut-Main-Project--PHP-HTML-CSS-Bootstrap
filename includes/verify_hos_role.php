<?php
    // Redirect users who aren't signed in as a user with the "Head Of School" role.
    if(!isset($_SESSION["role"]) || (isset($_SESSION["role"]) && $_SESSION["role"] != "Head Of School")) {
        header("location: index.php");
        exit;
    }
?>