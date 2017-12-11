<?php
if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $username = $_SESSION['login'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!Employee::verifyPassword($username, $oldPassword)) {
        $errors[] = "Old password is not correct.";
    } else {
        Employee::updatePassword($username, $newPassword);

        $success[] = "Password changed successfully!";
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

    <form method="post" action="" id="form" onsubmit="return validateForm()">
        Old Password: <input type="password" name="oldPassword" autofocus required />
        New Password: <input type="password" name="newPassword" required />
        Confirm Password: <input type="password" name="confirmPassword" required />
        <input type="submit" value="Change Password" />
    </form>
</div>

<script>
    function validateForm() {
        var newPassword = document.forms["form"]["newPassword"].value;
        var confirmPassword = document.forms["form"]["confirmPassword"].value;

        if (newPassword != confirmPassword) {
            alert("Entered passwords do not match!")
            return false;
        }
        if (newPassword.length < 6) {
            alert("Password must be at least 6 characters!");
            return false;
        }

    }
</script>
