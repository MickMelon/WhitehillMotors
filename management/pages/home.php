<?php
$list = Car::all();
?>

<div class="container">
    <table>
        <tr><th>#</th><th>Registration</th><th>Manufacturer</th><th>Model</th><th></th><th></th></tr>
        <?php for ($i = 0; $i < sizeof($list); $i++) { ?>
            <tr><td><?= ($i+1); ?></td>
                <td><?= $list[$i]->registration; ?></td>
                <td><?= $list[$i]->manufacturer; ?></td>
                <td><?= $list[$i]->model; ?></td>
                <td><a href="index.php?page=update&id=<?= $list[$i]->vehicleId; ?>">Update</a></td>
                <td><a href="index.php?page=update&id=<?= $list[$i]->vehicleId; ?>&action=delete" onclick="return confirmDelete()">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this vehicle?")) {
            return true;
        } else {
            return false;
        }
    }
</script>
