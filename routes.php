<?php
// List of controllers and their actions
$controllers = array('pages' => ['home', 'error', 'contact', 'about', 'services'],
                     'cars' => ['index', 'single', 'page'],
                     'reviews' => ['index', 'single', 'add']);

// Check that the requested controller anda ction are allowed
if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('pages', 'error');
        echo $controller;
        echo $action;
    }
} else {
    call('pages', 'error');
}

// Instantiate the specified controller and carry out the specified action
// on the controller
function call($controller, $action) {
    // Require the file that matches the controller name
    require_once('includes/controllers/' . $controller . '_controller.class.php');

    // Create a new instance of the needed controller
    switch ($controller) {
        case 'pages':
            $controller = new PagesController();
            break;
        case 'cars':
            require_once('includes/models/car.class.php');
            $controller = new CarsController();
            break;
        case 'reviews':
            require_once('includes/models/review.class.php');
            $controller = new ReviewsController();
            break;
    }

    // Call the action
    $controller->{ $action }();
}
?>
