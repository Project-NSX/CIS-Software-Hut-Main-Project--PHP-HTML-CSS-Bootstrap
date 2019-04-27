<!-- Variable to be used to highlight appropriate button in navbar -->
<?php $page = 'home';
require 'includes/header.php';
require 'includes/deny_hr_role.php' // Redirects users with the "Human Resources" role to prevent access to this page
?>
<!--Javascript to disable Enter key from submitting-->
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
//TODO: check sql statements and button clicks
require_once 'includes/database.php';
//Cancel Action for section Visit Requests awaiting action
if (isset($_POST['VRAACancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRAACancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRAA]'";
    mysqli_query($link, $VRAACancelQuery);
};
//Cancel Action for section Visit Requests approved by Supervisor
if (isset($_POST['VRABSCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRABSCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRABS]'";
    mysqli_query($link, $VRABSCancelQuery);
};
//Cancel Action for section Visit Requests denied by Supervisor
if (isset($_POST['VRDBSCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRDBSCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRDBS]'";
    mysqli_query($link, $VRDBSCancelQuery);
};
//Cancel Action for section Visit Requests Approved by Supervisor & HR
if (isset($_POST['VRABSHRCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRABSHRCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRABSHR]'";
    mysqli_query($link, $VRABSHRCancelQuery);
};
//Cancel Action for section Visit Requests denied by HR
if (isset($_POST['VRDBHRCancel'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $VRDBHRCancelQuery = "UPDATE visit SET supervisorApproved = 4, hrApproved = 4, cancelTime = '$publish_date' WHERE visitId = '$_POST[hiddenVRDBHR]'";
    mysqli_query($link, $VRDBHRCancelQuery);
};

//Cancel Action for section Visit(s) Prompted for Resubmission by HR
if (isset($_POST['RPFRBHRSend'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $s_date = $_POST['s_date'];
    $e_date = $_POST['e_date'];
    $summary = $_POST['summary'];
    $financialImp = $_POST['financialImp'];

    if (!empty($_FILES['file']['name'])) {
        $pathinfo = pathinfo($_FILES['file']['name']);
        $base = $pathinfo['filename'];
        $base = preg_replace('/[^a-zA-Z0-9_-]/', "_", $base);
        $base = mb_substr($base, 0, 200);
        $filename = $base . "." . $pathinfo['extension'];
        $destination = "ipr/$filename";
        $i = 1;

        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "ipr/$filename";
            $i++;
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            $iprBool = 1;
            $RPFRBHRSendQuery = "UPDATE visit SET visitAddedDate = '$publish_date', startDate = '$s_date', endDate = '$e_date', summary = '$summary', financialImplications = '$financialImp', iprIssues = '$iprBool', iprFile = '$filename', supervisorApproved = 0, supervisorUsername = NULL, supervisorApprovedDate = NULL, supervisorCOmment = NULL, hrApproved = 0, hrUsername = NULL, hrApprovedDate = NULL, hrComment = NULL WHERE visitId = '$_POST[hiddenRPFRBHR]'";
        }
    }
    if ($iprBool != 1) {
        $iprBool = 0;
        $RPFRBHRSendQuery = "UPDATE visit SET visitAddedDate = '$publish_date', startDate = '$s_date', endDate = '$e_date', summary = '$summary', financialImplications = '$financialImp', iprIssues = '$iprBool', iprFile = NULL, supervisorApproved = 0, supervisorUsername = NULL, supervisorApprovedDate = NULL, supervisorCOmment = NULL, hrApproved = 0, hrUsername = NULL, hrApprovedDate = NULL, hrComment = NULL WHERE visitId = '$_POST[hiddenRPFRBHR]'";
    }
    mysqli_query($link, $RPFRBHRSendQuery);
};
//Cancel Action for section Visit(s) Prompted for Resubmission by Supervisor
if (isset($_POST['RPFRBSSend'])) {
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $s_date = $_POST['s_date'];
    $e_date = $_POST['e_date'];
    $summary = $_POST['summary'];
    $financialImp = $_POST['financialImp'];

    if (!empty($_FILES['file']['name'])) {
        $pathinfo = pathinfo($_FILES['file']['name']);
        $base = $pathinfo['filename'];
        $base = preg_replace('/[^a-zA-Z0-9_-]/', "_", $base);
        $base = mb_substr($base, 0, 200);
        $filename = $base . "." . $pathinfo['extension'];
        $destination = "ipr/$filename";
        $i = 1;

        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "ipr/$filename";
            $i++;
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            $iprBool = 1;
        }
    } else {
        $iprBool = 0;
        $filename = null;
    }
    $RPFRBSSendQuery = "UPDATE visit SET visitAddedDate = '$publish_date', startDate = '$s_date', endDate = '$e_date', summary = '$summary', financialImplications = '$financialImp', iprIssues = '$iprBool', iprFile = '$filename', supervisorApproved = 0, supervisorUsername = NULL, supervisorApprovedDate = NULL, supervisorCOmment = NULL, hrApproved = 0, hrUsername = NULL, hrApprovedDate = NULL, hrComment = NULL WHERE visitId = '$_POST[hiddenRPFRBS]'";
    mysqli_query($link, $RPFRBSSendQuery);
};

$currentAcademic = $_SESSION['username'];
//SQL statement to retrieve all the required columns from the visit and visitingAcademic tables in the database
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment, v.iprIssues, v.iprFile, va.title, va.street, va.city, va.county, va.postcode  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '2'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>Request(s) Prompted for Resubmission by HR </h2>";
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $fName = $row["fName"]; //
        $lName = $row["lName"]; //
        $title = $row["title"]; //
        $homeInstitution = $row["homeInstitution"]; //
        $department = $row["department"]; //
        $street = $row["street"]; //
        $city = $row["city"]; //
        $county = $row["county"]; //
        $postcode = $row["postcode"]; //
        $email = $row["email"]; //
        $phoneNumber = $row["phoneNumber"]; //
        $visitAdded = $row["visitAddedDate"]; //
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"]; //
        $visitorTypeEXT = $row["visitorTypeExt"]; //
        $visitStart = $row["startDate"]; //
        $visitEnd = $row["endDate"]; //
        $summary = $row["summary"];
        $startDisplay = date("d/m/Y", strtotime($visitStart));
        $startDisplayDateDisp = date("Y-m-d", strtotime($visitStart));
        $endDisplay = date("d/m/Y", strtotime($visitEnd));
        $endDisplayDateDisp = date("Y-m-d", strtotime($visitEnd));
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded));
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //format the date to be displayed in a clear and concise way
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"]; //
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate));
        $hrComment = $row['hrComment'];
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post enctype="multipart/form-data">
            <fieldset>
                <legend>Supervisor Decision Details </legend>
                <div class='row'>
                    <div class='col-sm-3'><b>Supervisor Username:</b></div>
                    <div class='col-sm-3'><?php echo $supervisorUname ?></div>
                    <div class='col-sm-3'><b>Date Action Taken:</b></div>
                    <div class='col-sm-3'><?php echo $supervisorApprovedDateDisp ?></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>HR Decision Details</legend>
                <div class='row'>
                    <div class='col-sm-3'><b>HR Practitioner Username:</b></div>
                    <div class='col-sm-3'><?php echo $hrUname ?></div>
                    <div class='col-sm-3'><b>Date Action Taken:</b></div>
                    <div class='col-sm-3'><?php echo $hrApprovedDateDisp ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm-3'><b>Comment:</b></div>
                    <div class='col-sm-9'><?php echo $hrComment ?></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Personal Details</legend>
                <div class='row'>
                    <div class='col-sm'><b>Title:</b></div>
                    <div class='col-sm'><?php echo $title ?></div>
                    <div class='col-sm'><b>First Name:</b></div>
                    <div class='col-sm'><?php echo $fName ?></div>
                    <div class='col-sm'><b>Last Name:</b></div>
                    <div class='col-sm'><?php echo $lName ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm'><b>Email Address:</b></div>
                    <div class='col-sm'><?php echo $email ?></div>
                    <div class='col-sm'><b>Phone Number:</b></div>
                    <div class='col-sm'><?php echo $phoneNumber ?></div>
                    <div class='col-sm'><b>Visitor Type:</b></div>
                    <div class='col-sm'><?php echo $visitorType . " " . $visitorTypeEXT ?></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Home Institution Details</legend>
                <div class='row'>
                    <div class='col-sm'><b>Home Institution Name:</b></div>
                    <div class='col-sm'><?php echo $homeInstitution ?></div>
                    <div class='col-sm'><b>Department Name:</b></div>
                    <div class='col-sm'><?php echo $department ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm'><b>Street:</b></div>
                    <div class='col-sm'><?php echo $street ?></div>
                    <div class='col-sm'><b>City:</b></div>
                    <div class='col-sm'><?php echo $city ?></div>
                    <div class='col-sm'><b>County:</b></div>
                    <div class='col-sm'><?php echo $county ?></div>
                    <div class='col-sm'><b>Postcode:</b></div>
                    <div class='col-sm'><?php echo $postcode ?></div>

                </div>
            </fieldset>

            <fieldset>
                <legend>Visitor Details</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="s_date"><b>Visit Start Date:</b> </label>
                        <!-- Appends the date from the database to the datefield -->
                        <input id="datefield" type="date" name="s_date" value="<?php echo $startDisplayDateDisp ?>" onchange="updateDateFields()" class="form-control" max=e_date required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="e_date"><b>Visit End Date:</b> </label>
                        <!-- Appends the date from the database to the datefield -->
                        <input id="dateend" type="date" name="e_date" value="<?php echo $endDisplayDateDisp ?>" class="form-control" required>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-group">
                    <label for="financialImp"><b>Financial Implications:</b> </label>
                    <textarea class="form-control" id="financialImp" name="financialImp" rows="4" cols="40" placeholder="Please summarise the related financial implications" required> <?php echo $financialImp ?> </textarea>
                </div>
            </fieldset>

            <fieldset>
                <label for="ipr_issues"><b>IPR Issues:</b> </label>

                <p>Are there IPR issues with the visit? <b>NOTICE:</b> File must be uploaded again!</p>
                <?php if ($iprIssues == 1) {
                    echo "<p class='card-title'><b>Current File:</b> <a href='ipr/$iprFile' download>$iprFile</a></p>";
                } ?>

                <div class="form-check-inline">
                    <label class="form-check-label" for="radio1">
                        <input type="radio" class="form-check-input" id="radio1" name="ipr_issues" value="yes" onchange='CheckIPR(this.value);' <?php if ($iprIssues == 1) {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?>>Yes
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="radio2">
                        <input type="radio" class="form-check-input" id="radio1" name="ipr_issues" value="no" onchange='CheckIPR(this.value);' <?php if ($iprIssues != 1) {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?>>No
                    </label>
                </div>




                <div class="custom-file" id="ipr_issues_ext" <?php ?>>
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>

                    <input type="file" class="custom-file-input" id="file" name="file">

                    <br>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-group">
                    <label for="summary"><b>Summary of visit</b></label>
                    <textarea class="form-control" id="summary" name="summary" rows="4" cols="40" placeholder="Please summarise the purpose of the visit" required><?php echo $summary ?></textarea>
                </div>
            </fieldset>
            <input type=hidden name=hiddenRPFRBHR value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <!-- Button Resubmit request(s) Prompted for Resubmission by HR-->
                    <div class="col-md"><input type=submit name=RPFRBHRSend value='Resubmit Visit Request' class='btn btn-secondary' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>


        <script type="text/javascript">
            updateDateFields();
        </script>
        </form>

    <?php
}
echo "</div>";
} else { }

//SQL statement to retrieve all the required columns from the visit and visitingAcademic tables in the database
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.supervisorComment, v.iprIssues, v.iprFile, va.title, va.street, va.city, va.county, va.postcode  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '2' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>Request(s) Prompted for Resubmission by Supervisor </h2>";

    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $fName = $row["fName"]; //
        $lName = $row["lName"]; //
        $title = $row["title"]; //
        $homeInstitution = $row["homeInstitution"]; //
        $department = $row["department"]; //
        $street = $row["street"]; //
        $city = $row["city"]; //
        $county = $row["county"]; //
        $postcode = $row["postcode"]; //
        $email = $row["email"]; //
        $phoneNumber = $row["phoneNumber"]; //
        $visitAdded = $row["visitAddedDate"]; //
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"]; //
        $visitorTypeEXT = $row["visitorTypeExt"]; //
        $visitStart = $row["startDate"]; //
        $visitEnd = $row["endDate"]; //
        $summary = $row["summary"];
        $startDisplay = date("d/m/Y", strtotime($visitStart)); //format the date to be displayed in a clear and concise way
        $startDisplayDateDisp = date("Y-m-d", strtotime($visitStart)); //format the date to be used as input for the date pickers
        $endDisplay = date("d/m/Y", strtotime($visitEnd)); //format the date to be displayed in a clear and concise way
        $endDisplayDateDisp = date("Y-m-d", strtotime($visitEnd)); //format the date to be used as input for the date pickers
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); //format the date to be displayed in a clear and concise way
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //format the date to be displayed in a clear and concise way
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        $supervisorComment = $row['supervisorComment'];

        ?>
        <form action=view_requests.php method=post enctype="multipart/form-data">
            <fieldset>
                <legend>Supervisor Decision Details </legend>
                <div class='row'>
                    <div class='col-sm-3'><b>Supervisor Username:</b></div>
                    <div class='col-sm-3'><?php echo $supervisorUname ?></div>
                    <div class='col-sm-3'><b>Date Action Taken:</b></div>
                    <div class='col-sm-3'><?php echo $supervisorApprovedDateDisp ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm-3'><b>Comment:</b></div>
                    <div class='col-sm-9'><?php echo $supervisorComment ?></div>
                </div>
            </fieldset>


            <fieldset>
                <legend>Personal Details</legend>
                <div class='row'>
                    <div class='col-sm'><b>Title:</b></div>
                    <div class='col-sm'><?php echo $title ?></div>
                    <div class='col-sm'><b>First Name:</b></div>
                    <div class='col-sm'><?php echo $fName ?></div>
                    <div class='col-sm'><b>Last Name:</b></div>
                    <div class='col-sm'><?php echo $lName ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm'><b>Email Address:</b></div>
                    <div class='col-sm'><?php echo $email ?></div>
                    <div class='col-sm'><b>Phone Number:</b></div>
                    <div class='col-sm'><?php echo $phoneNumber ?></div>
                    <div class='col-sm'><b>Visitor Type:</b></div>
                    <div class='col-sm'><?php echo $visitorType . " " . $visitorTypeEXT ?></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Home Institution Details</legend>
                <div class='row'>
                    <div class='col-sm'><b>Home Institution Name:</b></div>
                    <div class='col-sm'><?php echo $homeInstitution ?></div>
                    <div class='col-sm'><b>Department Name:</b></div>
                    <div class='col-sm'><?php echo $department ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm'><b>Street:</b></div>
                    <div class='col-sm'><?php echo $street ?></div>
                    <div class='col-sm'><b>City:</b></div>
                    <div class='col-sm'><?php echo $city ?></div>
                    <div class='col-sm'><b>County:</b></div>
                    <div class='col-sm'><?php echo $county ?></div>
                    <div class='col-sm'><b>Postcode:</b></div>
                    <div class='col-sm'><?php echo $postcode ?></div>

                </div>
            </fieldset>

            <fieldset>
                <legend>Visitor Details</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="s_date"><b>Visit Start Date:</b> </label>
                        <!-- Appends the date from the database to the datefield -->
                        <input id="datefield" type="date" name="s_date" value="<?php echo $startDisplayDateDisp ?>" onchange="updateDateFields()" class="form-control" max=e_date required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="e_date"><b>Visit End Date:</b> </label>
                        <!-- Appends the date from the database to the datefield -->
                        <input id="dateend" type="date" name="e_date" value="<?php echo $endDisplayDateDisp ?>" class="form-control" required>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-group">
                    <label for="financialImp"><b>Financial Implications:</b> </label>
                    <textarea class="form-control" id="financialImp" name="financialImp" rows="4" cols="40" placeholder="Please summarise the related financial implications" required> <?php echo $financialImp ?> </textarea>
                </div>
            </fieldset>

            <fieldset>
                <label for="ipr_issues"><b>IPR Issues:</b> </label>

                <p>Are there IPR issues with the visit? <b>NOTICE:</b> File must be uploaded again!</p>
                <?php if ($iprIssues == 1) {
                    echo "<p class='card-title'><b>Current File:</b> <a href='ipr/$iprFile' download>$iprFile</a></p>";
                }

                ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ipr_issues" id="inlineRadio1" value="yes" onchange='CheckIPR(this.value);' <?php
                                                                                                                                                    ?>>
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ipr_issues" id="inlineRadio1" value="no" onchange='CheckIPR(this.value);' <?php
                                                                                                                                                    ?>>
                    <label class="form-check-label" for="inlineRadio1">No</label>
                </div>

                <div class="custom-file" id="ipr_issues_ext" <? php ?>>
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>

                    <input type="file" class="custom-file-input" id="file" name="file">

                    <br>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-group">
                    <label for="summary"><b>Summary of visit</b></label>
                    <textarea class="form-control" id="summary" name="summary" rows="4" cols="40" placeholder="Please summarise the purpose of the visit" required><?php echo $summary ?></textarea>
                </div>
            </fieldset>
            <input type=hidden name=hiddenRPFRBS value=<?php echo $visitId ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md"></div>
                    <!-- Button Resubmit request(s) Prompted for Resubmission by Supervisor-->
                    <div class="col-md"><input type=submit name=RPFRBSSend value='Resubmit Visit Request' class='btn btn-secondary' style='width:100%; margin-bottom:5px'></div>
                    <div class="col-md"></div>
                </div>
            </div>
        </form>


        <script type="text/javascript">
            updateDateFields();
        </script>
        </form>

    <?php
}
echo "</div>";
} else { }

//SQL statement to retrieve all the required columns from the visit and visitingAcademic tables in the database
$awaitingAction = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '0' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$awaitingActionresult = $link->query($awaitingAction);
if ($awaitingActionresult->num_rows > 0) {
    echo "<h2>Request(s) Awaiting Action</h2>";


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
<!-- Display Visits which require action and therefore pending -->
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
                    <!-- Button to cancel visit -->
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
} else { }

//SQL statement to retrieve all the required columns from the visit and visitingAcademic tables in the database
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.iprIssues, v.iprFile FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>Request(s) Approved by Supervisor</h2>";
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
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"];
        $visitorTypeEXT = $row["visitorTypeExt"];
        $visitStart = $row["startDate"];
        $visitEnd = $row["endDate"];
        $startDisplay = date("d/m/Y", strtotime($visitStart)); //format the date to be displayed in a clear and concise way
        $endDisplay = date("d/m/Y", strtotime($visitEnd)); //format the date to be displayed in a clear and concise way
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); //format the date to be displayed in a clear and concise way
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //format the date to be displayed in a clear and concise way
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
<!-- Display Visits which have been approved by the Supervisor -->

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
                    <!-- Button to cancel visit -->
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
} else { }

//SQL statement to retrieve all the required columns from the visit and visitingAcademic tables in the database
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.supervisorComment, v.iprIssues, v.iprFile FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '1' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>Request(s) Denied by Supervisor</h2>";
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
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"];
        $visitorTypeEXT = $row["visitorTypeExt"];
        $visitStart = $row["startDate"];
        $visitEnd = $row["endDate"];
        $startDisplay = date("d/m/Y", strtotime($visitStart)); //format the date to be displayed in a clear and concise way
        $endDisplay = date("d/m/Y", strtotime($visitEnd)); //format the date to be displayed in a clear and concise way
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); //format the date to be displayed in a clear and concise way
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //format the date to be displayed in a clear and concise way
        $supervisorComment = $row["supervisorComment"];
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
<!-- Display Visits which have been denied by the Supervisor -->
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
                    <!-- Button to cancel visit -->
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
} else { }

