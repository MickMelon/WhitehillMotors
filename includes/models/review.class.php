<?php
class Review {
    public $reviewId;
    public $customerName;
    public $reviewText;
    public $rating;
    public $employeeId;

    public function __construct($reviewId, $customerName, $reviewText, $rating, $employeeId) {
        $this->reviewId = $reviewId;
        $this->customerName = $customerName;
        $this->reviewText = $reviewText;
        $this->rating = $rating;
        $this->employeeId = $employeeId;
    }

    public static function all() {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM review');
        $query->execute();

        foreach ($query->fetchAll() as $review) {
            $list[] = new Review(
                $review['ReviewID'],
                $review['CustomerName'],
                $review['ReviewText'],
                $review['Rating'],
                $review['EmployeeID']);
        }
        return $list;
    }

    public static function findReviewById($reviewId) {
        $db = Db::getInstance();

        // Get main vehicle details
        $query = $db->prepare('SELECT * FROM review WHERE ReviewID = :reviewId LIMIT 1');
        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $query->execute();

        $car = $query->fetch();

        return new Review(
            $review['ReviewID'],
            $review['CustomerName'],
            $review['ReviewText'],
            $review['Rating'],
            $review['EmployeeID']);
    }

    public static function insert($reviewId, $customerName, $reviewText, $rating, $employeeId) {
        $db = Db::getInstance();

        $query = $db->prepare('INSERT INTO review (
                ReviewID,
                CustomerName,
                ReviewText,
                Rating,
                EmployeeID)
            VALUES (
                :reviewId,
                :customerName,
                :reviewText,
                :rating,
                :employeeId)');

        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $query->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $query->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);

        $query->execute();
    }

    public static function update($reviewId, $customerName, $reviewText, $rating, $employeeId) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE vehicle SET
                CustomerName = :customerName,
                ReviewText = :reviewText,
                Rating = :rating,
                EmployeeID = :employeeID
                WHERE ReviewID = :reviewId');

        $query->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $query->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
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
