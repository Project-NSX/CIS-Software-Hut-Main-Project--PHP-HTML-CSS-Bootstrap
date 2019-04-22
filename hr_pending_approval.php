<?php $page = 'HRPA'; require 'includes/header.php';?>
<!--HTML HERE-->

<!--disables enter on form-->
<script type="text/javascript">
function noenter() {
  return !(window.event && window.event.keyCode == 13); }
</script>

<style>
h6 span{
    display: inline-block;
    margin-right: 2.5em;
}
</style>
<h2>Human Resources - Applications Pending Approval</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--This page needs to show application pending approval from HR-->

<?php
//TODO Add functionality to approve and disapprove
require_once'includes/database.php';
//TODO: get rid of unecessqary columns and variables
if(isset($_POST['approve'])){
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET hrApproved = 3, hrUsername = '$uName', hrApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);
};

if(isset($_POST['deny'])){
    $uName = $_SESSION['username'];
    date_default_timezone_set('Europe/London');
    $publish_date = date("Y-m-d H:i:s");
    $ApproveQuery = "UPDATE visit SET hrApproved = 1, hrUsername = '$uName', hrApprovedDate = '$publish_date' WHERE visitId = '$_POST[hidden]'";
    mysqli_query($link, $ApproveQuery);
};

if(isset($_POST['revise'])){
    if(!empty($_POST['reasoning'])){
        $uName = $_SESSION['username'];
        date_default_timezone_set('Europe/London');
        $publish_date = date("Y-m-d H:i:s");
        $ApproveQuery = "UPDATE visit SET hrApproved = 2, hrUsername = '$uName', hrApprovedDate = '$publish_date', hrComment = '$_POST[reasoning]' WHERE visitId = '$_POST[hidden]'";
        mysqli_query($link, $ApproveQuery);
        //TODO: add datetime to hrApprovedDate field
    }else{
        echo "<script language='javascript'> alert('Please provide a reason as to why the user needs to resubmit'); </script>";
    }
};

echo "<h2>HR Pending Request(s)</h2>";
$supervisorApproved = "SELECT v.visitId, v.visitorId, va.fName, va.lName, va.homeInstitution, va.email, va.phoneNumber, v.summary, v.visitAddedDate, v.status,  v.financialImplications, va.visitorType, va.visitorTypeExt,  v.startDate, v.endDate, v.supervisorApproved, v.supervisorUsername, v.supervisorApprovedDate, v.hrApproved, v.hrUsername, v.hrApprovedDate, v.hrComment  FROM visit v, visitingAcademic va WHERE v.visitorId = va.visitorId AND v.supervisorApproved LIKE '3' AND v.hrApproved LIKE '0'  ORDER BY v.visitAddedDate DESC";
$supervisorApprovedresult = $link->query($supervisorApproved);
if ($supervisorApprovedresult->num_rows > 0) {
    echo "<div id='accordion'>";
    while($row = $supervisorApprovedresult->fetch_assoc()) {
        $uName = $_SESSION['username'];
        $visitId = $row["visitId"];
        $visitorId = $row["visitorId"];
        $headingId = "heading" . $visitId . $visitorId;
        $collapseId = "collapse" . $visitId . $visitorId;
        $collapseIdHash = "#collapse" . $visitId . $visitorId;
        $fName = $row["fName"];
        $lName = $row["lName"];
        $homeInt = $row["homeInstitution"];
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
        $supervisorApproved = $row["supervisorApprovedDate"];
        $supervisorUname = $row["supervisorUsername"];
        $supervisorApprovedDate = $row["supervisorApprovedDate"];
        $supervisorApprovedDateDisp = date("d/m/Y - g:iA", strtotime($supervisorApprovedDate));
        $hrApproved = $row["hrApprovedDate"];
        $hrUname = $row["hrUsername"];
        $hrApprovedDate = $row["hrApprovedDate"];
        $hrApprovedDateDisp = date("d/m/Y - g:iA", strtotime($hrApprovedDate));
        $hrComment = $row['hrComment']; ?>
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
        <form action=hr_pending_approval.php method=post>
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
        </div>
        </div>
        </div>
        <input type=hidden name=hidden value=<?php echo $visitId ?>>
        <div class="container">
        <div class="row">
        <div class="col-md-4"><input type=submit name=approve value=Approve class='btn btn-success' style='width:100%; margin-bottom:5px'></div>
        <div class="col-md-4"><input type=submit name=revise value='Prompt User to Resubmit' class='btn btn-warning' style='width:100%; margin-bottom:5px'></div>
        <div class="col-md-4"><input type=submit name=deny value=Deny class='btn btn-danger' style='width:100%; margin-bottom:5px'></div>
        </div>
        </div>
        <div class="form-row" style="margin-top:5px">
            <div class="form-group col-md-3">
                <label for="reason"><b>Reason to resubmit:</b></label>
            </div>
            <div class="form-group col-md-9" >
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

//$link->close();

?>

<?php require 'includes/footer.php';?>

