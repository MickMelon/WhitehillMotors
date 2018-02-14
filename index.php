<?php
// Include the PDO connection file for the MySQL database
require_once('includes/connection.php');
require_once('includes/functions.php');

// Check if the controller and action parameters are set
if (isset($_GET['controller']) && isset($_GET['action'])) {
    // Get the specified controller and action
    $controller = $_GET['controller'];
    $action = $_GET['action'];
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
} else {
    $pageTitle = formatPageTitle($action);
}

// Get the contents of the page
$buffer = ob_get_contents();
ob_end_clean();
// Replace %TITLE% in the header.php file with the title of the action
$buffer = str_replace("%TITLE%", $pageTitle, $buffer);

// Replace the page header text depending on what page we are on
if ($pageTitle == 'Home') {
    $pageTitle = 'Welcome to Whitehill Motors';
}
// Replace the banner text
$buffer = str_replace("%BANNERTEXT%", $pageTitle, $buffer);

// Display the page with the replaced title
echo $buffer;
