<?php
require 'includes/database.php';
$conn = getDB();
// Here's our Sql query we'll be running
$sql = "SELECT *
        FROM form";

// To assign a result you need to use the mysqli_query method and pass it the connection and the query.
// Note that this result will be FALSE if there's an error.
$results = mysqli_query($conn, $sql);

// Note that this is using three = as it's an "identical comparison" operator
if($results === false)
{
  echo mysqli_error($conn);
}
else
{
  // For this you can use fetch_row or fetch_all
  // This will get all of the results and store them in $form_result
  $form_result = mysqli_fetch_all($results, MYSQLI_ASSOC);
  // MYSQL_ASSOC will make it return the column names in the table instead of just number indexes
}
 ?>
 <?php require 'includes/header.php'; ?>
<!--HTML HERE-->

 <?php require 'includes/footer.php'; ?>