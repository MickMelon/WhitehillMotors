<?php
    class ReviewsController {
        public function index() {
            $list = Review::getAllApproved();
            $average = Review::getAverageRating();
            require_once('includes/views/reviews/index.php');
        }

        public function add() {
            require_once('includes/views/reviews/add.php');
        }
    }
?>
