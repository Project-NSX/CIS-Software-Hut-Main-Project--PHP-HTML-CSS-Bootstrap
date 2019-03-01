<?php

/**
 * Get the database connection
 *
 * @return object Connection to a MySQL server
 */
function getDB()
{
    $db_host = "localhost";
    $db_name = "va_form";
    $db_user = "root";
    $db_pass = "MyNewPass";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (mysqli_connect_error())
    {
        echo mysqli_connect_error();
        exit;
    }

    return $conn;
}
