<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
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
<div align="right"><a href="logout.php" class="btn">Sign Out</a></div>
<p>Welcome <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b><br/>

Role: <b><?php echo htmlspecialchars($_SESSION["role"]);?></b><br/>

<!--There's something wrong with this where it'll show an incorectly for HR if the page is reloaded,
also shows "College: " for HR-->
<?php if($_SESSION["role"] === "aca" || $_SESSION["role"] === "hos"){?>
School: <b><?php echo htmlspecialchars($_SESSION["school"]);
}
if($_SESSION["role"] === "cm"){?>
College: <b><?php echo htmlspecialchars($_SESSION["school"]);
}?>
</b></p>
    <!--Bootstrap Container. Closing tag for this is in the footer, just before the closing body tag-->
    <div class="container">
        <header>
            <h1>Visiting Academic Form</h1>
        </header>
        <main>
