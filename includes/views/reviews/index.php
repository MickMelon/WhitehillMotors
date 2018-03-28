<main>
    <section class="small"><h3><i class="fa fa-phone" aria-hidden="true"></i>Call us now on 01307 461234</h3></section>

    <section class="reviews">
        <div class="reviews-description">

            <div class="review-rating-average">
                <p>Average Rating:</p>
                <span class="fa fa-star <?php echo $average >= 1 ? 'checked' : ''?>"></span>
                <span class="fa fa-star <?php echo $average >= 2 ? 'checked' : ''?>"></span>
                <span class="fa fa-star <?php echo $average >= 3 ? 'checked' : ''?>"></span>
                <span class="fa fa-star <?php echo $average >= 4 ? 'checked' : ''?>"></span>
                <span class="fa fa-star <?php echo $average >= 5 ? 'checked' : ''?>"></span>
            </div>

            <p>Here is a list of reviews from our lovely customers. If you would like to share your experience with Whitehill Motors, use the link below to add a review!</p>
            <p><a href="/whitehillmotors/reviews/add">Add Review</a></p>
        </div>

        <?php foreach ($list as $review) { ?>
            <div class="review">
                <div class="review-title">
                    <p><span class="review-name"><?= $review->customerName; ?></span> <span class="review-date"><?= $review->dateReviewed; ?></span></p>
                    <p>
                        <span class="review-rating">
                            <span class="fa fa-star <?php echo $review->rating >= 1 ? 'checked' : ''?>"></span>
                            <span class="fa fa-star <?php echo $review->rating >= 2 ? 'checked' : ''?>"></span>
                            <span class="fa fa-star <?php echo $review->rating >= 3 ? 'checked' : ''?>"></span>
                            <span class="fa fa-star <?php echo $review->rating >= 4 ? 'checked' : ''?>"></span>
                            <span class="fa fa-star <?php echo $review->rating >= 5 ? 'checked' : ''?>"></span>
                        </span>
                    </p>
                </div>
                <div class="review-content">
                    <p><?= $review->reviewText; ?></p>
                </div>
            </div>
        <?php } ?>
    </section>
</main>
