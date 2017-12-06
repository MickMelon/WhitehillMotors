<?php
class Car {
    public $vehicleId;
    public $model;
    public $manufacturer;
    public $engine;
    public $year;
    public $registration;
    public $mileage;
    public $fuelType;
    public $condition;
    public $features;
    public $description;
    public $price;

    public function __construct($vehicleId, $model, $manufacturer, $engine, $year, $registration,
    $mileage, $fuelType, $condition, $features, $description, $price) {
        $this->vehicleId = $vehicleId;
        $this->model = $model;
        $this->manufacturer = $manufacturer;
        $this->engine = $engine;
        $this->year = $year;
        $this->registration = $registration;
        $this->mileage = $mileage;
        $this->fuelType = $fuelType;
        $this->condition = $condition;
        $this->features = $features;
        $this->description = $description;
        $this->price = $price;
    }

    public static function all() {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM `vehicle`');
        $query->execute();

        foreach ($query->fetchAll() as $car) {
            $list[] = new Car(
                $car['VehicleID'],
                Car::getModelName($car['ModelID']),
                Car::getManufacturerName(Car::getManufacturerId($car['ModelID'])),
                $car['Engine'],
                $car['Year'],
                $car['Registration'],
                $car['Mileage'],
                $car['FuelType'],
                $car['Condition'],
                $car['Features'],
                $car['Description'],
                $car['Price']);
        }
echo "test";
        return $list;
    }

    public static function find($reg) {
        $db = Db::getInstance();

        // Get main vehicle details
        $query = $db->prepare('SELECT * FROM `vehicle` WHERE `Registration` = `:reg` LIMIT 1');
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->execute();

        $car = $query->fetch();

        return new Car(
            $car['VehicleID'],
            Car::getModelName($car['ModelID']),
            Car::getManufacturerName(getManufacturerId($car['ModelID'])),
            $car['Engine'],
            $car['Year'],
            $car['Registration'],
            $car['Mileage'],
            $car['FuelType'],
            $car['Condition'],
            $car['Features'],
            $car['Description'],
            $car['Price']);
    }

    public static function insert($modelId, $engine, $year, $registration,
    $mileage, $fuelType, $condition, $features, $description, $price) {
        $db = Db::getInstance();

        $query = $db->prepare('INSERT INTO `vehicle` (
                `ModelID`,
                `Engine`,
                `Year`,
                `Registration`,
                `Mileage`,
                `FuelType`,
                `Condition`,
                `Features`,
                `Description`,
                `Price`
            )
            VALUES (
                `:modelId`,
                `:engine`,
                `:year`,
                `:registration`,
                `:mileage`,
                `:fuelType`,
                `:condition`,
                `:features`,
                `:description`,
                `:price`
            )');

        $query->bindParam(':modelId', $modelId, PDO::PARAM_INT);
        $query->bindParam(':engine', $engine, PDO::PARAM_FLOAT);
        $query->bindParam(':year', $year, PDO::PARAM_INT);
        $query->bindParam(':registration', $registration, PDO::PARAM_STR);
        $query->bindParam(':mileage', $mileage, PDO::PARAM_INT);

        $query->bindParam(':fuelType', $fuelType, PDO::PARAM_STR);
        $query->bindParam(':condition', $condition, PDO::PARAM_STR);
        $query->bindParam(':features', $features, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_FLOAT);

        $query->execute();
    }

    public static function getManufacturerName($manufacturerId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT `Name` FROM `manufacturer` WHERE `ManufacturerID` = :manufacturerId LIMIT 1');
        $query->bindParam(':manufacturerId', $manufacturerId, PDO::PARAM_INT);
        $query->execute();

        $manufacturer = $query->fetch();

        return $manufacturer['Name'];
    }

    public static function getModelName($modelId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT `Name` FROM `model` WHERE `ModelID` = :modelId LIMIT 1');
        $query->bindParam(':modelId', $modelId, PDO::PARAM_INT);
        $query->execute();

        $model = $query->fetch();

        return $model['Name'];
    }

    public static function getManufacturerId($modelId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT `ManufacturerID` FROM `model` WHERE `ModelID` = :modelId LIMIT 1');
        $query->bindParam(':modelId', $modelId, PDO::PARAM_INT);
        $query->execute();

        $model = $query->fetch();

        return $model['ManufacturerID'];
    }
}
