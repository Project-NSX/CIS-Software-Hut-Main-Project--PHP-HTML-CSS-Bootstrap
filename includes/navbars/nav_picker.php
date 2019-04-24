<?php if ($_SESSION["role"] === "Academic")
{
    require 'includes/navbars/aca_navbar.php';
}
if ($_SESSION["role"] === "Head Of School")
{
    require 'includes/navbars/hos_navbar.php';
}
if ($_SESSION["role"] === "College Manager")
{
    require 'includes/navbars/cm_navbar.php';
}
if ($_SESSION["role"] === "Human Resources")
{
    require 'includes/navbars/hr_navbar.php';
}
