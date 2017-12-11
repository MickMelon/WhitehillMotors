<?php
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $employee = Employee::find($username);

    if ($employee->username != '') {
        $errors[] = 'An employee with this username already exists!';
    } else {
        Employee::insert($username, $password);
        $success[] = $username . " was successfully added!";
    }
}
?>

<div class="container">
    <?php if (isset($errors)) {
        foreach ($errors as $error) { ?>
            <p><?= $error; ?></p>
    <?php }
    } else if (isset($success)) { ?>
        <p><?= $success[0]; ?></p>
    <?php } ?>
    <form method="post" action="index.php?page=add_employee" onsubmit="return validateForm()" id="form">
        Username: <input type="text" name="username" autofocus required />
        Password: <input type="password" name="password" required />
        Confirm Password: <input type="password" name="confirmPassword" required />
        <input type="submit" value="Add Employee" />
    </form>
</div>

<script>
    function validateForm() {
        var username = document.forms["form"]["username"].value;
        var password = document.forms["form"]["password"].value;
        var confirmPassword = document.forms["form"]["confirmPassword"].value;

        if (username.length < 3 || username.length > 24) {
            alert("Username must be between 3 and 24 characters!");
            return false;
        }
        if (password != confirmPassword) {
            alert("Entered passwords do not match!")
            return false;
        }
        if (password.length < 6) {
            alert("Password must be at least 6 characters!");
            return false;
        }

    }
</script>
