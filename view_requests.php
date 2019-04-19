<?php $page ='VR'; require 'includes/header.php';?>
<!--HTML HERE-->
<style>
span{
    display: inline-block;
    margin-right: 2.5em;
}
</style>
<h2>Pending Requests</h2>

<?php require'includes/navbars/nav_picker.php';?>
<!-- TODO: Get this to display title of the VA (with the titleExt being displayed as well if the value is "other")

-->

<?php
require_once'includes/database.php';

$currentAcademic = $_SESSION['username'];

echo "<h2>Request(s) Awaiting Action</h2>";
$awaitingAction = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '0' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$awaitingActionresult = $link->query($awaitingAction);
if ($awaitingActionresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $awaitingActionresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
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
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); ?>
       <div class="card">
        <div class="card-header" id ="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
        <div class="row" >
        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
        </div>
        <div class="row" >
        <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
        </div>
        </div>
        <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
        <div class="card-body">


        <h5 class='card-title'>Visit Summary</h5>
        <p class='card-text'><?php echo $summary ?></p>
        <h5 class='card-title'>Financial Implications</h5>
        <p class='card-text'><?php echo $financialImp ?></p>
        <h5 class='card-title'>Visitor Type</h5>
        <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo $visitorTypeEXT ?></p>
        <h5 class='card-title'>Visit Start & End Dates</h5>
        <p class='card-text'><b>Start:</b> <?php echo $startDisplay ?> &#8195; <b>End:</b> <?php echo $endDisplay ?></p>
        <h5 class='card-title'>Date & Time of Initial Submission</h5>
        <p class='card-text'><?php echo $addedDisplay ?> </p>
        </div>
        </div>
        </div>

        <br>
       <?php
    }
    echo "</div>";
} else {
    echo "0 results";
}

echo "<h2>Request(s) Approved by Supervisor</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
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
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); ?>
        <div class="card">
        <div class="card-header" id ="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
        <div class="row" >
        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
        </div>
        <div class="row" >
        <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
        </div>
        </div>
        <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
        <div class="card-body">


        <h5 class='card-title'>Visit Summary</h5>
        <p class='card-text'><?php echo $summary ?></p>
        <h5 class='card-title'>Financial Implications</h5>
        <p class='card-text'><?php echo $financialImp ?></p>
        <h5 class='card-title'>Visitor Type</h5>
        <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo $visitorTypeEXT ?></p>
        <h5 class='card-title'>Visit Start & End Dates</h5>
        <p class='card-text'><b>Start:</b> <?php echo $startDisplay ?> &#8195; <b>End:</b> <?php echo $endDisplay ?></p>
        <h5 class='card-title'>Date & Time of Initial Submission</h5>
        <p class='card-text'><?php echo $addedDisplay ?> </p>
        <h5 class='card-title'>Supervisor Username</h5>
        <p class='card-text'><?php echo $supervisorUname ?> </p>
        <h5 class='card-title'>Date & Time of Decision</h5>
        <p class='card-text'><?php echo $supervisorApprovedDateDisp ?> </p>
        </div>
        </div>
        </div>

        <br>
       <?php
    }
    echo "</div>";
} else {
    echo "0 results";
}

echo "<h2>Request(s) Denied by Supervisor</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.supervisorComment FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '1' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
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
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate));
        $supervisorComment = $row["supervisorComment"]; ?>
        <div class="card">
        <div class="card-header" id ="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
        <div class="row" >
        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
        </div>
        <div class="row" >
        <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
        </div>
        </div>
        <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
        <div class="card-body">

        <h5 class='card-title'>Visit Summary</h5>
        <p class='card-text'><?php echo $summary ?></p>
        <h5 class='card-title'>Financial Implications</h5>
        <p class='card-text'><?php echo $financialImp ?></p>
        <h5 class='card-title'>Visitor Type</h5>
        <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo $visitorTypeEXT ?></p>
        <h5 class='card-title'>Visit Start & End Dates</h5>
        <p class='card-text'><b>Start:</b> <?php echo $startDisplay ?> &#8195; <b>End:</b> <?php echo $endDisplay ?></p>
        <h5 class='card-title'>Date & Time of Initial Submission</h5>
        <p class='card-text'><?php echo $addedDisplay ?> </p>
        <h5 class='card-title'>Supervisor Username</h5>
        <p class='card-text'><?php echo $supervisorUname ?> </p>
        <h5 class='card-title'>Supervisor Comment</h5>
        <p class='card-text'><?php echo $supervisorComment ?> </p>
        <h5 class='card-title'>Date & Time of Decision</h5>
        <p class='card-text'><?php echo $supervisorApprovedDateDisp ?> </p>
        </div>
        </div>
        </div>

        <br>
       <?php

    }
    echo "</div>";
} else {
    echo "0 results";
}

