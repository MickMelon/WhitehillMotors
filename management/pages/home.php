<?php
$list = Car::all();
?>

<div class="container">
    <table>
        <tr><th>#</th><th>Registration</th><th>Manufacturer</th><th>Model</th><th></th><th></th><th></th></tr>
        <?php for ($i = 0; $i < sizeof($list); $i++) { ?>
            <tr><td><?= ($i+1); ?></td>
                <td><?= $list[$i]->registration; ?></td>
                <td><?= $list[$i]->manufacturer; ?></td>
                <td><?= $list[$i]->model; ?></td>
                <td><a href="index.php?action=mark_as_sold">Mark As Sold</a></td>
                <td><a href="index.php?action=update">Update</a></td>
                <td><a href="index.php?action=delete">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>
