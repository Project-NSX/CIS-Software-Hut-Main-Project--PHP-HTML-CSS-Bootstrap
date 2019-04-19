<?php $page ='HOSRPA'; require 'includes/header.php';?>
<!--HTML HERE-->
<style>
h6 span{
    display: inline-block;
    margin-right: 2.5em;
}
</style>
<h2>Head of School - Pending Requests</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--This page needs to show application pending approval from HR-->

<?php
//TODO Add functionality to approve and disapprove
require_once'includes/database.php';
//TODO: get rid of unecessqary columns and variables

echo "<h2>Head of School - Pending Requests</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, v.summary, v.financialImplications, v.startDate, v.endDate, v.visitAddedDate, va.fName, va.lName, va.homeInstitution, va.visitorType, va.visitorTypeExt FROM visit v, user u, school s, visitingAcademic va WHERE v.hostAcademic = u.username AND u.school_id = s.schoolId AND va.visitorId = v.visitorId AND u.school_id = '{$_SESSION['school_id']}' AND v.supervisorApproved LIKE '0' AND v.hostAcademic NOT LIKE '{$_SESSION['username']}' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $supervisorApprovedresult->fetch_assoc()) {
        //name, home inst, visit summary, financial imp, visitor type, start & end date
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
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
        ?>
        <div class="card">
        <div class="card-header" id ="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
        <div class="row" >
        <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
        <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
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
$link->close();

?>

<?php require 'includes/footer.php';?>

