test: normal traffic (200 peeps) might be more at app time
normal, extreme, exceptional. Test everything here.
user and component tests. just do good tests not loads of shit ones

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
    public $sold;

    public function __construct($vehicleId, $model, $manufacturer, $engine, $year, $registration,
    $mileage, $fuelType, $condition, $features, $description, $price, $sold) {
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
        $this->sold = $sold;
    }

    public static function all() {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM vehicle');
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
                $car['Price'],
                $car['Sold']);
        }
        return $list;
    }

    // The parameters are passed by reference so that the calling method can
    // use the modified values
    public static function allPage(&$page, &$total, &$startRow, $showMax) {
        $db = Db::getInstance();
        $total = Car::count();

        $startRow = $page * $showMax;

        if ($startRow > $total) {
            $startRow = 0;
            $page = 0;
        }

        $query = $db->prepare('SELECT * FROM vehicle LIMIT :startRow, :showMax');
        $query->bindParam(':startRow', $startRow, PDO::PARAM_INT);
        $query->bindParam(':showMax', $showMax, PDO::PARAM_INT);
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
                $car['Price'],
                $car['Sold']);
        }
        return $list;
    }

    public static function allFilter(&$page, &$total, &$startRow, $showMax, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
     $fuelType, $condition, $minPrice, $maxPrice) {
         // Get the database instance from the singleton class
         $db = Db::getInstance();

         // Initialize arrays
         $list = [];
         $params = [];

         // Build the SQL query depending on what values have been set
         // $params is passed as reference so we can use the modified data in this function
         $sql = Car::buildFilterSqlQuery($params, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
         $fuelType, $condition, $minPrice, $maxPrice);

         // Check if there are any WHERE conditions to be used
         if ($sql == '') {
             $total = Car::count();

             // Set the SQL string used later
             $sql = 'SELECT * FROM vehicle';
         } else {
             $total = Car::countFilter($sql, $params, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
             $fuelType, $condition, $minPrice, $maxPrice);

             // Set the SQL string used later
             $sql = 'SELECT * FROM vehicle WHERE ' . $sql;
         }

         // Determine the subset of data we are going to retrieve
         $startRow = $page * $showMax;
         if ($startRow > $total) {
             $startRow = 0;
             $page = 0;
         }

         // Add the subset to the query
         $sql .= ' LIMIT :startRow, :showMax';

         // Loop through all the params and bind it to the query
         $query = $db->prepare($sql);
         foreach ($params as $param) {
             $query->bindParam(':' . $param, ${ $param }, PDO::PARAM_STR);
         }

         // Now add the parameters that will always be there
         $query->bindParam(':startRow', $startRow, PDO::PARAM_INT);
         $query->bindParam(':showMax', $showMax, PDO::PARAM_INT);

         // Finally execute the query
         $query->execute();

         // Store all the results in an array and return the array
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
                 $car['Price'],
                 $car['Sold']);
         }

         return $list;
     }

    public static function buildFilterSqlQuery(&$params, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
     $fuelType, $condition, $minPrice, $maxPrice) {
        // Initialize sql query string
        $params = [];
        $sql = '';

        // It is going to check every variable and see if a WHERE condition for it
        // needs to be added to the sql query. It does this if the variable does
        // not hold the default value (any or 0)

        // Check if 'any' model was chosen
        if ($manufacturerId != 'any') {
            if ($modelId == 'any') {
                // Search just by manufacturer
                $sql = 'ModelId IN (SELECT model.modelid FROM vehicle, model, manufacturer WHERE ' .
                        'vehicle.modelid = model.modelid AND model.manufacturerid = manufacturer.manufacturerid ' .
                        'AND manufacturer.manufacturerid = :manufacturerId)';
                $params[] = 'manufacturerId';
            } else {
                // Search by model
                $sql .= 'ModelId = :modelId';
                $params[] = 'modelId';
            }
        }
        // Check if 'any' fueltype was chosen
        if ($fuelType != 'any') {
            Car::addAndToQuery($sql, $params);

            // Add the condition to the sql string and add to param
            $sql .= 'FuelType = :fuelType';
            $params[] = 'fuelType';
        }
        // Check if 'any' condition was chosen
        if ($condition != 'any') {
            Car::addAndToQuery($sql, $params);

            $sql .= '`Condition` = :condition';
            $params[] = 'condition';
        }
        // Check if maximum age has been set
        if ($maxAge != 0) {
            Car::addAndToQuery($sql, $params);

            $sql .= '(CURRENT_DATE() - Year) < :maxAge';
            $params[] = 'maxAge';
        }
        // Check if maximum mileage has been set
        if ($maxMileage > 0) {
            Car::addAndToQuery($sql, $params);

            $sql .= 'Mileage BETWEEN :minMileage AND :maxMileage';
            $params[] = 'minMileage';
            $params[] = 'maxMileage';
        // If maximum mileage hasn't been set, check if there is a min mileage
        } else if ($minMileage > 0) {
            Car::addAndToQuery($sql, $params);

            $sql .= 'Mileage > :minMileage';
            $params[] = 'minMileage';
        }
        // Check if maximum price has been set
        if ($maxPrice > 0) {
            Car::addAndToQuery($sql, $params);

            $sql .= 'Price BETWEEN :minPrice AND :maxPrice';
            $params[] = 'minPrice';
            $params[] = 'maxPrice';
        // If maximum price hasn't been set, check if there is a min price
        } else if ($minPrice > 0) {
            Car::addAndToQuery($sql, $params);

            $sql .= 'Price > :minPrice';
            $params[] = 'minPrice';
        }

        // Finally return the completed sql string
        return $sql;
    }

    public static function addAndToQuery(&$sql, &$params) {
        // Check to see if AND needs to be added to the query. If the params
        // is not empty then it means there was at least one WHERE beforehand so
        // AND needs to be added.
        if (sizeof($params) > 0) {
            $sql .= ' AND ';
        }
    }

    public static function findByVehicleId($vehicleId) {
        $db = Db::getInstance();

        // Get main vehicle details
        $query = $db->prepare('SELECT * FROM vehicle WHERE VehicleID = :vehicleId LIMIT 1');
        $query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $query->execute();

        $car = $query->fetch();

        return new Car(
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
            $car['Price'],
            $car['Sold']);
    }

    public static function findByReg($reg) {
        $db = Db::getInstance();

        // Get main vehicle details
        $query = $db->prepare('SELECT * FROM vehicle WHERE Registration = :reg LIMIT 1');
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
            $car['Price'],
            $car['Sold']);
    }

    public static function insert($modelId, $engine, $year, $registration,
    $mileage, $fuelType, $condition, $features, $description, $price) {
        $db = Db::getInstance();

        $query = $db->prepare('INSERT INTO vehicle (
                ModelID,
                Engine,
                Year,
                Registration,
                Mileage,
                FuelType,
                `Condition`,
                Features,
                Description,
                Price)
            VALUES (
                :modelId,
                :engine,
                :year,
                :registration,
                :mileage,
                :fuelType,
                :condition,
                :features,
                :description,
                :price)');

        $query->bindParam(':modelId', $modelId, PDO::PARAM_INT);
        $query->bindParam(':engine', $engine, PDO::PARAM_STR);
        $query->bindParam(':year', $year, PDO::PARAM_INT);
        $query->bindParam(':registration', $registration, PDO::PARAM_STR);
        $query->bindParam(':mileage', $mileage, PDO::PARAM_INT);
        $query->bindParam(':fuelType', $fuelType, PDO::PARAM_STR);
        $query->bindParam(':condition', $condition, PDO::PARAM_STR);
        $query->bindParam(':features', $features, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);

        $query->execute();
    }

    public static function update($vehicleId, $engine, $year, $registration,
    $mileage, $fuelType, $features, $description, $price, $sold) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE vehicle SET
                Engine = :engine,
                Year = :year,
                Registration = :registration,
                Mileage = :mileage,
                FuelType = :fuelType,
                Features = :features,
                Description = :description,
                Price = :price,
                Sold = :sold
                WHERE VehicleID = :vehicleId');

        $query->bindParam(':engine', $engine, PDO::PARAM_STR);
        $query->bindParam(':year', $year, PDO::PARAM_INT);
        $query->bindParam(':registration', $registration, PDO::PARAM_STR);
        $query->bindParam(':mileage', $mileage, PDO::PARAM_INT);
        $query->bindParam(':fuelType', $fuelType, PDO::PARAM_STR);
        $query->bindParam(':features', $features, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $query->bindParam(':sold', $sold, PDO::PARAM_INT);

        $query->execute();
    }

    public static function delete($vehicleId) {
        $db = Db::getInstance();

        $query = $db->prepare('DELETE FROM vehicle WHERE VehicleID = :vehicleId');
        $query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);

        $query->execute();
    }

    public static function getAllManufacturers() {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM manufacturer');
        $query->execute();

        $manufacturers = $query->fetchAll();

        return $manufacturers;
    }

    public static function getAllModelsForManufacturer($manufacturerId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM model WHERE ManufacturerID = :manufacturerId');
        $query->bindParam(':manufacturerId', $manufacturerId, PDO::PARAM_INT);
        $query->execute();

        $models = $query->fetchAll();

        return $models;
    }

    public static function getManufacturerName($manufacturerId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT Name FROM manufacturer WHERE ManufacturerID = :manufacturerId LIMIT 1');
        $query->bindParam(':manufacturerId', $manufacturerId, PDO::PARAM_INT);
        $query->execute();

        $manufacturer = $query->fetch();

        return $manufacturer['Name'];
    }

    public static function getModelName($modelId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT Name FROM model WHERE ModelID = :modelId LIMIT 1');
        $query->bindParam(':modelId', $modelId, PDO::PARAM_INT);
        $query->execute();

        $model = $query->fetch();

        return $model['Name'];
    }

    public static function getManufacturerId($modelId) {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT ManufacturerID FROM model WHERE ModelID = :modelId LIMIT 1');
        $query->bindParam(':modelId', $modelId, PDO::PARAM_INT);
        $query->execute();

        $model = $query->fetch();

        return $model['ManufacturerID'];
    }

    public static function markAsSold($vehicleId) {
        $db = Db::getInstance();

        $query = $db->prepare('UPDATE vehicle SET Sold = 1 WHERE VehicleID = :vehicleId');
        $query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $query->execute();
    }

    public static function count() {
        $db = Db::getInstance();

        $query = $db->prepare('SELECT * FROM vehicle');
        $query->execute();

        return $query->rowCount();
    }

    public static function countFilter($filterSql, $params, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
    $fuelType, $condition, $minPrice, $maxPrice) {
        $db = Db::getInstance();
        $filterSql = 'SELECT * FROM vehicle WHERE ' . $filterSql;

        $query = $db->prepare($filterSql);
        foreach ($params as $param) {
            $query->bindParam(':' . $param, ${ $param }, PDO::PARAM_STR);
        }

        $query->execute();

        return $query->rowCount();

    }
}
