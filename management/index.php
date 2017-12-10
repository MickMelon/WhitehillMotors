<?php
// Include the PDO connection file for the MySQL database
require_once('../includes/connection.php');
// Include the functions file
require_once('../includes/functions.php');

// Include the model classes
require_once('../includes/models/car.class.php');
require_once('../includes/models/employee.class.php');

// Start the PHP session
session_start();

// Get the current page that is set in the GET parameter
// ie. index.php?page=about
$page = getPage();

// Check if the person is logged in
if (!Employee::isLoggedIn()) {
    // If they aren't, redirect them to the login page
    header("Location: login.php");
}

// Make sure the employee isn't trying to access manager only pages
if (!Employee::isManager() && $page == 'add_employee') {
    header("Location: index.php?page=error");
}

// Include the header file
require_once('includes/header.php');

// Include the page specified above
require_once('pages/' . $page . '.php');

// Include the footer file
require_once('includes/footer.php');
