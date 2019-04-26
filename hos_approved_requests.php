<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'HOSAR';
require 'includes/header.php';
require 'includes/verify_hos_role.php'; // Redirect if the user is not logged in as a head of school.
?>
<!--HTML HERE-->

<h2>Head of School - Approved Requests</h2>
<?php require 'includes/navbars/nav_picker.php'; ?>
<!--This page needs to show application pending approval from HR-->

<?php
require_once 'includes/database.php';
//SQL statement to get the appropriate columns from the DB
$supervisorApproved = "SELECT v.visitId, v.visitorId, v.summary, v.financialImplications, v.startDate, v.endDate, v.visitAddedDate, v.supervisorApprovedDate, va.fName, va.lName, va.homeInstitution, va.department, va.visitorType, va.visitorTypeExt, v.iprIssues, v.iprFile FROM visit v, user u, school s, visitingAcademic va WHERE v.hostAcademic = u.username AND u.school_id = s.schoolId AND va.visitorId = v.visitorId AND u.school_id = '{$_SESSION['school_id']}' AND v.supervisorApproved LIKE '3' AND v.hostAcademic NOT LIKE '{$_SESSION['username']}' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>Head of School - Approved Requests</h2>";

    echo "<div id='accordion'>";
    //assigning column values to variables - easier to use at a later stage
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
        $summary = $row["summary"];
        $financialImp = $row["financialImplications"]; //done
        $visitorType = $row["visitorType"]; //done
        $visitorTypeEXT = $row["visitorTypeExt"]; //done
        $visitStart = $row["startDate"]; //done
        $visitEnd = $row["endDate"]; //done
        $Dateadded = $row["visitAddedDate"];
        $startDisplay = date("d/m/Y", strtotime($visitStart));
        $endDisplay = date("d/m/Y", strtotime($visitEnd));
        $addedDisplay = date("d/m/Y", strtotime($Dateadded));
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $suppervisorApproveDisplay = date("d/m/Y", strtotime($supervisorApprovedDate));
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <!-- Used a card as an accordion to present the information in a condense way -->
        <div class="card">
            <!-- Key Points -->
            <div class="card-header" id="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                <div class="row">
                    <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                    <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                    <div class='col-sm'><b>Department: </b> <?php echo $department ?></div>
                </div>
                <div class="row">
                    <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
                </div>
            </div>
            <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
                <!-- More detail about the visit -->
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
                    <h5 class='card-title'>Date & Time of Approval</h5>
                    <p class='card-text'><?php echo $suppervisorApproveDisplay ?> </p>
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
//doesn't print anything if nothing's returned
} else {
}
$link->close();

?>

<?php require 'includes/footer.php'; ?>