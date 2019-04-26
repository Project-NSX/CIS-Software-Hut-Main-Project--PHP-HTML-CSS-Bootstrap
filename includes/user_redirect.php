<?php
if ($_SESSION["role"] === "Academic" || $_SESSION["role"] === "College Manager" || $_SESSION["role"] === "Head Of School") {
        header("location: view_requests.php");
    } elseif ($_SESSION["role"] === "Human Resources") {
        header("location: hr_pending_approval.php");
    }
