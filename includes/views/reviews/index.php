<main>
    <section>
        <a href="/whitehillmotors/reviews/add">Add Review</a>
        <div class="text">
            <?php foreach ($list as $review) { ?>
                <h1><?= $review->customerName; ?></h1>
                <p style="font-weight: bold;"><?= $review->dateReviewed; ?> - <?=$review->rating; ?>/5</p>
                <p><?= $review->reviewText;?></p>
            <?php } ?>
        </div>

        <div class="image">

            <img src="http://www.blueworx.com/wp-content/uploads/2017/11/happy-customer-png-5.jpg" style="height: 250px;"/>
        </div>
    </section>
</main>
