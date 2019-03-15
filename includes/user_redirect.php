<?php
if ($_SESSION["role"] === "Academic")
{
header("location: academic_landing.php");
}
elseif ($_SESSION["role"] === "College Manager")
{
header("location: cm_landing.php");
} elseif ($_SESSION["role"] === "Head Of School")
{
header("location: hos_landing.php");
} elseif ($_SESSION["role"] === "Human Resources")
{
header("location: hr_landing.php");
}
?>