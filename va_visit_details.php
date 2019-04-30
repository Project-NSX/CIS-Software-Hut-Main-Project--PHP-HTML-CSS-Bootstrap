<?php
require 'includes/header.php';
require 'includes/verify_va_role.php';
?>

<!-- <?php require 'includes/navbars/nav_picker.php'; ?> -->

<?php
require_once 'includes/database.php';

$uname = $_SESSION["username"];

$sql = "SELECT visitorId FROM vaLogin WHERE username LIKE '" . $uname . "%'";
$result = $link->query($sql);
while ($row = $result->fetch_assoc()) {
    $visit = $row['visitorId'];
}
//SQL statement to retrieve columns from database table
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.induction, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.visitorId LIKE '" . $visit . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '3' AND v.induction LIKE '0' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {

    // If 1 or more results are returned, display each results as a separate card
    echo $lang['reqInduction'];

    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        //store row value of specified column in variable
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = htmlspecialchars($row["fName"]);
        $lName = htmlspecialchars($row["lName"]);
        $homeInt = htmlspecialchars($row["homeInstitution"]);
        $department = htmlspecialchars($row["department"]);
        $email = htmlspecialchars($row["email"]);
        $phone = htmlspecialchars($row["phoneNumber"]);
        $summary = htmlspecialchars($row["summary"]);
        $visitAdded = $row["visitAddedDate"];
        $financialImp = htmlspecialchars($row["financialImplications"]);
        $visitorType = $row["visitorType"]; //done
        $visitorTypeEXT = htmlspecialchars($row["visitorTypeExt"]);
        $visitStart = $row["startDate"]; //done
        $visitEnd = $row["endDate"]; //done
        $startDisplay = date("d/m/Y", strtotime($visitStart)); //convert date format to a user friendly manner
        $endDisplay = date("d/m/Y", strtotime($visitEnd)); //convert date format to a user friendly manner
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); //convert date format to a user friendly manner
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //convert date format to a user friendly manner
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"];
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate)); //convert date format to a user friendly manner
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>

        <!-- Using a card as an accordion -->
        <div class="card">
            <!-- Unique id and data target provided by database field which is unique, this is done so only one card expands on click rather than all of them -->
            <div class="card-header" id="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                <div class="row">
                    <div class='col-sm'><b><?php echo $lang['Name'] ?>: </b> <?php echo $fName . " " . $lName ?></div>
                    <div class='col-sm'><b><?php echo $lang['Home Institution'] ?>: </b> <?php echo $homeInt ?></div>
                    <div class='col-sm'><b><?php echo $lang['Department'] ?>: </b> <?php echo $department ?></div>
                    <div class='col-sm'><b><?php echo $lang['Email'] ?>: </b> <?php echo $email ?></div>
                    <div class='col-sm'><b><?php echo $lang['Phone Number'] ?>:</b> <?php echo $phone ?></div>
                </div>
                <div class="row">
                    <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
                </div>
            </div>
            <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
                <div class="card-body">
                    <h5 class='card-title'><?php echo $lang['Visit Summary'] ?></h5>
                    <p class='card-text'><?php echo htmlspecialchars($summary) ?></p>
                    <h5 class='card-title'><?php echo $lang['Financial Implications'] ?></h5>
                    <p class='card-text'><?php echo htmlspecialchars($financialImp) ?></p>
                    <h5 class='card-title'><?php echo $lang['Visitor Type'] ?></h5>
                    <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo htmlspecialchars($visitorTypeEXT) ?></p>
                    <h5 class='card-title'><?php echo $lang['Visit Start & End Dates'] ?></h5>
                    <p class='card-text'><b><?php echo $lang['Start'] ?>:</b> <?php echo $startDisplay ?> &#8195; <b><?php echo $lang['End'] ?>:</b> <?php echo $endDisplay ?></p>
                    <h5 class='card-title'><?php echo $lang['Date & Time of Initial Submission'] ?></h5>
                    <p class='card-text'><?php echo $addedDisplay ?> </p>
                    <h5 class='card-title'><?php echo $lang['Supervisor Username'] ?></h5>
                    <p class='card-text'><?php echo $supervisorUname ?> </p>
                    <h5 class='card-title'><?php echo $lang['Date & Time of Decision'] ?></h5>
                    <p class='card-text'><?php echo $supervisorApprovedDateDisp ?> </p>
                    <h5 class='card-title'><?php echo $lang['HR Practitioner Username'] ?></h5>
                    <p class='card-text'><?php echo $hrUname ?> </p>
                    <h5 class='card-title'><?php echo $lang['Date & Time of Decision'] ?></h5>
                    <p class='card-text'><?php echo $hrApprovedDateDisp ?> </p>

                    <!-- if there is an IPR issue (field value = 1) - display the IPR deed file -->
                    <?php
                    if ($iprIssues == 1) {
                        echo $lang['IPR'];
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

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#health-safety-dialog">
    Open Modal
</button>
<div class="modal fade" id="health-safety-dialog" tabindex="-1" role="dialog" aria-labelledby="health-safety-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="health-safety-title"><?php echo $lang["H&S Induction"] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <p><?php echo $lang["H&S Intro"] ?></p>
            <a href="<?php echo $lang["H&S Policy Link"] ?>" target="_blank"><?php echo $lang["H&S Link"] ?></a>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lang["Cancel"] ?></button>
            <button type="button" class="btn btn-primary"><?php echo $lang["Proceed"] ?></button>
        </div>
    </div>
    </div>

</div>
<?php require 'includes/footer.php'; ?>