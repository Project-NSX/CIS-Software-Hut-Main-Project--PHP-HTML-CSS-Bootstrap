<?php
require 'includes/database.php';
$conn = getDB();
?>
<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>College Manager - Requests Pending Approval</h2>
<a href="create_va.php">Create a Visiting Academic</a><br/>
<a href="create_visit.php">Create a Visit</a><br/>
<a href="view_requests.php">View Pending Requests</a><br/>
<a href="view_complete.php">View Complete Requests</a><br/><br/>

<a href="cm_landing.php">College Manager - Landing Page</a><br/>
<a href="cm_approved_requests.php"></a>




<?php require 'includes/footer.php';?>