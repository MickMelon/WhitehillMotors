<?php
// Include the PDO connection file for the MySQL database
require_once('../includes/connection.php');
// Include the functions file
require_once('../includes/functions.php');

// Get the current page that is set in the GET parameter
// ie. index.php?page=about
$page = getPage();

// Include the model classes
require_once('../includes/models/car.class.php');
require_once('../includes/models/employee.class.php');

// Include the header file
require_once('includes/header.php');

// Include the page specified above
require_once('pages/' . $page . '.php');

// Include the footer file
require_once('includes/footer.php');
