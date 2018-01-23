<?php
if (!isset($errorMessage)) {
    $errorMessage = 'There has been an error. Please contact the system administrator.';
}
?>

<section class="error">
    <h1>Error</h1>
    <p><?= $errorMessage; ?></p>
    <p><a href="home">Click here to return to the home page</a></p>
</section>
