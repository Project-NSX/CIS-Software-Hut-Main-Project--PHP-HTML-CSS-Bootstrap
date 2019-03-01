<?php
require 'includes/database.php';
$conn = getDB();
?>
<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Create a Visit</h2>
<a href="create_va.php">Create a Visiting Academic</a><br/>
<a href="view_requests.php">View Pending Requests</a><br/>
<a href="view_complete.php">View Complete Requests</a><br/><br/>
<a href="academic_landing.php">Academic</a><br/>
Or<br/>
<a href="cm_landing.php">College Manager</a><br/>
Or<br/>
<a href="hos_landing.php">Head of school</a><br/>



<?php require 'includes/footer.php';?>