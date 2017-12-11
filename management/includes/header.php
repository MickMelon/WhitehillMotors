<!DOCTYPE html>
<html>
    <head>
        <title>WM Management: <?= formatPageTitle($page); ?></title>

        <link rel="stylesheet" type="text/css" href="../css/management.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    </head>
    <body>
        <header>
            <div class="container">
                <h1>Management: <?= formatPageTitle($page); ?></h1>
                <p>Hello, <?= $_SESSION['login']; ?>! You logged in at <?= $_COOKIE['date']; ?></p>
                <ul>
                    <li><a href="index.php?page=home">Home</a></li>
                    <li><a href="index.php?page=add_vehicle">Add Vehicle</a></li>
                    <li><a href="index.php?page=change_password">Change Password</a></li>
                    <?php if (Employee::isManager()) echo '<li><a href="index.php?page=add_employee">Add Employee</a></li>'; ?>
                    <li><a href="login.php?action=logout">Logout</a></li>
                </ul>
            </div>
        </header>
