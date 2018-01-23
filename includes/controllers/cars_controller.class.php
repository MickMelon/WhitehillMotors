<?php
    class CarsController {
        public function index() {
            $list = Car::all();
            require_once('includes/views/cars/index.php');
        }

        public function single() {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $vehicleId = htmlentities($_GET['id']);
                $car = Car::findByVehicleId($vehicleId);

                if ($car->model == '') {
                    $errorMessage = 'Cannot find a vehicle for the specified ID.';
                    require_once('includes/views/pages/error.php');
                } else {
                    if (file_exists('img/cars/' . $car->registration . '.jpg')) {
                        $image = $car->registration . '.jpg';
                    } else if (file_exists('img/cars/' . $car->registration . '.png')) {
                        $image = $car->registration . '.png';
                    } else if (file_exists('img/cars/' . $car->registration . '.jpeg')) {
                        $image = $car->registration . '.jpeg';
                    } else {
                        $image = 'not_found.png';
                    }
                    require_once('includes/views/cars/single.php');
                }
            } else {
                call('pages', 'error');
            }
        }
    }
?>
