<?php
include "config.php";
// Initialize the session

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
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Application JavaScript -->
    <script src="js/bangor_va.js" type="text/javascript"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Custom JavaScript used by the system -->


</head>

<body>
    <section id="headerSection">
        <div id="headerTop">
            <?php
            if ($_SESSION["role"] === "Visiting Academic") {
                ?>
                <div id="signout" align="right"><a href="logout_va.php" class="btn btn-primary"><?php echo $lang['Sign Out'] ?></a></div>
            <?php
        } else {
            ?>
                <div id="signout" align="right"><a href="logout.php" class="btn btn-primary"><?php echo $lang['Sign Out'] ?></a></div>
            <?php
        }
        ?>
            <div id="welcome">
                <p><?php echo $lang['Hello'] ?>, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!<br />

                    <?php echo $lang['Role'] ?>: <b><?php echo htmlspecialchars($_SESSION["role"]); ?></b><br />

                    <?php if ($_SESSION["role"] === "Academic" || $_SESSION["role"] === "Head Of School") {


                        ?>
                        <?php echo $lang['School'] ?>: <b><?php echo $_SESSION["schoolName"]; ?></b><br />
                    <?php
                }
                if ($_SESSION["role"] === "College Manager") {
                    ?></b>
                        <?php echo $lang['College'] ?>: <b><?php echo $_SESSION["collegeName"];
                                                        } ?>
                    </b></p>
                <a href="index.php?lang=en"><?php echo $lang['lang_en'] ?></a>
                | <a href="index.php?lang=cy"><?php echo $lang['lang_cy'] ?></a>
            </div>
        </div>
    </section>
    <!--Bootstrap Container. Closing tag for this is in the footer, just before the closing body tag-->
    <div class="container">
        <header id="pageTitle">
            <img id="logo" src="img/bangor_logo.png" height="100px">
            <h1><?php echo $lang['Visiting Academics Form'] ?></h1>
        </header>
        <main>