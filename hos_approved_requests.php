<?php
require 'includes/database.php';
$conn = getDB();
?>
<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Head of School - Approved Requests</h2>
<a href="create_va.php">Create a Visiting Academic</a><br/>
<a href="create_visit.php">Create a Visit</a><br/>
<a href="view_requests.php">View Pending Requests</a><br/>
<a href="view_complete.php">View Complete Requests</a><br/><br/>

<a href="hos_landing.php">Head of School Landing Page</a><br/>
<a href="hos_requests_pending_approval.php">Head of School - Requests Pending Approval</a>


<?php require 'includes/footer.php';?>