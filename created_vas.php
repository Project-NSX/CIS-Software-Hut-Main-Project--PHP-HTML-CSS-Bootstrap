<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>My Visitors</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--This Page will show all of the VA's created by the logged in user. It will contain the functionality to edit / delete added VA's-->
<!--TODO: Make this page show a list of all VA's created by the user, and have buttons for deleting each VA (refuse if a visit request is open), and a link to edit the VA-->
<!--TODO: Make each Visitor editable using the link below, this should pass the Visitor ID (possibly in the URL) to get the details of the visitor-->
<a href="edit_va.php">Edit Visitor</a>

<?php require 'includes/footer.php';?>