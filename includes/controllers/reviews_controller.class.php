<?php
    class ReviewsController {
        public function index() {
            $list = Review::getAllApproved();
            $average = Review::getAverageRating();
            require_once('includes/views/reviews/index.php');
        }

        public function single() {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $reviewId = htmlentities($_GET['id']);
                $review = Review::findReviewById($reviewId);

                if ($review->customerName == '') {
                    call('pages', 'error');
                } else {
                    require_once('includes/views/reviews/single.php');
                }

            } else {
                call('pages', 'error');
            }
        }

        public function add() {
            require_once('includes/views/reviews/add.php');
        }
    }
?>
