<?php
// Initialize the session
session_start();
// TODO: Make session get trashed when window is closed or user is afk for an hour
// Check if the user is logged in, if not then redirect him to login page
// This might be helpful: https://stackoverflow.com/questions/22317888/destroy-php-sessions-on-browsers-tab-close
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <title>Visiting Academic Form</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<body>
<div align="right"><a href="logout.php" class="btn btn-primary">Sign Out</a></div>
<p>Welcome <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b><br/>

Role: <b><?php echo htmlspecialchars($_SESSION["role"]);?></b><br/>

<!--
    TODO: Make the school and college display correctly.
    This will require the use of another table when it's in there
    as it'll need to get the college / school name based on the ID supplied

    TODO: Make the role of the logged in user display correctly:
    Academic
    College Manager
    Head of School
    Human Resources
-->
<?php if($_SESSION["role"] === "Academic" || $_SESSION["role"] === "Head Of School"){?>
School: <b><?php echo htmlspecialchars($_SESSION["school_id"]);?></b><br/>
<?php
}
if($_SESSION["role"] === "College Manager"){?></b>
College: <b><?php echo htmlspecialchars($_SESSION["college_id"]);
}?>
</b></p>
    <!--Bootstrap Container. Closing tag for this is in the footer, just before the closing body tag-->
    <div class="container">
        <header>
            <h1>Visiting Academic Form</h1>
        </header>
        <main>

<!--TODO: Make a header bar here-->