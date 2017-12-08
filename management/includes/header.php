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
                <ul>
                    <li><a href="index.php?page=home">Home</a></li>
                    <li><a href="index.php?page=add_vehicle">Add Vehicle</a></li>
                    <li><a href="index.php?page=newsletter">Newsletter</a></li>
                    <li><a href="index.php?page=change_password">Change Password</a></li>
                </ul>
            </div>
        </header>
