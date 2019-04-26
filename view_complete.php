<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'VC';
require 'includes/header.php'; ?>
<!--HTML HERE-->

<h2>Completed Visits</h2>
<?php require 'includes/navbars/nav_picker.php'; ?>

<?php
require_once 'includes/database.php';

$currentAcademic = $_SESSION['username'];

//SQL statement to retrieve columns from database table
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.induction, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '3' AND v.induction LIKE '1' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
echo "<h2>Completed Visit(s)</h2>";

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

        <div class="card">
            <div class="card-header" id="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                <div class="row">
                    <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                    <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                    <div class='col-sm'><b>department: </b> <?php echo $department ?></div>
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

        <br>
    <?php

}
echo "</div>";
} else {
}

$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment, v.cancelTime, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '4' AND v.hrApproved LIKE '4'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
echo "<h2>Cancelled Request(s)</h2>";

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
        <br>
    <?php
}
echo "</div>";
} else {
}
$link->close();
?>
<?php require 'includes/footer.php'; ?>