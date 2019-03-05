<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Academic Landing</h2>
<!-- IMPORTANT NOTE: We need to figure out if we're going to make seperate pages for the Academic, CM, and HOS's VA Tools
    The main problem is that we're going to need to change the nav bar for each page depending on their position (as the home page and links will be different)
    Using seperate pages avoids this issue, but it may also be possible to just swap out the navbar depending on their position using php
    The same applies for the "va_application_details.php" page that will dynamically load the full details of an application when it's cliked on in the various application tables.
    Note that the function the va_application_details.php page uses will also need to be used in the various approval pages (which i have not made yet as there might be a better way
    than several different pages for them)-->
<?php require 'includes/navbars/aca_navbar.php';?>


<?php require 'includes/footer.php';?>