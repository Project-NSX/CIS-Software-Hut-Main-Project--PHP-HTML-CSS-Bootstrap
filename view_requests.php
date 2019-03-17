<?php require 'includes/header.php';?>
<!--HTML HERE-->
<style>
h7 span{
    display: inline-block;
    margin-right: 2.5em;
}
</style>
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

echo "<h2>Request(s) Awaiting Action</h2>";
$awaitingAction = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '0' AND v.hrApproved LIKE '0'";
$awaitingActionresult = $link->query($awaitingAction);
if ($awaitingActionresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $awaitingActionresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $email = $row["email"];
        $phone = $row["phoneNumber"];
        $summary = $row["summary"];
        $visitAdded = $row["visitAddedDate"];
        $financialImp = $row["financialImplications"]; //done
        $visitorType = $row["visitorType"]; //done
        $visitorTypeEXT = $row["visitorTypeExt"]; //done
        $visitStart = $row["startDate"]; //done
        $visitEnd = $row["endDate"]; //done
        $startDisplay = date("d/m/Y", strtotime($visitStart));
        $endDisplay = date("d/m/Y", strtotime($visitEnd));
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded));

        echo "<div class='card' >";
        echo "<div class='card-header' id='$headingId' <button class='btn btn-link collapsed'  data-toggle='collapse' data-target='#$collapseId' aria-expanded='false' aria-controls='$collapseId'</button>";
        echo "<h7 class='mb-0'>  <span> <b>Name:</b> $fName $lName </span> <span> <b>Home Institution:</b> $homeInt </span> <span> <b>Email:</b> $email </span> <span> <b>Phone Number:</b> $phone </span>  </h7>";
        echo "</div>";
        echo "<div id='$collapseId' class='collapse' aria-labelledby='$collapseId' data-parent='#accordion'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Visit Summary</h5>";
        echo "<p class='card-text'>$summary</p>";
        echo "<h5 class='card-title'>Financial Implications</h5>";
        echo "<p class='card-text'>$financialImp</p>";
        echo "<h5 class='card-title'>Visitor Type</h5>";
        echo "<p class='card-text'>$visitorType &#8195; $visitorTypeEXT</p>";
        echo "<h5 class='card-title'>Visit Start & End Dates</h5>";
        echo "<p class='card-text'><b>Start:</b> $startDisplay &#8195; <b>End:</b> $endDisplay</p>";
        echo "<h5 class='card-title'>Date & Time of Initial Submission</h5>";
        echo "<p class='card-text'>$addedDisplay </p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<br>";
    }
    echo "</div>";
} else {
    echo "0 results";
}

echo "<h2>Request(s) Approved by Supervisor</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.suppervisorApproved, v.supervisorUsername, v.supervisorApprovedDate  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '2' AND v.hrApproved LIKE '0'";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $email = $row["email"];
        $phone = $row["phoneNumber"];
        $summary = $row["summary"];
        $visitAdded = $row["visitAddedDate"];
        $financialImp = $row["financialImplications"]; //done
        $visitorType = $row["visitorType"]; //done
        $visitorTypeEXT = $row["visitorTypeExt"]; //done
        $visitStart = $row["startDate"]; //done
        $visitEnd = $row["endDate"]; //done
        $startDisplay = date("d/m/Y", strtotime($visitStart));
        $endDisplay = date("d/m/Y", strtotime($visitEnd));
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded));
        $supervisorApproved = $row["suppervisorApproved"];
        $supervisorUname = $row["supervisorUsername"];

        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate));


        echo "<div class='card' >";
        echo "<div class='card-header' id='$headingId' <button class='btn btn-link collapsed'  data-toggle='collapse' data-target='#$collapseId' aria-expanded='false' aria-controls='$collapseId'</button>";
        echo "<h7 class='mb-0'>  <span> <b>Name:</b> $fName $lName </span> <span> <b>Home Institution:</b> $homeInt </span> <span> <b>Email:</b> $email </span> <span> <b>Phone Number:</b> $phone </span>  </h7>";
        echo "</div>";
        echo "<div id='$collapseId' class='collapse' aria-labelledby='$collapseId' data-parent='#accordion'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Visit Summary</h5>";
        echo "<p class='card-text'>$summary</p>";
        echo "<h5 class='card-title'>Financial Implications</h5>";
        echo "<p class='card-text'>$financialImp</p>";
        echo "<h5 class='card-title'>Visitor Type</h5>";
        echo "<p class='card-text'>$visitorType &#8195; $visitorTypeEXT</p>";
        echo "<h5 class='card-title'>Visit Start & End Dates</h5>";
        echo "<p class='card-text'><b>Start:</b> $startDisplay &#8195; <b>End:</b> $endDisplay</p>";
        echo "<h5 class='card-title'>Date & Time of Initial Submission</h5>";
        echo "<p class='card-text'>$addedDisplay </p>";
        echo "<h5 class='card-title'>Approver Username</h5>";
        echo "<p class='card-text'>$supervisorUname </p>";
        echo "<h5 class='card-title'>Approval Date & Time</h5>";
        echo "<p class='card-text'>$supervisorApprovedDateDisp </p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<br>";
    }
    echo "</div>";
} else {
    echo "0 results";
}
$link->close();
echo "<h2>Request(s) Disapproved by Supervisor</h2>";
echo "<h2>Request(s) Approved by Supervisor & HR</h2>";
echo "<h2>Request(s) Disapproved by HR</h2>";

?>
<?php require 'includes/footer.php';?>