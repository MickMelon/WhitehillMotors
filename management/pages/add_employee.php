<?php
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    Employee::insert($username, $password);

    $success = $username . " was successfully added!";
}
?>

<div class="container">
    <?php if (isset($errors)) {
        foreach ($errors as $error) { ?>
            <p><?= $error; ?></p>
    <?php }
    } else if (isset($success)) { ?>
        <p><?= $success; ?></p>
    <?php } ?>
    <form method="post" action="index.php?page=add_employee">
        Username: <input type="text" name="username" autofocus required />
        Password: <input type="password" name="password" required />
        Confirm Password: <input type="password" name="confirmPassword" required />
        <input type="submit" value="Add Employee" />
    </form>
</div>
