<?php
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
