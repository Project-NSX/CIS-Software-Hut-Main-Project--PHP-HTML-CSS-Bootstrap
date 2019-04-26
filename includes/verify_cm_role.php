<?php
    // Redirect users who aren't signed in as a user with the "College Manager" role.
    if(!isset($_SESSION["role"]) || (isset($_SESSION["role"]) && $_SESSION["role"] != "College Manager")) {
        header("location: index.php");
        exit;
    }
