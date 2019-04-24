<?php $page = 'home';
require 'includes/header.php'; ?>
<!--HTML HERE-->
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>
<style>
    span {
        display: inline-block;
        margin-right: 2.5em;
    }
</style>
<h2>Pending Requests</h2>

<?php require 'includes/navbars/nav_picker.php'; ?>
<!-- TODO: Get this to display title of the VA (with the titleExt being displayed as well if the value is "other")

-->

<?php
require_once 'includes/database.php';
if (isset($_POST['VRAACancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRAACancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRAA]'";
    mysqli_query($link, $VRAACancelQuery);
};
if (isset($_POST['VRABSCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRABSCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRABS]'";
    mysqli_query($link, $VRABSCancelQuery);
};
if (isset($_POST['VRDBSCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRDBSCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRDBS]'";
    mysqli_query($link, $VRDBSCancelQuery);
};
if (isset($_POST['VRABSHRCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRABSHRCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRABSHR]'";
    mysqli_query($link, $VRABSHRCancelQuery);
};
if (isset($_POST['VRDBHRCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRDBHRCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRDBHR]'";
    mysqli_query($link, $VRDBHRCancelQuery);
};


$currentAcademic = $_SESSION['username'];

echo "<h2>Request(s) Awaiting Action</h2>";
$awaitingAction = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '0' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$awaitingActionresult = $link->query($awaitingAction);
if ($awaitingActionresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $awaitingActionresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $department = $row["department"];
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
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
            <div class="card">
                <div class="card-header" id="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                    <div class="row">
                        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                        <div class='col-sm'><b>Department: </b> <?php echo $department ?></div>
                        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
                        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
                    </div>
                    <div class="row">
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
                        <?php if ($iprIssues == 1) {
                            echo "<h5 class='card-title'>IPR Issues File:</h5>";
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <input type=hidden name=hiddenVRAA value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <div class="col-md"><input type=submit name=VRAACancel value='Cancel Visit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>
        <br>
    <?php
}
echo "</div>";
} else {
    echo "0 results";
}

echo "<h2>Request(s) Approved by Supervisor</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.iprIssues, v.iprFile FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $department = $row["department"];
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
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
            <div class="card">
                <div class="card-header" id="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                    <div class="row">
                        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                        <div class='col-sm'><b>Department: </b> <?php echo $department ?></div>
                        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
                        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
                    </div>
                    <div class="row">
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
                        <?php if ($iprIssues == 1) {
                            echo "<h5 class='card-title'>IPR Issues File:</h5>";
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <input type=hidden name=hiddenVRABS value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <div class="col-md"><input type=submit name=VRABSCancel value='Cancel Visit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>
        <br>
    <?php
}
echo "</div>";
} else {
    echo "0 results";
}

echo "<h2>Request(s) Denied by Supervisor</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.supervisorComment, v.iprIssues, v.iprFile FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '1' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $department = $row["department"];
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
        $supervisorComment = $row["supervisorComment"];
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
            <div class="card">
                <div class="card-header" id="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                    <div class="row">
                        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                        <div class='col-sm'><b>Department: </b> <?php echo $department ?></div>
                        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
                        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
                    </div>
                    <div class="row">
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
                        <?php if ($iprIssues == 1) {
                            echo "<h5 class='card-title'>IPR Issues File:</h5>";
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <input type=hidden name=hiddenVRDBS value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <div class="col-md"><input type=submit name=VRDBSCancel value='Cancel Visit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>
        <br>
    <?php

}
echo "</div>";
} else {
    echo "0 results";
}

//TODO: section for ones to be resubmitted
echo "<h2>Request(s) Approved by Supervisor & HR</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '3'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $department = $row["department"];
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
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
            <div class="card">
                <div class="card-header" id="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                    <div class="row">
                        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                        <div class='col-sm'><b>Department: </b> <?php echo $department ?></div>
                        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
                        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
                    </div>
                    <div class="row">
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
                        <?php if ($iprIssues == 1) {
                            echo "<h5 class='card-title'>IPR Issues File:</h5>";
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <input type=hidden name=hiddenVRABSHR value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <div class="col-md"><input type=submit name=VRABSHRCancel value='Cancel Visit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>
        <br>
    <?php
}
echo "</div>";
} else {
    echo "0 results";
}
echo "<h2>Request(s) Denied by HR</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '1'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $department = $row["department"];
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
        $hrComment = $row['hrComment'];
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
            <div class="card">
                <div class="card-header" id="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                    <div class="row">
                        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                        <div class='col-sm'><b>Department: </b> <?php echo $department ?></div>
                        <div class='col-sm'><b>Email: </b> <?php echo $email ?></div>
                        <div class='col-sm'><b>Phone Number:</b> <?php echo $phone ?></div>
                    </div>
                    <div class="row">
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
                        <?php if ($iprIssues == 1) {
                            echo "<h5 class='card-title'>IPR Issues File:</h5>";
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <input type=hidden name=hiddenVRDBHR value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <div class="col-md"><input type=submit name=VRDBHRCancel value='Cancel Visit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>

        <br>
    <?php
}
echo "</div>";
} else {
    echo "0 results";
}

echo "<h2>Cancelled Request(s)</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment, v.cancelTime, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '4' AND v.hrApproved LIKE '4'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $department = $row["department"];
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
        $hrComment = $row['hrComment'];
        $cancelTime = $row['cancelTime'];
        $cancelTimeDisplay = date("d/m/Y - g:iA", strtotime($cancelTime));
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>

        <form action=view_requests.php method=post>
            <div class="card">
                <div class="card-header" id="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                    <div class="row">
                        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                        <div class='col-sm'><b>Department: </b> <?php echo $department ?></div>
                        <div class='col-sm'><b>Cancelled Date: </b> <?php echo $cancelTimeDisplay ?></div>
                    </div>
                    <div class="row">
                        <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
                    </div>
                </div>
                <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
                    <div class="card-body">

                        <h5 class='card-title'>Email</h5>
                        <p class='card-text'><?php echo $email ?></p>
                        <h5 class='card-title'>Phone Number</h5>
                        <p class='card-text'><?php echo $phone ?></p>
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
                        <?php if ($iprIssues == 1) {
                            echo "<h5 class='card-title'>IPR Issues File:</h5>";
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <input type=hidden name=hiddenVRDBHR value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <div class="col-md"><input type=submit name=VRDBHRCancel value='Cancel Visit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>

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
<?php require 'includes/footer.php'; ?>