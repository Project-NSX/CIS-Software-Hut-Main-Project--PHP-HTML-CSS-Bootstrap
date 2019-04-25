<?php
// Initialize the session
session_start();
// TODO: Make session get trashed when window is closed or user is afk for an hour
// Check if the user is logged in, if not then redirect him to login page
// This might be helpful: https://stackoverflow.com/questions/22317888/destroy-php-sessions-on-browsers-tab-close

// TODO: Restrict the pages the user can visit depending on their role


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
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
    <script src="js/bangor_va.js" type="text/javascript"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Custom JavaScript used by the system -->


</head>

<body>
    <div id="headerTop">
        <div id="signout" align="right"><a href="logout.php" class="btn btn-primary">Sign Out</a></div>
        <div id="welcome">
            <p>Hello, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!<br />

                Role: <b><?php echo htmlspecialchars($_SESSION["role"]); ?></b><br />

                <?php if ($_SESSION["role"] === "Academic" || $_SESSION["role"] === "Head Of School") {


                    ?>
                    School: <b><?php echo $_SESSION["schoolName"]; ?></b><br />
                <?php
            }
            if ($_SESSION["role"] === "College Manager") {
                ?></b>
                    College: <b><?php echo $_SESSION["collegeName"];
                            } ?>
                </b></p>
        </div>
    </div>
    <!--Bootstrap Container. Closing tag for this is in the footer, just before the closing body tag-->
    <div class="container">
        <header id="pageTitle">
            <img id="logo" src="img/bangor_logo.png" height="100px">
            <h1>Visiting Academic Form</h1>
        </header>
        <main>

            <!--TODO: Make a header bar here-->