<?php
// Include the PDO connection file for the MySQL database
require_once('../includes/connection.php');
// Include the functions file
require_once('../includes/functions.php');

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'login') {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            
        }
    } else if ($_POST['action'] == 'logout') {

    }
}
?>

<div class="container">
    <form action="post" action="login.php?action=login">
        Username: <input type="text" name="username" autofocus required />
        Password: <input type="password" name="password" required />
        <input type="submit" value="Login" />
    </form>
    <p>If you have forgotten your password, please speak to your manager to
        have this reset.</p>
</div>
