<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

define('DB_SERVER', 'sql189.main-hosting.eu.');
define('DB_USERNAME', 'u359278202_eeuab');
define('DB_PASSWORD', '6N452fMvy6zc');
define('DB_NAME', 'u359278202_vawf');

// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', 'MyNewPass');
// define('DB_NAME', 'va_form');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
/**
 * Get the database connection
 *
 * @return object Connection to a MySQL server
 */
function getDB()
{
    $db_host = "sql189.main-hosting.eu.";
    $db_name = "u359278202_vawf";
    $db_user = "u359278202_eeuab";
    $db_pass = "6N452fMvy6zc";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }

    return $conn;
}