//SQL statement to retrieve all the required columns from the visit and visitingAcademic tables in the database
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '3'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>Request(s) Approved by Supervisor & HR</h2>";

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
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"];
        $visitorTypeEXT = $row["visitorTypeExt"];
        $visitStart = $row["startDate"];
        $visitEnd = $row["endDate"];
        $startDisplay = date("d/m/Y", strtotime($visitStart)); //format the date to be displayed in a clear and concise way
        $endDisplay = date("d/m/Y", strtotime($visitEnd)); //format the date to be displayed in a clear and concise way
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); //format the date to be displayed in a clear and concise way
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //format the date to be displayed in a clear and concise way
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"];
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate));
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
<!-- Display Visits which have been approved by the Supervisor and HR -->
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
                    <!-- Button to cancel visit -->
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
} else { }

//SQL statement to retrieve all the required columns from the visit and visitingAcademic tables in the database
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.hostAcademic LIKE '" . $currentAcademic . "%' AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '1'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>Request(s) Denied by HR</h2>";

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
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"];
        $visitorTypeEXT = $row["visitorTypeExt"];
        $visitStart = $row["startDate"];
        $visitEnd = $row["endDate"];
        $startDisplay = date("d/m/Y", strtotime($visitStart)); //format the date to be displayed in a clear and concise way
        $endDisplay = date("d/m/Y", strtotime($visitEnd)); //format the date to be displayed in a clear and concise way
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); //format the date to be displayed in a clear and concise way
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //format the date to be displayed in a clear and concise way
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"];
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate)); //format the date to be displayed in a clear and concise way
        $hrComment = $row['hrComment'];
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <form action=view_requests.php method=post>
<!-- Display Visits which have been approved by the Supervisor and denied by HR -->

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
                    <!-- Button to cancel visit -->

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
} else { }




$link->close();

?>
<?php require 'includes/footer.php'; ?>