<?php if ($_SESSION["role"] === "aca")
{
    require 'includes/navbars/aca_navbar.php';
}
if ($_SESSION["role"] === "hos")
{
    require 'includes/navbars/hos_navbar.php';
}
if ($_SESSION["role"] === "cm")
{
    require 'includes/navbars/cm_navbar.php';
}
if ($_SESSION["role"] === "hr")
{
    require 'includes/navbars/hr_navbar.php';
}
// TODO: Make Current page get highlighted in navbar