//TODO: section for ones to be resubmitted
echo "<h2>Request(s) Approved by Supervisor & HR</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '3'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
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
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate));
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"];
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate)); ?>

<div class="card">
        <div class="card-header" id ="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
        <div class="row" >
        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
        </div>
        <div class="row" >
        <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
        </div>
        </div>
        <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
        <div class="card-body">


        <h5 class='card-title'>Visit Summary</h5>
        <p class='card-text'><?php echo $summary ?></p>
        <h5 class='card-title'>Financial Implications</h5>
        <p class='card-text'><?php echo $financialImp ?></p>
        <h5 class='card-title'>Visitor Type</h5>
        <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo $visitorTypeEXT ?></p>
        <h5 class='card-title'>Visit Start & End Dates</h5>
        <p class='card-text'><b>Start:</b> <?php echo $startDisplay ?> &#8195; <b>End:</b> <?php echo $endDisplay ?></p>
        <h5 class='card-title'>Date & Time of Initial Submission</h5>
        <p class='card-text'><?php echo $addedDisplay ?> </p>
        <h5 class='card-title'>Supervisor Username</h5>
        <p class='card-text'><?php echo $supervisorUname ?> </p>
        <h5 class='card-title'>Date & Time of Decision</h5>
        <p class='card-text'><?php echo $supervisorApprovedDateDisp ?> </p>
        <h5 class='card-title'>HR Practitioner Username</h5>
        <p class='card-text'><?php echo $hrUname ?> </p>
        <h5 class='card-title'>Date & Time of Decision</h5>
        <p class='card-text'><?php echo $hrApprovedDateDisp ?> </p>
        </div>
        </div>
        </div>

        <br>
       <?php
    }
    echo "</div>";
} else {
    echo "0 results";
}
echo "<h2>Request(s) Denied by HR</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '".$currentAcademic."%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '1'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
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
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate));
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"];
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate));
        $hrComment = $row['hrComment']; ?>

        <div class="card">
        <div class="card-header" id ="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
        <div class="row" >
        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
        </div>
        <div class="row" >
        <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
        </div>
        </div>
        <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
        <div class="card-body">

        <h5 class='card-title'>Visit Summary</h5>
        <p class='card-text'><?php echo $summary ?></p>
        <h5 class='card-title'>Financial Implications</h5>
        <p class='card-text'><?php echo $financialImp ?></p>
        <h5 class='card-title'>Visitor Type</h5>
        <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo $visitorTypeEXT ?></p>
        <h5 class='card-title'>Visit Start & End Dates</h5>
        <p class='card-text'><b>Start:</b> <?php echo $startDisplay ?> &#8195; <b>End:</b> <?php echo $endDisplay ?></p>
        <h5 class='card-title'>Date & Time of Initial Submission</h5>
        <p class='card-text'><?php echo $addedDisplay ?> </p>
        <h5 class='card-title'>Supervisor Username</h5>
        <p class='card-text'><?php echo $supervisorUname ?> </p>
        <h5 class='card-title'>Date & Time of Decision</h5>
        <p class='card-text'><?php echo $supervisorApprovedDateDisp ?> </p>
        <h5 class='card-title'>HR Practitioner Username</h5>
        <p class='card-text'><?php echo $hrUname ?> </p>
        <h5 class='card-title'>Date & Time of Decision</h5>
        <p class='card-text'><?php echo $hrApprovedDateDisp ?> </p>
        <h5 class='card-title'>HR Comment</h5>
        <p class='card-text'><?php echo $hrComment ?> </p>
        </div>
        </div>
        </div>

        <br>
       <?php
    }
    echo "</div>";
} else {
    echo "0 results";
}

//TODO: section for resubmitted ones
$link->close();

?>
<?php require 'includes/footer.php';?>