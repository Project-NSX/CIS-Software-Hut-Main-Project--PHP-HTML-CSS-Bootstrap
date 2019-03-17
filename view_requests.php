<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Pending Requests</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!-- TODO: https://www.w3schools.com/php/php_mysql_select.asp
    https://www.siteground.com/tutorials/php-mysql/display-table-data/
    Make this page display a table of incomplete requests (hos / hr approved : false?)

    TODO: when clicked on the table should show full details of the VA and the visit

-->

<?php
require_once'includes/database.php';

$currentAcademic = $_SESSION['username'];

$doIt = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '0' AND v.hrApproved LIKE '0'";
$result = $link->query($doIt);

if ($result->num_rows > 0) {
    echo "<h2>Example</h2>";
    echo "<div id='accordion'>";
    while($row = $result->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;

        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $email = $row["email"];
        $phone = $row["phoneNumber"];
        echo "<div class='card' >";
        echo "<div class='card-header' id='$headingId'>";
        echo "<h5 class='mb-0'> <button class='btn btn-link collapsed' data-toggle='collapse' data-target='#$collapseId' aria-expanded='false' aria-controls='$collapseId'>Name: $fName $lName &#8195; Home Institution: $homeInt &#8195; Email: $email &#8195; Phone Number: $phone</button> </h5>";
        echo "</div>";
        echo "<div id='$collapseId' class='collapse' aria-labelledby='$collapseId' data-parent='#accordion'>";
        echo "<div class='card-body'> $visitorId </div>";
        echo "</div>";
        echo "</div>";
        echo "<br>";
    }
    echo "</div>";
} else {
    echo "0 results";
}


$link->close();
?>
<?php require 'includes/footer.php';?>