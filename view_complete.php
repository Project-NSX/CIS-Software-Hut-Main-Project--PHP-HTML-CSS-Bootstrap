<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'VC';
require 'includes/header.php';
require 'includes/deny_hr_role.php' // Redirects users with the "Human Resources" role to prevent access to this page
?>
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
    //if 1 or more results are returned, execute the following code to display the information
echo $lang['reqComp'];

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
                    <div class='col-sm'><b><?php echo $lang['department'] ?>: </b> <?php echo $department ?></div>
                    <div class='col-sm'><b><?php echo $lang['Email'] ?>: </b> <?php echo $email ?></div>
                    <div class='col-sm'><b><?php echo $lang['Phone Number'] ?>:</b> <?php echo $phone ?></div>
                </div>
                <div class="row">
                    <div class='col-md-1 offset-md-11' style="text-align: right;"><?php echo $lang['seeMore'] ?> &#x25BC</div>
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
<!-- if there is an IPR issue (field value = 1)display file, otherwise don't -->
                    <?php if ($iprIssues == 1) {
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

//SQL statement to retrieve columns from database table
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment, v.cancelTime, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '4' AND v.hrApproved LIKE '4'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    //if 1 or more results are returned, execute the following code to display the information

echo $lang['reqCan'];

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
        $visitAdded = htmlspecialchars($row["visitAddedDate"]);
        $financialImp = htmlspecialchars($row["financialImplications"]);
        $visitorType = htmlspecialchars($row["visitorType"]);
        $visitorTypeEXT = htmlspecialchars($row["visitorTypeExt"]);
        $visitStart = $row["startDate"];
        $visitEnd = $row["endDate"];
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
        $hrComment = htmlspecialchars($row['hrComment']);
        $cancelTime = $row['cancelTime'];
        $cancelTimeDisplay = date("d/m/Y - g:iA", strtotime($cancelTime));
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>

           <!-- Using a card as an accordion -->
           <div class="card">
                <div class="card-header" id="<?php echo $headingId ?>" <button class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                    <div class="row">
                        <div class='col-sm'><b><?php echo $lang['Name'] ?>: </b> <?php echo htmlspecialchars($fName) . " " . htmlspecialchars($lName) ?></div>
                        <div class='col-sm'><b><?php echo $lang['Home Institution'] ?>: </b> <?php echo htmlspecialchars($homeInt) ?></div>
                        <div class='col-sm'><b><?php echo $lang['Department'] ?>: </b> <?php echo htmlspecialchars($department) ?></div>
                        <div class='col-sm'><b><?php echo $lang['Cancelled Date'] ?>: </b> <?php echo $cancelTimeDisplay ?></div>
                    </div>
                    <div class="row">
                        <div class='col-md-1 offset-md-11' style="text-align: right;"><?php echo $lang['seeMore'] ?> &#x25BC</div>
                    </div>
                </div>
                <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
                    <div class="card-body">

                        <h5 class='card-title'><?php echo $lang['Email'] ?></h5>
                        <p class='card-text'><?php echo $email ?></p>
                        <h5 class='card-title'><?php echo $lang['Phone Number'] ?></h5>
                        <p class='card-text'><?php echo $phone ?></p>
                        <h5 class='card-title'><?php echo $lang['Visit Summary'] ?></h5>
                        <p class='card-text'><?php echo $summary ?></p>
                        <h5 class='card-title'><?php echo $lang['Financial Implications'] ?></h5>
                        <p class='card-text'><?php echo $financialImp ?></p>
                        <h5 class='card-title'><?php echo $lang['Visitor Type'] ?></h5>
                        <p class='card-text'><?php echo $visitorType ?> &#8195; <?php echo $visitorTypeEXT ?></p>
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
                        <h5 class='card-title'><?php echo $lang['HR Comment'] ?></h5>
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
} else { }
$link->close();
?>
<?php require 'includes/footer.php'; ?>