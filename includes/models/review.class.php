<?php
class Review {
    public $reviewId;
    public $customerName;
    public $reviewText;
    public $rating;
    public $employeeId;
    public $approved;
    public $dateReviewed;

    public function __construct($reviewId, $customerName, $reviewText, $rating, $employeeId, $approved, $dateReviewed) {
        $this->reviewId = $reviewId;
        $this->customerName = $customerName;
        $this->reviewText = $reviewText;
        $this->rating = $rating;
        $this->employeeId = $employeeId;
        $this->approved = $approved;
        $this->dateReviewed = $dateReviewed;
    }

    public static function all() {
        $list = [];

        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM review');
        $query->execute();

        foreach ($query->fetchAll() as $review) {
            $list[] = new Review(
                $review['ReviewID'],
                $review['CustomerName'],
                $review['ReviewText'],
                $review['Rating'],
                $review['EmployeeID'],
                $review['Approved'],
                $review['DateReviewed']);
        }
        return $list;
    }

    public static function findReviewById($reviewId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM review WHERE ReviewID = :reviewId LIMIT 1');
        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $query->execute();

        $review = $query->fetch();

        return new Review(
            $review['ReviewID'],
            $review['CustomerName'],
            $review['ReviewText'],
            $review['Rating'],
            $review['EmployeeID'],
            $review['Approved'],
            $review['DateReviewed']);
    }

    public static function setApproved($reviewId, $approved, $employeeId) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE review SET
            Approved = :approved,
            EmployeeID = :employeeId
            WHERE ReviewID = :reviewId');

        $query->bindParam(':approved', $approved, PDO::PARAM_INT);
        $query->bindParam('employeeId', $employeeId, PDO::PARAM_INT);
        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);

        $query->execute();
    }

    public static function getAllApproved() {
        $list = [];

        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM review WHERE Approved = 1');
        $query->execute();

        foreach ($query->fetchAll() as $review) {
            $list[] = new Review(
                $review['ReviewID'],
                $review['CustomerName'],
                $review['ReviewText'],
                $review['Rating'],
                $review['EmployeeID'],
                $review['Approved'],
                $review['DateReviewed']);
        }
        return $list;
    }

    public static function getAllNotApproved() {
        $list = [];
        
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM review WHERE Approved = 0');
        $query->execute();

        foreach ($query->fetchAll() as $review) {
            $list[] = new Review(
                $review['ReviewID'],
                $review['CustomerName'],
                $review['ReviewText'],
                $review['Rating'],
                $review['EmployeeID'],
                $review['Approved'],
                $review['DateReviewed']);
        }
        return $list;
    }

    public static function getAverageRating() {
        $list = Review::all();
        $sum = 0;
        $total = sizeof($list);

        foreach ($list as $review) {
            $sum += $review->rating;
        }

        return $sum / $total;
    }

    public static function insert($customerName, $reviewText, $rating, $employeeId, $approved) {
        $date = date('Y-m-d');

        $db = Db::getInstance();

        $query = $db->prepare('INSERT INTO review (
                CustomerName,
                ReviewText,
                Rating,
                EmployeeID,
                Approved,
                DateReviewed)
            VALUES (
                :customerName,
                :reviewText,
                :rating,
                :employeeId,
                :approved,
                :dateReviewed)');

        $query->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $query->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
        $query->bindParam(':approved', $approved, PDO::PARAM_INT);
        $query->bindParam(':dateReviewed', $date, PDO::PARAM_STR);

        $query->execute();
    }

    public static function update($reviewId, $customerName, $reviewText, $rating, $employeeId, $approved) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE review SET
                CustomerName = :customerName,
                ReviewText = :reviewText,
                Rating = :rating,
                EmployeeID = :employeeID,
                Approved = :approved
                WHERE ReviewID = :reviewId');

        $query->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $query->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
        $query->bindParam(':approved', $approved, PDO::PARAM_INT);
        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);

        $query->execute();
    }

    public static function delete($reviewId) {
        $db = Db::getInstance();

        $query = $db->prepare('DELETE FROM review WHERE ReviewID = :reviewId');
        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);

        $query->execute();
    }
}
