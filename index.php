<?php
// Include the header file
require_once('includes/header.php');

// Check to see if the page parameter has been set
if (isset($_GET['page'])) {
    // Make sure that the requested file actually exists
    if (file_exists('pages/' . $_GET['page'] . '.php')) {
        // If it exists, display the page
        include_once('pages/' . $_GET['page'] . '.php');
    } else {
        // If it doesn't exist, display page not found error
        $error = 'page-not-found';
        include_once('pages/error.php');
    }
} else {
    // If no page has been specified, then just display the home page
    include_once('pages/home.php');
}

// Include the footer file
require_once('includes/footer.php');
?>
