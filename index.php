<?php
// Include the PDO connection file for the MySQL database
require_once('includes/connection.php');
// Test to see if it works by getting an instance of the singleton class
Db::getInstance();

// Initialize the $page variable to make sure there are no issues
$page = '';

// Check to see if the page parameter has been set
if (isset($_GET['page'])) {
    // Make sure that the requested file actually exists
    if (file_exists('pages/' . $_GET['page'] . '.php')) {
        // If it exists, display the page
        $page = $_GET['page'];
    } else {
        // If it doesn't exist, display page not found error
        $error = 'page-not-found';
        $page = 'error';
    }
} else {
    // If no page has been specified, then just display the home page
    $page = 'home';
}

// Include the model classes
require_once('includes/models/car.class.php');
require_once('includes/models/employee.class.php');

// Include the header file
require_once('includes/header.php');

// Include the page specified above
require_once('pages/' . $page . '.php');

// Include the footer file
require_once('includes/footer.php');
