<?php
// Include the PDO connection file for the MySQL database
require_once('../includes/connection.php');
// Include the functions file
require_once('../includes/functions.php');
// Include the employee file_exists
require_once('../includes/models/employee.class.php');
// Start the php session
session_start();

if (Employee::isLoggedIn()) {
    header("Location: index.php?page=home");
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'login') {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            if (Employee::tryLogin($_POST['username'], $_POST['password'])) {
                header("Location: index.php?page=home");
            } else {
                // Incorrect username or password
                $errors[] = 'Incorrect username or password!';
            }
        }
    } else if ($_GET['action'] == 'logout') {
        Employee::logout();
    }
}
?>

<div class="container">
    <?php if (isset($errors)) {
            foreach ($errors as $error) { ?>
                <p><?= $error; ?></p>
    <?php }
    } ?>
    <form method="post" action="login.php?action=login">
        Username: <input type="text" name="username" autofocus required />
        Password: <input type="password" name="password" required />
        <input type="submit" value="Login" />
    </form>
    <p>If you have forgotten your password, please speak to your manager to
        have this reset.</p>
</div>
