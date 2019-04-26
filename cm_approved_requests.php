<!-- Variable to be used to highlight appropriate button in navbar -->
<?php $page = 'CMAR';
require 'includes/header.php';
require 'includes/verify_cm_role.php'; // Redirect if the user is not logged in as a college manager.
?>
<!--HTML HERE-->

<h2>College Manager - Approved Requests</h2>
<?php require 'includes/navbars/nav_picker.php'; ?>
<!--TODO: Add the ability to search for an approved request-->
<?php
require_once 'includes/database.php';
//SQL Statement to retrieve the appropriate cells from the tables
$supervisorApproved = "SELECT v.visitId, v.visitorId, v.summary, v.financialImplications, v.startDate, v.endDate, v.visitAddedDate, v.supervisorApprovedDate, va.fName, va.lName, va.homeInstitution, va.department, va.visitorType, va.visitorTypeExt, v.iprIssues, v.iprFile FROM visit v, user u, school s, visitingAcademic va WHERE v.hostAcademic = u.username AND u.school_id = s.schoolId AND va.visitorId = v.visitorId AND u.college_id = '{$_SESSION['college_id']}' AND u.role = 'Head Of School' AND v.supervisorApproved LIKE '3' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
echo "<h2>College Manager - Approved Requests</h2>";
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        //assigning returned columns to variables - made it easier to reference at a later stage
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
        $summary = $row["summary"];
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"];
        $visitorTypeEXT = $row["visitorTypeExt"];
        $visitStart = $row["startDate"];
        $visitEnd = $row["endDate"];
        $Dateadded = $row["visitAddedDate"];
        $department = $row["department"];
        //Convert Dates to how we want them displayed
        $startDisplay = date("d/m/Y", strtotime($visitStart));
        $endDisplay = date("d/m/Y", strtotime($visitEnd));
        $addedDisplay = date("d/m/Y", strtotime($Dateadded));
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $suppervisorApproveDisplay = date("d/m/Y", strtotime($supervisorApprovedDate));
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <!-- Used a card to make something similar to an accordion which was used to display data with brief into in header and detail in the collapsable section-->
        <div class="card">
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
                <div class="card-body">
                    <h5 class='card-title'>Visit Summary</h5>
                    <p class='card-text'><?php echo $summary ?></p>
                    <h5 class='card-title'>Financial Implications</h5>
                    <p class='card-text'><?php echo $financialImp ?></p>
                    <h5 class='card-title'>Visitor Type</h5>
                    <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo $visitorTypeEXT ?></p>
                    <h5 class='card-title'>Visit Start & End Dates</h5>
                    <p class='card-text'><b>Start:</b> <?php echo $startDisplay ?> &#8195; <b>End:</b> <?php echo $endDisplay ?>
                    </p>
                    <h5 class='card-title'>Date & Time of Initial Submission</h5>
                    <p class='card-text'><?php echo $addedDisplay ?> </p>
                    <h5 class='card-title'>Date & Time of Approval</h5>
                    <p class='card-text'><?php echo $suppervisorApproveDisplay ?> </p>
                    <!-- if there is a ipr issue in the database, display the file by allowing the user to download it -->
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
} else { }
$link->close();

?>

<?php require 'includes/footer.php'; ?>