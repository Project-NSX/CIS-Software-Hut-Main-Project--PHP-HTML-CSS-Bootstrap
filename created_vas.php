<?php $page = 'CVas'; require 'includes/header.php';?>
<!--HTML HERE-->
<h2>My Visitors</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--This Page will show all of the VA's created by the logged in user. It will contain the functionality to edit / delete added VA's-->
<!--TODO: Format the rows-->
<!--TODO: Make each Visitor editable using the link below, this should pass the Visitor ID (possibly in the URL) to get the details of the visitor-->

<?php
require_once'includes/database.php';

$myVisitors = "SELECT visitorId, title, fName, lName, visitorType, visitorTypeExt, homeInstitution FROM visitingAcademic WHERE hostAcademic = '{$_SESSION['username']}' ";
$myVisitorsResult = $link->query($myVisitors);
if ($myVisitorsResult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $myVisitorsResult->fetch_assoc()) {
        $title = $row['title'];
        $fName = $row["fName"];
        $lName = $row["lName"];
$homeInstitution =$row["homeInstitution"];
        $visitorType = $row["visitorType"]; //done
        $visitorTypeEXT = $row["visitorTypeExt"]; //done
        $id=$row["visitorId"];

if($visitorType == "Academic" || $visitorType == "Other")
        $visitorTypeShow = $visitorType.": ".  $visitorTypeEXT;
else{
$visitorTypeShow = $visitorType;
}
?>
        <div class='row' >
        <div class='col-sm'><b>Name:</b></div>
        <div class='col-sm'><?php echo $title." ".$fName." ".$lName ?></div>
        <div class='col-sm'><b>Visitor Type:</b></div>
        <div class='col-sm'><?php echo $visitorTypeShow ?></div>
        <div class='col-sm'><b>Home Institution:</b></div>
        <div class='col-sm'><?php echo $homeInstitution ?></div>
        </div>
        <a href='edit_va.php?id=$id'>
        <div class='row' >
            <button type='button' id="button1" class='btn btn-primary btn-sm col-sm' style='margin:5px 2px 5px 2px'>Edit Visitor</button>
            <button type='button' id="button2" class='btn btn-primary btn-sm col-sm' style='margin:5px 2px 5px 2px'>Delete Visitor</button>
</div></a>
        <?php
    }
    echo "</div>";
} else {
    echo "0 results";
}
?>
<?php require 'includes/footer.php';?>