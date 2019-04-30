<?php
include "config.php";
if (isset($_GET['accept-cookies'])) {
    setcookie('accept-cookies', 'true', time() + 31556925);  //To store cookies pop up
    header('Location: ./');
}
?>

<?php

$role = "";
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Redirect user to welcome page
    require 'includes/user_redirect.php';
    exit;
}
require_once 'includes/database.php';
// Define variables and initialize with empty values
$username = $password_entered = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password_entered = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT role, school_id, college_id, username, password FROM user WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $role, $school_id, $college_id, $username, $password_db);
                    if (mysqli_stmt_fetch($stmt)) {
                        if ($password_entered == $password_db) {
                            session_regenerate_id(true);
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;
                            $_SESSION["school_id"] = $school_id;
                            $_SESSION["college_id"] = $college_id;

                            if ($_SESSION['role'] == "Academic" || $_SESSION['role'] ==  "Head Of School" || $_SESSION['role'] == "College Manager") {

                                $sql = "SELECT name FROM college WHERE collegeId = $college_id";
                                $result = $link->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    $_SESSION["collegeName"] = $row["name"];
                                }
                            }
                            if ($_SESSION['role'] == "Academic" || $_SESSION['role'] ==  "Head Of School") {
                                $sql = "SELECT name FROM school WHERE schoolId = $school_id";
                                $result = $link->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    $_SESSION["schoolName"] = $row["name"];
                                }
                            }
                            require 'includes/user_redirect.php';
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<?php require 'includes/header_index.php'; ?>
<!--HTML HERE-->

<div class="container">
    <h2><?php echo $lang['Staff Login Page'] ?></h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label><?php echo $lang['Username'] ?></label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label><?php echo $lang['Password'] ?></label>
            <input type="password" name="password" class="form-control" id="passwordField">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="checkbox" onclick="togglePasswordHidden()"> <?php echo $lang['Show Password'] ?>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="<?php echo $lang['Login'] ?>">
        </div>
    </form>
</div>


<?php
if (!isset($_COOKIE['accept-cookies'])) {
    ?>
    <div class="cookie-banner">
        <div class="container1">
            <p><?php echo $lang['Cookies'] ?><a href="/cookies"> <?php echo $lang['Cookies2'] ?></a> </p>
            <a href="?accept-cookies" class="button"><?php echo $lang['Cookies3'] ?></a>
        </div>
    </div>
<?php
}
?>

<script src="js/bangor_va.js"></script>

<?php require 'includes/footer.php'; ?>