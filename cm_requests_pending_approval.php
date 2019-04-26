<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'CMRPA';
require 'includes/header.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';



?>
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>

<h2>College Manager - Requests Pending Approval</h2>
<?php require 'includes/navbars/nav_picker.php'; ?>
<!--TODO: Add the ability to search for an approved request-->
<?php
require_once 'includes/database.php';
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.hostinger.com';
$mail->SMTPAuth = true;
$mail->Username = 'support@nwsd.online';
$mail->Password = 'twNqxeX4okGE';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('support@nwsd.online', 'Visitng Academic Form');

//TODO: get rid of unecessqary columns and variables

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

if (isset($_POST['cmdeny'])) {
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET supervisorApproved = 1, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";

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

if (isset($_POST['cmrevise'])) {
    if (!empty($_POST['reasoning'])) {
        $uName = $_SESSION['username'];
        date_default_timezone_set('Europe/London');
        $publish_date = date("Y-m-d H:i:s");
        $ApproveQuery = "UPDATE visit SET supervisorApproved = 2, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date', supervisorComment = '$_POST[reasoning]' WHERE visitId = '$_POST[hidden]'";
        mysqli_query($link, $ApproveQuery);
        //TODO: add datetime to hrApprovedDate field

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
        echo "<script language='javascript'> alert('Please provide a reason as to why the user needs to resubmit'); </script>";
    }
};

echo "<h2>College Manager - Requests Pending Approval</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, v.summary, v.financialImplications, v.startDate, v.endDate, v.visitAddedDate, va.fName, va.lName, va.homeInstitution, va.department, va.visitorType, va.visitorTypeExt, v.iprIssues, v.iprFile FROM visit v, user u, school s, visitingAcademic va WHERE v.hostAcademic = u.username AND u.school_id = s.schoolId AND va.visitorId = v.visitorId AND u.college_id = '{$_SESSION['college_id']}' AND u.role = 'Head Of School' AND v.supervisorApproved LIKE '0' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        //name, home inst, visit summary, financial imp, visitor type, start & end date
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
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <div class="card">
            <div class="card-header" id="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                <div class="row">
                    <div class='col-sm'><b>Name: </b> <?php echo $fName . " " . $lName ?></div>
                    <div class='col-sm'><b>Home Institution: </b> <?php echo $homeInt ?></div>
                    <div class='col-sm'><b>Home Department: </b> <?php echo $department ?></div>
                </div>
                <div class="row">
                    <div class='col-md-1 offset-md-11' style="text-align: right;">&#x25BC</div>
                </div>
            </div>
            <form action=cm_requests_pending_approval.php method=post>
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
        <input type=hidden name=hidden value=<?php echo $visitId ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-4"><input type=submit name=cmapprove value=Approve class='btn btn-success' style='width:100%; margin-bottom:5px'></div>
                <div class="col-md-4"><input type=submit name=cmrevise value='Prompt User to Resubmit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                <div class="col-md-4"><input type=submit name=cmdeny value=Deny class='btn btn-danger' style='width:100%; margin-bottom:5px'></div>
            </div>
        </div>
        <div class="form-row" style="margin-top:5px">
            <div class="form-group col-md-3">
                <label for="reason"><b>Reason to resubmit:</b></label>
            </div>
            <div class="form-group col-md-9">
                <input type=text name=reasoning style="width:100%" class="form-control" onkeypress="return noenter()">
            </div>
            <div class="form-group col-md-12">
                <p style="text-align:right; margin-top:-15px; font-size:0.8em">** Required if the visit is prompted for resubmission</p>
            </div>
        </div>



        </form>
        <br>
        <br>
    <?php
}
echo "</div>";
} else {
    echo "0 results";
}
$link->close();

?>

<?php require 'includes/footer.php'; ?>