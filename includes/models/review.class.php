<?php
class Review {
    public $reviewId;
    public $customerName;
    public $reviewText;
    public $rating;
    public $employeeId;
    public $approved;

    public function __construct($reviewId, $customerName, $reviewText, $rating, $employeeId, $approved) {
        $this->reviewId = $reviewId;
        $this->customerName = $customerName;
        $this->reviewText = $reviewText;
        $this->rating = $rating;
        $this->employeeId = $employeeId;
        $this->approved = $approved;
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
                $review['EmployeeID'],
                $review['Approved']);
        }
        return $list;
    }

    public static function findReviewById($reviewId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM review WHERE ReviewID = :reviewId LIMIT 1');
        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $query->execute();

        $car = $query->fetch();

        return new Review(
            $review['ReviewID'],
            $review['CustomerName'],
            $review['ReviewText'],
            $review['Rating'],
            $review['EmployeeID'],
            $review['Approved']);
    }

    public static function setApproved($reviewId, $approved) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE Review SET
            Approved = :approved
            WHERE ReviewID = :reviewId');

        $query->bindParam(':approved', $approved, PDO::PARAM_INT);
        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);

        $query->execute();
    }

    public static function insert($reviewId, $customerName, $reviewText, $rating, $employeeId, $reviewed) {
        $db = Db::getInstance();

        $query = $db->prepare('INSERT INTO review (
                ReviewID,
                CustomerName,
                ReviewText,
                Rating,
                EmployeeID,
                Approved)
            VALUES (
                :reviewId,
                :customerName,
                :reviewText,
                :rating,
                :employeeId,
                :approved)');

        $query->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $query->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $query->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
        $query->bindParam(':approved', approved, PDO::PARAM_INT);

        $query->execute();
    }

    public static function update($reviewId, $customerName, $reviewText, $rating, $employeeId, $approved) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE vehicle SET
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
