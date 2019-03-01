<?php
require 'includes/database.php';
$conn = getDB();
?>
<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Head of School - landing page</h2>
<a href="create_va.php">Create a Visiting Academic</a><br/>
<a href="create_visit.php">Create a Visit</a><br/>
<a href="view_requests.php">View Pending Requests</a><br/>
<a href="view_complete.php">View Complete Requests</a><br/>
<br/>
<a href="hos_approved_requests.php">HOS View Approved Requests</a><br/>
<a href="hos_requests_pending_approval.php"></a>HOS View Requests Pending Approval<br/>



<?php require 'includes/footer.php';?>