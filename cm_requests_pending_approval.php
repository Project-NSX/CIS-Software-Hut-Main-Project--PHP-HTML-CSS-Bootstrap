<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'CMRPA';
require 'includes/header.php';
//import phpmailer to send emails
require 'includes/verify_cm_role.php'; // Redirect if the user is not logged in as a college manager.

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';
?>
<!-- Javascript to disable the enter key from submitting the forms -->
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>

<h2><?php echo $lang['College Manager - Requests Pending Approval'] ?></h2>
<?php require 'includes/navbars/nav_picker.php'; ?>
<?php
require_once 'includes/database.php';
//initialize phpmailer to send emails
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.hostinger.com';
$mail->SMTPAuth = true;
$mail->Username = 'support@nwsd.online';
$mail->Password = 'twNqxeX4okGE';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('support@nwsd.online', 'Visitng Academic Form');
$message = file_get_contents('Email.html');
$message = str_replace('%startdate%', $visitStart, $message);
$message = str_replace('%enddate%', $visitEnd, $message);
$message = str_replace('%HostAcademic%', $uName, $message);
$message = str_replace('%visitorId%', $visitorId, $message);
$mail->AddEmbeddedImage('img/bangor_logo.png', 'logo');
$mail->MsgHTML($message);

//script behind the button the College Manager uses to approve a request which updates the database and emails HR since that's the next step in the procedure
if (isset($_POST['cmapprove'])) {
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET supervisorApproved = 3, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);

    $mail->Subject = 'Your visit requests has been approved!';
    $mail->Body = "Your visit request has been approved by the College Manager: {$uName}";

    $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $mail->addAddress("$email");
    }
    $mail->send();
};

//script behind the button the College Manager uses to deny a request which updates the database and emails the host academic to let them know that the request has been denied
if (isset($_POST['cmdeny'])) {
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET supervisorApproved = 1, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);

    $mail->Subject = 'Your visit requests has been approved!';
    $mail->Body = "Your visit request has been denied by the College Manager: {$uName}";

    $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $mail->addAddress("$email");
    }
    $mail->send();
};

//script behind the button the College Manager uses to send the visit request back to the host academic to be resubmited after editing
if (isset($_POST['cmrevise'])) {
    if (!empty($_POST['reasoning'])) {
        $uName = $_SESSION['username'];
        date_default_timezone_set('Europe/London');
        $publish_date = date("Y-m-d H:i:s");
        $ApproveQuery = "UPDATE visit SET supervisorApproved = 2, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date', supervisorComment = '$_POST[reasoning]' WHERE visitId = '$_POST[hidden]'";
        mysqli_query($link, $ApproveQuery);

        //configuring the email to be sent to the host academic
        $mail->Subject = 'Your visit requests has been approved!';
        $mail->Body = "Your visit request requires additional information to be approved. Information is requested by the College Manager: {$uName}. Please log in to see what further information is requested";

        $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
        $result = $link->query($sql);
        while ($row = $result->fetch_assoc()) {
            $email = $row["email"];
            $mail->addAddress("$email");
        }
        $mail->send();
    } else {
        //displays a message if a reason for resubmission isn't entered
        echo "<script language='javascript'> alert('Please provide a reason as to why the user needs to resubmit'); </script>";
    }
};

//SQL Statement to retrieve the appropriate cells from the tables
$supervisorApproved = "SELECT v.visitId, v.visitorId, v.summary, v.financialImplications, v.startDate, v.endDate, v.visitAddedDate, va.fName, va.lName, va.homeInstitution, va.department, va.visitorType, va.visitorTypeExt, v.iprIssues, v.iprFile FROM visit v, user u, school s, visitingAcademic va WHERE v.hostAcademic = u.username AND u.school_id = s.schoolId AND va.visitorId = v.visitorId AND u.college_id = '{$_SESSION['college_id']}' AND u.role = 'Head Of School' AND v.supervisorApproved LIKE '0' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<h2>College Manager - Requests Pending Approval</h2>";

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
        $department = $row["department"];
        $summary = $row["summary"];
        $financialImp = $row["financialImplications"];
        $visitorType = $row["visitorType"];
        $visitorTypeEXT = $row["visitorTypeExt"];
        $visitStart = $row["startDate"];
        $visitEnd = $row["endDate"];
        $Dateadded = $row["visitAddedDate"];
        //Convert Dates to how we want them displayed
        $startDisplay = date("d/m/Y", strtotime($visitStart));
        $endDisplay = date("d/m/Y", strtotime($visitEnd));
        $addedDisplay = date("d/m/Y", strtotime($Dateadded));
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <!-- Used a card to make something similar to an accordion which was used to display data with brief into in header and detail in the collapsable section-->
        <div class="card">
            <div class="card-header" id="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                <div class="row">
                    <div class='col-sm'><b><?php echo $lang['Name'] ?>: </b> <?php echo htmlspecialchars($fName) . " " . htmlspecialchars($lName) ?></div>
                    <div class='col-sm'><b><?php echo $lang['Home Institution'] ?>: </b> <?php echo htmlspecialchars($homeInt) ?></div>
                    <div class='col-sm'><b><?php echo $lang['Department'] ?>: </b> <?php echo htmlspecialchars($department) ?></div>
                </div>
                <div class="row">
                    <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
                </div>
            </div>
            <form action=cm_requests_pending_approval.php method=post>
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
                        <h5 class='card-title'><?php echo $lang['Date & Time of Approval'] ?></h5>
                        <p class='card-text'><?php echo $suppervisorApproveDisplay ?> </p>
                        <?php if ($iprIssues == 1) {
                            echo $lang['IPR'];
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>htmlspecialchars($iprFile)</a>";
                        }
                        ?>
                    </div>
                </div>
        </div>
        <input type=hidden name=hidden value=<?php echo $visitId ?>>
        <div class="container">
            <div class="row">
                <!-- three buttons for the College Manager to use to decide on a request -->
                <div class="col-md-4"><input type=submit name=cmapprove value=Approve     data-toggle="tooltip" data-placement="top" title="To Approve Requests Only"     class='btn btn-success' style='width:100%; margin-bottom:5px'></div>
                <div class="col-md-4"><input type=submit name=cmrevise value='Prompt User to Resubmit' data-toggle="tooltip" data-placement="top" title="To Resubmit Requests Only" class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                <div class="col-md-4"><input type=submit name=cmdeny value=Deny data-toggle="tooltip" data-placement="top" title="To Approve Deny Only" class='btn btn-danger' style='width:100%; margin-bottom:5px'></div>
            </div>
        </div>
        <!-- Field to provide a reason why the request must be resubmitted -->
        <div class="form-row" style="margin-top:5px">
            <div class="form-group col-md-3">
                <label for="reason"><b>Reason to resubmit:</b></label>
            </div>
            <div class="form-group col-md-9">
                <input type=text name=reasoning style="width:100%" data-toggle="tooltip" data-placement="top" title="Go back" class="form-control" onkeypress="return noenter()">
            </div>
            <div class="form-group col-md-12">
                <p style="text-align:right; margin-top:-15px; font-size:0.8em"><?php echo $lang['resubmitText'] ?></p>
            </div>
        </div>



        </form>
        <br>
        <br>
    <?php
}
echo "</div>";
} else { }
$link->close();

?>

<?php require 'includes/footer.php'; ?>