<?php require 'includes/header.php';?>
<!--HTML HERE-->
<style>
.btnG {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 25%;
}
.btnR {
  background-color: Red;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 25%;
}
.btnA {
  background-color: Orange;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 25%;
}
</style>
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
        echo "<button class='btnG'>Approve Request</button> <button class='btnR' >Deny Request</button> <button class='btnA' >Prompt User to Resubmit</button>";
        //echo "<tr><td>" . $row["username"]. "</td><td>" . $row["password"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}


$conn->close();
?>

<?php require 'includes/footer.php';?>