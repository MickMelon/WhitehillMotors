<?php
    class ReviewsController {
        public function index() {
            // Get all the approved reviews and get the average rating
            $list = Review::getAllApproved();
            $average = Review::getAverageRating();

            // Display the page
            require_once('includes/views/reviews/index.php');
        }

        public function add() {
            // Display the add page
            require_once('includes/views/reviews/add.php');
        }
    }
?>
