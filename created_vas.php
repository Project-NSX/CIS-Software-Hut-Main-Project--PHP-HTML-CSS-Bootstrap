<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>My Visitors</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--This Page will show all of the VA's created by the logged in user. It will contain the functionality to edit / delete added VA's-->
<!--TODO: Format the rows-->
<!--TODO: Make each Visitor editable using the link below, this should pass the Visitor ID (possibly in the URL) to get the details of the visitor-->

<?php
require_once'includes/database.php';

$myVisitors = "SELECT visitorId, title, titleExt, fName, lName, visitorType, visitorTypeExt, homeInstitution FROM visitingAcademic WHERE hostAcademic = '{$_SESSION['username']}' ";
$myVisitorsResult = $link->query($myVisitors);
if ($myVisitorsResult->num_rows > 0) {
    echo "<div id='accordion'>";
    while ($row = $myVisitorsResult->fetch_assoc()) {
        $title = $row['title'];
        $titleExt = $row['titleExt'];
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
        if ($title == "Other" || $title == "other") {
            $titleShow = $titleExt;
        } else {
            $titleShow = $title;
        }
        echo "<div class='card' >";
        echo "<h7 class='mb-0'> <span> <b>Name:</b> $titleShow $fName $lName </span> <span> <b>Visitor Type:</b> $visitorTypeShow <b>Home Institution:</b> $homeInstitution</span></h7>";
echo "<a href='edit_va.php?id=$id'>Edit Visitor</a>";
        echo "</div>";
        echo "<br>";
    }
    echo "</div>";
} else {
    echo "0 results";
}
?>
<?php require 'includes/footer.php';?>