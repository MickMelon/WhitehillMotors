<?php
if ($error) {
    if ($error = 'page-not-found') {
        $errorMessage = "Oh no! We couldn't find the page that you were looking for!";
    } else {
        $errorMessage = 'There has been an error. Please contact the system administrator.';
    }
} else {
    $errorMessage = 'There has been an error. Please contact the system administrator.';
}
?>

<section class="error">
    <h1>Error</h1>
    <p><?= $errorMessage; ?></p>
    <p><a href="index.php">Click here to return to the home page</a></p>
</section>
