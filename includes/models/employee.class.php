<?php
class Employee {
    public $username;
    public $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public static function find($username) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM employee WHERE Username = :username LIMIT 1');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();

        $employee = $query->fetch();

        return new Employee($employee['Username'], $employee['Password']);
    }

    public static function insert($username, $password) {
        $db = Db::getInstance();

        $query = $db->prepare('INSERT INTO employee (Username, Password)
            VALUES (:username, :password)');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);

        $query->execute();
    }

    public static function updatePassword($username, $password) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE employee SET Password = :password
            WHERE Username = :username LIMIT 1');
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);

        $query->execute();
    }

    public static function tryLogin($username, $password) {
        $employee = Employee::find($username);

        if ($employee->username == '') return false;

        if (!password_verify($password, $employee->password)) return false;

        // Set the session or some shit here
        session_start();
        $_SESSION['login'] = $username;
        header("Location: index.php?page=home");

        return true;
    }

    public static function logout() {
        session_destroy();
        header("Location: index.php?page=login");
    }
}
