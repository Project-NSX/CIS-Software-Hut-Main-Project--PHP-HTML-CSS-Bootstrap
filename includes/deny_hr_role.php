<?php
    // Redirect users who are signed in as a user with the "Human Resources" role.
    if(!isset($_SESSION["role"]) || (isset($_SESSION["role"]) && $_SESSION["role"] != "Human Resources")) {
        header("location: index.php");
        exit;
    }
?>