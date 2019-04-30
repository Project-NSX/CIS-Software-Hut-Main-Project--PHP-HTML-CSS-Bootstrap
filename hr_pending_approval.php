<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'home';
require 'includes/header.php';
require 'includes/verify_hr_role.php'; // Redirect if the user is not logged in as a HR user.
// Import PHP mailer to send emails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';
?>
<!--disables enter key on form which means teh form won't get submitted-->
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>

<h2><?php echo $lang['Human Resources - Applications Pending Approval'] ?></h2>
<?php require 'includes/navbars/nav_picker.php'; ?>

<?php
//Configure PHPMailer to send emails using our email address hosted by hostinger
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

//This is the script behind the approve button for the HR practitioner
//Sets the value of approval to 3 (approved), appends the logged in users' username and also adds the current data
if (isset($_POST['approve'])) {
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET hrApproved = 3, hrUsername = '$uName', hrApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);

    //appends values to the phpMailer to send an email
    $mail->Subject = 'Your visit requests has been approved!';
    $mail->Body = "Your visit request has been approved by the Human Resources User: {$uName}";

    //SQL Statement to get the email address to be used to send the email
    $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $mail->addAddress("$email");
    }
    $mail->send(); //sends the email
};

//This is the script behind the deny button for the HR practitioner
//Sets the value of approval to 1 (denied), appends the logged in users' username and also adds the current data
if (isset($_POST['deny'])) {
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET hrApproved = 1, hrUsername = '$uName', hrApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);

    //appends values to the phpMailer to send an email
    $mail->Subject = 'Your visit requests has been denied!';
    $mail->Body = "Your visit request has been denied by the Human Resources User: {$uName}";

    //SQL Statement to get the email address to be used to send the email
    $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $mail->addAddress("$email");
    }
    $mail->send(); //sends the email
};

if (isset($_POST['revise'])) {
    //Check if the textbox has text to represnt a reason which is required.
    if (!empty($_POST['reasoning'])) {
        $uName = $_SESSION['username'];
        date_default_timezone_set('Europe/London');
        $publish_date = date("Y-m-d H:i:s");
        $ApproveQuery = "UPDATE visit SET hrApproved = 2, hrUsername = '$uName', hrApprovedDate = '$publish_date', hrComment = '$_POST[reasoning]' WHERE visitId = '$_POST[hidden]'";
        mysqli_query($link, $ApproveQuery);


        //appends values to the phpMailer to send an email
        $mail->Subject = 'Your visit requires additional data!';
        $mail->Body = "Your visit request requires additional information to be approved. Please log in to see what additional information is being requested by the Human Resources User: {$uName}";

        //SQL Statement to get the email address to be used to send the email
        $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
        $result = $link->query($sql);
        while ($row = $result->fetch_assoc()) {
            $email = $row["email"];
            $mail->addAddress("$email");
        }
        $mail->send(); //sends the email
    } else { //if there's no text, use an alert to display an error
        echo "<script language='javascript'> alert('Please provide a reason as to why the user needs to resubmit'); </script>";
    }
};

//SQL statement to retrieve columns from database table
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.department, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment, v.iprIssues, v.iprFile  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    //if one or more record returns do the following to display the record
    echo $lang['hrPenTitle'];
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $uName = $_SESSION['username'];
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
        $financialImp = htmlspecialchars($row["financialImplications"]); //done
        $visitorType = $row["visitorType"]; //done
        $visitorTypeEXT = htmlspecialchars($row["visitorTypeExt"]); //done
        $visitStart = $row["startDate"]; //done
        $visitEnd = $row["endDate"]; //done
        $startDisplay = date("d/m/Y", strtotime($visitStart)); //Format date in user friendly manner
        $endDisplay = date("d/m/Y", strtotime($visitEnd)); //Format date in user friendly manner
        $addedDisplay = date("d/m/Y - g:iA", strtotime($visitAdded)); //Format date in user friendly manner
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate)); //Format date in user friendly manner
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"];
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate)); //Format date in user friendly manner
        $hrComment = htmlspecialchars($row['hrComment']);
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>

        <!-- Use card to display data in a compressed way -->
        <div class="card">
            <div class="card-header" id="<?php echo $headingId ?>" <button id="button1" class="btn btn-link collapsed" data-toggle="collapse" data-target=" <?php echo $collapseIdHash ?>" aria-expanded="false" aria-controls=" <?php echo $collapseId ?>">
                <div class="row">
                    <div class='col-sm'><b><?php echo $lang['Name'] ?>: </b> <?php echo $fName . " " . $lName ?></div>
                    <div class='col-sm'><b><?php echo $lang['Home Institution'] ?>: </b> <?php echo $homeInt ?></div>
                    <div class='col-sm'><b><?php echo $lang['Department'] ?>: </b> <?php echo $department ?></div>
                </div>
                <div class="row">
                    <div class='col-md-1 offset-md-11' style="text-align: right;"><?php echo $lang['seeMore'] ?> &#x25BC</div>
                </div>
            </div>
            <!-- Create form with text fields and buttons -->
            <form action=hr_pending_approval.php method=post>
                <div id="<?php echo $collapseId ?>" class="collapse" aria-labelledby="<?php echo $headingId ?>" data-parent="#accordion">
                    <div class="card-body">
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
                        <?php if ($iprIssues == 1) {
                            echo $lang['IPR'];
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                        <input type=hidden name=hidden value=<?php echo $visitId ?>>
                            <div class="container">
                                <div class="row">
                                    <!-- Implemented three buttons -->
                                    <!-- The button name gets used in the isset() in the top to check if it's been pressed -->
                                    <div class="col-md-4"><input type=submit name=approve   data-toggle="tooltip" data-placement="top" title="<?php echo $lang['To Approve Requests Only'] ?>"    value="<?php echo $lang['Approve'] ?>" class='btn btn-success' style='width:100%; margin-bottom:5px'></div>
                                    <div class="col-md-4"><input type=submit name=revise    data-toggle="tooltip" data-placement="top" title="<?php echo $lang['To Re-submit Only'] ?>"           value="<?php echo $lang['Prompt User to Resubmit'] ?>" class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                                    <div class="col-md-4"><input type=submit name=deny      data-toggle="tooltip" data-placement="top" title="<?php echo $lang['To Deny Requests Only'] ?>"        value="<?php echo $lang['Deny'] ?>" class='btn btn-danger' style='width:100%; margin-bottom:5px'></div>
                                </div>
                            </div>
                            <div class="form-row" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['moreInfoNeeded'] ?>" style="margin-top:5px">
                                <div class="form-group col-md-3">
                                    <label for="reason"><b><?php echo $lang['Reason to resubmit'] ?>:</b></label>
                                </div>
                                <div class="form-group col-md-9">
                                    <input type=text name=reasoning style="width:100%" class="form-control" onkeypress="return noenter()">
                                </div>
                                <div class="form-group col-md-12">
                                    <p style="text-align:right; margin-top:-15px; font-size:0.8em"><?php echo $lang['resubmitText'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php
}
echo "</div>";
} else { }

//$link->close();

?>

<?php require 'includes/footer.php'; ?>