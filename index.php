<?php
/*
    This index.php file is used as the gateway to all parts of the site. Any page
    accessed goes through this file first. It gets the controller and action parameters
    to determine what page needs to be displayed. At the end it will set the page title.
*/

// Include the PDO connection file for the MySQL database
require_once('includes/connection.php');

// Include commonly used functions
require_once('includes/functions.php');

// Check if the controller and action parameters are set
// e.g. index.php?controller=pages&action=about
if (isset($_GET['controller']) && isset($_GET['action'])) {
    // Get the specified controller and action
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    // Set default controller and action
    $controller = 'pages';
    $action = 'home';
}

// Start output buffer. Used to change page title after page has loaded because
// the page is loaded after the header
ob_start();

// Set up page
require_once('includes/header.php');
require_once('routes.php');
require_once('includes/footer.php');

// Format the page title. If its one of the cars pages, just set the page
// title to 'New and Used Cars'
$pageTitle = '';

if ($controller == 'cars') {
    $pageTitle = 'New and Used Cars';
} else if ($controller == 'reviews') {
    $pageTitle = 'Reviews';
} else {
    $pageTitle = formatPageTitle($action);
}

// Call the function that lives in functions.php to modify the page and header titles
setPageTitle($pageTitle);
