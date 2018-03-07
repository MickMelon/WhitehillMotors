<?php
function getPage() {
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

    return $page;
}

function formatPageTitle($pageTitle) {
    // Check if there is an underscore in the action name
    $strPos = strrpos($pageTitle, '_');
    if ($strPos) {
        // If there is, split the string in two parts (leaving the underscore behind).
        // Uppercase the first letter on each part. Then, add a space onto the
        // end of the first string. Then join the two strings together.
        $pieces = explode('_', $pageTitle);
        $pieces[0] = ucfirst($pieces[0]);
        $pieces[1] = ucfirst($pieces[1]);
        $pieces[0] .= ' ';

        $pageTitle = $pieces[0] . $pieces[1];
    }
    else {
        // If there isn't, just uppercase the first letter of $action
        $pageTitle = ucfirst($pageTitle);
    }

    return $pageTitle;
}
