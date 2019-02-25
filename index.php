<?php
require 'includes/database.php';
$conn = getDB();
// Here's an Sql query we can run (Just used it to test the database connection)
$sql = "SELECT *
        FROM form";
// To assign a result you need to use the mysqli_query method and pass it the connection and the query.
// Note that this result will be FALSE if there's an error.
$results = mysqli_query($conn, $sql);

// Note that this is using three = as it's an "identical comparison" operator
if ($results === false) {
    echo mysqli_error($conn);
} else {
    // For this you can use fetch_row or fetch_all
    // This will get all of the results and store them in $form_results
    $form_results = mysqli_fetch_all($results, MYSQLI_ASSOC);
    // MYSQL_ASSOC will make it return the column names in the table instead of just number indexes
}
?>
<?php require 'includes/header.php';?>
<!--HTML HERE-->
<!--TODO-->
<div class="container">
    <h2>Visiting Academics:</h2>

    <?php if (empty($form_results)): ?>
    <p>No results were found!</p>
    <?php else: ?>
    <ul>
        <?php foreach ($form_results as $form_result): ?>
        <li>
            <article>
                <h2>
                    <?=htmlspecialchars($form_result['fName']);?>
                    <?=htmlspecialchars($form_result['lName']);?>
                </h2>

                <p>
                    <?=htmlspecialchars($form_result['fName']);?>
                    <?=htmlspecialchars($form_result['lName']);?>'s ID is:
                    <?=htmlspecialchars($form_result['idform']);?>
                </p>
            </article>
        </li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>
</div>

<?php require 'includes/footer.php';?>