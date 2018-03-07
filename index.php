<?php
/*
    REMEMBER YOU NEEDED TO ADD A NEW COLUMN TO REVIEWS. MENTION THAT IN THE LOG
*/

// Include the PDO connection file for the MySQL database
require_once('includes/connection.php');
require_once('includes/functions.php');

// Check if the controller and action parameters are set
if (isset($_GET['controller']) && isset($_GET['action'])) {
    // Get the specified controller and action
    $controller = $_GET['controller'];
    $action = $_GET['action'];
    echo $controller;
    echo $action;
} else {
    // Set default controller and action
    $controller = 'pages';
    $action = 'home';
}

// Start output buffer. Used to change page title after page has loaded
ob_start();

// Set up page
require_once('includes/header.php');
require_once('routes.php');
require_once('includes/footer.php');

// Format the page title from the action name
$pageTitle = '';
// Format the page title. If its one of the cars pages, just set the page
// title to 'New and Used Cars'
if ($controller == 'cars') {
    $pageTitle = 'New and Used Cars';
} else if ($controller == 'reviews') {
    $pageTitle = 'Reviews';
} else {
    $pageTitle = formatPageTitle($action);
}

setPageTitle($pageTitle);
