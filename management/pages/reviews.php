<?php
if (isset($_GET['action']) && isset($_GET['id'])) {
    if ($_GET['action'] == 'approve') {
        Review::setApproved(htmlentities($_GET['id']), true);
    } else if ($_GET['action'] == 'delete') {
        Review::delete(htmlentities($_GET['id']));
    }
}

$list = Review::all();
?>

<div class="container">
    Show:
    <select name="approvedSelect" id="approvedSelect">
        <option value="all">All</option>
        <option value="notApproved">Not Approved</option>
        <option value="approved">Approved</option>
    </select>
    <table>
        <tr><th>#</th><th>Name</th><th>Text</th><th>Rating</th><th>Date</th><th>Approved</th><th>Approve</th><th>Delete</th></tr>
        <?php for ($i = 0; $i < sizeof($list); $i++) { ?>
            <tr><td><?= ($i+1); ?></td>
                <td><?= $list[$i]->customerName; ?></td>
                <td><?= $list[$i]->reviewText; ?></td>
                <td><?= $list[$i]->rating; ?></td>
                <td><?= $list[$i]->dateReviewed; ?></td>
                <td><?= $list[$i]->approved; ?></td>
                <td><a href="index.php?page=reviews&action=approve&id=<?= $list[$i]->reviewId; ?>">Approve</a></td>
                <td><a href="index.php?page=reviews&action=delete&id=<?= $list[$i]->reviewId; ?>" onclick="return confirmDelete()">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<script>
    approvedSelect.onChange = function() {
        let value = approvedSelect.getValue();
    };

    function confirmDelete() {
        return confirm("Are you sure you want to delete this review?");
    }
</script>
