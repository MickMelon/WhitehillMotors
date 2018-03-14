<?php
$sort = '';

if (isset($_GET['sort'])) {
    $sort = htmlentities($_GET['sort']);

    if ($sort == 'approved') {
        $list = Review::getAllApproved();
    } else if ($sort == 'notapproved') {
        $list = Review::getAllNotApproved();
    }
} else {
    $list = Review::all();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    if ($_GET['action'] == 'approve') {
        Review::setApproved(htmlentities($_GET['id']), true, $_SESSION['employeeId']);
        header("Location: index.php?page=reviews");
    } else if ($_GET['action'] == 'delete') {
        Review::delete(htmlentities($_GET['id']));
        header("Location: index.php?page=reviews");
    }
}
?>

<div class="container">
    Show:
    <select name="approvedSelect" id="approvedSelect">
        <option value="all" <?php echo (!isset($_GET['sort'])) ? 'selected' : ''?>>All</option>
        <option value="notApproved" <?php echo ($sort == 'notapproved') ? 'selected' : ''?>>Not Approved</option>
        <option value="approved" <?php echo ($sort == 'approved') ? 'selected' : ''?>>Approved</option>
    </select>
    <table>
        <tr><th>#</th><th>Name</th><th>Text</th><th>Rating</th><th>Date</th><th>Approved</th><th>By</th><th>Approve</th><th>Delete</th></tr>
        <?php for ($i = 0; $i < sizeof($list); $i++) { ?>
            <tr><td><?= ($i+1); ?></td>
                <td><?= $list[$i]->customerName; ?></td>
                <td><?= $list[$i]->reviewText; ?></td>
                <td><?= $list[$i]->rating; ?></td>
                <td><?= $list[$i]->dateReviewed; ?></td>
                <td><?= ($list[$i]->approved == 0) ? 'No' : 'Yes' ?></td>
                <td><?= $list[$i]->employeeId; ?></td>
                <td><a href="index.php?page=reviews&action=approve&id=<?= $list[$i]->reviewId; ?>">Approve</a></td>
                <td><a href="index.php?page=reviews&action=delete&id=<?= $list[$i]->reviewId; ?>" onclick="return confirmDelete()">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<script>
    document.getElementById("approvedSelect").onchange = function() {onApprovedSelectChange()};

    function onApprovedSelectChange() {
        var x = document.getElementById("approvedSelect");

        if (x.value == "approved") {
            loadUrl("index.php?page=reviews&sort=approved");
        } else if (x.value == "notApproved") {
            loadUrl("index.php?page=reviews&sort=notapproved");
        } else {
            loadUrl("index.php?page=reviews");
        }
    }

    function confirmDelete() {
        return confirm("Are you sure you want to delete this review?");
    }

    function loadUrl(newLocation)
    {
        window.location = newLocation;
        return false;
    }
</script>
