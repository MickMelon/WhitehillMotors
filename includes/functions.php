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

function setPageTitle($pageTitle) {
    /* The code below is going to find %TITLE% on the HTML page and replace it with
    the current page title */

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
}
