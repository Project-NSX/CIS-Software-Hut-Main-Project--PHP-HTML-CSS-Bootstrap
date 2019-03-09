<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>College Manager - Approved Requests</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--This page should show all requests approved by the CM-->
<!--TODO:  Make this display table & Add search function -->
<?php
$servername = "sql189.main-hosting.eu.";
$username = "u359278202_eeuab";
$password = "6N452fMvy6zc";
$dbname = "u359278202_vawf";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bedsTest = "SELECT * FROM user";
$result = $conn->query($bedsTest);

if ($result->num_rows > 0) {
    echo"<h3>Test Output</h3>";
    //echo "<table><tr><th>ID</th><th>Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $uname = $row["username"];
        $passwd = $row["password"];
        echo "<p><strong>Username:</strong> $uname<br><strong>Password:</strong> $passwd</p>";
        //echo "<tr><td>" . $row["username"]. "</td><td>" . $row["password"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}


$conn->close();
?>

<?php require 'includes/footer.php';?>