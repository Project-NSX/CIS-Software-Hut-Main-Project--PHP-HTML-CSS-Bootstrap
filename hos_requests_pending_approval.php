<?php
require 'includes/database.php';
$conn = getDB();
?>
<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Head Of School - Requests Pending Approval</h2>
<a href="create_va.php">Create a Visiting Academic</a><br/>
<a href="create_visit.php">Create a Visit</a><br/>
<a href="view_requests.php">View Pending Requests</a><br/>
<a href="view_complete.php">View Complete Requests</a><br/><br/>

<a href="hos_landing.php">Head of School - Landing</a><br/>
<a href="hos_approved_requests.php">Head of school - approved requests</a>




<?php require 'includes/footer.php';?>