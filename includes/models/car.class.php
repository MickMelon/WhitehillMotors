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
         $db = Db::getInstance();

         $list = [];
         $params = [];

         // $params is passed as reference so we can use the modified data in this function
         $sql = Car::buildFilterSqlQuery($params, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
         $fuelType, $condition, $minPrice, $maxPrice);

         echo '<br>SQL:' . $sql;

         // Decide which count function to use depending on if $sql is empty
         if ($sql == '') {
             $total = Car::count();
         } else {
             $total = Car::countFilter($sql, $params, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
             $fuelType, $condition, $minPrice, $maxPrice);
         }

         // do that shit here
         $startRow = $page * $showMax;

         if ($startRow > $total) {
             $startRow = 0;
             $page = 0;
         }

         // Decide what query to use depending on whether $sql is empty
         if ($sql == '') {
             $sql = 'SELECT * FROM vehicle';
         } else {
             $sql = 'SELECT * FROM vehicle WHERE ' . $sql;
         }

         // Add the subset
         $sql .= ' LIMIT :startRow, :showMax';

         // Loop through all the params and bind it to the query
         $query = $db->prepare($sql);
         foreach ($params as $param) {
             $query->bindParam(':' . $param, ${ $param }, PDO::PARAM_STR); // dont think thisll work lol
         }

         // Now add the parameters that will always be there
         $query->bindParam(':startRow', $startRow, PDO::PARAM_INT);
         $query->bindParam(':showMax', $showMax, PDO::PARAM_INT);

         // Next execute this shit show
         $query->execute();

         // now return whatever monstrosity result we get.... if any
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

        // Check if 'any' model was chosen
        if ($manufacturerId != 'any') {
            if ($modelId == 'any') {
                // Search just by manufacturer
                //$sql .= 'ManufacturerId = :manufacturerId';
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
        if ($fuelType != 'any') {
            if (sizeof($params) > 0) {
                $sql .= ' AND ';
            }

            $sql .= 'FuelType = :fuelType';
            $params[] = 'fuelType';
        }
        if ($condition != 'any') {
            if (sizeof($params) > 0) {
                $sql .= ' AND ';
            }

            $sql .= '`Condition` = :condition';
            $params[] = 'condition';
        }
        if ($maxAge != 0) {
            if (sizeof($params) > 0) {
                $sql .= ' AND ';
            }

            $sql .= '(CURRENT_DATE() - Year) < :maxAge';
            $params[] = 'maxAge';
        }
        if ($maxMileage > 0) {
            if (sizeof($params) > 0) {
                $sql .= ' AND ';
            }

            $sql .= 'Mileage BETWEEN :minMileage AND :maxMileage';
            $params[] = 'minMileage';
            $params[] = 'maxMileage';
        } else if ($minMileage > 0) {
            if (sizeof($params) > 0) {
                $sql .= ' AND ';
            }

            $sql .= 'Mileage > :minMileage';
            $params[] = 'minMileage';
        }
        if ($maxPrice > 0) {
            if (sizeof($params) > 0) {
                $sql .= ' AND ';
            }

            $sql .= 'Price BETWEEN :minPrice AND :maxPrice';
            $params[] = 'minPrice';
            $params[] = 'maxPrice';
        } else if ($minPrice > 0) {
            if (sizeof($params) > 0) {
                $sql .= ' AND ';
            }

            $sql .= 'Price > :minPrice';
            $params[] = 'minPrice';
        }

        echo 'SQL: ' . $sql . '<br />';
        echo 'MaxAge: ' . $maxAge . '<br />';
        echo 'MinPrice: ' . $minPrice . '<br />';
        echo 'MaxPrice: ' . $maxPrice . '<br />';
        echo 'minMileage: ' . $minMileage . '<br />';
        echo 'maxMileage: ' . $maxMileage . '<br />';

        echo 'Model: ' . $modelId . '<br />';
        echo 'FuelType: ' . $fuelType . '<br />';
        echo 'Condition: ' . $condition . '<br />';

        return $sql;
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
