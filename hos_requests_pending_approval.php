<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'HOSRPA';
require 'includes/header.php';
require 'includes/verify_hos_role.php'; // Redirect if the user is not logged in as a head of school.
?>

<!--Javascript to stop the form being entered when enter key is pressed-->
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>

<h2><?php echo $lang['Head of School - Pending Requests'] ?>
</h2>
<?php require 'includes/navbars/nav_picker.php'; ?>
<!--This page needs to show application pending approval from HR-->

<?php
require_once 'includes/database.php';
// Import PHPMailer to send emails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

// Configure PHPMailer to send emails
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.hostinger.com';
$mail->SMTPAuth = true;
$mail->Username = 'support@nwsd.online';
$mail->Password = 'twNqxeX4okGE';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('support@nwsd.online', 'Visitng Academic Form');


//Check if Approve button has been pressed
if (isset($_POST['hosapprove'])) {
//Updates the values in the database row
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET supervisorApproved = 3, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);

    //Appends text to the subject and main body of email
    $mail->Subject = 'Your visit requests has been approved!';
    $mail->Body = "Your visit request has been approved by the Head Of School: {$uName}";

    //SQL query to get email to know who to send to
    $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $mail->addAddress("$email");
    }
    $mail->send(); //sends email
};

//Check if Deny button has been pressed
if (isset($_POST['hosdeny'])) {
    //Updates the values in the database row
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET supervisorApproved = 1, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);

    //Appends text to the subject and main body of email
    $mail->Subject = 'Your visit requests has been denied!';
    $mail->Body = "Your visit request has been denied by the Head of School: {$uName}";

    //SQL query to get email to know who to send to
    $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $mail->addAddress("$email");
    }
    $mail->send(); //sends email
};

//Check if the button for the host academic to remake the visit request has been pressed
if (isset($_POST['hosrevise'])) {
    //Check if the reasoning textbox has content which it should do
    if (!empty($_POST['reasoning'])) {
    //Updates the values in the database row
        $uName = $_SESSION['username'];
        date_default_timezone_set('Europe/London');
        $publish_date = date("Y-m-d H:i:s");
        $ApproveQuery = "UPDATE visit SET supervisorApproved = 2, supervisorUsername = '$uName', supervisorApprovedDate = '$publish_date', supervisorComment = 'htmlspecialchars($_POST[reasoning])' WHERE visitId = '$_POST[hidden]'";
        mysqli_query($link, $ApproveQuery);


        $mail->Subject = 'Your visit requests requires additional information!';
        $mail->Body = "Your visit request requires additional information. Please log in to see the information requested by the Head of School: {$uName}";

    //SQL query to get email to know who to send to
        $sql = "SELECT u.email FROM user u, visit v where u.username = v.hostAcademic AND v.visitId = '$_POST[hidden]'";
        $result = $link->query($sql);
        while ($row = $result->fetch_assoc()) {
            $email = $row["email"];
            $mail->addAddress("$email");
        }
        $mail->send(); //sends email
    } else {
        //if the textbox is empty, display an error
        echo "<script language='javascript'> alert('Please provide a reason as to why the user needs to resubmit'); </script>";
    }
};

//SQL statement to retrieve columns from database table
$supervisorApproved = "SELECT v.visitId, v.visitorId, v.summary, v.financialImplications, v.startDate, v.endDate, v.visitAddedDate, va.fName, va.lName, va.homeInstitution, va.department, va.visitorType, va.visitorTypeExt, v.iprIssues, v.iprFile FROM visit v, user u, school s, visitingAcademic va WHERE v.hostAcademic = u.username AND u.school_id = s.schoolId AND va.visitorId = v.visitorId AND u.school_id = '{$_SESSION['school_id']}' AND v.supervisorApproved LIKE '0' AND v.hostAcademic NOT LIKE '{$_SESSION['username']}' ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
// If 1 or more results are returned execute the following code to display the information
if ($supervisorApprovedresult->num_rows > 0) {
    echo $lang['hosPenTitle'];
    echo "<div id='accordion'>";
    while ($row = $supervisorApprovedresult->fetch_assoc()) {
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = htmlspecialchars($row["fName"]);
        $lName = htmlspecialchars($row["lName"]);
        $homeInt = htmlspecialchars($row["homeInstitution"]);
        $department = htmlspecialchars($row["department"]);
        $summary = htmlspecialchars($row["summary"]);
        $financialImp = htmlspecialchars($row["financialImplications"]); //done
        $visitorType = $row["visitorType"]; //done
        $visitorTypeEXT = htmlspecialchars($row["visitorTypeExt"]); //done
        $visitStart = $row["startDate"]; //done
        $visitEnd = $row["endDate"]; //done
        $Dateadded = $row["visitAddedDate"];
        $startDisplay = date("d/m/Y", strtotime($visitStart));
        $endDisplay = date("d/m/Y", strtotime($visitEnd));
        $addedDisplay = date("d/m/Y", strtotime($Dateadded));
        $iprIssues = $row['iprIssues'];
        $iprFile = $row['iprFile'];
        ?>
        <!-- Use card as accordion to display results in a compressed manner -->
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
            <!-- Makes a form with data fields and buttons -->
            <form action=hos_requests_pending_approval.php method=post>
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
                        <?php if ($iprIssues == 1) {
                            echo $lang['IPR'];
                            echo "<p class='card-text'><a href='ipr/$iprFile' download>$iprFile</a>";
                        }
                        ?>
                        <input type=hidden name=hidden value=<?php echo $visitId ?>>
                        <div class="container">
                            <!-- Make three buttons, for approving, denying and sending a visit back for reapproval by the Host Academic -->
                            <div class="row">
                                <!-- The button name must match the isset() in the top  -->
                                <div class="col-md-4"><input type=submit name=hosapprove value="<?php echo $lang['Approve'] ?>" class='btn btn-success' style='width:100%; margin-bottom:5px'></div>
                                <div class="col-md-4"><input type=submit name=hosrevise value="<?php echo $lang['Prompt User to Resubmit'] ?>" class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
                                <div class="col-md-4"><input type=submit name=hosdeny value="<?php echo $lang['Deny'] ?>" class='btn btn-danger' style='width:100%; margin-bottom:5px'></div>
                            </div>
                        </div>
                        <div class="form-row" style="margin-top:5px">
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
$link->close();

?>

<?php require 'includes/footer.php'; ?>